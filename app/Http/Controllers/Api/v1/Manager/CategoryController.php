<?php

namespace App\Http\Controllers\Api\v1\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        \App::setLocale($request->lang);
        $category=Category::with('subCategories')->get()->toArray();        return $category;
    }

}
