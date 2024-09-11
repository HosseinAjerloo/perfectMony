<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ورود به ساینا ارز</title>
{{--    @vite('resources/css/app.css')--}}
    <link rel="stylesheet" href="{{asset('src/FontAwesome/css/all.css')}}">
    <style>
        body{
            background-color: blue!important;
        }
    </style>
</head>

<body class="font-yekan text-white  overflow-x-hidden bg-white ">
<header class="bg-sky-500 py-3 px-2 flex items-center justify-center relative">

    <a class="flex items-center space-x-2 space-x-reverse cursor-pointer " href="{{route('panel.index')}}">
        <h1 class="font-bold text-xl italic underline underline-offset-2">سایناارز</h1>
        <img src="{{asset('src/images/logo.svg')}}" alt="">
    </a>

    <section id="menu"
             class=" menu-non-show absolute w-3/5 sm:w-3/6 lg:w-1/4 xl:w-1/5 top-14   z-10 pb-2  text-white bg-sky-500 rounded-ee-md overflow-hidden transition-all duration-500 ">
        <article class="space-y-2">
            <a href="{{route('panel.purchase.view')}}"
               class="text-sm flex  items-center px-3 py-1.5 space-x-2 space-x-reverse border-t border-white">
                <img src="{{asset('src/images/pm.png')}}" alt="" class="w-4 h-4">
                <p class="sm:text-base "> خرید ووچر پرفکت مانی </p>
            </a>
            <a href="{{route('panel.order.expectation')}}"
               class="text-sm flex  items-center px-3 py-1.5 space-x-2 space-x-reverse border-t border-white">
                <img src="{{asset('src/images/list.png')}}" alt="" class="w-4 h-4">
                <p class="sm:text-base "> سفارشات شما </p>
            </a>

            <a href="{{route('panel.order')}}"
               class="text-sm flex  items-center px-3 py-1.5 space-x-2 space-x-reverse border-t border-white">
                <img src="{{asset('src/images/mony.png')}}" alt="" class="w-4 h-4">
                <p class="sm:text-base "> سوابق مالی </p>
            </a>
            <a href=""
               class="text-sm flex  items-center px-3 py-1.5 space-x-2 space-x-reverse border-t border-white">
                <img src="{{asset('src/images/ticket.png')}}" alt="" class="w-4 h-4">
                <p class="sm:text-base "> تیکت پشتیبانی </p>
            </a>
            <a href=""
               class="text-sm flex  items-center px-3 py-1.5 space-x-2 space-x-reverse border-t border-white">
                <img src="{{asset('crs/images/phone.png')}}" alt="" class="w-4 h-4">
                <p class="sm:text-base "> تماس باما </p>
            </a>
        </article>
    </section>


    <section id="menu-user"
             class="menu-user-non-show absolute w-7/12 md:w-3/12 lg:w-3/12 xl:w-2/12 top-14   z-10 pb-2  text-white bg-sky-500 rounded-ee-md overflow-hidden transition-all duration-500">
        <article class="space-y-2">
            <a href="" class="flex items-center py-1.5 px-2 space-x-2 space-x-reverse text-sm sm:text-base">
                <img src="{{asset('src/images/Profile.png')}}" alt="">
                <p> {{\Illuminate\Support\Facades\Auth::user()->fullName??''}} </p>
            </a>
            <a href="{{route('panel.user.edit')}}"
               class="flex items-center py-1.5 px-2 space-x-2 space-x-reverse text-sm sm:text-base">
                <img src="{{asset('src/images/editPen.png')}}" alt="">
                <p>ویرایش مشخصات</p>
            </a>
            <a href="{{route('logout')}}"
               class="flex items-center py-1.5 px-2 space-x-2 space-x-reverse text-sm sm:text-base">
                <img src="{{asset('src/images/logout.png')}}" alt="">
                <p>خروج از حساب کاربری</p>
            </a>

        </article>
    </section>

</header>
@yield('header-tag')
<main class=" w-full transition-all duration-700">
    <section class="py-5 px-3 flex justify-center items-center container md:mx-auto">
        @yield('message-box')

    </section>
    <section class="container md:mx-auto">
        @yield('container')
    </section>

    <section class="py-5 px-3 flex justify-center flex-col items-center container md:mx-auto  ">

            @yield('content')
    </section>

</main>
@yield('script-tag')
@yield('footer')
</body>
</html>



