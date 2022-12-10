@extends('layouts.signing')
@push('css')
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .form-control-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
        }

        .form-control {
            padding-left: 35px;
        }

        .title {
            color: #4662c8;
        }

        .btnSubmit {
            background-color: #4662c8;
            color: white;
        }

        .btnSubmit:hover {
            background-color: #2f47a0;
            color: white;
        }

        .form {
            padding: 10px 30px 50px 30px;
            background: white;
        }

    </style>
@endpush

@section('title')
    Đăng ký
@endsection
@section('main')
    <div class="container pt-5 position-relative">
        <div class="col-lg-6 col-12 mx-auto shadow-lg rounded-3 form">
            <h1 class="mb-4 title">Đăng ký</h1>
            @if(session('alert') != null)
                <div class="alert alert-{{session('alert')['type']}}" role="alert">
                    {{session('alert')['message']}}
                </div>
            @endif
            <form action="{{route('signUp')}}" method="post">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            @csrf
                            <div class="col-md-6 col-12 mt-2">
                                <div class="form-group">
                                    <label>Họ tên</label>
                                    <input type="text"  class="form-control"
                                           placeholder="Họ tên" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mt-2">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email"  class="form-control"
                                           placeholder="Example@email.com" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 mt-2">
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text"  class="form-control"
                                           placeholder="Địa chỉ" name="address" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 mt-2">
                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="text"  class="form-control"
                                           placeholder="Số điện thoại" name="phoneNumber" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 mt-2">
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <input type="password"  class="form-control"
                                           placeholder="Mật khẩu" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 mt-4">
                                <div class="form-group">
                                    <button class="btn btnSubmit form-control">Đăng ký</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </form>
    </div>
    </div>
@endsection
@push('js')

@endpush
