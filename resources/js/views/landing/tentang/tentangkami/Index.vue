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
                                            Tentang Kami
                                        </h1>
                                        <div class="description">
                                            <p>
                                                SIAP PPAK merupakan singkatan dari Sistem Informasi Pelayanan Perlindungan Perempuan Dan Anak (SIAP PPAK!) merupakan suatu sistem aplikasi terintegrasi berbasis website yang dibangun oleh Dinas Pemberdayaan Perempuan dan Perlindungan Anak Serta Pengendalian Penduduk dan Keluarga Berencana atau DP3APPKB Pemerintah Kota Surabaya. Sistem aplikasi ini terhubung dengan SSW Alfa, E Health dan Aplikasi Wargaku dan bisa diakses oleh seluruh warga kota Surabaya. 
                                                Sistem Informasi Pelayanan Perlindungan Perempuan Dan Anak (SIAP PPAK!) dapat diakses di <a href="https://ppa-dp3appkb.surabaya.go.id/"><strong>ppa-dp3appkb.surabaya.go.id</strong></a> sebagai aplikasi yang holistik integratif dalam Perlindungan Perempuan dan Anak dalam pelayanan ke masyarakat. Mulai dari Tombol Panic Button untuk Pengaduan Permasalahan kekerasan Perempuan dan Anak yang terhubung ke UPTD PPA, Tombol panic Button apabila warga masyarakat mempunyai permasalahan psikologi dalam keluarga, telekonsultasi psikologi gratis dengan para konselor psikolog dan psikolog volunteer puspaga, sebagai akses pembelajaran psikologis untuk diri sendiri dan keluarga dengan menu Komunikasi Informasi Edukasi, informasi seputar pendaftaran dan pelaksanaan kelas Calon Pengantin, Siapa saja Mitra dan jejaring UPTD PPA dan Puspaga, juga ada Puspaga TV yang memuat video-video edukasi terkait permasalahan keluarga, dan kekerasan terhadap perempuan dan anak, dan ketuntasan intervensi lintas OPD Pemerintah Kota Surabaya dalam penanganan permasalahan kekerasan terhadap perempuan dan anak serta permasalahan sosial lainnya seperti korban bencana alam, kebakaran, ngamen, sulak2, tawuran, balap liar dan lain sebagainya
                                                Di Dalamnya juga dilengkapi dengan database mahasiswa yang membantu pelaksanaan Puspaga Balai RW, Relawan Pusat Krisis Berbasis Masyarakat (PKBM) Kecamatan, Satgas Perlindungan Perempuan dan Anak Kelurahan serta Database Fasilitator Puspaga Balai RW dan SK Puspaga Balai RW.                                            </p>
                                            <p>
                                                Tujuan :
                                            </p>
                                            <ul>
                                                <li>
                                                    Mewujudkan sinergitas dan integrasi data penanganan permasalahan perempuan dan anak.
                                                </li>
                                                <li>
                                                    Menyajikan informasi dan data permasalahan perempuan dan anak khususnya korban kekerasan termasuk Anak Berhadapan Hukum dan korban trafficking.
                                                </li>
                                                <li>
                                                    Menyajikan informasi dan data Tim PKBM, Tim Satgas PPA, Tim Puspaga RW yang tersebar di seluruh Kota Surabaya.
                                                </li>
                                                <li>
                                                    Menyajikan informasi terkait hasil penanganan Pemerintah Kota Surabaya terhadap permasalahan perempuan dan anak khususnya korban kekerasan termasuk Anak Berhadapan Hukum dan korban trafficking.
                                                </li>
                                                <li>
                                                    Meningkatkan Komunikasi, Informasi dan Edukasi (KIE) dalam pencegahan dan penanganan kekerasan terhadap perempuan dan anak.
                                                </li>
                                            </ul>
                                        </div>
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