@extends('Panel.layout.master')

@section('message-box')
    <h1 class=" border-2 border-2-white rounded-md py-3 px-3 text-sm sm:text-base font-semibold text-center ">
        ضمن تشکر از انتخاب <span class="text-sky-500  font-semibold"> ساینا ارز  </span> <span
            class="text-rose-600  font-bold text-xl">نکته </span><span
            class="underline underline-offset-8 decoration-rose-500 decoration-2 decoration-wavy">پذیرنده اصلی شما هلوگیت میباشد</span>

    </h1>
@endsection

@section('container')
    <div class=" flex items-center justify-center w-full p-8 ">
        <div class="rounded-md bg-white border-sky-700  min-w-full sm:w-4/12 sm:min-w-0 p-1">
            <div class="p-2 rounded-md shadow shadow-gray-400 ">
                <img src="{{asset('src/images/vucher.jpg')}}" alt="" class="rounded-md">
                <div class=" shadow-lg rounded-md mt-2">
                    <h1 class="font-thin text-lg px-2 py-1.5 flex items-center text-gray-600"><i
                            class="fas fa-shopping-cart ml-2 text-gray-400"></i>نوع سفارش:حواله پرفکت مانی</h1>
                    <div class="text-right text-gray-400 px-2">
                        <h1>قیمت : <span class="text-rose-500/70">USD 1</span></h1>
                        <h1>قیمت به تومان : <span class="text-rose-500/70">60،000</span></h1>
                        <h1>سایت ارجاع دهنده : <span class="text-rose-500/70">هلوگیت</span></h1>
                    </div>
                    <p class="text-gray-400 px-2 py-1.5 text-balance">
                        <span class="text-rose-600">اطلاعیه</span>:کاربر گرامی سایت ساینا ارز به صورت واسط بین شما و
                        سایت
                        مورد نظر فعالیت میکند و پذیرنده اصلی شما سایت متناظر است.
                    </p>
                    <button class="px-2 py-1.5 bg-sky-600 text-white p-4 rounded-md text-center w-full">ادامه</button>
                </div>

            </div>
        </div>
    </div>
@endsection
