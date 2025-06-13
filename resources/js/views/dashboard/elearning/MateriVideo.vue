<template>
    <div>
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
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <button
                                                class="btn btn-link p-0"
                                                type="button"
                                                @click="
                                                    () =>
                                                        navigateTo(
                                                            'elearning-puspaga'
                                                        )
                                                "
                                            >
                                                Elearning Puspaga
                                            </button>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <button
                                                class="btn btn-link p-0"
                                                type="button"
                                                @click="
                                                    () =>
                                                        navigateTo(
                                                            'elearningpuspaga-kategori',
                                                            {
                                                                id: category.id,
                                                            }
                                                        )
                                                "
                                            >
                                                Kategori {{ category.name }}
                                            </button>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <button
                                                class="btn btn-link p-0"
                                                type="button"
                                                @click="
                                                    () =>
                                                        navigateTo(
                                                            'elearningpuspaga-subkategori',
                                                            {
                                                                id: subCategory.id,
                                                            }
                                                        )
                                                "
                                            >
                                                {{ subCategory.name }}
                                            </button>
                                        </li>
                                        <li
                                            class="breadcrumb-item active"
                                            aria-current="page"
                                        >
                                            Materi Video
                                        </li>
                                    </ol>
                                </nav>

                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    id="kt_profile_details_view"
                                >
                                    <div
                                        class="card-body pt-6"
                                        id="start-content"
                                    >
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-6"
                                        >
                                            <h3 class="card-title">
                                                {{ name }}
                                            </h3>
                                            <button
                                                type="button"
                                                class="btn"
                                                style="
                                                    background-color: #fff8dd;
                                                "
                                                @click="goBack"
                                            >
                                                <span
                                                    class="text-warning d-flex"
                                                >
                                                    <svg
                                                        width="18"
                                                        height="18"
                                                        viewBox="0 0 18 18"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            opacity="0.3"
                                                            d="M17.4166 10.0846C17.9228 10.0846 18.3333 10.495 18.3333 11.0013C18.3333 11.5076 17.9228 11.918 17.4166 11.918H10.0833C9.57699 11.918 9.16658 11.5076 9.16658 11.0013C9.16658 10.495 9.57699 10.0846 10.0833 10.0846H17.4166Z"
                                                            fill="#FFA800"
                                                        />
                                                        <path
                                                            d="M11.6481 15.8531C12.0061 16.2111 12.0061 16.7915 11.6481 17.1495C11.2901 17.5075 10.7097 17.5075 10.3517 17.1495L4.85174 11.6495C4.50471 11.3025 4.49257 10.7437 4.8242 10.3819L9.86586 4.88189C10.208 4.5087 10.7878 4.48349 11.161 4.82558C11.5342 5.16767 11.5594 5.74752 11.2173 6.12072L6.76871 10.9737L11.6481 15.8531Z"
                                                            fill="#FFA800"
                                                        />
                                                    </svg>
                                                    Kembali
                                                </span>
                                            </button>
                                        </div>

                                        <p class="des mb-6">
                                            Ketika kita mulai kelas ini, penting
                                            bagi kita untuk memahami beberapa
                                            konsep dasar yang akan membantu
                                            dalam memahami materi selanjutnya.
                                            Menguasai konsep-konsep ini akan
                                            membuat kita lebih siap untuk
                                            menerapkan ide-ide yang akan kita
                                            temui sepanjang proses belajar.
                                            Dengan begitu, kita bisa lebih mudah
                                            mengeksplorasi topik-topik seru yang
                                            akan kita bahas bersama.
                                        </p>

                                        <div class="card video-card mb-5">
                                            <div class="row">
                                                <div
                                                    class="col-lg-8 col-12 mb-3"
                                                >
                                                    <div
                                                        class="video-wrapper"
                                                        v-if="video"
                                                    >
                                                        <iframe
                                                            width="560"
                                                            height="315"
                                                            :src="embedUrl"
                                                            title="YouTube video player"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            referrerpolicy="strict-origin-when-cross-origin"
                                                            allowfullscreen
                                                        ></iframe>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-12">
                                                    <div
                                                        class="content mx-lg-5 mx-2"
                                                    >
                                                        <p
                                                            class="card-description"
                                                        >
                                                            Silahkan simak video
                                                            berikut dengan baik
                                                            dan perhatikan
                                                            poin-poin penting
                                                            yang disampaikan.
                                                            Kamu juga bisa
                                                            melihat modul
                                                            penjelasan untuk
                                                            pemahaman yang lebih
                                                            mendalam. Jangan
                                                            ragu untuk mencatat
                                                            hal-hal penting.
                                                            Selamat belajar &
                                                            menonton!
                                                        </p>

                                                        <button
                                                            class="btn btn-lihatmodul"
                                                            type="button"
                                                            @click="lihatModul"
                                                        >
                                                            Lihat Modul
                                                            <i
                                                                class="bi bi-arrow-right text-white fs-4"
                                                            ></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex justify-content-center mt-4"
                                        >
                                            <button
                                                class="btn btn-mulai-latihan"
                                                type="button"
                                                @click="showConfirmModal = true"
                                            >
                                                Mulai Latihan
                                            </button>
                                        </div>

                                        <div
                                            :class="[
                                                'modal',
                                                'fade',
                                                { show: showConfirmModal },
                                            ]"
                                            tabindex="-1"
                                            v-if="showConfirmModal"
                                            style="display: block"
                                        >
                                            <div
                                                class="modal-dialog modal-dialog-centered"
                                            >
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Konfirmasi Mulai
                                                            Latihan
                                                        </h5>
                                                        <div
                                                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                            @click="
                                                                showConfirmModal = false
                                                            "
                                                            aria-label="Close"
                                                        >
                                                            <span
                                                                class="svg-icon-2x"
                                                            >
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
                                                    <div class="modal-body">
                                                        <p>
                                                            Apakah Anda yakin
                                                            ingin memulai
                                                            latihan ini?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-light me-4"
                                                            @click="
                                                                showConfirmModal = false
                                                            "
                                                        >
                                                            Batal
                                                        </button>
                                                        <button
                                                            @click="startQuiz"
                                                            class="btn btn-sm bg-second-primary-custom text-white"
                                                            type="button"
                                                        >
                                                            Mulai
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
            showConfirmModal: false,
            video: "",
            modul: "",
            name: "",
            subCategory: {
                id: null,
                name: "",
            },
            category: {
                id: null,
                name: "",
            },
        };
    },
    methods: {
        navigateTo(routeName, params = {}) {
            this.$router.push({ name: routeName, params });
        },
        goBack() {
            this.$router.go(-1);
        },
        navigateToKategoriDasar() {
            this.$router.push({ name: "elearning-puspaga" });
        },
        lihatModul() {
            if (this.modul) {
                window.open(`/storage/${this.modul}`, "_blank");
            } else {
                alert("Modul tidak tersedia.");
            }
        },
        async startQuiz() {
            this.showConfirmModal = false;
            const idMateri = this.$route.params.id;

            const data = {
                id_materi: idMateri,
                jenis_materi: "video",
            };

            try {
                // Create a new answer entry
                const jawabanResponse = await axios.post("/api/jawaban", data, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "dp5a-token"
                        )}`, // Ensure the token is in localStorage
                    },
                });

                const idJawaban = jawabanResponse.data?.data?.id; // Extract the ID of the answer
                console.log("ID Jawaban berhasil dibuat:", idJawaban);

                if (idJawaban) {
                    // Save `idJawaban` in localStorage
                    localStorage.setItem("idJawaban", idJawaban);

                    // Redirect to the quiz view with the materi ID
                    this.$router.push({
                        name: "elearningpuspaga-latihansoal", // Replace with your route name
                        params: { id: idMateri },
                    });
                }
            } catch (error) {
                console.error(
                    "Error during startQuiz:",
                    error.response?.data || error
                );
            }
        },
        async fetchMateri() {
            const idMateri = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/materi/getMateri/${idMateri}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.video = response.data.video;
                this.modul = response.data.modul;
                this.name = response.data.name;
                this.subCategory = response.data.sub_kategori;
                this.category = response.data.kategori;
            } catch (error) {
                console.error("Error fetching category data:", error);
            }
        },
    },
    computed: {
        embedUrl() {
            if (!this.video) return "";
            const videoId = this.video.split("v=")[1]?.split("&")[0];
            return `https://www.youtube.com/embed/${videoId}`;
        },
    },
    mounted() {
        reinitializeAllPlugin();
        this.fetchMateri();
    },
};
</script>

<style scoped>
.breadcrumb {
    display: flex;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 0.95rem;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
}

.breadcrumb-item:not(:last-child)::after {
    content: "|";
    color: #6c757d;
    padding: 0 0.5rem;
    font-size: 1.1rem;
}

.breadcrumb-item button {
    color: #ee7b33;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-item.active {
    color: #6c757d;
}

p.des {
    color: grey;
    line-height: 1.6;
    padding: 10px 0;
    font-size: 1rem;
}

.video-card {
    background-color: #fde2e4;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    max-width: 100%;
    margin: 0 auto;
}

.content {
    text-align: left;
    width: 100%;
}

.card-title {
    font-size: 1.5em;
    font-weight: bold;
    margin: 10px 0;
}

p.card-description {
    font-size: 1rem;
    color: #333;
    margin-bottom: 20px;
}

.btn-lihatmodul {
    background-color: #feaf60;
    color: white;
    border-radius: 10px;
    font-size: 12px;
    padding: 10px 1px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: box-shadow 0.3s ease;
    font-weight: 800;
}

.btn-lihatmodul:hover {
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

.btn-mulai-latihan {
    background-color: #feaf60;
    color: white;
    border-radius: 10px;
    font-size: 12px;
    padding: 8px 1px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: box-shadow 0.3s ease;
    font-weight: 800;
}

.modal.fade {
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transform: translateY(-20px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.modal.fade.show {
    opacity: 1;
    transform: translateY(0);
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    max-width: 300px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.modal-footer {
    display: flex;
    justify-content: center;
}

.video-wrapper {
    position: relative;
    width: 100%; /* Lebar penuh */
    aspect-ratio: 16 / 9; /* Rasio aspek 16:9 */
    border-radius: 10px;
    overflow: hidden;
    margin: auto;
}

.video-wrapper iframe {
    width: 100% !important; /* Abaikan atribut width */
    height: 100% !important; /* Abaikan atribut height */
    max-width: 100%; /* Batasi lebar ke ukuran container */
    aspect-ratio: 16 / 9; /* Pastikan proporsi tetap */
    border: none; /* Hilangkan border jika ada */
}

@media (max-width: 1024px) {
    .video-wrapper {
        max-width: 560px; /* Maksimal ukuran embed pada perangkat besar */
        margin: auto;
    }

    .video-card {
        flex-direction: column;
        align-items: center;
        padding: 10px;
    }

    .content {
        width: 100%;
        text-align: center;
        margin-top: 10px;
    }

    .card-title {
        font-size: 1.25em;
        text-align: left;
    }

    .card-description {
        text-align: left;
    }

    .btn-lihatmodul,
    .btn-mulai-latihan {
        width: 100%;
        font-size: 0.9em;
    }
}

@media (max-width: 768px) {
    .video-wrapper {
        max-width: 100%; /* Sesuaikan ke lebar layar */
    }

    .video-card {
        flex-direction: column;
        align-items: center;
        padding: 10px;
    }

    .content {
        width: 100%;
        text-align: center;
        margin-top: 10px;
    }

    .card-title {
        font-size: 1.25em;
    }

    .btn-lihatmodul,
    .btn-mulai-latihan {
        width: 100%;
        font-size: 0.9em;
    }
}

@media (max-width: 480px) {
    .video-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        width: 100%;
        margin: 0 auto;
    }

    .video-wrapper {
        width: 100%;
        position: relative;
        padding-top: 56.25%; /* Menjaga rasio 16:9 */
        margin-bottom: 15px; /* Menambah jarak dengan konten lainnya */
    }

    .video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .content {
        width: 100%;
        text-align: center;
        margin-top: 10px;
        padding: 0 10px;
    }

    .btn-lihatmodul {
        width: 100%;
        font-size: 0.8em;
        margin-top: 10px;
    }

    .card-description {
        font-size: 0.85em;
        text-align: center;
    }

    /* Pastikan container row dan col tidak overflow */
    .row {
        margin: 0;
        padding: 0;
        width: 100%;
        box-sizing: border-box;
    }

    .col-12 {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
}
</style>
