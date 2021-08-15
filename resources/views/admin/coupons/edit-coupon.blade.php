@extends('admin.layouts.app', ['title' => 'Edit Coupon'])

@section('css')
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{env('APP_NAME')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.coupons.index')}}">{{__('admin.coupon')}}</a></li>
                        <li class="breadcrumb-item active">{{__('admin.edit')}}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{__('admin.edit_coupon')}}</h4>
            </div>
        </div>
    </div>
    <div class="container">
        @include('shared.errors')
        @include('shared.lang-nav')

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.coupons.update',['id'=>$coupon->id])}}" method="post">
                            @csrf
                            {{method_field('PATCH')}}
                            
                            <div class="tab-content clearfix">
                                @include('admin.coupons.form')
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="is_active" id="is_active" @if($coupon->is_active) checked @endif>
                                       <label class="custom-control-label" for="is_active">{{__('admin.coupon_activation')}}</label>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light">{{__('admin.update')}}</button>
                                <a type="button" href="{{route('admin.coupons.index')}}"
                                   class="btn btn-danger waves-effect waves-light m-l-10">{{__('admin.cancel')}}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
@endsection
