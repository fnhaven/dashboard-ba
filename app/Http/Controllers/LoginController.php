<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\ErrorResponses;
use App\Http\StatusCodes;

use App\User;

use Auth;

class LoginController extends Controller
{
    use ErrorResponses;

    public function login(Request $request){
        $validator  = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return redirect('login')->with('login-error', $validator->errors())->withInput();
        }

        if(!$user = User::where('email', $request->email)->first()){
            return redirect('login')->with('login-error', 'Email not found!')->withInput();
        }

        if(!Auth::attempt([ 'email' => $request->email, 'password' => $request->password ])){
            return redirect('login')->with('login-error', 'Invalid/missing user/password...')->withInput();
        }

        if($user->type !== 'admin' && $user->type !== 'super admin'){
            $this->logout(false);
            return redirect('login')->with('login-error', 'Cannot Login use this account!')->withInput();
        }

        return redirect('/');
    }

    public function logout($return = true){
        Auth::logout();

        if($return){
            return redirect('login');
        }
    }
}