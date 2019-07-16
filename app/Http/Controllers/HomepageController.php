<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Category;
use App\Catalog;
use App\User;

use Auth;

class HomepageController extends Controller
{
    protected $title = 'this is dashboard';

    public function __construct(){
        $this->title = 'this is dashboard';
    }
    
    /**
     * Login Page
     *
     * @return page view
    */
    public function login(){
        // dd(User::all());
        return view('login.index', [
            'title' => $this->title
        ]);
    }

    /**
     * Dashboard Homepage
     *
     * @return page view
    */
    public function index(){
        return view('dashboard._content', [
            'title' => $this->title
        ]);
    }

    /**
     * Catalog Page
     *
     * @return page view
    */
    public function catalog(){
        $category = Category::select(['id', 'name'])->where('depth', 3)->get();
        $catalog = Catalog::offset(0)
            ->limit(12)
            ->get();;

        return view('catalog.index', [
            'title' => $this->title,
            'categories' => $category,
            'catalogs' => $catalog,
        ]);
    }

    /**
     * Category Page
     *
     * @return page view
    */
    public function category(){
        $category = \App\Category::where('depth', 1)->get();

        return view('category.index', [
            'title' => $this->title,
            'category' => $category,
        ]);
    }
}