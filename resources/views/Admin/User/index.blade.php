@extends('Panel.layout.master')

@section('message-box')
    <form action="" class=" px-2 min-w-full flex items-center justify-center mb-6 relative">
        <input type="text" placeholder="جستوجو" class="text-gray-500 outline-none placeholder:text-gray-600/50 min-w-full  sm:w-1/2 py-3 px-2 rounded-md ring-8 ring-offset-4 ring-gray-500/50">
        <i class="fas fa-search absolute text-2xl  text-gray-700/50 left-3 top-[12px]"></i>
    </form>
@endsection

@section('container')
    <section class="flex justify-center  flex-col px-4 mt-3">
        <article
            class="pb-8 space-y-3 flex-wrap rounded-md text-black  bg-white  p-2 ring-8 ring-offset-8 ring-gray-800 flex items-center justify-between ">
            <div class="flex bg-red-100 items-center space-x-3 space-x-reverse min-w-full rounded-md p-4 ">
                <img src="{{asset('src/images/avatar1.png')}}" alt="" class="w-16 h-16">
                <div class="space-y-1">

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500 text-sm">نام و نام خانوادگی:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">حسین آجرلو</h1>
                    </div>

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">موجودی کیف پول:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">350</h1>
                    </div>
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">شماره تلفن:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">09186414452</h1>
                    </div>
                </div>
            </div>
            <div class="flex flex-col space-y-3">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <i class="fa-solid fa-location-dot"></i>
                    <p class="tetx-sm leading-6 text-gray-600"> اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهری
                        اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهریاراک رودکی کوچه شهید طاهری</p>
                </div>
            </div>
            <div class="min-w-full h-[1px] rounded-md bg-gray-300"></div>
            <div class="min-w-full flex items-center space-x-2 space-x-reverse text-sm text-white justify-center sm:justify-normal ">
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-sky-500 rounded-md shadow-amber-300 shadow-2xl">وارید شوید</a>
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-rose-500 rounded-md shadow-amber-300 shadow-2xl">غیرفعال کردن کاربر</a>
            </div>


        </article>
    </section>
    <section class="flex justify-center  flex-col px-4 mt-3">
        <article
            class="pb-8 space-y-3 flex-wrap rounded-md text-black  bg-white  p-2 ring-8 ring-offset-8 ring-gray-800 flex items-center justify-between ">
            <div class="flex bg-red-100 items-center space-x-3 space-x-reverse min-w-full rounded-md p-4 ">
                <img src="{{asset('src/images/avatar1.png')}}" alt="" class="w-16 h-16">
                <div class="space-y-1">

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500 text-sm">نام و نام خانوادگی:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">حسین آجرلو</h1>
                    </div>

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">موجودی کیف پول:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">350</h1>
                    </div>
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">شماره تلفن:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">09186414452</h1>
                    </div>
                </div>
            </div>
            <div class="flex flex-col space-y-3">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <i class="fa-solid fa-location-dot"></i>
                    <p class="tetx-sm leading-6 text-gray-600"> اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهری
                        اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهریاراک رودکی کوچه شهید طاهری</p>
                </div>
            </div>
            <div class="min-w-full h-[1px] rounded-md bg-gray-300"></div>
            <div class="min-w-full flex items-center space-x-2 space-x-reverse text-sm text-white justify-center sm:justify-normal ">
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-sky-500 rounded-md shadow-amber-300 shadow-2xl">وارید شوید</a>
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-rose-500 rounded-md shadow-amber-300 shadow-2xl">غیرفعال کردن کاربر</a>
            </div>


        </article>
    </section>
    <section class="flex justify-center  flex-col px-4 mt-3">
        <article
            class="pb-8 space-y-3 flex-wrap rounded-md text-black  bg-white  p-2 ring-8 ring-offset-8 ring-gray-800 flex items-center justify-between ">
            <div class="flex bg-red-100 items-center space-x-3 space-x-reverse min-w-full rounded-md p-4 ">
                <img src="{{asset('src/images/avatar1.png')}}" alt="" class="w-16 h-16">
                <div class="space-y-1">

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500 text-sm">نام و نام خانوادگی:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">حسین آجرلو</h1>
                    </div>

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">موجودی کیف پول:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">350</h1>
                    </div>
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">شماره تلفن:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">09186414452</h1>
                    </div>
                </div>
            </div>
            <div class="flex flex-col space-y-3">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <i class="fa-solid fa-location-dot"></i>
                    <p class="tetx-sm leading-6 text-gray-600"> اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهری
                        اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهریاراک رودکی کوچه شهید طاهری</p>
                </div>
            </div>
            <div class="min-w-full h-[1px] rounded-md bg-gray-300"></div>
            <div class="min-w-full flex items-center space-x-2 space-x-reverse text-sm text-white justify-center sm:justify-normal ">
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-sky-500 rounded-md shadow-amber-300 shadow-2xl">وارید شوید</a>
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-rose-500 rounded-md shadow-amber-300 shadow-2xl">غیرفعال کردن کاربر</a>
            </div>


        </article>
    </section>
    <section class="flex justify-center  flex-col px-4 mt-3">
        <article
            class="pb-8 space-y-3 flex-wrap rounded-md text-black  bg-white  p-2 ring-8 ring-offset-8 ring-gray-800 flex items-center justify-between ">
            <div class="flex bg-red-100 items-center space-x-3 space-x-reverse min-w-full rounded-md p-4 ">
                <img src="{{asset('src/images/avatar1.png')}}" alt="" class="w-16 h-16">
                <div class="space-y-1">

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500 text-sm">نام و نام خانوادگی:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">حسین آجرلو</h1>
                    </div>

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">موجودی کیف پول:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">350</h1>
                    </div>
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">شماره تلفن:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">09186414452</h1>
                    </div>
                </div>
            </div>
            <div class="flex flex-col space-y-3">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <i class="fa-solid fa-location-dot"></i>
                    <p class="tetx-sm leading-6 text-gray-600"> اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهری
                        اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهریاراک رودکی کوچه شهید طاهری</p>
                </div>
            </div>
            <div class="min-w-full h-[1px] rounded-md bg-gray-300"></div>
            <div class="min-w-full flex items-center space-x-2 space-x-reverse text-sm text-white justify-center sm:justify-normal ">
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-sky-500 rounded-md shadow-amber-300 shadow-2xl">وارید شوید</a>
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-rose-500 rounded-md shadow-amber-300 shadow-2xl">غیرفعال کردن کاربر</a>
            </div>


        </article>
    </section>
    <section class="flex justify-center  flex-col px-4 mt-3">
        <article
            class="pb-8 space-y-3 flex-wrap rounded-md text-black  bg-white  p-2 ring-8 ring-offset-8 ring-gray-800 flex items-center justify-between ">
            <div class="flex bg-red-100 items-center space-x-3 space-x-reverse min-w-full rounded-md p-4 ">
                <img src="{{asset('src/images/avatar1.png')}}" alt="" class="w-16 h-16">
                <div class="space-y-1">

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500 text-sm">نام و نام خانوادگی:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">حسین آجرلو</h1>
                    </div>

                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">موجودی کیف پول:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">350</h1>
                    </div>
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <p class="text-gray-500">شماره تلفن:</p>
                        <h1 class="font-bold tetx-sm leading-6 text-gray-700">09186414452</h1>
                    </div>
                </div>
            </div>
            <div class="flex flex-col space-y-3">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <i class="fa-solid fa-location-dot"></i>
                    <p class="tetx-sm leading-6 text-gray-600"> اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهری
                        اراک رودکی کوچه شهید طاهری اراک رودکی کوچه شهید طاهریاراک رودکی کوچه شهید طاهری</p>
                </div>
            </div>
            <div class="min-w-full h-[1px] rounded-md bg-gray-300"></div>
            <div class="min-w-full flex items-center space-x-2 space-x-reverse text-sm text-white justify-center sm:justify-normal ">
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-sky-500 rounded-md shadow-amber-300 shadow-2xl">وارید شوید</a>
                <a href="" class="flex items-center justify-center px-4 py-1.5 bg-rose-500 rounded-md shadow-amber-300 shadow-2xl">غیرفعال کردن کاربر</a>
            </div>


        </article>
    </section>

@endsection
