<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIAP PPAK (Sistem Informasi Pelayanan Perlindungan Perempuan dan Anak) DP3APPKB Pemerintah Kota Surabaya
    </title>

    <link rel="icon" href="{{ asset('assets/siapppak/images/logo-without-text-favicon.png') }}" type="image/png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/extends/css/ewp.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/extends/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"
        integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    @if (config('env.app_env') == 'production')
        <link
            href="{{ asset('assets/module/dashboard/production/css/app-dashboard.css') }}?v={{ filemtime(public_path('assets/module/dashboard/production/css/app-dashboard.css')) }}"
            rel="stylesheet" type="text/css" />
    @elseif(config('env.app_env') == 'demo')
        <link
            href="{{ asset('assets/module/dashboard/demo/css/app-dashboard.css') }}?v={{ filemtime(public_path('assets/module/dashboard/demo/css/app-dashboard.css')) }}"
            rel="stylesheet" type="text/css" />
    @else
        <link
            href="{{ asset('assets/module/dashboard/development/css/app-dashboard.css') }}?v={{ filemtime(public_path('assets/module/dashboard/development/css/app-dashboard.css')) }}"
            rel="stylesheet" type="text/css" />
    @endif
</head>

<script>
    var apiUrl = "{{ env('APP_URL') }}/api/";
    var baseUrl = "{{ env('APP_URL') }}";
    var assetUrl = "{{ asset('assets') }}/";
</script>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

    <div id="dashboard">
        <main-app />
    </div>

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

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
                KTUtil.onDOMContentLoaded((function() {
                    KTApp.init()
                })), window.addEventListener("load", (function() {
                    KTApp.initPageLoader()
                })), "undefined" != typeof module && void 0 !== module.exports && (module.exports = KTApp);
                KTUtil.onDOMContentLoaded((function() {
                    KTLayoutAside.init()
                }));
                KTUtil.onDOMContentLoaded((function() {
                    KTLayoutSearch.init()
                }));
                KTUtil.onDOMContentLoaded((function() {
                    KTLayoutToolbar.init()
                }));
            }, 100);

            setTimeout(() => {
                $('body').attr('data-kt-drawer-aside', 'off');
                $('body').attr('data-kt-drawer', 'off');
                $('body').attr('data-kt-aside-minimize', 'off');
                $(".drawer-overlay").remove();
            }, 10);


            $("#kt_aside_mobile_toggle").on('click', function() {
                setTimeout(() => {
                    $('.drawer-overlay').each(function() {
                        let checkLength = $(".drawer-overlay").length;

                        if (checkLength > 1) {
                            $(this).remove();
                        }
                    });
                }, 10);
            });

            $('input[type="number"]').bind("paste", function(event) {
                var text = event.originalEvent.clipboardData.getData('Text');
                if ($.isNumeric(text)) {
                    return true;
                } else {
                    event.preventDefault();
                }
            });

            $('input[type="number"]').on("keyup keypress", function(event) {
                this.value = this.value.replace(/\D/g, '');
            });

        }

        function reinitializeKTMenuPlugin() {
            KTMenu.createInstances()
        }
    </script>

    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/documentation/general/datatables/advanced.js') }}"></script>
    <script src="{{ asset('assets/extends/js/custom.js') }}"></script>
    <script src="{{ asset('assets/extends/js/ewp.js') }}"></script>
    <script src="{{ asset('assets/extends/js/pico.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
        integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if (config('env.app_env') == 'production')
        <script
            src="{{ asset('assets/module/dashboard/production/js/app-dashboard.js') }}?v={{ filemtime(public_path('assets/module/dashboard/production/js/app-dashboard.js')) }}">
        </script>
    @elseif(config('env.app_env') == 'demo')
        <script
            src="{{ asset('assets/module/dashboard/demo/js/app-dashboard.js') }}?v={{ filemtime(public_path('assets/module/dashboard/demo/js/app-dashboard.js')) }}">
        </script>
    @else
        <script
            src="{{ asset('assets/module/dashboard/development/js/app-dashboard.js') }}?v={{ filemtime(public_path('assets/module/dashboard/development/js/app-dashboard.js')) }}">
        </script>
    @endif
</body>

</html>
