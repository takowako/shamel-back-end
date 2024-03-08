@extends('layouts.admin.app')

@section('title',translate('messages.update_notification'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title text-capitalize">
                        <div class="card-header-icon d-inline-flex mr-2 img">
                            <img src="{{dynamicAsset('/public/assets/admin/img/bell.png')}}" alt="public">
                        </div>
                        <span>
                            {{translate('messages.notification_update')}}
                        </span>
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.notification.update',[$notification['id']])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.title')}}</label>
                                <input id="notification_title" type="text" value="{{$notification['title']}}" name="notification_title" class="form-control" placeholder="{{translate('messages.new_notification')}}" required maxlength="191">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.zone')}}</label>
                                <select id="zone" name="zone" class="form-control js-select2-custom" >
                                    <option value="all" {{isset($notification->zone_id)?'':'selected'}}>{{translate('messages.all_zone')}}</option>
                                    @foreach(\App\Models\Zone::orderBy('name')->get(['id','name']) as $z)
                                        <option value="{{$z['id']}}"  {{$notification->zone_id==$z['id']?'selected':''}}>{{$z['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="tergat">{{translate('messages.send_to')}}</label>

                                <select id="tergat" name="tergat" class="form-control" id="tergat" data-placeholder="{{translate('messages.select_tergat')}}" required>
                                    <option value="customer" {{$notification->tergat=='customer'?'selected':''}}>{{translate('messages.customer')}}</option>
                                    <option value="deliveryman" {{$notification->tergat=='deliveryman'?'selected':''}}>{{translate('messages.deliveryman')}}</option>
                                    <option value="restaurant" {{$notification->tergat=='restaurant'?'selected':''}}>{{translate('messages.restaurant')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="text-center py-3 mb-3">
                                    <img  class="initial-30" id="viewer"
                                          src="{{\App\CentralLogics\Helpers::onerror_image_helper($notification['image'], dynamicStorage('storage/app/public/notification/').'/'.$notification['image'], dynamicAsset('public/assets/admin/img/900x400/img1.jpg'), 'notification/') }}"
                                          data-onerror-image="{{dynamicAsset('public/assets/admin/img/900x400/img1.jpg')}}" alt="image"/>
                                </div>
                                <label>{{translate('messages.notification_banner')}}</label><small class="text-danger">* ( {{translate('messages.ratio_3:1')}} )</small>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1">{{translate('messages.choose_file')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('messages.description')}}</label>
                            <textarea id="description" name="description" class="form-control h--md-200px" required>{{$notification['description']}}</textarea>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mb-0">
                        <button id="reset_btn" type="button" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="submit" class="btn btn--primary">{{translate('send_again')}}</button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        "use strict";
        $("#customFileEg1").change(function () {
            readURL(this);
        });
        $('#reset_btn').click(function(){
            $('#notification_title').val("{{$notification['title']}}");
            $('#zone').val("{{$notification->zone_id}}").trigger('change');
            $('#tergat').val("{{$notification->tergat}}").trigger('change');
            $('#viewer').attr('src', "{{dynamicStorage('storage/app/public/notification')}}/{{$notification['image']}}");
            $('#customFileEg1').val(null);
            $('#description').val("{{$notification['description']}}");
        })
    </script>
@endpush
