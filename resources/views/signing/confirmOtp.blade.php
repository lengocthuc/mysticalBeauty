@extends('layouts.signing')
@push('css')
    <link rel="stylesheet" href="{{asset('/landing/vendors/toastify/toastify.css')}}">
    <style>
        .form-control-icon{
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
        }
        .reSend{
            background: none;
            border: none;
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
            padding: 10px 30px 50px 30px;
            background-color: white;
        }
        .pt-10{
            padding-top: 140px;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
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
            <h3>{{$email}}</h3>
            <form action="{{route('verifyOtp')}}" method="post">
                @csrf
                <div class="form-group mb-4">
                    <label for="">Mã OTP</label>
                    <div class="position-relative">
                        <input type="number" name="otp" class="form-control form-control-xl" required >
                        <div class="form-control-icon" title="gửi lại mã" >
                            <button class="reSend" ><i class="bi bi-arrow-clockwise"></i></button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btnSubmit shadow-lg mt-4 form-control">Xác nhận</button>
            </form>
        </div>

    </div>
@endsection
@push('js')
    <script src="{{asset('/landing/vendors/toastify/toastify.js')}}"></script>
    <script>

        $(document).ready(function (){

            function createToast(content,type,duration = 3000){
                Toastify({
                    text: content,
                    duration: duration,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className:type
                }).showToast();
            }
            const resendMail =  debounce(function (){
                createToast('Đã yêu cầu gửi lại mã OTP!','info')
                $.ajax({
                    headers: {
                        'X-CSRF-Token': '{{csrf_token()}}',
                    },
                    url : `{{route('resendMail')}}`,
                    method : 'post',
                    data : JSON.stringify({
                        email:'{{$email}}'
                    }),
                    contentType : "application/json",
                    dataType: 'json',
                    timeout: 5000,
                    success: function(result) {
                        createToast(result.message,'success')
                    },
                    error: function(error) {
                        let resp = error.responseText || '{"message":"Có lỗi!"}'
                        createToast(JSON.parse(resp).message,'danger')
                    }
                })
            },500)

            $('.reSend').click(function (e){
                e.preventDefault();
                resendMail();
            })
        })
    </script>
@endpush
