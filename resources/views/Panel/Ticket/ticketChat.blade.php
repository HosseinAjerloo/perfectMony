@extends('Panel.layout.master')

@section('container')
    <h1 class="text-center text-sky-500">متن تیکت</h1>
    <h3 class="text-center">{{$ticket->subject}}</h3>
    <div class="md:w-1/2 mx-auto p-2">
        <div id="messages" class="h-[70vh] overflow-auto">
            @foreach($ticket_messages as $ticket_message)
                <div class="mb-2 flex flex-wrap justify-center">
                    <div class="w-full">
                        @if($ticket_message->type=='message')
                            <div
                                class="p-3 rounded-xl w-fit @if($ticket_message->user_id)  rounded-bl-none bg-cyan-800 @else float-left rounded-br-none bg-cyan-600 @endif ">
                                <p>{{$ticket_message->message}}</p>
                            </div>
                        @endif
                        @if($ticket_message->user_id and $ticket_message->type=='file' and $ticket_message->image)

                            <div class="p-3 rounded-xl  flex w-full">
                                <div class="p-3 rounded-xl  flex w-full  ">
                                    <img src="{{asset($ticket_message->image->path)}}" alt=""
                                         class="w-52 h-52 rounded-md dowbload cursor-pointer"
                                         data-val="{{route('panel.ticket.download',$ticket_message->image->id)}}">
                                </div>
                            </div>
                        @endif
                        @if($ticket_message->admin_id and $ticket_message->type=='file' and $ticket_message->image)
                            <div class="p-3 rounded-xl  flex w-full">

                                <div class="p-3 rounded-xl  flex w-full justify-end">
                                    <img src="{{asset($ticket_message->image->path)}}" alt=""
                                         class="w-52 h-52 rounded-md dowbload cursor-pointer"
                                         data-val="{{route('panel.ticket.download',$ticket_message->image->id)}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <span
                        class="text-xs text-gray-500">{{Morilog\Jalali\Jalalian::forge($ticket_message->created_at)->format('h:i Y/m/d')}}</span>
                </div>
            @endforeach


        </div>

        <div class="relative">
            <label class="p-2 flex justify-between">
                <button id="send_message" type="button" class="rounded-full border-2 border-sky-500 w-[57px] h-[48px]">
                    <i class="fa-solid fa-paper-plane-top fa-xl text-sky-500 p-1"></i>
                </button>
{{--                <input id="input_message" type="text" class="rounded-lg bg-gray-500 w-full mr-2 p-2" @if($ticket->status=='closed') disabled @endif placeholder="@if($ticket->status=='closed') تیکت بسته شده است@endif">--}}

                <textarea id="input_message" type="text" class="rounded-lg bg-gray-500 w-full mr-2  resize-none  " @if($ticket->status=='closed') readonly disabled @endif>@if($ticket->status=='closed') تیکت بسته شده است@endif</textarea>

            @if($ticket->status!='closed')
                    <i class="fa-solid fa-link w-8 h-8 top-4 left-3 absolute cursor-pointer bg-gray-500 z-10 file"></i>
                @endif
                <input type="file" class="hidden" id="file" name="file">
                {{--                <form action="{{route('test')}}" method="post" enctype="multipart/form-data">--}}
                {{--                    @csrf--}}
                {{--                    <input type="submit" value="send" class="p-96">--}}
                {{--                </form>--}}
            </label>

           @if($ticket->status!='closed')
                <section
                    class="file-demo absolute w-full h-12 box-border  bottom-96 right-40  transition-all duration-1000 invisible z-[100]">
                    <article class="flex justify-center items-center h-64">
                        <div class=" w-full bg-white p-2 rounded-md space-y-2 sm:w-3/5 md:w-3/6">
                            <i class="fas fa-times-circle text-sky-500 w-8 h-8 close"></i>
                            <img src="{{asset('src/images/them.jpg')}}" alt=""
                                 class="h-64 w-full bg-origin-content rounded-md bg-live">
                            <button class="py-1.5 px-2 rounded-md bg-sky-500 text-sm sm:text-base send">ارسال عکس</button>
                            <p class="text-rose-500 font-semibold text-sm sm:text-base">عکس ارسالی شما نمیتواند بیشتر از 3 مگابایت باشد</p>
                        </div>
                    </article>
                </section>
           @endif
        </div>

    </div>
@endsection


@section('script-tag')
    <script>
        const messages = $('#messages');
        $(document).ready(function () {
            messages.animate({scrollTop: messages.prop("scrollHeight")}, 200);
        });
        $('#send_message').on('click', (e) => {
            const message = $('#input_message').val();
            if (!message)
                return null;
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                url: "{{route('panel.ticket-client-message')}}",
                data: {'ticket_id': {{$ticket->id}}, 'message': message},
                success: function (response) {
                    if (response.success) {
                        console.log(response.data);
                        $('#input_message').val('');
                        const client_new_message = ' <div class="mb-2 flex flex-wrap justify-center">' +
                            '<div class="w-full">' +
                            '<p class="p-3 bg-cyan-800 rounded-xl rounded-bl-none w-fit ">' + response.data.message + '</p>' +
                            '</div>' +
                            '<span class="text-xs text-gray-500">' + response.data.jalali_date + '</span>' +
                            '</div>';
                        $('#messages').append(client_new_message);
                        messages.animate({scrollTop: messages.prop("scrollHeight")}, 500);
                        $('#input_message').css({'height':'auto'})
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            let file = $("#file");
            $(".file").click(function () {
                $(file).trigger('click')
            })

            $(".close").click(function () {
                $('.file-demo').addClass('invisible')
                $('.file-demo').removeClass('visibility')
                $('.file-demo').addClass('right-40')
                $('.file-demo').removeClass('right-0')
            })
            $(file).change(function () {

                let urlImage = showLiveFile();
                if (urlImage) {
                    $('.file-demo').removeClass('invisible')
                    $('.file-demo').addClass('visibility')
                    $('.file-demo').removeClass('right-40')
                    $('.file-demo').addClass('right-0')

                    $(".bg-live").attr('src', urlImage)
                }
            })
        })
    </script>
    <script>
        $(document).ready(function () {
            let count = 0;
            let file = $("#file");

            $('.send').click(function () {
                let fileData = $(file).get(0).files[0];
                console.log(fileData)

                let elementMessage = '';
                if (imageValidation.includes(fileData.type)) {
                    let myFormData = new FormData();
                    myFormData.append('image', fileData);
                    myFormData.append('_token', "{{csrf_token()}}")
                    myFormData.append('ticket_id', "{{$ticket->id}}")
                    $.ajax({
                        url: "{{route('panel.ticket-client-message')}}",
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        data: myFormData,
                        headers: {
                            "Accept": "application/json"
                        },
                        mimeType: "multipart/form-data",
                        success: function (response) {
                            if (response.success) {
                                let parentImage = $('#messages');
                                console.log(response.data.path);

                                elementMessage =
                                    ' <div class="mb-2 flex flex-wrap justify-center"> ' +
                                    '<div class="w-full relative z-10 bg-gray-950 " >' +
                                    '<div class="p-3 rounded-xl  flex w-full">' +
                                    '<div class="p-3 rounded-xl  flex w-full flex ">' +
                                    '   <img src="' + response.data.crs + '" alt="" class="w-52 h-52 rounded-md dowbload cursor-pointer" data-val="' + response.data.value + '">' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<span class="text-xs text-gray-500">' + response.data.jalali_date + '</span>' +
                                    '</div>';
                                parentImage.append(elementMessage)
                                $('.close').trigger('click')
                                download();
                            }
                        }

                    });


                }


            })
        })
    </script>
    <script>
        let imageValidation = ['image/png', 'image/jpeg', 'image/jpg'];

        function showLiveFile() {
            let files = $("#file");
            let src;
            var _URL = window.URL || window.webkitURL;

            var image, file;
            if ((file = $(files).get(0).files[0])) {
                image = new Image();
                image.onload = function () {

                }
            }

            if (imageValidation.includes(file.type)) {
                image.src = _URL.createObjectURL(file);
                return image.src;
            }
            return false;

        }
    </script>
    <script>
        function download() {
            $(".dowbload").click(function () {
                let data = $(this).attr('data-val')

                window.location.href = data;
            })
        }

        download();
    </script>

    <script>
        document.querySelectorAll('textarea').forEach( element => {
            element.style.height = `${element.scrollHeight}px`;
            element.addEventListener('input', event => {
                event.target.style.height = 'auto';
                event.target.style.height = `${event.target.scrollHeight}px`;
            })
        })
    </script>
@endsection

