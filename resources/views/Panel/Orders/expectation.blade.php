@extends('Panel.layout.master')


@section('container')

    <section class="mx-auto px-4 sm:w-3/4 md:w-3/5 lg:w-2/5 space-y-5">
        @foreach($invoices as $invoice)
            <article class="border-2 rounded-md border-white p-3 space-y-3.5">
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


                <div class="text-sm sm:text-base flex items-center justify-between">
                    <div class="flex items-center space-x-2 space-x-reverse">

                        <p>تاریخ ثبت سفارش:</p>
                        <p>{{\Morilog\Jalali\Jalalian::forge($invoice->created_at)->format('%A, %d %B %y')}}</p>
                    </div>

                        <a href="{{route('panel.order.expectation.details',$invoice->id)}}"
                           class="bg-gray-100 px-4 py-1.5 rounded-md space-x-3">
                            <i class="fa-solid fa-eye text-black"></i>
                            <span class="text-black">جزئیات</span>
                        </a>


                </div>
            </article>
        @endforeach

    </section>

@endsection



@section('script-tag')


@endsection
