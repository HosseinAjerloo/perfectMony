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
                گاهی پیامک دیر می رسد. لطفا یک رمز عبور برای خود انتخاب نمائید
                حداقل 8 کاراکتر، یک حرف بزرگ و یک حرف کوچک.  مثلا Aa123456
            </p>
        </div>

        <form class="py-5 px-3  flex justify-center items-center flex-col  space-y-7" action="{{route('login.register-password')}}" method="post">
            @csrf
            <input type="password" placeholder="کلمه عبور" name="password"
                   class="px-16 py-2 rounded-md ring-8 ring-gray-400 ring-opacity-35 placeholder:font-yekan outline-none w-full placeholder:text-center placeholder:text-gray-400 text-gray-900 text-center">
            <input type="password" placeholder="تکرار کلمه عبور" name="password_confirmation"
                   class="px-16 py-2 rounded-md ring-8 ring-gray-400 ring-opacity-35 placeholder:font-yekan outline-none w-full placeholder:text-center placeholder:text-gray-400 text-gray-900 text-center">
            <div class="py-5 px-3  flex justify-center items-center space-x-2 space-x-reverse">
                <button class="py-2 px-4 rounded-md font-semibold bg-sky-400  " type="submit">تنظیم کلمه عبور</button>
                <a href="{{route('login.login-BySms')}}" class="py-2 px-8 rounded-md font-semibold bg-sky-400  cursor-pointer" type="submit">فعلا بیخیال</a>
            </div>

        </form>

    </article>
@endsection
