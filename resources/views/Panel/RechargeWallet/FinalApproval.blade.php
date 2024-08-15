@extends('Panel.layout.master')

@section('message-box')
    <div class="flex items-center justify-center space-x-reverse space-x-4 bg-gray-500 p-2">
        <img src="{{asset('src/images/dollar 1.png')}}" alt="" class="w-9 h-9">
        <p class="text-sm text-center sm:text-base">موجودی فعلی شما:{{numberFormat($balance)}} ریال میباشد</p>
    </div>
@endsection

@section('container')

    <form class="flex items-center justify-center flex-col p-3 space-y-4 w-5/4  md:w-4/6 lg:w-2/6 mx-auto from" method="post"
          action="{{route('panel.wallet.charging.store')}}">
        @csrf
        <article class="bg-gray-500 w-full space-y-4 p-2">
            <div class="flex items-center justify-between text-sm sm:text-base">
                <p>مبلغ:</p>
                <p>{{$inputs['price']}} تومان</p>
            </div>
            <div class="flex items-center justify-between text-sm sm:text-base">
                <p>شماره تراکنش:</p>
                <p>{{$inputs['orderID']}}</p>
            </div>
            <div class="flex items-center justify-between text-sm sm:text-base">
                <p> تاریخ و ساعت:</p>
                <p>{{\Morilog\Jalali\Jalalian::forge(\Carbon\Carbon::now()->toDateTimeString())->format('%B %d، %Y')}}</p>
            </div>
            <div class="flex items-center justify-between text-sm sm:text-base">
                <p>وضعیت:</p>
                <p class="text-yellow-300">درانتظار پرداخت</p>
            </div>
        </article>
        <div class=" flex items-center justify-start  max-w-max  rounded-md ">
            <button class="bg-sky-500 py-1.5 px-12 rounded-md submit" type="submit">پرداخت مبلغ</button>
        </div>
        <div class=" flex items-center justify-start  max-w-max  rounded-md back">
            <a href="{{route('panel.wallet.charging')}}" class="bg-sky-500 py-1.5 px-10 rounded-md ">بازگشت</a>
        </div>
        <input type="hidden" name="price" value="{{$inputs['price']}}">
        <input type="hidden" name="bank_id" class="hidden bank" value="{{$inputs['bank_id']}}">
        <div type="button" class="loading hidden">

            <i class="fas fa-spinner fa-spin   animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"></i>
            لطفا منتظر بمانید
        </div>
    </form>

@endsection



@section('script-tag')
    <script>
        $(document).ready(function () {
                $('.submit').click(function (){
                    $(this).remove();
                    $(".back").remove();
                    $(".loading").removeClass('hidden');
                    $(".from").submit();
                })
        })
    </script>
@endsection
