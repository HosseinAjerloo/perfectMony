@extends('Panel.layout.master')


@section('container')

    <section class="py-3 px-3 w-full space-y-3 ">

        @foreach($financeTransactions as $financeTransaction)

            <article class="min-w-full w-full ">
                <div class="min-w-full w-full flex flex-col space-y-3 bg-sky-500 rounded-ss-md rounded-se-md">
                    <div class="flex items-center min-w-full  justify-between border-b-4 border-gray-200">
                        <div class="text-[11.5px] w-1/12 font-semibold  text-center py-2">شماره سفارش</div>
                        <div class="text-[11.5px] w-2/12 font-semibold  text-center py-2">تاریخ</div>
                        <div class="text-[11.5px] w-1/4 font-semibold  text-center py-2">تراکنش</div>
                        <div class="text-[11.5px] w-2/12  font-semibold text-center py-2">مبلغ به هزارتومان</div>
                        <div class="text-[11.5px] w-1/12 font-semibold text-center py-2">وضعیت</div>
                        <div class="text-[11.5px] w-2/12 font-semibold text-center py-2">مانده به هزارتومان</div>
                    </div>
                </div>
                <div class="min-w-full w-full flex flex-col bg-slate-50 text-black p-2 rounded-ee-md rounded-es-md">
                    <div class="flex items-center min-w-full  justify-between ">
                        <div
                            class="font-semibold text-[11.5px] w-1/12  text-center py-2">
                            {{$financeTransaction->id}}
                        </div>
                        <div
                            class="font-semibold text-[11.5px] w-2/12  text-center py-2">{{\Morilog\Jalali\Jalalian::forge($financeTransaction->created_at)->format('Y/m/d H:i:s')}}</div>
                        <div
                            class="text-[11.5px] w-1/4 font-semibold  text-center py-2">{{$financeTransaction->description??''}}</div>
                        <div class="text-[11.5px] w-2/12 text-center py-2 ">

                            <div class="flex items-center justify-center">
                                <p class="font-semibold text-[11.5px]">{{ strrev(substr(strrev($financeTransaction->amount),4))!=""?strrev(substr(strrev($financeTransaction->amount),4)):0}}</p>
                                @if($financeTransaction->type=="deposit")
                                    <i class="fa-solid fa-plus text-[11.5px] text-green-400"></i>

                                @elseif($financeTransaction->type=="withdrawal")
                                    <i class="fa-solid fa-minus text-[11.5px] text-rose-500"></i>
                                @endif
                            </div>
                        </div>
                        <div class="text-[11.5px] w-1/12  text-center py-2">
                            @if($financeTransaction->type!="bank")
                                <i class="fa-solid fa-check text-[11.5px] text-green-400"></i>
                            @else
                                <i class="fas fa-times-circle text-[11.5px] text-rose-500"></i>
                            @endif
                        </div>
                        <div class="text-[11.5px] w-2/12  text-center py-2 font-semibold">
                            {{strrev(substr(strrev($financeTransaction->creadit_balance),4))!=""?strrev(substr(strrev($financeTransaction->creadit_balance),4)):0}}
                        </div>
                    </div>
                    @if($financeTransaction->voucher)

                        <div class="border-2 rounded-md border-gray-300 p-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold sm:text-base">
                                    کد فعال سازی:
                                </p>
                                <div class="flex items-center space-x-3 space-x-reverse">
                                    <span class="text-sm sm:text-base">{{$financeTransaction->voucher->code}}</span>
                                    <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                         class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold sm:text-base">
                                    شماره ووچر:
                                </p>
                                <div class=" relative">
                                    <div class="flex items-center space-x-3 space-x-reverse">
                                        <span
                                            class="text-sm sm:text-base">{{$financeTransaction->voucher->serial}}</span>
                                        <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                             class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif


                    @if($financeTransaction->transmission)

                        <div class="border-2 rounded-md border-gray-300 p-3">

                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold sm:text-base">
                                    مبلغ انتقال:
                                </p>
                                <div class="flex items-center space-x-3 space-x-reverse">
                                    <span
                                        class="text-sm sm:text-base ">{{$financeTransaction->transmission->payment_amount}} دلاری</span>
                                    <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                         class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold sm:text-base">
                                    کد رهگیری:
                                </p>
                                <div class="flex items-center space-x-3 space-x-reverse">
                                    <span
                                        class="text-sm sm:text-base">{{$financeTransaction->transmission->payment_batch_num}}</span>
                                    <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                         class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold sm:text-base">
                                    شماره حساب گیرنده:
                                </p>
                                <div class=" relative">
                                    <div class="flex items-center space-x-3 space-x-reverse">
                                        <span
                                            class="text-sm sm:text-base">{{$financeTransaction->transmission->payee_account}}</span>
                                        <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                             class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </article>

        @endforeach
        {{--        <article class="min-w-full w-full ">--}}
        {{--            <div class="min-w-full w-full flex flex-col bg-slate-200 text-black p-2 rounded-md">--}}
        {{--                <div class="flex items-center min-w-full  justify-between ">--}}
        {{--                    <div class="text-[11.5px] w-2/12  text-center py-2">1403/02/01 11:07</div>--}}
        {{--                    <div class="text-[11.5px] w-1/4  text-center py-2">صدور کارت هدیه پرفکت مانی</div>--}}
        {{--                    <div class="text-[11.5px] w-2/12 text-center py-2">120،000</div>--}}
        {{--                    <div class="text-[11.5px] w-1/12  text-center py-2">--}}
        {{--                        <i class="fa-solid fa-plus text-[11.5px] text-green-400"></i>--}}
        {{--                    </div>--}}
        {{--                    <div class="text-[11.5px] w-2/12  text-center py-2">120،000</div>--}}
        {{--                </div>--}}


        {{--            </div>--}}

        {{--        </article>--}}

        {{--        <article class="min-w-full w-full ">--}}
        {{--            <div class="min-w-full w-full flex flex-col bg-slate-50 text-black p-2 rounded-md">--}}
        {{--                <div class="flex items-center min-w-full  justify-between ">--}}
        {{--                    <div class="text-[11.5px] w-2/12  text-center py-2">1403/02/01 11:07</div>--}}
        {{--                    <div class="text-[11.5px] w-1/4  text-center py-2">صدور کارت هدیه پرفکت مانی</div>--}}
        {{--                    <div class="text-[11.5px] w-2/12 text-center py-2">120،000</div>--}}
        {{--                    <div class="text-[11.5px] w-1/12  text-center py-2"><i--}}
        {{--                            class="fa-solid fa-minus text-[11.5px] text-rose-500"></i></div>--}}
        {{--                    <div class="text-[11.5px] w-2/12  text-center py-2">120،000</div>--}}
        {{--                </div>--}}
        {{--                <div class="flex items-center justify-between">--}}
        {{--                    <p class="text-sm font-semibold sm:text-base">--}}
        {{--                        کد فعال سازی:--}}
        {{--                    </p>--}}
        {{--                    <div class="flex items-center space-x-3 space-x-reverse">--}}
        {{--                        <span class="text-sm sm:text-base">100001515645</span>--}}
        {{--                        <img src="{{asset('src/images/Group 422.png')}}" alt=""--}}
        {{--                             class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="flex items-center justify-between">--}}
        {{--                    <p class="text-sm font-semibold sm:text-base">--}}
        {{--                        شماره ووچر:--}}
        {{--                    </p>--}}
        {{--                    <div class=" relative">--}}
        {{--                        <div class="flex items-center space-x-3 space-x-reverse">--}}
        {{--                            <span class="text-sm sm:text-base">465465</span>--}}
        {{--                            <img src="{{asset('src/images/Group 422.png')}}" alt=""--}}
        {{--                                 class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">--}}
        {{--                        </div>--}}

        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        {{--        </article>--}}
        {{--        <article class="min-w-full w-full ">--}}
        {{--            <div class="min-w-full w-full flex flex-col bg-slate-200 text-black p-2 rounded-md">--}}
        {{--                <div class="flex items-center min-w-full  justify-between ">--}}
        {{--                    <div class="text-[11.5px] w-2/12  text-center py-2">1403/02/01 11:07</div>--}}
        {{--                    <div class="text-[11.5px] w-1/4  text-center py-2">افزایش مبلغ کیف پول درگاه بانک سامان</div>--}}
        {{--                    <div class="text-[11.5px] w-2/12 text-center py-2">120،000</div>--}}
        {{--                    <div class="text-[11.5px] w-1/12  text-center py-2">--}}
        {{--                        <i class="fa-solid fa-plus text-[11.5px] text-green-400"></i>--}}
        {{--                    </div>--}}
        {{--                    <div class="text-[11.5px] w-2/12  text-center py-2">120،000</div>--}}
        {{--                </div>--}}


        {{--            </div>--}}

        {{--        </article>--}}

        {{--        <article class="min-w-full w-full ">--}}
        {{--            <div class="min-w-full w-full flex flex-col bg-slate-200 text-black p-2 rounded-md">--}}
        {{--                <div class="flex items-center min-w-full  justify-between ">--}}
        {{--                    <div class="text-[11.5px] w-2/12  text-center py-2">1403/02/01 11:07</div>--}}
        {{--                    <div class="text-[11.5px] w-1/4  text-center py-2">افزایش مبلغ کیف پول درگاه بانک سامان</div>--}}
        {{--                    <div class="text-[11.5px] w-2/12 text-center py-2">120،000</div>--}}
        {{--                    <div class="text-[11.5px] w-1/12  text-center py-2">--}}
        {{--                        <i class="fas fa-times-circle text-[11.5px] text-rose-500"></i>--}}
        {{--                    </div>--}}
        {{--                    <div class="text-[11.5px] w-2/12  text-center py-2">120،000</div>--}}
        {{--                </div>--}}
        {{--              --}}

        {{--            </div>--}}

        {{--        </article>--}}
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
