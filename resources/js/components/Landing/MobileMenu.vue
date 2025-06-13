<template>
    <div>
        <div class="off_canvus_menu">
            <div class="off_canvus_menu_iner">
                <div class="off_canvus_menu_iner_logo">
                    <a href="#" class="off_canvus_logo"> <img :src="$assetUrl() + 'siapppak/images/logo-with-text.png'" style="width: 100px;" alt="#"> </a>
                    <div class="popup-close-button close_icon" @click="hideCanvus()">
                        <div class="burger-icon">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                </div>
                <div class="off_canvus_menu_iner_content">
                    <nav class="navbar">
                        <app-navbar></app-navbar>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link :to="{ name: 'konsultasi' }" class="nav-link" style="font-weight: bold;" @click="hideCanvus">Telekonsultasi</router-link>
                        </li>
                    </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="offcanvas_overlay"></div>
    </div>
</template>

<script>
export default {
    mounted() { },
    methods: {
        hideCanvus() {
            $("body").removeClass("active_off_canvus");
            $(".offcanvas_overlay").removeClass("active_offcanvas_overlay");
        }
    }
};
</script>