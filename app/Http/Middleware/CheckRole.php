<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Người dùng đã đăng nhập, kiểm tra vai trò
            if (Auth::user()->role!='admin') {
                return abort(403, 'Unauthorized action.');
            }
        } else {
            // Người dùng chưa đăng nhập, điều hướng đến trang đăng nhập hoặc trang lỗi
            // Ví dụ:
             return redirect()->route('login');
            // Hoặc:
            // return abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }

}
