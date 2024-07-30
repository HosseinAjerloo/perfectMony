@extends('Panel.layout.master')

@section('message-box')
    <div class="flex items-center justify-center space-x-reverse space-x-4 bg-gray-500 p-2">
        <img src="{{asset('src/images/dollar 1.png')}}" alt="" class="w-9 h-9">
        <p class="text-sm text-center sm:text-base">موجودی فعلی شما:4500000 هزارریال میباشد</p>
    </div>
@endsection

@section('container')

    <section class="flex items-center justify-center flex-col space-y-3  w-full sm:w-1/2 mx-auto">
        <div class=" flex items-center justify-start  max-w-max  rounded-md ">
            <a class="bg-sky-500 py-1.5 px-4 rounded-md ">خرید ووچر پرفکت مانی</a>
        </div>
        <div class=" flex items-center justify-start  max-w-max  rounded-md ">
            <a class="bg-sky-500 py-1.5 px-4 rounded-md ">مشاهده فاکتور</a>
        </div>
        <div class=" flex items-center justify-start  max-w-max  rounded-md ">
            <a class="bg-sky-500 py-1.5 px-4 rounded-md ">تلاش مجدد برای خرید</a>
        </div>
    </section>

@endsection



@section('script-tag')


@endsection
