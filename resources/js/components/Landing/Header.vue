<template>
    <div class="sub_header pl-lg-3 pr-lg-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="sub_header_left_content text-xl-right d-lg-flex align-items-center justify-content-xl-end">
                        <div class="sub_header_login_meta d-flex">
                            <div class="dropdown modal_btn header_meta text-uppercase mr-5">
                                <a class="dropdown-toggle text-white" href="#" data-toggle="dropdown">
                                    <i class="fa fa-user text-white"></i>
                                    Daftar
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                        <a :href="$baseUrl() + '/registrasi-konseling'">
                                            Daftar Warga
                                        </a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a :href="$baseUrl() + '/registrasi-mahasiswa'">
                                            Daftar Mahasiswa
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a :href="$baseUrl() + '/login'" class="modal_btn header_meta text-uppercase mr-5 align-self-center">
                                <i class="fa fa-sign-in-alt text-white"></i>
                                Masuk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header class="header_part classic_header position_abs border_style">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-xl justify-content-between align-items-center">
                        <div class="pu_logo_area">
                            <a class="navbar-brand main_logo" href="/">
                                <img :src="$assetUrl() + 'siapppak/images/logo-with-text.png'" alt="logo" style="width: 120px;">
                            </a>
                            <a class="navbar-brand sticky_logo" href="/">
                                <img :src="$assetUrl() + 'siapppak/images/logo-with-text.png'" alt="logo">
                            </a>
                        </div>
                        <div class="main_nav collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                            <app-navbar></app-navbar>
                            <div class="header_right_option">
                            </div>
                        </div>
                        <div class="header_right_btn">
                            <div class="header_right_option d-xl-none">
                                <div class="pu_collaps_menu_icon offcanvus_menu_trigger navbar-toggler collapsed mr-0" @click="showCanvus()">
                                    <div class="burger_icon">
                                        <span class="burger_icon_top"></span>
                                        <span class="burger_icon_bottom"></span>
                                    </div>
                                </div>
                            </div>
                            <router-link :to="{ name: 'konsultasi' }" class="header_btn d-xl-block d-none" style="font-weight: bold">
                                Telekonsultasi
                            </router-link>
                            <a href="https://dp3appkb.surabaya.go.id/sigas/" class="header_btn d-xl-block d-none" style="font-weight: bold">
                                Sigas
                            </a>
                            <div class="d-none d-md-block">
                                <div class="d-flex">
                                    <img :src="$assetUrl() + 'siapppak/images/logo-pemkot-new.png'" alt="Logo Pemkot SBY" style="width: 40px; margin-right: 10px;">
                                    <img :src="$assetUrl() + 'siapppak/images/logo/puspagasbynew.png'" alt="Logo puspaga" style="height: 50px;">
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    mounted() { },
    methods: {
        showCanvus() {
            $("body").addClass("active_off_canvus");
            $(".offcanvas_overlay").addClass("active_offcanvas_overlay");
        }
    }
};
</script>