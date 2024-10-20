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
                        <h1>مبلغ حواله :
                            <span
                                class="  text-green-700 @error('amount') text-rose-600/70 @enderror">
                                @if($errors->has('amount'))
                                    {{$errors->first('amount')}}
                                @else
                                    {{$inputs['amount']}}
                                @endif
                            </span>
                        </h1>

                        @if(!$errors->any())
                            <h1>قیمت به ریال : <span class="text-green-700">{{$inputs['rial']}}</span></h1>
                        @endif

                        <h1>آدرس حساب مقصد : <span
                                class=" text-green-700  @error('account')  text-rose-600/70 @enderror">
                                @if($errors->has('account'))
                                    {{$errors->first('account')}}
                                @else
                                    {{$inputs['account']}}
                                @endif

                            </span>
                        </h1>
                    </div>
                    <p class="text-gray-400 px-2 py-1.5 text-right">
                        <span class="text-rose-600">اطلاعیه </span>:
                        شما درحال انجام حواله با اطلاعات فوق هستید جهت ادامه بر روی دکمه زیر کلیک کنید.
                    </p>
                    @if(!$errors->any())
                        <form action="">
                            <input type="hidden" name="transmission">
                            <input type="hidden" name="custom_payment">
                            <button class="px-2 py-1.5 bg-sky-600 text-white p-4 rounded-md text-center w-full">ادامه
                            </button>
                        </form>
                    @else

                        <button class="px-2 py-1.5 bg-rose-600 text-white p-4 rounded-md text-center w-full">ابتدا
                            خطاهای موجود را رفع کنید و سپس اقدام فرمایید
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script-tag')
    <script>
        $(document).ready(function () {
            let toast = $('.toast');
            setTimeout(function () {
                $(toast).addClass('-translate-y-7');
                $(toast).remove();
            }, 9000)


            let closeToast = $('.close-toast');
            $(closeToast).click(function () {
                $(toast).addClass('invisible');
                $(toast).remove();
            });
        })
    </script>
@endsection
