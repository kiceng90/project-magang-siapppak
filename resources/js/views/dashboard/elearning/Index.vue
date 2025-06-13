<template>
    <div>
        <audio
            ref="backgroundMusic"
            src="/assets/siapppak/music/songpride.mp3"
            autoplay
            loop
        ></audio>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div
                    class="wrapper d-flex flex-column flex-row-fluid"
                    id="kt_wrapper"
                >
                    <app-navbar></app-navbar>

                    <div id="main-content">
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <div
                                id="kt_content_container"
                                class="container-xxl"
                            >
                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    id="kt_profile_details_view"
                                >
                                    <div class="card card-xl-stretch">
                                        <div class="hero">
                                            <video
                                                src="/assets/siapppak/video/hero.mp4"
                                                autoplay
                                                loop
                                                muted
                                                oncontextmenu="return false;"
                                                class="hero-video"
                                            ></video>
                                        </div>
                                        <div
                                            class="card-body pt-1"
                                            id="start-content"
                                        >
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <img
                                                        src="/assets/siapppak/img/logo-elearning.png"
                                                        alt="Logo E-Learning"
                                                        class="logo-img"
                                                    />
                                                </div>
                                                <div class="col-md-7">
                                                    <h3>
                                                        Kenali E-Learning
                                                        Puspaga lebih dekat
                                                    </h3>
                                                    <p class="salam-pembuka">
                                                        E-Learning Puspaga
                                                        adalah platform
                                                        pembelajaran online
                                                        dengan metode Learning
                                                        Management System (LMS)
                                                        yang fokus pada
                                                        Perlindungan Perempuan
                                                        dan Anak, Pemberdayaan
                                                        Perempuan serta
                                                        Pemenuhan Hak Anak. Di
                                                        sini, kamu bisa belajar
                                                        tentang pengasuhan
                                                        positif, hak anak,
                                                        OCSEA, Ketahanan
                                                        Keluarga, dan Manajemen
                                                        Kasus dalam Perlindungan
                                                        Perempuan dan Anak serta
                                                        banyak materi menarik
                                                        lainnya yang pastinya
                                                        bermanfaat dalam
                                                        pencegeahan dan
                                                        perlindungan pada
                                                        kekerasan pada perempuan
                                                        dan anak. Dengan
                                                        E-Learning Puspaga, kamu
                                                        dapat meningkatkan
                                                        pemahaman dan
                                                        keterlibatan dalam
                                                        menciptakan lingkungan
                                                        yang aman, ramah, dan
                                                        mendukung bagi perempuan
                                                        dan anak-anak.
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row mt-5 px-5">
                                                <div
                                                    class="header-title mb-5 text-center"
                                                >
                                                    <h1>
                                                        Kategori Pembelajaran
                                                    </h1>
                                                    <p class="ajakan">
                                                        Yuk, ikuti kategori
                                                        pembelajaran berikut
                                                        agar bisa mendapatkan
                                                        sertifikat lebih lanjut.
                                                    </p>
                                                </div>
                                                <div
                                                    class="col-md-3"
                                                    v-for="(
                                                        card, index
                                                    ) in cards"
                                                    :key="index"
                                                >
                                                    <div
                                                        class="text-decoration-none"
                                                        :class="{
                                                            'disabled-card':
                                                                card.disabled,
                                                        }"
                                                        :style="{
                                                            'pointer-events':
                                                                card.disabled
                                                                    ? 'none'
                                                                    : 'auto',
                                                            cursor: !card.disabled
                                                                ? 'pointer'
                                                                : 'default',
                                                        }"
                                                        @click="
                                                            !card.disabled &&
                                                                navigateToCategory(
                                                                    card.id
                                                                )
                                                        "
                                                    >
                                                        <div
                                                            class="card card-class shadow-sm"
                                                        >
                                                            <img
                                                                :src="
                                                                    getImageUrl(
                                                                        card.image
                                                                    )
                                                                "
                                                                class="card-img-top"
                                                                alt="Category Image"
                                                                v-if="
                                                                    card.image
                                                                "
                                                            />
                                                            <div
                                                                class="card-body"
                                                            >
                                                                <h3
                                                                    class="card-title"
                                                                >
                                                                    {{
                                                                        card.name
                                                                    }}
                                                                </h3>
                                                                <div
                                                                    class="kutipan"
                                                                >
                                                                    <small
                                                                        class="card-text"
                                                                        >{{
                                                                            card.kutipan
                                                                        }}</small
                                                                    >
                                                                </div>
                                                                <div
                                                                    class="text-right my-3"
                                                                >
                                                                    <small
                                                                        class="certifikat-text"
                                                                        :class="
                                                                            card.completed
                                                                                ? 'active-certifikat'
                                                                                : 'text-black'
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="bi bi-patch-check-fill fs-5"
                                                                            :class="
                                                                                card.completed
                                                                                    ? 'active-certifikat'
                                                                                    : 'text-black'
                                                                            "
                                                                        ></i>
                                                                        Sertifikat
                                                                    </small>
                                                                </div>
                                                                <div
                                                                    v-if="
                                                                        card.disabled
                                                                    "
                                                                    class="disable-category mb-2"
                                                                >
                                                                    <span
                                                                        class="unprogress"
                                                                        >Selesaikan
                                                                        kelas
                                                                        sebelumnya
                                                                        ya!</span
                                                                    >
                                                                </div>
                                                                <div
                                                                    v-else
                                                                    class="progress mb-2"
                                                                >
                                                                    <div
                                                                        class="progress-bar"
                                                                        role="progressbar"
                                                                        :style="{
                                                                            width:
                                                                                card.progress +
                                                                                '%',
                                                                        }"
                                                                        :aria-valuenow="
                                                                            card.progress
                                                                        "
                                                                        aria-valuemin="0"
                                                                        aria-valuemax="100"
                                                                    >
                                                                        {{
                                                                            card.progress
                                                                        }}%
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="bottom-bar d-flex justify-content-between align-items-center"
                                        >
                                            <span>
                                                Siap untuk tantangan baru? Yuk,
                                                ikuti pembelajaran E-learning
                                                dari KemenPPA dan tingkatkan
                                                pengetahuanmu!
                                            </span>
                                            <button
                                                class="kemenppa"
                                                @click="showModal = true"
                                            >
                                                Ikuti Tantangan
                                            </button>
                                        </div>
                                        <div
                                            :class="[
                                                'modal',
                                                'fade',
                                                { show: showModal },
                                            ]"
                                            tabindex="-1"
                                            v-if="showModal"
                                            style="display: block"
                                        >
                                            <div
                                                class="modal-dialog modal-dialog-centered"
                                            >
                                                <div class="modal-content">
                                                    <!-- Header Modal -->
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            E-Learning
                                                            Kementerian
                                                            Perlindungan
                                                            Perempuan dan Anak
                                                        </h5>
                                                        <div
                                                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                            @click="closeModal"
                                                            aria-label="Close"
                                                        >
                                                            <span
                                                                class="svg-icon-2x"
                                                            >
                                                                <!-- Close Icon -->
                                                                <svg
                                                                    width="32"
                                                                    height="32"
                                                                    viewBox="0 0 32 32"
                                                                    fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                >
                                                                    <path
                                                                        d="M17.88 15.9996L23.6134 10.2796C23.8644 10.0285 24.0055 9.688 24.0055 9.33293C24.0055 8.97786 23.8644 8.63733 23.6134 8.38626C23.3623 8.13519 23.0218 7.99414 22.6667 7.99414C22.3116 7.99414 21.9711 8.13519 21.72 8.38626L16 14.1196L10.28 8.38626C10.029 8.13519 9.68844 7.99414 9.33337 7.99414C8.97831 7.99414 8.63778 8.13519 8.38671 8.38626C8.13564 8.63733 7.99459 8.97786 7.99459 9.33293C7.99459 9.688 8.13564 10.0285 8.38671 10.2796L14.12 15.9996L8.38671 21.7196C8.26174 21.8435 8.16254 21.991 8.09485 22.1535C8.02716 22.316 7.99231 22.4902 7.99231 22.6663C7.99231 22.8423 8.02716 23.0166 8.09485 23.179C8.16254 23.3415 8.26174 23.489 8.38671 23.6129C8.51066 23.7379 8.65813 23.8371 8.8206 23.9048C8.98308 23.9725 9.15736 24.0073 9.33337 24.0073C9.50939 24.0073 9.68366 23.9725 9.84614 23.9048C10.0086 23.8371 10.1561 23.7379 10.28 23.6129L16 17.8796L21.72 23.6129C21.844 23.7379 21.9915 23.8371 22.1539 23.9048C22.3164 23.9725 22.4907 24.0073 22.6667 24.0073C22.8427 24.0073 23.017 23.9725 23.1795 23.9048C23.342 23.8371 23.4894 23.7379 23.6134 23.6129C23.7383 23.489 23.8375 23.3415 23.9052 23.179C23.9729 23.0166 24.0078 22.8423 24.0078 22.6663C24.0078 22.4902 23.9729 22.316 23.9052 22.1535C23.8375 21.991 23.7383 21.8435 23.6134 21.7196L17.88 15.9996Z"
                                                                        fill="black"
                                                                    />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Body Modal -->
                                                    <div class="modal-body">
                                                        <p>
                                                            Sebagai standarisasi
                                                            puspaga balai RW,
                                                            berikut materi yang
                                                            wajib diikuti pada
                                                            E-learning KemenPPA:
                                                            <br /><br />
                                                            1. Konvensi Hak Anak
                                                            <br />
                                                            2. Pengasuhan
                                                            Positif <br />
                                                            3. Perlindungan dan
                                                            Keselamatan Anak
                                                            <br />
                                                        </p>
                                                    </div>

                                                    <!-- Footer Modal -->
                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-light me-4"
                                                            @click="closeModal"
                                                        >
                                                            Batal
                                                        </button>
                                                        <button
                                                            @click="
                                                                navigateToWebsite
                                                            "
                                                            class="btn btn-sm bg-second-primary-custom text-white"
                                                            type="button"
                                                        >
                                                            Mengerti
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            cards: [],
            showModal: false,
        };
    },
    mounted() {
        this.fetchCategories();
        reinitializeAllPlugin();
    },
    methods: {
        navigateToCategory(id) {
            this.$router.push({
                name: "elearningpuspaga-kategori",
                params: { id },
            });
        },
        async fetchCategories() {
            try {
                const response = await axios.get(`/api/kategori/getKategoris`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "dp5a-token"
                        )}`,
                    },
                });
                console.log("Respons API Kategori:", response.data);

                if (Array.isArray(response.data)) {
                    this.cards = response.data.map((category) => ({
                        id: category.id,
                        name: category.name,
                        deskripsi: category.deskripsi,
                        kutipan: category.kutipan,
                        progress: category.progress,
                        image: category.image,
                        disabled: category.is_disabled,
                        completed: category.is_completed,
                    }));
                } else {
                    console.error(
                        "Data kategori tidak dalam bentuk array:",
                        response.data
                    );
                }
            } catch (error) {
                console.error("Gagal mengambil data kategori:", error);
            }
        },
        getImageUrl(path) {
            return `/storage/${path}`;
        },
        navigateToWebsite() {
            window.open("https://elearning.kemenpppa.go.id/", "_blank");
            this.showModal = false;
        },
        closeModal() {
            this.showModal = false;
        },
    },
};
</script>

<style scoped>
.hero-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
}

.logo-img {
    width: 100%;
    height: auto;
}

.row {
    display: flex;
    align-items: center;
}

.header-title h1 {
    font-size: 24px;
    font-weight: bold;
}

.header-title p {
    font-size: 14px;
    color: grey;
}

.card-class {
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 20px;
}

p.salam-pembuka {
    font-size: 15px;
}

p.ajakan {
    font-size: 15px;
}

.card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    height: 180px;
    object-fit: cover;
    object-position: top;
}

.card-body {
    padding: 1rem;
}

.kutipan {
    height: 35px;
}

small.card-text {
    font-size: 14px;
}

small.certifikat-text {
    font-weight: 500;
    font-size: 10px;
    text-align: right;
    display: block;
}

.active-certifikat {
    color: #00a175;
}

.progress-bar {
    background-color: #f85c9b;
}

.disabled-card {
    pointer-events: none;
    opacity: 0.6;
    cursor: not-allowed;
    background-color: #f0f0f0;
}

span.unprogress {
    font-size: 10px;
}

.bottom-bar {
    background-color: #fce4ec;
    padding: 15px 20px;
    border-top: 1px solid #f8bbd0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    border-radius: 0 0 10px 10px;
}

.bottom-bar span {
    color: black;
    font-weight: 900;
    font-size: 1rem;
}

.bottom-bar button {
    background-color: #ffffff;
    border: none;
    padding: 5px 10px;
    border-radius: 7px;
    color: black;
    cursor: pointer;
    font-size: 1rem;
}

@media (max-width: 768px) {
    .bottom-bar {
        padding: 10px 15px;
    }

    .bottom-bar span,
    .bottom-bar button {
        font-size: 0.9rem;
        padding: 5px 8px;
    }

    .card-img-top {
        height: 460px;
    }
}

@media (max-width: 480px) {
    .bottom-bar {
        padding: 8px 10px;
    }

    .bottom-bar span,
    .bottom-bar button {
        font-size: 0.8rem;
        padding: 4px 8px;
    }

    .card-img-top {
        height: 290px;
    }

    span.unprogress {
        font-size: 14px;
    }
}
</style>
