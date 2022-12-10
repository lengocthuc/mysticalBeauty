@extends('layouts.admin')
@section('title')
    Danh sách sản phẩm
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        table.dataTable thead .sorting, table.dataTable thead .sorting_desc {
            background-position: left !important;
        }

        #loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 60px;
            height: 60px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            margin: auto;
        }

        #button_wrapper{
            padding: 0 12px;
        }
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Danh sách danh mục</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Danh mục con
                </div>
                <div class="card-body">
                    <div id="button_wrapper">
                        <div class="row">
                            <div class="col-md-6 d-flex my-1">
                                <a href="{{route('subCategories.create')}}" class="btn btn-success btn-sm me-1">Thêm</a>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <table class="table table-hover" id="products">
                            <thead>
                            <tr>
                                <th><a href="#" class="dataTable-sorter">#</a>
                                </th>
                                <th><a href="#" class="dataTable-sorter">Danh mục</a>
                                </th>
                                <th><a href="#" class="dataTable-sorter">Danh mục cha</a>
                                </th>
                                <th>
                                    sửa
                                </th>
                                <th>
                                    xóa
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </section>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pre-js')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/fh-3.2.2/r-2.2.9/sc-2.0.5/sb-1.3.2/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/fh-3.2.2/r-2.2.9/sc-2.0.5/sb-1.3.2/datatables.min.js"></script>

    <script>
        // Simple Datatable
        $(document).ready(function () {
            $(document).on('click','.btnDelete',function (e){
                e.preventDefault()
                let row = $(this).parents('tr')
                let form = $(this).parents('form')
                $.ajax({
                    url: form.attr('action'),
                    method: 'post',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (resp){
                        row.remove();
                        table.draw();
                        createToast(resp.message,'success')
                    },
                    error: function (error){
                        createToast(JSON.parse(error.responseText).message,'danger')
                    },

                })

            })

            let table = $('#products').DataTable({
                ajax: "{!! route('api.subCategories.data') !!}",
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'parentName', name: 'parentName'},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false},
                    {
                        data: 'delete', name: 'delete', orderable: false, searchable: false,
                        render: function (data,type,row,meta){
                            return `<form action='${data}' method='post'>
                                        @csrf
                            <button type='button' class='btnDelete btn btn-danger btn-sm' >xóa</button>
                        </form>`
                        }
                    },
                ],
                columnDefs: [
                    {className: 'not-export', 'targets': [3]},
                    {className: 'not-export', 'targets': [4]},
                ],
                pagingType: "full_numbers",
                searchDelay: 500,
                language: {processing: "<div id='loader'></div>"},
                responsive: true,
                dom: 'Bflrtip',
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible :not(.not-export)'
                        },
                        className: 'btn btn-secondary btn-sm'

                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible :not(.not-export)'
                        },
                        className: 'btn btn-secondary btn-sm'
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible :not(.not-export)'
                        },
                        className: 'btn btn-secondary btn-sm'
                    }
                ]
            });

            table.buttons().container().appendTo('#button_wrapper .col-md-6:eq(0)');
            Array.from(table.buttons()).forEach(b => $(b.node).removeClass('dt-button buttons-excel buttons-pdf buttons-print buttons-html5'))
        });

    </script>
@endpush
