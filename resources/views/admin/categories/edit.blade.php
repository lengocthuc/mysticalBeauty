@extends('layouts.admin')
@section('title')
    Sửa Danh mục
@endsection
@push('css')

@endpush

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Sửa danh mục</h3>
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
                        <div class="row">
                            <div class="col-md-12 d-flex my-1">
                                <form id="updateForm">
                                    <label for="">Tên danh mục</label>
                                    <input type="text" name="name" value="{{$category->name}}">
                                    <button type="button" class="btnSubmit btn btn-primary me-1 mb-1">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('pre-js')
    <script>
        $(document).ready(function (){
            $('.btnSubmit').click(function (){
                var Data = $("#updateForm").serializeArray()[0];
                $.ajax({
                    headers: {
                        'X-CSRF-Token': '{{csrf_token()}}'
                    },
                    url: "{{route('categories.update',$category->id)}}",
                    method:'post',
                    data : JSON.stringify(Data),
                    contentType : "application/json",
                    dataType: 'json',
                    beforeSend: function(){
                        $("#loading-overlay").show();
                    },
                    success: function(result) {
                        $("#loading-overlay").hide();
                        createToast(result.message,'success')
                    },
                    error: function(error) {
                        $("#loading-overlay").hide();
                        createToast(JSON.parse(error.responseText).message,'danger')
                    }
                })
            })
        })
    </script>
@endpush
