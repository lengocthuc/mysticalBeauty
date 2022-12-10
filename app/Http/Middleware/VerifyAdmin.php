<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class VerifyAdmin
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
        if($request->session()->has('user') && session('user')['isAdmin'] == 1){
            return $next($request);
        }else{
            session()->flash('alert',[
                'message'=>'Bạn cần phải đăng nhập để tiếp tục!',
                'type'=>'danger'
            ]);
            return redirect()->route('login');
        }

    }
}
