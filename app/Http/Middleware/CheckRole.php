<?php

namespace App\Http\Middleware;

//use App\Admin;

use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roleName)
    {
    	$per = Auth::guard('admin')->user()->permission;
        
        if(
        	$roleName == 'isSuper' && $per != 1 ||
        	$roleName == 'isAdmin' && $per > 5 ||
        	$roleName == 'isDesigner' && $per != 10
        ) {
        	return redirect('dashboard/top-settings');
        }
    	
        return $next($request);
    }
}
