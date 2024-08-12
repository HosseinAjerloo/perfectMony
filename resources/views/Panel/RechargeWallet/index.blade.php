@extends('Panel.layout.master')

@section('message-box')
    <div class="flex items-center justify-center space-x-reverse space-x-4 bg-gray-500 p-2">
        <img src="{{asset('src/images/dollar 1.png')}}" alt="" class="w-9 h-9">
        <p class="text-sm text-center sm:text-base">موجودی فعلی شما:{{$balance}} ریال میباشد</p>
    </div>
@endsection

@section('container')

    <form class="flex items-center justify-center flex-col space-y-3  w-full sm:w-1/2 mx-auto"
          action="{{route('panel.wallet.charging-Preview')}}" method="get" id="form">
        <p class="text-center text-sm py-2 sm:text-base ">
            مبلغ (تومان) :
        </p>
        <input type="text"
               class="rounded-md bg-black py-1  border border-white outline-none Desired_amount custom_payment text-gray-400 w-5/6 md:w-4/6"
               name="price">


        @foreach($banks as $bank)
            <label data-bank="{{$bank->id}}" for="bank-{{$bank->id}}"
                   class=" flex items-center justify-start  max-w-max   rounded-md  cursor-pointer bank">
                <img src="{{asset($bank->logo_url)}}" alt="" class="w-12 h-12 bg-sky-500 rounded-md">
                <span class="bg-sky-500 py-1.5 px-2 rounded-se-md rounded-ee-md"> {{$bank->name}} </span>
                <input type="radio" name="bank_id" id="bank-{{$bank->id}}" class="hidden bank" value="{{$bank->id}}">
            </label>
        @endforeach
    </form>

@endsection



@section('script-tag')

    <script>
        $(document).ready(function (){
           $(".bank").click(function (){
                $("#form").submit();

           }) ;
        });
    </script>
@endsection
