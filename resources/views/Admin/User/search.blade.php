@extends('Panel.layout.master')

@section('message-box')
    <form action="{{route('panel.admin.user.search')}}"
          class=" px-2 min-w-full flex items-center justify-center mb-6 relative" method="POST">
        @csrf
        <input name="search" type="text" placeholder="جستجو"
               class="text-gray-500 outline-none placeholder:text-gray-600/50 min-w-full  sm:w-1/2 py-3 px-2 rounded-md ring-8 ring-offset-4 ring-gray-500/50">
        <i class="fas fa-search absolute text-2xl  text-gray-700/50 left-3 top-[12px]"></i>
    </form>
@endsection

@section('container')
    @foreach($users as $user)
        <section class="flex justify-center  flex-col px-4 mt-3">
            <article
                class="pb-8 space-y-3 flex-wrap rounded-md text-black  bg-white  p-2 ring-8 ring-offset-8 ring-gray-800 flex items-center justify-between ">
                <div class="flex bg-red-100 items-center space-x-3 space-x-reverse min-w-full rounded-md p-4 ">
                    <div class="flex items-center justify-center flex-col space-y-2">
                        <img src="{{asset('src/images/avatar1.png')}}" alt="" class="w-16 h-16">
                        @if($user->validationFiledUser())
                            <i class="fa-solid fa-xmark text-rose-600 text-xl font-bold"></i>

                        @else
                            <i class="fa-solid fa-check text-green-600 text-xl font-bold"></i>
                        @endif
                    </div>
                    <div class="space-y-1">

                        <div class="flex items-center space-x-2 space-x-reverse">
                            <p class="text-gray-500 text-sm">نام و نام خانوادگی:</p>
                            <h1 class="font-bold tetx-sm leading-6 text-gray-700">{{$user->fullName}}</h1>
                        </div>

                        <div class="flex items-center space-x-2 space-x-reverse">
                            <p class="text-gray-500">موجودی کیف پول:</p>
                            <h1 class="font-bold tetx-sm leading-6 text-gray-700"> {{$user->getCreaditBalance()}}
                                ریال</h1>
                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <p class="text-gray-500">شماره تلفن:</p>
                            <h1 class="font-bold tetx-sm leading-6 text-gray-700">{{$user->mobile}}</h1>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col space-y-3">
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <i class="fa-solid fa-location-dot"></i>
                        <p class="tetx-sm leading-6 text-gray-600">{{$user->address??'کاربرآدرس خودرا وارد نکرده است'}}</p>
                    </div>
                </div>
                <div class="min-w-full h-[1px] rounded-md bg-gray-300"></div>
                <div
                    class="min-w-full flex items-center space-x-2 space-x-reverse text-sm text-white justify-center sm:justify-normal ">
                    <a href="@if($user->type!='admin') {{route('panel.admin.login-another-user',$user->id)}} @else # @endif"
                       class="flex items-center justify-center px-4 py-1.5 bg-sky-500 rounded-md shadow-amber-300 shadow-2xl">
                        @if($user->type!='admin') واردشوید @else کاربرادمین@endif
                    </a>
                    <a href="{{route('panel.admin.user.inactive',$user->id)}}"
                       class="flex items-center justify-center px-4 py-1.5  rounded-md shadow-amber-300 shadow-2xl  @if($user->is_active) bg-rose-500  @else bg-emerald-400 @endif ">
                        @if($user->is_active)
                            غیرفعال
                            کردن کاربر
                        @else
                            فعال کردن کاربر
                        @endif
                    </a>
                </div>


            </article>
        </section>
    @endforeach



{{--    <section class="min-w-full flex justify-center items-center space-x-reverse space-x-2 px-2 flex-wrap">--}}

{{--        @if($users->currentPage()>1)--}}

{{--            @for($j=$users->currentPage()-5;$j<$users->currentPage();$j++)--}}
{{--                @if($j!=$users->currentPage() and $j>0)--}}
{{--                    <a href="{{$users->url($j)}}"--}}
{{--                       class="w-8 h-8 rounded-sm  flex items-center justify-center font-bold shadow shadow-emerald-300 mt-5 @if($users->currentPage()==$j) @endif">--}}
{{--                        {{$j}}--}}
{{--                    </a>--}}
{{--                @endif--}}

{{--            @endfor--}}
{{--            <div--}}
{{--                class="w-8 h-8 rounded-sm  flex items-center justify-center font-bold shadow shadow-emerald-300 mt-5">--}}
{{--                ...--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        @if($users->hasPages())--}}
{{--            @for($i=$users->currentPage();$i<$users->currentPage()+3;$i++)--}}

{{--                @if($users->lastPage()>$i)--}}
{{--                    <a href="{{$users->url($i)}}"--}}
{{--                       class="w-8 h-8 rounded-sm  flex items-center justify-center font-bold shadow shadow-emerald-300 mt-5 @if($users->currentPage()==$i)selectPage @endif">--}}
{{--                        {{$i}}--}}
{{--                    </a>--}}
{{--                @endif--}}

{{--            @endfor--}}
{{--        @endif--}}
{{--        @if($users->hasMorePages() )--}}
{{--            <div--}}
{{--                class="w-8 h-8 rounded-sm  flex items-center justify-center font-bold shadow shadow-emerald-300 mt-5">--}}
{{--                ...--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        @if($users->hasMorePages() and $users->currentPage()>=3)--}}
{{--            @for($i=$users->currentPage()+4;$i<$users->currentPage()+6;$i++)--}}
{{--                @if($users->lastPage()>=$i)--}}
{{--                    <a href="{{$users->url($i)}}"--}}
{{--                       class="w-8 h-8 rounded-sm  flex items-center justify-center font-bold shadow shadow-emerald-300 mt-5 @if($users->currentPage()==$i)selectPage @endif">--}}
{{--                        {{$i}}--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--            @endfor--}}
{{--        @endif--}}



{{--        --}}{{--        <a class="w-8 h-8 rounded-sm  flex items-center justify-center font-bold shadow shadow-emerald-300 selectPage">--}}
{{--        --}}{{--            3--}}
{{--        --}}{{--        </a>--}}


{{--        --}}{{--        <a class="w-8 h-8 rounded-sm  flex items-center justify-center font-bold shadow shadow-emerald-300">--}}
{{--        --}}{{--            12--}}
{{--        --}}{{--        </a>--}}
{{--        --}}{{--        <a class="w-8 h-8 rounded-sm  flex items-center justify-center font-bold shadow shadow-emerald-300 selectPage">--}}
{{--        --}}{{--            13--}}
{{--        --}}{{--        </a>--}}
{{--        --}}{{--        <a class="w-8 h-8 rounded-sm  flex items-center justify-center font-bold shadow shadow-emerald-300">--}}
{{--        --}}{{--           بعدی--}}
{{--        --}}{{--        </a>--}}
{{--    </section>--}}

@endsection
