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
                                                    style="font-size:20px !important;">Master Data Klien</span>
                                            </h3>
                                        </div>
                                        <div class="card-body pt-5">
                                            <app-datatable-serverside :table_config="tableConfig"
                                                @change-page="getDataTable"
                                                v-model:show_per_page="tableConfig.config.show_per_page"
                                                v-model:search="tableConfig.config.search"
                                                v-model:order="tableConfig.config.order"
                                                v-model:sort_by="tableConfig.config.sort_by"
                                                v-model:current_page="tableConfig.config.current_page">
                                                <template v-slot:body>
                                                    <tr v-for="(context, index) in tableConfig.feeder.data">
                                                        <td class="text-center">{{index + 1}}</td>
                                                        <td class="text-left">
                                                            <div>{{context.name}}</div>
                                                            <div class="text-gray-600">{{context.nik}}</div>
                                                            <div class="pt-2">{{context?.alamat}}</div>
                                                            <div class="text-gray-600">{{context.kelurahan_name}},
                                                                {{context.kecamatan_name}}
                                                            </div>
                                                        </td>
                                                        <td class="text-left">
                                                            <template v-for="konselor in context.konselor">
                                                                - {{konselor.name}}<br>
                                                            </template>
                                                        </td>
                                                        <td class="text-left">{{context?.phone_number}}</td>
                                                        <td class="text-left">
                                                            {{context?.kategori == 1 ? 'Anak-anak' : 'Dewasa'}}</td>
                                                        <td class="text-center">
                                                            <div class="dropdown" style="position:static !important;">
                                                                <button class="btn btn-secondary btn-xs dropdown-toggle"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    style="padding:5px 10px !important;"
                                                                    aria-expanded="false">
                                                                    Aksi
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="history(context.id)">Histori
                                                                            Kasus</a></li>
                                                                    <li
                                                                        v-if="canAccessPenangananKasus.filter((e) => e == $store.state.profile.role_id).length > 0">
                                                                        <a class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="showModalAdd(1, context.id)">Pendampingan
                                                                            Lanjutan</a></li>
                                                                    <li v-if="canAccessPenangananKasus.filter((e) => e == $store.state.profile.role_id).length > 0"><a class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="showModalAdd(2, context.id)">Monitoring</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item py-3"
                                                                            v-if="context.id_pengaduan"
                                                                            href="javascript:void(0);"
                                                                            @click="redirectCetak(context.id_pengaduan)">Cetak
                                                                            Kasus</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </app-datatable-serverside>
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


        <div class="modal fade" tabindex="-1" id="modal-form-history-penanganan">
            <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:1100px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Penanganan
                            Kasus</h5>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon-2x">

                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.88 15.9996L23.6134 10.2796C23.8644 10.0285 24.0055 9.688 24.0055 9.33293C24.0055 8.97786 23.8644 8.63733 23.6134 8.38626C23.3623 8.13519 23.0218 7.99414 22.6667 7.99414C22.3116 7.99414 21.9711 8.13519 21.72 8.38626L16 14.1196L10.28 8.38626C10.029 8.13519 9.68844 7.99414 9.33337 7.99414C8.97831 7.99414 8.63778 8.13519 8.38671 8.38626C8.13564 8.63733 7.99459 8.97786 7.99459 9.33293C7.99459 9.688 8.13564 10.0285 8.38671 10.2796L14.12 15.9996L8.38671 21.7196C8.26174 21.8435 8.16254 21.991 8.09485 22.1535C8.02716 22.316 7.99231 22.4902 7.99231 22.6663C7.99231 22.8423 8.02716 23.0166 8.09485 23.179C8.16254 23.3415 8.26174 23.489 8.38671 23.6129C8.51066 23.7379 8.65813 23.8371 8.8206 23.9048C8.98308 23.9725 9.15736 24.0073 9.33337 24.0073C9.50939 24.0073 9.68366 23.9725 9.84614 23.9048C10.0086 23.8371 10.1561 23.7379 10.28 23.6129L16 17.8796L21.72 23.6129C21.844 23.7379 21.9915 23.8371 22.1539 23.9048C22.3164 23.9725 22.4907 24.0073 22.6667 24.0073C22.8427 24.0073 23.017 23.9725 23.1795 23.9048C23.342 23.8371 23.4894 23.7379 23.6134 23.6129C23.7383 23.489 23.8375 23.3415 23.9052 23.179C23.9729 23.0166 24.0078 22.8423 24.0078 22.6663C24.0078 22.4902 23.9729 22.316 23.9052 22.1535C23.8375 21.991 23.7383 21.8435 23.6134 21.7196L17.88 15.9996Z"
                                        fill="black" />
                                </svg>

                            </span>
                        </div>
                    </div>

                    <div class="modal-body">


                        <div class="row mb-5 pb-5">
                            <div class="col-lg-12 mb-5">
                                <!--begin::Radio group-->
                                <div data-kt-buttons="true" class="row">
                                    <!--begin::Radio button-->
                                    <div class="col-lg-6 p-5">
                                        <label
                                            class=" btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div
                                                    class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                    <input class="form-check-input" type="radio"
                                                        name="form-history-penanganan"
                                                        v-model="single.formHistoryPenanganan.type" value="1" />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center fs-3 fw-bolder flex-wrap">
                                                        Pendampingan Lanjutan
                                                    </h2>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                    </div>
                                    <div class="col-lg-6 p-5">
                                        <label
                                            class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div
                                                    class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                    <input class="form-check-input" type="radio"
                                                        name="form-history-penanganan"
                                                        v-model="single.formHistoryPenanganan.type" value="2" />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center fs-3 fw-bolder flex-wrap">
                                                        Monitoring/Home Visit
                                                    </h2>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                    </div>
                                    <!--end::Radio button-->

                                </div>
                                <!--end::Radio group-->
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder"
                                :class="v$.single.formHistoryPenanganan.date.$error ? 'text-danger' : ''"
                                v-show="single.formHistoryPenanganan.type">
                                Tanggal Pelayanan
                            </div>
                            <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.type">
                                <app-datepicker type="date" placeholder="Pilih tanggal" :format="'DD-MM-YYYY'"
                                    :value-type="'YYYY-MM-DD'" v-model:value="single.formHistoryPenanganan.date">
                                </app-datepicker>
                                <div v-if="v$.single.formHistoryPenanganan.date.$error" class="text-danger"> Tanggal
                                    tidak boleh kosong!
                                </div>
                            </div>
                            <template
                                v-if="single.formHistoryPenanganan.type == 1 || single.formHistoryPenanganan.type == 2">
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.service.$error ? 'text-danger' : ''"
                                    v-show="single.formHistoryPenanganan.type">
                                    Pelayanan Yang Diberikan
                                </div>
                                <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.type">
                                    <app-select-single v-model="single.formHistoryPenanganan.service"
                                        @option-change="single.formHistoryPenanganan.shelter_type = ''"
                                        :loading="pageStatus == 'service-load'" :placeholder="'Pilih Pelayanan'"
                                        :options="listService" @change-search="getService" :serverside="true">
                                    </app-select-single>
                                    <div v-if="v$.single.formHistoryPenanganan.service.$error" class="text-danger">
                                        Pelayanan
                                        tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.shelter_type.$error ? 'text-danger' : ''"
                                    v-show="single.formHistoryPenanganan.service.id == 5">
                                    Kebutuhan Shelter
                                </div>
                                <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.service.id == 5">
                                    <div class="d-flex flex-wrap">
                                        <div class="form-check form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="radio" value="1" name="shelter-type"
                                                v-model="single.formHistoryPenanganan.shelter_type" id="shelter1" />
                                            <label class="form-check-label" for="shelter1">
                                                Shelter ABH
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="radio" value="2" name="shelter-type"
                                                v-model="single.formHistoryPenanganan.shelter_type" id="shelter2" />
                                            <label class="form-check-label" for="shelter2">
                                                Shelter Anak Perempuan
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="radio" value="3" name="shelter-type"
                                                v-model="single.formHistoryPenanganan.shelter_type" id="shelter3" />
                                            <label class="form-check-label" for="shelter3">
                                                Shelter Perempuan
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="4" name="shelter-type"
                                                v-model="single.formHistoryPenanganan.shelter_type" id="shelter4" />
                                            <label class="form-check-label" for="shelter4">
                                                Shelter LSM/LKSA/Fasilitas Lainnya
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if="v$.single.formHistoryPenanganan.shelter_type.$error" class="text-danger">
                                        Pilih Salah Satu!
                                    </div>
                                </div>
                            </template>
                            <template v-if="single.formHistoryPenanganan.type == 3">
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.need.$error ? 'text-danger' : ''">
                                    Pelayanan Yang Diberikan
                                </div>
                                <div class="col-lg-9 mb-5">
                                    <app-select-single v-model="single.formHistoryPenanganan.need"
                                        :loading="pageStatus == 'need-load'" :placeholder="'Pilih Kebutuhan'"
                                        :options="listNeed" @change-search="getNeed" :serverside="true">
                                    </app-select-single>
                                    <div v-if="v$.single.formHistoryPenanganan.need.$error" class="text-danger">
                                        Kebutuhan
                                        tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.opd.$error ? 'text-danger' : ''">
                                    OPD/Instansi Rujukan
                                </div>
                                <div class="col-lg-9 mb-5">
                                    <app-select-single v-model="single.formHistoryPenanganan.opd"
                                        @option-change="single.formHistoryPenanganan.intervensi = {}"
                                        :loading="pageStatus == 'opd-load'" :placeholder="'Pilih OPD'"
                                        :options="listOPD" @change-search="getOPD" :serverside="true">
                                    </app-select-single>
                                    <div v-if="v$.single.formHistoryPenanganan.opd.$error" class="text-danger">
                                        OPD
                                        tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.intervensi.$error ? 'text-danger' : ''">
                                    Pelayanan Yang Diberikan(Intervensi)
                                </div>
                                <div class="col-lg-9 mb-5">
                                    <app-select-single :disabled="!single.formHistoryPenanganan.opd.id"
                                        v-model="single.formHistoryPenanganan.intervensi"
                                        :loading="pageStatus == 'intervensi-load'" :placeholder="'Pilih Pelayanan'"
                                        :options="listIntervensi" @change-search="getIntervensi" :serverside="true">
                                    </app-select-single>
                                    <div v-if="v$.single.formHistoryPenanganan.intervensi.$error" class="text-danger">
                                        Pelayanan
                                        tidak boleh kosong!
                                    </div>
                                </div>
                            </template>
                            <div class="col-lg-3 mb-5 fw-bolder"
                                :class="v$.single.formHistoryPenanganan.note.$error ? 'text-danger' : ''"
                                v-show="single.formHistoryPenanganan.type">
                                Deskripsi Pelayanan Yang Diberikan
                            </div>
                            <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.type">
                                <app-editor v-model:content="single.formHistoryPenanganan.note" ref="editor" contentType="html"></app-editor>
                                <div v-if="v$.single.formHistoryPenanganan.note.$error" class="text-danger"> Deskripsi
                                    tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder" v-show="single.formHistoryPenanganan.type">
                                Dokumen Pendukung
                            </div>
                            <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.type">

                                <div class="dropzone dropzone-file-area dz-clickable"
                                    :id="`dropzone-form-history-penanganan`">
                                    <div class="dz-message needsclick">
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <div class="ms-4">
                                            <h5 class="kt-dropzone__msg-title">Drop
                                                files here or
                                                click
                                                to upload</h5>
                                            <span class="kt-dropzone__msg-desc text-primary">
                                                Upload up to 10 files with the
                                                format
                                                .jpg/.jpeg/.png/.pdf
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button @click="saveHistoryPenanganan" class="btn btn-sm bg-second-primary-custom text-white"
                            type="button">
                            Simpan
                        </button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Api from "@/services/api";
    import useVuelidate from '@vuelidate/core'
    import {
        required,
        requiredIf
    } from '@vuelidate/validators'
    export default {
        data() {
            return {
                canAccessPenangananKasus: [process.env.MIX_ROLE_ADMIN_ID, process.env.MIX_ROLE_KABID_ID, process.env
                    .MIX_ROLE_KONSELOR_ID, process.env.MIX_ROLE_SUBKORD_ID
                ],
                v$: useVuelidate(),
                pageStatus: 'standby',
                listService: [],
                listNeed: [],
                listOPD: [],
                listIntervensi: [],
                single: {
                    formHistoryPenanganan: {
                        clientId: '',
                        type: '',
                        date: '',
                        service: {},
                        shelter_type: '',
                        need: {},
                        opd: {},
                        intervensi: {},
                        note: '',
                        dropzoneUpload: null,
                    }
                },
                tableConfig: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                            {
                                text: 'KLIEN - NIK',
                                sort_by: 'name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'KONSELOR',
                                sort_column: false,
                                style: 'text-align: left',
                            },
                            {
                                text: 'TELEPON',
                                sort_by: 'phone_number',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'KATEGORI',
                                sort_by: 'kategori',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'AKSI',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                        ],

                        data: [],
                    },
                    config: {
                        title: 'Datatable',
                        show_per_page: 10,
                        search: '',
                        order: 'desc',
                        sort_by: 'id',
                        total_data: 2,
                        current_page: 1,
                        loading: false,
                        show_search: true,
                    }
                },
            }

        },
        validations() {
            return {
                single: {
                    formHistoryPenanganan: {
                        type: {
                            required
                        },
                        service: {
                            required: requiredIf(function () {
                                return (this.single.formHistoryPenanganan.type == 1 || this.single
                                    .formHistoryPenanganan.type == 2);
                            })
                        },
                        shelter_type: {
                            required: requiredIf(function () {
                                return (this.single.formHistoryPenanganan.type == 1 || this.single
                                        .formHistoryPenanganan.type == 2) && this.single
                                    .formHistoryPenanganan.service.id == 5;
                            })
                        },
                        date: {
                            required
                        },
                        note: {
                            required
                        },
                        need: {
                            required: requiredIf(function () {
                                return this.single.formHistoryPenanganan.type == 3;
                            })
                        },
                        opd: {
                            required: requiredIf(function () {
                                return this.single.formHistoryPenanganan.type == 3;
                            })
                        },
                        intervensi: {
                            required: requiredIf(function () {
                                return this.single.formHistoryPenanganan.type == 3;
                            })
                        }
                    }
                }
            }
        },
        watch: {
            'single.formHistoryPenanganan.type': function () {
                this.single.formHistoryPenanganan.service = {};
                this.single.formHistoryPenanganan.shelter_type = '';
                this.single.formHistoryPenanganan.need = {};
                this.single.formHistoryPenanganan.opd = {};
                this.single.formHistoryPenanganan.intervensi = {};
            }
        },
        beforeRouteLeave(to, from, next) {
            this.single.formHistoryPenanganan.dropzoneUpload.destroy();
            next();
        },
        mounted() {
            reinitializeAllPlugin();

            this.initDropzone();
            this.getDataTable();
        },
        methods: {
            initDropzone() {
                const that = this;
                this.single.formHistoryPenanganan.dropzoneUpload = new Dropzone("#dropzone-form-history-penanganan", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 20,
                    parallelUploads: 1,
                    uploadMultiple: false,
                    maxFiles: 10,
                    addRemoveLinks: true,
                    acceptedFiles: '.png,.jpg,.jpeg,.pdf',
                    autoProcessQueue: false,
                    init: function () {
                        this.on("error", function (file) {
                            if (!file.accepted) {
                                this.removeFile(file);
                                that.$swal('Silahkan periksa file Anda lagi');
                            } else if (file.status == 'error') {
                                this.removeFile(file);
                                that.$swal('Terjadi kesalahan koneksi');
                            }
                        });

                        this.on('resetFiles', function (file) {
                            this.removeAllFiles();
                        });
                    },
                });
            },
            history(id) {
                this.$router.push({ 
                    name: 'klien-history-kasus', 
                    params: { id: id }}
                )
            },
            getDataTable() {
                this.tableConfig.config.loading = true;
                this.tableConfig.feeder.data = [];

                let params = {
                    page: this.tableConfig.config.current_page,
                    limit: this.tableConfig.config.show_per_page,
                    sortby: this.tableConfig.config.sort_by,
                    order: this.tableConfig.config.order,
                    search: this.tableConfig.config.search
                }

                Api().get(`daftar-klien`, {
                        params
                    })
                    .then(response => {

                        let data = response.data.data;
                        this.tableConfig.feeder.data = data;
                        this.tableConfig.config.total_data = response.data.total;

                        this.tableConfig.config.loading = false;
                    })
                    .catch(error => {

                        this.tableConfig.config.loading = false;

                        this.tableConfig.feeder.data = [];
                        this.tableConfig.config.total_data = 0;

                        this.$axiosHandleError(error);
                    });
            },
            redirectCetak(id) {
                this.$router.push({ 
                    name: 'pengaduan-cetak', 
                    params: { id: id }}
                )
            },
            showModalAdd(type, clientId) {
                this.reset();

                this.single.formHistoryPenanganan.type = type;
                this.single.formHistoryPenanganan.clientId = clientId;
                $("#modal-form-history-penanganan").modal('show');
            },
            saveHistoryPenanganan() {
                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }

                let formData = new FormData();

                let filesUpload = []
                if (!$.isEmptyObject(this.single.formHistoryPenanganan.dropzoneUpload.files)) {
                    for (let file in this.single.formHistoryPenanganan.dropzoneUpload.files) {
                        filesUpload.push(this.single.formHistoryPenanganan.dropzoneUpload.files[file])
                    }
                }
                
                formData.append('tipe_penanganan', this.single.formHistoryPenanganan.type);
                formData.append('tanggal_pelayanan', this.single.formHistoryPenanganan.date);
                formData.append('deskripsi', this.single.formHistoryPenanganan.note);
                if (this.single.formHistoryPenanganan.type == 1 || this.single.formHistoryPenanganan.type == 2) {
                    formData.append('id_pelayanan', this.single.formHistoryPenanganan.service.id);
                }

                if (this.single.formHistoryPenanganan.type == 3) {
                    formData.append('id_kebutuhan', this.single.formHistoryPenanganan.need.id);
                    formData.append('id_opd', this.single.formHistoryPenanganan.opd.id);
                    formData.append('id_intervensi', this.single.formHistoryPenanganan.intervensi.id);
                }

                if (filesUpload.length > 0) {
                    for (let x = 0; x < filesUpload.length; x++) {
                        let fileX = filesUpload[x]
                        formData.append('dokumen[]', fileX);
                    }
                }

                this.$ewpLoadingShow();
                Api().post('daftar-klien/' + this.single.formHistoryPenanganan.clientId + '/penanganan-kasus', formData)
                    .then(response => {
                        $(".modal").modal('hide');
                        this.$swal({
                            title: "Berhasil!",
                            text: 'Menambahkan data penanganan kasus klien',
                            icon: "success",
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            getService(keyword, limit) {

                this.pageStatus = 'service-load';


                Api().get(`m-pelayanan/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {
                        this.listService = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listService.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listService = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getNeed(keyword, limit) {

                this.pageStatus = 'need-load';


                Api().get(`m-kebutuhan/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {
                        this.listNeed = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listNeed.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listNeed = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getOPD(keyword, limit) {

                this.pageStatus = 'opd-load';


                Api().get(`m-opd/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {
                        this.listOPD = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listOPD.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listOPD = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },

            getIntervensi(keyword, limit) {

                this.pageStatus = 'intervensi-load';


                Api().get(
                        `m-intervensi/lists?limit=${limit}&search=${keyword}&id_opd=${this.single.formHistoryPenanganan.opd.id}`
                    )
                    .then(response => {
                        this.listIntervensi = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listIntervensi.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listIntervensi = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            reset() {

                this.flagFormPenanganan = 'insert';

                this.pageStatus = 'standby';

                this.v$.$reset();

                this.single.formHistoryPenanganan.clientId = '';

                this.single.formHistoryPenanganan.type = '';
                this.single.formHistoryPenanganan.date = '';
                this.single.formHistoryPenanganan.service = {};
                this.single.formHistoryPenanganan.shelter_type = '';

                this.single.formHistoryPenanganan.need = {};
                this.single.formHistoryPenanganan.opd = {};
                this.single.formHistoryPenanganan.intervensi = {};

                this.single.formHistoryPenanganan.note = '';
                this.single.formHistoryPenanganan.existingFile = [];

                this.single.formHistoryPenanganan.dropzoneUpload.removeAllFiles(true);
                this.single.formHistoryPenanganan.dropzoneUpload.files = [];
            },
        }
    }

</script>

<style scoped>

</style>
