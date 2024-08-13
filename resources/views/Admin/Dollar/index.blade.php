@extends('Panel.layout.master')

@section('container')
    <article class="py-5 px-3 flex flex-col items-center justify-center space-y-9">
        <div class="flex justify-center items-center flex-col  w-full sm:w-2/6 md:w-1/3 lg:w-1/4 space-y-5">
            <form action="{{route('panel.admin.dollar-price-submit')}}" method="get"
                  class=" w-full text-center">
                <label  class="border-2 border-2-white rounded-md bg-gray-800  py-3 px-3 text-center flex justify-between items-center space-x-2 space-x-reverse">
                    قیمت دلار
                    <input type="number" name="dollar_price" value="{{$dollar_price}}" class="text-black p-2">
                    ریال
                </label>
                <button class="bg-sky-500 m-2 py-1.5 px-2 rounded-md rounded-md">ثبت قیمت دلار</button>
            </form>
        </div>
    </article>

@endsection
