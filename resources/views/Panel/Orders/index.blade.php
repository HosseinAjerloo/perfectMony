@extends('Panel.layout.master')


@section('container')

    <section class="py-3 px-3 w-full ">
        <article class="flex min-w-full  ">
            <div class="flex flex-col w-1/2 space-y-3 p-3 shadow-md shadow-white rounded-md">
                <div class="min-w-full flex items-center justify-between ">
                    <div class="flex flex-col items-center ">
                        <p class="text-sm">تاریخ:</p>
                        <p class="text-sm">1403/02/01</p>
                    </div>
                    <div class="flex flex-col items-center ">
                        <p class="text-sm">ساعت:</p>
                        <p class="text-sm">11:54</p>
                    </div>
                </div>
                <div class="min-w-full flex flex-col justify-center text-sm text-center">
                    <p>صدور کارت هدیه 1 دلاری پرفکت مانی</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                 class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                            <span class="text-sm sm:text-base">45645</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                 class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                            <span class="text-sm sm:text-base">745646546598764</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between w-1/2  p-3 shadow-md shadow-white rounded-md">
                <div class="flex flex-col items-center">
                    <p class="text-sm text-center">مبلغ هزارتومان</p>
                    <p class="text-sm text-center">120 +</p>
                </div>
                <div class="flex flex-col items-center">
                    <p class="text-sm text-center">مانده هزارتومان</p>
                    <p class="text-sm text-center">120 +</p>
                </div>
                <div class="flex flex-col items-center w-2/6">
                    <p class="text-sm text-center">بیشتر</p>
                    <button
                        class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
        </article>
    </section>

@endsection



@section('script-tag')


@endsection
