@switch($type)
    @case('message-box')
        <section class="space-y-3">
            <div class="flex justify-center min-w-full items-center">
                <h1 class="font-bold text-lg text-green-500">خرید موفق کارت هدیه (ووچر)</h1>
                <img src="{{asset('src/images/Group 414.png')}}" class="w-8 h-8 mt-3">
            </div>
            <div class="flex items-center justify-center text-black text-sm ">
                <p>خرید کارت هدیه 5 دلاری و کسر مبلغ از کیف پول</p>
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
                        شماره ووچر:
                    </p>
                    <p class="pr-1">
                        کدفعال سازی ووچر:
                    </p>
                    <p class="pr-1">
                        شماره سفارش:
                    </p>
                    <p class="pr-1">
                        مبلغ سفارش:
                    </p>
                </div>
                <div class="text-left text-sm space-y-2 divide-y-2 divide-black ">
                    <p class="pl-2">
                        1403/06/09 15:17:49
                    </p>
                    <p class="pl-2">
                        3862850767
                    </p>
                    <p class="pl-2">
                        8683760825678912
                    </p>
                    <p class="pl-2">
                        #6577214
                    </p>
                    <p class="pl-2">
                        343 ریال
                    </p>
                </div>
            </article>
        </section>
        <div class="min-w-full flex items-center justify-center mt-16 text-black">
            <p>با تشکر از همراهی شما ، تیم ساینا ارز</p>
            <img src="{{asset('src/images/icon.svg')}}" alt="">

        </div>
        @break
@endswitch
