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
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Auth, Hash;

class UserController extends Controller
{
    use ErrorResponses;

    public function login(Request $request){
        $validator  = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        if(!$user = User::select(['email', 'fullname', 'phone_number', 'status', 'type'])->where('email', $request->email)->first()){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->responseError('Email / password not match.', StatusCodes::INTERNAL_SERVER_ERROR);
            }
        } catch (JWTException $e) {
            return $this->responseError('Could not create token.', StatusCodes::INTERNAL_SERVER_ERROR);
        }

        return response()->json(['status' => true, 'data' => [
            'user' => $user, 
            'token' => $token,
            'address' => [],
            'wishlist' => [],
            'payment' => [],
            'posts' => [],
            'messages' => []
        ]]);
    }

    public function logout(Request $request){

    }

    public function show(Request $request){
        if(!$user = User::where('email', $request->email)->firs()){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        return response()->json(['status' => true, 'data' => $user]);
    }

    public function store(Request $request){
        $validator  = Validator::make($request->all(), [
            'email' => 'required|min:5|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'fullname' => 'required|min:6',
            'phone_number' => 'numeric',
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $user = new User;

        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->fullname = $request->fullname;
        $user->phone_number = $request->phone_number ? '+62' . $request->phone_number : '';
        $user->status = 'not verified';
        $user->type = $request->type ?: 'customer';

        if($user->type == 'super admin') $user->status = 'verified';

        $user->save();

        return response()->json([
            'status' => true,
            'msg' => 'user create successfully',
            'user' => $user
        ]);
    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }
}