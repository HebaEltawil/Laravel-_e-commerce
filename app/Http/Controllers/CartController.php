<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\MultiImage;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if(!$user)
        {
            return redirect()->route("login");
        }
        $cart = Cart::where("user_id", $user->id)->first();
        $items = [];
        if ($cart) {
            $items = Item::where("cart_id", $cart->id)->with("product","product.multiimage")->get();
        }
        // $products = [];
        // $total = 0.00;
        // foreach ($items as $item) {
        //     $product = Product::where('id',$item->product_id)->first();
        //     $product->quantity = $item->quantity;
        //     $product->image = MultiImage::where('product_id', $product->id)->first();
        //     $total += $product->price*$item->quantity;
        //     array_push($products, $product);
        // }
        // return view('user_view.cart.shoping_cart', compact('products','total','items'));
        return view('user_view.cart.shoping_cart', compact('items'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    try{
        $user = Auth::user();
        $cart = Cart::where("user_id", $user->id)->first();
        if(!$cart)
        {
            Cart::create(["user_id"=> $user->id]);
            $cart = Cart::where("user_id", $user->id)->first();
        }
        $product_quantity = Product::where("id", $request->productId)->first()->quantity;
        if($product_quantity == 0)
        {
            session()->flash('message',"Product out of stock");
            return Redirect::route('products.show',$request->productId);

        }
        if($product_quantity<$request->quantity)
        {
            session()->flash('message',"Only $product_quantity left in stock");
            return Redirect::route('products.show',$request->productId);
        }
        $item_exist = Item::where('cart_id', $cart->id)
                    ->where('product_id', $request->productId)
                    ->where('difficulty', $request->size)
                    ->first();
        if($item_exist)
        {
            $item_exist->update(['quantity'=> $request->quantity+$item_exist->quantity]);
        }
        else{
            Item::create(['cart_id'=>$cart->id,'product_id'=>$request->productId,'quantity'=>$request->quantity,'difficulty'=>$request->size]);
        }
        return Redirect::route('cart.index');
        }
        catch(Exception $e){
            session()->flash('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $item = Item::find($id);
        $item->update(["quantity"=>$request->quantity]);
        $cart = Cart::where("user_id", $user->id)->first();
        $items = [];
        if ($cart) {
            $items = Item::where("cart_id", $cart->id)->with("product")->get();
        }
        $total = 0.00;
        foreach ($items as $item) {
            $total += $item->product->price*$item->quantity;
        }
        $item_total = $item->quantity * $item->product->price;
        return response()->json([
            'total' => number_format($total, 2),
            'item_total' => number_format( $item_total,2),
            'message' => 'Cart updated successfully'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $item = Item::find($id);
        $item->delete();
        $cart = Cart::where("user_id", $user->id)->first();
        $items = [];
        if ($cart) {
            $items = Item::where("cart_id", $cart->id)->with("product")->get();
        }
        $total = 0.00;
        foreach ($items as $item) {
            $total += $item->product->price*$item->quantity;
        }
        return response()->json([
            'total' => number_format($total, 2),
            'message' => 'Cart updated successfully'
        ]);

    }
}
