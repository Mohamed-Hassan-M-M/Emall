<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeaturesController extends Controller {

    public function index() {
        $features = \App\Models\Features::orderBy('updated_at', 'DESC')->paginate(10);
        return view('admin.features.index')->with([
                    'features' => $features
        ]);
    }

    public function create() {
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        return view('admin.categories.create-category', compact('languages'));
    }

    public function store(Request $request) {
        $validation_arr = \App\Helpers\ValidationRules::getValidation(['title', 'description']);
        $this->validate($request, array_merge([
            'image' => 'required',
                        ], $validation_arr)
        );
        $data = $request->except(['image', '_token']);
        $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['title', 'description'], $data);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category_data = array_merge([
                'image_url' => $path,
                    ], $stored_array);
            $category = Category::create($category_data);
            if ($category) {
                return redirect()->route('admin.categories.index')->with('message', trans('admin.category_created'));
            } else {
                return redirect()->route('admin.categories.index')->with('error', trans('admin.something_wrong'));
            }
        }
        return redirect()->route('categories.index')->with('error', trans('admin.something_wrong'));
    }

    public function show($id) {
        
    }

    public function edit($id) {
        $category = Category::find($id);
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        return view('admin.categories.edit-category', compact('category', 'languages'));
    }

    public function update(Request $request, $id) {
        $validation_arr = \App\Helpers\ValidationRules::getValidation(['title', 'description']);
        $this->validate($request, $validation_arr);
        $data = $request->except(['image', '_token']);
        $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['title', 'description'], $data);
        $category = Category::find($id);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category->image_url = $path;
        }
        $category->title = $stored_array['title'];
        $category->description = $stored_array['description'];
        if ($category->save()) {
            return redirect(route('admin.categories.index'))->with('message', trans('admin.category_updated'));
        }
        return redirect(route('admin.categories.index'))->with('error', trans('admin.something_wrong'));
    }

    public function destroy($id) {
        
    }

}
