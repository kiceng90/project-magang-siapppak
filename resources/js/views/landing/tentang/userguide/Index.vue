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
                                            User Guide
                                        </h1>
                                        <div class="description">
                                            <p>
                                                SIAP PPAK (Sistem Informasi Pelayanan Perlindungan Perempuan dan Anak) adalah sistem aplikasi terintegrasi berbasis web yang dibangun oleh Dinas Pemberdayaan Perempuan dan Perlindungan Anak Serta Pengendalian Penduduk dan Keluarga Berencana (DP3APPKB) Pemerintah Kota Surabaya. 
                                                Sistem ini memiliki beberapa fitur utama seperti Telekonsultasi, Panic Button Pengaduan, KIE, dan lain lain. SIAP PPAK dirancang untuk menjadi solusi terintegrasi dalam perlindungan perempuan dan anak, serta berfungsi sebagai alat yang dapat diakses oleh seluruh warga Kota Surabaya. Sistem ini memfasilitasi pelaporan masalah, konsultasi psikologi, dan penyediaan informasi yang bermanfaat dalam upaya perlindungan.                                           </p>
                                            <p>
                                            Dokumen ini bertujuan untuk memberikan panduan kepada pengguna SIAP PPAK agar masyarakat dapat menggunakan sistem ini secara efektif. 
                                            Ini mencakup panduan mulai dari pengentryan database oleh perangkat daerah, kecamatan dan kelurahan hingga penggunaan fitur-fitur utama seperti konsultasi dan pengaduan.
                                            </p>
                                            <p>
                                                Panduan :
                                            </p>
                                            <ul>
                                                <li>
                                                    Panduan Melakukan Entry Database Tim PKBM dan Tim Puspaga RW oleh Kecamatan dapat dilihat <a href="https://drive.google.com/file/d/1-W-Oc1mQn2C36cED_MZW-eHaXG3gK3H5/view?usp=sharing"><strong>disini</strong></a>
                                                </li>
                                                <li>
                                                    Panduan Melakukan Entry Database Tim Satgas PPA oleh Kelurahan dapat dilihat <a href="https://drive.google.com/file/d/11r3IaWBIuuJJomMgKNSJMAtqNNQTO2BZ/view?usp=sharing"><strong>disini</strong></a>
                                                </li>
                                                <li>
                                                    Panduan Melakukan Entry hasil intervensi oleh Perangkat Daerah dapat dilihat <a href="https://drive.google.com/file/d/1xH1LLyDQNu3qAbbmjxkM_RrhkQuRwhV7/view?usp=sharing"><strong>disini</strong></a>
                                                </li>
                                                <li>
                                                    Panduan Melakukan telekonsultasi online oleh Warga/Masyarakat dapat dilihat <a href="https://drive.google.com/file/d/1mJkCRDuzQOwdSM3w5EIKIvhbkgthTyDo/view?usp=sharing"><strong>disini</strong></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <iframe :src="$assetUrl() + 'siapppak/images/pdf/UserGuideSIAPPPAK.pdf'" frameborder="0" type="application/pdf" width="720" height="1080"></iframe>
                                        <br>
                                        <br>
                                        <div class="image">
                                            <div class="mx-5">
                                                <img :src="$assetUrl() + 'siapppak/images/img-logo-dp3appkb-black.png'" style="height: 100px;">
                                            </div>
                                            <div class="mx-5">
                                                <img :src="$assetUrl() + 'siapppak/images/img-logo-siapppak.png'" style="height: 100px;">
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