<template>
    <div>
        <div class="pu_site_page">
            <app-header></app-header>

            <section class="pu_beadcrumb_part" data-bg-img="/img/fotokegiatan/famili2.jpg" :style="`background: url(${$assetUrl()}siapppak/images/fotokegiatan/famili2.jpg) center center / cover no-repeat;`">
                <div class="container custom_container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pu_breadcrumb_inner_content"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pu_causes_details_part padding_bottom">
                <div class="container custom_container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="">
                                <div class="causes_details_inner">
                                    <div class="pu_causes_details_content" style="padding: 20px;">
                                        <h1 class="title fw-bold text-center">
                                            Panduan Video
                                        </h1>
                                        <h2 style="font-size: 24px; font-weight: bold;">1. Panduan Pemanfaatan Fitur SIAP PPAK.</h2>
                                        <div class="carousel-inner" width="100%" height="525">
                                        <br>
                                        <div class="carousel-item active">
                                            <iframe width="100%" height="525" src="https://www.youtube.com/embed/qzp_ayLBwEg?si=XIXSE7Lz_u5Ip8FJ" allow="autoplay" title="PUSPAGA SURABAYA TAHUN 2022 II DP3APPKB SURABAYA" frameborder="0"></iframe>
                                        </div>
                                        </div>                                        
                                        <br>
                                        <br>
                                        <h2 style="font-size: 24px; font-weight: bold;">2. Panduan Telekonsultasi SIAP PPAK.</h2>
                                        <div class="carousel-inner" width="100%" height="525">
                                        <br>
                                        <div class="carousel-item active">
                                            <iframe width="100%" height="525" src="https://www.youtube.com/embed/xGInk9nktT4?si=eGM7rZzzN26BzdQ5" allow="autoplay" title="PUSPAGA SURABAYA TAHUN 2022 II DP3APPKB SURABAYA" frameborder="0"></iframe>
                                        </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    
            <app-footer></app-footer>
    
        </div>

        <app-popupsearch></app-popupsearch>
        
        <app-mobilemenu></app-mobilemenu>
    </div>
</template>

<script>
export default {
    mounted() { }
};
</script>