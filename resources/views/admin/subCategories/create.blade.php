@extends('layouts.admin')
@section('title')
    Thêm Danh mục con
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Thêm danh mục con</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Danh mục
                </div>
                <div class="card-body">
                    <div id="button_wrapper">
                        <form id="updateForm">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="">Tên danh mục</label>
                                    <input class="form-control" type="text" name="name" id="name">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Danh mục cha</label>
                                        <select name="categoryId" class="form-control" id="select"></select>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btnSubmit btn btn-primary me-1 mb-1">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('pre-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#select').select2({
                ajax: {
                    url: '{{route('api.categories')}}',
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


            $('.btnSubmit').click(function () {
                $.ajax({
                    headers: {
                        'X-CSRF-Token': '{{csrf_token()}}'
                    },
                    url: "{{route('subCategories.store')}}",
                    method: 'post',
                    data: JSON.stringify({
                        name: $('#name').val(),
                        categoryId: $('#select').select2('val'),
                    }),
                    contentType: "application/json",
                    dataType: 'json',
                    beforeSend: function () {
                        $("#loading-overlay").show();
                    },
                    success: function (result) {
                        $("#loading-overlay").hide();
                        $('#name').val('')
                        createToast(result.message, 'success')
                    },
                    error: function (error) {
                        $("#loading-overlay").hide();
                        createToast(JSON.parse(error.responseText).message, 'danger')
                    }
                })
            })
        })
    </script>
@endpush
