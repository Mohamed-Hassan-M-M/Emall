@extends('admin.layouts.app', ['title' => 'Create Shop'])

@section('css')
<link href="{{asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{env('APP_NAME')}}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{route('admin.shops.index')}}">{{__('admin.shop')}}</a></li>
                        <li class="breadcrumb-item active">{{__('admin.create')}}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{__('admin.create_shop')}}</h4>
            </div>
        </div>
    </div>
    <div class="container">
        @include('shared.errors')
        @include('shared.lang-nav')
        <div class="row justify-content-center">
            <div class="col-12">
                <form action="{{route('admin.shops.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('admin.shops.form')
                    <div class="col mt-3 mb-3">
                        <div class="text-right">
                            <button type="submit"
                                    class="btn btn-success waves-effect waves-light mr-1">{{__('admin.create')}}
                            </button>
                            <a type="button" href="{{route('admin.shops.index')}}"
                               class="btn btn-danger waves-effect waves-light m-l-10">{{__('admin.cancel')}}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<!------ Summer note -------->
<script>
    $(document).ready(function () {
        $('#summernote').summernote({
            toolbar: [
                ['style', ['bold', 'italic']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['codeview', 'help']],
            ]
        })
    });
</script>

<script src="{{asset('assets/libs/summernote/summernote.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-summernote.init.js')}}"></script>

<!------ Dropify -------->

<script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
@endsection
