<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Cookie;

class BackendAuth
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
        $expires = $request->cookie('expires');
        $expires = intval($expires);
      if ($request->cookie('full_name') && $expires > time()) {
            return $next($request);
        }
        $request->session()->flash('alert-class', 'alert-danger');
        $request->session()->flash('message', "You have not logged in");
        return redirect()->route('logout');
    }
}
