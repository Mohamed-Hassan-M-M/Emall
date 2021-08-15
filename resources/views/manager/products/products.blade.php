@extends('manager.layouts.app', ['title' => 'Products'])

@section('css')
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
                        <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">{{env('APP_NAME')}}</a></li>
                        <li class="breadcrumb-item active">{{__('manager.products')}}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{__('manager.products')}}</h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            {{ $products->links() }}
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a type="button" href="{{route('manager.products.create')}}"
                                   class="btn btn-primary waves-effect waves-light mb-2 text-white">{{__('manager.add_product')}}
                                </a>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{__('manager.image')}}</th>
                                    <th>{{__('manager.name')}}</th>
                                    <th>{{__('manager.rating')}}</th>
                                    <th></th>
                                    <th style="width: 82px;">{{__('manager.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <div>
                                            @if(count($product['productImages'])!=0)
                                            <img src="{{asset('storage/'.$product['productImages'][0]['url'])}}"
                                                 style="object-fit: cover" alt="OOps"
                                                 height="64px"
                                                 width="64px">
                                            @else
                                            <img src="{{\App\Models\Product::getPlaceholderImage()}}"
                                                 style="object-fit: cover" alt="OOps"
                                                 height="64px"
                                                 width="64px">
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{$product['name']}}
                                        @if(!$product['active'])
                                        <span class="text-danger d-block">* {{__('manager.this_product_was_disabled')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @for($i=0;$i<5;$i++)
                                        <a href="{{route('manager.productShowReview',$product['id'])}}"> <i class="mdi @if($i<$product['rating']) mdi-star @else mdi-star-outline @endif"
                                                                                                            style="font-size: 18px; margin-left: -4px; color: @if($i<$product['rating'])  {{\App\Models\ProductReview::getColorFromRating($product['rating'])}} @else black @endif"></i></a>
                                        @endfor
                                        <p class="d-inline">({{$product['total_rating']}})</p>
                                    </td>
                                    <td>
                                        <select class="form-control" onchange="changestatus(this, {{$product['id']}})">
                                            <option value="{{env('ACTIVE')}}"{{($product->active==1)?"selected":""}} >{{trans('manager.active')}} </option>
                                            <option value="{{env('DEACTIVE')}}"{{($product->active==0)?"selected":""}}> {{trans('manager.deactive')}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{route('manager.products.edit',['id'=>$product['id']])}}"
                                           style="font-size: 20px"> <i
                                                class="mdi mdi-pencil"></i></a>
                                        <form method="POST" id="{{$product['id']}}" action="{{route('manager.products.destroy',['id'=>$product['id']])}}" accept-charset="UTF-8" style="display: inline;"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="{{csrf_token()}}"> <button type="submit" title="' . trans('lines.delete_btn') . '" onclick="return checkDelete(this, {{$product['id']}})" dt-msg="{{trans('manager.product_delete_confirm_msg')}}" class="btn btn-sm"><i aria-hidden="true" class="mdi mdi-18px mdi-trash-can"></i></button></form>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>


                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
</div> <!-- container -->
<script>
    function changestatus(selected, id){
    var trans = '{{ __('manager.changestatusalert') }}';
    if (selected.value == 1){
    var maintitle = '{{ __('manager.changeshow') }}';
    } else{
    var maintitle = '{{ __('manager.changehide') }}';
    }
    mscConfirm({
    title: maintitle,
            subtitle: trans, // default: ''

            okText: '{{ __('manager.ok') }}', // default: OK

            cancelText: '{{ __('manager.cancel') }}', // default: Cancel

            onOk: function () {
            link = '/manager/changeStatus/' + id + '/' + selected.value;
            $.get(link);
            }
    ,
            onCancel: function () {
            //do nothing
            }
    }
    );
    return false;
    }
</script>
@endsection

@section('script')
@endsection
