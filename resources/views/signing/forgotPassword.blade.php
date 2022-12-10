@extends('layouts.signing')
@push('css')
    <style>
        .form-control-icon{
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
        }
        .form-control{
            padding-left: 35px;
        }
        .title{
            color: #4662c8;
        }
        .btnSubmit{
            background-color: #4662c8;
            color: white;
        }
        .btnSubmit:hover{
            background-color: #2f47a0;
            color: white;
        }
        .btnSubmit:active, .btnSubmit:focus{
            background-color: #1b2758;
            color: white;
        }
        .form{
            padding: 10px 30px 50px 30px;
            background-color: white;
        }
        .pt-10{
            padding-top: 140px;
        }
    </style>
@endpush

@section('title')
    Quên mật khẩu
@endsection
@section('main')
    <div class="pt-10 position-relative">
        <div class="col-lg-4 col-12 mx-auto shadow-lg rounded-3 form">
            <h1 class="mb-4 title">Quên mật khẩu</h1>
            @if(session('alert') != null)
                <div class="alert alert-{{session('alert')['type']}}" role="alert">
                    {{session('alert')['message']}}
                </div>
            @endif
            <form id="forgetForm" action="{{route('sendMail')}}" method="post">
                @csrf
                <div class="form-group position-relative mb-4">
                    <input type="email" name="email" class="form-control form-control-xl" placeholder="Tài khoản" required>
                </div>

                <button type="button" class="btn btnSubmit shadow-lg mt-4 form-control">Xác nhận</button>
            </form>
        </div>

    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function (){
            $('.btnSubmit').click(debounce(()=>{
                $('#forgetForm')[0].submit();
            },500))
        })
    </script>
@endpush
