@extends('manager.layouts.app', ['title' => 'New Product'])

@section('css')
<link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

<!-- Start Content-->
<div class="container-fluid">
    <x-alert></x-alert>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">{{env('APP_NAME')}}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{route('manager.products.index')}}">{{__('manager.product')}}</a></li>
                        <li class="breadcrumb-item active">{{__('manager.create')}}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{__('manager.new_product')}}</h4>
            </div>
        </div>
    </div>

    <form action="{{route('manager.products.store')}}" method="post" enctype="multipart/form-data"
          id="product-form">
        @csrf
        <div class="container">
            @include('shared.errors')
            @include('shared.lang-nav')

            <div class="row">

                <div class="col-lg-6">
                    <!-- end col-->

                    <div class="card-box">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">{{__('manager.general')}}</h5>

                        <div class="tab-content clearfix">
                            @foreach($languages as $item)
                            <div class="tab-pane {{($item->code==app()->getLocale())?'active':''}}" id="{{$item->code}}">
                                @include('admin.products.translatable-fields')
                            </div> 
                            @endforeach
                        </div>

                        <div class="form-group mb-3">
                            <label for="category">{{__('manager.category')}} <span class="text-danger">*</span></label>
                            <select class="form-control"  name="category" id="category" required>
                                <option disabled>Select</option>
                                @foreach($categories as $category)
                                <optgroup label="{{$category->title}}">
                                    @foreach($category->subCategories as $sub_category)
                                    <option value="{{$sub_category->id}}">{{$sub_category->title}}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <!-- end card-box -->

                </div>


                <div class="col-lg-6">

                    <div class="card-box">
                        <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('manager.meta_data')}}</h5>
                        <div class="form-group mb-3">
                            <label for="offer">{{__('manager.offer')}} (%)</label>
                            <div class="input-group">
                                <input type="number" min="0" max="100" step="1"
                                       class="form-control @if($errors->has('offer')) is-invalid @endif" name="offer"
                                       id="offer"
                                       placeholder="Offer" value="0">
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


                    </div>
                    <!-- end card-box -->
                </div> <!-- end col -->


                <div class="col-lg-12">

                    <div class="card-box">
                        <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{__('manager.items')}}</h5>

                        <div class="text-danger" id="product-item-wrapper-error"></div>
                        <div id="product-item-wrapper" class="mt-2">
                        </div>
                        <div class=" row">
                            <div class="col-md-3">
                                <select class="form-control" onchange="getSub(this)">
                                    <option disabled selected="">{{trans('admin.pleaseselect')}}</option>
                                    @foreach($features as $feature)
                                    <option value="{{$feature->id}}">{{$feature->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" id="sublist">
                                <select class="form-control subselect" id="1">

                                </select>
                                <br>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" id="add-feature"
                                        class="btn w-sm btn-primary waves-effect waves-light" onclick="addSubFeature()">{{__('manager.add_item')}}</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button"
                                        class="btn w-sm btn-success" onclick="addSubFeature()" id="add_sub"><span class="fa fa-plus"></span></button>
                            </div>
                        </div>
                    </div>
                    <!-- end card-box -->
                </div>


                <div class="col-12" id="features_list">
                    <div class="text-right mb-3">
                        <a href="{{route('manager.products.index')}}"
                           class="btn w-sm btn-light waves-effect">{{__('manager.cancel')}}</a>
                        <button type="button" id="submitBtn"
                                class="btn w-sm btn-success waves-effect waves-light" onclick="addfeature()">{{__('manager.create')}}</button>
                    </div>
                </div> <!-- end col-->
            </div>
        </div>
    </form>

</div>

@endsection

@section('script')


<script src="{{asset('assets/libs/summernote/summernote.min.js')}}"></script>

<!-- Page js-->
<script src="{{asset('assets/js/pages/form-summernote.init.js')}}"></script>
<script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
<script>
                                    function getSub(sel) {
                                        $.get('/manager/getSubFeatures?id=' + sel.value, function (data) {
                                            $('.subselect').empty();
                                            $.each(data, function (index, sectObj) {
                                                var selected = "";
                                                $('.subselect').append('<option value="' + sectObj.id + '" ' + selected + '> ' + sectObj.value + '</option>');

                                            });
                                        });
                                    }
                                    var i = 1;
                                    function addSubFeature() {
                                        var itm = document.getElementById("1");
                                        var cln = itm.cloneNode(true);
                                        cln.id = ++i;
                                        document.getElementById("sublist").appendChild(cln);
                                        $('#sublist').append('<button type="button" class="btn btn-danger" onclick=' + 'removeitem(' + i + ') id=btn_' + i + '><span class="fa fa-minus"></span></button>');
                                        if (i == 3) {
                                            document.getElementById("add_sub").disabled = true;
                                        }
                                    }
                                    function removeitem(id) {
                                        var item = document.getElementById(id);
                                        item.remove();
                                        var btn = document.getElementById('btn_' + id);
                                        btn.remove();
                                        document.getElementById("add_sub").disabled = false;
                                    }

</script>
@endsection
