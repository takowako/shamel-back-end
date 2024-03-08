
<div class="card h-100">
    <!-- Header -->
    <div class="card-header">
        <div class="chat-user-info w-100 d-flex align-items-center">
            <div class="chat-user-info-img">
                <img class="avatar-img onerror-image"
                     data-onerror-image="{{dynamicAsset('public/assets/admin/img/160x160/img1.jpg')}}"
                     src="{{\App\CentralLogics\Helpers::onerror_image_helper($user['image'], dynamicStorage('storage/app/public/profile/').'/'.$user['image'], dynamicAsset('public/assets/admin/img/160x160/img1.jpg'), 'profile/')}}"
                     alt="Image Description">
            </div>
            <div class="chat-user-info-content">
                <h5 class="mb-0 text-capitalize">
                    {{$user['f_name'].' '.$user['l_name']}}</h5>
                <span>{{ $user['phone'] }}</span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="scroll-down">
            @foreach($convs as $con)
                @if($con->sender_id != $vendor->id)
                    <div class="pt1 pb-1">
                        <div class="conv-reply-1">
                            <h6>{{$con->message}}</h6>
                            @if($con->file!=null)
                            @foreach (json_decode($con->file) as $img)
                            <br>
                                <img class="w-100"
                                src="{{dynamicStorage('storage/app/public/conversation').'/'.$img}}">
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="pl-1">
                        <small>                {{ Carbon\Carbon::parse($con->created_at)->locale(app()->getLocale())->translatedFormat('d M Y')  }} {{ Carbon\Carbon::parse($con->created_at)->locale(app()->getLocale())->translatedFormat(config('timeformat'))}}
</small>
                    </div>
                @else
                    <div class="pt-1 pb-1">
                        <div class="conv-reply-2">
                            <h6>{{$con->message}}</h6>
                            @if($con->file!=null)
                            @foreach (json_decode($con->file) as $img)
                            <br>
                                <img class="w-100"
                                src="{{dynamicStorage('storage/app/public/conversation').'/'.$img}}">
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="text-right pr-1">
                        <small>                {{ Carbon\Carbon::parse($con->created_at)->locale(app()->getLocale())->translatedFormat('d M Y')  }} {{ Carbon\Carbon::parse($con->created_at)->locale(app()->getLocale())->translatedFormat(config('timeformat'))}}
</small>
                        @if ($con->is_seen == 1)
                        <span class="text-primary"><i class="tio-checkmark-circle"></i></span>
                        @else
                        <span><i class="tio-checkmark-circle-outlined"></i></span>
                        @endif
                    </div>
                @endif
            @endforeach
            <div id="scroll-here"></div>
        </div>

    </div>
    <!-- Body -->
    <div class="card-footer border-0 conv-reply-form">

        <form action="javascript:" method="post" id="reply-form-vnd" enctype="multipart/form-data">
            @csrf
            <div class="quill-custom_">
                <label for="msg" class="layer-msg">

                </label>
                <textarea class="form-control pr--180" id="msg" rows = "1" name="reply"></textarea>
                <div id="coba">
                </div>
                <button type="submit"
                        class="btn btn-primary btn--primary con-reply-btn">{{translate('messages.send')}}
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{{dynamicAsset('public/assets/admin')}}/js/view-pages/common.js"></script>
<script>
    "use strict";

    $(document).ready(function () {
        $('.scroll-down').animate({
            scrollTop: $('#scroll-here').offset().top
        },0);
    });

    $(function() {
        $("#coba").spartanMultiImagePicker({
            fieldName: 'images[]',
            maxCount: 3,
            rowHeight: '55px',
            groupClassName: 'attc--img',
            maxFileSize: '',
            placeholderImage: {
                image: '{{ dynamicAsset('public/assets/admin/img/attatchments.png') }}',
                width: '100%'
            },
            dropFileLabel: "Drop Here",
            onAddRow: function(index, file) {

            },
            onRenderedPreview: function(index) {

            },
            onRemoveRow: function(index) {

            },
            onExtensionErr: function(index, file) {
                toastr.error('{{ translate('messages.please_only_input_png_or_jpg_type_file') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
            onSizeErr: function(index, file) {
                toastr.error('{{ translate('messages.file_size_too_big') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        });
    });


    $('#reply-form-vnd').on('submit', function() {
        $('button[type=submit], input[type=submit]').prop('disabled',true);
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('vendor.message.store', ['user_id'=>$user->id,'user_type'=>$user_type]) }}',
                data: $('reply-form-vnd').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.errors && data.errors.length > 0) {

                        if (data.errors[1] && data.errors[1].code == 'images') {
                            toastr.error(data.errors[1].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        } else {

                            $('button[type=submit], input[type=submit]').prop('disabled',false);
                            toastr.error('{{ translate('Write something to send massage!') }}', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    }else{

                        toastr.success('Message sent', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#view-conversation').html(data.view);
                    }
                },
                error() {
                    toastr.error('{{ translate('Write something to send massage!') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
</script>
