<div class="form-group mt-0">
    <label for="title_{{$item->code}}">{{__('admin.category_'.$item->code)}}</label>
    <input type="text" class="form-control @if($errors->has('title_'.$item->code)) is-invalid @endif" id="title_{{$item->code}}" placeholder="{{__('admin.category_'.$item->code)}}" name="title_{{$item->code}}" value="{{ old('title_'.$item->code, (isset($category))?$category->getTranslation('title', $item->code):'')}}">
    @if($errors->has('title_'.$item->code))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('title_'.$item->code) }}</strong>
    </span>
    @endif
</div>

<div class="form-group">
    <label for="description_{{$item->code}}">{{__('admin.description_'.$item->code)}}</label>
    <textarea name="description_{{$item->code}}" id="description_{{$item->code}}" class="form-control @if($errors->has('description_'.$item->code)) is-invalid @endif"
              placeholder="{{__('admin.description_'.$item->code)}}">{{ old('description_'.$item->code, (isset($category))?$category->getTranslation('description', $item->code):'')}}</textarea>
    @if($errors->has('description_'.$item->code))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('description_'.$item->code) }}</strong>
    </span>
    @endif
</div>
