@extends('Panel.layout.master')

@section('message-box')
    <div class="flex justify-between min-w-full items-center">
        <h1 class="font-extrabold">سوالات متداول</h1>
        <a href="{{route('panel.ticket')}}" class="font-sm sm:font-semibold text-white rounded-md bg-sky-500 py-1.5 px-2"> ورود به قسمت تیکت </a>
    </div>
@endsection

@section('container')

    <section class="px-2 space-y-6">
        <article class="border-2 border-white rounded-md cursor-pointer pr">

            <div class="bg-white p-2 flex items-center text-black text-sm space-x-reverse space-x-3 font-bold">
                <img src="{{asset('src/images/faq.svg')}}" alt="">
                <p>چرا برخی موارد تراکنش بانکی برگشت می خورد ؟</p>
            </div>
            <div
                class="py-2 px-2.5 text-center leading-snug text-sm sm:text-base toggle hidden">
                <p>
                    چرا برخی موارد تراکنش بانکی برگشت می خورد ؟
                    بعد از پرداخت باید منتظر بمانید تا به سایت ساینا ارز منتقل شوید و اگر دگمه stop یا Back یا F5
                    (Refresh) را بزنید.  پرداخت شما برگشت می خورد و بانک مبلغ را ظرف مدت 24 الی 72 ساعت به حساب شما
                    باز
                    می گرداند.</p>
            </div>

        </article>

        <article class="border-2 border-white rounded-md cursor-pointer pr">
                <div class="bg-white p-2 flex items-center text-black text-sm space-x-reverse space-x-3 font-bold">
                    <img src="{{asset('src/images/faq.svg')}}" alt="">
                    <p>چگونه مشخصات کارت هدیه خریداری شده را ببینم ؟</p>
                </div>
                <div
                    class="py-2 px-2.5 text-center leading-snug text-sm sm:text-base space-y-3 flex flex-col items-center justify-center toggle hidden">
                    <p>در قسمت سوابق علاوه بر سوابق تراکنش می توانید مشخصات کارت هدیه خریداری شده را نیز مشاهده و کپی
                        کنید.</p>
                    <img class="sm:w-2/5" src="{{asset('src/images/example.svg')}}" alt="">

                </div>
        </article>

        <article class="border-2 border-white rounded-md cursor-pointer pr">
                <div class="bg-white p-2 flex items-center text-black text-sm space-x-reverse space-x-3 font-bold">
                    <img src="{{asset('src/images/faq.svg')}}" alt="">
                    <p>چرا مشخصات فردی، شماره، کد ملی و آدرس گرفته می شود؟</p>
                </div>
                <div class="py-2 px-2.5 text-center leading-snug text-sm sm:text-base toggle hidden">
                    <p>طبق قوانین مبارزه با پولشویی بانک مرکزی این اطلاعات بایستی از کاربران دریافت شود. شما بایستی با
                        کارت
                        بانکی، شماره موبایل و کد ملی خود در سایت ثبت نام کرده و خرید خود را انجام دهید. این اطلاعات
                        کاملا
                        محرمانه نگهداری خواهد شد.</p>
                </div>

        </article>

        <article class="border-2 border-white rounded-md cursor-pointer pr">

                <div class="bg-white p-2 flex items-center text-black text-sm space-x-reverse space-x-3 font-bold">
                    <img src="{{asset('src/images/faq.svg')}}" alt="">
                    <p>چرا سایت ساینا ارز برای من باز نمی شود ؟</p>
                </div>
                <div class="py-2 px-2.5 text-center leading-snug text-sm sm:text-base toggle hidden">
                    <p>فیلترشکن خود را خاموش کنید و دوباره امتحان کنید.</p>
                </div>

        </article>
    </section>
@endsection

@section('script-tag')

    <script>
        $(document).ready(function () {
            $(".pr").click(function () {
                $(this).children(".toggle").toggle(1000)
            });
        });
    </script>
@endsection