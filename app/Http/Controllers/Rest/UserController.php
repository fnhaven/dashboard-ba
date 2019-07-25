<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\ErrorResponses;
use App\Http\StatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\UserAdress;
use App\Token;

use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use DB, Hash;

class UserController extends Controller
{
    use ErrorResponses;

    public function get_all(){
        $user = User::get();

        $user = collect($user)->map(function($v, $k){
            $v->wishlist;
            $v->address;

            unset($v->id);
            
            return $v;
        });

        return $user;
    }

    # login
    # params $request
    # return json
    public function login(Request $request){
        $validator  = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        if(!$user = User::select(['id', 'email', 'fullname', 'phone_number', 'status', 'type', 'created_at', 'updated_at'])->where('email', $request->email)->first()){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        if($user->status == 'not verified'){
            return $this->responseError('User account not verified. Please verified your account.', StatusCodes::INTERNAL_SERVER_ERROR);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->responseError('Email / password not match.', StatusCodes::INTERNAL_SERVER_ERROR);
            }
        } catch (JWTException $e) {
            return $this->responseError('Could not create token.', StatusCodes::INTERNAL_SERVER_ERROR);
        }

        # show user address
        $user->address;
        # show user wishlist
        $user->wishlist = collect($user->wishlist)->map(function($v, $k){
            $v->catalog;
            $v->catalog->category_name = $v->catalog->category->name;

            unset($v->catalog_id);
            unset($v->catalog->id);
            unset($v->catalog->category_id);
            unset($v->catalog->category);

            return $v;
        });

        return response()->json([
            'status' => true, 
            'msg' => 'Successfully login',
            'data' => [
                'token' => $token,
                'user' => $user
        ]], 200);
    }

    public function inject_verifying_account(Request $request){
        if(!$user = User::where('email', $request->email)->first()){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        $user->status = 'verified';
        $user->save();

        return response()->json(['status' => true], 200);
    }

    public function verifying_account(Request $request){

    }

    public function resend_verification_email(Request $request){

    }

    # Register
    # params $request
    # return json
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
            'data' => $user
        ], 200);
    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }

    # Get user address
    # return json
    public function get_address(){
        $user = JWTAuth::parseToken()->authenticate();

        $address = collect($user->address)->map(function($v, $k){
            unset($v->user_id);

            return $v;
        })->all();

        return response()->json([
            'status' => true,
            'msg' => 'address added successfully.',
            'data' => $address
        ]);
    }

    # Register user address
    # params $request
    # return json
    public function store_address(Request $request){
        $validator  = Validator::make($request->all(), [
            'address' => 'required|min:8',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required|min:5',
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $user = JWTAuth::parseToken()->authenticate();

        $address = new UserAdress;

        $address->user_id = $user->id;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->province = $request->province;
        $address->postal_code = $request->postal_code;
        $address->status = $user->address->count() ? 0 : 1;

        $address->save();

        unset($address->user_id);

        return response()->json([
            'status' => true,
            'msg' => 'address added successfully.',
            'data' => $address
        ]);
    }

    # Update user address
    # params $request
    # return json
    public function update_address(Request $request, $id){
        $validator  = Validator::make($request->all(), [
            'address' => 'required|min:8',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required|min:5',
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $user = JWTAuth::parseToken()->authenticate();

        if(! $address = $user->address->where('id', $id)->first()){
            return $this->responseError('Address Not Found!', StatusCodes::NOT_FOUND);
        }

        $address->address = $request->address;
        $address->city = $request->city;
        $address->province = $request->province;
        $address->postal_code = $request->postal_code;

        $address->save();

        unset($address->user_id);

        return response()->json([
            'status' => true,
            'msg' => 'address added successfully.',
            'data' => $address
        ]);
    }

    # make user address as shipping address
    # params $request
    # return json
    public function make_shipping_address(Request $request, $id){
        $user = JWTAuth::parseToken()->authenticate();

        $address = UserAdress::findOrFail($id);

        DB::table('user_address')
            ->where('user_id', $user->id)
            ->update(['status' => 0]);
        
        $address->status = 1;
        $address->save();

        return response()->json([
            'status' => true,
            'msg' => 'shipping address set successfully.'
        ]);
    }

    # delete user address
    # params $request
    # return json
    public function delete_address(Request $request, $id){
        $user = JWTAuth::parseToken()->authenticate();

        $address = UserAdress::findOrFail($id);

        $is_shipping_address = $address->status;

        $address->delete();

        if($is_shipping_address){
            $address = $user->address->first();

            $address->status = 1;

            $address->save();
        }

        return response()->json([
            'status' => true,
            'msg' => 'shipping address set successfully.'
        ]);
    }
}