@extends('layouts.admin')

@section('title')
    Thêm sản phẩm
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('admin/vendors/quill/quill.snow.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/fontawesome/all.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thêm sản phẩm mới</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" id="create-form" enctype="multipart/form-data">
                            <div class="row">
                                <input type="hidden" id="_token" value="{{@csrf_token()}}">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                               placeholder="Tên sản phẩm" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Giá</label>
                                        <input type="number" id="last-name-column" class="form-control"
                                               placeholder="Giá" name="price">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Danh mục</label>
                                        <select name="categories[]" multiple="multiple" class="form-control" id="multipleSelect"></select>
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
                                            <button class="nav-link me-1 active" data-bs-toggle="tab"
                                                    data-bs-target="#detail-1" type="button" role="tab"
                                                    aria-controls="detail-1" aria-selected="true">Color 1
                                                <i class="fa fa-times deleteColor"></i>
                                            </button>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-secondary btnAddColor">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </nav>
                                    <div class="tab-content mt-3" id="nav-tabContent">
                                        <div class="tab-pane show active" id="detail-1" role="tabpanel"
                                             aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-3 col-lg-6">
                                                    <div class="form-group">
                                                        <label>màu sắc</label>
                                                        <input class="form-control" type="color" name="color"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Số lượng</label>
                                                        <input class="form-control" type="number" min="1" max="9999"
                                                               name="quantity"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-12">
                                                    <label for="images-upload">Ảnh</label>
                                                    <input type="file" multiple accept="image/*"
                                                           class="form-control images-upload" name="images">
                                                </div>
                                                <div class="col-md-6 mt-3 mx-auto">
                                                    <div id="carouselExampleControls" class="carousel slide"
                                                         data-ride="carousel">
                                                        <div class="carousel-inner">

                                                        </div>
                                                        <a class="carousel-control-prev"
                                                           href="#carouselExampleControls" role="button"
                                                           data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon"
                                                                      aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next"
                                                           href="#carouselExampleControls" role="button"
                                                           data-bs-slide="next">
                                                                <span class="carousel-control-next-icon"
                                                                      aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="button" class="btnSubmit btn btn-primary me-1 mb-1">Submit</button>
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
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // handle event
            $(document).on('click', '.btnAddColor', function () {
                let size = $('#nav-tab > button').length;
                $('#nav-tab > button.active').removeClass('active')
                $('#nav-tabContent > div.tab-pane.active').removeClass('active show')
                $('#nav-tab').append(`
                        <button class="nav-link me-1 active" data-bs-toggle="tab"
                            data-bs-target="#detail-${size + 1}" type="button" role="tab"
                            aria-controls="detail-${size + 1}" aria-selected="true">Color ${size + 1}
                            <i class="fa fa-times deleteColor"></i>
                        </button>
                `)
                $('#nav-tabContent').append(`
                    <div class="tab-pane show active" id="detail-${size + 1}" role="tabpanel"
                         aria-labelledby="detail-${size + 1}">
                        <form class="sub-form">
                            <div class="row">
                                <div class="col-md-3 col-lg-6">
                                    <div class="form-group">
                                        <label>màu sắc</label>
                                        <input class="form-control" type="color" name="color"/>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-6">
                                    <div class="form-group">
                                        <label>Số lượng</label>
                                        <input class="form-control" type="number" min="1" max="9999"
                                               name="quantity"/>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-12">
                                    <label for="images-upload">Ảnh</label>
                                    <input type="file" multiple accept="image/*" class="form-control images-upload" name="images">
                                </div>
                                <div class="col-md-6 mt-3 mx-auto">
                                    <div id="carouselExampleControls" class="carousel slide"
                                         data-ride="carousel">
                                        <div class="carousel-inner">

                                        </div>
                                        <a class="carousel-control-prev"
                                           href="#carouselExampleControls" role="button"
                                           data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"
                                                  aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </a>
                                        <a class="carousel-control-next"
                                           href="#carouselExampleControls" role="button"
                                           data-bs-slide="next">
                                            <span class="carousel-control-next-icon"
                                                  aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                `)
            })

            $(document).on('click', '.deleteColor', function (e) {
                let id = $(e.target).parents('.nav-link').attr('data-bs-target');
                $(e.target).parents('.nav-link').remove();
                $(id).remove();
                $('#nav-tab button.nav-link:first-child').addClass('active')
                $('#nav-tabContent div.tab-pane:first-child').addClass('active show')
            })

            $(document).on('change', '.images-upload', function (e) {
                readAsDataURL(this).then(resp => {
                    resp.forEach((url, index) => {
                        let content = $(e.target).parents('.tab-pane');
                        $(content[0].querySelector('.carousel-inner')).append(`
                        <div class="carousel-item ${index == 0 ? 'active' : ''}">
                            <img id="img1" src="${url}" class="d-block w-100" alt="...">
                        </div>`)
                    })
                })
            })

            $('.btnSubmit').click(function (e) {
                e.preventDefault();
                createProduct()
            })

            // quill editor
            var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],

                [{'header': 1}, {'header': 2}],               // custom button values
                [{'list': 'ordered'}, {'list': 'bullet'}],
                [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
                [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
                [{'direction': 'rtl'}],                         // text direction

                [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
                [{'header': [1, 2, 3, 4, 5, 6, false]}],

                [{'color': []}, {'background': []}],          // dropdown with defaults from theme
                [{'font': []}],
                [{'align': []}],

                ['clean']                                         // remove formatting button
            ];
            var quill = new Quill('#editor', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            });

            // select 2

            $('#multipleSelect').select2({
                ajax: {
                    url: '{{route('api.subCategories')}}',
                    method: 'get',
                    dataType: 'json',
                    delay: 350,
                    placeholder: 'tìm danh mục',
                    minimumInputLength: 1,
                    data: function (params) {
                        var query = {
                            q: params.term
                        }
                        return query;
                    },
                    processResults: function (data, params) {
                        var data = $.map(data.results, obj =>{
                            obj.id = obj.id;
                            obj.text = obj.name;
                            return obj;
                        });
                        return {
                            results: data
                        };
                    },

                }
            });

            function createProduct(){
                let Data = {};
                Data.product = {
                    name : $('input[name="name"]').val(),
                    price : $('input[name="price"]').val(),
                    description : JSON.stringify(quill.getContents())
                }
                let colorDetails = $.map($('.tab-pane'),tab => {
                    let inputs = tab.querySelectorAll('input')
                    let data = {}
                    data.tab = tab.getAttribute('id')
                    for (input of inputs){
                        data[`${input.name}`] = input.value;
                    }
                    return data
                })
                var selected = $('#multipleSelect').select2("val");
                Data.categories = selected;
                const imagesUrl = getImagesUrl();
                Promise.all(imagesUrl)
                    .then(resp => {
                        let data = []
                        colorDetails.forEach(color => {
                            let exists = resp.filter(img => img.tab === color.tab)
                            if(exists.length > 0){
                                let merge = {...color,...exists[0]}
                                delete merge.tab
                                delete merge.images
                                data.push(merge)
                            }
                        })
                        Data.details = data
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': '{{csrf_token()}}'
                            },
                            url : '{{route('products.store')}}',
                            method : 'post',
                            data : JSON.stringify(Data),
                            contentType : "application/json",
                            dataType: 'json',
                            timeout: 3000,
                            beforeSend: function(){
                                $("#loading-overlay").show();
                            },
                            success: function(result) {
                                $("#loading-overlay").hide();
                                $('#create-form')[0].reset();
                                $('#multipleSelect').select2("val","")
                                quill.setContents([]);
                                $('#nav-tab').empty()
                                $('#nav-tabContent').empty()
                                createToast(result.message,'success')
                            },
                            error: function(error) {
                                createToast(JSON.parse(error.responseText).message,'danger')
                                $("#loading-overlay").hide();
                            }
                        })
                    })
            }
        })
    </script>
@endpush
