@extends('Panel.layout.master')

@section('message-box')
    <div class="flex items-center justify-center flex-col space-y-3">
        <img src="{{asset('src/images/Group 414.png')}}" alt="" class="w-14 h-14" id="warning-img">
        <div type="button" class="loading ">
            <i class="fas fa-spinner fa-spin   animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"></i>
            درحال ساخت کارت هدیه پرفکت مانی لطفا منتظر بمانید.
        </div>
        <div class="space-x-3 space-x-reverse">
            <p class="text-sm text-center sm:text-lg font-bold" id="warning-text">مبلغ {{substr($payment->amount,0,strlen($payment->amount)-1)}}  تومان به کیف پول شما اضافه شد</p>
        </div>

        <div class="space-x-3 space-x-reverse">
            <button class="py-1.5 px-2 bg-sky-500 rounded-md again hidden" disabled onclick="redirect()">مجددا تلاش فرمایید</button>
        </div>
    </div>
@endsection

@section('container')
    <section class="px-2 py-6 hidden" id="voucher-status">
        <article
            class="flex flex-col justify-between  border-2 border-white rounded-md   p-5  sm:w-4/6 md:w-3/6 lg:w-2/6 xl:w-1/4 mx-auto space-y-3">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold sm:text-base">
                    شماره ووچر:
                </p>
                <div class=" relative">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <span class="text-sm sm:text-base " id="voucher-serial"></span>
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                    </div>

                </div>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold sm:text-base">
                    کد فعال سازی:
                </p>
                <div class="flex items-center space-x-3 space-x-reverse">
                    <span class="text-sm sm:text-base" id="voucher-code"></span>
                    <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                </div>
            </div>
            <div class="flex items-center space-x-2 space-x-reverse">
                <p class="text-sm font-semibold sm:text-base">
                    مبلغ ووچر:
                </p>
                <div class="flex items-center space-x-1 space-x-reverse pe-2">
                    <span class="text-sm sm:text-base" id="voucher-amount">1 دلار</span>
                    <i class="fas fa-dollar-sign text-sky-500 text-lg"></i>
                </div>
            </div>

        </article>
    </section>

{{--<section class="flex items-center justify-center px-2 hidden" id="voucher-pending">--}}
{{--    <div type="button" class="loading flex items-center space-x-3 space-x-reverse" >--}}
{{--        <i class="fas fa-spinner fa-spin   animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"></i>--}}
{{--        <span class="text-lg font-bold flex items-center justify-center text-center">لطفا منتظر بمانید و از بروزرسانی و بارگیری مجدد صفحه خودداری فرمایید.</span>--}}
{{--    </div>--}}
{{--</section>--}}
@endsection
@section('script-tag')

    <script>

        function copyToClipboard(text) {

            var textArea = document.createElement( "textarea" );
            textArea.value = text;
            document.body.appendChild( textArea );
            textArea.select();

            try {
                var successful = document.execCommand( 'copy' );
                var msg = successful ? 'successful' : 'unsuccessful';
                console.log('Copying text command was ' + msg);
            } catch (err) {
                console.log('Oops, unable to copy',err);
            }
            document.body.removeChild( textArea );
        }

        $( '.copy' ).click( function()
        {
            let spanText=$(this).siblings('span').text();
            copyToClipboard( spanText);
        });
    </script>
    <script>
        var createVoucher=function (){
            var dataValue={
                _token:"{{csrf_token()}}",

            }
            $.ajax({
                method:'POST',
                url: "{{route('panel.deliveryVoucherBank',[$invoice, $payment])}}",
                data:dataValue,
                timeout:20000,
                success: function(response){
                    if(response.status!='undefined' && response.status)
                    {
                        $("#voucher-status").removeClass('hidden');
                        $("#voucher-serial").html(response.voucher.serial)
                        $("#voucher-code").html(response.voucher.code)
                        $("#voucher-amount").html(response.payment_amount)
                        $(".loading").addClass('hidden')
                        $("#warning-text").html('کارت هدیه پرفکت مانی بامشخصات ذیل برای شما ایجاد شد')
                        console.log(response);
                    }
                    else {
                        $("#voucher-pending").removeClass('hidden');
                        $("#voucher-pending").addClass('flex');
                        $('#warning-text').html('اتصال به سرور پرفکت مانی با شکست مواجه شد!')
                        $('.loading').addClass('hidden')
                        $("#warning-img").attr('src',"{{asset('src/images/warning.png')}}")
                        $(".again").removeClass('hidden');
                        again();
                        console.log(response);
                    }
                },
                error: function(error){
                    $("#voucher-pending").removeClass('hidden');
                    $("#voucher-pending").addClass('flex');
                    $('#warning-text').html('اتصال به سرور پرفکت مانی با شکست مواجه شد!')
                    $('.loading').addClass('hidden')
                    $("#warning-img").attr('src',"{{asset('src/images/warning.png')}}")
                    $(".again").removeClass('hidden');
                    again();
                },
            });
        }();


        var countDownDate = new Date("{{\Carbon\Carbon::now()->toDateTimeString()}}")

        var now = new Date("{{\Carbon\Carbon::now()->subMinutes(2)->toDateTimeString()}}")


        // Update the count down every 1 second
       function again()
       {
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
                   text += 'مدت زمان باقی مانده تا تلاش مجدد ' + minutes + ' دقیقه و ' + seconds + ' ثانیه  '
               } else {
                   text = 'مدت زمان باقی مانده تا تلاش مجدد ' + seconds + ' ثانیه  '
               }
               document.querySelector(".again").innerHTML = text

               // If the count down is finished, write some text
               if (distance < 0) {
                   clearInterval(x);
                   let resend_btn = document.querySelector(".again")
                   resend_btn.innerHTML = "ارسال درخواست مجددا";
                   resend_btn.removeAttribute('disabled')
               }
           }, 1000);
       }
    </script>
    <script>
        function redirect()
        {
            window.location.href="{{route('panel.deliveryVoucherBankView',[$invoice, $payment])}}"
        }
    </script>
@endsection
