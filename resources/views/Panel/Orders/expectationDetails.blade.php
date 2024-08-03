@extends('Panel.layout.master')


@section('container')

    <section class="mx-auto px-4 sm:w-3/4 md:w-3/5 lg:w-2/5 space-y-5">
            <form class="border-2 rounded-md border-white p-3 space-y-3.5">
                <div class="text-sm sm:text-base flex items-center justify-between">
                    <p>شماره پیش فاکتور: {{$invoice->id}}</p>
                    <p class="text-center">مبلغ کل:{{$invoice->final_amount}} ریال</p>
                </div>
                <div class="text-sm sm:text-base flex items-center justify-between">
                    @if($invoice->voucherAmount())
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <img src="{{asset('src/images/prl.png')}}" alt="">
                        <p>خرید ووچر پرفکت مانی {{$invoice->voucherAmount()}} دلاری</p>
                    </div>
                    @endif
                    <p class="text-center">
                        وضعیت:
                        @if($invoice->status=='finished')
                            <span class="text-green-400">انجام شده</span>
                        @else
                            <span class="text-red-700">پرداخت نشده</span>
                        @endif
                    </p>
                </div>
                @if($invoice->status!='finished')
                    <div class="text-sm sm:text-base flex items-center space-x-2 space-x-reverse">
                        <img src="{{asset('src/images/close.svg')}}" alt="" class="h-6 w-6">
                        <p class="mb-2">سفارش شما پرداخت نشده است، نسب به واریز آن اقدام نمایید.</p>
                    </div>
                    <div class="text-sm sm:text-base flex items-center space-x-2 space-x-reverse bg-neutral-600  rounded-md px-1 ">
                        <img src="{{asset('src/images/circleWarning.svg')}}" alt="" class="h-6 w-6  mb-2">
                        <p class="mb-2 leading-loose">
                            نکته مهم : مهلت پرداخت این پیش فاکتور 1 ساعت بعد از ثبت
                            سفارش می باشد و بعد از آن سفارش لغو شده و بایستی مجددا
                            برای خرید اقدام نمایید.</p>
                    </div>
                @endif

                <div class="text-sm sm:text-base flex items-center justify-between">
                    <div class="flex items-center space-x-2 space-x-reverse">

                        <p>تاریخ ثبت سفارش:</p>
                        <p>{{\Morilog\Jalali\Jalalian::forge($invoice->created_at)->format('%A, %d %B %y')}}</p>
                    </div>

                </div>
                @if($invoice->status!='finished')

                <div class=" flex items-center justify-start  max-w-max   rounded-md wallet ">
                    <img src="{{asset('src/images/wallet.png')}}" alt="" class="w-12 h-12 bg-sky-500 rounded-md">
                    <button class="bg-sky-500 py-1.5 px-2 rounded-se-md rounded-ee-md">پرداخت با کیف پول</button>
                </div>

                @foreach($banks as $bank)
                    <label data-bank="{{$bank->id}}"
                           class=" flex items-center justify-start  max-w-max   rounded-md  cursor-pointer bank">
                        <img src="{{asset($bank->logo_url)}}" alt="" class="w-12 h-12 bg-sky-500 rounded-md">
                        <span class="bg-sky-500 py-1.5 px-2 rounded-se-md rounded-ee-md"> {{$bank->name}} </span>
                    </label>
                @endforeach
                @endif
            </form>

    </section>

@endsection



@section('script-tag')


@endsection
