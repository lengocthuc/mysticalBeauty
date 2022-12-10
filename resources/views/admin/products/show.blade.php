@extends('layouts.admin')

@section('title')
    Chi tiết sản phẩm
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('admin/vendors/quill/quill.snow.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/fontawesome/all.min.css')}}">

@endpush
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Xem chi tiết sản phẩm</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                               name="name" value="{{$product->name}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Giá</label>
                                        <input type="number" id="last-name-column" class="form-control"
                                               value="{{$product->price}}" name="price">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Danh mục</label>
                                        <select multiple="multiple" class="form-control" id="multipleSelect">
                                            @foreach($categories as $category)
                                                <option>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <div class="form-control" id="editor"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <nav class="d-flex align-items-center">
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            @foreach($details as $key => $detail)
                                                <button class="nav-link me-1 {{$key==0?'active':''}}"
                                                        data-bs-toggle="tab"
                                                        data-bs-target="#detail-{{$key}}" type="button" role="tab"
                                                        aria-controls="detail-{{$key}}" aria-selected="true">
                                                    Màu {{$key+1}}
                                                </button>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content mt-3" id="nav-tabContent">
                                        @foreach($details as $key => $detail)
                                            <div class="tab-pane {{$key==0?'show active':''}}" id="detail-{{$key}}"
                                                 role="tabpanel"
                                                 aria-labelledby="nav-home-tab">
                                                <div class="row">
                                                    <div class="col-md-3 col-lg-6">
                                                        <div class="form-group">
                                                            <label>màu sắc</label>
                                                            <input class="form-control" type="color"
                                                                   value="{{$detail->color}}" disabled/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-lg-6">
                                                        <div class="form-group">
                                                            <label>Số lượng</label>
                                                            <input class="form-control" type="number" min="1" max="9999"
                                                                   value="{{$detail->quantity}}" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-lg-12">
                                                        <label for="images-upload">Ảnh</label>

                                                    </div>
                                                    <div class="col-md-6 mt-3 mx-auto">
                                                        <div id="carouselExampleControls" class="carousel slide">
                                                            <div class="carousel-inner">
                                                                @foreach($detail->images as $key=> $images)
                                                                    <div class="carousel-item {{$key==0?'active':''}}">
                                                                        <img src="/files/{{$images->name}}"
                                                                             class="d-block w-100" alt="...">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <a class="carousel-control-prev"
                                                               href="#carouselExampleControls" role="button"
                                                               data-slide="prev">
                                                                <span class="carousel-control-prev-icon"
                                                                      aria-hidden="true"></span>
                                                                <span class="sr-only">Previous</span>
                                                            </a>
                                                            <a class="carousel-control-next"
                                                               href="#carouselExampleControls" role="button"
                                                               data-slide="next">
                                                                <span class="carousel-control-next-icon"
                                                                      aria-hidden="true"></span>
                                                                <span class="sr-only">Next</span>
                                                            </a>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pre-js')
    <script src="{{asset('admin/vendors/quill/quill.js')}}"></script>
    <script src="{{asset('admin/vendors/fontawesome/all.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('.carousel').carousel()
            $('.carousel-control-next').click(function (e){
                e.preventDefault()
                $('.carousel').carousel('next')
            })
            $('.carousel-control-prev').click(function (e){
                e.preventDefault()
                $('.carousel').carousel('prev')
            })
            // quill editor
            var quill = new Quill('#editor', {
                modules: {
                    toolbar: false
                },
                theme: 'snow'
            });
            quill.enable(false);
            try {
                const json = '{{$product->description}}'.replace(/&quot;/g, "\"").replace(/\n/g, "\\n")
                quill.setContents(JSON.parse(json));
            } catch (e) {
                console.log('error')
            }

        })
    </script>
@endpush
