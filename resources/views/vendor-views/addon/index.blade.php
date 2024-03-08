@extends('layouts.vendor.app')

@section('title',translate('messages.add_new_addon'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title"><i class="tio-add-circle-outlined"></i> {{translate('messages.add_new_addon')}}</h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{route('vendor.addon.store')}}" method="post" class="row">
                    @csrf
                    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                    @php($language = $language->value ?? null)
                    @php($default_lang = str_replace('_', '-', app()->getLocale()))
                    @if($language)
                        <div class="col-12">
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active" href="#" id="default-link">{{ translate('Default')}}</a>
                                </li>
                                @foreach(json_decode($language) as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link" href="#" id="{{$lang}}-link">{{\App\CentralLogics\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group col-md-6 lang_form" id="default-form">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}}</label>
                            <input type="text" name="name[]" class="form-control" placeholder="{{ translate('messages.Ex :') }} {{translate('Water')}}" required maxlength="191">
                        </div>
                        <input type="hidden" name="lang[]" value="default">
                        @foreach(json_decode($language) as $lang)
                            <div class="form-group col-md-6 d-none lang_form" id="{{$lang}}-form">
                                <label class="form-label" for="exampleFormControlInput1">{{translate('messages.name')}} ({{strtoupper($lang)}})</label>
                                <input type="text" name="name[]" class="form-control h--45px" placeholder="{{translate('Ex : New Addon ')}}" maxlength="191"  oninvalid="document.getElementById('en-link').click()">
                            </div>
                            <input type="hidden" name="lang[]" value="{{$lang}}">
                        @endforeach
                    @else
                            <div class="form-group col-md-6 lang_form" id="default-form">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}}</label>
                                <input type="text" name="name[]" class="form-control" placeholder="{{ translate('messages.Ex :') }} {{translate('Water')}}"  required maxlength="191">
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                    @endif

                    <div class="form-group col-md-6">
                        <label class="form-label" for="exampleFormControlInput1">{{translate('messages.price')}}</label>
                        <input type="number" min="0" max="999999999999.99" name="price" step="0.01" class="form-control h--45px" placeholder="{{ translate('Ex : 100.00') }}" value="{{old('price')}}" required>
                    </div>
                    <div class="col-12">
                        <div class="btn--container justify-content-end">
                            <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                            <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        {{translate('messages.addon_list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$addons->total()}}</span>
                    </h5>
                    <div id="search-form">
                        <form >
                        <div class="input-group input--group">
                            <input autocomplete="false" type="text" class="d-none">
                            <input type="text" name="search" value="{{ request()?->search ?? null }}"  class="form-control" placeholder="{{ translate('Ex : Search by Addon Name or Restaurant Name') }}">
                            <button type="submit" class="btn btn--secondary">
                                <i class="tio-search"></i>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                       class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                         "order": [],
                         "orderCellsTop": true,
                         "paging":false
                       }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="w-100px">{{translate('messages.sl')}}</th>
                        <th class="w-30p">{{translate('messages.name')}}</th>
                        <th class="w-25p">{{translate('messages.price')}}</th>
                        <th class="text-center w-100px">{{translate('messages.action')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($addons as $key=>$addon)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                            <span class="d-block font-size-sm text-body">
                                {{Str::limit($addon['name'], 20, '...')}}
                            </span>
                            </td>
                            <td>{{\App\CentralLogics\Helpers::format_currency($addon['price'])}}</td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                            href="{{route('vendor.addon.edit',[$addon['id']])}}" title="{{translate('messages.edit_addon')}}"><i class="tio-edit"></i></a>
                                    <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                        data-id="addon-{{$addon['id']}}" data-message="{{ translate('Want to delete this addon ?') }}" title="{{translate('messages.delete_addon')}}"><i class="tio-delete-outlined"></i></a>
                                    <form action="{{route('vendor.addon.delete',[$addon['id']])}}"
                                                method="post" id="addon-{{$addon['id']}}">
                                        @csrf @method('delete')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(count($addons) === 0)
                <div class="empty--data">
                    <img src="{{dynamicAsset('/public/assets/admin/img/empty.png')}}" alt="public">
                    <h5>
                        {{translate('no_data_found')}}
                    </h5>
                </div>
                @endif
                <table>
                    <tfoot>
                    {!! $addons->links() !!}
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        "use strict";
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });


            $('#column3_search').on('change', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
@endpush
