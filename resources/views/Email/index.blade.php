<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ورود به ساینا ارز</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{asset('src/FontAwesome/css/all.css')}}">

</head>

<body class="font-yekan text-white  overflow-x-hidden bg-white ">
<header class="bg-sky-500 py-3 px-2 flex items-center justify-center relative">

    <a class="flex items-center space-x-2 space-x-reverse cursor-pointer " href="{{route('panel.index')}}">
        <h1 class="font-bold text-xl italic underline underline-offset-2">سایناارز</h1>
        <img src="{{asset('src/images/logo.svg')}}" alt="">
    </a>
</header>
<main class=" w-full transition-all duration-700">
    <section class="py-5 px-3 flex justify-center items-center container md:mx-auto">
        <x-email-failed :type="'message-box'"/>

    </section>
    <section class="container md:mx-auto">
        <x-email-failed :type="'container'"/>
    </section>


</main>
<article class="bg-sky-500 p-4 flex items-center justify-around">
    <div class="flex items-center justify-center space-x-1 space-x-reverse">
        <p>
            086-33805
        </p>
        <img src="{{asset('src/images/phone.png')}}" alt="" class="w-4 h-4 mt-2">
    </div>
    <div class="flex items-center justify-center space-x-1 space-x-reverse">
        <p>
            www.sainaex.ir
        </p>
        <img src="{{asset('src/images/network.svg')}}" alt="">
    </div>
</article>
</body>
</html>







