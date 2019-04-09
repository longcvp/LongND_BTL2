<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Support\MessageBag;

class ActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if (!Auth::check()) {
            return view('login');
        } elseif (Auth::user()->active == 1) {
            return $next($request);
        } else {
            Auth::logout();
            $errors = new MessageBag(['errorlogin' => 'Bạn chưa xác thực email! Mời bạn xác thực email sau đó đăng nhập']);
            return redirect()->route('login.index')->withInput()->withErrors($errors);
        }
    }
}
