@extends('Panel.layout.master')

@section('container')
    <article class="py-5 px-3 flex flex-col items-center justify-center space-y-9">

        <div class="flex justify-center items-center flex-col  w-full sm:w-2/6 md:w-1/3 lg:w-1/4 space-y-5">
            <div class="border-2 border-2-white rounded-md py-3 px-3 w-full text-center   bg-gray-800">
                <a href="{{route('panel.admin.tickets')}}" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/ticket.png')}}" alt="" class="w-6 h-6">
                    <p>تیکت پشتیبانی</p>
                </a>
            </div>
        </div>
        <div class="flex justify-center items-center flex-col  w-full sm:w-2/6 md:w-1/3 lg:w-1/4 space-y-5">
            <div class="border-2 border-2-white rounded-md py-3 px-3 w-full text-center   bg-gray-800">
                <a href="{{route('panel.admin.dollar-price')}}" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/mony.png')}}" alt="" class="w-6 h-6">
                    <p>قیمت دلار</p>
                </a>
            </div>
        </div>
        <div class="flex justify-center items-center flex-col  w-full sm:w-2/6 md:w-1/3 lg:w-1/4 space-y-5">
            <div class="border-2 border-2-white rounded-md py-3 px-3 w-full text-center   bg-gray-800">
                <a href="{{route('panel.admin.user.index')}}" class="text-center flex items-center space-x-2 space-x-reverse">
                    <i class="fa-solid fa-user w-6 h-6"></i>
                    <p>کاربران</p>
                </a>
            </div>
        </div>
    </article>

@endsection
