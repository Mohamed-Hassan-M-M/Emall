<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;

        $addresses =  User::find($user_id)->addresses;
        return view('user.addresses.addresses')->with([
            'addresses'=>$addresses
        ]);
    }

    public function create()
    {
        return view('user.addresses.create-address');
    }


    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $this->validate($request,[
           'longitude'=>'required',
           'latitude'=>'required',
           'address'=>'required',
           'city'=>'required',
           'pincode'=>'required',
        ]);

        $address = new UserAddress();
        $address->longitude = $request->longitude;
        $address->latitude = $request->latitude;
        $address->address = $request->address;
        $address->address2 = $request->address2;
        $address->city = $request->city;
        $address->pincode = $request->pincode;
        $address->user_id = $user_id;

        if ($address->save()) {
            return redirect()->back()->with([
                'message' => trans('user.address_added')
            ]);
        }
        return redirect()->back()->with([
            'error' => trans('user.something_wrong')
        ]);
    }

    public function show($id)
    {
    }


    public function edit($id)
    {

    }


    public function update(Request $request)
    {

    }


    public function destroy($id){

        $userAddress = UserAddress::find($id);
        if($userAddress->delete()){
            return response(['message' => trans('user.address_deleted')], 200);
        }else{
            return response(['errors' => ['Something wrong']], 403);
        }


    }

}
