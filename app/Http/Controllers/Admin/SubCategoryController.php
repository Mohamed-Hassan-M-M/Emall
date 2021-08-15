<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller {

    public function index() {
        $subCategories = SubCategory::with('category')->orderBy('updated_at', 'DESC')->paginate(10);
        // return $subCategories;
        return view('admin.sub-categories.sub-categories')->with([
                    'sub_categories' => $subCategories
        ]);
    }

    public function create() {
        $categories = Category::all();
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        return view('admin.sub-categories.create-sub-category', compact('languages', 'categories'));
    }

    public function store(Request $request) {
        $validation_arr = \App\Helpers\ValidationRules::getValidation(['title', 'description']);
        $this->validate($request, array_merge([
            'category' => 'required',
                        ], $validation_arr)
        );
        $data = $request->except(['category', '_token']);
        $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['title', 'description'], $data);
        $sub_category_data = array_merge([
            'category_id' => $request->category,
                ], $stored_array);
        $subCategory = SubCategory::create($sub_category_data);
        if ($subCategory->save()) {
            return redirect()->route('admin.sub-categories.index')->with('message', trans('admin.sub_category_created'));
        } else {
            return redirect()->route('admin.sub-categories.index')->with('error', trans('admin.something_wrong'));
        }
    }

    public function show($id) {
        
    }

    public function edit($id) {
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        $subCategory = SubCategory::with('category')->find($id);
        $categories = Category::all();
        return view('admin.sub-categories.edit-sub-category', compact('languages', 'subCategory','categories'));
    }

    public function update(Request $request, $id) {
        $validation_arr = \App\Helpers\ValidationRules::getValidation(['title', 'description']);
        $this->validate($request, array_merge([
            'category' => 'required',
                        ], $validation_arr)
        );
        $data = $request->except(['category', '_token']);
        $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['title', 'description'], $data);
        $sub_category_data = array_merge([
            'category_id' => $request->category,
                ], $stored_array);

        $subcategory = SubCategory::find($id);
        $subcategory->title = $sub_category_data['title'];
        $subcategory->description = $sub_category_data['description'];
        $subcategory->category_id = $sub_category_data['category_id'];
        if ($subcategory->save()) {
            return redirect(route('admin.sub-categories.index'))->with('message', trans('admin.sub_category_updated'));
        }
        return redirect(route('admin.sub-categories.index'))->with('error', trans('admin.something_wrong'));
    }

    public function destroy($id) {
        
    }

}
