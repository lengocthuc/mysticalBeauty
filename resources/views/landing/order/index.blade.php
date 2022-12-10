@extends('layouts.landing')
@section('title')
    Mua hàng
@endsection

@section('main')
    <section class="banner banner-secondary" id="top"
             style="background-image: url('{{asset('/img/lipstick_banner_1920x300.jpg')}}');">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Mua hàng</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="featured-places">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="h2">{{session('user')['name']}}</p>
                            <label for="">Địa chỉ nhận hàng (ghi rõ địa chỉ):</label>
                            <input class="form-control" type="text" name="address" value="{{session('user')['address']}}" form="form-order">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <form action="{{route('order.success')}}" id="form-order" method="post">
                        @csrf
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
                                                <div class="flexactioncart">
                                                    <div class="">
                                                        <span>{{$detail->pivot->quantity}}</span>
                                                    </div>
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

                        <div class="clearfix">
                            <div class="blue-button float-end">
                                <input type="submit" value="Đặt hàng">
                            </div>
                        </div>
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
                                    <em>Phí vận chuyển</em>
                                </div>

                                <div class="col-xs-6 text-right price">
                                    <strong>30,000 đ</strong>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <em>Tổng</em>
                                </div>

                                <div class="col-xs-6 text-right price price-total">
                                    <strong>{{number_format($total+30000)}} đ</strong>
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
    @if(session()->has('order-fail'))
        <script>
            $(document).ready(function (){
                Toastify({
                    text: "{{session('order-fail')['message']}}",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "{{session('order-fail')['status']}}"
                }).showToast();
            })
        </script>
    @endif
@endpush
