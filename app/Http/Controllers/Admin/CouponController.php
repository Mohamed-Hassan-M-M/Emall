<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller {

    public function index() {
        $coupons = Coupon::orderBy('expired_at', 'ASC')->paginate(10);
        return view('admin.coupons.coupons')->with([
                    'coupons' => $coupons
        ]);
    }

    public function create() {
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        return view('admin.coupons.create-coupon', compact('languages'));
    }

    public function store(Request $request) {
        $validation_arr = \App\Helpers\ValidationRules::getValidation(['description']);
        $this->validate($request, array_merge([
            'code' => 'required|unique:coupons',
            'offer' => 'required|numeric|max:100|min:0"',
            'expired_at' => 'required|date|after:now',
            'min_order' => 'required',
            'max_discount' => 'required'], $validation_arr)
        );
        $data = $request->except(['code', 'offer', 'expired_at', 'min_order', 'max_discount', '_token']);
        $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['description'], $data);
        $coupon = new Coupon();
        $coupon->code = $request->get('code');
        $coupon->description = $stored_array['description'];
        $coupon->offer = $request->get('offer');
        $coupon->min_order = $request->get('min_order');
        $coupon->max_discount = $request->get('max_discount');
        $coupon->expired_at = $request->get('expired_at');
        if (isset($request->for_new_user)) {
            $coupon->for_new_user = true;
        } else {
            $coupon->for_new_user = false;
        }
        if (isset($request->for_new_user)) {
            $coupon->for_only_one_time = true;
        } else {
            $coupon->for_only_one_time = false;
        }

        if ($coupon->save()) {
            return redirect(route('admin.coupons.index'))->with('message',trans('admin.coupon_created') );
        } else {
            return redirect(route('admin.coupons.index'))->with('error', trans('admin.something_wrong'));
        }
    }

    public function show($id) {
        
    }

    public function edit($id) {
        $coupon = Coupon::find($id);
        $languages = \App\Models\Language::select('code', 'name', 'id')->get();
        return view('admin.coupons.edit-coupon', compact('languages', 'coupon'));
    }

    public function update(Request $request, $id) {
        $validation_arr = \App\Helpers\ValidationRules::getValidation(['description']);
        $this->validate($request, array_merge([
            'code' => 'required|unique:coupons,code,'. $id,
            'offer' => 'required|numeric|max:100|min:0"',
            'expired_at' => 'required|date|after:now',
            'min_order' => 'required',
            'max_discount' => 'required'], $validation_arr)
        );

        $data = $request->except(['code', 'offer', 'expired_at', 'min_order', 'max_discount', '_token']);
        $stored_array = \App\Helpers\GettingMultiLanguagesFields::getmultilanguage(['description'], $data);
        $coupon = Coupon::find($id);
        $coupon->code = $request->get('code');
        $coupon->offer = $request->get('offer');
        $coupon->min_order = $request->get('min_order');
        $coupon->max_discount = $request->get('max_discount');
        $coupon->description = $stored_array['description'];
        $coupon->expired_at = $request->get('expired_at');
        if (isset($request->is_active)) {
            $coupon->is_active = true;
        } else {
            $coupon->is_active = false;
        }
        if ($coupon->save()) {
            return redirect(route('admin.coupons.index'))->with('message',trans('admin.coupon_updated'));
        } else {
            return redirect(route('admin.coupons.index'))->with('error', trans('admin.something_wrong'));
        }
    }

    public function destroy($id) {
        
    }

}
