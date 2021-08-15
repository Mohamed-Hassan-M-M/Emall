@extends('manager.layouts.app', ['title' => 'Edit Shop'])

@section('css')
    <link href="{{asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
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
                                    href="{{route('manager.shops.index')}}">{{__('manager.my_shop')}}</a></li>
                            <li class="breadcrumb-item active">{{__('manager.edit')}}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{__('manager.edit_shop')}}</h4>
                </div>
            </div>
        </div>

    <div class="container">

        @include('shared.errors')
        @include('shared.lang-nav')

        <div class="row justify-content-center">
            <div class="col-12">
                <form action="{{route('manager.shops.update',['id'=>$shop->id])}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    @include('admin.shops.form')
                    <div class="col mt-3 mb-3">
                        <div class="text-right">
                            <a href="{{route('manager.shops.index')}}" type="button"
                               class="btn w-sm btn-light waves-effect">{{__('manager.cancel')}}</a>
                            <button type="submit"
                                    class="btn btn-success waves-effect waves-light">{{__('manager.update')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#summernote').summernote({
                toolbar: [
                    ['style', ['bold', 'italic']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview', 'help']],
                ]
            }).code("{{$shop->description}}")
        });
    </script>

    <script src="{{asset('assets/libs/summernote/summernote.min.js')}}"></script>

    <!-- Page js-->
    <script src="{{asset('assets/js/pages/form-summernote.init.js')}}"></script>
    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
@endsection
