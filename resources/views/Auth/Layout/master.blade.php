@include('Auth.Layout.heade')
<body class="font-yekan bg-gray-950 text-white">
@include('Auth.Layout.header')
@yield('header-tag')
@include('Auth.Layout.script')

<main>
    @include('Alert.Toast.warning')
    <section class="py-5 px-3 flex justify-center items-center container md:mx-auto">

        @yield('message-box')

    </section>
    <section class="container md:mx-auto">
        @yield('action')

    </section>

    <section class="py-5 px-3 flex justify-center flex-col items-center container md:mx-auto  ">
    @yield('container')

    </section>

</main>
</body>
@include('Auth.Layout.footer')
@yield('script-tag')
