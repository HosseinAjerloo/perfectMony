@switch($type)
    @case('message-box')
        <section class="space-y-3">
            <div class="flex justify-center min-w-full items-center">
                <img src="" class="w-8 h-8">
                <h1 class="font-bold text-lg text-rose-500">خرید ناموفق کارت هدیه (ووچر)</h1>
            </div>
            <div class="flex items-center justify-center text-black text-sm border-2 rounded-md border-black ">
                <p class="p-2">
                    متاسفانه به علت بروز مشکل در درگاه بانکی ، پرداخت شما ناموفق بوده است.
                    در صورت عدم برگشت پول ظرف مدت <span class="font-bold text-rose-500">72 ساعت</span> با پشتیبانی درگاه بانک مربوطه تماس بگیرید.

                </p>
            </div>
        </section>
        @break
    @case('container')
        <section class="px-2">
            <article
                class=" grid grid-cols-2 border-2 border-black rounded-md text-black justify-between divide-x-2 divide-x-reverse divide-black">
                <div class="text-right text-sm space-y-2 divide-y-2 divide-black bg-sky-500 text-white">
                    <p class="pr-1">
                        تاریخ و زمان خرید:
                    </p>
                    <p class="pr-1">
                        شماره سفارش:
                    </p>
                    <p class="pr-1">
                        درگاه پرداخت:
                    </p>
                </div>
                <div class="text-left text-sm space-y-2 divide-y-2 divide-black ">
                    <p class="pl-2">
                        1403/06/09 15:17:49
                    </p>
                    <p class="pl-2">
                        #6577214
                    </p>
                    <div class="pl-2 flex items-center justify-end space-x-1 space-x-reverse">
                        <img src="{{asset('src/images/bankSamanSvg.svg')}}" alt="" class="w-6 h-6">
                        <p>بانک سامان</p>
                    </div>
                </div>
            </article>
        </section>
        <div class="min-w-full flex items-center justify-center mt-16 text-black">
            <p>با تشکر از همراهی شما ، تیم ساینا ارز</p>
            <img src="{{asset('src/images/icon.svg')}}" alt="">
        </div>
        @break
@endswitch
