@extends('Panel.layout.master')


@section('container')

    <section class="py-3 px-3 w-full space-y-20">
        <article class=" shadow-xl shadow-sky-500 flex   rounded-md">
            <div class="w-1/2  space-y-1 p-1">
                <p class="text-sm text-balance text-center">تاریخ:1403/03/02</p>
                <p class="text-sm text-balance text-center">ساعت:11:07</p>
                <p class="text-sm text-balance text-center leading-6">صدور کارت هدیه 1 دلاری پرفکت مانی</p>
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center space-x-3 space-x-reverse">
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        <span class="text-sm sm:text-base">6982541</span>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center space-x-3 space-x-reverse">
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        <span class="text-sm sm:text-base">698454562541</span>
                    </div>
                </div>
            </div>
            <div class="w-1/2  space-y-1 p-1 flex items-center justify-center flex-col">
                <p class="text-sm text-balance text-center flex items-center">
                    مبلغ هزار ریال: 1،200،000
                    <i class="fa-solid fa-plus text-xl mr-2 text-green-400"></i>
                </p>
                <p class="text-sm text-balance text-center flex items-center">
                    مانده هزار ریال : 1،200،000
                </p>
                <div    class=" whitespace-no-wrap text-right  border-gray-500 text-sm leading-5 w-5/6">
                    <button
                        class="px-6  w-full py-1.5 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
        </article>

        <article class=" shadow-xl shadow-sky-500 flex   rounded-md">
            <div class="w-1/2  space-y-1 p-1">
                <p class="text-sm text-balance text-center">تاریخ:1403/03/02</p>
                <p class="text-sm text-balance text-center">ساعت:11:07</p>
                <p class="text-sm text-balance text-center leading-6">صدور کارت هدیه 1 دلاری پرفکت مانی</p>
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center space-x-3 space-x-reverse">
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        <span class="text-sm sm:text-base">6982541</span>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center space-x-3 space-x-reverse">
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        <span class="text-sm sm:text-base">698454562541</span>
                    </div>
                </div>
            </div>
            <div class="w-1/2  space-y-1 p-1 flex items-center justify-center flex-col">
                <p class="text-sm text-balance text-center flex items-center">
                    مبلغ هزار ریال: 1،200،000
                    <i class="fa-solid fa-minus text-2xl text-rose-500"></i>
                </p>
                <p class="text-sm text-balance text-center flex items-center">
                    مانده هزار ریال : 1،200،000
                </p>
                <div    class=" whitespace-no-wrap text-right  border-gray-500 text-sm leading-5 w-5/6">
                    <button
                        class="px-6  w-full py-1.5 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
        </article>
        <article class=" shadow-xl shadow-sky-500 flex   rounded-md">
            <div class="w-1/2  space-y-1 p-1">
                <p class="text-sm text-balance text-center">تاریخ:1403/03/02</p>
                <p class="text-sm text-balance text-center">ساعت:11:07</p>
                <p class="text-sm text-balance text-center leading-6">صدور کارت هدیه 1 دلاری پرفکت مانی</p>
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center space-x-3 space-x-reverse">
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        <span class="text-sm sm:text-base">6982541</span>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center space-x-3 space-x-reverse">
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        <span class="text-sm sm:text-base">698454562541</span>
                    </div>
                </div>
            </div>
            <div class="w-1/2  space-y-1 p-1 flex items-center justify-center flex-col">
                <p class="text-sm text-balance text-center flex items-center">
                    مبلغ هزار ریال: 1،200،000
                    <i class="fa-solid fa-minus text-2xl text-rose-500"></i>
                </p>
                <p class="text-sm text-balance text-center flex items-center">
                    مانده هزار ریال : 1،200،000
                </p>
                <div    class=" whitespace-no-wrap text-right  border-gray-500 text-sm leading-5 w-5/6">
                    <button
                        class="px-6  w-full py-1.5 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
        </article>

    </section>

@endsection



@section('script-tag')


@endsection
