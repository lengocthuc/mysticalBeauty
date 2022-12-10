<?php

namespace App\Http\Controllers;

use App\Mail\SendOtp;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SigningController extends Controller
{
    public function login(Request $request){
        if(!session()->has('user')){
            return view('signing.login');
        }
        else{
            return redirect()->route('home-page');
        }
    }
    public function signIn(Request $request){
        try{
            $data = [
                'email' => $request->get('username'),
                'password' => $request->get('password'),
            ];
            $user = User::query()->where('email','=',$data['email'])
                ->firstOrFail();
            if(!Hash::check($request->get('password'),$user->password)){
                throw new \Exception();
            }
            if (!session()->has('user')){
                session()->put('user',$user);
            }
            if(session()->has('back-url')){
                return redirect()->to(session('back-url')['url']);
            }
            return redirect()->route('admin-dashboard');
        }catch (\Exception){
            session()->flash('alert',[
                'message'=>'Tài khoản hoặc mật khẩu không chính xác!',
                'type'=>'danger'
            ]);
            return redirect()->route('login');
        }

    }

    public function signOut(Request $request){
        session()->flush();
        return redirect()->route('home-page');
    }

    public function registration(Request $request){
        return view('signing.registration');
    }

    public function signUp(Request $request){
        try{
            DB::beginTransaction();
            if(User::query()->where('email', $request->get('email'))->exists()){
                session()->flash('alert',[
                    'message'=>'tài khoản đã tồn tại',
                    'type'=>'danger'
                ]);
                return redirect()->route('registration');
            }else{
                $user = new User();
                $data = $request->all();
                $user->fill($data);
                $password = $request->get('password');
                $user->fill([
                    'password'=>Hash::make($password),
                ]);
                $user->save();
                DB::commit();
                session()->flash('alert',[
                    'message'=>'Đăng ký thành công!',
                    'type'=>'success'
                ]);
                return redirect()->route('login');
            }

        }catch (\Exception){
            DB::rollBack();
            session()->flash('alert',[
                'message'=>'Có lỗi xảy ra, vui lòng thử lại sau!',
                'type'=>'danger'
            ]);
            return redirect()->route('registration');
        }
    }

    public function forgotPassword(Request $request)
    {
        return view('signing.forgotPassword');
    }
    public function sendMail(Request $request)
    {
        try{
            $email = $request->get('email');
            User::query()->where('email',$email)->firstOrFail();
            $data = [
                'email' => $email,
                'code'=> random_int(100000, 999999),
                'create_at'=> date('Y-m-d H:i:s')
            ];
            if(!session()->has('otp')){
                session()->put('otp',$data);
            }
            else{
                session()->forget('otp');
                session()->put('otp',$data);
            }
            Mail::to($email)->send(new SendOtp($data));
            return redirect()->route('confirmOtp');
        }catch (\Exception){
            session()->flash('alert',[
                'message'=>'Tài khoản không tồn tại',
                'type'=>'danger'
            ]);
            return redirect()->route('forgotPassword');
        }
    }
    public function resendMail(Request $request)
    {
        try{
            $email = session('otp')['email'];
            User::query()->where('email',$email)->firstOrFail();
            $data = [
                'email' => $email,
                'code'=> random_int(100000, 999999),
                'create_at'=> date('Y-m-d H:i:s')
            ];
            if(!session()->has('otp')){
                session()->put('otp',$data);
            }
            else{
                session()->forget('otp');
                session()->put('otp',$data);
            }
            Mail::to($email)->send(new SendOtp($data));
            return response()->json([
                'message'=>'Vui lòng kiểm tra email!'
            ]);
        }catch (\Exception){
            return response()->json([
                'message'=>'Có lỗi xảy ra, vui lòng thử lại sau!'
            ],500);
        }
    }
    public function confirmOtp(Request $request){
        return view('signing.confirmOtp',[
            'email'=>session('email')
        ]);
    }
    public function verifyOtp(Request $request){
        try{
            $otp = session('otp');
            $Time = abs(strtotime(date('Y-m-d H:i:s')) - strtotime($otp['create_at']));
            if($otp['code'] == $request->get('otp') && $Time <= 300){
                return redirect()->route('editPassword');
            }else{
                throw new \Exception();
            }
        }catch (\Exception){
            DB::rollBack();
            session()->flash('alert',[
                'message'=>'Mã OTP Không chính xác',
                'type'=>'danger'
            ]);
            return redirect()->route('confirmOtp');
        }
    }

    public function editPassword(Request $request){
        return view('signing.updatePassword',[
            'email'=>session('otp')['email']
        ]);
    }
    public function updatePassword(Request $request){
        try{
            $password = $request->get('password');
            $rePassword = $request->get('re-password');
            if($password != $rePassword){
                session()->flash('alert',[
                    'message'=>'Mật khẩu nhập lại không trùng khớp',
                    'type'=>'danger'
                ]);
                return redirect()->route('editPassword');
            }
            else{
                DB::beginTransaction();
                User::query()->where('email',session('otp')['email'])->update([
                    'password'=>Hash::make($password)
                ]);
                session()->flush();
                DB::commit();
                session()->flash('alert',[
                    'message'=>'Đổi mật khẩu thành công!',
                    'type'=>'success'
                ]);
                return redirect()->route('login');
            }
        }catch (\Exception){
            DB::rollBack();
            session()->flash('alert',[
                'message'=>'Có lỗi xảy ra, vui lòng thử lại sau!',
                'type'=>'danger'
            ]);
            return redirect()->route('editPassword');
        }
    }
}
