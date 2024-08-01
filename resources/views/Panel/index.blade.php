@extends('Panel.layout.master')

@section('message-box')
   @if($UserInformationStatus)
       <div
           class=" border-2 border-2-white rounded-md py-3 px-6 font-semibold text-lg flex justify-start space-x-2 space-x-reverse">
           <img src="{{asset('src/images/warning.png')}}" alt="" class="w-5 h-5">
           <div class="space-y-2">
               <p class=" leading-6 break-all text-right text-base">
                   اطلاعات پایه شما ناقص است لطفا جهت خرید
                   .آن را تکمیل نمایید
               </p>
               <a href="{{route('panel.user.completionOfInformation')}}" class=" px-3 py-1 bg-sky-500 rounded-md text-sm mb-24 block max-w-max"> تکمیل اطلاعات</a>
           </div>
       </div>
   @endif
@endsection

@section('container')
    <article class="py-5 px-3 flex flex-col items-center justify-center space-y-9">
        <div class="bg-sky-500 px-4  rounded-md flex items-center justify-between space-x-3 space-x-reverse">
            <p class="text-center font-semibold">
                <span class="text-lg font-semibold text-sky-500">$</span> موجودی شما : {{numberFormat($balance)}} ریال
            </p>
            <a href="{{route('panel.wallet.charging')}}" class="border-r pr-2 ">
                <i class="fa-solid fa-plus w-6 h-6 mt-2"></i>
            </a>
        </div>

        <div class="flex justify-center items-center flex-col  w-full sm:w-2/6 md:w-1/3 lg:w-1/4 space-y-5">
            <div class="border-2 border-2-white rounded-md py-3 px-3 f w-full text-center   bg-gray-800">
                <a href="{{route('panel.purchase.view')}}" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/list.png')}}" alt="" class="w-6 h-6">
                    <p>خرید ووچر پرفکت مانی</p>
                </a>
            </div>
            <div class="border-2 border-2-white rounded-md py-3 px-3 f w-full text-center   bg-gray-800">

                <a href="{{route('panel.order')}}" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/list.png')}}" alt="" class="w-6 h-6">
                    <p>سفارشات شما</p>
                </a>
            </div>
            <div class="border-2 border-2-white rounded-md py-3 px-3 f w-full text-center   bg-gray-800">
                <a href="" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/cart.png')}}" alt="" class="w-6 h-6">
                    <p>پرداخت های شما</p>
                </a>
            </div>
            <div class="border-2 border-2-white rounded-md py-3 px-3 f w-full text-center   bg-gray-800">
                <a href="" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/mony.png')}}" alt="" class="w-6 h-6">
                    <p>سوابق مالی</p>
                </a>
            </div>
            <div class="border-2 border-2-white rounded-md py-3 px-3 f w-full text-center   bg-gray-800">
                <a href="" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/ticket.png')}}" alt="" class="w-6 h-6">
                    <p>تیکت پشتیبانی</p>
                </a>
            </div>
            <div class="border-2 border-2-white rounded-md py-3 px-3 f w-full text-center   bg-gray-800">
                <a href="" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/phone.png')}}" alt="" class="w-6 h-6">
                    <p>تماس باما</p>
                </a>
            </div>

        </div>
    </article>

@endsection
