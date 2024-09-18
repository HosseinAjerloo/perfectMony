@include('Email.layout.head')
<body class="font-yekan text-white  overflow-x-hidden bg-white">
@include('Email.layout.header')
@yield('header-tag')
<main class=" w-full h-screen transition-all duration-700">

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
@yield('footer')
</body>

@include('Email.layout.footer')

