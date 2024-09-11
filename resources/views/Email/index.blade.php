@vite('resources/css/app.css')
<style>
    body{
        background-color: red!important;
    }
</style>
@extends('Email.layout.master')

@section('message-box')
    <x-email-failed :type="'message-box'"/>
@endsection

@section('container')
    <x-email-failed :type="'container'"/>
@endsection

@section('footer')
    <article class="bg-sky-500 p-4 flex items-center justify-around">
        <div class="flex items-center justify-center space-x-1 space-x-reverse">
            <p>
                086-33805
            </p>
            <img src="{{asset('src/images/phone.png')}}" alt="" class="w-4 h-4 mt-2">
        </div>
        <div class="flex items-center justify-center space-x-1 space-x-reverse">
            <p>
                www.sainaex.ir
            </p>
            <img src="{{asset('src/images/network.svg')}}" alt="">
        </div>
    </article>

@endsection
