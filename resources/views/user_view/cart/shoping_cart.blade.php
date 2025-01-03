@extends('user_view.layout.layout')
@section('content')
<html>
<header>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</header>
    <section class="bg0 p-t-120 p-b-140">
        <!-- breadcrumb -->
        <div class="container">
            <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
                <a href="{{route('home')}}" class="stext-109 cl8 hov-cl1 trans-04">
                    Home
                    <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                </a>

                <span class="stext-109 cl4">
                    Shoping Cart
                </span>
            </div>
        </div>
        @php
            $total = 0.00;
            foreach ($items as $item) {
                $total += $item->quantity * $item->product->price;
            }
        @endphp

        <!-- Shoping Cart -->
        <form class="bg0 p-t-75 p-b-85" method="POST" action="{{route('order.store')}}">
        @csrf
            <input type="hidden" name="items" value="{{ json_encode($items) }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                <table class="table-shopping-cart">
                                    <tr class="table_head">
                                        <th class="column-1">Product</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">Price</th>
                                        <th class="column-4">Quantity</th>
                                        <th class="column-5">Total</th>
                                    </tr>
                                    @foreach ($items as $item)
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="{{ asset('upload/products/' . $item->product->multiimage[0]['image_path']) }}" alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">{{$item->product->name}}</td>
                                        <td class="column-3">$ {{$item->product->price}}</td>
                                        <td class="column-4">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0" style="display: flex; justify-content: center; align-items: center;">
                                                    <div
                                                    class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                                    data-id="{{$item->id}}"
                                                    data-action="decrement">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>
                                                <input
                                                    class="mtext-104 cl3 txt-center num-product"
                                                    type="number"
                                                    name="num-product2"
                                                    value="{{$item->quantity}}"
                                                    data-id="{{$item->id}}"
                                                    disabled>
                                                <div
                                                    class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                                    data-id="{{$item->id}}"
                                                    data-action="increment">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>

                                        </td>

                                        <td class="column-5 item_total">$ {{$item->quantity * $item->product->price}}</td>
                                    </tr>
                                    @endforeach

{{--
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="images/item-cart-05.jpg" alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">Lightweight Jacket</td>
                                        <td class="column-3">$ 16.00</td>
                                        <td class="column-4">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <

                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-5">$ 16.00</td>
                                    </tr> --}}
                                </table>
                            </div>

                            <div class="">
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            <h4 class="mtext-109 cl2 p-b-30">
                                Cart Totals
                            </h4>

                            <div class="flex-w flex-t bor12 p-b-13">
                                <div class="size-208">
                                    <span class="stext-110 cl2">
                                        Subtotal:
                                    </span>
                                </div>

                                <div class="size-209">
                                    <span class="mtext-110 cl2 total">
                                        ${{$total}}
                                    </span>
                                </div>
                            </div>

                            <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                                <div class="size-208 w-full-ssm">
                                    <span class="stext-110 cl2">
                                        Shipping:
                                    </span>
                                </div>

                                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                    <p class="stext-111 cl6 p-t-2">
                                        There are no shipping methods available. Please double check your address, or contact us if you need any help.
                                    </p>

                                    <div class="p-t-15">
                                        <span class="stext-112 cl8">
                                            Calculate Shipping
                                        </span>

                                        <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                            <select class="js-select2" name="time">
                                                <option>Select a country...</option>
                                                <option>USA</option>
                                                <option>UK</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>

                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" placeholder="State /  country">
                                        </div>

                                        <div class="bor8 bg0 m-b-22">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Postcode / Zip">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-t p-t-27 p-b-33">
                                <div class="size-208">
                                    <span class="mtext-101 cl2">
                                        Total:
                                    </span>
                                </div>

                                <div class="size-209 p-t-1">
                                    <span class="mtext-110 cl2 total">
                                        ${{$total}}
                                    </span>
                                </div>
                            </div>

                            <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" {{count($items) == 0 ? 'disabled' : ''}}>
                                Proceed to Checkout
                            </button>
                            @if(session('error'))
                                <p style="color: red; text-align: center; margin-top: 15px;">
                                    {{ session('error') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</html>
@endsection

