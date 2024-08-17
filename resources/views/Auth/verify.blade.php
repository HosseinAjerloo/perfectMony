@extends('Auth.Layout.master')
@section('message-box')
    <h1 class=" border-2 border-2-white rounded-md py-3 px-12 font-semibold text-lg ">
        به <span class="text-sky-500 ">ساینا ارز </span> خوش آمدین
    </h1>
@endsection

@section('action')
    <article class="py-5 px-3 flex flex-col items-center justify-center space-y-4">
        <p class="px-4 text-center">
            کد پیامک شده به شماره {{$otp->mobile}}
            را وارد نمایید:
        </p>
        <form id="form" class="flex flex-col space-y-4 justify-center items-center"
              action="{{route('login.dologin.post',$otp->token)}}" method="post">
            @csrf
            <div class="justify-between items-center">
                <label for="" class="text-sm">رمز عبور پیامک شده: </label>
                <input type="text" class="py-1 rounded-md outline-none text-black" name="SMS_code">
            </div>
            <button id="resend" class="px-16 py-2 bg-sky-500 rounded-md sm:text-base font-semibold box-content text-sm "
                    disabled type="button"></button>
            <button id="login" class="px-20 py-2 bg-sky-500 rounded-md text-base font-semibold box-content " type="submit">ورود
            </button>
        </form>
    </article>
@endsection


@section('container')

{{--    <ul class="space-y-3">--}}
{{--        <li class="flex  items-center space-x-2 space-x-reverse">--}}
{{--            <img src="{{asset('src/images/Group 414.png')}}" alt="" class="w-9 h-9">--}}
{{--            <p class="mb-2 text-sm ">خرید آسان و سریع ووچر پرفکت مانی</p>--}}
{{--        </li>--}}
{{--        <li class="flex  items-center space-x-2 space-x-reverse">--}}
{{--            <img src="{{asset('src/images/Group 414.png')}}" alt="" class="w-9 h-9">--}}
{{--            <p class="mb-2 text-sm ">تحویل آنی و اتوماتیک</p>--}}
{{--        </li>--}}
{{--        <li class="flex  items-center space-x-2 space-x-reverse">--}}
{{--            <img src="{{asset("src/images/Group 414.png")}}" alt="" class="w-9 h-9">--}}
{{--            <p class="mb-2 text-sm ">پشتیبانی 24 ساعته</p>--}}
{{--        </li>--}}
{{--        <li class="flex  items-center space-x-2 space-x-reverse">--}}
{{--            <img src="{{asset('src/images/Group 414.png')}}" alt="" class="w-9 h-9">--}}
{{--            <p class="mb-2 text-sm ">بدون نیاز به اخراز هویت</p>--}}
{{--        </li>--}}
{{--    </ul>--}}
@endsection
@section('script-tag')

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("{{\Carbon\Carbon::make($otp->created_at)->toDateTimeString()}}")

        var now = new Date("{{\Carbon\Carbon::now()->subMinutes(3)->toDateTimeString()}}")


        // Update the count down every 1 second
        var x = setInterval(function () {
            now.setSeconds(now.getSeconds() + 1)


            // Get today's date and time

            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            console.log(distance)
            // Time calculations for days, hours, minutes and seconds

            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // console.log(minutes)
            // Display the result in the element with id="demo"
            var text = '';
            if (minutes > 0) {
                text += 'مدت زمان باقی مانده تا دریافت مجدد کد ' + minutes + ' دقیقه و ' + seconds + ' ثانیه  '
            } else {
                text = 'مدت زمان باقی مانده تا دریافت مجدد کد ' + seconds + ' ثانیه  '
            }
            document.getElementById("resend").innerHTML = text

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                let resend_btn = document.getElementById("resend")
                resend_btn.innerHTML = "دریافت مجدد کد";
                let btnLogin = document.getElementById("login");
                btnLogin.remove();
                resend_btn.removeAttribute('disabled')
                resend_btn.removeAttribute('type')
                let form = document.getElementById('form');
                form.action = "{{route("login.resend",$otp->token)}}"


            }
        }, 1000);
    </script>
@endsection
