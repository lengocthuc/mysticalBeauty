<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class verifyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('user')){
            return $next($request);
        }
        else{
            session()->put('back-url',session('_previous'));
            if($request->ajax()){
                return response()->json([
                    'message'=>'Bạn cần phải đăng nhập!',
                    'status' => 401
                ],401);
            }
            return redirect()->route('login');
        }
    }
}
