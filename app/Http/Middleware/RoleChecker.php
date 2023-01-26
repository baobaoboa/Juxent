<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ExceptionTrait;

class RoleChecker
{
    use ExceptionTrait;
    public function handle($request, Closure $next, ...$roles)
    {
        foreach($roles as $role) {
            if(auth()->user()->role->name === $role){
                return $next($request);
            }
        }
        //echo auth()->user()->role->slug;
        $this->throwException('401', 'Unauthorized Access' );
    }

}
