<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 mb-2">
                <h4 class="card-title">{{__('admin.general')}}</h4>
            </div>

            <div class="col-12 mb-3">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <label for="image">{{__('admin.image')}}</label>
                        <input type="file" name="image" id="image" data-plugins="dropify"
                               data-default-file="{{isset($shop)?asset('/storage/'.$shop->image_url):''}}"
                               class="form-control"/>
                        <p class="text-muted text-center mt-2 mb-0">{{__('admin.upload_image')}}</p>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="row">
                          <div class="col-12">
                            <div class="tab-content clearfix">
                                    @foreach($languages as $item)
                                    <div class="tab-pane {{($item->code==app()->getLocale())?'active':''}}" id="{{$item->code}}">
                                        @include('admin.shops.translatable-fields')
                                    </div> 
                                    @endforeach
                                </div></div>
                                <div class="col-12">
                                    <div class="form-group mt-0">
                                        <label for="email">{{__('admin.email')}}</label>
                                        <input type="text"
                                               class="form-control @if($errors->has('email')) is-invalid @endif"
                                               id="email" placeholder="Email" name="email"
                                               value="{{ old('email', (isset($shop))?$shop->email:'')}}">
                                        @if($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mt-0">
                                        <label for="mobile">{{__('admin.mobile')}}</label>
                                        <input type="tel" pattern="[0-9]{10}"
                                               class="form-control @if($errors->has('mobile')) is-invalid @endif"
                                               id="mobile" placeholder="091-8469435337" name="mobile"
                                               value="{{ old('mobile', (isset($shop))?$shop->mobile:'')}}">
                                        @if($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-2">
                    <h4 class="card-title">{{__('admin.location')}}</h4>
                </div>



                <div class="col-12 col-md-6">
                    <div class="form-group mt-0">
                        <label for="latitude">{{__('admin.latitude')}}</label>
                        <input type="text"
                               class="form-control @if($errors->has('latitude')) is-invalid @endif"
                               id="latitude" placeholder="Latitude" name="latitude"
                               value="{{ old('latitude', (isset($shop))?$shop->latitude:'')}}">
                        @if($errors->has('latitude'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('latitude') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group mt-0">
                        <label for="longitude">{{__('admin.longitude')}}</label>
                        <input type="text"
                               class="form-control @if($errors->has('longitude')) is-invalid @endif"
                               id="longitude" placeholder="Longitude" name="longitude"
                               value="{{ old('longitude', (isset($shop))?$shop->longitude:'')}}">
                        @if($errors->has('longitude'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('longitude') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-2">
                    <h4 class="card-title">{{__('manager.delivery_boy')}}</h4>
                </div>


                <div class="col-12 col-md-6">
                    <div class="custom-checkbox custom-control">
                        <input class="custom-control-input" type="checkbox" id="available_for_delivery"
                               name="available_for_delivery" {{(isset($shop))?($shop->available_for_delivery)?'checked':'':''}}>
                        <label class="custom-control-label"
                               for="available_for_delivery">{{__('manager.available_for_delivery')}}</label>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group mt-0">
                        <label for="delivery_range">{{__('manager.delivery_range')}}</label>
                        <div class="input-group">

                            <input type="number" step="1" min="0"
                                   class="form-control @if($errors->has('delivery_range')) is-invalid @endif"
                                   id="delivery_range" placeholder="Delivery Range" name="delivery_range" value="{{ old('delivery_range', (isset($shop))?$shop->delivery_range:'')}}">
                            @if($errors->has('delivery_range'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('delivery_range') }}</strong>
                            </span>
                            @endif

                            <div class="input-group-append">
                                <span class="input-group-text"
                                      id="basic-addon1">Meter</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group mt-0">
                        <label for="minimum_delivery_charge">{{__('manager.minimum_delivery_charge')}}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                      id="basic-addon1">{{\App\Helpers\AppSetting::$currencySign}}</span>
                            </div>
                            <input type="number" step="1" min="0"
                                   class="form-control @if($errors->has('minimum_delivery_charge')) is-invalid @endif"
                                   id="minimum_delivery_charge" placeholder="{{__('manager.minimum_delivery_charge')}}" name="minimum_delivery_charge" value="{{ old('minimum_delivery_charge', (isset($shop))?$shop->minimum_delivery_charge:'')}}">
                            @if($errors->has('minimum_delivery_charge'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('minimum_delivery_charge') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group mt-0">
                        <label for="delivery_cost_multiplier">{{__('manager.delivery_cost_multiplier')}}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                      id="basic-addon1">{{\App\Helpers\AppSetting::$currencySign}}</span>
                            </div>
                            <input type="number" step="1" min="0"
                                   class="form-control @if($errors->has('delivery_cost_multiplier')) is-invalid @endif"
                                   id="delivery_cost_multiplier" placeholder="{{__('manager.delivery_cost_multiplier')}}" name="delivery_cost_multiplier" value="{{ old('delivery_cost_multiplier', (isset($shop))?$shop->delivery_cost_multiplier:'')}}">
                            @if($errors->has('delivery_cost_multiplier'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('delivery_cost_multiplier') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-2">
                    <h4 class="card-title">{{__('manager.other')}}</h4>
                </div>

                <div class="col-12 col-md-12 mb-3">
                    <div class="custom-checkbox custom-control">
                        <input class="custom-control-input" type="checkbox" name="open" id="open" {{(isset($shop))?($shop->open)?'checked':'':''}}>
                        <label class="custom-control-label" for="open">{{__('manager.open')}}</label>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group mt-0">
                        <label for="default_tax">{{__('manager.default_tax')}}</label>
                        <div class="input-group">
                            <input type="number" step="1" min="0"
                                   class="form-control @if($errors->has('default_tax')) is-invalid @endif"
                                   id="default_tax" placeholder="Default Tax" name="default_tax" value="{{ old('default_tax', (isset($shop))?$shop->default_tax:'')}}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                            @if($errors->has('default_tax'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('default_tax') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group mt-0">
                        <label for="admin_commission">{{__('manager.admin_commission')}}</label>
                        <div class="input-group">
                            <input type="number" step="1"
                                   class="form-control"
                                   id="admin_commission" placeholder="{{__('manager.admin_commission')}}" name="admin_commission" value="{{ old('admin_commission', (isset($shop))?$shop->admin_commission:'')}}">
                            <div class="input-group-append">
                                <span class="input-group-text"
                                      id="basic-addon1">%</span>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>


  