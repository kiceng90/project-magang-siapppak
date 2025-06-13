<template>
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                style="font-weight: bold; margin-left: 4px"
            >
                Tentang
            </a>
            <ul class="dropdown-menu blue_border_bottom">
                <li>
                    <router-link
                        :to="{ name: 'tentang-tentangkami' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Tentang Kami
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'tentang-userguide' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        User Guide
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'tentang-panduanvideo' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Panduan Video
                    </router-link>
                </li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                style="font-weight: bold; margin-left: 4px"
            >
                Layanan
            </a>
            <ul class="dropdown-menu blue_border_bottom">
                <li>
                    <router-link
                        :to="{ name: 'layanan-pengaduan' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Pengaduan
                    </router-link>
                </li>
                <li>
                    <a
                        class="dropdown-item"
                        href="https://ppa-dp3appkb.surabaya.go.id/laporppa/pelaporan/"
                        target="_blank"
                        @click="hideCanvus"
                    >
                        Lapor PPAK
                    </a>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'layanan-cekpengaduan' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Cek Pengaduan
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'konsultasi' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Telekonsultasi
                    </router-link>
                </li>
                <li>
                    <a class="dropdown-item"  @click="hideCanvus"
                        :href="$baseUrl() + '/login'">
                        E-Learning
                    </a>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'layanan-puspagakota' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Puspaga Kota
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'layanan-puspagarw' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Puspaga RW
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'layanan-uptdppa' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        UPTD PPA
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'layanan-kelascatin' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Seputar Kelas Calon Pengantin
                    </router-link>
                </li>
                <li class="dropdown-item text-white" @click="hideCanvus">
                    <a :href="$baseUrl() + '/pilihan'" class="text-white">
                        Buku Tamu
                    </a>
                </li>
                <li class="dropdown">
                    <a
                        class="dropdown-item dropdown-toggle"
                        href="#"
                        data-toggle="dropdown"
                    >
                        Data Publik
                    </a>
                    <ul class="dropdown-menu blue_border_bottom">
                        <li>
                            <router-link
                                :to="{ name: 'datapublik-mahasiswamsib' }"
                                class="dropdown-item"
                                @click="hideCanvus"
                            >
                                Mahasiswa Program MBKM & MSIB
                            </router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                style="font-weight: bold; margin-left: 4px"
            >
                Publikasi
            </a>
            <ul class="dropdown-menu blue_border_bottom">
                <li>
                    <router-link
                        :to="{ name: 'kie' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        KIE
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'artikel' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Artikel
                    </router-link>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                data-toggle="dropdown"
                style="font-weight: bold; margin-left: 4px"
            >
                Mitra
            </a>
            <ul class="dropdown-menu blue_border_bottom">
                <li
                    v-for="(kategorimitra, index) in kategorimitras"
                    :key="index"
                >
                    <router-link
                        :to="{
                            name: 'mitra',
                            params: { slug: kategorimitra.slug },
                        }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        {{ kategorimitra.name }}
                    </router-link>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                style="font-weight: bold; margin-left: 4px"
            >
                Links
            </a>
            <ul class="dropdown-menu blue_border_bottom">
                <li>
                    <a
                        class="dropdown-item"
                        href="https://sswalfa.surabaya.go.id/"
                        target="_blank"
                        @click="hideCanvus"
                    >
                        Surabaya Single Window
                    </a>
                </li>
                <li>
                    <a
                        class="dropdown-item"
                        href=" https://play.google.com/store/apps/details?id=com.surabaya.go.id.wargaku&hl=id&pli=1"
                        target="_blank"
                        @click="hideCanvus"
                    >
                        Aplikasi Wargaku
                    </a>
                </li>
                <li>
                    <a
                        class="dropdown-item"
                        href="https://ehealth.surabaya.go.id/"
                        target="_blank"
                        @click="hideCanvus"
                    >
                        E-Health
                    </a>
                </li>
                <li>
                    <a
                        class="dropdown-item"
                        href="https://bit.ly/ikmsiapppak"
                        target="_blank"
                        @click="hideCanvus"
                    >
                        Indeks Kepuasan Masyrakat
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                style="font-weight: bold; margin-left: 4px"
            >
                Puspaga TV
            </a>
            <ul class="dropdown-menu blue_border_bottom">
                <li>
                    <!-- <a class="dropdown-item" href="https://www.instagram.com/puspaga.sby/" target="_blank" @click="hideCanvus">
                        Live IG
                    </a> -->
                    <router-link
                        :to="{ name: 'puspagatv-instagram' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Live Instagram
                    </router-link>
                </li>
                <li>
                    <router-link
                        :to="{ name: 'puspagatv-youtube' }"
                        class="dropdown-item"
                        @click="hideCanvus"
                    >
                        Youtube
                    </router-link>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <router-link
                :to="{ name: 'kontak-kami' }"
                class="nav-link"
                style="font-weight: bold; margin-left: 4px"
                @click="hideCanvus"
            >
                Kontak
            </router-link>
        </li>
        <!-- <li class="nav-item">
        <a href="https://dp3appkb.surabaya.go.id/sigas/" class="nav-link" style="font-weight: bold; margin-left: 4px;" @click="hideCanvus">
                Sigas 
        </a>
        </li> -->
    </ul>
</template>

<script>
import Api from "@/services/api";

export default {
    data() {
        return {
            kategorimitras: [],
        };
    },
    mounted() {
        this.getKategoriMitra();
    },
    methods: {
        getKategoriMitra() {
            Api()
                .get(`public/m-kategori-mitra`)
                .then((response) => {
                    this.kategorimitras = response.data;
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        hideCanvus() {
            $("body").removeClass("active_off_canvus");
            $(".offcanvas_overlay").removeClass("active_offcanvas_overlay");
        },
    },
};
</script>
