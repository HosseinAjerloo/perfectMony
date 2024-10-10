@extends('Panel.layout.master')

@section('message-box')

    <section class="space-y-9">
        <div class="space-y-9 print">
            <div
                class=" space-x-2 space-x-reverse bg-green-500 text-white p-2 rounded-md font-bold flex items-center justify-center">
                <i class="fas fa-check-circle"></i>
                <p class="text-sm">حواله پرفکت مانی شما با موفقیت انجام شد</p>
            </div>
            <section class=" border-2 border-2-white rounded-md py-3 px-3 text-sm sm:text-base  ">
                <section class="space-y-3">
                    <div class="flex items-center space-x-reverse space-x-1">
                        <p>مبلغ حواله :</p>
                        <h1 class="font-semibold text-lg"> {{$transitionDelivery->payment_amount??''}} دلار</h1>
                    </div>
                    <div class=" relative">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <p>کد رهگیری :</p>
                            <span class="text-sm sm:text-base bg-gray-500 px-6 py-1 rounded-md">{{$transitionDelivery->payment_batch_num??''}}</span>
                            <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                 class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <p>حساب مقصد :</p>
                            <span class="text-sm sm:text-base">{{$transitionDelivery->payee_account??''}}</span>
                        </div>
                    </div>
                </section>
            </section>
        </div>

        <section class="flex items-center justify-between">
            <div class="bg-green-500 rounded-md font-semibold py-1 w-1/4 flex items-center justify-center cursor-pointer">
                <a href="{{route('panel.index')}}">تایید</a>
            </div>
            <div class="bg-white rounded-md font-semibold  py-1 w-1/4 flex items-center justify-center share cursor-pointer">

                <img src="{{asset('src/images/share.svg')}}" alt="" class="w-5 h-5">
            </div>
            <div
                class="bg-sky-600 rounded-md font-semibold  py-1.5 px-2 box-content  text-sm flex items-center justify-center cursor-pointer">
                دریافت رسید
            </div>
        </section>

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
