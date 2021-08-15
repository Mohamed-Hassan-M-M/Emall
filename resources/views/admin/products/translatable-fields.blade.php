<div class="form-group mt-0">
    <label for="name_{{$item->code}}">{{__('admin.category_'.$item->code)}}</label>
    <input type="text" class="form-control @if($errors->has('name_'.$item->code)) is-invalid @endif" id="name_{{$item->code}}" placeholder="{{__('admin.category_'.$item->code)}}" name="name_{{$item->code}}" value="{{ old('name_'.$item->code, (isset($product))?$product->getTranslation('name', $item->code):'')}}">
    @if($errors->has('name_'.$item->code))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name_'.$item->code) }}</strong>
    </span>
    @endif
</div>

<div class="form-group">
    <label for="description_{{$item->code}}">{{__('admin.description_'.$item->code)}}</label>
    <textarea name="description_{{$item->code}}" id="{{__('admin.description_'.$item->code)}}" class="summernote form-control @if($errors->has('description_'.$item->code)) is-invalid @endif"
              placeholder="Description_{{$item->code}}">{{ old('description_'.$item->code, (isset($product))?$product->getTranslation('description', $item->code):'')}}</textarea>
    @if($errors->has('description_'.$item->code))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('description_'.$item->code) }}</strong>
    </span>
    @endif
</div>
