@extends('admin.layouts.app', ['title' => 'Edit Category'])

@section('css')
<link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{env('APP_NAME')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">{{__('admin.category')}}</a></li>
                        <li class="breadcrumb-item active">{{__('admin.edit')}}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{__('admin.edit_category')}}</h4>
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
                        <form action="{{route('admin.categories.update',['id'=>$category->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            {{method_field('PATCH')}}
                            <div class="tab-content clearfix">
                                @include('admin.categories.form')
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light">{{__('admin.update')}}</button>
                                <a type="button" href="{{route('admin.categories.index')}}"
                                   class="btn btn-danger waves-effect waves-light m-l-10">{{__('admin.cancel')}}
                                </a>
                            </div>
                        </form>
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