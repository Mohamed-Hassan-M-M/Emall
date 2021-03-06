<?php

namespace App\Http\Controllers\Api\v1\DeliveryBoy;

use App\Helpers\AppSetting;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\ShopRevenue;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class DeliveryBoyController extends Controller
{


    public function create()
    {

    }


    public function store(Request $request)
    {

    }

    public function show($id)
    {
    }


    public function edit()
    {

    }


    public function update(Request $request)
    {



    }


    public function destroy($id)
    {

    }


    public function getAppData(){
        return response([
            'min_build_version'=>AppSetting::$DELIVERY_BOY_APP_MINIMUM_VERSION
        ]);
    }



    public function getAppDataWithDeliveryBoy(){

        return response([
            'min_build_version'=>AppSetting::$DELIVERY_BOY_APP_MINIMUM_VERSION,
            'delivery_boy'=>auth()->user()
        ]);
    }


}
