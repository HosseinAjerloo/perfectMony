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
                <a href="{{route('panel.user.completionOfInformation')}}"
                   class=" px-3 py-1 bg-sky-500 rounded-md text-sm mb-24 block max-w-max"> تکمیل اطلاعات</a>
            </div>
        </div>
    @endif
@endsection

@section('container')
    <article class="py-5 px-3 flex flex-col items-center justify-center space-y-9 relative">
        <div class="bg-sky-500 px-4  rounded-md flex items-center justify-between space-x-3 space-x-reverse">
            <p class="text-center font-semibold">
                <span class="text-lg font-semibold text-sky-500">$</span> موجودی شما : {{numberFormat($balance)}} ریال
            </p>
            <a href="{{route('panel.wallet.charging')}}" class="border-r pr-2 ">
                <i class="fa-solid fa-plus w-6 h-6 mt-2"></i>
            </a>
        </div>

        <div class="flex justify-center items-center flex-col  w-full sm:w-2/6 md:w-1/3 lg:w-1/4 space-y-5">
            <div class="border-2 border-2-white rounded-md py-3 px-3  w-full text-center   bg-gray-800">
                <a href="{{route('panel.purchase.view')}}"
                   class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/prl.png')}}" alt="" class="w-6 h-6">
                    <p>کارت هدیه پرفکت مانی</p>
                </a>
            </div>
            <div class="border-2 border-2-white rounded-md py-3 px-3  w-full text-center   bg-gray-800">
                <a href="{{route('panel.transmission.view')}}"
                   class="text-center flex items-center space-x-2 space-x-reverse">
                    <i class="fa-solid fa-money-bill-transfer w-6 h-6"></i>
                    <p>حواله پرفکت</p>
                </a>
            </div>
            <div class="border-2 border-2-white rounded-md py-3 px-3  w-full text-center   bg-gray-800">

                <a href="{{route('panel.order.expectation')}}"
                   class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/invoice.svg')}}" alt="" class="w-6 h-6">
                    <p>سفارشات شما</p>
                </a>
            </div>

            <div class="border-2 border-2-white rounded-md py-3 px-3  w-full text-center   bg-gray-800">
                <a href="{{route('panel.order')}}" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/mony.png')}}" alt="" class="w-6 h-6">
                    <p>سوابق مالی</p>
                </a>
            </div>
            <div class="border-2 border-2-white rounded-md py-3 px-3 w-full text-center   bg-gray-800">
                <a href="{{route('panel.ticket')}}" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/ticket.png')}}" alt="" class="w-6 h-6">
                    <p>تیکت پشتیبانی</p>
                </a>
            </div>
            <div class="border-2 border-2-white rounded-md py-3 px-3 w-full text-center   bg-gray-800">
                <a href="{{route('panel.contactUs')}}" class="text-center flex items-center space-x-2 space-x-reverse">
                    <img src="{{asset('src/images/phone.png')}}" alt="" class="w-6 h-6">
                    <p>تماس با ما</p>
                </a>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->type=='admin')
                <div class="border-2 border-2-white rounded-md py-3 px-3 w-full text-center   bg-gray-800">
                    <a href="{{route('panel.admin')}}" class="text-center flex items-center space-x-2 space-x-reverse">
                        <i class="fa-solid fa-user w-6 h-6"></i>
                        <p>ورود به پنل ادمین</p>
                    </a>
                </div>
            @endif

        </div>


        @if(session()->has('previous_user') and session()->get('previous_user')!=\Illuminate\Support\Facades\Auth::user()->id)
            <div class="bg-rose-500 py-1.5 px-2 rounded-md font-semibold notifyBox shadow-2xl shadow-white z-[100] sm:left-5 sm:bottom-8 sm:absolute ">
                <a  href="{{route('panel.admin.login-another-user',session()->get('previous_user'))}}" class="text-sm sm:text-base">ورود به حساب پشتیبان</a>
            </div>
        @endif
    </article>

@endsection
