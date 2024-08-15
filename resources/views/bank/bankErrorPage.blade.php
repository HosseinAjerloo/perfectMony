@extends('Panel.layout.master')

@section('message-box')

    <section class="space-y-9">
        <div class="text-center bg-rose-500 text-white p-2 rounded-md font-bold">
            تراکنش ناموفق
        </div>
        <h1 class=" border-2 border-2-white rounded-md py-3 px-3 text-sm sm:text-base font-semibold  ">
            اگر پول از حساب شما کسر شده است حداکثر تا 72 ساعت
            به حساب شما عودت می گردد.
            ناموفق بودن تراکنش به بانک اعلام شد.
        </h1>

    </section>


@endsection

@section('container')
    <section class=" px-3 text-sm sm:text-base flex space-x-4 space-x-reverse mx-auto md:w-3/4 lg:w-3/6">
        <p>شماره تراکنش :</p>
        <div>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 space-x-reverse mb-2">
                    <span class="text-sm sm:text-base font-bold bg-gray-400 rounded-sm px-6  py-1">{{$payment->order_id??''}}</span>
                    <img src="{{asset('src/images/Group 422.png')}}" alt=""
                         class="w-6 h-6 copy cursor-pointer transition-all hover:scale-125">
                </div>
            </div>
        </div>
    </section>
    <section class=" px-3 text-sm sm:text-base flex space-x-2 space-x-reverse mx-auto md:w-3/4 lg:w-3/6 items-center ">
        <img src="{{asset('src/images/samanBank.png')}}" alt="" class="w-10 h-10">
        <p>پشتیبانی بانک سامان : 6422-021</p>
    </section>
@endsection
@section('script-tag')

    <script>

        function copyToClipboard(text) {

            var textArea = document.createElement("textarea");
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                console.log('Copying text command was ' + msg);
            } catch (err) {
                console.log('Oops, unable to copy', err);
            }
            document.body.removeChild(textArea);
        }

        $('.copy').click(function () {

            let spanText = $(this).siblings('span').text();
            copyToClipboard(spanText);
        });
    </script>
@endsection
