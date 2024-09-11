<header class="bg-sky-500 py-3 px-2 flex items-center justify-between relative">
    <div class="menuHamburger cursor-pointer">
        <img src="{{asset('src/images/hamburger.svg')}}" alt="">
    </div>
    <a class="flex items-center space-x-2 space-x-reverse cursor-pointer " href="{{route('panel.index')}}">
        <h1 class="font-bold text-2xl italic underline underline-offset-2">سایناارز</h1>
        <img src="{{asset('src/images/logo.svg')}}" alt="">


    </a>
    <div class="myProfile cursor-pointer">
        <img src="{{asset('src/images/paneLUserIcon.png')}}" alt="">
    </div>

</header>
