<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\ErrorResponses;
use App\Http\StatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Article;

class ArticleController extends Controller
{
    use ErrorResponses;

    public function get_all(){
        $art = Article::select(['title', 'content', 'image', 'updated_at'])->get();

        return response()->json(['status' => true, 'data' => $art]);
    }

    public function read($slug){
        if(!$article = Article::where('slug', $slug)->first()){
            return $this->responseError('Not Found!', StatusCodes::NOT_FOUND);
        }

        return response()->json(['status' => true, 'data' => $article]);
    }

    public function store(Request $request){
        
    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }
}