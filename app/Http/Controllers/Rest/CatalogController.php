<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\ErrorResponses;
use App\Http\StatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Catalog;

use Image, Storage;

class CatalogController extends Controller
{
    use ErrorResponses;

    public function get_all(Request $request){
        $cat = Catalog::select(['name', 'category_id', 'description', 'slug', 'image', 'price', 'stock', 'discount', 'discount_type', 'rate', 'updated_at'])->get();

        $cat = collect($cat)->map(function($v, $k){
            $image = $v->image;

            $v->category_name = $v->category->name;

            unset($v->category);
            unset($v->category_id);

            $v->image = url('catalog/image/') . '/' . $image;
            $v->image_small = url('catalog/image/') . '/' . $image . '/sm';

            return $v;
        });

        return response()->json(['status' => true, 'data' => $cat, 'total' => $cat->count()], 200)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function show($id){
        if(! $product = Catalog::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        return response()->json(['status' => true, 'data' => $product], 200);
    }

    public function detail($slug){
        if(! $product = Catalog::where('slug', $slug)->first() ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        # show product category
        $product->category_name = $product->category->name;

        unset($product->category);
        unset($product->category_id);

        return response()->json(['status' => true, 'data' => $product], 200);
    }

    public function generate_image($file = '', $size = ''){
        $path = '/catalog/image';

        ini_set('memory_limit', '-1');

        if($size == 'sm'){
            $path .= '_sm';
            $file = str_replace('.jpg', '-sm.jpg', $file);
        }

        if (EMPTY($file)) return redirect()->back();

        if (file_exists(storage_path() . $path . '/' . $file)) {
            return Image::make(storage_path() . $path . '/' . $file)->response();
        } else {
            return Image::make(storage_path() . $path . '/' . 'no-image.png')->response();
        }
    }

    public function store(Request $request){
        $validator  = Validator::make($request->all(), [
            'name' => 'required|min:5|unique:catalogs,name',
            'description' => 'required|min:5',
            'category' => 'required|exists:category,id',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'tags' => 'nullable|max:191',
            'price' => 'required|numeric|min:1000',
            'stock' => 'numeric',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:percentage,value',
            'discount_description' => 'nullable|min:5',
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $product = new Catalog;

        $product->name = $request->name;
        $product->description = $request->description;
        $product->slug = str_slug(str_replace('&', '-and', str_replace('+', '-plus', $request->name)), '-');
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->stock = $request->stock ?: 0;
        $product->discount = $request->discount ?: 0;
        $product->discount_type = $request->{'discount-type'};
        $product->discount_description = $request->discount_description;

        # save image
        $filename = 'img-' . str_random(5) . uniqid('-');
        $product->image = $filename . '.jpg';

        # save tags
        $product->tags = $request->tags;

        if($product->save()){
            # save original picture
            $request->file('image')->storeAs('image', $product->image, 'catalog');

            # save resized picture
            $image = Image::make(storage_path('catalog/image/' . $product->image));
            $image->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save(storage_path('catalog/image_sm/' . $filename . '-sm.jpg'));
        }

        return response()->json(['status' => true, 'data' => $product], 200);
    }

    public function update(Request $request, $id){
        if(! $product = Catalog::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        $validator  = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'description' => 'required|min:5',
            'category' => 'required|exists:category,id',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'tags' => 'nullable|max:191',
            'price' => 'required|numeric|min:1000',
            'stock' => 'numeric',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:percentage,value',
            'discount_description' => 'nullable|min:5',
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->slug = str_slug(str_replace('&', '-and', str_replace('+', '-plus', $request->name)), '-');
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->stock = $request->stock ?: 0;
        $product->discount = $request->discount ?: 0;
        $product->discount_type = $request->{'discount-type'};
        $product->discount_description = $request->discount_description;

        # save image
        $filename = str_replace('.jpg', '', $product->image);

        # save tags
        $product->tags = $request->tags;

        if($product->save()){
            # save original picture
            $request->file('image')->storeAs('image', $product->image, 'catalog');

            # save resized picture
            $image = Image::make(storage_path('catalog/image/' . $product->image));
            $image->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save(storage_path('catalog/image_sm/' . $filename . '-sm.jpg'));
        }

        return response()->json(['status' => true, 'data' => $product], 200);
    }

    public function set_promo(Request $request, $id){
        if(! $product = Catalog::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        $validator  = Validator::make($request->all(), [
            'discount' => 'required|numeric|min:1',
            'discount_type' => 'required|in:percentage,value',
            'discount_description' => 'nullable|min:5',
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->discount_description = $request->discount_description;

        $product->save();

        return response()->json(['status' => true], 200);
    }

    public function change_price(Request $request, $id){
        if(! $product = Catalog::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        $validator  = Validator::make($request->all(), [
            'price' => 'required|numeric|min:10000',
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $product->price = $request->price;

        $product->save();

        return response()->json(['status' => true], 200);
    }

    public function add_stock(Request $request, $id){
        if(! $product = Catalog::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        $validator  = Validator::make($request->all(), [
            'stock' => 'required|numeric|min:1',
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $product->stock += $request->stock;

        $product->save();

        return response()->json(['status' => true], 200);
    }

    public function delete(Request $request, $id){
        if(! $product = Catalog::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        if($product->delete()){
            return response()->json(['status' => true], 200);
        }

        return $this->responseError('Something wrong!', StatusCodes::BAD_REQUEST);
    }
}