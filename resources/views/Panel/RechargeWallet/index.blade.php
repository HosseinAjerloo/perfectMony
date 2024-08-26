@extends('Panel.layout.master')

@section('message-box')
    <div class="flex  p-2 w-full items-center justify-center">
        <div
            class="rounded-md border-2 border-white w-full p-2 flex space-x-3 space-x-reverse items-center sm:w-1/2 md:w-1/3">
            <img src="{{asset('src/images/newWallet.svg')}}" alt="" class="w-8 h-8">
            <h1 class="font-bold text-white text-md mt-1">کیف پول شما {{$balance}} ریال است</h1>
        </div>
    </div>
@endsection

@section('container')
    <div class="flex items-center justify-center flex-col space-y-3  w-full sm:w-1/2 mx-auto text-center p-2">
        <p>مناسب کسانی که خرید های مکرر از ساینا ارز دارند.</p>
        <p>1-شارژ کیف پول بالای 10 دلار یک دلار اضافه شارژ می شود</p>
        <p>2-موقع تسویه کارت هدیه و یا حواله کیف پول را انتخاب می کنید</p>
    </div>
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
        $(document).ready(function () {
            $(".bank").click(function () {
                $("#form").submit();

            });
        });
    </script>
@endsection
