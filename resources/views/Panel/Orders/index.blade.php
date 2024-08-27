@extends('Panel.layout.master')


@section('container')

    <section class="py-3 px-3 w-full ">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">

            <div
                class="align-middle inline-block min-w-full shadow overflow-hidden bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
                <table class="w-full min-w-full">
                    <thead>
                    <tr>

                        <th class="px-6 py-3 border-b-2 border-gray-300  text-sm leading-4 text-blue-500 tracking-wider">
                            تاریخ
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300  text-sm leading-4 text-blue-500 tracking-wider">
                            عملیات
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300  text-sm leading-4 text-blue-500 tracking-wider">
                            مبلغ
                        </th>

                        <th class="px-6 py-3 border-b-2 border-gray-300  text-sm leading-4 text-blue-500 tracking-wider">
                            وضعیت
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300  text-sm leading-4 text-blue-500 tracking-wider">
                            مانده کیف پول
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300  text-sm leading-4 text-blue-500 tracking-wider">
                            بیشتر
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <tr>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                            <div class="text-sm leading-5 text-blue-900"> 11:7 1403/06/07 </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            پرداخت بانک سامان
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            1،200،000 ریال
                        </td>


                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                            <i class="fa-solid fa-plus text-2xl text-green-400"></i>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            1،200،000 ریال
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                            <button
                                class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr >

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                            <div class="text-sm leading-5 text-blue-900"> 11:7 1403/06/07 </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            پرداخت بانک سامان
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            1،200،000 ریال
                        </td>


                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                            <i class="fa-solid fa-minus text-2xl text-rose-500"></i>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            1،200،000 ریال
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                            <button
                                class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr >

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                            <div class="text-sm leading-5 text-blue-900"> 11:7 1403/06/07 </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            <p>
                                صدور کارت هدیه 1 دلاری
                            </p>
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <span class="text-sm sm:text-base">12056978</span>
                                <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                            </div>

                            <div class="flex items-center space-x-3 space-x-reverse">
                                <span class="text-sm sm:text-base">12056564654978</span>
                                <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                            </div>

                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            1،200،000 ریال
                        </td>


                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                            <i class="fa-solid fa-minus text-2xl text-rose-500"></i>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            1،200،000 ریال
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                            <button
                                class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">
                                <i class="fa-solid fa-eye"></i>
                            </button>
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
