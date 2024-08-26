@extends('Panel.layout.master')

@section('message-box')
    <h1 class=" border-2 border-2-white rounded-md py-3 px-3 text-sm sm:text-base font-semibold  ">
        ضمن تشکر از انتخاب <span class="text-sky-500  font-semibold"> ساینا ارز  </span> لطفا مشکل خود را بیان کنید تا
        در اسرع وقت کارشناسان ما مشکل شما را بر طرف کنند.
    </h1>
@endsection

@section('container')
    <form enctype="multipart/form-data"
        class="font-yekan py-5 px-4 w-full sm:w-2/4 md:w-2/3 lg:w-2/4 xl:w-1/4 flex flex-col items-center justify-center space-y-9 sm:mx-auto"
        method="post" action="{{route('panel.ticket-add-submit')}}">
        @csrf
        <div class="w-full">
            <label for="input_subject" class="text-base">
                عنوان تیکت
                <input id="input_subject" type="text" class="py-1 px-2 m-2 rounded-md text-black outline-none w-full" name="subject" placeholder="عنوان تیکت">
            </label>
        </div>
        <div class="w-full">
            <label for="input_subject" class="text-base">
                متن پیام
                <textarea id="input_subject"  name="message" cols="40" rows="5" class="py-1 px-2 m-2 rounded-md text-black outline-none w-full"></textarea>
            </label>
        </div>
        <input type="file" name="image">
        <div>
            <button class="text-base font-semibold bg-sky-500 px-6 py-1.5 rounded-md font-yekan">ثبت تیکت</button>
        </div>
    </form>
@endsection
