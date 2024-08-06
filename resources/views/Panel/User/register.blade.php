@extends('Panel.layout.master')

@section('message-box')
    <h1 class=" border-2 border-2-white rounded-md py-3 px-3 text-sm sm:text-base font-semibold  ">
        ضمن تشکر از انتخاب <span class="text-sky-500  font-semibold"> ساینا ارز  </span> لطفا مشخصات خود را وارد
        نمائید که در صورت بروز مشکل و خطا بتوانیم پشتیبانی
        لازم را انجام دهیم
    </h1>
@endsection

@section('container')
    <form
        class="py-5 px-4 w-full   sm:w-2/4 md:w-2/3 lg:w-2/4 xl:w-1/4 flex flex-col items-center justify-center space-y-9 sm:mx-auto" method="post" action="{{route('panel.user.register')}}">
        @csrf
        <div class="flex justify-between items-center  w-full  space-x-2 space-x-reverse">
            <label for="" class="text-base font-yekan  ">نام:</label>
            <input type="text" class="font-yekan py-1 px-2 rounded-md text-black outline-none" name="name" value="{{old('name',$user->name)}}">
        </div>
        <div class="flex justify-between items-center  w-full space-x-2 space-x-reverse">
            <label for="" class="text-base font-yekan ">نام خانوادگی:</label>
            <input type="text" class="font-yekan py-1 px-2   rounded-md text-black outline-none box-border" name="family" value="{{old("family",$user->family)}}">
        </div>
        <div class="flex justify-between items-center  w-full space-x-2 space-x-reverse ">
            <label for="" class="text-base font-yekan ">تلفن ثابت  :</label>
            <input type="text" class="font-yekan py-1 px-2  rounded-md text-black outline-none" name="tel" value="{{old("tel",$user->tel)}}">
        </div>

        <div class="flex justify-between items-center  w-full space-x-2 space-x-reverse">
            <label for="" class="text-base font-yekan ">ایمیل:</label>
            <input type="text" class="font-yekan py-1 px-2  rounded-md text-black outline-none" name="email" value="{{old('email',$user->email)}}">
        </div>
        <div class="flex justify-between items-center  w-full space-x-2 space-x-reverse">
            <label for="" class="text-base font-yekan ">کد ملی:</label>
            <input type="text" class="font-yekan  py-1 px-2  rounded-md text-black outline-none" name="national_code" value="{{old("national_code",$user->national_code)}}">
        </div>

        <div class="flex justify-between items-center  w-full space-x-2 space-x-reverse ">
            <label for="" class="text-base font-yekan ">آدرس :</label>
            <textarea class="font-yekan py-1 px-2  rounded-md text-black outline-none" name="address">{{old('address',$user->address)}}</textarea>
        </div>
        <div>
            <button class="text-base font-semibold bg-sky-500 px-6 py-1.5 rounded-md font-yekan">تکمیل ثبت نام</button>
        </div>
    </form>
@endsection
