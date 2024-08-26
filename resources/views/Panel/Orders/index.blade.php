@extends('Panel.layout.master')


@section('container')


    <section class="py-3 px-3 w-full overflow-auto mx-auto">

        <table class="table-fixed  mx-auto  w-max overflow-x-scroll sm:w-2/3 md:w-4/6 ">
            <thead class="bg-sky-500 ">
            <tr class="w-full">
                <th class="py-2 text-sm sm:text-base w-1/12 sm:w-2/6">تاریخ</th>
                <th class="py-2  text-sm sm:text-base w-2/5 sm:max-w-max">عملیات</th>
                <th class="py-2 text-sm sm:text-base w-1/6 sm:max-w-max">مبلغ</th>
                <th class="py-2  text-sm sm:text-base w-1/6 sm:max-w-max">+/-</th>
                <th class="py-2  text-sm sm:text-base w-1/6 sm:max-w-max">مانده کیف پول</th>
                <th class="py-2  text-sm sm:text-base w-2/12 sm:max-w-max">بیشتر</th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-center py-2  w-full ">
                <td class="py-2  text-sky-500">1403/02/04 12:14</td>
                <td class="py-2 text-sky-500 ">
                    <div class="flex items-center justify-center  flex-col  space-y-3 w-full text-sky-500 ">
                        <p>صدور کارت هدیه 1 دلاری پرفکت مانی</p>
                        <div class="flex  w-full space-x-4 space-x-reverse items-center justify-center">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy cursor-pointer bg-white p-2 rounded-md">
                            <p class="font-bold text-sm sm:text-base">575899</p>
                        </div>
                        <div class="flex  w-full space-x-4 space-x-reverse items-center justify-center">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy cursor-pointer bg-white p-2 rounded-md">
                            <p class="font-bold text-sm sm:text-base">879899875879899875</p>
                        </div>
                    </div>
                </td>
                <td class="py-2  text-sky-500">1200000</td>
                <td class="py-2  text-sky-500">+</td>
                <td class="py-2 text-sky-500">600000</td>
                <td class="py-2 text-sky-500">بیشتر</td>
            </tr>

            <tr class="text-center py-2  w-full ">
                <td class="py-2 text-sky-500 ">1403/02/04 12:14</td>
                <td class="py-2 text-sky-500 ">
                    <div class="flex items-center justify-center  flex-col  space-y-3 w-full text-sky-500 ">
                        <p>صدور کارت هدیه 1 دلاری پرفکت مانی</p>
                        <div class="flex  w-full space-x-4 space-x-reverse items-center justify-center">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy cursor-pointer bg-white p-2 rounded-md">
                            <p class="font-bold text-sm sm:text-base">575899</p>
                        </div>
                        <div class="flex  w-full space-x-4 space-x-reverse items-center justify-center">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy cursor-pointer bg-white p-2 rounded-md">
                            <p class="font-bold text-sm sm:text-base">879899875879899875</p>
                        </div>
                    </div>
                </td>
                <td class="py-2 text-sky-500 ">1200000</td>
                <td class="py-2  text-sky-500">+</td>
                <td class="py-2 text-sky-500 ">600000</td>
                <td class="py-2 text-sky-500">بیشتر</td>
            </tr>
            <tr class="text-center py-2  w-full ">
                <td class="py-2 text-sky-500 ">1403/02/04 12:14</td>
                <td class="py-2 text-sky-500 ">
                    <div class="flex items-center justify-center  flex-col  space-y-3 w-full text-sky-500 ">
                        <p>صدور کارت هدیه 1 دلاری پرفکت مانی</p>
                        <div class="flex  w-full space-x-4 space-x-reverse items-center justify-center">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy cursor-pointer bg-white p-2 rounded-md">
                            <p class="font-bold text-sm sm:text-base">575899</p>
                        </div>
                        <div class="flex  w-full space-x-4 space-x-reverse items-center justify-center">
                            <img src="{{asset('src/images/copy.svg')}}" alt="" class="inline-block copy cursor-pointer bg-white p-2 rounded-md">
                            <p class="font-bold text-sm sm:text-base">879899875879899875</p>
                        </div>
                    </div>
                </td>
                <td class="py-2 text-sky-500 ">1200000</td>
                <td class="py-2  text-sky-500">+</td>
                <td class="py-2 text-sky-500 ">600000</td>
                <td class="py-2 text-sky-500">بیشتر</td>
            </tr>




            </tbody>
        </table>
    </section>

@endsection



@section('script-tag')


@endsection
