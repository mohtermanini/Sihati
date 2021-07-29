<?php

namespace App\Http\Middleware;

use Closure,Session, Auth;
use Illuminate\Http\Request;
use App\Models\AccountType;

class Type
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $types, $message = "لاتملك صلاحيات الدخول لهذا الرابط")
    {
        if(Auth::check()){
            $types = explode("-",$types);
            $user_type = AccountType::where("id",Auth::user()->type_id)->first()->name;
            if(in_array($user_type ,$types)){
                return $next($request);
            }
        }
            Session::flash("failed",$message);
            return redirect()->back();
        }
}
