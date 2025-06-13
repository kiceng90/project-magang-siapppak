<template>
    <div>
        <div class="pu_site_page">
            <app-header></app-header>

            <section class="main-banner-v2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-container" data-loop="true" data-autoplay="true" data-speed="1000" data-space="0"
                                data-next=".swiper-button-next" data-prev=".swiper-button-prev">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <a href="">
                                            <img :src="$assetUrl() + 'siapppak/images/slider/4.png'" alt="Selamat Datang" class="main-header-rounded" style="border-radius: 30px;">
                                            <h4 class="main-title-v2 title-float-shadow title-homepage"></h4>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="">
                                            <img :src="$assetUrl() + 'siapppak/images/slider/6.jpg'" alt="Hari Anak Nasional 2024" class="main-header-rounded" style="border-radius: 30px;">
                                            <h4 class="main-title-v2 title-float-shadow title-homepage"></h4>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="">
                                            <img :src="$assetUrl() + 'siapppak/images/slider/5.jpg'" alt="Penghargaan Puspaga Semanggi" class="main-header-rounded" style="border-radius: 30px;">
                                            <h4 class="main-title-v2 title-float-shadow title-homepage"></h4>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="">
                                            <img :src="$assetUrl() + 'siapppak/images/slider/17.png'" alt="Penghargaan Inovboyo Puspaga" class="main-header-rounded" style="border-radius: 30px;">
                                            <h4 class="main-title-v2 title-float-shadow title-homepage"></h4>
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="">
                                            <img :src="$assetUrl() + 'siapppak/images/slider/16.png'" alt="Penghargaan Puspaga Semanggi" class="main-header-rounded" style="border-radius: 30px;">
                                            <h4 class="main-title-v2 title-float-shadow title-homepage"></h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </section>
    
            <section class="homepage-control mt-4">
                <div class="container">
                    <div class="row text-center justify-content-center align-items-center">
                        <div class="col-md-2 mb-3">
                            <router-link :to="{ name: 'layanan-pengaduan' }" class="dropdown-item">
                                <img :src="$assetUrl() + 'siapppak/images/icon/iconpengaduan.png'">
                                <h5 class="mt-2 fw-bolder text-uppercase">
                                    Pengaduan
                                </h5>
                            </router-link>
                        </div>
                        <div class="col-md-2 mb-3">
                            <router-link :to="{ name: 'konsultasi' }" class="dropdown-item">
                                <img :src="$assetUrl() + 'siapppak/images/icon/iconkonseling.png'">
                                <h5 class="mt-2 fw-bolder text-uppercase">
                                    Telekonsultasi              
                                </h5>
                            </router-link>
                        </div>
                        <div class="col-md-2 mb-3">
                            <router-link :to="{ name: 'layanan-puspagakota' }" class="dropdown-item">
                                <img :src="$assetUrl() + 'siapppak/images/icon/iconpuspaga.png'">
                                <h5 class="mt-2 fw-bolder text-uppercase">
                                    Puspaga Kota
                                </h5>
                            </router-link>
                        </div>
                        <div class="col-md-2 mb-3">
                            <router-link :to="{ name: 'layanan-puspagarw' }" class="dropdown-item">
                                <img :src="$assetUrl() + 'siapppak/images/icon/kegiatan2.png'">
                                <h5 class="mt-2 fw-bolder text-uppercase">
                                    Puspaga RW
                                </h5>
                            </router-link>
                        </div>
                        <div class="col-md-2 mb-3">
                            <router-link :to="{ name: 'layanan-uptdppa' }" class="dropdown-item">
                                <img :src="$assetUrl() + 'siapppak/images/icon/pelatihan2.png'">
                                <h5 class="mt-2 fw-bolder text-uppercase">
                                    UPTD PPA
                                </h5>
                            </router-link>
                        </div>
                        <div class="col-md-2 mb-3 dropdown-item">
                            <a :href="$baseUrl() + '/login'">
                                <img :src="$assetUrl() + 'siapppak/images/icon/iconelearning.png'">
                                <h5 class="mt-2 fw-bolder text-uppercase">
                                    E-Learning
                                </h5>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
    
            <section class="homepage-grey mt-4 pt-4 pb-4">
                <div class="content-section">
                <!-- KIE Section -->
                <section class="kie-section mb-5">
                    <div class="container">
                    <h2 class="section-title text-center">Komunikasi, Informasi, dan Edukasi (KIE)</h2>
                    <div class="row">
                        <div
                        class="col-md-3 kie-card"
                        v-for="(kie, index) in kies"
                        :key="index"
                        >
                        <div class="card shadow-sm">
                            <div class="kie-thumbnail">
                            <img :src="kie.file_thumbnail" :alt="kie.title" />
                            </div>
                            <div class="card-body text-center">
                            <h5 class="card-title text-truncate">{{ kie.title }}</h5>
                            <span class="badge bg-info text-dark">{{ kie.type_string }}</span>
                            <div class="mt-2">
                                <a v-if="kieTypeEnum[kie.type] === 'Gambar'" :href="kie.file_image" download class="btn btn-outline-primary btn-sm">Download Gambar</a>
                                <a v-else-if="kieTypeEnum[kie.type] === 'PDF'" :href="kie.file_pdf" download class="btn btn-outline-primary btn-sm">Download PDF</a>
                                <a v-else-if="kieTypeEnum[kie.type] === 'Video'" :href="kie.url_video_youtube" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Video</a>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </section>

                <!-- Articles Section -->
                <section class="articles-section">
                    <div class="container">
                        <h2 class="section-title text-center">Artikel Perlindungan Perempuan dan Anak</h2>
                        <div class="row justify-content-center">
                        <div
                            class="col-lg-3 col-md-4 col-sm-6 article-card"
                            v-for="(article, index) in articles"
                            :key="index"
                        >
                            <div class="card shadow-sm h-100 article-card-hover">
                            <div class="article-thumbnail">
                                <img :src="article.file_thumbnail" :alt="article.title" />
                            </div>
                            <div class="card-body text-center d-flex flex-column">
                                <h6 class="card-title text-truncate">{{ article.title }}</h6>
                                <p class="text-muted small">{{ formatDate(article.created_at) }}</p>
                                <div class="mt-auto">
                                <router-link
                                    :to="{ name: 'artikel-detail', params: { id: article.id } }"
                                    class="btn btn-outline-primary btn-sm"
                                >
                                    <i class="bi bi-book"></i> Baca Selengkapnya
                                </router-link>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="text-center mt-4">
                        <router-link
                            :to="{ name: 'artikel' }"
                            class="btn btn-primary btn-lg rounded-pill px-4 py-2"
                        >
                            <i class="bi bi-card-list"></i> Lihat Semua Artikel
                        </router-link>
                        </div>
                    </div>
                </section>
                </div>
            </section>
    
            <app-footer></app-footer>
    
        </div>

        <app-popupsearch></app-popupsearch>
        
        <app-mobilemenu></app-mobilemenu>
    </div>
</template>

<script>
import Api from "@/services/api"
const GAMBAR = 1;
const VIDEO = 2;
const PDF = 3;

export default {
    data() {
        return {
            kies: [],
            kieTypeEnum: {
                [GAMBAR]: 'Gambar',
                [VIDEO]: 'Video',
                [PDF]: 'PDF',
            },
            articles: [],
        }

    },
    mounted() {
        this.getData()
        this.getArtikel()
        this.getKieJenisEnum()
    },
    methods: {
        getData() {
            Api().get(`public/recentkie`)
                .then(response => {
                    this.kies = response.data
                })
                .catch(error => {
                    this.kies = []
                    this.$axiosHandleError(error)
                });
        },
        getKieJenisEnum() {
            Api().get(`public/kie-jenis-enum`)
                .then(response => {
                    const baseEnum = response.data;
                    this.kieTypeEnum = {
                        [baseEnum.GAMBAR.value]: baseEnum.GAMBAR.label,
                        [baseEnum.VIDEO.value]: baseEnum.VIDEO.label,
                        [baseEnum.PDF.value]: baseEnum.PDF.label,
                    }
                })
                .catch(error => {
                    this.$axiosHandleError(error)
                });
        },
        getArtikel() {
            Api().get(`public/recentartikel`)
                .then(response => {
                    this.articles = response.data
                })
                .catch(error => {
                    this.articles = []
                    this.$axiosHandleError(error)
                });
        },
        formatDate(date) {
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(date).toLocaleDateString("id-ID", options);
        },

    }
};
</script>

<style scoped>

.truncate{
  overflow:hidden;
  -webkit-box-orient: vertical;
  display: block;
  display: -webkit-box;
  overflow: hidden !important;
  text-overflow: ellipsis;
  -webkit-line-clamp: 1;
}

.truncate-2{
  -webkit-line-clamp: 2;
}

.article-card {
  margin-bottom: 1.5rem;
}

.article-card-hover {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 15px;
}

.article-card-hover:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.article-thumbnail img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 15px 15px 0 0;
}

.card-body {
  padding: 1rem;
}

.card-title {
  font-size: 1rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
  color: #343a40;
}

.text-muted {
  font-size: 0.8rem;
  color: #6c757d;
}

.btn {
  transition: all 0.3s ease-in-out;
}

.btn:hover {
  transform: scale(1.05);
}

.btn-outline-primary {
  color: #007bff;
  border-color: #007bff;
}

.btn-outline-primary:hover {
  background-color: #007bff;
  color: white;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  color: white;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.section-title {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 2rem;
  color: #333;
}

/* General Styling */
.section-title {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 2rem;
  color: #343a40;
}

.card {
  border: none;
  border-radius: 15px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

/* KIE Section */
.kie-card {
  margin-bottom: 1.5rem;
}

.kie-thumbnail img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 15px 15px 0 0;
}

/* Articles Section */
.featured-article {
  border: none;
  overflow: hidden;
  border-radius: 15px;
}

.featured-thumbnail img {
  object-fit: cover;
  width: 100%;
  height: 250px;
}

.article-thumbnail img {
  object-fit: cover;
  width: 100%;
  height: 180px;
}

.article-card {
  margin-bottom: 1.5rem;
}

.btn {
  transition: all 0.3s ease-in-out;
}

.btn:hover {
  transform: scale(1.05);
}

.btn-danger {
  background-color: #d81b60;
  border-color: #d81b60;
}

.btn-outline-danger {
  color: #d81b60;
  border-color: #d81b60;
}

.btn-outline-danger:hover {
  background-color: #d81b60;
  color: white;
}
</style>
