@extends('Panel.layout.master')

@section('container')
    <h1>متن تیکت</h1>
    <h3>{{$ticket->subject}}</h3>
    <div class="md:w-1/2 mx-auto p-2">
        @foreach($ticket_messages as $ticket_message)
            @if($ticket_message->user_id)
                <div>
                    <p>{{$ticket_message->message}}</p>
                </div>
            @else
                <div>
                    <p>{{$ticket_message->message}}</p>
                </div>
            @endif
        @endforeach
    </div>
@endsection


@section('script-tag')
    <script>

    </script>
@endsection

