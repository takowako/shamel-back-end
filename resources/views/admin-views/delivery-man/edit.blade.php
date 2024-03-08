@extends('layouts.admin.app')

@section('title',translate('Update_Deliveryman'))

@push('css_or_js')
    <link rel="stylesheet" href="{{dynamicAsset('/public/assets/admin/css/intlTelInput.css')}}" />
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mb-2 text-capitalize">
                <div class="card-header-icon d-inline-flex mr-2 img">
                    <img src="{{dynamicAsset('/public/assets/admin/img/delivery-man.png')}}" alt="public">
                </div>
                <span>
                    {{translate('messages.Update_Deliveryman')}}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <form action="{{route('admin.delivery-man.update',[$delivery_man['id']])}}" method="post"
        class="js-validate"   enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <span class="card-title-icon"><i class="tio-user"></i></span>
                        <span>
                            {{ translate('general_info') }}
                        </span>
                    </h5>
                </div>
                <div class="card-body">

                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.first_name')}}</label>
                                        <input type="text" value="{{$delivery_man['f_name']}}" name="f_name"
                                                class="form-control h--45px" placeholder="{{translate('messages.first_name')}}"
                                                required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.last_name')}}</label>
                                        <input type="text" value="{{$delivery_man['l_name']}}" name="l_name"
                                                class="form-control h--45px" placeholder="{{translate('messages.last_name')}}"
                                                required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.email')}}</label>
                                        <input type="email" value="{{$delivery_man['email']}}" name="email" class="form-control h--45px"
                                                placeholder="{{ translate('Ex:_ex@example.com') }}"
                                                required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.deliveryman_type')}}</label>
                                        <select name="earning" class="form-control h--45px" required>
                                            <option value="1" {{$delivery_man->earning?'selected':''}}>{{translate('messages.freelancer')}}</option>
                                            <option value="0" {{$delivery_man->earning?'':'selected'}}>{{translate('messages.salary_based')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.zone')}}</label>
                                        <select name="zone_id" class="form-control js-select2-custom h--45px">
                                        @foreach(\App\Models\Zone::where('status',1)->get(['id','name']) as $zone)
                                            @if(isset(auth('admin')->user()->zone_id))
                                                @if(auth('admin')->user()->zone_id == $zone->id)
                                                    <option value="{{$zone->id}}" {{$zone->id == $delivery_man->zone_id?'selected':''}}>{{$zone->name}}</option>
                                                @endif
                                            @else
                                            <option value="{{$zone->id}}" {{$zone->id == $delivery_man->zone_id?'selected':''}}>{{$zone->name}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.vehicle')}}</label>
                                        <select name="vehicle_id" class="form-control js-select2-custom h--45px">
                                            <option value="" readonly="true" hidden="true">{{ translate('messages.select_vehicle') }}</option>
                                        @foreach(\App\Models\Vehicle::where('status',1)->get(['id','type']) as $v)
                                            <option value="{{$v->id}}" {{$v->id == $delivery_man->vehicle_id?'selected':''}}>{{$v->type}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group m-0">
                                <label class="d-block mb-lg-5 text-center">{{translate('messages.deliveryman_image')}} <small class="text-danger">* ( {{translate('messages.ratio_1:1')}} )</small></label>
                                <div class="text-center py-3 my-auto">
                                    <img class="initial-24 onerror-image" id="viewer"
                                         src="{{\App\CentralLogics\Helpers::onerror_image_helper($delivery_man['image'], dynamicStorage('storage/app/public/delivery-man/').'/'.$delivery_man['image'], dynamicAsset('public/assets/admin/img/100x100/user.png'), 'delivery-man/') }}"
                                         data-onerror-image="{{dynamicAsset('/public/assets/admin/img/100x100/user.png')}}"
                                         alt="delivery-man image"/>
                                </div>
                                <label class="d-block mb-lg-3 text-center"></label>

                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input h--45px"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1">{{translate('messages.choose_file')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="row g-3">
                                <div class="col-sm-6 col-lg-12">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.identity_type')}}</label>
                                        <select name="identity_type" class="form-control h--45px">
                                            <option
                                                value="passport" {{$delivery_man['identity_type']=='passport'?'selected':''}}>
                                                {{translate('messages.passport')}}
                                            </option>
                                            <option
                                                value="driving_license" {{$delivery_man['identity_type']=='driving_license'?'selected':''}}>
                                                {{translate('messages.driving_license')}}
                                            </option>
                                            <option value="nid" {{$delivery_man['identity_type']=='nid'?'selected':''}}>{{translate('messages.nid')}}
                                            </option>
                                            <option
                                                value="restaurant_id" {{$delivery_man['identity_type']=='restaurant_id'?'selected':''}}>
                                                {{translate('messages.restaurant_id')}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-12">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.identity_number')}}</label>
                                        <input type="text" name="identity_number" value="{{$delivery_man['identity_number']}}"
                                                class="form-control h--45px"
                                                placeholder="{{ translate('messages.Ex:DH-23434-LS') }} "
                                                required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group mb-0">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.identity_image')}}</label>
                                <div>
                                    <div class="row" id="coba"></div>
                                </div>
                            </div>
                            @foreach(json_decode($delivery_man['identity_image'],true) as $img)
                                <img height="150" src="{{dynamicStorage('storage/app/public/delivery-man').'/'.$img}}">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">
                        <span class="card-header-icon"><i class="tio-user"></i></span>
                        <span>{{ translate('messages.account_info') }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group m-0">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.phone')}}</label>
                                <input type="tel" id="phone" name="phone" value="{{$delivery_man['phone']}}" class="form-control h--45px"
                                        placeholder="{{ translate('Ex:_017********') }}"
                                        required>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">

                            <div class="js-form-message form-group">
                                <label class="input-label" for="signupSrPassword">{{translate('messages.password')}}
                                    <span class="input-label-secondary ps-1" title="{{ translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters') }}"><img src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}" alt="{{ translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters') }}"></span>
                                </label>

                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control h--45px" name="password"
                                        id="signupSrPassword"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="{{ translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters') }}"
                                        placeholder="{{ translate('messages.password_length_8+')  }}"
                                        aria-label="8+ characters required"
                                        data-msg="Your password is invalid. Please try again."
                                        data-hs-toggle-password-options='{
                                                        "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                                        "defaultClass": "tio-hidden-outlined",
                                                        "showClass": "tio-visible-outlined",
                                                        "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                                                        }'>
                                    <div class="js-toggle-password-target-1 input-group-append">
                                        <a class="input-group-text" href="javascript:;">
                                            <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Static -->
                        <div class="col-sm-6 col-lg-4">

                            <div class="js-form-message form-group">
                                <label class="input-label" for="signupSrConfirmPassword">{{translate('messages.confirm_password')}}
                                </label>

                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control h--45px"
                                        name="confirmPassword" id="signupSrConfirmPassword"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="{{ translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters') }}"
                                        placeholder="{{translate('messages.password_length_8+')}}"
                                        aria-label="8+ characters required"
                                        data-msg="Password does not match the confirm password."
                                        data-hs-toggle-password-options='{
                                                            "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                                            "defaultClass": "tio-hidden-outlined",
                                                            "showClass": "tio-visible-outlined",
                                                            "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                                                            }'>
                                    <div class="js-toggle-password-target-2 input-group-append">
                                        <a class="input-group-text" href="javascript:;">
                                            <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Static -->
                    </div>
                </div>
            </div>
            <div class="btn--container mt-4 justify-content-end">
                <button type="reset" id="reset_btn" class="btn btn--reset">{{ translate('messages.reset') }}</button>
                <button type="submit" class="btn btn--primary">{{ translate('messages.submit') }}</button>
            </div>
        </form>
    </div>

@endsection

@push('script_2')
    <script src="{{dynamicAsset('public/assets/admin/js/intlTelInput.js')}}"></script>
    <script src="{{dynamicAsset('public/assets/admin/js/intlTelInput-jquery.min.js')}}"></script>
    <script src="{{dynamicAsset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        "use strict";
             $('#exampleInputPassword ,#exampleRepeatPassword').on('keyup', function() {
                let pass = $("#exampleInputPassword").val();
                let passRepeat = $("#exampleRepeatPassword").val();
                if (pass == passRepeat) {
                    $('.pass').hide();
                } else {
                    $('.pass').show();
                }
            });

        $("#customFileEg1").change(function () {
            readURL(this);
        });

        <?php
            $country=\App\Models\BusinessSetting::where('key','country')->first();
        ?>
        let phone = $("#phone").intlTelInput({
            utilsScript: "{{dynamicAsset('public/assets/admin/js/intlTellInput-util.min.js')}}",
            nationalMode: true,
            autoHideDialCode: true,
            autoPlaceholder: "ON",
            dropdownContainer: document.body,
            formatOnDisplay: true,
            hiddenInput: "phone",
            initialCountry: "{{$country?$country->value:auto}}",
            placeholderNumberType: "MOBILE",
            separateDialCode: true
        });


        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '140px',
                groupClassName: 'col-6 col-lg-4',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{dynamicAsset('public/assets/admin/img/100x100/user2.png')}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        $('#reset_btn').click(function(){
            $('#viewer').attr('src','{{dynamicStorage('storage/app/public/delivery-man')}}/{{$delivery_man['image']}}');
        })

    </script>
@endpush
