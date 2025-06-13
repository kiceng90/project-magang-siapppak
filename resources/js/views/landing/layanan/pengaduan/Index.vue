<template>
    <div>
        <div class="pu_site_page">
            <app-header></app-header>
    
            <section class="main-banner-v2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <img :src="$assetUrl() + 'siapppak/images/services/lapor-tindakan-kekerasan.png'" alt="Pelatihan"
                                class="main-header-rounded">
                                <h3 class="main-title-v2 title-float-shadow">PENGADUAN</h3>
                        </div>
                    </div>
                </div>
            </section>
    
            <section class="py-4" style="background:#E9E9E9;">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="container-rounded p-5 mb-3 text-center">
                                <h3 class="lapor-title" style="font-weight: bold;">PENGADUAN KEKERASAN KE UPTD PPA</h3>
                                <a href="tel:+628113345303" class="btn btn-lapor mt-1" style="background-color: #c81e4f;">
                                    Lapor Sekarang! Telepon
                                </a>
                                <a href="https://api.whatsapp.com/send/?phone=628113345303&type=phone_number&app_absent=0" target="_blank" class="btn btn-lapor mt-1" style="background-color: #c81e4f;">
                                    Lapor Sekarang! WhatsApp
                                </a>
                                <div class="mt-4">
                                    <p>
                                        Tersambung ke Hotline UPTD PPA. Terkait Permasalahan Perempuan Dan Anak Termasuk Tindak Kekerasan, Anak Berhadapan Hukum dan Trafficking.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="container-rounded p-5 mb-3 text-center">
                                <h3 class="lapor-title" style="font-weight: bold;">KONSULTASI PUSPAGA</h3>
                                <a href="https://api.whatsapp.com/send/?phone=6287722288959&type=phone_number&app_absent=0" target="_blank" class="btn btn-lapor mt-1" style="background-color: #c81e4f;">
                                    Konsultasi Sekarang WhatsApp</a>
                                <div class="mt-4">
                                    <p>
                                        Tersambung ke Hotline Puspaga. Terkait Konseling/Konsultasi Keluarga dan Kelas Calon Pengantin.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="container-rounded p-5 mb-3 text-center">
                                <h3 class="lapor-title" style="font-weight: bold;">PENGADUAN PELAYANAN</h3>
                                <a href="tel:+6281779939535" class="btn btn-lapor mt-1" style="background-color: #c81e4f;">Lapor Sekarang! Telepon</a>
                                <a href="https://api.whatsapp.com/send/?phone=6281779939535&type=phone_number&app_absent=0" target="_blank" class="btn btn-lapor mt-1" style="background-color: #c81e4f;">
                                    Lapor Sekarang! WhatsApp</a>
                                <div class="mt-4">
                                    <p>
                                        Tersambung ke Hotline Sekretariat DP3APPKB. Terkait Pengaduan Pelayanan.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="container-rounded p-5 mb-3 text-center">
                                <h3 class="lapor-title" style="font-weight: bold;">PENGADUAN KEKERASAN KE KELURAHAN</h3>
                                <a href="https://ppa-dp3appkb.surabaya.go.id/laporppa/pelaporan" target="_blank" class="btn btn-lapor mt-1" style="background-color: #c81e4f;">
                                    Lapor Sekarang!</a>
                                <div class="mt-4">
                                    <p>
                                        Lapor PPA. Pengaduan Kekerasan Tingkat Kelurahan yang akan ditangani oleh Satgas PPA Tingkat Kelurahan.
                                    </p>
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
    mounted() {

    }
};
</script>
