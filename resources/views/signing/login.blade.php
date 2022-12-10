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
        .form{
            padding: 10px 30px;
            background-color: white;
        }
        .pt-10{
            padding-top: 140px;
        }
    </style>
@endpush

@section('title')
    Đăng nhập
@endsection
@section('main')
    <div class="pt-10 position-relative">
        <div class="col-lg-4 col-12 mx-auto shadow-lg rounded-3 form">
            <h1 class="mb-4 title">Đăng nhập</h1>
            @if(session('alert') != null)
                <div class="alert alert-{{session('alert')['type']}}" role="alert">
                    {{session('alert')['message']}}
                </div>
            @endif
            <form action="{{route('signIn')}}" method="post">
                @csrf
                <div class="form-group position-relative mb-4">
                    <input type="text" name="username" class="form-control form-control-xl" placeholder="Tài khoản" required>
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative mb-4">
                    <input type="password" name="password" class="form-control form-control-xl" placeholder="Mật khẩu" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button class="btn btnSubmit shadow-lg mt-4 form-control">Đăng nhập</button>
            </form>
            <div class="text-center mt-5 fs-6">
                <p class="text-gray-600">Bạn đã có tài khoản chưa? <a href="{{route('registration')}}" class="font-bold">Đăng ký</a>.</p>
                <p><a class="font-bold" href="{{route('forgotPassword')}}">Quên mật khẩu?</a>.</p>
            </div>
        </div>

    </div>
@endsection
@push('js')

@endpush
