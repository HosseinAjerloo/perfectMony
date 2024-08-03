@extends('Panel.layout.master')


@section('container')

    <section class="mx-auto px-4 sm:w-3/4 md:w-3/5 lg:w-2/5 space-y-5">

        <article class="border-2 rounded-md border-white p-3 space-y-3.5">
            <div class="text-sm sm:text-base flex items-center justify-between">
                <p>شماره سفارش: {{$financeTransaction->id}}</p>
                <p class="text-center">مبلغ کل:{{$financeTransaction->amount}} ریال</p>
            </div>
            <div class="text-sm sm:text-base flex items-center justify-between">
                @if($financeTransaction->voucher)
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <img src="{{asset('src/images/prl.png')}}" alt="">
                        <p>خرید ووچر پرفکت مانی {{$financeTransaction->voucher->voucherAmount()}} دلاری</p>
                    </div>
                @endif
                @if($financeTransaction->type!='deposit')
                    <p class="text-center">
                        نرخ دلار:
                        {{numberFormat($financeTransaction->time_price_of_dollars)}}
                        ریال
                    </p>
                @endif
            </div>

            <div class="text-sm sm:text-base flex items-center justify-between">
                <div class="flex items-center space-x-2 space-x-reverse">

                    <p>تاریخ ثبت سفارش:</p>
                    <p>{{\Morilog\Jalali\Jalalian::forge($financeTransaction->created_at)->format('%A, %d %B %y')}}</p>
                </div>
                <p class="text-center">
                    وضعیت:
                    @if($financeTransaction->status=='success')
                        <span class="text-green-400">انجام شده</span>
                    @else
                        <span class="text-red-700">درحال پردازش</span>
                    @endif
                </p>
            </div>
            <div class="text-sm sm:text-base flex items-center space-x-2 space-x-reverse">
                @if($financeTransaction->status=='success')
                    <img src="{{asset('src/images/Group 414.png')}}" alt="" class="h-8 w-8">
                @else
                    <img src="{{asset('src/images/warning.png')}}" alt="" class="h-4 w-6">
                @endif
                <p class="mb-2">{{$financeTransaction->description}}</p>
            </div>
            @if($financeTransaction->voucher)
                <div class="px-3 py-1.5 bg-white rounded-md text-black text-sm sm:text-base">
                    <div class="flex items-center space-x-16 space-x-reverse">
                        <p class="text-sm sm:text-base font-semibold">شماره ووچر:</p>


                        <div class=" items-center space-x-4 space-x-reverse text-sm sm:text-base font-semibold">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy">
                            <span class="inline-block"> {{$financeTransaction->voucher->serial}}</span>
                        </div>

                    </div>
                </div>
            @endif
            @if($financeTransaction->voucher)
                <div class="px-3 py-1.5 bg-white rounded-md text-black text-sm sm:text-base">
                    <div class="flex items-center space-x-16 space-x-reverse">
                        <p class="text-sm sm:text-base font-semibold">کد فعال سازی:</p>


                        <div class=" items-center space-x-4 space-x-reverse text-sm sm:text-base font-semibold">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy">
                            <span class="inline-block">{{$financeTransaction->voucher->code}}</span>
                        </div>

                    </div>
                </div>
            @endif
            <div class="px-3 py-1.5 bg-white rounded-md text-black text-sm sm:text-base">
                <div class="flex items-center space-x-16 space-x-reverse">
                    <p class="text-sm sm:text-base font-semibold">شماره سفارش:</p>
                    <div class=" items-center space-x-4 space-x-reverse text-sm sm:text-base font-semibold">
                        <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy">
                        <span class="inline-block">{{$financeTransaction->id}}</span>
                    </div>
                </div>
            </div>
        </article>

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
