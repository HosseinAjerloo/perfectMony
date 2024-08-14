@extends('Panel.layout.master')


@section('container')

    <section class="mx-auto px-4 sm:w-3/4 md:w-3/5 lg:w-2/5 space-y-5">
        <form class="border-2 rounded-md border-white p-3 space-y-3.5">
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
            @if($invoice->bank_id)
                <div class="text-sm sm:text-base flex items-center justify-between">
                    <div class="flex items-center space-x-2 space-x-reverse">

                        <p>پرداخت از طریق:</p>
                        <p>{{$invoice->bank->name}}</p>
                    </div>

                </div>
            @endif
        </form>

    </section>

@endsection



@section('script-tag')


@endsection
