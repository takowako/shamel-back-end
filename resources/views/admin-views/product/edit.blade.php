@extends('layouts.admin.app')

@section('title', translate('Update_product'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ dynamicAsset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title"><i class="tio-edit"></i>
                {{ translate('messages.food_update') }}
            </h1>
        </div>




        <form action="javascript:" method="post" id="product_form" enctype="multipart/form-data">
            @csrf
            <div class="row g-2">
                <div class="col-lg-6">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-body pb-0">
                            @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
                            @php($language = $language->value ?? null)
                            @php($default_lang = str_replace('_', '-', app()->getLocale()))
                                @if ($language)
                                    <ul class="nav nav-tabs mb-4">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active"
                                                href="#"
                                                id="default-link">{{ translate('Default') }}</a>
                                        </li>
                                        @foreach (json_decode($language) as $lang)
                                            <li class="nav-item">
                                                <a class="nav-link lang_link "
                                                    href="#"
                                                    id="{{ $lang }}-link">{{ \App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                        </div>

                            <div class="card-body">
                                <div class="lang_form"  id="default-form">
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="default_name">{{ translate('messages.name') }}
                                            ({{ translate('Default') }})
                                        </label>
                                        <input type="text" name="name[]" id="default_name"
                                            class="form-control" value="{{$product?->getRawOriginal('name')}}"
                                            placeholder="{{ translate('messages.new_food') }}"

                                            oninvalid="document.getElementById('en-link').click()">
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.short_description') }}
                                            ({{ translate('Default') }})</label>
                                        <textarea type="text" name="description[]" class="form-control ckeditor min-height-154px">{!! $product?->getRawOriginal('description') ?? '' !!}</textarea>
                                    </div>
                            </div>
                                @if ($language)
                                    @foreach (json_decode($language) as $lang)

                                        <?php
                                        if (count($product['translations'])) {
                                            $translate = [];
                                            foreach ($product['translations'] as $t) {
                                                if ($t->locale == $lang && $t->key == 'name') {
                                                    $translate[$lang]['name'] = $t->value;
                                                }
                                                if ($t->locale == $lang && $t->key == 'description') {
                                                    $translate[$lang]['description'] = $t->value;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="d-none lang_form" id="{{ $lang }}-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="{{ $lang }}_name">{{ translate('messages.name') }}
                                                        ({{ strtoupper($lang) }})
                                                    </label>
                                                    <input type="text" name="name[]" id="{{ $lang }}_name"
                                                        class="form-control"  value="{{ $translate[$lang]['name'] ?? '' }}"
                                                        placeholder="{{ translate('messages.new_food') }}"
                                                        oninvalid="document.getElementById('en-link').click()">
                                                </div>
                                                <input type="hidden" name="lang[]" value="{{ $lang }}">
                                                <div class="form-group mb-0">
                                                    <label class="input-label"
                                                        for="exampleFormControlInput1">{{ translate('messages.short_description') }}
                                                        ({{ strtoupper($lang) }})</label>
                                                    <textarea type="text" name="description[]" class="form-control ckeditor min-height-154px">{!! $translate[$lang]['description'] ?? '' !!}</textarea>
                                                </div>
                                            </div>
                                    @endforeach
                                @endif
                            </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow--card-2 border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <span>{{ translate('Food_Image') }} <small
                                        class="text-danger">({{ translate('messages.Ratio_200x200') }})</small></span>
                            </h5>
                            <div class="form-group mb-0 h-100 d-flex flex-column align-items-center justify-content-center">
                                <label>
                                    <center id="image-viewer-section" class="my-auto">
                                        <img class="initial-52 object--cover border--dashed onerror-image" id="viewer"
                                             src="{{ \App\CentralLogics\Helpers::onerror_image_helper(
                                            $product['image'] ?? '',
                                            dynamicStorage('storage/app/public/product').'/'.$product['image'] ?? '',
                                            dynamicAsset('public/assets/admin/img/100x100/food-default-image.png'),
                                            'product/'
                                        ) }}"
                                             data-onerror-image="{{ dynamicAsset('public/assets/admin/img/100x100/food-default-image.png') }}"
                                            alt="{{  translate('image')}}" />
                                        <input type="file" name="image" id="customFileEg1" class="d-none" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    </center>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-dashboard-outlined"></i>
                                </span>
                                <span> {{ translate('Restaurants_&_Category_Info') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1">{{ translate('messages.restaurant') }}<span
                                                class="input-label-secondary"></span></label>
                                                <select name="restaurant_id"
                                                data-placeholder="{{ translate('messages.select_restaurant') }}"
                                                class="js-data-example-ajax form-control"
                                                title="{{ translate('select_restaurant') }}" required
                                                oninvalid="this.setCustomValidity('{{ translate('messages.please_select_restaurant') }}')">
                                                @if (isset($product->restaurant))
                                                    <option value="{{ $product->restaurant_id }}" selected="selected">
                                                        {{ $product->restaurant->name }}</option>
                                                @endif
                                            </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1">{{ translate('messages.category') }}<span
                                                class="input-label-secondary">*</span></label>
                                                <select name="category_id" id="category-id" class="form-control js-select2-custom get-request">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category['id'] }}"
                                                        {{ $category->id == $product_category[0]->id ? 'selected' : '' }}>
                                                        {{ $category['name'] }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1">{{ translate('messages.sub_category') }}<span
                                                class="input-label-secondary" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="{{ translate('messages.category_required_warning') }}"><img
                                                    src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ translate('messages.category_required_warning') }}"></span></label>
                                                    <select name="sub_category_id" id="sub-categories"
                                                    data-id="{{ count($product_category) >= 2 ? $product_category[1]->id : '' }}"
                                                    class="form-control js-select2-custom">
                                                </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.food_type') }}</label>
                                            <select name="veg" class="form-control js-select2-custom">
                                                <option value="0" {{ $product['veg'] == 0 ? 'selected' : '' }}>
                                                    {{ translate('messages.non_veg') }}
                                                </option>
                                                <option value="1" {{ $product['veg'] == 1 ? 'selected' : '' }}>
                                                    {{ translate('messages.veg') }}
                                                </option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-dashboard-outlined"></i>
                                </span>
                                <span>{{ translate('messages.addon') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <label class="input-label"
                                for="exampleFormControlSelect1">{{ translate('Select_Add-on') }}<span
                                    class="input-label-secondary" data-toggle="tooltip"
                                    data-placement="right"
                                    data-original-title="{{ translate('messages.restaurant_required_warning') }}"><img
                                        src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                        alt="{{ translate('messages.restaurant_required_warning') }}"></span></label>
                                        <select name="addon_ids[]" class="form-control border js-select2-custom" multiple="multiple"
                                        id="add_on">
                                    </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2"><i class="tio-date-range"></i></span>
                                <span>{{ translate('messages.Availability') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.available_time_starts') }}</label>
                                        <input type="time" name="available_time_starts" class="form-control"
                                            id="available_time_starts"  value="{{ $product['available_time_starts'] }}"
                                            placeholder="{{ translate('messages.Ex:_10:30_am') }} " required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.available_time_ends') }}</label>
                                        <input type="time" name="available_time_ends" class="form-control" value="{{ $product['available_time_ends'] }}"
                                            id="available_time_ends" placeholder="5:45 pm" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2"><i class="tio-dollar-outlined"></i></span>
                                <span>{{ translate('Price_Information') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.price') }}</label>
                                        <input type="number" min="0" max="999999999999.99"
                                            step="0.01" value="{{ $product['price'] }}" name="price" class="form-control"
                                            placeholder="{{ translate('messages.Ex:_100') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.discount_type') }}

                                        </label>
                                        <select name="discount_type" class="form-control js-select2-custom">
                                            <option value="percent"
                                                {{ $product['discount_type'] == 'percent' ? 'selected' : '' }}>
                                                {{ translate('messages.percent').' (%)' }}
                                            </option>
                                            <option value="amount" {{ $product['discount_type'] == 'amount' ? 'selected' : '' }}>
                                                {{ translate('messages.amount').' ('.\App\CentralLogics\Helpers::currency_symbol().')'  }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.discount') }}
                                            <span class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="{{ translate('Currently_you_need_to_manage_discount_with_the_Restaurant.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                        </label>
                                        <input type="number" min="0" max="9999999999999999999999"
                                        value="{{ $product['discount'] }}"  name="discount" class="form-control"
                                            placeholder="{{ translate('messages.Ex:_100') }} ">
                                    </div>
                                </div>
                                <div class="col-md-3" id="maximum_cart_quantity">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="maximum_cart_quantity">{{ translate('messages.Maximum_Purchase_Quantity_Limit') }}
                                            <span
                                            class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="{{ translate('If_this_limit_is_exceeded,_customers_can_not_buy_the_food_in_a_single_purchase.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                        </label>
                                        <input type="number" placeholder="{{ translate('messages.Ex:_10') }}" class="form-control" name="maximum_cart_quantity" min="0" value="{{ $product->maximum_cart_quantity }}" id="cart_quantity">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header flex-wrap">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-canvas-text"></i>
                                </span>
                                <span>{{ translate('messages.food_variations') }}</span>
                            </h5>
                            <a class="btn text--primary-2" id="add_new_option_button">
                                {{ translate('add_new_variation') }}
                                <i class="tio-add"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <div id="add_new_option">
                                        @if (isset($product->variations))
                                        @foreach (json_decode($product->variations,true) as $key_choice_options=>$item)
                                            @if (isset($item["price"]))
                                                @break
                                            @else
                                                @include('admin-views.product.partials._new_variations',['item'=>$item,'key'=>$key_choice_options+1])
                                            @endif
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2"><i class="tio-label"></i></span>
                                <span>{{ translate('tags') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <input type="text" class="form-control" name="tags"  value="@foreach($product->tags as $c) {{$c->tag.','}} @endforeach" placeholder="Enter tags" data-role="tagsinput">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="btn--container justify-content-end">
                        <button type="reset" id="reset_btn"
                            class="btn btn--reset">{{ translate('messages.reset') }}</button>
                        <button type="submit"
                            class="btn btn--primary">{{ translate('messages.submit') }}</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@push('script')
@endpush

@push('script_2')
    <script src="{{ dynamicAsset('public/assets/admin') }}/js/tags-input.min.js"></script>
    <script src="{{ dynamicAsset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        "use strict";
        $('#restaurant_id').on('change', function () {
            let route = '{{ url('/') }}/admin/restaurant/get-addons?data[]=0&restaurant_id=';
            let restaurant_id = $(this).val();
            let id = 'add_on';
            getRestaurantData(route,restaurant_id, id);

        });
        $('.get-request').on('change', function () {
            let route = '{{ url('/') }}/admin/food/get-categories?parent_id='+$(this).val();
            let id = 'sub-categories';
            getRequest(route, id);
        });
        function getRestaurantData(route, restaurant_id, id) {
            $.get({
                url: route + restaurant_id,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function getRequest(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
            $('#image-viewer-section').show(1000)
        });

        $(document).ready(function() {
            setTimeout(function() {
                let category = $("#category-id").val();
                let sub_category = '{{ count($product_category) >= 2 ? $product_category[1]->id : '' }}';
                let sub_sub_category = '{{ count($product_category) >= 3 ? $product_category[2]->id : '' }}';
                getRequest('{{ url('/') }}/admin/food/get-categories?parent_id=' + category +
                    '&sub_category=' + sub_category, 'sub-categories');
                getRequest('{{ url('/') }}/admin/food/get-categories?parent_id=' + sub_category +
                    '&sub_category=' + sub_sub_category, 'sub-sub-categories');

            }, 1000)

            @if(count(json_decode($product['add_ons'], true))>0)
            getRestaurantData('{{url('/')}}/admin/restaurant/get-addons?@foreach(json_decode($product['add_ons'], true) as $addon)data[]={{$addon}}& @endforeach restaurant_id=','{{$product['restaurant_id']}}','add_on');
            @else
            getRestaurantData('{{url('/')}}/admin/restaurant/get-addons?data[]=0&restaurant_id=','{{$product['restaurant_id']}}','add_on');
            @endif
        });

        $(document).on('ready', function() {
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{ url('/') }}/admin/restaurant/get-restaurants',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        function show_min_max(data){
            $('#min_max1_'+data).removeAttr("readonly");
            $('#min_max2_'+data).removeAttr("readonly");
            $('#min_max1_'+data).attr("required","true");
            $('#min_max2_'+data).attr("required","true");
        }
        function hide_min_max (data){
            $('#min_max1_'+data).val(null).trigger('change');
            $('#min_max2_'+data).val(null).trigger('change');
            $('#min_max1_'+data).attr("readonly","true");
            $('#min_max2_'+data).attr("readonly","true");
            $('#min_max1_'+data).attr("required","false");
            $('#min_max2_'+data).attr("required","false");
        }
        $(document).on('change', '.show_min_max', function () {
            let data = $(this).data('count');
            show_min_max(data);
        });

        $(document).on('change', '.hide_min_max', function () {
            let data = $(this).data('count');
            hide_min_max(data);
        });


        var count= {{isset($product->variations)?count(json_decode($product->variations,true)):0}};

        $(document).ready(function(){
            console.log(count);

            $("#add_new_option_button").click(function(e) {
                $('#empty-variation').hide();
                count++;
                let add_option_view = `
                    <div class="__bg-F8F9FC-card view_new_option mb-2">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-check form--check">
                                    <input id="options[` + count + `][required]" name="options[` + count + `][required]" class="form-check-input" type="checkbox">
                                    <span class="form-check-label">{{ translate('Required') }}</span>
                                </label>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm delete_input_button"
                                        title="{{ translate('Delete') }}">
                                        <i class="tio-add-to-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-xl-4 col-lg-6">
                                    <label for="">{{ translate('name') }}</label>
                                    <input required name=options[` + count +
                    `][name] class="form-control new_option_name" type="text" data-count="`+
                    count +`">
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label class="input-label text-capitalize d-flex align-items-center"><span class="line--limit-1">{{ translate('messages.selcetion_type') }} </span>
                                        </label>
                                        <div class="resturant-type-group px-0">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input show_min_max" data-count="`+count+`" type="radio" value="multi"
                                                name="options[` + count + `][type]" id="type` + count +
                    `" checked
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Multiple Selection') }}
                    </span>
                </label>

                <label class="form-check form--check mr-2 mr-md-4">
                    <input class="form-check-input hide_min_max" data-count="`+count+`" type="radio" value="single"
                                                name="options[` + count + `][type]" id="type` + count +
                    `"
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Single Selection') }}
                    </span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="row g-2">
            <div class="col-6">
                <label for="">{{ translate('Min') }}</label>
                                            <input id="min_max1_` + count + `" required  name="options[` + count + `][min]" class="form-control" type="number" min="1">
                                        </div>
                                        <div class="col-6">
                                            <label for="">{{ translate('Max') }}</label>
                                            <input id="min_max2_` + count + `"   required name="options[` + count + `][max]" class="form-control" type="number" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="option_price_` + count + `" >
                                <div class="bg-white border rounded p-3 pb-0 mt-3">
                                    <div  id="option_price_view_` + count + `">
                                        <div class="row g-3 add_new_view_row_class mb-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Option_name') }}</label>
                                                <input class="form-control" required type="text" name="options[` +
                    count +
                    `][values][0][label]" id="">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Additional_price') }}</label>
                                                <input class="form-control" required type="number" min="0" step="0.01" name="options[` +
                    count + `][values][0][optionPrice]" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 p-3 mr-1 d-flex "  id="add_new_button_` + count +
                    `">
                                        <button type="button" class="btn btn--primary btn-outline-primary add_new_row_button" data-count="`+
                    count +`" >{{ translate('Add_New_Option') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $("#add_new_option").append(add_option_view);
            });

        });

        function new_option_name(value,data)
        {
            $("#new_option_name_"+data).empty();
            $("#new_option_name_"+data).text(value)
            console.log(value);
        }
        function removeOption(e)
        {
            element = $(e);
            element.parents('.view_new_option').remove();
        }
        function deleteRow(e)
        {
            element = $(e);
            element.parents('.add_new_view_row_class').remove();
        }


        function add_new_row_button(data) {
            count = data;
            countRow = 1 + $('#option_price_view_' + data).children('.add_new_view_row_class').length;
            let add_new_row_view = `
            <div class="row add_new_view_row_class mb-3 position-relative pt-3 pt-sm-0">
                <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Option_name') }}</label>
                        <input class="form-control" required type="text" name="options[` + count + `][values][` +
                countRow + `][label]" id="">
                    </div>
                    <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Additional_price') }}</label>
                        <input class="form-control"  required type="number" min="0" step="0.01" name="options[` +
                count +
                `][values][` + countRow + `][optionPrice]" id="">
                    </div>
                    <div class="col-sm-2 max-sm-absolute">
                        <label class="d-none d-sm-block">&nbsp;</label>
                        <div class="mt-1">
                            <button type="button" class="btn btn-danger btn-sm deleteRow"
                                title="{{ translate('Delete') }}">
                                <i class="tio-add-to-trash"></i>
                            </button>
                        </div>
                </div>
            </div>`;
            $('#option_price_view_' + data).append(add_new_row_view);

        }
        $(document).on('click', '.delete_input_button', function () {
            let e = $(this);
            removeOption(e);
        });

        $(document).on('click', '.deleteRow', function () {
            let e = $(this);
            deleteRow(e);
        });
        $(document).on('click', '.add_new_row_button', function () {
            let data = $(this).data('count');
            add_new_row_button(data);
        });
        $(document).on('keyup', '.new_option_name', function () {
            let data = $(this).data('count');
            let value = $(this).val();
            new_option_name(value, data);
        });


        $('#choice_attributes').on('change', function() {
            $('#customer_choice_options').html(null);
            combination_update();
            $.each($("#choice_attributes option:selected"), function() {
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name;

            $('#customer_choice_options').append(
                `<div class="__choos-item"><div><input type="hidden" name="choice_no[]" value="${i}"><input type="text" class="form-control d-none" name="choice[]" value="${n}" placeholder="{{ translate('messages.choice_title') }}" readonly> <label class="form-label">${n}</label> </div><div><input type="text" class="form-control combination_update" name="choice_options_${i}[]" placeholder="{{ translate('messages.enter_choice_values') }}" data-role="tagsinput"></div></div>`
            );
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        setTimeout(function() {
            $('.call-update-sku').on('change', function() {
                combination_update();
            });
        }, 2000)

        $('#colors-selector').on('change', function() {
            combination_update();
        });

        $('input[name="unit_price"]').on('keyup', function() {
            combination_update();
        });

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{ route('admin.food.variant-combination') }}',
                data: $('#product_form').serialize(),
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    $('#variant_combination').html(data.view);
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }

        $('#product_form').on('submit', function() {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.food.update', [$product['id']]) }}',
                data: $('#product_form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{ translate('product_updated_successfully!') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function() {
                            location.href =
                                '{{ \Request::server('HTTP_REFERER') ?? route('admin.food.list') }}';
                        }, 2000);
                    }
                }
            });
        });


        $('#reset_btn').click(function(){
            location.reload(true);
        })
    </script>
@endpush
