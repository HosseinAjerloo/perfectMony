@extends('Panel.layout.master')

@section('message-box')
    <div class="flex items-center justify-center space-x-reverse space-x-4 bg-gray-500 p-2">
        <img src="{{asset('src/images/dollar 1.png')}}" alt="" class="w-9 h-9">
        <p class="text-sm text-center sm:text-base">موجودی فعلی شما:4500000 هزارریال میباشد</p>
    </div>
@endsection

@section('container')

    <section class="flex items-center justify-center flex-col p-3 space-y-4 w-5/4  md:w-4/6 lg:w-2/6 mx-auto">
        <article class="  bg-gray-500 w-full space-y-4 p-2">
            <div class="flex items-center justify-between text-sm sm:text-base">
                <p>مبلغ:</p>
                <p>1500000 هزار ریال</p>
            </div>
            <div class="flex items-center justify-between text-sm sm:text-base">
                <p>شماره تراکنش:</p>
                <p>15654</p>
            </div>
            <div class="flex items-center justify-between text-sm sm:text-base">
                <p> تاریخ و ساعت:</p>
                <p>8 مرداد 1403</p>
            </div>
            <div class="flex items-center justify-between text-sm sm:text-base">
                <p>وضعیت:</p>
                <p class="text-yellow-300">درانتظار پرداخت</p>
            </div>
        </article>
        <div class=" flex items-center justify-start  max-w-max  rounded-md ">
            <button class="bg-sky-500 py-1.5 px-12 rounded-md ">پرداخت مبلغ</button>
        </div>
        <div class=" flex items-center justify-start  max-w-max  rounded-md ">
            <button class="bg-sky-500 py-1.5 px-10 rounded-md ">بازگشت</button>
        </div>
    </section>

@endsection



@section('script-tag')


@endsection
