@extends('admin.layouts.app', ['title' => 'Edit Sub Category'])

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
                        <li class="breadcrumb-item"><a href="{{route('admin.sub-categories.index')}}">{{__('admin.sub_category')}}</a></li>
                        <li class="breadcrumb-item active">{{__('admin.edit')}}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{__('admin.sub_category')}}</h4>
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
                        <form action="{{route('admin.sub-categories.update',['id'=>$subCategory->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            {{method_field('PATCH')}}
                            <div class="tab-content clearfix">
                                @include('admin.sub-categories.form')
                            </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">{{__('admin.update')}}</button>
                                    <a type="button" href="{{route('admin.sub-categories.index')}}"
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
@endsection
