@extends('Panel.layout.master')


@section('container')

    <section class="mx-auto px-4 sm:w-3/4 md:w-3/5 lg:w-2/5 space-y-5">
        <div class="border-2 border-white rounded-md  p-3 space-y-3.5">
            <div class="text-sm sm:text-base flex items-center justify-between">
                <p>شماره پیش فاکتور: {{$invoice->id}}</p>
                <p class="text-center">مبلغ کل:{{numberFormat($invoice->final_amount)}} ریال</p>
            </div>
            <div class="text-sm sm:text-base flex items-center justify-between">


                <div class="flex items-center space-x-2 space-x-reverse">
                    @switch($invoice->type)
                        @case('service')
                        @case('transmission')
                            <img src="{{asset('src/images/prl.png')}}" alt="">
                            <p>
                                {{$invoice->persianType()}}
                                @if($invoice->voucherAmount())
                                    {{$invoice->voucherAmount()}} دلاری
                                @endif
                            </p>
                            @break
                        @case('service')
                        @case('wallet')
                            <i class="fa-solid fa-wallet"></i>
                            <p>{{$invoice->persianType()}}</p>
                            @break
                        @default
                    @endswitch

                </div>

                <p class="text-center">
                    وضعیت:
                    @if($invoice->status=='finished')
                        <span class="text-green-400">انجام شده</span>
                    @else
                        <span class="text-red-700">پرداخت نشده</span>
                    @endif
                </p>
            </div>

            <div class="text-sm sm:text-base flex items-center justify-between">
                <div class="flex items-center space-x-2 space-x-reverse">

                    <p>تاریخ ثبت سفارش:</p>
                    <p>{{\Morilog\Jalali\Jalalian::forge($invoice->created_at)->format('%A, %d %B %y ساعت:  h:i:s')}}</p>
                </div>

            </div>

            @if($invoice->description)
                <div class="text-sm sm:text-base flex items-center justify-between">
                    <div class="flex items-center space-x-2 space-x-reverse">

                        <p>توضیحات:</p>
                        <p>{{$invoice->description}}</p>
                    </div>

                </div>
            @endif
            @if($invoice->transferm)
                <div class="text-sm sm:text-base flex items-center justify-between">
                    <div class="flex items-center space-x-2 space-x-reverse">

                        <p>شماره حساب مقصد:</p>
                        <p>{{$invoice->transferm->payee_account}}</p>
                    </div>

                </div>
            @endif
            <div class="text-sm sm:text-base flex items-center justify-between mt-2 mb-2 ">
                @if($invoice->bank_id)
                    <div class="flex flex-col space-y-3">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <p>پرداخت از طریق:</p>

                            <p>{{$invoice->bank->name}}</p>

                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            @if($invoice->status!='finished')

                                <img src="{{asset('src/images/samanBank.png')}}" alt="" class="w-10 h-10">
                                <p>پشتیبانی بانک سامان : 6422-021</p>
                            @endif

                            @else
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    <p>پرداخت از طریق:</p>
                                    <p>کیف پول</p>
                                </div>
                        </div>
                    </div>
                @endif
            </div>
            @if($invoice->payment)
                <div class="text-sm sm:text-base flex items-center justify-between">
                    <div class="flex items-center space-x-2 space-x-reverse">

                        <p>شماره تراکنش:</p>
                        <p>{{$invoice->payment->order_id}}</p>
                    </div>

                </div>
            @endif

            @if($invoice->voucher and $invoice->voucher->status=='finished')
                <div class="px-3 py-1.5 bg-white rounded-md text-black text-sm sm:text-base">
                    <div class="flex items-center space-x-16 space-x-reverse">
                        <p class="text-sm sm:text-base font-semibold">شماره ووچر:</p>


                        <div class=" items-center space-x-4 space-x-reverse text-sm sm:text-base font-semibold">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy">
                            <span class="inline-block"> {{$invoice->voucher->serial}}</span>
                        </div>

                    </div>
                </div>
                <div class="px-3 py-1.5 bg-white rounded-md text-black text-sm sm:text-base">
                    <div class="flex items-center space-x-16 space-x-reverse">
                        <p class="text-sm sm:text-base font-semibold">کد فعال سازی:</p>


                        <div class=" items-center space-x-4 space-x-reverse text-sm sm:text-base font-semibold">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy">
                            <span class="inline-block">{{$invoice->voucher->code}}</span>
                        </div>

                    </div>
                </div>
            @endif

        </div>

    </section>

@endsection



@section('script-tag')


@endsection
