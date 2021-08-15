<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class ProductController extends Controller {

    //Todo: Add auth validations

    public function index() {
        $shop = auth()->user()->shop;
        if (!$shop) {
            return view('manager.error-page')->with([
                        'code' => 502,
                        'error' => 'You havn\'t any shop yet',
                        'message' => 'Please join any shop and then manage product',
                        'redirect_text' => 'Join',
                        'redirect_url' => route('manager.shops.index')
            ]);
        }

        $products = Product::with('productImages', 'productItems', 'productItems.productItemFeatures')->where("shop_id", "=", $shop->id)->orderBy('active', "DESC")->paginate(10);

        //return $products;
        return view('manager.products.products')->with([
                    'shop' => $shop,
                    'products' => $products
        ]);
    }

    public function create() {
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        $categories = Category::with('subCategories')->get();
        $features = \App\Models\Features::get();
        $subfeatures = \App\Models\SubFeatures::get();
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

        return view('manager.products.create-product', compact('languages', 'categories', 'features'));
    }

    public function getSubFeatures(Request $request) {
        $subfeature = \App\Models\SubFeatures::select('id', 'value')->where('feature_id', '=', $request->id)->get()->toArray();
        return \Illuminate\Support\Facades\Response::json($subfeature);
    }

    public function store(Request $request) {


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
        $validation_arr = \App\Helpers\ValidationRules::getValidation(['name', 'description']);
        $this->validate($request, array_merge([
            'category' => 'required',
            'items' => 'required'
                        ], $validation_arr)
        );



        $items = array_values(json_decode($request->get('items'), true));

        if (count($items) > 0) {
            $data = $request->except(['image', '_token']);
            $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['name', 'description'], $data);
            if (self::validateItems($items)) {
                $product = new Product();
                $product->name = $stored_array['name'];
                $product->description = $stored_array['description'];

                $subCategory = SubCategory::find($request->get('category'));

                $product->sub_category_id = $request->get('category');
                $product->category_id = $subCategory->category_id;

                if (isset($request->offer))
                    $product->offer = $request->get('offer');
                else
                    $product->offer = 0;

                $product->shop_id = $shop->id;
                $product->save();
                ProductItemController::addItemsWithClear($product->id, $items);
            } else {
                return redirect()->back()->with([
                            'error' => trans('manager.product_items_not_valid')
                ]);
            }
        } else {
            return redirect()->back()->with([
                        'error' => trans('manager.at_least_one_item')
            ]);
        }
        return redirect(route('manager.product-images.edit', ['id' => $product->id]));
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
        $shop = auth()->user()->shop;
        if (!$shop) {
            return view('manager.error-page')->with([
                        'code' => 502,
                        'error' => 'You havn\'t any shop yet',
                        'message' => 'Please join any shop and then manage product',
                        'redirect_text' => 'Join',
                        'redirect_url' => route('manager.shops.index')
            ]);
        }

        $product = Product::with('shop', 'productImages', 'productItems', 'productItems.productItemFeatures')->find($id);

        if ($product) {
            if ($shop->id === $product->shop->id) {
                $categories = Category::with('subCategories')->get();
                return view('manager.products.edit-product', compact(['languages', 'product', 'categories']));
            } else {
                return view('manager.error-page')->with([
                            'code' => 502,
                            'error' => 'This is not your shop product',
                            'message' => 'Please go to your product then edit',
                            'redirect_text' => 'Go to Product',
                            'redirect_url' => route('manager.products.index')
                ]);
            }
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

        $shop = auth()->user()->shop;
        if (!$shop) {
            return view('manager.error-page')->with([
                        'code' => 502,
                        'error' => 'You haven\'t any shop yet',
                        'message' => 'Please join any shop and then add product',
                        'redirect_text' => 'Join',
                        'redirect_url' => route('manager.shops.index')
            ]);
        }


        $validation_arr = \App\Helpers\ValidationRules::getValidation(['name', 'description']);
        $this->validate($request, array_merge([
            'category' => 'required',
            'items' => 'required'
                        ], $validation_arr)
        );



        $items = array_values(json_decode($request->get('items'), true));
        if (count($items) > 0) {

            if (self::validateItems($items)) {
                $data = $request->except(['image', '_token']);
                $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['name', 'description'], $data);
                $product = Product::find($id);
                $product->name = $stored_array['name'];
                $product->description = $stored_array['description'];
                $subCategory = SubCategory::find($request->get('category'));

                $product->sub_category_id = $request->get('category');
                $product->category_id = $subCategory->category_id;

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

                if ($product->save()) {
                    ProductItemController::updateItems($product->id, $items);
                    return redirect(route('manager.products.index'))->with([
                                'message' => trans('manager.product_updated')
                    ]);
                } else {
                    return redirect()->back()->with([
                                'error' => trans('manager.something_wrong')
                    ]);
                }
            } else {
                return redirect()->back()->with([
                            'error' => trans('manager.product_items_not_valid')
                ]);
            }
        } else {
            return redirect()->back()->with([
                        'error' => trans('manager.at_least_one_item')
            ]);
        }
    }

    public function destroy($id) {
        Product::destroy($id);
        return redirect(route('manager.products.index'))->with([
                    'message' => trans('manager.product_deleted')
        ]);
    }

    public function showReview($id) {
        $num = env('PAGINATE_NUM');
        $product = Product::find($id);
        $reviews = \App\Models\ProductReview::where('product_id', '=', $id)->paginate($num);
        return view('manager.products.review', compact('reviews', 'product'));
    }

    public function changeStaus(Request $request) {
        $product = Product::findorfail($request->id);
        if ($product) {
            if ($request->value == env('ACTIVE')) {
                $product->active = env('ACTIVE');
                $product->save();
            } elseif ($request->value == env('DEACTIVE')) {
                $product->active = env('DEACTIVE');
                $product->save();
            } else {
                return redirect('/manager/products')->with([
                            'error' => trans('manager.something_wrong')
                ]);
            }
            return redirect('/manager/products')->with([
                        'message' => trans('manager.product_updated')
            ]);
        }
    }

}
