@extends('Panel.layout.master')

@section('message-box')

@endsection

@section('container')
    <div class="py-3 px-3 w-full">
        <div class="w-1/2 md:w-1/6 mx-auto m-2">
            <a href="{{route('panel.ticket-add')}}" class="bg-sky-500 rounded-md flex items-center justify-center">
                <p class="text-center font-semibold p-2">ثبت تیکت جدید</p>
                <i class="fa-solid fa-plus w-6 h-6  pr-3"></i>
            </a>
        </div>
        <table class="table-fixed  mx-auto  w-full sm:w-2/3 md:w-3/4 lg:w-3/5 xl:w-3/6">
            <thead class="bg-sky-500 ">
            <tr class="text-white ">
                <th class=" w-1/3 py-3 font-semibold">#</th>
                <th class=" w-1/3 py-3 font-semibold">عنوان</th>
                <th class=" w-1/3 py-3 font-semibold">تاریخ</th>
                <th class=" w-1/3 py-3 font-bold">جزئیات</th>
                <th class=" w-1/3 py-3 font-bold">ورود به حساب کاربری</th>

            </tr>
            </thead>
            <tbody id="tickets_body">
            @foreach($tickets as $key=> $ticket)
                <tr class="py-6 text-black text-sm sm:text-base">
                    <td class=" w-1/3  text-center py-2">{{$ticket->id}}</td>
                    <td class=" w-1/3 text-center py-2 cursor-pointer  "><a
                            href="{{route('panel.admin.ticket-chat',$ticket->id)}}"
                            class="decoration-2 decoration-sky-500 underline underline-offset-8 text-sky-500 ">{{$ticket->subject}}</a>
                    </td>
                    <td class=" w-1/3  text-center py-2">{{\Morilog\Jalali\Jalalian::forge($ticket->created_at)->format('Y/m/d H:i:s')}}</td>
                    <td class=" w-1/3  text-center py-2">{{$ticket->ticketStatus()}}</td>
                    @if($ticket->user->type!='admin')
                        <td class=" w-1/3  text-center py-2"><a
                                href="{{route('panel.admin.login-another-user',$ticket->user_id)}}">وارد شوید</a></td>
                    @else
                        ---
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script-tag')
    <script>
        var current_page = {{$tickets->currentPage()}};
        var has_more = "{{$tickets->hasMorePages()}}";
        var requesting = false;
        $(window).on("scroll", (e) => {
            var scrollHeight = $(document).height();
            var scrollPosition = $(window).height() + $(window).scrollTop();
            if ((scrollHeight - scrollPosition) < 1) {
                if (has_more && !requesting)
                    get_next_page();
            }
        });

        function get_next_page() {
            requesting = true;
            $.ajax({
                type: "GET",
                url: "{{route('panel.admin.ticket-page')}}",
                data: {'page': ++current_page},
                success: function (response) {
                    if (response.success) {
                        has_more = response.has_more;
                        var content = '';
                        for (var i = 0; i < response.data.data.length; i++) {
                            content += '<tr id="ticket_row" class="py-6 text-black text-sm sm:text-base">' +
                                '<td class=" w-1/3  text-center py-2">' + response.data.data[i].id + '</td>' +
                                '<td class=" w-1/3 text-center py-2 cursor-pointer  "><a ' +
                                ' href="{{route('panel.admin.ticket-chat',$ticket->id)}}"' +
                                ' class="decoration-2 decoration-sky-500 underline underline-offset-8 text-sky-500 ">' + response.data.data[i].subject + '</a>' +
                                '</td>' +
                                '<td class=" w-1/3  text-center py-2">' + response.data.data[i].date + '</td>' +
                                '<td class=" w-1/3  text-center py-2">' + response.data.data[i].status + '</td>' +
                                '</tr>';
                        }
                        $('#tickets_body').append(content);
                    }
                    requesting = false;
                }
            });
        }
    </script>
@endsection
