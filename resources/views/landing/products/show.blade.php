@extends('layouts.landing')
@section('title')
    {{$product->name}}
@endsection

@section('main')
    <section class="banner banner-secondary" id="top"
             style="background-image: url('{{asset('/img/lipstick_banner_1920x300.jpg')}}');">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>{{$product->name}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="featured-places">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div>
                        <img src="/files/{{$details->first()->images->first()->name}}" alt=""
                             class="lg-img img-responsive wc-image">
                    </div>
                    <br>
                    <div class="row">
                        <div class="owl-carousel owl-carousel-img owl-theme">
                            @foreach($details as $detail)
                                @foreach($detail->images as $img)
                                    <div class="item popular-item sm-img">
                                        <img color="{{$detail->color}}" src="/files/{{$img->name}}" alt=""
                                             class="img-responsive">
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12">
                    <form action="{{route('buyNow')}}" method="post" id="add-to-cart-form" autocomplete="off">
                        @csrf
                        <h2><strong class="text-primary">VND {{$product->price}}</strong></h2>
                        <br>
                        <p class="description"></p>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label">Màu sắc</label>

                                <div class="row">
                                    @foreach($details as $key=> $detail)
                                        <div class="col-md-2 col-sm-1">
                                            <label color="{{$detail->color}}" style="background: {{$detail->color}}"
                                                   class="color-picker" for="color{{$key}}"></label>
                                            <input id="color{{$key}}" class="input-color" type="radio" name="color"
                                                   value="{{$detail->id}}">
                                        </div>
                                    @endforeach
                                </div>

                                <label class="control-label">Số lượng</label>

                                <div class="form-group">
                                    <input type="number" name="quantity" class="form-control" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="blue-button">
                            <a href="#" class="add-to-cart">Thêm vào giỏ</a>
                        </div>
                        <div class="blue-button mt-1">
                            <input type="button" class="buy-now" value="Mua Ngay">
                        </div>
                    </form>
                    <div class="mt-5">
                        <span>Danh mục: </span>
                        @foreach($categories as $category)
                            <a href="#"><span>{{$category->name}}</span></a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            function quillGetHTML(inputDelta) {
                var tempCont = document.createElement("div");
                (new Quill(tempCont)).setContents(JSON.parse(inputDelta));
                return tempCont.getElementsByClassName("ql-editor")[0].innerHTML;
            }

            const deltaData = '{{$product->description}}'.replace(/&quot;/g, "\"").replace(/\n/g, "\\n")
            $('.description').append(quillGetHTML(deltaData))
        })
    </script>
@endpush
