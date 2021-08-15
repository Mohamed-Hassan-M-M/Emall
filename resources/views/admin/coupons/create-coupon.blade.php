@extends('admin.layouts.app', ['title' => 'New Coupon'])

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
                        <li class="breadcrumb-item active">{{__('admin.create')}}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{__('admin.create_coupon')}}</h4>
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
                        <form action="{{route('admin.coupons.store')}}" method="post">
                            @csrf
                            <div class="tab-content clearfix">
                                @include('admin.coupons.form')
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="for_new_user" id="for_new_user">
                                <label class="custom-control-label" for="for_new_user">{{__('admin.for_only_new_user')}}</label>
                            </div>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" name="for_only_one_time" id="for_only_one_time" checked>
                                <label class="custom-control-label" for="for_only_one_time">{{__('admin.for_only_one_time')}}</label>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light">{{__('admin.save')}}</button>
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
<script>
    $(document).ready(function () {
        $('#expired_at').datetimepicker({
            format: 'MM/DD/YYYY',
            locale: 'en',
            min: (new Date()).toString()
        })
    });
</script>
@endsection
