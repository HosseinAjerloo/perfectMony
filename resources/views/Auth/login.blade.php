@extends('Auth.Layout.master')
@section('message-box')
    <h1 class=" border-2 border-2-white rounded-md py-3 px-12 font-semibold text-lg ">
        به <span class="text-sky-500 ">ساینا ارز </span> خوش آمدین
    </h1>
@endsection

@section('action')
    <article class="py-5 px-3 flex flex-col items-center justify-center">
        <div>
            <p class="text-center font-semibold">
                جهت ورود به سایت و خرید ووچر پرفکت مانی
                شماره همراه خود را وارد نمایید :
            </p>
        </div>

        <form class="py-5 px-3  flex justify-center items-center flex-col  space-y-7" action="{{route('login.sendCode')}}" method="post">
            @csrf
            <input type="text" placeholder="*********09" name="mobile"
                   class="px-4 py-2 rounded-md ring-8 ring-gray-400 ring-opacity-35 placeholder:font-yekan outline-none w-full placeholder:text-center placeholder:text-gray-700 text-gray-900 text-center">
            <button class="py-2 px-4 rounded-md font-semibold bg-sky-400  " type="submit">مرحله بعد</button>
        </form>
    </article>
@endsection


@section('container')

{{--    <ul class="space-y-3">--}}
{{--        <li class="flex  items-center space-x-2 space-x-reverse">--}}
{{--            <img src="{{asset('src/images/Group 414.png')}}" alt="" class="w-9 h-9">--}}
{{--            <p class="mb-2 text-sm ">خرید آسان و سریع ووچر پرفکت مانی</p>--}}
{{--        </li>--}}
{{--        <li class="flex  items-center space-x-2 space-x-reverse">--}}
{{--            <img src="{{asset('src/images/Group 414.png')}}" alt="" class="w-9 h-9">--}}
{{--            <p class="mb-2 text-sm ">تحویل آنی و اتوماتیک</p>--}}
{{--        </li>--}}
{{--        <li class="flex  items-center space-x-2 space-x-reverse">--}}
{{--            <img src="{{asset("src/images/Group 414.png")}}" alt="" class="w-9 h-9">--}}
{{--            <p class="mb-2 text-sm ">پشتیبانی 24 ساعته</p>--}}
{{--        </li>--}}
{{--        <li class="flex  items-center space-x-2 space-x-reverse">--}}
{{--            <img src="{{asset('src/images/Group 414.png')}}" alt="" class="w-9 h-9">--}}
{{--            <p class="mb-2 text-sm ">بدون نیاز به اخراز هویت</p>--}}
{{--        </li>--}}
{{--    </ul>--}}
@endsection
