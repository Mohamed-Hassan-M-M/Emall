<div class="form-group">
    <label for="code">{{__('admin.coupon_code')}}  <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">#</span>
        </div>
        <input type="text" class="form-control @if($errors->has('code')) is-invalid @endif"
               id="code" placeholder="SAVE40" value="{{ old('code', (isset($coupon))?$coupon->code:'')}}"
               name="code">
        @if($errors->has('code'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('code') }}</strong>
        </span>
        @endif
    </div>

</div>
@foreach($languages as $item)
<div class="tab-pane {{($item->code==app()->getLocale())?'active':''}}" id="{{$item->code}}">
    @include('admin.coupons.translatable-fields')
</div> 
@endforeach

<div class="form-group">
    <label for="offer">{{__('admin.offer')}} (in %)  <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="number" step="1" id="offer" value="{{ old('offer', (isset($coupon))?$coupon->offer:'')}}"
               class="form-control @if($errors->has('offer')) is-invalid @endif"
               name="offer"
               placeholder="Offer"/>
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon1">%</span>
        </div>
        @if($errors->has('offer'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('offer') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group mb-3">
    <label for="min_order">{{__('admin.min_order')}} <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">{{\App\Helpers\AppSetting::$currencySign}}</span>
        </div>
        <input type="number" min="0" max="1000" step="1"
               class="form-control @if($errors->has('min_order')) is-invalid @endif" name="min_order"
               id="min_order" value="{{ old('min_order', (isset($coupon))?$coupon->min_order:'')}}"
               placeholder="{{__('admin.min_order')}}">

        @if($errors->has('min_order'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('min_order') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group mb-3">
    <label for="max_discount">{{__('admin.max_discount')}} <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">{{\App\Helpers\AppSetting::$currencySign}}</span>
        </div>
        <input type="number" min="0" max="1000" step="1"
               class="form-control @if($errors->has('max_discount')) is-invalid @endif" name="max_discount"
               id="max_discount" value="{{ old('max_discount', (isset($coupon))?$coupon->max_discount:'')}}"
               placeholder="{{__('admin.max_discount')}}">

        @if($errors->has('max_discount'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('max_discount') }}</strong>
        </span>
        @endif
    </div>
</div>




<div class="form-group">
    <label for="expired_at">{{__('admin.expired_at')}}</label>
    <input type="date" id="expired_at" min="{{now()->addDays(1)->format('Y-m-d')}}"
           value="{{ old('expired_at', (isset($coupon))?$coupon->expired_at:'')}}" name="expired_at"
           class="form-control @if($errors->has('expired_at')) is-invalid @endif">
    @if($errors->has('expired_at'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('expired_at') }}</strong>
    </span>
    @endif
</div>




