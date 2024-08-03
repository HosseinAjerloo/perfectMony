@extends('Panel.layout.master')

@section('message-box')
    <div class="flex items-center justify-center flex-col space-y-3">
        <img src="{{asset('src/images/Group 414.png')}}" alt="" class="w-14 h-14">
        <div class="space-x-3 space-x-reverse">
            <p class="text-sm text-center sm:text-base">خرید با موفقیت انجام شد</p>
        </div>
    </div>
@endsection

@section('container')
    <section class="px-2 py-6">
        <article
            class="flex flex-col justify-between  border-2 border-white rounded-md   p-5  sm:w-4/6 md:w-3/6 lg:w-2/6 xl:w-1/4 mx-auto space-y-3">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold sm:text-base">
                    شماره ووچر:
                </p>
                <div class=" relative">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <span class="text-sm sm:text-base">{{$voucher->serial}}</span>
                        <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                    </div>

                </div>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold sm:text-base">
                    کد فعال سازی:
                </p>
                <div class="flex items-center space-x-3 space-x-reverse">
                    <span class="text-sm sm:text-base">{{$voucher->code}}</span>
                    <img src="{{asset('src/images/Group 422.png')}}" alt="" class="w-6 h-6 mt-1 copy cursor-pointer transition-all hover:scale-150">
                </div>
            </div>
            <div class="flex items-center space-x-2 space-x-reverse">
                <p class="text-sm font-semibold sm:text-base">
                    مبلغ ووچر:
                </p>
                <div class="flex items-center space-x-1 space-x-reverse pe-2">
                    <span class="text-sm sm:text-base">{{$payment_amount}} دلار</span>
                    <i class="fas fa-dollar-sign text-sky-500 text-lg"></i>
                </div>
            </div>

        </article>
    </section>
@endsection
@section('script-tag')

    <script>

        function copyToClipboard(text) {

            var textArea = document.createElement( "textarea" );
            textArea.value = text;
            document.body.appendChild( textArea );
            textArea.select();

            try {
                var successful = document.execCommand( 'copy' );
                var msg = successful ? 'successful' : 'unsuccessful';
                console.log('Copying text command was ' + msg);
            } catch (err) {
                console.log('Oops, unable to copy',err);
            }
            document.body.removeChild( textArea );
        }

        $( '.copy' ).click( function()
        {
            let spanText=$(this).siblings('span').text();
            copyToClipboard( spanText);
        });
    </script>
@endsection
