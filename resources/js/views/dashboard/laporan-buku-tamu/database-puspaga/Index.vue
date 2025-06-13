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
                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    id="kt_profile_details_view"
                                >
                                    <div
                                        class="card card-xl-stretch mb-5 mb-xl-8"
                                    >
                                        <div
                                            class="card-header border-0 pt-5 align-items-center"
                                        >
                                            <h3
                                                class="card-title align-items-start flex-column"
                                            >
                                                <span
                                                    class="card-label fw-bolder text-dark mb-2"
                                                    style="
                                                        font-size: 20px !important;
                                                    "
                                                    >Laporan Buku Tamu Puspaga</span
                                                >
                                            </h3>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div
                                                class="row justify-content-center"
                                            >
                                                <div class="col-lg-12">
                                                    <div
                                                        data-kt-buttons="true"
                                                        class="row"
                                                    >
                                                        <div
                                                            class="col-lg-4 p-6"
                                                        >
                                                            <label
                                                                class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5"
                                                            >
                                                                <div
                                                                    class="d-flex align-items-center me-2"
                                                                >
                                                                    <!--begin::Radio-->
                                                                    <div
                                                                        class="form-check form-check-custom form-check-solid form-check-primary me-6"
                                                                    >
                                                                        <input
                                                                            class="form-check-input"
                                                                            type="radio"
                                                                            :name="'type'"
                                                                            v-model="
                                                                                single.type
                                                                            "
                                                                            value="laporanPuspaga"
                                                                            checked
                                                                        />
                                                                    </div>
                                                                    <!--end::Radio-->

                                                                    <!--begin::Info-->
                                                                    <div
                                                                        class="flex-grow-1"
                                                                    >
                                                                        <h2
                                                                            class="d-flex align-items-center fs-3 fw-bolder flex-wrap"
                                                                        >
                                                                            Buku Tamu Puspaga
                                                                        </h2>
                                                                        <div
                                                                            class="text-gray-500"
                                                                        >
                                                                            Akan
                                                                            menampilkan
                                                                            laporan
                                                                            Database Buku Tamu
                                                                            Puspaga
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Info-->
                                                                </div>
                                                            </label>
                                                        </div>

                                                        <!--end::Radio button-->
                                                    </div>
                                                    <div
                                                        class="row align-items-center"
                                                    >
                                                        <div
                                                            class="col-lg-3 mb-5 fw-bolder"
                                                        >
                                                            Periode tanggal 
                                                        </div>
                                                        <div
                                                            class="col-lg-9 mb-5"
                                                        >
                                                            <div
                                                                class="d-flex flex-wrap"
                                                            >
                                                                <button
                                                                    type="button"
                                                                    :style="
                                                                        single.periode ==
                                                                        'all'
                                                                            ? 'color:#fff !important;background-color: #009ef7 !important;'
                                                                            : ''
                                                                    "
                                                                    @click="
                                                                        single.periode =
                                                                            'all'
                                                                    "
                                                                    style="
                                                                        font-size: 13px;
                                                                        padding: 7px
                                                                            10px !important;
                                                                    "
                                                                    class="btn me-4 mb-3 btn-outline btn-outline-solid btn-outline-primary btn-active-light-primary"
                                                                >
                                                                    Semua
                                                                    Periode
                                                                </button>
                                                                <button
                                                                    type="button"
                                                                    :style="
                                                                        single.periode ==
                                                                        1
                                                                            ? 'color:#fff !important;background-color: #009ef7 !important;'
                                                                            : ''
                                                                    "
                                                                    @click="
                                                                        single.periode = 1
                                                                    "
                                                                    style="
                                                                        font-size: 13px;
                                                                        padding: 7px
                                                                            10px !important;
                                                                    "
                                                                    class="btn me-4 mb-3 btn-outline btn-outline-solid btn-outline-primary btn-active-light-primary"
                                                                >
                                                                    Bulan Ini
                                                                </button>
                                                                <button
                                                                    type="button"
                                                                    :style="
                                                                        single.periode ==
                                                                        2
                                                                            ? 'color:#fff !important;background-color: #009ef7 !important;'
                                                                            : ''
                                                                    "
                                                                    @click="
                                                                        single.periode = 2
                                                                    "
                                                                    style="
                                                                        font-size: 13px;
                                                                        padding: 7px
                                                                            10px !important;
                                                                    "
                                                                    class="btn me-4 mb-3 btn-outline btn-outline-solid btn-outline-primary btn-active-light-primary"
                                                                >
                                                                    3 Bulan
                                                                    Terakhir
                                                                </button>
                                                                <button
                                                                    type="button"
                                                                    :style="
                                                                        single.periode ==
                                                                        3
                                                                            ? 'color:#fff !important;background-color: #009ef7 !important;'
                                                                            : ''
                                                                    "
                                                                    @click="
                                                                        single.periode = 3
                                                                    "
                                                                    style="
                                                                        font-size: 13px;
                                                                        padding: 7px
                                                                            10px !important;
                                                                    "
                                                                    class="btn me-4 mb-3 btn-outline btn-outline-solid btn-outline-primary btn-active-light-primary"
                                                                >
                                                                    1 Tahun
                                                                    Terakhir
                                                                </button>
                                                                <button
                                                                    type="button"
                                                                    :style="
                                                                        single.periode ==
                                                                        4
                                                                            ? 'color:#fff !important;background-color: #009ef7 !important;'
                                                                            : ''
                                                                    "
                                                                    @click="
                                                                        single.periode = 4
                                                                    "
                                                                    style="
                                                                        font-size: 13px;
                                                                        padding: 7px
                                                                            10px !important;
                                                                    "
                                                                    class="btn me-4 mb-3 btn-outline btn-outline-solid btn-outline-primary btn-active-light-primary"
                                                                >
                                                                    Pilih
                                                                    Tanggal
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="row mt-5 align-items-center"
                                                                v-if="
                                                                    single.periode ==
                                                                    4
                                                                "
                                                            >
                                                                <div
                                                                    class="col-lg-2 fw-bolder"
                                                                >
                                                                    Tgl. Awal
                                                                </div>
                                                                <div
                                                                    class="col-lg-4"
                                                                >
                                                                    <app-datepicker
                                                                        type="datetime"
                                                                        :format="'DD-MM-YYYY HH:mm:ss'"
                                                                        :value-type="'YYYY-MM-DD HH:mm:ss'"
                                                                        :style="'font-size:12px !important;'"
                                                                        v-model:value="
                                                                            single.startDate
                                                                        "
                                                                    >
                                                                    </app-datepicker>
                                                                </div>
                                                                <div
                                                                    class="col-lg-2 fw-bolder"
                                                                >
                                                                    Tgl. Akhir
                                                                </div>
                                                                <div
                                                                    class="col-lg-4"
                                                                >
                                                                    <app-datepicker
                                                                        type="datetime"
                                                                        :format="'DD-MM-YYYY HH:mm:ss'"
                                                                        :value-type="'YYYY-MM-DD HH:mm:ss'"
                                                                        :style="'font-size:12px !important;'"
                                                                        v-model:value="
                                                                            single.endDate
                                                                        "
                                                                    ></app-datepicker>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <template
                                                            v-if="
                                                                single.type ==
                                                                'laporanPuspaga'
                                                            "
                                                        >
                                                            <div class="col-lg-3 mb-5 fw-bolder"
                                                            >
                                                                Layanan
                                                            </div>
                                                            <div class="col-lg-9 mb-5">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="w-100 me-3">
                                                                        <app-select-single
                                                                            v-model="single.layanan"
                                                                            :placeholder="'Pilih Layanan'"
                                                                            :disabled="single.checkAllLayanan"
                                                                            :loading="pageStatus == 'layanan-load'"
                                                                            :options="list_layanan"
                                                                            :serverside="true"
                                                                            @change-search="getLayanan"
                                                                        >
                                                                        </app-select-single>
                                                                    </div>
                                                                    <div class="form-check form-check-custom form-check-solid">
                                                                        <input
                                                                            class="form-check-input"
                                                                            v-model="single.checkAllLayanan"
                                                                            type="checkbox"
                                                                            value=""
                                                                            id="all-sub-district"
                                                                        />
                                                                        <label class="form-check-label" for="all-sub-district">
                                                                            Semua
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-center mt-5"
                                                    >
                                                        <button
                                                            class="btn btn-light me-3"
                                                            @click="preview"
                                                        >
                                                            Preview
                                                        </button>
                                                        <button
                                                            class="btn btn-primary"
                                                            @click="excel"
                                                            :disabled="
                                                                pageStatus ==
                                                                'form-export'
                                                            "
                                                        >
                                                            <template
                                                                v-if="
                                                                    pageStatus ==
                                                                    'form-export'
                                                                "
                                                            >
                                                                Memproses...
                                                            </template>
                                                            <template v-else>
                                                                &ensp;
                                                                <svg
                                                                    width="21"
                                                                    height="21"
                                                                    viewBox="0 0 21 21"
                                                                    fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                >
                                                                    <path
                                                                        d="M2.16675 11.3333C2.16675 10.9167 2.58341 10.5 3.00008 10.5C3.41675 10.5 3.83341 10.9167 3.83341 11.3333C3.83341 11.6111 3.83341 13 3.83341 15.5C3.83341 16.4205 4.57961 17.1667 5.50008 17.1667H15.5001C16.4206 17.1667 17.1667 16.4205 17.1667 15.5V11.3333C17.1667 10.8731 17.5398 10.5 18.0001 10.5C18.4603 10.5 18.8334 10.8731 18.8334 11.3333V15.5C18.8334 17.3409 17.341 18.8333 15.5001 18.8333H5.50008C3.65913 18.8333 2.16675 17.3409 2.16675 15.5C2.16675 13 2.16675 11.6111 2.16675 11.3333Z"
                                                                        fill="white"
                                                                    />
                                                                    <path
                                                                        d="M9.66659 12.1667C9.66659 12.6269 10.0397 13 10.4999 13C10.9602 13 11.3333 12.6269 11.3333 12.1667L11.3333 2.16667C11.3333 1.70643 10.9602 1.33333 10.4999 1.33333C10.0397 1.33333 9.66659 1.70643 9.66659 2.16667L9.66659 12.1667Z"
                                                                        fill="white"
                                                                    />
                                                                    <path
                                                                        d="M14.0774 8.24668C14.4028 7.92124 14.9305 7.92124 15.2559 8.24668C15.5814 8.57212 15.5814 9.09975 15.2559 9.42519L11.0893 13.5919C10.7759 13.9053 10.272 13.9185 9.94253 13.622L5.77586 9.87201C5.43377 9.56413 5.40604 9.03722 5.71392 8.69513C6.0218 8.35304 6.54871 8.32531 6.8908 8.63319L10.4698 11.8543L14.0774 8.24668Z"
                                                                        fill="white"
                                                                    />
                                                                </svg>
                                                                Unduh Excel
                                                            </template>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
import Api from "@/services/api";

export default {
    data() {
        return {
            pageStatus: "standby",
            list_layanan: [],
            single: {
                type: "laporanPuspaga",
                periode: "",
                startDate: "",
                endDate: "",
                layanan:{},
                checkAllLayanan: false,
            },
        };
    },
    watch: {
        "single.type": function () {
            this.single.layanan = {};

            this.single.checkAllLayanan = false;
        },
        "single.periode": function () {
            this.single.startDate = "";
            this.single.endDate = "";
        },
        "single.checkAllLayanan": function () {
            if (this.single.checkAllLayanan) {
                this.single.layanan = {};
            }
        },
    },
    mounted() {
        reinitializeAllPlugin();
    },
    methods: {
        preview() {
            if (!this.single.type) {
                this.$toast.info("Pilih tipe dahulu!");
                return false;
            }

            if (!this.single.periode) {
                this.$toast.info("Pilih periode dahulu!");
                return false;
            }

            if (this.single.periode == 4) {
                if (!this.single.startDate) {
                    this.$toast.info("Tanggal awal tidak boleh kosong!");
                    return false;
                }
                if (!this.single.endDate) {
                    this.$toast.info("Tanggal akhir tidak boleh kosong!");
                    return false;
                }
            }
            this.$router.push({
                path: "/laporan/kasus-klien/preview",
                query: {
                    periode: this.single.periode,
                    startDate: this.single.startDate,
                    endDate: this.single.endDate,
                    category: this.single.category,
                    problemType: this.single.problemType.id
                        ? this.single.problemType.id
                        : "",
                    caseCategory: this.single.caseCategory.id
                        ? this.single.caseCategory.id
                        : "",
                    subDistrict: this.single.subDistrict.id
                        ? this.single.subDistrict.id
                        : "",
                    lastEducation: this.single.lastEducation.id
                        ? this.single.lastEducation.id
                        : "",
                    type: this.single.type,
                },
            });
        },
        excel() {
            if (!this.single.type) {
                this.$toast.info("Pilih tipe dahulu!");
                return false;
            }

            if (!this.single.periode) {
                this.$toast.info("Pilih periode dahulu!");
                return false;
            }

            if (this.single.periode == 4) {
                if (!this.single.startDate) {
                    this.$toast.info("Tanggal awal tidak boleh kosong!");
                    return false;
                }
                if (!this.single.endDate) {
                    this.$toast.info("Tanggal akhir tidak boleh kosong!");
                    return false;
                }
            }
            let formData = {
                is_download: 1,
                type: this.single.type,
            };

            if (this.single.periode && this.single.periode != "all") {
                Object.assign(formData, {
                    periode: this.single.periode,
                });
            }

            if (this.single.startDate) {
                Object.assign(formData, {
                    start_date: this.single.startDate,
                });
            }

            if (this.single.endDate) {
                Object.assign(formData, {
                    end_date: this.single.endDate,
                });
            }
            
            if (this.single.layanan.id) {
                Object.assign(formData, {
                    id_layanan: this.single.layanan.id,
                });
            }

            this.pageStatus = "form-export";

            Api()
                .get("/buku-tamu/laporan-puspaga", {
                    responseType: "blob",
                    params: formData,
                })
                .then((response) => {
                    const url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "Laporan Database Puspaga.xlsx");
                    document.body.appendChild(link);
                    link.click();
                })
                .catch((error) => {
                    this.$axioshandler(error);
                })
                .then(() => {
                    this.pageStatus = "standby";
                    this.disabledButton = false;
                });
        },

        getLayanan(keyword, limit) {
            this.pageStatus = "layanan-load";
            Api()
                .get(`kebutuhan-layanan/lists?limit=${limit}&search=${keyword}`)
                .then((response) => {
                    this.list_layanan = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_layanan.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })
                .catch((error) => {
                    this.list_layanan = [];
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.pageStatus = "standby";
                });
        },
    },
};
</script>

<style scoped></style>
