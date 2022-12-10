@extends('layouts.landing')

@section('title')
Home page
@endsection
@section('main')
    <section class="banner" id="top" style="background-image: url({{asset('img/banner.png')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Chúng tôi cố gắng mang lại những điều tốt nhất cho bạn</h2>
                        <div class="blue-button">
                            <a href="contact.html">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <main>
        <section class="our-services">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="left-content">
                            <br>
                            <h4>Về chúng tôi</h4>
                            <p>Mystical Beauty Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting<br><br>Mauris sit amet quam congue, pulvinar urna et, congue diam. Suspendisse eu lorem massa. Integer sit amet posuere tellus, id efficitur leo. In hac habitasse platea dictumst. Vel sequi odit similique repudiandae ipsum iste, quidem tenetur id impedit, eaque et, aliquam quod.</p>
                            <div class="blue-button">
                                <a href="about-us.html">Tìm hiểu thêm</a>
                            </div>

                            <br>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <img src="{{asset('img/about.jpg')}}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <span class="h1">Sản Phẩm Nổi Bật</span>
                            <h2>Lorem ipsum dolor sit amet ctetur.</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($featuredProducts as $product)
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="featured-item shadow-sm">
                                <div class="thumb">
                                    <a href="{{route('landing.products.show',$product->id)}}"><img class="thumbnail" src="/files/{{$product->productDetail[0]->images[0]->name}}" alt=""></a>
                                </div>
                                <div class="down-content">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <a href="{{route('landing.products.show',$product->id)}}" class="product-name"><h4>{{$product->name}}</h4></a>

                                            <span><strong>{{$product->price}}<u class="fs-5">đ</u></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <span>Sản Phẩm Mới</span>
                            <h2>Lorem ipsum dolor sit amet ctetur.</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($featuredProducts as $product)
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="featured-item shadow-sm">
                                <div class="thumb">
                                    <a href="{{route('landing.products.show',$product->id)}}"><img class="thumbnail" src="/files/{{$product->productDetail[0]->images[0]->name}}" alt=""></a>
                                </div>
                                <div class="down-content">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <a href="{{route('landing.products.show',$product->id)}}" class="product-name"><h4>{{$product->name}}</h4></a>

                                            <span><strong>{{$product->price}}<u class="fs-5">đ</u></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="video-container">
            <div class="video-overlay"></div>
            <div class="video-content">
                <div class="inner">
                    <div class="section-heading">
                        <span>Hãy liên hệ với chúng tôi</span>
                        <h2>Chúng tôi luôn sẵn lòng giúp đỡ bạn</h2>
                    </div>
                    <!-- Modal button -->

                    <div class="blue-button">
                        <a href="contact.html">Liên hệ</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="popular-places" id="popular">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <span class="h1">Sản Phẩm Bán Chạy</span>
                            <h2>Lorem ipsum dolor sit amet</h2>
                        </div>
                    </div>
                </div>

                <div class="owl-carousel owl-carousel-products owl-theme">
                    @foreach($featuredProducts as $product)
                        <div class="item popular-item">
                            <a href="{{route('landing.products.show',$product->id)}}" class="d-block">
                                <div class="thumb shadow">
                                    <img src="/files/{{$product->productDetail[0]->images[0]->name}}" class="best-sell-img" alt="">
                                    <div class="text-content">
                                        <h4>{{$product->price }}<u class="fs-5">đ</u></h4>
                                        <span>{{$product->name}}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection


@push('js')
    @if(session()->has('ordered'))
        <script>
            $(document).ready(function (){
                Toastify({
                    text: "{{session('ordered')['message']}}",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "{{session('ordered')['status']}}"
                }).showToast();
            })
        </script>
    @endif
@endpush
