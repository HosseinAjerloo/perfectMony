@extends('Panel.layout.master')


@section('container')

    <section class="py-3 px-3 w-full ">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8  lg:px-8">

            <div
                class="align-middle inline-block min-w-full shadow overflow-hidden bg-white shadow-dashboard  pt-3 rounded-bl-lg rounded-br-lg">
                <table class="w-full min-w-full">
                    <thead>
                    <tr>

                        <th class=" py-3 border-b-2 border-gray-300  text-[10px] leading-4 text-blue-500 tracking-wider">
                            تاریخ
                        </th>
                        <th class=" py-3 border-b-2 border-gray-300  text-[10px] leading-4 text-blue-500 tracking-wider">
                            عملیات
                        </th>
                        <th class=" py-3 border-b-2 border-gray-300  text-[10px] leading-4 text-blue-500 tracking-wider">
                            مبلغ هزارتومان
                        </th>

                        <th class=" py-3 border-b-2 border-gray-300  text-[10px] leading-4 text-blue-500 tracking-wider">
                            وضعیت
                        </th>
                        <th class=" py-3 border-b-2 border-gray-300  text-[10px] leading-4 text-blue-500 tracking-wider">
                             مانده کیف پول هزار تومان
                        </th>

                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <tr>

                        <td class=" py-4 whitespace-no-wrap border-b border-gray-500">
                            <div class="text-[10px] leading-5 text-blue-900"> 11:7 1403/06/07</div>
                        </td>
                        <td class="text-[10px] py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            پرداخت بانک سامان
                        </td>
                        <td class="text-[10px] py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            120،000
                        </td>


                        <td class="text-[10px] py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                            <i class="fa-solid fa-minus text-[10px] text-rose-500"></i>
                        </td>
                        <td class="text-[10px] py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            120،000
                        </td>

                    </tr>
                    <tr>

                        <td class=" py-4 whitespace-no-wrap border-b border-gray-500">
                            <div class="text-[10px] leading-5 text-blue-900"> 11:7 1403/06/07</div>
                        </td>
                        <td class=" text-[10px] py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            <p class="text-center ">
                                صدور کارت هدیه 1 دلاری
                            </p>
                            <div class="flex items-center  space-x-3 space-x-reverse">
                                <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                     class="w-4 h-4 mt-1 copy cursor-pointer transition-all hover:scale-150">

                                <span class="text-[10px] sm:text-base">12056978</span>
                            </div>

                            <div class="flex items-center  space-x-3 space-x-reverse">
                                <img src="{{asset('src/images/Group 422.png')}}" alt=""
                                     class="w-4 h-4 mt-1 copy cursor-pointer transition-all hover:scale-150">
                                <span class="text-[10px] text-sm sm:text-base">12056564654978</span>

                            </div>

                        </td>
                        <td class="text-[10px] px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            120000
                        </td>


                        <td class="text-[10px] px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                            <i class="fa-solid fa-minus text-[10px] text-rose-500"></i>
                        </td>
                        <td class="text-[10px] px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            120،000
                        </td>

                    </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </section>

@endsection



@section('script-tag')


@endsection
