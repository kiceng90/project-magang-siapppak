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
                                                    style="font-size:20px !important;">Master Wilayah Kota
                                                    Surabaya</span>
                                            </h3>
                                            <button type="button" class="btn btn-sm bg-primary-custom"
                                                @click="showModalAdd">
                                                <span class="text-white">Tambah Data</span>
                                            </button>

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
                                                        <td class="text-left">{{context.name}}</td>
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
                                                                    @click="edit(context.id, context.name)"
                                                                    style="cursor:pointer">

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
                            {{flag == 'insert' ? 'Tambah Data Wilayah' : 'Edit Data Wilayah'}}</h5>
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
                                :class="v$.single.name.$error ? 'text-danger' : ''">Nama Wilayah</label>
                            <input class="form-control" type="text" placeholder="Contoh: Surabaya Pusat"
                                autocomplete="off" v-model="single.name" />
                            <div v-if="v$.single.name.$error" class="text-danger"> Nama Wilayah tidak boleh kosong!
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
                flag: 'insert',
                single: {
                    id: '',
                    name: ''
                },
                tableConfig: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                            {
                                text: 'NAMA',
                                sort_by: 'name',
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
                        total_data: 0,
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
                    name: {
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
            edit(id, name) {
                this.reset();

                this.flag = 'update';

                this.single.id = id;
                this.single.name = name;

                $("#modal-form").modal('show');
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

                Api().get(`m-wilayah`, {
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
                    name: this.single.name
                }


                Api().post('m-wilayah', formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Menambahkan data wilayah',
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
                    name: this.single.name
                }

                this.$ewpLoadingShow();

                Api().put(`m-wilayah/${this.single.id}`, formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Memperbarui data wilayah',
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
                Api().put(`m-wilayah/${id}/switch-status`)
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
            reset() {
                this.v$.$reset();

                this.flag = 'insert';

                this.single.id = '';
                this.single.name = '';
            }
        }
    }

</script>

<style scoped>

</style>
