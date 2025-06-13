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
                                                    style="font-size:20px !important;">Master Konselor</span>
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
                                                        <td class="text-left">
                                                            <div class="d-flex align-items-center">
                                                                <img class="me-3" :src="context.foto"
                                                                    style="width:50px;height:50px;border-radius:5px;">
                                                                <div>{{context.name}}</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left">{{context.phone_number}}</td>
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
                            {{flag == 'insert' ? 'Tambah Data Konselor' : 'Edit Data Konselor'}}</h5>
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
                                :class="v$.single.name.$error ? 'text-danger' : ''">Nama Lengkap</label>
                            <input class="form-control" type="text" placeholder="Contoh: Nebi Agustina, S. Psi"
                                autocomplete="off" v-model="single.name" />
                            <div v-if="v$.single.name.$error" class="text-danger"> Nama Lengkap tidak boleh
                                kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.phone.$error ? 'text-danger' : ''">Nomor HP</label>
                            <input class="form-control" type="text" placeholder="Contoh: 081 234 567 890"
                                autocomplete="off" v-model="single.phone" />
                            <div v-if="v$.single.phone.$error" class="text-danger"> Nomor HP tidak boleh
                                kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6">Foto Konselor</label>
                            <div class="" style="position:relative;width:130px;">
                                <img class="mb-3" v-if="single.photo_path" :src="single.photo_path"
                                    style="width:130px;height:130px;">
                                <img class="mb-3" v-if="!single.photo_path"
                                    :src="$assetUrl() + 'extends/img/noimage.png'" style="width:130px;height:130px;">
                                <input :id="'input-file'" type="file" class="d-none" accept="image/*"
                                    @change="imageChange($event)">
                                <button class="btn d-flex align-items-center justify-content-center" type="button"
                                    style="padding:0 !important;border-radius:100px;width:40px;height:40px;background:#fff !important;;position:absolute;top:5px;right:-10px;box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important"
                                    @click="chooseFile">
                                    <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.22775 17.7066L15.5208 8.41364L11.1068 3.99964L1.81375 13.2926C1.68582 13.4207 1.59494 13.5811 1.55075 13.7566L0.520752 18.9996L5.76275 17.9696C5.93875 17.9256 6.09975 17.8346 6.22775 17.7066ZM18.5208 5.41364C18.8957 5.03858 19.1063 4.52996 19.1063 3.99964C19.1063 3.46931 18.8957 2.96069 18.5208 2.58564L16.9348 0.999635C16.5597 0.624693 16.0511 0.414062 15.5208 0.414062C14.9904 0.414062 14.4818 0.624693 14.1068 0.999635L12.5208 2.58564L16.9348 6.99964L18.5208 5.41364Z"
                                            fill="#7E8299" />
                                    </svg>

                                </button>
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
                    name: '',
                    phone: '',
                    photo_path: '',
                    photo_file: ''
                },
                tableConfig: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                            {
                                text: 'NAMA KONSELOR',
                                sort_by: 'name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'NOMOR HP',
                                sort_by: 'phone_number',
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
                    phone: {
                        required
                    }
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
                    this.single.phone = this.tableConfig.feeder.data[index].phone_number;
                    this.single.photo_path = this.tableConfig.feeder.data[index].foto;

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

                Api().get(`m-konselor`, {
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

                let formData = new FormData();
                formData.append('name', this.single.name ? this.single
                    .name : '')
                formData.append('phone_number', this.single.phone ? this.single
                    .phone : '')
                formData.append('foto', this.single.photo_file ? this.single.photo_file : '');


                Api().post('m-konselor', formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Menambahkan data konselor',
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

                let formData = new FormData();
                formData.append('name', this.single.name ? this.single
                    .name : '')
                formData.append('phone_number', this.single.phone ? this.single
                    .phone : '')
                formData.append('foto', this.single.photo_file ? this.single.photo_file : '');
                formData.append('_method', 'PUT');


                this.$ewpLoadingShow();

                Api().post(`m-konselor/${this.single.id}`, formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Memperbarui data konselor',
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
                Api().put(`m-konselor/${id}/switch-status`)
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
                this.single.phone = '';

                this.single.photo_path = '';
                this.single.photo_file = '';

                $('#input-file').val('');
            },
            chooseFile() {
                this.single.photo_path = '';
                this.single.photo_file = '';

                $('#input-file').val('');
                setTimeout(() => {
                    $('#input-file').click();
                }, 500);

            },
            imageChange(evt) {
                evt.preventDefault();
                evt.stopImmediatePropagation();

                const conteks = window.$(evt.target)
                const that = this;
                if (window.FileReader) {
                    const fileReader = new FileReader();
                    const files = document.getElementById(conteks.attr('id')).files;
                    if (!files.length) {
                        return;
                    }
                    const file = files[0];
                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            var files = evt.target.files || event.dataTransfer.files;
                            if (!files.length) {
                                return;
                            }

                            console.log(files[0]);
                            that.single.photo_path = fileReader.result;
                            that.single.photo_file = files[0];
                        };
                    } else {
                        this.$swal({
                            title: 'Peringatan!',
                            text: 'File yang anda pilih belum termasuk gambar!',
                            icon: 'warning',
                        })
                    }
                }
            },
        }
    }

</script>

<style scoped>

</style>
