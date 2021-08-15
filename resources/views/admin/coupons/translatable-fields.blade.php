<div class="form-group">
    <label for="description_{{$item->code}}">{{__('admin.description_'.$item->code)}}</label>
    <textarea name="description_{{$item->code}}" id="description_{{$item->code}}" class="form-control @if($errors->has('description_'.$item->code)) is-invalid @endif"
              placeholder="{{__('admin.description_'.$item->code)}}">{{ old('description_'.$item->code, (isset($coupon))?$coupon->getTranslation('description', $item->code):'')}}</textarea>
    @if($errors->has('description_'.$item->code))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('description_'.$item->code) }}</strong>
    </span>
    @endif
</div>
