<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <app-navbar></app-navbar>
                    <!-- isi contentnya ya -->

                    <div id="main-content">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-xxl">

                                <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-header border-0 pt-5 align-items-center">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder text-dark mb-2"
                                                    style="font-size:20px !important;">Laporan Rekap E-Learning</span>
                                            </h3>

                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-9">
                                                    <div data-kt-buttons="true" class="row">
                                                        <div class="col-lg-6 p-6">
                                                            <label
                                                                class=" btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
                                                                <!--end::Description-->
                                                                <div class="d-flex align-items-center me-2">
                                                                    <!--begin::Radio-->
                                                                    <div
                                                                        class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="type" v-model="single.type"
                                                                            value="year" />
                                                                    </div>
                                                                    <!--end::Radio-->

                                                                    <!--begin::Info-->
                                                                    <div class="flex-grow-1">
                                                                        <h2
                                                                            class="d-flex align-items-center fs-3 fw-bolder flex-wrap">
                                                                            Tahunan
                                                                        </h2>
                                                                    </div>
                                                                    <!--end::Info-->
                                                                </div>
                                                                <!--end::Description-->
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-6 p-6">
                                                            <label
                                                                class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
                                                                <!--end::Description-->
                                                                <div class="d-flex align-items-center me-2">
                                                                    <!--begin::Radio-->
                                                                    <div
                                                                        class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                                        <input class="form-check-input" type="radio"
                                                                            :name="'type'" v-model="single.type"
                                                                            value="month" />
                                                                    </div>
                                                                    <!--end::Radio-->

                                                                    <!--begin::Info-->
                                                                    <div class="flex-grow-1">
                                                                        <h2
                                                                            class="d-flex align-items-center fs-3 fw-bolder flex-wrap">
                                                                            Bulanan
                                                                        </h2>

                                                                    </div>
                                                                    <!--end::Info-->
                                                                </div>
                                                                <!--end::Description-->
                                                            </label>
                                                        </div>
                                                        <!--end::Radio button-->
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <template v-if="single.type == 'year'">
                                                            <div class="col-lg-3 mb-5 fw-bolder">
                                                                Tahun Awal
                                                            </div>
                                                            <div class="col-lg-3 mb-5">
                                                                <app-datepicker :format="'YYYY'" :value-type="'YYYY'"
                                                                    :type="'year'" v-model:value="single.startYear">
                                                                </app-datepicker>
                                                            </div>
                                                            <div class="col-lg-3 mb-5 fw-bolder">
                                                                Tahun Akhir
                                                            </div>
                                                            <div class="col-lg-3 mb-5">
                                                                <app-datepicker :format="'YYYY'" :value-type="'YYYY'"
                                                                    :type="'year'" v-model:value="single.endYear">
                                                                </app-datepicker>
                                                            </div>
                                                        </template>
                                                        <template v-if="single.type == 'month'">
                                                            <div class="col-lg-3 mb-5 fw-bolder">
                                                                Bulan Awal
                                                            </div>
                                                            <div class="col-lg-3 mb-5">
                                                                <app-datepicker :format="'MM-YYYY'"
                                                                    :value-type="'YYYY-MM'" :type="'month'"
                                                                    v-model:value="single.startMonth">
                                                                </app-datepicker>
                                                            </div>
                                                            <div class="col-lg-3 mb-5 fw-bolder">
                                                                Bulan Akhir
                                                            </div>
                                                            <div class="col-lg-3 mb-5">
                                                                <app-datepicker :format="'MM-YYYY'"
                                                                    :value-type="'YYYY-MM'" :type="'month'"
                                                                    v-model:value="single.endMonth">
                                                                </app-datepicker>
                                                            </div>
                                                        </template>
                                                        <div class="col-lg-3 mb-5 fw-bolder">
                                                            Kategori
                                                        </div>
                                                        <div class="col-lg-9 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <div class="w-100 me-3">
                                                                    <app-select-single v-model="single.kategori"
                                                                        :placeholder="'Pilih Kategori'"
                                                                        :disabled="single.checkAllProblemType"
                                                                        :loading="pageStatus == 'kategori-load'"
                                                                        :options="list_kategori" :serverside="true"
                                                                        @change-search="getKategori">
                                                                    </app-select-single>
                                                                </div>
                                                                <div
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input"
                                                                        v-model="single.checkAllProblemType"
                                                                        type="checkbox" value=""
                                                                        id="all-problem-type" />
                                                                    <label class="form-check-label"
                                                                        for="all-problem-type">
                                                                        Semua
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-3 mb-5 fw-bolder">
                                                            Sub Kategori
                                                        </div>
                                                        <div class="col-lg-9 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <div class="w-100 me-3">
                                                                    <app-select-single v-model="single.subkategori"
                                                                        :disabled="!single.kategori.id || single.checkAllCaseCategory"
                                                                        :placeholder="'Pilih Sub Kategori'"
                                                                        :loading="pageStatus == 'subkategori-load'"
                                                                        :options="list_subkategori" :serverside="true"
                                                                        @change-search="getSubkategori">
                                                                    </app-select-single>
                                                                </div>
                                                                <div
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input"
                                                                        v-model="single.checkAllCaseCategory"
                                                                        type="checkbox" value=""
                                                                        id="all-case-category" />
                                                                    <label class="form-check-label"
                                                                        for="all-case-category">
                                                                        Semua
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="d-flex justify-content-center mt-5">
                                                        <button class="btn btn-light me-3"
                                                            @click="preview">Preview</button>
                                                        <button class="btn btn-primary" @click="excel"
                                                            :disabled="pageStatus == 'form-export'">
                                                            <template v-if="pageStatus == 'form-export'">
                                                                Memproses...
                                                            </template>
                                                            <template v-else>
                                                                &ensp;
                                                                <svg width="21" height="21" viewBox="0 0 21 21"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M2.16675 11.3333C2.16675 10.9167 2.58341 10.5 3.00008 10.5C3.41675 10.5 3.83341 10.9167 3.83341 11.3333C3.83341 11.6111 3.83341 13 3.83341 15.5C3.83341 16.4205 4.57961 17.1667 5.50008 17.1667H15.5001C16.4206 17.1667 17.1667 16.4205 17.1667 15.5V11.3333C17.1667 10.8731 17.5398 10.5 18.0001 10.5C18.4603 10.5 18.8334 10.8731 18.8334 11.3333V15.5C18.8334 17.3409 17.341 18.8333 15.5001 18.8333H5.50008C3.65913 18.8333 2.16675 17.3409 2.16675 15.5C2.16675 13 2.16675 11.6111 2.16675 11.3333Z"
                                                                        fill="white" />
                                                                    <path
                                                                        d="M9.66659 12.1667C9.66659 12.6269 10.0397 13 10.4999 13C10.9602 13 11.3333 12.6269 11.3333 12.1667L11.3333 2.16667C11.3333 1.70643 10.9602 1.33333 10.4999 1.33333C10.0397 1.33333 9.66659 1.70643 9.66659 2.16667L9.66659 12.1667Z"
                                                                        fill="white" />
                                                                    <path
                                                                        d="M14.0774 8.24668C14.4028 7.92124 14.9305 7.92124 15.2559 8.24668C15.5814 8.57212 15.5814 9.09975 15.2559 9.42519L11.0893 13.5919C10.7759 13.9053 10.272 13.9185 9.94253 13.622L5.77586 9.87201C5.43377 9.56413 5.40604 9.03722 5.71392 8.69513C6.0218 8.35304 6.54871 8.32531 6.8908 8.63319L10.4698 11.8543L14.0774 8.24668Z"
                                                                        fill="white" />
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
                pageStatus: 'standby',
                list_kategori: [],
                list_subkategori: [],
                single: {
                    type: '',
                    startYear: '',
                    endYear: '',
                    startMonth: '',
                    endMonth: '',
                    kategori: {},
                    subkategori: {},

                    checkAllProblemType: false,
                    checkAllCaseCategory: false,
                }


            }

        },
        watch: {
            'single.type': function () {
                this.single.startYear = '';
                this.single.endYear = '';

                this.single.startMonth = '';
                this.single.endMonth = '';

                this.single.kategori = {};
                this.single.subkategori = {};

                this.single.checkAllProblemType = false;
                this.single.checkAllCaseCategory = false;
            },
            'single.checkAllProblemType': function () {
                if (this.single.checkAllProblemType) {
                    this.single.kategori = {};
                    this.single.subkategori = {};
                }
            },
            'single.checkAllCaseCategory': function () {
                if (this.single.checkAllCaseCategory) {
                    this.single.subkategori = {};
                }
            },
            "single.kategori": function () {
                this.single.subkategori = {};
            }

        },
        mounted() {
            reinitializeAllPlugin();
        },
        methods: {
            preview() {
                if (!this.single.type) {
                    this.$toast.info('Pilih tipe dahulu!');
                    return false;
                }
                if (this.single.type == 'year') {
                    if (!this.single.startYear) {
                        this.$toast.info('Tahun awal tidak boleh kosong!');
                        return false;
                    }
                    if (!this.single.endYear) {
                        this.$toast.info('Tahun akhir tidak boleh kosong!');
                        return false;
                    }
                } else {
                    if (!this.single.startMonth) {
                        this.$toast.info('Tahun awal tidak boleh kosong!');
                        return false;
                    }
                    if (!this.single.endMonth) {
                        this.$toast.info('Tahun akhir tidak boleh kosong!');
                        return false;
                    }
                }

                this.$router.push({
                    name: 'laporan-kasus-klien-preview',
                    query: {
                        type: this.single.type,
                        startYear: this.single.startYear,
                        endYear: this.single.endYear,
                        startMonth: this.single.startMonth,
                        endMonth: this.single.endMonth,
                        kategori: this.single.kategori.id ? this.single.kategori.id : '',
                        subkategori: this.single.subkategori.id ? this.single.subkategori.id : '',

                    }
                })
            },
            excel() {

                if (!this.single.type) {
                    this.$toast.info('Pilih tipe dahulu!');
                    return false;
                }
                let urlX = '';
                if (this.single.type == 'year') {
                    urlX = 'databasepeserta/rekap-tahunan';
                    if (!this.single.startYear) {
                        this.$toast.info('Tahun awal tidak boleh kosong!');
                        return false;
                    }
                    if (!this.single.endYear) {
                        this.$toast.info('Tahun akhir tidak boleh kosong!');
                        return false;
                    }
                } else {
                    urlX = 'databasepeserta/rekap-bulanan';
                    if (!this.single.startMonth) {
                        this.$toast.info('Tahun awal tidak boleh kosong!');
                        return false;
                    }
                    if (!this.single.endMonth) {
                        this.$toast.info('Tahun akhir tidak boleh kosong!');
                        return false;
                    }
                }
                let formData = {
                    is_download: 1
                }

                if (this.single.startYear) {
                    Object.assign(formData, {
                        tahun_awal: this.single.startYear
                    });
                }

                if (this.single.endYear) {
                    Object.assign(formData, {
                        tahun_akhir: this.single.endYear
                    });
                }
                if (this.single.startMonth) {
                    Object.assign(formData, {
                        bulan_awal: this.single.startMonth
                    });
                }

                if (this.single.endMonth) {
                    Object.assign(formData, {
                        bulan_akhir: this.single.endMonth
                    });
                }

                if (this.single.kategori.id) {
                    Object.assign(formData, {
                        id_kategori: this.single.kategori.id
                    });
                }

                if (this.single.subkategori.id) {
                    Object.assign(formData, {
                        id_subkategori: this.single.subkategori.id
                    });
                }

                this.pageStatus = 'form-export';

                let fileName = this.single.type == 'year' ? 'Laporan Rekap Tahunan E-Learning.xlsx' : 'Laporan Rekap Bulanan E-Learning.xlsx';
                Api().get(urlX, {
                    responseType: 'blob',
                    params: formData
                }).then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', fileName);
                    document.body.appendChild(link);
                    link.click();
                }).catch(error => {
                    this.$axioshandler(error);
                }).then(() => {
                    this.pageStatus = 'standby';
                    this.disabledButton = false;
                });
            },
            getKategori(keyword, limit) {

                this.pageStatus = 'kategori-load';

                Api().get(`kategori/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.list_kategori = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_kategori.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.list_kategori = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getSubkategori(keyword, limit) {

                this.pageStatus = 'subkategori-load';

                let idTipePermasalahan = this.single.kategori.id;

                Api().get(
                        `subkategori/lists?limit=${limit}&search=${keyword}&id_kategori=${idTipePermasalahan}`
                    )
                    .then(response => {

                        this.list_subkategori = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_subkategori.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.list_subkategori = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
        }
    }

</script>

<style scoped>

</style>
