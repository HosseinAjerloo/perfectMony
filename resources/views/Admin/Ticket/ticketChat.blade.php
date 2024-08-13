@extends('Panel.layout.master')

@section('container')
    <h1 class="text-center text-sky-500">متن تیکت</h1>
    <h3 class="text-center">{{$ticket->subject}}</h3>
    <div class="md:w-1/2 mx-auto p-2">
        <div id="messages" class="h-[70vh] overflow-auto">
            @foreach($ticket_messages as $ticket_message)
                    <div class="mb-2 flex flex-wrap justify-center">
                        <div class="w-full">
                            <p class="p-3 rounded-xl w-fit {{$ticket_message->admin_id ? 'float-left rounded-bl-none bg-cyan-800':'rounded-br-none bg-cyan-600'}}">{{$ticket_message->message}}</p>
                        </div>
                        <span class="text-xs text-gray-500">{{Morilog\Jalali\Jalalian::forge($ticket_message->created_at)->format('h:i Y/m/d')}}</span>
                    </div>
            @endforeach
        </div>
        <div class="">
            <label class="p-2 flex justify-between">
                <button id="send_message" type="button" class="rounded-full border-2 border-sky-500 w-[57px] h-[48px]">
                    <i class="fa-solid fa-paper-plane-top fa-xl text-sky-500 p-1"></i>
                </button>
                <input id="input_message" type="text" class="rounded-lg bg-gray-500 w-full mr-2 p-2">
            </label>
        </div>
    </div>
@endsection


@section('script-tag')
    <script>
        const messages = $('#messages');
        $(document).ready(function() {
            messages.animate({ scrollTop: messages.prop("scrollHeight") }, 200);
        });
        $('#send_message').on('click',(e)=>{
            const message = $('#input_message').val();
            if(!message)
                return null;
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                url: "{{route('panel.admin.ticket-message')}}",
                data: {'ticket_id':{{$ticket->id}},'message':message},
                success: function(response){
                    if(response.success){
                        $('#input_message').val('');
                        const client_new_message = ' <div class="mb-2 flex flex-wrap justify-center">'+
                            '<div class="w-full">'+
                            '<p class="p-3 bg-cyan-800 rounded-xl rounded-bl-none w-fit float-left">'+ response.data.message +'</p>'+
                            '</div>'+
                        '<span class="text-xs text-gray-500">'+ response.data.jalali_date +'</span>'+
                    '</div>';
                        $('#messages').append(client_new_message);
                        messages.animate({ scrollTop: messages.prop("scrollHeight") }, 500);
                    }
                }
            });
        });
    </script>
@endsection

