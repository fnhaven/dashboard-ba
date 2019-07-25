<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\ErrorResponses;
use App\Http\StatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Wishlist;
use App\Catalog;

use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class WishlistController extends Controller
{
    use ErrorResponses;

    public function add(Request $request){
        $validator  = Validator::make($request->all(), [
            'slug' => 'required|exists:catalogs,slug'
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $user = JWTAuth::parseToken()->authenticate();
        $catalog = Catalog::where('slug', $request->slug)->first();

        if($wish = $user->wishlist->where('catalog_id', $catalog->id)->first()){
            return response()->json([
                'status' => true,
                'msg' => 'wish already added.',
                'data' => $wish
            ], 500);
        }

        $wish = new Wishlist;

        $wish->user_id = $user->id;
        $wish->catalog_id = $catalog->id;

        $wish->save();

        return response()->json([
            'status' => true,
            'msg' => 'product added to wishlist.',
            'content' => $wish,
        ], 200);
    }

    public function remove(Request $request, $id){
        $user = JWTAuth::parseToken()->authenticate();

        if(!$wish = $user->wishlist->where('id', $id)->first()){
            return response()->json([
                'status' => false,
                'msg' => 'wishlist not found.'
            ], 404);
        }

        $wish->delete();

        return response()->json([
            'status' => true,
            'msg' => 'wishlist removed.'
        ], 200);
    }
}