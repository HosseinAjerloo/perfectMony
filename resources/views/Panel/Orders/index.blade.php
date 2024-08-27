@extends('Panel.layout.master')


@section('container')

    <section class="py-3 px-3 w-full ">
        <article class="flex min-w-full bg-green-500">
            <div class="flex flex-col bg-rose-500 w-1/2 space-y-3 px-1">
               <div class="min-w-full flex items-center justify-between ">
                   <div class="flex flex-col items-center ">
                       <p class="text-sm">تاریخ:</p>
                       <p class="text-sm">1403/02/01</p>
                   </div>
                   <div class="flex flex-col items-center ">
                       <p class="text-sm">ساعت:</p>
                       <p class="text-sm">11:54</p>
                   </div>
               </div>
                <div class="min-w-full flex flex-col justify-center text-sm text-center">
                    <p>صدور کارت هدیه 1 دلاری پرفکت مانی</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <span class="text-sm sm:text-base">45645</span>
                            <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <span class="text-sm sm:text-base">798764</span>
                            <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                        </div>
                    </div>
                </div>
            </div>
            <div>

            </div>
        </article>
    </section>

@endsection



@section('script-tag')


@endsection
