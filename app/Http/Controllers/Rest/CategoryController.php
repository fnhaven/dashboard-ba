<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\ErrorResponses;
use App\Http\StatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Category;

class CategoryController extends Controller
{
    use ErrorResponses;

    public function get_all(){
        $cats = Category::where('depth', 1)->get();
        $data = [];

        foreach($cats as $index => $cat):
            $data[] = [
                'name' => $cat->name,
                'slug' => $cat->slug,
                'pinned' => $cat->pinned == 1,
                'content' => []
            ];
            foreach($cat->childrens as $i => $subcat):
                $data[$index]['content'][] = [
                    'name' => $subcat->name,
                    'slug' => $subcat->slug,
                    'pinned' => $subcat->pinned == 1,
                    'content' => []
                ];
                foreach($subcat->childrens as $i2 => $subcontent):
                    $data[$index]['content'][$i]['content'][] = [
                        'name' => $subcontent->name,
                        'slug' => $subcontent->slug,
                        'pinned' => $subcontent->pinned == 1
                    ];
                endforeach;
            endforeach;
        endforeach;

        return response()->json(['status' => true, 'data' => $data], 200)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function get_pinned(){
        if(! $category = Category::select(['name', 'pinned', 'slug', 'depth'])->where('pinned', true)->get() ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        return response()->json(['status' => true, 'data' => $category], 200)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function show($id){
        if(! $category = Category::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        return response()->json(['status' => true, 'data' => $category], 200)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function store(Request $request){
        $validator  = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:category,name'
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $category = new Category;
        $max = 0;

        $category->name = $request->name;
        $category->slug = str_slug(str_replace('+', '-plus', $request->name), '-');
        $category->pinned = 0;

        if($request->parent_id){
            $category->parent_id = $request->parent_id;
            $category->depth = $request->depth + 1;
        }

        $category->save();

        return response()->json(['status' => true, 'data' => $category], 200);
    }

    public function update(Request $request, $id){
        if(! $category = Category::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        $validator  = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:category,name,' . $id
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $category->name = $request->name;
        $category->slug = str_slug(str_replace('+', '-plus', $request->name), '-');

        $category->save();

        return response()->json(['status' => true, 'data' => $category], 200);
    }

    public function pinned($id){
        if(! $category = Category::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }
        
        $category->pinned = !$category->pinned;

        $category->save();

        return response()->json(['status' => true, 'data' => $category], 200);
    }

    public function delete(Request $request, $id){
        if(! $category = Category::find($id) ){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        if($category->delete()){
            return response()->json(['status' => true]);
        }

        return $this->responseError('Something wrong!', StatusCodes::BAD_REQUEST);
    }
}