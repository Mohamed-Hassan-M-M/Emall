<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manager\ProductItemController;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class ProductController extends Controller {

    //Todo: Add auth validations

    public function index() {
        $products = Product::with('productImages', 'productItems', 'productItems.productItemFeatures')->orderBy('active', "DESC")->paginate(10);
        //return $products;


        return view('admin.products.products')->with([
                    'products' => $products
        ]);
    }

    public function create() {

        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        $categories = Category::all();

        $shop = auth()->user()->shop;
        if (!$shop) {
            return view('manager.error-page')->with([
                        'code' => 502,
                        'error' => 'You havn\'t any shop yet',
                        'message' => 'Please join any shop and then add product',
                        'redirect_text' => 'Join',
                        'redirect_url' => route('manager.shops.index')
            ]);
        }
        return view('admin.products.create-product', compact(['languages', 'categories']));
    }

    public function store(Request $request) {
        
    }

    static function validateItems($items): bool {
        foreach ($items as $item) {
            $productItemFeatures = $item['product_item_features'];
            for ($i = 0; $i < sizeof($productItemFeatures); $i++) {
                for ($j = $i + 1; $j < sizeof($productItemFeatures); $j++) {
                    if ($productItemFeatures[$i]["feature"] === $productItemFeatures[$j]["feature"])
                        return false;
                }
            }
        }
        return true;
    }

    public function show($id) {
        
    }

    public function edit($id) {
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        $product = Product::with('shop', 'productImages', 'productItems', 'productItems.productItemFeatures')->find($id);
        if ($product) {
            $categories = Category::with('subCategories')->get();
            return view('admin.products.edit-product', compact(['product', 'categories', 'languages']));
        }
        return view('manager.error-page')->with([
                    'code' => 502,
                    'error' => 'This is not your shop product',
                    'message' => 'Please go to your product then edit',
                    'redirect_text' => 'Go to Product',
                    'redirect_url' => route('manager.products.index')
        ]);
    }

    public function update(Request $request, $id) {
        $validation_arr = \App\Helpers\ValidationRules::getValidation(['name', 'description']);
        $this->validate($request, array_merge([
            'category' => 'required',
                        ], $validation_arr)
        );

        $items = array_values(json_decode($request->get('items'), true));
        if (self::validateItems($items)) {
            $data = $request->except(['image', '_token']);
            $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['name', 'description'], $data);
            $product = Product::find($id);
            $product->name = $stored_array['name'];
            $product->description = $stored_array['description'];
            $product->sub_category_id = $request->get('category');

            if (isset($request->active)) {
                $product->active = true;
            } else {
                Cart::where('product_id', '=', $product->id)->where('active', '=', true)->delete();
                $product->active = false;
            }

            if (isset($request->offer))
                $product->offer = $request->get('offer');
            else
                $product->offer = 0;

            if ($request->hasFile('image')) {
                ProductImage::updateImage($request, $product->id);
            }
            if ($product->save()) {
                ProductItemController::updateItems($product->id, $items);
                return redirect(route('admin.products.index'))->with([
                            'message' => trans('admin.product_updated')
                ]);
            } else {
                return redirect()->back()->with([
                            'error' => trans('admin.something_wrong')
                ]);
            }
        } else {
            return redirect()->back()->with([
                        'error' => trans('admin.product_items_not_valid')
            ]);
        }
    }

    public function destroy($id) {
        
    }

}
