@include('Email.layout.head')
<body class="font-yekan text-white  overflow-x-hidden bg-white ">
@include('Email.layout.header')
@yield('header-tag')
@include('Email.layout.script')
<main class=" w-full transition-all duration-700">
    @include('Alert.Toast.warning')
    @include('Alert.Toast.success')
    <section class="py-5 px-3 flex justify-center items-center container md:mx-auto">
        @yield('message-box')

    </section>
    <section class="container md:mx-auto">
        @yield('container')
    </section>

    <section class="py-5 px-3 flex justify-center flex-col items-center container md:mx-auto  ">

            @yield('content')
    </section>

</main>
@yield('script-tag')
@yield('footer')
</body>
@include('Email.layout.footer')



