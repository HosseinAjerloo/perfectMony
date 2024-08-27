@extends('Panel.layout.master')


@section('container')

    <section class="py-3 px-3 w-full space-y-1 ">
        <div class="min-w-full w-full flex flex-col space-y-3 bg-sky-500">
            <div class="flex items-center min-w-full  justify-between border-b-4 border-gray-200">
                <div class="text-[10px] w-2/12  text-center py-2">تاریخ</div>
                <div class="text-[10px] w-1/4  text-center py-2">تراکنش</div>
                <div class="text-[10px] w-2/12  text-center py-2">مبلغ هزارتومان</div>
                <div class="text-[10px] w-1/12  text-center py-2">وضعیت</div>
                <div class="text-[10px] w-2/12  text-center py-2">مانده هزارتومان</div>
            </div>
        </div>
        <article class="min-w-full w-full ">
            <div class="min-w-full w-full flex flex-col bg-slate-50 text-black p-2 rounded-md">
                <div class="flex items-center min-w-full  justify-between ">
                    <div class="text-[10px] w-2/12  text-center py-2">1403/02/01 11:07</div>
                    <div class="text-[10px] w-1/4  text-center py-2">صدور کارت هدیه پرفکت مانی</div>
                    <div class="text-[10px] w-2/12 text-center py-2">120،000</div>
                    <div class="text-[10px] w-1/12  text-center py-2"><i
                            class="fa-solid fa-minus text-[10px] text-rose-500"></i></div>
                    <div class="text-[10px] w-2/12  text-center py-2">120،000</div>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold sm:text-base">
                        کد فعال سازی:
                    </p>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <span class="text-sm sm:text-base">100001515645</span>
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold sm:text-base">
                        شماره ووچر:
                    </p>
                    <div class=" relative">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <span class="text-sm sm:text-base">465465</span>
                            <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        </div>

                    </div>
                </div>
            </div>

        </article>
        <article class="min-w-full w-full ">
            <div class="min-w-full w-full flex flex-col bg-slate-200 text-black p-2 rounded-md">
                <div class="flex items-center min-w-full  justify-between ">
                    <div class="text-[10px] w-2/12  text-center py-2">1403/02/01 11:07</div>
                    <div class="text-[10px] w-1/4  text-center py-2">صدور کارت هدیه پرفکت مانی</div>
                    <div class="text-[10px] w-2/12 text-center py-2">120،000</div>
                    <div class="text-[10px] w-1/12  text-center py-2">
                        <i class="fa-solid fa-plus text-[10px] text-green-400"></i>
                    </div>
                    <div class="text-[10px] w-2/12  text-center py-2">120،000</div>
                </div>


            </div>

        </article>

        <article class="min-w-full w-full ">
            <div class="min-w-full w-full flex flex-col bg-slate-50 text-black p-2 rounded-md">
                <div class="flex items-center min-w-full  justify-between ">
                    <div class="text-[10px] w-2/12  text-center py-2">1403/02/01 11:07</div>
                    <div class="text-[10px] w-1/4  text-center py-2">صدور کارت هدیه پرفکت مانی</div>
                    <div class="text-[10px] w-2/12 text-center py-2">120،000</div>
                    <div class="text-[10px] w-1/12  text-center py-2"><i
                            class="fa-solid fa-minus text-[10px] text-rose-500"></i></div>
                    <div class="text-[10px] w-2/12  text-center py-2">120،000</div>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold sm:text-base">
                        کد فعال سازی:
                    </p>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <span class="text-sm sm:text-base">100001515645</span>
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold sm:text-base">
                        شماره ووچر:
                    </p>
                    <div class=" relative">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <span class="text-sm sm:text-base">465465</span>
                            <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        </div>

                    </div>
                </div>
            </div>

        </article>
        <article class="min-w-full w-full ">
            <div class="min-w-full w-full flex flex-col bg-slate-200 text-black p-2 rounded-md">
                <div class="flex items-center min-w-full  justify-between ">
                    <div class="text-[10px] w-2/12  text-center py-2">1403/02/01 11:07</div>
                    <div class="text-[10px] w-1/4  text-center py-2">صدور کارت هدیه پرفکت مانی</div>
                    <div class="text-[10px] w-2/12 text-center py-2">120،000</div>
                    <div class="text-[10px] w-1/12  text-center py-2">
                        <i class="fa-solid fa-plus text-[10px] text-green-400"></i>
                    </div>
                    <div class="text-[10px] w-2/12  text-center py-2">120،000</div>
                </div>


            </div>

        </article>
    </section>

@endsection



@section('script-tag')


@endsection
