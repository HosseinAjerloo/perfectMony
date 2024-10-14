@extends('Auth.Layout.master')
@section('message-box')
    <h1 class=" border-2 border-2-white rounded-md py-3 px-12 font-semibold text-lg ">
        به <span class="text-sky-500 ">ساینا ارز </span> خوش آمدین
    </h1>
@endsection

@section('action')
    <article class="py-5 px-3 flex flex-col items-center justify-center">
        <div>
            <p class="text-center font-semibold whitespace-pre-line">
                لطفا کلمه عبور انتخابی خودرا
                برای رودبه سایناارز وارد کنید.
            </p>
        </div>

        <form class="py-5 px-3  flex justify-center items-center flex-col  space-y-7" action="{{route('login.simple-post')}}" method="post">
            @csrf
            <input type="password" placeholder="کلمه عبور" name="password"
                   class="px-16 py-2 rounded-md ring-8 ring-gray-400 ring-opacity-35 placeholder:font-yekan outline-none w-full placeholder:text-center placeholder:text-gray-400 text-gray-900 text-center">

            <div class="py-5 px-3  flex justify-center items-center space-x-2 space-x-reverse">
                <a href="{{route('forgotPassword')}}" class="text-sky-500">فراموشی رمز عبور</a>
                <button class="py-2 px-4 rounded-md font-semibold bg-sky-400  " type="submit">ورود به سایناارز</button>

            </div>

        </form>

    </article>
@endsection
