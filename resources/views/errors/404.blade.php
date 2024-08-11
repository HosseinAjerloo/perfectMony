@extends('Auth.Layout.master')
@section('message-box')
    <div class="pt-10 pl-10 pr-10">
        <img src="{{asset('src/images/404.png')}}" alt="">
    </div>
@endsection

@section('action')
    <article class="py-5 px-3 flex flex-col items-center justify-center">
        <div class="space-y-2">
            <h1 class="text-center font-semibold">
                صفحه مورد نظر یافت نشد!
            </h1>
            <p class="text-center text-sm sm:text-base">
                احتمالا صفحه مورد نظر شما حذف
                یا تغییر نام داده شده است
            </p>
        </div>

        <div class="mt-3.5 sm:mt-8">
            <a href="{{route('panel.index')}}"
               class="text-base font-semibold bg-sky-500 px-6 py-1.5 rounded-md font-yekan">صفحه اصلی ساینا ارز</a>
        </div>

    </article>
@endsection


