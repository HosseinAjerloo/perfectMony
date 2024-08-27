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


        <div class="flex justify-between items-center   w-full  flex-wrap ">


            <a href="{{route('panel.purchase.view')}}"  class="flex flex-col items-center justify-center space-y-2  mb-7 w-1/3 sm:w-1/4 md:w-1/6">
                <div class="border-white border-2 rounded-full p-4 box-border">
                    <img src="{{asset('src/images/newGift.svg')}}" alt="">
                </div>
                <p class="text-sm sm:text-base">کارت هدیه</p>
            </a>
            <a href="{{route('panel.transmission.view')}}" class="flex flex-col items-center justify-center space-y-2  mb-7 w-1/3 sm:w-1/4 md:w-1/6">
                <div class="border-white border-2 rounded-full p-4 box-border">
                    <img src="{{asset('src/images/newPm.svg')}}" alt="" >
                </div>
                <p class="text-sm sm:text-base">حواله پرفکت مانی</p>
            </a>

            <a href="{{route('panel.order')}}" class="flex flex-col items-center justify-center space-y-2 mb-7 w-1/3 sm:w-1/4 md:w-1/6">
                <div class="border-white border-2 rounded-full p-4 box-border">
                    <img src="{{asset('src/images/newTransaction.svg')}}" alt="">
                </div>
                <p class="text-sm sm:text-base"> سوابق</p>
            </a>

            <a href="{{route('panel.wallet.charging')}}" class="flex flex-col items-center justify-center space-y-2  mb-7 w-1/3 sm:w-1/4 md:w-1/6">
                <div class="border-white border-2 rounded-full p-4 box-border">
                    <img src="{{asset('src/images/newWallet.svg')}}" alt="">
                </div>
                <p class="text-sm sm:text-base">کیف پول</p>
            </a>
            <a href="{{route('panel.contactUs')}}" class="flex flex-col items-center justify-center space-y-2  mb-7 w-1/3 sm:w-1/4 md:w-1/6">
                <div class="border-white border-2 rounded-full p-4 box-border">
                    <img src="{{asset('src/images/newPhone.svg')}}" alt="">
                </div>
                <p class="text-sm sm:text-base">تماس باما</p>
            </a>
            <a href="{{route('panel.ticket')}}" class="flex flex-col items-center justify-center space-y-2  mb-7 w-1/3 sm:w-1/4 md:w-1/6">
                <div class="border-white border-2 rounded-full p-4 box-border">
                    <img src="{{asset('src/images/newTicket.svg')}}" alt="">
                </div>
                <p class="text-sm sm:text-base">پشتیبانی</p>
            </a>
            @if(\Illuminate\Support\Facades\Auth::user()->type=='admin')

            <a href="{{route('panel.admin')}}"  class="flex flex-col items-center justify-center space-y-2  mb-7 w-1/3 sm:w-1/4 md:w-1/6">
                <div class="border-white border-2 rounded-full p-4 box-border">
                    <img src="{{asset('src/images/newAdmin.svg')}}" alt="">
                </div>
                <p class="text-sm sm:text-base">ورود به پنل ادمین</p>
            </a>
            @endif

        </div>


        @if(session()->has('previous_user') and session()->get('previous_user')!=\Illuminate\Support\Facades\Auth::user()->id)
            <div
                class="bg-rose-500 py-1.5 px-2 rounded-md font-semibold notifyBox shadow-2xl shadow-white z-[100] sm:left-5 sm:bottom-8 sm:absolute ">
                <a href="{{route('panel.admin.login-another-user',session()->get('previous_user'))}}"
                   class="text-sm sm:text-base">ورود به حساب پشتیبان</a>
            </div>
        @endif
    </article>

@endsection
