@extends('Panel.layout.master')

@section('container')
    <h1 class="text-center text-sky-500">متن تیکت</h1>
    <h3 class="text-center">{{$ticket->subject}}</h3>
    <div class="md:w-1/2 mx-auto p-2">
        <div class="h-[70vh] overflow-auto">
            @foreach($ticket_messages as $ticket_message)
                    <div class="mb-2 flex flex-wrap justify-center">
                        <div class="w-full">
                            <p class="p-3 bg-cyan-800 rounded-lg rounded-bl-none w-fit {{$ticket_message->user_id ? 'float-left':''}}">{{$ticket_message->message}}</p>
                        </div>
                        <span class="text-xs text-gray-500">{{$ticket_message->created_at}}</span>
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
        $('#send_message').on('click',(e)=>{
            const message = $('#input_message').val();
            if(!message)
                return null;
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                url: "{{route('panel.ticket-client-message')}}",
                data: {'ticket_id':{{$ticket->id}},'message':message},
                success: function(response){
                    if(response.success){
                        console.log(response.data);
                    }
                }
            });
        });
    </script>
@endsection

