@extends('Panel.layout.master')

@section('message-box')

    <section class="space-y-9">
        <div class="space-y-9 print">
            <div
                class=" space-x-2 space-x-reverse bg-rose-500 text-white p-2 rounded-md font-bold flex items-center justify-center">
                <i class="fas fa-close text-white"></i>
                <p class="text-sm sm:text-base">متاسفانه حواله شما با خطا مواجه شده است</p>
            </div>
            <section class=" border-2 border-2-white rounded-md py-3 px-3 text-sm sm:text-base space-y-3 ">
                <div class=" flex items-center space-x-3 space-x-reverse">
                    <div class=" flex items-center justify-start  max-w-max   rounded-md wallet ">
                        <img src="{{asset('src/images/wallet.png')}}" alt="" class="w-6 h-6 ">
                    </div>
                    <p class="text-sm">مبلغ به کیف پول شما اضافه شده است</p>
                </div>
                <p>
                    لطفا چند دقیقه دیگر تلاش نمایید و تسویه حواله خود را با
                    کیف پول انجام دهید.
                </p>
            </section>
        </div>

        <form class="flex items-center justify-between">
            <div class="bg-rose-500 rounded-md font-semibold py-1 w-1/3 flex items-center justify-center cursor-pointer">
                <button class="text-sm">تلاش مجدد</button>
            </div>
            <div class="bg-sky-500 rounded-md font-semibold py-1  px-2 flex items-center justify-center cursor-pointer">
                <a class="text-sm" href="{{route('panel.ticket')}}">تیکت به پشتیبانی</a>
            </div>


        </form>

    </section>

@endsection

@section('script-tag')

    <script>
        $(".share").click(function () {
            let body = $("body").html();
            let htmlPrint = $('.print').html();
            $("body").html(htmlPrint);
            window.print()
            $("body").html(body);

        })

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
