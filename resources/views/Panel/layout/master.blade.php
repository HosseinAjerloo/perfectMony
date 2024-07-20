@include('Panel.layout.head')
<body class="font-yekan text-white  overflow-x-hidden  ">
@include('Panel.layout.header')
@yield('header-tag')
@include('Panel.layout.script')
<main class="bg-gray-950 w-full h-screen transition-all duration-700">
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
</body>

@include('Panel.layout.footer')

