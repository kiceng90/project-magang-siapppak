<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <app-navbar></app-navbar>

                    <div id="main-content">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-xxl">
                                <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-header border-0 pt-5 align-items-center">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder text-dark mb-2" style="font-size: 20px !important;">
                                                    Master Materi Tes Rumah Perubahan
                                                </span>
                                            </h3>
                                            <button type="button" class="btn btn-sm bg-primary-custom" @click="showModalAdd">
                                                <span class="text-white">Tambah Data</span>
                                            </button>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row mb-3">
                                                <div class="col-lg-2 pb-5">
                                                    <div style="font-size: 20px; font-weight: 600;" class="pt-2">
                                                        Filter Data
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 pb-5">
                                                    <app-select-single
                                                        v-model="filter.kategori"
                                                        :show_button_clear="false"
                                                        placeholder="Kategori"
                                                        :options="filterKategoriOptions"
                                                        :serverside="true"
                                                        :loading="isLoadingKategori"
                                                        @change-search="getKategori"
                                                    >
                                                    </app-select-single>
                                                </div>
                                            </div>
                                            <app-datatable-serverside
                                                :table_config="tableConfig"
                                                @change-page="getDataTable"
                                                v-model:show_per_page="tableConfig.config.show_per_page"
                                                v-model:search="tableConfig.config.search"
                                                v-model:order="tableConfig.config.order"
                                                v-model:sort_by="tableConfig.config.sort_by"
                                                v-model:current_page="tableConfig.config.current_page"
                                            >
                                                <template v-slot:body>
                                                    <tr v-for="(item, index) in tableConfig.feeder.data" :key="item.id">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td class="text-left">{{ item.name }}</td>
                                                        <td class="text-left">{{ item.kategori.name }}</td>
                                                        <td class="text-center">
                                                            <div class="text-center w-100">
                                                                <div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                                                    <input
                                                                        class="form-check-input h-20px w-40px"
                                                                        type="checkbox"
                                                                        :checked="item.is_active"
                                                                        @click="changeStatus(item.id)"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="dropdown" style="position: static !important;">
                                                                <button
                                                                    class="btn btn-secondary btn-xs dropdown-toggle"
                                                                    type="button"
                                                                    data-bs-toggle="dropdown"
                                                                    style="padding: 5px 10px !important;"
                                                                    aria-expanded="false"
                                                                >
                                                                    Aksi
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <router-link
                                                                            class="dropdown-item py-3"
                                                                            :to="{
                                                                                name: 'm-rumahperubahan-latihansoal',
                                                                                params: { id: item.id },
                                                                            }"
                                                                        >
                                                                            Latihan Soal
                                                                        </router-link>
                                                                    </li>
                                                                    <li>
                                                                        <a
                                                                            class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="edit(item.id)"
                                                                        >
                                                                            Edit
                                                                        </a>
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
        
        <!-- Modal Form -->
        <div class="modal fade" tabindex="-1" id="modal-form">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ isEditMode ? "Edit Materi" : "Tambah Materi" }}
                        </h5>
                        <div
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            <span class="svg-icon-2x">
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
                        <label
                            class="form-label fw-bolder fs-6 mb-3"
                            :class="{ 'text-danger': v$.form.kategori.$error }"
                        >
                            Kategori
                        </label>
                        <app-select-single
                            v-model="form.kategori"
                            placeholder="Pilih Kategori"
                            :loading="isLoadingKategori"
                            :options="list_kategori"
                            :serverside="true"
                            @change-search="getKategori"
                        />
                        <div v-if="v$.form.kategori.$error" class="text-danger">
                            > Kategori tidak boleh kosong!
                        </div>
                        <div class="mb-5 mt-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="{ 'text-danger': v$.form.name.$error }"
                            >
                                Judul Materi
                            </label>
                            <input
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Judul Materi"
                                autocomplete="off"
                                v-model="form.name"
                            />
                            <div v-if="v$.form.name.$error" class="text-danger">
                                > Judul Materi tidak boleh kosong!
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-sm btn-light"
                            data-bs-dismiss="modal"
                        >
                            Batal
                        </button>
                        <button
                            @click="submitForm"
                            class="btn btn-sm bg-second-primary-custom text-white"
                            type="button"
                        >
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
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
    setup() {
        return {
            v$: useVuelidate()
        };
    },
    
    data() {
        return {
            isEditMode: false,
            isLoadingKategori: false,
            list_kategori: [],
            
            form: {
                id: "",
                name: "",
                kategori: {}
            },
            
            filter: {
                kategori: {
                    id: "0",
                    text: "Semua Kategori"
                }
            },
            
            tableConfig: {
                feeder: {
                    column: [
                        {
                            text: "NO",
                            sort_column: false,
                            style: "text-align: center"
                        },
                        {
                            text: "MATERI",
                            sort_by: "name",
                            sort_column: true,
                            style: "text-align: left"
                        },
                        {
                            text: "KATEGORI",
                            sort_by: "kategori",
                            sort_column: true,
                            style: "text-align: left"
                        },
                        {
                            text: "STATUS",
                            sort_column: false,
                            style: "text-align: center"
                        },
                        {
                            text: "AKSI",
                            sort_column: false,
                            style: "text-align: center"
                        }
                    ],
                    data: []
                },
                config: {
                    title: "Datatable",
                    show_per_page: 10,
                    search: "",
                    order: "desc",
                    sort_by: "id",
                    total_data: 0,
                    current_page: 1,
                    loading: false,
                    show_search: true
                }
            }
        };
    },
    
    computed: {
        filterKategoriOptions() {
            const options = [
                {
                    id: "0",
                    text: "Semua Kategori"
                }
            ];
            
            return [...options, ...this.list_kategori];
        }
    },
    
    validations() {
        return {
            form: {
                name: { required },
                kategori: { required }
            }
        };
    },
    
    mounted() {
        if (typeof reinitializeAllPlugin === 'function') {
            reinitializeAllPlugin();
        }
        this.getDataTable();
    },
    
    methods: {
        showModalAdd() {
            this.resetForm();
            this.isEditMode = false;
            $("#modal-form").modal("show");
        },
        
        edit(id) {
            this.resetForm();
            this.isEditMode = true;
            
            const item = this.tableConfig.feeder.data.find(item => item.id === id);
            
            if (item) {
                this.form.id = item.id;
                this.form.name = item.name;
                
                if (item.kategori?.id && item.kategori?.name) {
                    this.form.kategori = {
                        id: item.kategori.id,
                        text: item.kategori.name
                    };
                }
                
                $("#modal-form").modal("show");
            }
        },
        
        getDataTable() {
            this.tableConfig.config.loading = true;
            this.tableConfig.feeder.data = [];
            
            const params = {
                page: this.tableConfig.config.current_page,
                limit: this.tableConfig.config.show_per_page,
                sortby: this.tableConfig.config.sort_by,
                order: this.tableConfig.config.order,
                search: this.tableConfig.config.search
            };
            
            if (this.filter.kategori?.id !== "0") {
                params.id_kategori = this.filter.kategori.id;
            }
            
            Api()
                .get("m-materi-rumah-perubahan", { params })
                .then(response => {
                    this.tableConfig.feeder.data = response.data.data;
                    this.tableConfig.config.total_data = response.data.total;
                })
                .catch(error => {
                    this.tableConfig.feeder.data = [];
                    this.tableConfig.config.total_data = 0;
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.tableConfig.config.loading = false;
                });
        },
        
        submitForm() {
            this.v$.$touch();
            
            if (this.v$.$error) {
                return;
            }
            
            this.$ewpLoadingShow();
            
            const formData = new FormData();
            formData.append("name", this.form.name);
            formData.append("id_kategori", this.form.kategori?.id || "");
            
            const endpoint = this.isEditMode 
                ? `m-materi-rumah-perubahan/${this.form.id}?_method=PUT` 
                : "m-materi-rumah-perubahan";
            
            Api()
                .post(endpoint, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(() => {
                    $("#modal-form").modal("hide");
                    
                    const message = this.isEditMode 
                        ? "Memperbarui data materi" 
                        : "Menambahkan data materi";
                    
                    this.$swal({
                        title: "Berhasil!",
                        text: message,
                        icon: "success"
                    }).then(() => {
                        if (!this.isEditMode) {
                            this.tableConfig.config.current_page = 1;
                        }
                        this.getDataTable();
                    });
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        
        changeStatus(id) {
            this.$ewpLoadingShow();
            
            Api()
                .put(`m-materi-rumah-perubahan/${id}/switch-status`)
                .then(() => {
                    this.$toast.success("Status berhasil diubah!");
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                    this.getDataTable();
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        
        getKategori(keyword = "", limit = 10) {
            this.isLoadingKategori = true;
            
            Api()
                .get(`m-kategori-rumah-perubahan/lists?limit=${limit}&search=${keyword}`)
                .then(response => {
                    this.list_kategori = response.data.data.map(item => ({
                        id: item.id,
                        text: item.name
                    }));
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.isLoadingKategori = false;
                });
        },
        
        resetForm() {
            this.v$.$reset();
            this.form = {
                id: "",
                name: "",
                kategori: {}
            };
        }
    }
};
</script>

<style scoped>
.icon-password {
    cursor: pointer;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    font-size: 20px;
}
</style>