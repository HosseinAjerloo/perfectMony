@extends('Panel.layout.master')

@section('container')
    <h1 class="text-center text-sky-500">متن تیکت</h1>
    <h3 class="text-center">{{$ticket->subject}}</h3>
    <div class="md:w-1/2 mx-auto p-2">
        <div id="messages" class="h-[70vh] overflow-auto">
            @foreach($ticket_messages as $ticket_message)
                <div class="mb-2 flex flex-wrap justify-center">
                    <div class="w-full ticket-message">
                        <div
                            class="p-3 rounded-xl w-fit @if($ticket_message->user_id) float-left rounded-bl-none bg-cyan-800 @else rounded-br-none bg-cyan-600 @endif ">
                            <p>{{$ticket_message->message}}</p>
                        </div>
                        @if($ticket_message->user_id)
                            <div class="p-3 rounded-xl  flex w-full">
                                <div class="p-3 rounded-xl  flex w-full flex justify-end">
                                    <img src="{{asset('src/images/them.jpg')}}" alt="" class="w-52 h-52 rounded-md">
                                </div>
                            </div>
                            <div class="p-3 rounded-xl  flex w-full">
                                <div class="p-3 rounded-xl  flex w-full flex justify-end">
                                    <img src="{{asset('src/images/them.jpg')}}" alt="" class="w-52 h-52 rounded-md">
                                </div>
                            </div>

                        @else
                            <div class="p-3 rounded-xl  flex w-full">

                                <div class="p-3 rounded-xl  flex w-full">
                                    <img src="{{asset('src/images/them.jpg')}}" alt="" class="w-52 h-52 rounded-md">
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
                <input id="input_message" type="text" class="rounded-lg bg-gray-500 w-full mr-2 p-2">
                <i class="fa-solid fa-link w-8 h-8 top-4 left-3 absolute cursor-pointer bg-gray-500 z-10 file"></i>
                <input type="file" class="hidden" id="file" name="file">
                {{--                <form action="{{route('test')}}" method="post" enctype="multipart/form-data">--}}
                {{--                    @csrf--}}
                {{--                    <input type="submit" value="send" class="p-96">--}}
                {{--                </form>--}}
            </label>

            <section
                class="file-demo absolute w-full h-12 box-border  bottom-96 right-40  transition-all duration-1000 invisible">
                <article class="flex justify-center items-center h-64">
                    <div class=" w-full bg-white p-2 rounded-md space-y-2 sm:w-3/5 md:w-3/6">
                        <i class="fas fa-times-circle text-sky-500 w-8 h-8 close"></i>
                        <img src="{{asset('src/images/them.jpg')}}" alt=""
                             class="h-64 w-full bg-origin-content rounded-md bg-live">
                        <button class="py-1.5 px-2 rounded-md bg-sky-500 text-sm sm:text-base send">ارسال عکس</button>
                    </div>
                </article>
            </section>
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
                            '<p class="p-3 bg-cyan-800 rounded-xl rounded-bl-none w-fit float-left">' + response.data.message + '</p>' +
                            '</div>' +
                            '<span class="text-xs text-gray-500">' + response.data.jalali_date + '</span>' +
                            '</div>';
                        $('#messages').append(client_new_message);
                        messages.animate({scrollTop: messages.prop("scrollHeight")}, 500);
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
            let file = $("#file");

            $('.send').click(function () {
                let fileData = $(file).get(0).files[0];
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

                    });

                    let parentImage = $('.ticket-message');
                    let urlImage = showLiveFile();
                    let elementMessage =
                        '<div class="p-3 rounded-xl  flex w-full">' +
                        '<div class="p-3 rounded-xl  flex w-full flex justify-end">' +
                        '   <img src="' + urlImage + '" alt="" class="w-52 h-52 rounded-md test">' +
                        '</div>' +
                        '</div>';
                    $(parentImage).append(elementMessage)
                }
                $('.close').trigger('click')


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
@endsection

