@extends('Panel.layout.master')


@section('container')


    <section class="mx-auto px-4">
         <article class="border-2 rounded-md border-white p-2 space-y-3.5">
             <div class="text-sm sm:text-base flex items-center justify-between">
                 <p>شماره تراکنش: 5489</p>
                 <p class="text-center">مبلغ کل:500000 ریال</p>
             </div>
             <div class="text-sm sm:text-base flex items-center justify-between">
                 <div class="flex items-center space-x-2 space-x-reverse">
                 <img src="{{asset('src/images/prl.png')}}" alt="">
                     <p>خرید ووچر پرفکت مانی 2 دلاری</p>
                 </div>
                 <p class="text-center">
                     وضعیت:
                     <span class="text-green-400">انجام شده</span>
                 </p>
             </div>

             <div class="text-sm sm:text-base flex items-center justify-between">
                 <div class="flex items-center space-x-2 space-x-reverse">

                     <p>تاریخ ثبت سفارش:</p>
                     <p>1403/5/10  11:50</p>
                 </div>
                 <a href="" class="bg-gray-100 px-4 py-1.5 rounded-md space-x-3">
                     <i class="fa-solid fa-eye text-black"></i>
                     <span class="text-black">جزئیات خرید</span>
                 </a>
             </div>
         </article>
    </section>

@endsection



@section('script-tag')


@endsection
