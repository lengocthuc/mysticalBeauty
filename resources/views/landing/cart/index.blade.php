@extends('layouts.landing')
@section('title')
    Giỏ hàng
@endsection

@section('main')
    <section class="banner banner-secondary" id="top"
             style="background-image: url('{{asset('/img/lipstick_banner_1920x300.jpg')}}');">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Giỏ hàng</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="featured-places">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <form action="{{route('order.index')}}" method="get">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="cartheadflex">
                                    <div>SẢN PHẨM</div>
                                    <div></div>
                                    <div>SỐ LƯỢNG</div>
                                    <div>GIÁ</div>
                                    <div>TỔNG</div>
                                </div>

                                <div class="cartlines">
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($details as $detail)
                                        <div class="cartlines__box-content">
                                            <div class="box-product">
                                                <img class="box-product__img" src="/files/{{$detail->images->first()->name}}" alt="">
                                            </div>

                                            <div class="cart__info">
                                                {{$detail->product->name}}
                                            </div>

                                            <div class="quantity text-center">
                                                <a class="delete-cart" href="#" pid="{{$detail->id}}">xóa</a>
                                                <div class="flexactioncart">
                                                    <div class="numbercontrol dcr">-</div>
                                                    <div class="quantity__number">
                                                        <input class="quantity-number-input" pid="{{$detail->id}}" type="text" value="{{$detail->pivot->quantity}}">
                                                    </div>
                                                    <div class="numbercontrol icr">+</div>
                                                </div>
                                            </div>

                                            <div class="price-cart">
                                                <span>{{number_format($detail->product->price)}} đ</span>
                                                @php
                                                $price = $detail->product->price * $detail->pivot->quantity;
                                                $total += $price;
                                                @endphp
                                            </div>
                                            <div class="price-cart price-product">{{number_format($price)}} đ</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @if($total !=0)
                            <div class="clearfix btn-checkout">
                                <div class="blue-button float-end">
                                    <input type="submit" value="Mua hàng">
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
                <div class="col-lg-4 col-md-5 pull-right">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <em>Tạm tính</em>
                                </div>

                                <div class="col-xs-6 text-right price price-total">
                                    <strong>{{number_format($total)}} đ</strong>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item ">
                            <div class="row">
                                <div class="col-xs-6">
                                    <em>Giảm giá</em>
                                </div>

                                <div class="col-xs-6 text-right price">
                                    <strong>0 đ</strong>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <em>Tổng</em>
                                </div>

                                <div class="col-xs-6 text-right price price-total">
                                    <strong>{{number_format($total)}} đ</strong>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>

    </script>
@endpush
