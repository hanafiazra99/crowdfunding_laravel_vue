<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$role)
    {
        $role_id = Role::where('role',$role)->first()->id;
        if(auth()->user()->role_id ==  $role_id){
            return $next($request);
        }
        return abort(403);

    }
}
