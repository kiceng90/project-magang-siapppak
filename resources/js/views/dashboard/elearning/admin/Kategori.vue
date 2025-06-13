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
                                                    >Master Kategori</span
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
                                                                context.kutipan
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
                                                                        <a
                                                                            class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="
                                                                                showModalLihatDeskripsi(
                                                                                    context.id
                                                                                )
                                                                            "
                                                                            >Lihat
                                                                            Deskripsi</a
                                                                        >
                                                                        <a
                                                                            class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="
                                                                                showModalLihatGambar(
                                                                                    context.id
                                                                                )
                                                                            "
                                                                            >Lihat
                                                                            Gambar</a
                                                                        >
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
                                    ? "Tambah Data Kategori"
                                    : "Edit Data Kategori"
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
                        <div class="mb-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="
                                    v$.single.name.$error ? 'text-danger' : ''
                                "
                                >Nama Kategori</label
                            >
                            <input
                                class="form-control"
                                type="text"
                                placeholder="Masukkan kategori"
                                autocomplete="off"
                                v-model="single.name"
                            />
                            <div
                                v-if="v$.single.name.$error"
                                class="text-danger"
                            >
                                > Kategori tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5 mt-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="
                                    v$.single.kutipan.$error
                                        ? 'text-danger'
                                        : ''
                                "
                                >Kutipan</label
                            >
                            <input
                                class="form-control"
                                type="text"
                                placeholder="Masukkan kategori"
                                autocomplete="off"
                                v-model="single.kutipan"
                            />
                            <div
                                v-if="v$.single.kutipan.$error"
                                class="text-danger"
                            >
                                > Kutipan tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5 mt-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="
                                    v$.single.deskripsi.$error
                                        ? 'text-danger'
                                        : ''
                                "
                                >Deskripsi</label
                            >
                            <textarea class="form-control"
                                type="text"
                                placeholder="Masukkan kategori"
                                autocomplete="off"
                                rows="4"
                                v-model="single.deskripsi">
                            </textarea>
                            <div
                                v-if="v$.single.deskripsi.$error"
                                class="text-danger"
                            >
                                > deskripsi tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6 mb-3"
                                >Image</label
                            >
                            <input
                                type="file"
                                class="form-control"
                                accept="image/png, image/jpeg, image/jpg"
                                @change="
                                    (e) =>
                                        (this.single.image = e.target.files[0])
                                "
                                ref="fileInput"
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
        <div class="modal fade" tabindex="-1" id="modal-deskripsi">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">lihat Deskripsi</h5>
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
                        {{ single.deskripsi }}
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-sm bg-second-primary-custom text-white"
                            data-bs-dismiss="modal"
                        >
                            Oke
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="modal-gambar">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">lihat Gambar</h5>
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
                        <img
                            class="img-kategori"
                            :src="getImageUrl(single.image)"
                            alt="Deskripsi Gambar"
                            v-if="single.image"
                        />
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-sm bg-second-primary-custom text-white"
                            data-bs-dismiss="modal"
                        >
                            Oke
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
    data() {
        return {
            v$: useVuelidate(),
            pageStatus: "standby",
            flag: "insert",
            single: {
                id: "",
                name: "",
                kutipan: "",
                deskripsi: "",
                image: "",
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
                            text: "NAMA",
                            sort_by: "name",
                            sort_column: true,
                            style: "text-align: left",
                        },
                        {
                            text: "KUTIPAN",
                            sort_by: "kutipan",
                            sort_column: false,
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
    computed: {},
    validations() {
        return {
            single: {
                name: {
                    required,
                },
                kutipan: {
                    required,
                },
                deskripsi: {
                    required,
                },
                image: {},
            },
        };
    },
    mounted() {
        reinitializeAllPlugin();
        this.getDataTable();
    },
    methods: {
        getImageUrl(path) {
            return `${path}`;
        },
        showModalAdd() {
            this.reset();

            $("#modal-form").modal("show");
        },
        showModalLihatDeskripsi(id) {
            const index = this.tableConfig.feeder.data.findIndex(
                (item) => item.id === id
            );
            if (index >= 0) {
                this.single.deskripsi =
                    this.tableConfig.feeder.data[index].deskripsi;
                $("#modal-deskripsi").modal("show");
            }
        },
        showModalLihatGambar(id) {
            const index = this.tableConfig.feeder.data.findIndex(
                (item) => item.id === id
            );
            if (index >= 0) {
                this.single.image = this.tableConfig.feeder.data[index].image;
                $("#modal-gambar").modal("show");
            }
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
                this.single.kutipan =
                    this.tableConfig.feeder.data[index].kutipan;
                this.single.deskripsi =
                    this.tableConfig.feeder.data[index].deskripsi;

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

            Api()
                .get(`kategori`, {
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
            formData.append("kutipan", this.single.kutipan);
            formData.append("deskripsi", this.single.deskripsi);

            // Check and append files if available
            if (this.single.image) {
                formData.append("image", this.single.image);
            }

            Api()
                .post("kategori", formData)
                .then((response) => {
                    $("#modal-form").modal("hide");

                    this.$swal({
                        title: "Berhasil!",
                        text: "Menambahkan data Kategori",
                        icon: "success",
                    }).then((result) => {
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

            let formData = new FormData();
            formData.append("name", this.single.name);
            formData.append("kutipan", this.single.kutipan);
            formData.append("deskripsi", this.single.deskripsi);

            // Check and append files if available
            if (this.single.image) {
                formData.append("image", this.single.image);
            }

            Api()
                .post(`kategori/${this.single.id}?_method=PUT`, formData)
                .then((response) => {
                    $("#modal-form").modal("hide");

                    this.$swal({
                        title: "Berhasil!",
                        text: "Memperbarui data kategori",
                        icon: "success",
                    }).then((result) => {
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
        changeStatus(id) {
            this.$ewpLoadingShow();
            Api()
                .put(`kategori/${id}/switch-status`)
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
        reset() {
            this.v$.$reset();

            this.flag = "insert";

            this.single.id = "";
            this.single.name = "";
            this.single.kutipan = "";
            this.single.deskripsi = "";
            this.single.image = "";

            this.$refs.fileInput.value = '';
        },
    },
};
</script>

<style scoped>
.img-kategori {
    width: 300px;
    height: 300px;
}
</style>
