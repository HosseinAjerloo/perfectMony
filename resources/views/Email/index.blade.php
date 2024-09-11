@extends('Email.layout.master')


@section('message-box')
    <link rel="preload" as="style" href="{{$message->embed(public_path('build/assets/app-DfXRdrCz.css'))}}">
    <link rel="stylesheet" href="{{$message->embed(public_path('build/assets/app-DfXRdrCz.css'))}}">

    <section class="py-5 px-3 flex justify-center items-center container md:mx-auto">
        <x-email-failed :type="'message-box'"/>

    </section>

@endsection

@section('container')

    <section class="container md:mx-auto">
        <x-email-failed :type="'container'"/>
    </section>
@endsection


@section('footer')

    <article class="bg-sky-500 p-4 flex items-center justify-around">
        <div class="flex items-center justify-center space-x-1 space-x-reverse">
            <p>
                086-33805
            </p>
            <img src="{{$message->embed(public_path('src/images/phone.png'))}}" alt="" class="w-4 h-4 mt-2">
        </div>
        <div class="flex items-center justify-center space-x-1 space-x-reverse">
            <p>
                www.sainaex.ir
            </p>
            <img src="{{$message->embed(public_path('src/images/network.svg'))}}" alt="">
        </div>
    </article>


@endsection










