<header class="bg-sky-500 py-3 px-2 flex items-center justify-between relative">
    <div class="menuHamburger">
        <img src="{{asset('src/images/hamburger.svg')}}" alt="">
    </div>
    <a class="flex items-center space-x-2 space-x-reverse cursor-pointer " href="{{route('panel.index')}}" >
        <i class="fa-solid fa-house w-6 h-6"></i>
            <img src="{{asset('src/images/Group 2631.svg')}}" alt="">

    </a>
    <div class="myProfile">
        <img src="{{asset('src/images/paneLUserIcon.png')}}" alt="">
    </div>

    <section id="menu"
             class=" menu-non-show absolute w-3/5 sm:w-3/6 lg:w-1/4 xl:w-1/5 top-14   z-10 pb-2  text-white bg-sky-500 rounded-ee-md overflow-hidden transition-all duration-500">
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
            <a href=""
               class="text-sm flex  items-center px-3 py-1.5 space-x-2 space-x-reverse border-t border-white">
                <img src="{{asset('src/images/cart.png')}}" alt="" class="w-4 h-4">
                <p class="sm:text-base "> پرداخت های شما </p>
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
                <p> {{\Illuminate\Support\Facades\Auth::user()->name??''}} </p>
            </a>
            <a href="" class="flex items-center py-1.5 px-2 space-x-2 space-x-reverse text-sm sm:text-base">
                <img src="{{asset('src/images/editPen.png')}}" alt="">
                <p>ویرایش مشخصات</p>
            </a>
            <a href="{{route('logout')}}" class="flex items-center py-1.5 px-2 space-x-2 space-x-reverse text-sm sm:text-base">
                <img src="{{asset('src/images/logout.png')}}" alt="">
                <p>خروج از حساب کاربری</p>
            </a>
        </article>
    </section>

</header>
