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
                                                    >Master Materi</span
                                                >
                                            </h3>
                                            <button
                                                type="button"
                                                class="btn btn-sm bg-primary-custom"
                                                @click="showModalAdd"
                                            >
                                                <span class="text-white"
                                                    >Tambah Data</span
                                                >
                                            </button>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row mb-3">
                                                <div class="col-lg-2 pb-5">
                                                    <div
                                                        style="
                                                            font-size: 20px;
                                                            font-weight: 600;
                                                        "
                                                        class="pt-2"
                                                    >
                                                        Filter Data
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 pb-5">
                                                    <app-select-single
                                                        v-model="
                                                            single.filter
                                                                .kategori
                                                        "
                                                        :show_button_clear="
                                                            false
                                                        "
                                                        :placeholder="'Kategori'"
                                                        :options="
                                                            filter_list_kategori_computed
                                                        "
                                                        :serverside="true"
                                                        :loading="
                                                            pageStatus ==
                                                            'kategori-load'
                                                        "
                                                        @change-search="
                                                            getKategori
                                                        "
                                                        @option-change="
                                                            resetSubkategori();
                                                            tableConfig.config.current_page = 1;
                                                            getDataTable();
                                                        "
                                                    >
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-5 pb-5">
                                                    <app-select-single
                                                        v-model="
                                                            single.filter
                                                                .subkategori
                                                        "
                                                        :show_button_clear="
                                                            false
                                                        "
                                                        :placeholder="'Sub Kategori'"
                                                        :options="
                                                            filter_list_subkategori_computed
                                                        "
                                                        :serverside="true"
                                                        :loading="
                                                            pageStatus ==
                                                            'subkategori-load'
                                                        "
                                                        @change-search="
                                                            getFilterSubkategori(
                                                                single.filter
                                                                    .kategori.id
                                                            )
                                                        "
                                                        @option-change="
                                                            tableConfig.config.current_page = 1;
                                                            getDataTable();
                                                        "
                                                    >
                                                    </app-select-single>
                                                </div>
                                            </div>
                                            <app-datatable-serverside
                                                :table_config="tableConfig"
                                                @change-page="getDataTable"
                                                v-model:show_per_page="
                                                    tableConfig.config
                                                        .show_per_page
                                                "
                                                v-model:search="
                                                    tableConfig.config.search
                                                "
                                                v-model:order="
                                                    tableConfig.config.order
                                                "
                                                v-model:sort_by="
                                                    tableConfig.config.sort_by
                                                "
                                                v-model:current_page="
                                                    tableConfig.config
                                                        .current_page
                                                "
                                            >
                                                <template v-slot:body>
                                                    <tr
                                                        v-for="(
                                                            context, index
                                                        ) in tableConfig.feeder
                                                            .data"
                                                    >
                                                        <td class="text-center">
                                                            {{ index + 1 }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ context.name }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{
                                                                context
                                                                    .subkategori
                                                                    .kategori
                                                                    .name
                                                            }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{
                                                                context
                                                                    .subkategori
                                                                    .name
                                                            }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div
                                                                class="text-center w-100"
                                                            >
                                                                <div
                                                                    class="form-check form-switch form-check-custom form-check-solid justify-content-center"
                                                                >
                                                                    <input
                                                                        class="form-check-input h-20px w-40px"
                                                                        type="checkbox"
                                                                        value="1"
                                                                        :checked="
                                                                            context.is_active
                                                                        "
                                                                        @click="
                                                                            changeStatus(
                                                                                context.id
                                                                            )
                                                                        "
                                                                    />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div
                                                                class="dropdown"
                                                                style="
                                                                    position: static !important;
                                                                "
                                                            >
                                                                <button
                                                                    class="btn btn-secondary btn-xs dropdown-toggle"
                                                                    type="button"
                                                                    data-bs-toggle="dropdown"
                                                                    style="
                                                                        padding: 5px
                                                                            10px !important;
                                                                    "
                                                                    aria-expanded="false"
                                                                >
                                                                    Aksi
                                                                </button>
                                                                <ul
                                                                    class="dropdown-menu"
                                                                >
                                                                    <li>
                                                                        <router-link
                                                                            class="dropdown-item py-3"
                                                                            :to="{
                                                                                name: 'elearning-latihansoal',
                                                                                params: {
                                                                                    id: context.id,
                                                                                },
                                                                            }"
                                                                        >
                                                                            Latihan
                                                                            Soal
                                                                        </router-link>
                                                                    </li>
                                                                    <li>
                                                                        <router-link
                                                                            class="dropdown-item py-3"
                                                                            :to="{
                                                                                name: 'elearning-detail-materi',
                                                                                params: {
                                                                                    id: context.id,
                                                                                },
                                                                            }"
                                                                        >
                                                                            Detail
                                                                            Materi
                                                                        </router-link>
                                                                    </li>
                                                                    <li>
                                                                        <a
                                                                            class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="
                                                                                edit(
                                                                                    context.id
                                                                                )
                                                                            "
                                                                            >Edit</a
                                                                        >
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
        
        <div class="modal fade" tabindex="-1" id="modal-form">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{
                                flag == "insert"
                                    ? "Tambah Materi"
                                    : "Edit Materi"
                            }}
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
                            :class="
                                v$.single.kategori.$error ? 'text-danger' : ''
                            "
                            >Kategori</label
                        >
                        <app-select-single
                            v-model="single.kategori"
                            placeholder="Pilih Kategori"
                            :loading="pageStatus === 'kategori-load'"
                            :options="list_kategori"
                            :serverside="true"
                            @change-search="getKategori"
                        />
                        <div
                            v-if="v$.single.kategori.$error"
                            class="text-danger"
                        >
                            > Kategori tidak boleh kosong!
                        </div>
                        <template v-if="single.kategori && single.kategori.id">
                            <label class="form-label fw-bolder fs-6 mb-5 mt-5"
                                >Sub Kategori</label
                            >
                            <app-select-single
                                v-model="single.subkategori"
                                placeholder="Pilih Sub Kategori"
                                :loading="pageStatus === 'subkategori-load'"
                                :options="list_subkategori"
                                :serverside="true"
                                @change-search="getSubkategori"
                            />
                            <div
                                v-if="v$.single.kategori.$error"
                                class="text-danger"
                            >
                                > Sub Kategori tidak boleh kosong!
                            </div>
                        </template>
                        <div class="mb-5 mt-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="
                                    v$.single.name.$error ? 'text-danger' : ''
                                "
                                >Judul Materi</label
                            >
                            <input
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Judul Materi"
                                autocomplete="off"
                                v-model="single.name"
                            />
                            <div
                                v-if="v$.single.name.$error"
                                class="text-danger"
                            >
                                > Judul Materi tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5 mt-5">
                            <label class="form-label fw-bolder fs-6"
                                >Url Video</label
                            >
                            <input
                                class="form-control"
                                type="text"
                                placeholder="Masukkan URL Materi Video"
                                autocomplete="off"
                                v-model="single.video"
                            />
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6 mb-3"
                                >Modul</label
                            >
                            <input
                                type="file"
                                class="form-control"
                                accept="application/pdf"
                                ref="modulInput"
                                @change="
                                    (e) =>
                                        (this.single.modul = e.target.files[0])
                                "
                            />
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6 mb-3"
                                >Materi</label
                            >
                            <input
                                type="file"
                                class="form-control"
                                accept="application/pdf"
                                ref="materiInput"
                                @change="
                                    (e) =>
                                        (this.single.materi = e.target.files[0])
                                "
                            />
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
                            v-if="flag == 'insert'"
                            @click="save"
                            class="btn btn-sm bg-second-primary-custom text-white"
                            type="button"
                        >
                            Simpan
                        </button>
                        <button
                            v-if="flag == 'update'"
                            @click="update"
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
import { required, sameAs, requiredIf, minLength } from "@vuelidate/validators";

export default {
    data() {
        return {
            v$: useVuelidate(),
            pageStatus: "standby",
            flag: "insert",
            list_kategori: [],
            list_subkategori: [],
            single: {
                id: "",
                name: "",
                kategori: {},
                subkategori: {},

                filter: {
                    kategori: {
                        id: "0",
                        text: "Semua Kategori",
                    },

                    subkategori: {
                        id: "0",
                        text: "Semua Sub Kategori",
                    },
                },
            },
            tableConfig: {
                feeder: {
                    column: [
                        {
                            text: "NO",
                            sort_column: false,
                            style: "text-align: center",
                        },
                        {
                            text: "MATERI",
                            sort_by: "name",
                            sort_column: true,
                            style: "text-align: left",
                        },
                        {
                            text: "KATEGORI",
                            sort_by: "kategori",
                            sort_column: true,
                            style: "text-align: left",
                        },
                        {
                            text: "SUB KATEGORI",
                            sort_by: "subkategori",
                            sort_column: true,
                            style: "text-align: left",
                        },
                        {
                            text: "STATUS",
                            sort_column: false,
                            style: "text-align: center",
                        },
                        {
                            text: "AKSI",
                            sort_column: false,
                            style: "text-align: center",
                        },
                    ],

                    data: [],
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
                    show_search: true,
                },
            },
        };
    },
    computed: {
        filter_list_kategori_computed() {
            let response = [];

            response.push({
                id: "0",
                text: "Semua Kategori",
            });

            for (let i = 0; i < this.list_kategori.length; i++) {
                response.push(this.list_kategori[i]);
            }

            return response;
        },

        filter_list_subkategori_computed() {
            let response = [
                {
                    id: "0",
                    text: "Semua Sub Kategori",
                },
            ];

            this.list_subkategori.forEach((item) => {
                response.push({
                    id: item.id,
                    text: item.text || item.name,
                });
            });

            return response;
        },
    },
    validations() {
        return {
            single: {
                name: {
                    required,
                },
                kategori: {
                    required,
                },
                subkategori: {
                    required,
                },
            },
        };
    },
    mounted() {
        reinitializeAllPlugin();
        this.getDataTable();
    },
    methods: {
        resetSubkategori() {
            this.single.filter.subkategori = {
                id: "0",
                text: "Semua Sub Kategori",
            };
            this.list_subkategori = [];
        },

        showModalAdd() {
            this.reset();

            $("#modal-form").modal("show");
        },
        edit(id) {
            this.reset();

            this.flag = "update";

            const index = this.tableConfig.feeder.data.findIndex(
                (e) => e.id == id
            );
            if (index >= 0) {
                this.single.id = this.tableConfig.feeder.data[index].id;
                this.single.name = this.tableConfig.feeder.data[index].name;
                this.single.video = this.tableConfig.feeder.data[index].video;

                if (
                    this.tableConfig.feeder.data[index].subkategori.kategori
                        .id &&
                    this.tableConfig.feeder.data[index].subkategori.kategori
                        .name
                ) {
                    this.single.kategori = {
                        id: this.tableConfig.feeder.data[index].subkategori
                            .kategori.id,
                        text: this.tableConfig.feeder.data[index].subkategori
                            .kategori.name,
                    };
                }

                if (
                    this.tableConfig.feeder.data[index].subkategori.id &&
                    this.tableConfig.feeder.data[index].subkategori.name
                ) {
                    this.single.subkategori = {
                        id: this.tableConfig.feeder.data[index].subkategori.id,
                        text: this.tableConfig.feeder.data[index].subkategori
                            .name,
                    };
                }

                $("#modal-form").modal("show");
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
                search: this.tableConfig.config.search,
            };

            if (
                this.single.filter.kategori &&
                this.single.filter.kategori.id != "0"
            ) {
                Object.assign(params, {
                    id_kategori: this.single.filter.kategori.id,
                });
            }
            if (
                this.single.filter.subkategori &&
                this.single.filter.subkategori.id != "0"
            ) {
                Object.assign(params, {
                    id_subkategori: this.single.filter.subkategori.id,
                });
            }

            Api()
                .get(`materi`, {
                    params,
                })
                .then((response) => {
                    let data = response.data.data;

                    this.tableConfig.feeder.data = data;
                    this.tableConfig.config.total_data = response.data.total;

                    this.tableConfig.config.loading = false;
                })
                .catch((error) => {
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
            formData.append("name", this.single.name);
            formData.append("video", this.single.video);
            formData.append(
                "id_sub_kategori",
                this.single.subkategori ? this.single.subkategori.id : ""
            );

            // Check and append files if available
            if (this.single.modul) {
                formData.append("modul", this.single.modul);
            }
            if (this.single.materi) {
                formData.append("materi", this.single.materi);
            }
            Api()
                .post("materi", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    $("#modal-form").modal("hide");
                    this.$swal({
                        title: "Berhasil!",
                        text: "Menambahkan data materi",
                        icon: "success",
                    }).then(() => {
                        this.tableConfig.config.current_page = 1;
                        this.getDataTable();
                    });
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .then(() => {
                    this.$ewpLoadingHide();
                });
        },
        update() {
            this.v$.$touch();
            if (this.v$.$error) {
                return false;
            }

            this.$ewpLoadingShow();

            // Creating a new instance of FormData
            let formData = new FormData();
            formData.append("name", this.single.name);
            formData.append("video", this.single.video);
            formData.append("id_sub_kategori", this.single.subkategori.id);

            // Adding files if they exist
            if (this.single.modul) {
                formData.append("modul", this.single.modul);
            }
            if (this.single.materi) {
                formData.append("materi", this.single.materi);
            }

            // Using PUT to update data on the server
            Api()
                .post(`materi/${this.single.id}?_method=PUT`, formData)
                .then((response) => {
                    $("#modal-form").modal("hide");

                    this.$swal({
                        title: "Berhasil!",
                        text: "Memperbarui data materi",
                        icon: "success",
                    }).then((result) => {
                        this.getDataTable(); // Reload data after update
                    });
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .then(() => {
                    this.$ewpLoadingHide();
                });
        },
        changeStatus(id) {
            this.$ewpLoadingShow();
            Api()
                .put(`materi/${id}/switch-status`)
                .then((response) => {
                    this.$toast.success("Status berhasil diubah!");
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                    this.getDataTable();
                })
                .then(() => {
                    this.$ewpLoadingHide();
                });
        },
        getKategori(keyword, limit) {
            this.pageStatus = "kategori-load";

            Api()
                .get(`kategori/lists?limit=${limit}&search=${keyword}`)
                .then((response) => {
                    this.list_kategori = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_kategori.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })

                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .then(() => {
                    this.pageStatus = "standby";
                });
        },

        getSubkategori(keyword, limit) {
            this.pageStatus = "subkategori-load";

            Api()
                .get(
                    `subkategori/lists?search=${keyword}&limit=${limit}&id_kategori=${this.single.kategori.id}`
                )
                .then((response) => {
                    this.list_subkategori = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_subkategori.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.pageStatus = "standby";
                });
        },

        getFilterSubkategori(id_kategori) {
            if (!id_kategori) return; // Jika tidak ada id_kategori, tidak melanjutkan permintaan

            const searchTerm =
                this.single.filter.subkategori &&
                typeof this.single.filter.subkategori === "string"
                    ? this.single.filter.subkategori
                    : "";

            this.pageStatus = "subkategori-load";
            Api()
                .get(
                    `subkategori/lists?limit=15&search=${searchTerm}&id_kategori=${id_kategori}`
                )
                .then((response) => {
                    if (response.data && response.data.data) {
                        this.list_subkategori = response.data.data.map(
                            (item) => ({
                                id: item.id,
                                text: item.name,
                            })
                        );
                    } else {
                        console.error(
                            "Respons API tidak sesuai format yang diharapkan:",
                            response.data
                        );
                    }
                })
                .catch((error) => {
                    console.error(
                        "Terjadi error saat memuat subkategori:",
                        error
                    );
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.pageStatus = "standby";
                });
        },

        reset() {
            this.v$.$reset();

            this.flag = "insert";

            this.single.id = "";
            this.single.name = "";
            this.single.kategori = {};
            this.single.subkategori = {};
            this.single.modul = null;
            this.single.materi = null;
            this.single.video = null;

            // Reset nilai input file di DOM
            this.$refs.modulInput.value = "";
            this.$refs.materiInput.value = "";
        },
    },
};
</script>

<style scoped>
.icon-password {
    cursor: pointer;
    float: right;
    position: relative;
    bottom: 32px;
    right: 10px;
    font-size: 20px;
}
</style>
