<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\ErrorResponses;
use App\Http\StatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Token;

use Carbon\Carbon;

use Auth;

class LoginController extends Controller
{
    use ErrorResponses;

    public function login(Request $request){
        $rules = array(
            'email' => 'required',
            'password' => 'required',
        );

        if(!$user = User::where('email', $request->email)->first()){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        if(!Auth::attempt([ 'email' => $request->email, 'password' => $request->password ])){
            return $this->responseError('Invalid/missing user/password...', StatusCodes::BAD_REQUEST);
        }

        $session = new Token;

        $session->user_id = $user->id;
        $session->email = $user->email;
        $session->token = $this->gen_uuid() . '.' . str_random(28);
        $session->expired_at = Carbon::now()->addMonths(2);

        $session->save();

        return response()->json([
            'status' => true,
            'msg' => 'successfully login',
            'user' => $user,
            'token' => $session->token,
        ]);
    }

    public function logout($return = true){
        if(!$session = Token::where('token', $request->ba_token)->first()){
            return $this->responseError('Failed to Logout', StatusCodes::NOT_FOUND);
        }

        $session->expired_at = Carbon::now();
        $session->save();

        return response()->json([
            'status' => true,
            'msg' => 'successfully logout!',
        ]);
    }

    private function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}