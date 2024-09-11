<script src="{{asset('src/FontAwesome/js/all.js')}}"></script>
<script src="{{asset('src/vendor/jquery-3.7.1.min.js')}}"></script>

<script>
    $(document).ready(function () {
        let menuHamburger = $('.menuHamburger');
        let menu = $('#menu');
        srcClose = "{{asset('src/images/close.png')}}"
        Hamburger = "{{asset("src/images/hamburger.svg")}}"
        menuHamburger.click(function () {
            let img = $(this).children('img');
            if (($(menu).hasClass('menu-non-show'))) {
                $(menu).removeClass('menu-non-show')
                $(menu).addClass('menu-show')
                $(img).attr("src", srcClose)
                $('main').addClass('blur-sm');
            } else {
                $(menu).addClass('menu-non-show')
                $(menu).removeClass('menu-show')
                $(img).attr("src", Hamburger)
                $('main').removeClass('blur-sm');
            }


        })
    })


    $(document).ready(function () {
        let myProfile = $('.myProfile');
        let menuUser = $('#menu-user');
        myProfile.click(function () {
            if (($(menuUser).hasClass('menu-user-non-show'))) {
                $(menuUser).removeClass('menu-user-non-show')
                $(menuUser).addClass('menu-user-show')
                $('main').addClass('blur-sm');
            } else {
                $(menuUser).addClass('menu-user-non-show')
                $(menuUser).removeClass('menu-user-show')
                $('main').removeClass('blur-sm');
            }


        })
    })
</script>
