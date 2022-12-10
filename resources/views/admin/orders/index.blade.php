@extends('layouts.admin')
@section('title')
    Danh sách sản phẩm
@endsection
@push('css')

@endpush

@section('main')
    @php
        $title = [
            'PENDING'=>'Xác nhận',
            'PROCESSING'=>'Giao hàng'
        ];
    @endphp
    <div class="page-heading">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tổng tiền</th>
                <th scope="col">Ngày đặt</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
                @foreach($orders as $key=>$order)
                    <tr>
                        <th scope="row">{{$order->id}}</th>
                        <td>{{$order->totalAmount}}</td>
                        <td>{{$order->createAt}}</td>
                        <td><a href="#">xem</a></td>
                        <td>
                        @if($status == 'PENDING' || $status == 'PROCESSING')
                            <form action="{{route('order.confirm',$order->id)}}" method="post">
                                @csrf
                                <button name="status" value="{{$status}}" class="btn btn-success btn-sm" type="submit">{{$title[$status]}}</button>
                            </form>
                        @endif
                        </td>
                        <td>
                        @if($status == 'PENDING' || $status == 'PROCESSING')
                            <form action="{{route('order.cancel',$order->id)}}" method="post">
                                @csrf
                                <button name="status" value="{{$status}}" class="btn btn-danger btn-sm" type="submit">Hủy đơn</button>
                            </form>
                        @endif
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                @php
                    if($current_page > 2) $i = $current_page - 2;
                    else $i=1;
                    $page_end = ceil($total / $size);
                    if($current_page+2 <= $page_end){
                        $numPage = $current_page + 2;
                    }
                    else    $numPage = $page_end;
                @endphp
                <li class="page-item {{1 == $current_page ? 'disabled' : ''}}">
                    <a class="page-link" href="{{route('order.getByStatus',[$status,$current_page-1])}}" >Previous</a>
                </li>
                @for($i;$i<=$numPage;$i++)
                    <li class="page-item"><a class="page-link {{$i == $current_page ? 'disable' : ''}}" href="{{route('order.getByStatus',[$status,$i] )}}">{{$i}}</a></li>
                @endfor
                <li class="page-item {{$page_end == $current_page ? 'disabled' : ''}}">
                    <a class="page-link" href="{{route('order.getByStatus',[$status,$current_page+1])}}">Next</a>
                </li>
            </ul>
        </nav>
    </div>
@endsection

@push('pre-js')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/fh-3.2.2/r-2.2.9/sc-2.0.5/sb-1.3.2/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/fh-3.2.2/r-2.2.9/sc-2.0.5/sb-1.3.2/datatables.min.js"></script>

@endpush
