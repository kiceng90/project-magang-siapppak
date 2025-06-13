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
                                                    style="font-size:20px !important;">Master Kelurahan</span>
                                            </h3>
                                            <button type="button" class="btn btn-sm bg-primary-custom"
                                                @click="showModalAdd">
                                                <span class="text-white">Tambah Data</span>
                                            </button>

                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row mb-3">
                                                <div class="col-lg-2 pb-5">
                                                    <div style="font-size:20px;font-weight:600;" class="pt-2">Filter
                                                        Data</div>
                                                </div>
                                                <div class="col-lg-5 pb-5">
                                                    <app-select-single v-model="single.filter.kecamatan"
                                                        :show_button_clear="false" :placeholder="'Pilih Kecamatan'"
                                                        :options="filter_list_kecamatan_computed" :serverside="true"
                                                        :loading="pageStatus == 'kecamatan-load'"
                                                        @change-search="getKecamatan"
                                                        @option-change="tableConfig.config.current_page = 1; getDataTable()">
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-5 pb-5">
                                                    <app-select-single v-model="single.filter.wilayah"
                                                        :show_button_clear="false" :placeholder="'Pilih Wilayah'"
                                                        :options="filter_list_wilayah_computed" :serverside="true"
                                                        :loading="pageStatus == 'wilayah-load'"
                                                        @change-search="getWilayah"
                                                        @option-change="tableConfig.config.current_page = 1; getDataTable()">
                                                    </app-select-single>
                                                </div>
                                            </div>
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
                                                        <td class="text-left">{{context.name}}</td>
                                                        <td class="text-left">
                                                            <div style="font-size:15px">{{context.kecamatan_name}}</div>
                                                            <div class="text-gray-500 pt-1">{{context.wilayah_name}}
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="text-center w-100">
                                                                <div
                                                                    class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                                                    <input class="form-check-input h-20px w-40px"
                                                                        type="checkbox" value="1"
                                                                        :checked="context.is_active"
                                                                        @click="changeStatus(context.id)" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center flex-wrap">
                                                                <div class="action-datatable-column m-2"
                                                                    @click="edit(context.id)" style="cursor:pointer">

                                                                    <svg width="17" height="16" viewBox="0 0 17 16"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M4.10953 15.3575L2.38436 15.9331C2.17711 16.0021 1.95475 16.012 1.74217 15.9618C1.5296 15.9116 1.33518 15.8033 1.18069 15.6489C1.02619 15.4945 0.917705 15.3001 0.867372 15.0876C0.817038 14.875 0.826838 14.6527 0.895682 14.4454L1.47135 12.7193L4.10953 15.3575ZM2.79043 8.762L8.06678 14.0383L16.6413 5.46382L11.3649 0.1875L2.79043 8.762Z"
                                                                            fill="#50CD89" />
                                                                    </svg>

                                                                </div>
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

        <div class="modal fade" tabindex="-1" id="modal-form">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{flag == 'insert' ? 'Tambah Data Kelurahan' : 'Edit Data Kelurahan'}}</h5>
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
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.kecamatan.$error ? 'text-danger' : ''">Nama Kecamatan</label>
                            <app-select-single v-model="single.kecamatan" :placeholder="'Pilih Kecamatan'"
                                :loading="pageStatus == 'kecamatan-load'" :options="list_kecamatan" :serverside="true"
                                @change-search="getKecamatan">
                            </app-select-single>
                            <div v-if="v$.single.kecamatan.$error" class="text-danger">Kecamatan tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.name.$error ? 'text-danger' : ''">Nama Kelurahan</label>
                            <input class="form-control" type="text" placeholder="Masukkan nama kelurahan"
                                autocomplete="off" v-model="single.name" :loading="pageStatus == 'kecamatan-load'" />
                            <div v-if="v$.single.name.$error" class="text-danger">>Nama Kelurahan tidak boleh kosong!
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                        <button v-if="flag == 'insert'" @click="save"
                            class="btn btn-sm bg-second-primary-custom text-white" type="button">
                            Simpan
                        </button>
                        <button v-if="flag == 'update'" @click="update"
                            class="btn btn-sm bg-second-primary-custom text-white" type="button">
                            Simpan
                        </button>
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
        required
    } from '@vuelidate/validators'
    export default {
        data() {
            return {
                v$: useVuelidate(),
                pageStatus: 'standby',
                flag: 'insert',
                list_kecamatan: [],
                list_wilayah: [],
                single: {
                    id: '',
                    name: '',
                    kecamatan: {},
                    filter: {
                        kecamatan: {
                            id: '0',
                            text: 'Semua Kecamatan'
                        },
                        wilayah: {
                            id: '0',
                            text: 'Semua Wilayah'
                        },
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
                                text: 'NAMA KELURAHAN',
                                sort_by: 'name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'NAMA KECAMATAN',
                                sort_by: 'kecamatan_name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'STATUS',
                                sort_by: 'is_active',
                                sort_column: true,
                                style: 'text-align: center',
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
        computed: {
            filter_list_kecamatan_computed() {
                let response = [];

                response.push({
                    id: '0',
                    text: 'Semua Kecamatan'
                });

                for (let i = 0; i < this.list_kecamatan.length; i++) {
                    response.push(this.list_kecamatan[i]);
                }

                return response;
            },
            filter_list_wilayah_computed() {
                let response = [];

                response.push({
                    id: '0',
                    text: 'Semua Wilayah'
                });

                for (let i = 0; i < this.list_wilayah.length; i++) {
                    response.push(this.list_wilayah[i]);
                }

                return response;
            }
        },
        validations() {
            return {
                single: {
                    name: {
                        required
                    },
                    kecamatan: {
                        required
                    },
                },
            }
        },
        mounted() {
            reinitializeAllPlugin();
            this.getDataTable();

        },
        methods: {
            showModalAdd() {
                this.reset();

                $("#modal-form").modal('show');
            },
            edit(id) {
                this.reset();

                this.flag = 'update';

                const index = this.tableConfig.feeder.data.findIndex((e) => e.id == id);
                if (index >= 0) {
                    this.single.id = this.tableConfig.feeder.data[index].id;
                    this.single.name = this.tableConfig.feeder.data[index].name;

                    if (this.tableConfig.feeder.data[index].id_kecamatan && this.tableConfig.feeder.data[index]
                        .kecamatan_name) {
                        this.single.kecamatan = {
                            id: this.tableConfig.feeder.data[index].id_kecamatan,
                            text: this.tableConfig.feeder.data[index].kecamatan_name
                        };
                    }
                    $("#modal-form").modal('show');
                }
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

                if (this.single.filter.kecamatan && this.single.filter.kecamatan.id != '0') {
                    Object.assign(params, {
                        id_kecamatan: this.single.filter.kecamatan.id
                    })
                }

                if (this.single.filter.wilayah && this.single.filter.wilayah.id != '0') {
                    Object.assign(params, {
                        id_wilayah: this.single.filter.wilayah.id
                    })
                }

                Api().get(`m-kelurahan`, {
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
            save() {
                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }

                this.$ewpLoadingShow();

                let formData = {
                    name: this.single.name,
                    id_kecamatan: this.single.kecamatan.id,
                }


                Api().post('m-kelurahan', formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Menambahkan data kelurahan',
                            icon: "success",
                        }).then(result => {

                            this.tableConfig.config.current_page = 1;

                            this.getDataTable();

                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            update() {

                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }

                let formData = {
                    name: this.single.name,
                    id_kecamatan: this.single.kecamatan.id,
                }

                this.$ewpLoadingShow();

                Api().put(`m-kelurahan/${this.single.id}`, formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Memperbarui data kelurahan',
                            icon: "success",
                        }).then(result => {
                            this.getDataTable();
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            changeStatus(id) {
                this.$ewpLoadingShow();
                Api().put(`m-kelurahan/${id}/switch-status`)
                    .then(response => {
                        this.$toast.success("Status berhasil diubah!");
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                        this.getDataTable();
                    }).then(() => {
                        this.$ewpLoadingHide();
                    })
            },
            getKecamatan(keyword, limit) {

                this.pageStatus = 'kecamatan-load';

                Api().get(`m-kecamatan/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.list_kecamatan = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_kecamatan.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getWilayah(keyword, limit) {

                this.pageStatus = 'wilayah-load';

                Api().get(`m-wilayah/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.list_wilayah = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_wilayah.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            reset() {
                this.v$.$reset();

                this.flag = 'insert';

                this.single.id = '';
                this.single.name = '';
                this.single.kecamatan = {};
            }
        }
    }

</script>

<style scoped>

</style>
