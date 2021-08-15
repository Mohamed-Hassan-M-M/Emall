@foreach($languages as $item)
<div class="tab-pane {{($item->code==app()->getLocale())?'active':''}}" id="{{$item->code}}">
    @include('admin.categories.translatable-fields')
</div> 
@endforeach
<div class="form-group">
  
    <label for="image">{{__('admin.image')}}</label>
    <input type="file" class="form-control @if($errors->has('image')) is-invalid @endif"  name="image" id="image" data-plugins="dropify"
           data-default-file="{{isset($category)?asset('storage/'.$category->image_url):''}}"/>

    <p class="text-muted text-center mt-2 mb-0">{{__('admin.upload_image')}}</p>
     @if($errors->has('image'))
     <span class="red">
        <strong>{{ $errors->first('image') }}</strong>
    </span>
    @endif
</div>
 


