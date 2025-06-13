<template>
    <div>
        <div class="pu_site_page">
            <app-header></app-header>

            <section
                class="pu_beadcrumb_part"
                :data-bg-img="`${$assetUrl()}siapppak/images/windowkie.jpg`"
                :style="`background: url(${$assetUrl()}siapppak/images/windowkie.jpg) center center / cover no-repeat;`"
            >
                <div class="container custom_container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pu_breadcrumb_inner_content">
                                <h2 class="sub_title">
                                    KIE (Komunikasi Informasi Edukasi)
                                </h2>

                                <h1 class="title">Perempuan dan Anak</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pu_beadcrumb_shape"></div>
            </section>

            <section class="pu_blog_post padding_bottom pu_single_page_wrapper">
                <div class="container custom_container">
                    <div class="row mb-5">
                        <h3
                            class="d-inline-block fw-bolder"
                            style="width: fit-content"
                        >
                            Filter Data
                        </h3>
                        <div class="col-md-4">
                            <select
                                class="form-control"
                                v-on:change="getData"
                                v-model="filter.type"
                                placeholder="Pilih Tipe KIE"
                            >
                                <option value="">Semua</option>
                                <option
                                    v-for="opt in kieTypeOptions"
                                    :value="opt.value"
                                >
                                    {{ opt.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row" v-if="data.length > 0">
                        <div
                            class="col-lg-4 col-md-6 mb-5"
                            v-for="(item, index) in data"
                            :key="index"
                        >
                            <div class="popular_causes_list_wrapper">
                                <div class="popular_causes_list_thumb">
                                    <a href="#" class="d-block">
                                        <img
                                            :src="item.file_thumbnail"
                                            alt="Profil Puspaga"
                                            class="img-fluid popup-image"
                                            :data-mfp-src="item.file_thumbnail"
                                        />
                                    </a>
                                </div>
                                <div class="pu_upcoming_event_description">
                                    <span class="badge badge-info mb-3">{{
                                        kieTypeEnum[item.type]
                                    }}</span>
                                    <h4 class="title truncate truncate-1">
                                        {{ item.title }}
                                    </h4>
                                    <div
                                        class="description text-truncate-container"
                                        v-html="item.description"
                                    ></div>
                                    <div class="my-3" v-if="item.description">
                                        <span
                                            class="badge badge-dark read-more-kie"
                                            v-on:click="showMore(item)"
                                            data-toggle="modal"
                                            data-target="#showMoreModal"
                                            >Read More</span
                                        >
                                    </div>
                                    <a
                                        v-if="
                                            'Gambar' == kieTypeEnum[item.type]
                                        "
                                        :href="item.file_image"
                                        download
                                        class="cu_btn btn_2"
                                        >Download Gambar</a
                                    >
                                    <a
                                        v-else-if="
                                            'PDF' == kieTypeEnum[item.type]
                                        "
                                        :href="item.file_pdf"
                                        download
                                        class="cu_btn btn_2"
                                        >Download PDF</a
                                    >
                                    <a
                                        v-else-if="
                                            'Video' == kieTypeEnum[item.type]
                                        "
                                        :href="item.url_video_youtube"
                                        class="cu_btn btn_2"
                                        target="_blank"
                                        >Lihat Video</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center">
                        Belum ada materi apapun.
                    </div>
                    <div class="row" v-if="data.length > 0">
                        <div class="d-flex justify-content-end">
                            <button
                                class="btn-prev-next"
                                :disabled="pagination.current_page === 1"
                                v-on:click="onPrev"
                            >
                                <i class="fa fa-arrow-left"></i>
                            </button>
                            <span
                                style="
                                    min-width: 2rem;
                                    font-weight: bold;
                                    font-size: 1.5rem;
                                    text-align: center;
                                    line-height: 3rem;
                                "
                                >{{ pagination.current_page }}</span
                            >
                            <button
                                class="btn-prev-next"
                                :disabled="
                                    pagination.current_page ===
                                    pagination.last_page
                                "
                                v-on:click="onNext"
                            >
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <app-footer></app-footer>
        </div>
        <div
            class="modal fade"
            id="showMoreModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="showMoreModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-more">
                    <div class="modal-header">
                        <h5
                            class="modal-title fw-bolder"
                            id="showMoreModalLabel"
                        >
                            {{ selectedData.title }}
                        </h5>
                        <button
                            type="button"
                            class="close btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div
                            class="description"
                            v-html="selectedData.description"
                        ></div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <app-popupsearch></app-popupsearch>
        <app-mobilemenu></app-mobilemenu>
    </div>
</template>

<script>
import Api from "@/services/api";
const GAMBAR = 1;
const VIDEO = 2;
const PDF = 3;

export default {
    data() {
        return {
            data: [],
            kieTypeEnum: {
                [GAMBAR]: "Gambar",
                [VIDEO]: "Video",
                [PDF]: "PDF",
            },
            kieTypeOptions: [],
            selectedData: {},
            filter: {
                type: "",
            },
            pagination: {
                current_page: 1,
                last_page: 1,
            },
        };
    },
    methods: {
        getData() {
            const params = {
                type: this.filter.type,
                page: this.pagination.current_page,
                limit: 12,
            };

            Api()
                .get(`public/kie`, { params })
                .then((response) => {
                    this.data = response.data.data;
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        next_page_url: response.data.next_page_url,
                        prev_page_url: response.data.prev_page_url,
                    };
                })
                .catch((error) => {
                    this.data = [];
                    this.$axiosHandleError(error);
                });
        },
        getKieJenisEnum() {
            Api()
                .get(`public/kie-jenis-enum`)
                .then((response) => {
                    const baseEnum = response.data;
                    this.kieTypeEnum = {
                        [baseEnum.GAMBAR.value]: baseEnum.GAMBAR.label,
                        [baseEnum.VIDEO.value]: baseEnum.VIDEO.label,
                        [baseEnum.PDF.value]: baseEnum.PDF.label,
                    };

                    this.kieTypeOptions = Object.values(baseEnum).map((v) => ({
                        ...v,
                    }));
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        showMore(item) {
            this.selectedData = { ...item };
        },
        onPrev() {
            this.pagination.current_page -= 1;
            this.getData();
        },
        onNext() {
            this.pagination.current_page += 1;
            this.getData();
        },
    },
    mounted() {
        this.getKieJenisEnum();
        this.getData();
    },
};
</script>

<style>
.text-truncate-container {
    width: 100%;
    max-width: 100%;
    -webkit-line-clamp: 3;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 0;
    height: 90px;
}

.text-truncate-container p {
    margin: 0;
}

.social_tooltip .social_icon a {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
}

.read-more-kie {
    cursor: pointer;
}

.modal-more {
    box-shadow: 0px 0px 7px 0px rgba(0, 0, 0, 0.07);
    border: none;
    outline: none;
    border-radius: 0.75rem;
}

.modal-more .modal-title {
    padding-block: 0.5rem;
    font-size: 28px;
    font-weight: bold;
    line-height: 1.071;
    margin-bottom: 20px;
}

.btn-prev-next {
    padding: 5px;
    font-size: 12px;
    border: 0 !important;
    width: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 5px;
    height: 35px;
    border-radius: 8px !important;
    background-color: #c81e4f;
}

.btn-prev-next > i {
    color: #fff;
}

.btn-prev-next:disabled {
    background: #f7f9fb;
}
.btn-prev-next:disabled > i {
    background: #f7f9fb;
    color: gray;
}
</style>
