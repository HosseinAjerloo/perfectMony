@extends('Panel.layout.master')


@section('container')
    <div class=" flex items-center justify-center w-full p-8 ">
        <div class="rounded-md bg-white border-sky-700  min-w-full sm:w-4/12 sm:min-w-0 ">
            <div class="p-2 rounded-md shadow shadow-gray-400 ">
                <img src="{{asset('src/images/vucher2.png')}}" alt="" class="rounded-md">
                <div class=" shadow-lg rounded-md mt-2">
                    <h1 class="font-thin text-lg px-2 py-1.5 flex items-center text-gray-600"><i
                            class="fas fa-shopping-cart ml-2 text-gray-400"></i>نوع سفارش:حواله پرفکت مانی</h1>
                    <div class="text-right text-gray-400 px-2">
                        <h1>قیمت : <span class="text-rose-500/70">USD 1</span></h1>
                        <h1>قیمت به تومان : <span class="text-rose-500/70">60،000</span></h1>
                        <h1>آدرس حساب مقصد : <span class="text-rose-500/70">U42822981</span></h1>
                    </div>
                    <p class="text-gray-400 px-2 py-1.5 text-right">
                        <span class="text-rose-600">اطلاعیه </span>:
                        شما درحال انجام حواله با اطلاعات فوق هستید جهت ادامه بر روی دیکمه زیر کلیک کنید
                    </p>
                    <form action="">
                        <input type="hidden" name="transmission" >
                        <input type="hidden" name="custom_payment" >
                        <button class="px-2 py-1.5 bg-sky-600 text-white p-4 rounded-md text-center w-full">ادامه</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
