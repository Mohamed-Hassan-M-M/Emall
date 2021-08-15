@foreach($languages as $item)
<div class="tab-pane {{(($item->code==app()->getLocale()))?'active':''}}" id="{{$item->code}}">
    @include('admin.sub-categories.translatable-fields')
</div> 
@endforeach
<div class="form-group mt-0">
    <label for="category">{{__('manager.category')}} <span class="text-danger">*</span></label>
    <select class="form-control @if($errors->has('category')) is-invalid @endif" required="" name="category" id="category">
        <option disabled selected="">{{trans('admin.selectcategory')}}</option>
        @foreach($categories as $category)
        <option value="{{$category->id}}" {{isset($subCategory)?($subCategory->category_id==$category->id)?"selected":'':''}}>{{$category->getTranslation('title',app()->getLocale())}}</option>
        @endforeach
    </select>
    @if($errors->has('category'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('category') }}</strong>
    </span>
    @endif
</div>
