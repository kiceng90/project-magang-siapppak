<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="title" content="" />
    <meta name="description" content="" />

    <title>SIAP PPAK (Sistem Informasi Pelayanan Perlindungan Perempuan dan Anak) DP3APPKB Pemerintah Kota Surabaya
    </title>

    <link rel="icon" href="{{ asset('assets/siapppak/images/logo-without-text-favicon.png') }}" type="image/png">

    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/siapppak/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/siapppak/vendors/themify_icons/themify-icons.css') }}" /> 
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />  
    <link rel="stylesheet" href="{{ asset('assets/siapppak/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/siapppak/vendors/swiper/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/siapppak/vendors/magnific-popup/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/siapppak/css/style.css') }}" />

    @if(config('env.app_env') == 'production')
        <link href="{{asset('assets/module/landing/production/css/app-landing.css')}}?v={{ filemtime(public_path('assets/module/landing/production/css/app-landing.css')) }}" rel="stylesheet" type="text/css" />
    @elseif(config('env.app_env') == 'demo')
        <link href="{{asset('assets/module/landing/demo/css/app-landing.css')}}?v={{ filemtime(public_path('assets/module/landing/demo/css/app-landing.css')) }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{asset('assets/module/landing/development/css/app-landing.css')}}?v={{ filemtime(public_path('assets/module/landing/development/css/app-landing.css')) }}" rel="stylesheet" type="text/css" />
    @endif

</head>

<body>
    <div id="landing">
        <main-app />
    </div>

    <script>
        var apiUrl = "{{ env('APP_URL') }}/api/";
        var baseUrl = "{{ env('APP_URL') }}";
        var assetUrl = "{{ asset('assets') }}/";
    </script>

    <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('assets/js/scripts.bundle.js')}}"></script>

    <script>
        function reinitializeAllPlugin() {
            $(".drawer-overlay").remove();
            setTimeout(() => {
                KTDialer.init();
                KTDrawer.init();
                KTImageInput.init();
                KTMenu.createInstances()
                KTPasswordMeter.init();
                KTScroll.init();
                KTScrolltop.init();
                KTSticky.init();
                KTSwapper.init();
                KTToggle.init();
                KTUtil.onDOMContentLoaded((function () {
                    KTApp.init()
                })), window.addEventListener("load", (function () {
                    KTApp.initPageLoader()
                })), "undefined" != typeof module && void 0 !== module.exports && (module.exports = KTApp);
                KTUtil.onDOMContentLoaded((function () {
                    KTLayoutAside.init()
                }));
                KTUtil.onDOMContentLoaded((function () {
                    KTLayoutSearch.init()
                }));
                KTUtil.onDOMContentLoaded((function () {
                    KTLayoutToolbar.init()
                }));
            }, 100);

            setTimeout(() => {
                $('body').attr('data-kt-drawer-aside', 'off');
                $('body').attr('data-kt-drawer', 'off');
                $('body').attr('data-kt-aside-minimize', 'off');
                $(".drawer-overlay").remove();
            }, 10);


            $("#kt_aside_mobile_toggle").on('click', function () {
                setTimeout(() => {
                    $('.drawer-overlay').each(function () {
                        let checkLength = $(".drawer-overlay").length;

                        if (checkLength > 1) {
                            $(this).remove();
                        }
                    });
                }, 10);
            });

            $('input[type="number"]').bind("paste", function (event) {
                var text = event.originalEvent.clipboardData.getData('Text');
                if ($.isNumeric(text)) {
                    return true;
                } else {
                    event.preventDefault();
                }
            });

            $('input[type="number"]').on("keyup keypress", function (event) {
                this.value = this.value.replace(/\D/g, '');
            });

        }

        function reinitializeKTMenuPlugin() {
            KTMenu.createInstances()
        }
    </script>

    <script src="{{ asset('assets/siapppak/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/siapppak/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/siapppak/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/siapppak/js/jquery.easing.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/siapppak/vendors/magnify_popup/jquery.magnific-popup.js') }}"></script> --}}
    <script src="{{ asset('assets/siapppak/vendors/swiper/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/siapppak/vendors/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/siapppak/js/slider.js') }}"></script>
    <script src="{{ asset('assets/siapppak/vendors/progressbar/progressbar.js') }}"></script>
    <script src="{{ asset('assets/siapppak/vendors/countdown/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/siapppak/vendors/countdown/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/siapppak/vendors/parallax/jquery.parallax-scroll.js') }}"></script>
    <script src="{{ asset('assets/siapppak/vendors/parallax/parallax_layer.js') }}"></script>
    <script src="{{ asset('assets/siapppak/vendors/headroom.js') }}"></script>
    <script src="{{ asset('assets/siapppak/js/custom.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/documentation/general/datatables/advanced.js') }}"></script>

    @if(config('env.app_env') == 'production')
        <script src="{{ asset('assets/module/landing/production/js/app-landing.js') }}?v={{ filemtime(public_path('assets/module/landing/production/js/app-landing.js')) }}"></script>
    @elseif(config('env.app_env') == 'demo')
        <script src="{{ asset('assets/module/landing/demo/js/app-landing.js') }}?v={{ filemtime(public_path('assets/module/landing/demo/js/app-landing.js')) }}"></script>
    @else
        <script src="{{ asset('assets/module/landing/development/js/app-landing.js') }}?v={{ filemtime(public_path('assets/module/landing/development/js/app-landing.js')) }}"></script>
    @endif
</body>

</html>
