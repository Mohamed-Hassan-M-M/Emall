<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\Shop;
use App\Models\ShopRequest;
use App\Models\ShopReview;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {

        $shop = auth()->user()->shop;
        if ($shop) {
            return view('manager.shops.shop')->with([
                'have_shop' => true,
                'shop' => $shop
            ]);
        } else {
            $shopRequest = ShopRequest::where('manager_id', auth()->user()->id)->first();
            if ($shopRequest) {
                $shop = Shop::find($shopRequest->shop_id);
                return view('manager.shops.shop')->with([
                    'have_shop' => false,
                    'have_shop_request' => true,
                    'shop' => $shop,
                    'shop_request' => $shopRequest
                ]);
            }
            $shops = Shop::doesnthave('manager')->get();
            return view('manager.shops.shop')->with([
                'have_shop' => false,
                'have_shop_request' => false,
                'shops' => $shops
            ]);
        }

    }


    public function create()
    {

    }

    public function store(Request $request)
    {

        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|unique:shops',
                'mobile' => 'required|unique:shops',
                'description' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'image' => 'required',
                'delivery_range'=>'required',
                'minimum_delivery_charge'=>'required',
                'delivery_cost_multiplier'=>'required'
            ],
            [

            ]);

        $shop = new Shop();

        $path = $request->file('image')->store('shop_images', 'public');
        $shop->image_url = $path;
        $shop->name = $request->get('name');
        $shop->email = $request->get('email');
        $shop->mobile = $request->get('mobile');
        $shop->description = $request->get('description');
        $shop->address = $request->get('address');
        $shop->latitude = $request->get('latitude');
        $shop->longitude = $request->get('longitude');
        $shop->default_tax = $request->get('default_tax');
        $shop->minimum_delivery_charge = $request->get('minimum_delivery_charge');
        $shop->delivery_cost_multiplier = $request->get('delivery_cost_multiplier');
        $shop->delivery_range = $request->get('delivery_range');
        if ($request->get('available_for_delivery')) {
            $shop->available_for_delivery = true;
        } else {
            $shop->available_for_delivery = false;
        }

        if ($request->get('open')) {
            $shop->open = true;
        } else {
            $shop->open = false;
        }

        if ($shop->save()) {
            return redirect(route('manager.shops.index'))->with([
                'message' => trans('manager.shop_created')
            ]);
        } else {
            return redirect(route('manager.shops.index'))->with([
                'error' => trans('manager.something_wrong')
            ]);
        }

    }

    public function show($id)
    {
    }


    public function edit($id)
    {
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        $manager = Manager::find(auth()->user()->id);
        if ($manager->shop) {
            if ($manager->shop->id == $id) {
                $shop = Shop::find($id);
                return view('manager.shops.edit-shop',compact('languages','manager','shop'));
            } else {
                return abort(401);
            }
        }else{
            return redirect(route('manager.shops.index'));
        }

    }


    public function update(Request $request, $id)
    {
               $validation_arr = \App\Helpers\ValidationRules::getValidation(['name', 'description', 'address']);
        $this->validate($request, array_merge([
            'email' => 'required|unique:shops,email,'. $id,
            'mobile' => 'required|unique:shops,mobile,'. $id,
            'latitude' => 'required',
            'longitude' => 'required',
            'delivery_range' => 'required',
            'minimum_delivery_charge' => 'required',
            'delivery_cost_multiplier' => 'required'
                        ], $validation_arr)
        );
        $data = $request->except(['image', '_token', 'email', 'mobile', 'latitude', 'longitude', 'delivery_range', 'minimum_delivery_charge', 'delivery_cost_multiplier', 'default_tax', 'admin_commission']);
        $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['name', 'description', 'address'], $data);
        $shop = Shop::find($id);

        if ($request->hasFile('image')) {
            Shop::updateShopImage($request, $id);
        }

        $shop->name = $stored_array['name'];
        $shop->email = $request->get('email');
        $shop->mobile = $request->get('mobile');
        $shop->description = $stored_array['description'];
        $shop->address = $stored_array['address'];
        $shop->latitude = $request->get('latitude');
        $shop->longitude = $request->get('longitude');
        $shop->default_tax = $request->get('default_tax');
        $shop->minimum_delivery_charge = $request->get('minimum_delivery_charge');
        $shop->delivery_cost_multiplier = $request->get('delivery_cost_multiplier');
        $shop->delivery_range = $request->get('delivery_range');

        if ($request->get('available_for_delivery')) {
            $shop->available_for_delivery = true;
        } else {
            $shop->available_for_delivery = false;
        }

        if ($request->get('open')) {
            $shop->open = true;
        } else {
            $shop->open = false;
        }

        if ($shop->save()) {
            return redirect()->back()->with([
                'message' => trans('manager.shop_updated')
            ]);
        } else {
            return redirect()->back()->with([
                'error' => trans('manager.something_wrong')
            ]);
        }
    }


    public function destroy($id)
    {

    }


    public function showReviews($id){
        $shop = Shop::find($id);
        $managerId = auth()->user()->id;

        if($shop){

            if($shop->manager_id == $managerId){

                $shopReviews = ShopReview::with('user')->where('shop_id','=',$shop->id)->get();
                return view('manager.shops.shop-reviews')->with([
                    'shopReviews'=>$shopReviews
                ]);




            }else{
                return view('manager.error-page')->with([
                    'code' => 502,
                    'error' => 'This shop is not for your',
                    'message' => 'Please go to your shop',
                    'redirect_text' => 'Go to shop',
                    'redirect_url' => route('manager.shops.index')
                ]);
            }

        }else{
            return view('manager.error-page')->with([
                'code' => 502,
                'error' => 'This shop is not available',
                'message' => 'Please go to your shop',
                'redirect_text' => 'Go to shop',
                'redirect_url' => route('manager.shops.index')
            ]);
        }



    }



}
