<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserModule\SuperAdmin;
use App\Models\UserModule\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login_show()
    {
        if( auth('super_admin')->check() || auth('web')->check() ){
            return redirect()->route("dashboard");
        }else{
            return view('auth.login');
        }
    }

    public function do_login(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'password' => 'required|min:6',
        ]);
        

        $superadmin = SuperAdmin::where('email',$request->staff_id)->first();
        $user = User::where('staff_id',$request->staff_id)->first();

        if( $superadmin ){
            if (auth('super_admin')->attempt(['email' => $request->staff_id, 'password' => $request->password], $request->remember)) {
                $dashboard = route('dashboard');
                return response()->json(['login' => $dashboard ], 200);
            } 
            else {
                return response()->json(['error' => 'Invalid Credentials' ], 200);
            }
        }
        elseif( $user ){

            if( HrisLogin($request->staff_id, $request->password) ) {
                if( $user->is_active == true && $user->role->is_active == true ){
                    $dashboard = route('dashboard');
                    Auth::guard('web')->login($user, true);
                    return response()->json(['login' => $dashboard ], 200);
                }
                else{
                    return response()->json(['error' => 'Your Account is temporary disabled. Please contact with system administrator' ], 200);
                }
            }
            else{
                return response()->json(['error' => 'Invalid Credentials' ], 200);
            }
            
        }
        else{
            return response()->json(['error' => 'Invalid Credentials' ], 200);
        }

        
    }
}