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
                    <!-- isi contentnya ya -->

                    <div id="main-content">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div
                                id="kt_content_container"
                                class="container-xxl"
                            >
                                <!-- start -->
                                <div>
                                    <div class="head my-5">
                                        <div class="row pt-5 mt-4">
                                            <div class="col-12">
                                                <div class="d-flex flex-wrap">
                                                    <div
                                                        class=""
                                                        style="
                                                            border-right: 1px
                                                                solid grey;
                                                            padding-right: 10px;
                                                        "
                                                    >
                                                        <h4>Detail Materi</h4>
                                                    </div>
                                                    <div>
                                                        &ensp;
                                                        <span
                                                            class="text-muted"
                                                        >
                                                            <a
                                                                href="javascript:void(0)"
                                                                @click="
                                                                    $router.push(
                                                                        {
                                                                            name: 'elearning-materi',
                                                                        }
                                                                    )
                                                                "
                                                                class="text-muted"
                                                                style="
                                                                    text-decoration: none;
                                                                "
                                                            >
                                                                Materi
                                                            </a>
                                                            - Detail Data
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-5">
                                        <div class="col-lg-8">
                                            <h1>Detail Materi</h1>
                                        </div>
                                        <div
                                            class="col-lg-4 d-flex"
                                            style="justify-content: flex-end"
                                        >
                                            <button
                                                type="button"
                                                class="btn"
                                                style="
                                                    background-color: #fff8dd;
                                                "
                                                @click="
                                                    $router.push({
                                                        name: 'elearning-materi',
                                                    })
                                                "
                                            >
                                                <span
                                                    class="text-warning d-flex"
                                                >
                                                    <svg
                                                        width="22"
                                                        height="22"
                                                        viewBox="0 0 22 22"
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
                                    </div>
                                    <div
                                        class="card card-flush mt-5 mb-5 mb-xl-10"
                                        id="kt_profile_details_view"
                                    >
                                        <!-- Loader while data is being fetched -->
                                        <div
                                            v-if="pageStatus === 'loading'"
                                            class="w-100 d-flex justify-content-center mt-10 mb-10"
                                        >
                                            <app-loader></app-loader>
                                        </div>

                                        <!-- Content displays when data has been fetched -->
                                        <div
                                            class="card card-xl-stretch mb-5 mb-xl-8"
                                            v-else
                                        >
                                            <div class="card-body pt-5">
                                                <h4
                                                    class="c-primary-custom fw-bolder mb-10"
                                                >
                                                    Detail Materi
                                                </h4>

                                                <!-- Judul Materi -->
                                                <div class="row">
                                                    <div
                                                        class="col-lg-3 text-gray-600 mb-8"
                                                    >
                                                        Judul Materi
                                                    </div>
                                                    <div
                                                        class="col-lg-9 fw-bolder mb-8"
                                                    >
                                                        {{ materi.name }}
                                                    </div>
                                                </div>

                                                <!-- Kategori -->
                                                <div class="row">
                                                    <div
                                                        class="col-lg-3 text-gray-600 mb-8"
                                                    >
                                                        Kategori
                                                    </div>
                                                    <div
                                                        class="col-lg-9 fw-bolder mb-8"
                                                    >
                                                        {{
                                                            materi.subkategori
                                                                .kategori.name
                                                        }}
                                                    </div>
                                                </div>

                                                <!-- Sub Kategori -->
                                                <div class="row">
                                                    <div
                                                        class="col-lg-3 text-gray-600 mb-8"
                                                    >
                                                        Sub Kategori
                                                    </div>
                                                    <div
                                                        class="col-lg-9 fw-bolder mb-8"
                                                    >
                                                        {{
                                                            materi.subkategori
                                                                .name
                                                        }}
                                                    </div>
                                                </div>

                                                <!-- Modul Section -->
                                                <div
                                                    class="row"
                                                    v-if="materi.modul_url"
                                                >
                                                    <div
                                                        class="col-lg-3 text-gray-600 mb-8"
                                                    >
                                                        Modul
                                                    </div>
                                                    <div
                                                        class="col-lg-9 fw-bolder mb-8"
                                                    >
                                                        <a
                                                            href="javascript:void(0)"
                                                            @click="lihatModul"
                                                        >
                                                            <img
                                                                style="
                                                                    height: 22px;
                                                                    width: 22px;
                                                                "
                                                                class="img-fluid"
                                                                src="/assets/siapppak/img/logo-pdf.svg"
                                                                alt="PDF Icon"
                                                            />
                                                            Modul
                                                            {{
                                                                materi.name
                                                            }}.pdf
                                                        </a>
                                                        <br />
                                                        <span
                                                            style="
                                                                font-size: 0.7em;
                                                                color: #6c757d;
                                                            "
                                                        >
                                                        </span>
                                                    </div>
                                                </div>

                                                <div
                                                    class="row"
                                                    v-if="materi.materi_url"
                                                >
                                                    <div
                                                        class="col-lg-3 text-gray-600 mb-8"
                                                    >
                                                        Materi
                                                    </div>
                                                    <div
                                                        class="col-lg-9 fw-bolder mb-8"
                                                    >
                                                        <div>
                                                            <div
                                                                v-if="isLoading"
                                                                class="loading-indicator mt-4"
                                                            >
                                                                <span
                                                                    >Loading
                                                                    PDF...</span
                                                                >
                                                            </div>
                                                            <div
                                                                v-else-if="
                                                                    pdfPages.length >
                                                                    0
                                                                "
                                                                class="pdf-slider mt-4"
                                                            >
                                                                <div
                                                                    v-for="(
                                                                        page,
                                                                        index
                                                                    ) in pdfPages"
                                                                    :key="index"
                                                                    v-show="
                                                                        currentPage ===
                                                                        index
                                                                    "
                                                                >
                                                                    <img
                                                                        :src="
                                                                            page
                                                                        "
                                                                        alt="PDF Page"
                                                                        class="slide-image"
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="indikator"
                                                                >
                                                                    <button
                                                                        @click="
                                                                            prevPage
                                                                        "
                                                                        class="slider-button prev"
                                                                    >
                                                                        <i
                                                                            class="bi bi-arrow-left text-dark fs-3"
                                                                        ></i>
                                                                    </button>
                                                                    <div
                                                                        class="slide-indicator"
                                                                    >
                                                                        {{
                                                                            currentPage +
                                                                            1
                                                                        }}
                                                                        /
                                                                        {{
                                                                            pdfPages.length
                                                                        }}
                                                                    </div>
                                                                    <button
                                                                        @click="
                                                                            nextPage
                                                                        "
                                                                        class="slider-button next"
                                                                    >
                                                                        <i
                                                                            class="bi bi-arrow-right text-dark fs-3"
                                                                        ></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div
                                                                v-else
                                                                class="error-indicator mt-4"
                                                            >
                                                                <span
                                                                    >Loading
                                                                    Slider...</span
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Video Section -->
                                                <div
                                                    class="row"
                                                    v-if="materi.video_url"
                                                >
                                                    <div
                                                        class="col-lg-3 col-12 text-gray-600 mb-8"
                                                    >
                                                        Video
                                                    </div>
                                                    <div
                                                        class="col-lg-9 col-12 fw-bolder mb-8"
                                                    >
                                                        <iframe
                                                            width="655"
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end -->
                            </div>
                            <!--end::Container-->
                        </div>

                        <!--end::Post-->
                    </div>

                    <!-- end of content -->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
import createApiInstance from "@/services/api";
import * as pdfjsLib from "pdfjs-dist/build/pdf";
pdfjsLib.GlobalWorkerOptions.workerSrc = `https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js`;

export default {
    data() {
        return {
            pageStatus: "loading",
            materi: {
                name: "",
                subkategori: {
                    name: "",
                    kategori: {
                        name: "",
                    },
                },
                modul_url: null,
                materi_url: null,
                video_url: null,
            },
            pdfPages: [],
            currentPage: 0,
        };
    },
    methods: {
        async loadPdfPages() {
            const pdfUrl = `/storage/${this.materi.materi_url}`;
            pdfjsLib.GlobalWorkerOptions.workerSrc = `//cdnjs.cloudflare.com/ajax/libs/pdf.js/${pdfjsLib.version}/pdf.worker.min.js`;
            this.isLoading = true; // Start loading
            try {
                const pdf = await pdfjsLib.getDocument(pdfUrl).promise;
                const pages = [];
                for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                    const page = await pdf.getPage(pageNum);
                    const viewport = page.getViewport({ scale: 1.5 });
                    const canvas = document.createElement("canvas");
                    const context = canvas.getContext("2d");
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;
                    await page.render({ canvasContext: context, viewport })
                        .promise;
                    pages.push(canvas.toDataURL("image/png"));
                }
                this.pdfPages = pages;
            } catch (error) {
                console.error("Error loading PDF:", error);
            } finally {
                this.isLoading = false; // End loading
            }
        },
        prevPage() {
            if (this.currentPage > 0) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.pdfPages.length - 1) {
                this.currentPage++;
            }
        },
        async fetchMateriDetails() {
            this.pageStatus = "loading";
            try {
                const Api = createApiInstance();
                const response = await Api.get(
                    `/materi/${this.$route.params.id}`
                );
                if (response.data.status === "success") {
                    this.materi = response.data.data;
                    this.pageStatus = "standby";
                } else {
                    console.warn("API returned a non-success status");
                    this.pageStatus = "error";
                }
            } catch (error) {
                console.error("Failed to fetch materi details:", error);
                this.pageStatus = "error";
            }
        },
        lihatModul() {
            if (this.materi.modul_url) {
                // Buat URL lengkap dengan prefix storage
                const url = `/storage/${this.materi.modul_url}`;
                window.open(url, "_blank");
            } else {
                alert("Modul tidak tersedia.");
            }
        },
    },
    computed: {
        embedUrl() {
            if (!this.materi.video_url) return "";
            const videoId = this.materi.video_url.split("v=")[1]?.split("&")[0];
            return `https://www.youtube.com/embed/${videoId}`;
        },
    },
    mounted() {
        this.fetchMateriDetails().then(() => {
            this.loadPdfPages();
        });
        reinitializeAllPlugin();
    },
};
</script>

<style scoped>
.loading-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: gray;
}

.error-indicator {
    color: grey;
    font-weight: 700;
    text-align: center;
}

.pdf-slider {
    position: relative;
}

.slide-image {
    width: 100%;
    border-radius: 7px;
}

.indikator {
    display: flex;
    justify-content: center;
    align-items: center;
}

.slide-indicator {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 500;
}

.prev,
.next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.7);
    border: none;
    padding: 8px;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.prev {
    left: 10px;
}

.next {
    right: 10px;
}
</style>
