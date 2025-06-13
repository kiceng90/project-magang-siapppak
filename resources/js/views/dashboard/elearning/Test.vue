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
                                                    >Materi</span
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
                                                <div class="col-lg-3">
                                                    <app-select-single
                                                        v-model="
                                                            single.filter.role
                                                        "
                                                        :show_button_clear="
                                                            false
                                                        "
                                                        :placeholder="'Pilih Kategori'"
                                                        :options="
                                                            list_filter_role_computed
                                                        "
                                                        :serverside="false"
                                                        :loading="false"
                                                        @option-change="
                                                            getDataTable()
                                                        "
                                                    >
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-3">
                                                    <app-select-single
                                                        v-model="
                                                            single.filter.role
                                                        "
                                                        :show_button_clear="
                                                            false
                                                        "
                                                        :placeholder="'Pilih Sub Kategori'"
                                                        :options="
                                                            list_filter_role_computed
                                                        "
                                                        :serverside="false"
                                                        :loading="false"
                                                        @option-change="
                                                            getDataTable()
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
                                                                context.kategori_name
                                                            }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{
                                                                context.subkategori_name
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
                        <h5 class="modal-title">Tambah Data Materi</h5>
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
                                    v$.single.username.$error
                                        ? 'text-danger'
                                        : ''
                                "
                                >Judul Materi</label
                            >
                            <input
                                class="form-control"
                                type="text"
                                placeholder="Masukkan judul materi"
                                v-model="single.username"
                                autocomplete="off"
                            />
                            <div
                                v-if="v$.single.username.$error"
                                class="text-danger"
                            >
                                Username tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="
                                    v$.single.role.$error ? 'text-danger' : ''
                                "
                                >Kategori</label
                            >
                            <app-select-single
                                v-model="single.role"
                                :placeholder="'Pilih Kategori'"
                                :show_search="false"
                                :options="list_role"
                                :serverside="false"
                            >
                            </app-select-single>
                            <div
                                v-if="v$.single.role.$error"
                                class="text-danger"
                            >
                                Kategori tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="
                                    v$.single.role.$error ? 'text-danger' : ''
                                "
                                >Sub Kategori</label
                            >
                            <app-select-single
                                v-model="single.role"
                                :placeholder="'Pilih Sub Kategori'"
                                :show_search="false"
                                :options="list_role"
                                :serverside="false"
                            >
                            </app-select-single>
                            <div
                                v-if="v$.single.role.$error"
                                class="text-danger"
                            >
                                Sub Kategori tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                >Upload Modul</label
                            >
                            <div id="dropzone-container-1">
                                <div
                                    class="dropzone dropzone-file-area dz-clickable"
                                    id="dropzone-upload-modul"
                                >
                                    <div class="dz-message needsclick">
                                        <i
                                            class="bi bi-file-earmark-arrow-up text-primary fs-3x"
                                        ></i>
                                        <div class="ms-4">
                                            <h5 class="kt-dropzone__msg-title">
                                                Drop files here or click to
                                                upload
                                            </h5>
                                            <span
                                                class="kt-dropzone__msg-desc text-primary"
                                            >
                                                Upload files with format .pdf
                                                maksimum size file 10 MB
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div
                                    class="col-lg-6 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                    v-for="(
                                        contextX, indexX
                                    ) in single.existingSk"
                                >
                                    <a :href="contextX.path" target="_blank">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <img
                                                    :src="
                                                        $assetUrl() +
                                                        'extends/img/ic_files_img.png'
                                                    "
                                                    style="width: 35px"
                                                    v-if="contextX.isImage"
                                                />
                                                <img
                                                    :src="
                                                        $assetUrl() +
                                                        'extends/img/ic_files_pdf.png'
                                                    "
                                                    style="width: 35px"
                                                    v-else
                                                />
                                            </div>
                                            <div>
                                                <div
                                                    class="fw-bolder text-primary"
                                                    style="
                                                        word-break: break-word;
                                                    "
                                                >
                                                    {{
                                                        $noNullable(
                                                            contextX.name
                                                        )
                                                    }}
                                                </div>
                                                <div class="text-gray-500">
                                                    {{
                                                        $formatBytes(
                                                            contextX.size
                                                        )
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div>
                                        <i
                                            @click="
                                                single.existingSk.splice(
                                                    indexX,
                                                    1
                                                )
                                            "
                                            class="fa fa-times text-danger"
                                            style="
                                                font-size: 20px;
                                                cursor: pointer;
                                            "
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                >Upload Materi</label
                            >
                            <div id="dropzone-container-1">
                                <div
                                    class="dropzone dropzone-file-area dz-clickable"
                                    id="dropzone-upload-materi"
                                >
                                    <div class="dz-message needsclick">
                                        <i
                                            class="bi bi-file-earmark-arrow-up text-primary fs-3x"
                                        ></i>
                                        <div class="ms-4">
                                            <h5 class="kt-dropzone__msg-title">
                                                Drop files here or click to
                                                upload
                                            </h5>
                                            <span
                                                class="kt-dropzone__msg-desc text-primary"
                                            >
                                                Upload files with format .jpg,
                                                .jpeg, or .png maksimum size
                                                file 2 MB
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div
                                    class="col-lg-6 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                    v-for="(
                                        contextX, indexX
                                    ) in single.existingSk"
                                >
                                    <a :href="contextX.path" target="_blank">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <img
                                                    :src="
                                                        $assetUrl() +
                                                        'extends/img/ic_files_img.png'
                                                    "
                                                    style="width: 35px"
                                                    v-if="contextX.isImage"
                                                />
                                                <img
                                                    :src="
                                                        $assetUrl() +
                                                        'extends/img/ic_files_pdf.png'
                                                    "
                                                    style="width: 35px"
                                                    v-else
                                                />
                                            </div>
                                            <div>
                                                <div
                                                    class="fw-bolder text-primary"
                                                    style="
                                                        word-break: break-word;
                                                    "
                                                >
                                                    {{
                                                        $noNullable(
                                                            contextX.name
                                                        )
                                                    }}
                                                </div>
                                                <div class="text-gray-500">
                                                    {{
                                                        $formatBytes(
                                                            contextX.size
                                                        )
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div>
                                        <i
                                            @click="
                                                single.existingSk.splice(
                                                    indexX,
                                                    1
                                                )
                                            "
                                            class="fa fa-times text-danger"
                                            style="
                                                font-size: 20px;
                                                cursor: pointer;
                                            "
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6">
                                Upload Video<br />
                                <span
                                    style="
                                        font-size: 12px;
                                        color: #706f6f;
                                        font-weight: normal !important;
                                    "
                                >
                                    Maksimal ukuran file 100 MB
                                </span>
                            </label>
                            <div style="position: relative; width: 200px">
                                <video
                                    class="mb-3"
                                    v-if="single.ktp_path"
                                    :src="single.ktp_path"
                                    style="width: 200px; height: 130px"
                                    controls
                                />
                                <img
                                    class="mb-3"
                                    v-if="!single.ktp_path"
                                    :src="
                                        $assetUrl() + 'extends/img/noimage.png'
                                    "
                                    style="width: 200px; height: 130px"
                                />
                                <input
                                    :id="'input-file'"
                                    type="file"
                                    class="d-none"
                                    accept="video/*"
                                    @change="imageChange($event)"
                                />
                                <button
                                    class="btn d-flex align-items-center justify-content-center"
                                    type="button"
                                    style="
                                        padding: 0 !important;
                                        border-radius: 100px;
                                        width: 40px;
                                        height: 40px;
                                        background: #fff !important;
                                        position: absolute;
                                        top: 5px;
                                        right: -10px;
                                        box-shadow: 0 0.5rem 1rem
                                            rgba(0, 0, 0, 0.15) !important;
                                    "
                                    @click="chooseFile"
                                >
                                    <svg
                                        width="20"
                                        height="19"
                                        viewBox="0 0 20 19"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M6.22775 17.7066L15.5208 8.41364L11.1068 3.99964L1.81375 13.2926C1.68582 13.4207 1.59494 13.5811 1.55075 13.7566L0.520752 18.9996L5.76275 17.9696C5.93875 17.9256 6.09975 17.8346 6.22775 17.7066ZM18.5208 5.41364C18.8957 5.03858 19.1063 4.52996 19.1063 3.99964C19.1063 3.46931 18.8957 2.96069 18.5208 2.58564L16.9348 0.999635C16.5597 0.624693 16.0511 0.414062 15.5208 0.414062C14.9904 0.414062 14.4818 0.624693 14.1068 0.999635L12.5208 2.58564L16.9348 6.99964L18.5208 5.41364Z"
                                            fill="#7E8299"
                                        />
                                    </svg>
                                </button>
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
                            class="btn btn-sm bg-second-primary-custom text-white"
                            type="button"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="modal-edit">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Materi</h5>
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
                                    v$.single.username.$error
                                        ? 'text-danger'
                                        : ''
                                "
                                >Judul Materi</label
                            >
                            <input
                                class="form-control"
                                type="text"
                                placeholder="Masukkan judul materi"
                                v-model="single.username"
                                autocomplete="off"
                            />
                            <div
                                v-if="v$.single.username.$error"
                                class="text-danger"
                            >
                                Username tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="
                                    v$.single.role.$error ? 'text-danger' : ''
                                "
                                >Kategori</label
                            >
                            <app-select-single
                                v-model="single.role"
                                :placeholder="'Pilih Kategori'"
                                :show_search="false"
                                :options="list_role"
                                :serverside="false"
                            >
                            </app-select-single>
                            <div
                                v-if="v$.single.role.$error"
                                class="text-danger"
                            >
                                Kategori tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label
                                class="form-label fw-bolder fs-6"
                                :class="
                                    v$.single.role.$error ? 'text-danger' : ''
                                "
                                >Sub Kategori</label
                            >
                            <app-select-single
                                v-model="single.role"
                                :placeholder="'Pilih Sub Kategori'"
                                :show_search="false"
                                :options="list_role"
                                :serverside="false"
                            >
                            </app-select-single>
                            <div
                                v-if="v$.single.role.$error"
                                class="text-danger"
                            >
                                Sub Kategori tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                >Upload Modul</label
                            >
                            <div id="dropzone-container-1">
                                <div
                                    class="dropzone dropzone-file-area dz-clickable"
                                    id="dropzone-upload-modul"
                                >
                                    <div class="dz-message needsclick">
                                        <i
                                            class="bi bi-file-earmark-arrow-up text-primary fs-3x"
                                        ></i>
                                        <div class="ms-4">
                                            <h5 class="kt-dropzone__msg-title">
                                                Drop files here or click to
                                                upload
                                            </h5>
                                            <span
                                                class="kt-dropzone__msg-desc text-primary"
                                            >
                                                Upload files with format .pdf
                                                maksimum size file 10 MB
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div
                                    class="col-lg-6 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                    v-for="(
                                        contextX, indexX
                                    ) in single.existingSk"
                                >
                                    <a :href="contextX.path" target="_blank">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <img
                                                    :src="
                                                        $assetUrl() +
                                                        'extends/img/ic_files_img.png'
                                                    "
                                                    style="width: 35px"
                                                    v-if="contextX.isImage"
                                                />
                                                <img
                                                    :src="
                                                        $assetUrl() +
                                                        'extends/img/ic_files_pdf.png'
                                                    "
                                                    style="width: 35px"
                                                    v-else
                                                />
                                            </div>
                                            <div>
                                                <div
                                                    class="fw-bolder text-primary"
                                                    style="
                                                        word-break: break-word;
                                                    "
                                                >
                                                    {{
                                                        $noNullable(
                                                            contextX.name
                                                        )
                                                    }}
                                                </div>
                                                <div class="text-gray-500">
                                                    {{
                                                        $formatBytes(
                                                            contextX.size
                                                        )
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div>
                                        <i
                                            @click="
                                                single.existingSk.splice(
                                                    indexX,
                                                    1
                                                )
                                            "
                                            class="fa fa-times text-danger"
                                            style="
                                                font-size: 20px;
                                                cursor: pointer;
                                            "
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                >Upload Materi</label
                            >
                            <div id="dropzone-container-1">
                                <div
                                    class="dropzone dropzone-file-area dz-clickable"
                                    id="dropzone-upload-materi"
                                >
                                    <div class="dz-message needsclick">
                                        <i
                                            class="bi bi-file-earmark-arrow-up text-primary fs-3x"
                                        ></i>
                                        <div class="ms-4">
                                            <h5 class="kt-dropzone__msg-title">
                                                Drop files here or click to
                                                upload
                                            </h5>
                                            <span
                                                class="kt-dropzone__msg-desc text-primary"
                                            >
                                                Upload files with format .jpg,
                                                .jpeg, or .png maksimum size
                                                file 2 MB
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div
                                    class="col-lg-6 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                    v-for="(
                                        contextX, indexX
                                    ) in single.existingSk"
                                >
                                    <a :href="contextX.path" target="_blank">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <img
                                                    :src="
                                                        $assetUrl() +
                                                        'extends/img/ic_files_img.png'
                                                    "
                                                    style="width: 35px"
                                                    v-if="contextX.isImage"
                                                />
                                                <img
                                                    :src="
                                                        $assetUrl() +
                                                        'extends/img/ic_files_pdf.png'
                                                    "
                                                    style="width: 35px"
                                                    v-else
                                                />
                                            </div>
                                            <div>
                                                <div
                                                    class="fw-bolder text-primary"
                                                    style="
                                                        word-break: break-word;
                                                    "
                                                >
                                                    {{
                                                        $noNullable(
                                                            contextX.name
                                                        )
                                                    }}
                                                </div>
                                                <div class="text-gray-500">
                                                    {{
                                                        $formatBytes(
                                                            contextX.size
                                                        )
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div>
                                        <i
                                            @click="
                                                single.existingSk.splice(
                                                    indexX,
                                                    1
                                                )
                                            "
                                            class="fa fa-times text-danger"
                                            style="
                                                font-size: 20px;
                                                cursor: pointer;
                                            "
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6">
                                Upload Video<br />
                                <span
                                    style="
                                        font-size: 12px;
                                        color: #706f6f;
                                        font-weight: normal !important;
                                    "
                                >
                                    Maksimal ukuran file 100 MB
                                </span>
                            </label>
                            <div style="position: relative; width: 200px">
                                <video
                                    class="mb-3"
                                    v-if="single.ktp_path"
                                    :src="single.ktp_path"
                                    style="width: 200px; height: 130px"
                                    controls
                                />
                                <img
                                    class="mb-3"
                                    v-if="!single.ktp_path"
                                    :src="
                                        $assetUrl() + 'extends/img/noimage.png'
                                    "
                                    style="width: 200px; height: 130px"
                                />
                                <input
                                    :id="'input-file'"
                                    type="file"
                                    class="d-none"
                                    accept="video/*"
                                    @change="imageChange($event)"
                                />
                                <button
                                    class="btn d-flex align-items-center justify-content-center"
                                    type="button"
                                    style="
                                        padding: 0 !important;
                                        border-radius: 100px;
                                        width: 40px;
                                        height: 40px;
                                        background: #fff !important;
                                        position: absolute;
                                        top: 5px;
                                        right: -10px;
                                        box-shadow: 0 0.5rem 1rem
                                            rgba(0, 0, 0, 0.15) !important;
                                    "
                                    @click="chooseFile"
                                >
                                    <svg
                                        width="20"
                                        height="19"
                                        viewBox="0 0 20 19"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M6.22775 17.7066L15.5208 8.41364L11.1068 3.99964L1.81375 13.2926C1.68582 13.4207 1.59494 13.5811 1.55075 13.7566L0.520752 18.9996L5.76275 17.9696C5.93875 17.9256 6.09975 17.8346 6.22775 17.7066ZM18.5208 5.41364C18.8957 5.03858 19.1063 4.52996 19.1063 3.99964C19.1063 3.46931 18.8957 2.96069 18.5208 2.58564L16.9348 0.999635C16.5597 0.624693 16.0511 0.414062 15.5208 0.414062C14.9904 0.414062 14.4818 0.624693 14.1068 0.999635L12.5208 2.58564L16.9348 6.99964L18.5208 5.41364Z"
                                            fill="#7E8299"
                                        />
                                    </svg>
                                </button>
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
                            text: "JUDUL MATERI",
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
                            sort_by: "is_active",
                            sort_column: true,
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
    watch: {},
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
    computed: {
        list_filter_kategori_computed() {
            let response = [];

            let all = [
                {
                    id: "-",
                    text: "Semua",
                },
            ];

            return response;
        },
    },
    mounted() {
        reinitializeAllPlugin();

        this.initDropzone();

        this.getDataTable();
    },
    methods: {
        initDropzone() {
            const that = this;
            this.dropzoneUpload = new Dropzone("#dropzone-upload-modul", {
                url: "/",
                dictCancelUpload: "Cancel",
                maxFilesize: 10,
                parallelUploads: 1,
                uploadMultiple: false,
                maxFiles: 10,
                addRemoveLinks: true,
                acceptedFiles: ".pdf",
                autoProcessQueue: false,
                init: function () {
                    this.on("error", function (file) {
                        if (!file.accepted) {
                            this.removeFile(file);
                            that.$swal("Silahkan periksa file Anda lagi");
                        } else if (file.status == "error") {
                            this.removeFile(file);
                            that.$swal("Terjadi kesalahan koneksi");
                        }
                    });

                    this.on("resetFiles", function (file) {
                        this.removeAllFiles();
                    });
                },
            });
            this.dropzoneUpload = new Dropzone("#dropzone-upload-materi", {
                url: "/upload-url",
                dictCancelUpload: "Cancel",
                maxFilesize: 2,
                parallelUploads: 5,
                uploadMultiple: true,
                maxFiles: 50,
                addRemoveLinks: true,
                acceptedFiles: ".jpg,.jpeg,.png",
                autoProcessQueue: false,
                init: function () {
                    this.on("error", function (file) {
                        if (!file.accepted) {
                            this.removeFile(file);
                            that.$swal("Silahkan periksa file Anda lagi");
                        } else if (file.status === "error") {
                            this.removeFile(file);
                            that.$swal("Terjadi kesalahan koneksi");
                        }
                    });

                    this.on("resetFiles", function () {
                        this.removeAllFiles();
                    });
                },
            });
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

            this.single.name = this.tableConfig.feeder.data[index].name;

            if (
                this.tableConfig.feeder.data[index].subkategori.kategori.id &&
                this.tableConfig.feeder.data[index].subkategori.kategori.name
            ) {
                this.single.kategori = {
                    id: this.tableConfig.feeder.data[index].subkategori.kategori
                        .id,
                    text: this.tableConfig.feeder.data[index].subkategori
                        .kategori.name,
                };
            }

            if (
                this.tableConfig.feeder.data[index].subkategori.id &&
                this.tableConfig.feeder.data[index].subkategori.name
            ) {
                this.single.kategori = {
                    id: this.tableConfig.feeder.data[index].subkategori.id,
                    text: this.tableConfig.feeder.data[index].subkategori.name,
                };
            }

            $("#modal-edit").modal("show");
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
                this.single.filter.role.id &&
                this.single.filter.role.id !== "-"
            ) {
                Object.assign(params, {
                    id_role: this.single.filter.role.id,
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

            let formData = {
                id_role: this.single.role.id,
                id_konselor:
                    this.single.role.id == this.ROLE_KONSELOR_ID
                        ? this.single.konselor.id
                        : "",
                id_psikolog_volunteer:
                    this.single.role.id == this.ROLE_PSIKOLOG_ID
                        ? this.single.psikolog.id
                        : "",
                id_opd:
                    this.single.role.id == this.ROLE_OPD_ID
                        ? this.single.opd.id
                        : "",
                id_kecamatan:
                    this.single.role.id == this.ROLE_KECAMATAN_ID
                        ? this.single.kecamatan.id
                        : "",
                id_kelurahan:
                    this.single.role.id == this.ROLE_KELURAHAN_ID
                        ? this.single.kelurahan.id
                        : "",
                username: this.single.username,
                password: this.single.password,
                password_confirmation: this.single.confirm_password,
            };

            if (
                this.single.role.id != this.ROLE_KONSELOR_ID &&
                this.single.role.id != this.ROLE_OPD_ID
            ) {
                Object.assign(formData, {
                    name: this.single.name,
                });
            }

            Api()
                .post("m-user", formData)
                .then((response) => {
                    $("#modal-form").modal("hide");

                    this.$swal({
                        title: "Berhasil!",
                        text: "Menambahkan data user",
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

            let formData = {
                id_role: this.single.role.id,
                id_konselor:
                    this.single.role.id == this.ROLE_KONSELOR_ID
                        ? this.single.konselor.id
                        : "",
                id_psikolog_volunteer:
                    this.single.role.id == this.ROLE_PSIKOLOG_ID
                        ? this.single.psikolog.id
                        : "",
                id_opd:
                    this.single.role.id == this.ROLE_OPD_ID
                        ? this.single.opd.id
                        : "",
                id_kecamatan:
                    this.single.role.id == this.ROLE_KECAMATAN_ID
                        ? this.single.kecamatan.id
                        : "",
                id_kelurahan:
                    this.single.role.id == this.ROLE_KELURAHAN_ID
                        ? this.single.kelurahan.id
                        : "",
                username: this.single.username,
            };

            if (
                this.single.role.id != this.ROLE_KONSELOR_ID &&
                this.single.role.id != this.ROLE_OPD_ID
            ) {
                Object.assign(formData, {
                    name: this.single.name,
                });
            }

            this.$ewpLoadingShow();

            Api()
                .put(`m-user/${this.single.id}`, formData)
                .then((response) => {
                    $("#modal-form").modal("hide");

                    this.$swal({
                        title: "Berhasil!",
                        text: "Memperbarui data user",
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
        getOpd(keyword, limit) {
            this.pageStatus = "opd-load";

            Api()
                .get(`m-opd/lists?limit=${limit}&search=${keyword}`)
                .then((response) => {
                    this.list_opd = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_opd.push({
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
        getKonselor(keyword, limit) {
            this.pageStatus = "konselor-load";

            Api()
                .get(`m-konselor/lists?limit=${limit}&search=${keyword}`)
                .then((response) => {
                    this.list_konselor = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_konselor.push({
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
        getPsikolog(keyword, limit) {
            this.pageStatus = "psikolog-load";

            Api()
                .get(
                    `database/psikolog-volunteer/lists?limit=${limit}&search=${keyword}`
                )
                .then((response) => {
                    this.list_psikolog = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_psikolog.push({
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
        getKecamatan(keyword, limit) {
            this.pageStatus = "kecamatan-load";

            Api()
                .get(`m-kecamatan/lists?limit=${limit}&search=${keyword}`)
                .then((response) => {
                    this.list_kecamatan = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_kecamatan.push({
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
        getKelurahan(keyword, limit) {
            this.pageStatus = "kelurahan-load";

            Api()
                .get(
                    `m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${this.single.kecamatan.id}`
                )
                .then((response) => {
                    this.list_kelurahan = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this.list_kelurahan.push({
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
        reset() {
            this.v$.$reset();

            this.flag = "insert";

            this.single.id = "";
            this.single.role = {};
            this.single.name = "";
            this.single.konselor = {};
            this.single.opd = {};
            this.single.kecamatan = {};
            this.single.kelurahan = {};
            this.single.password = "";
            this.single.confirm_password = "";
            this.single.username = "";

            this.list_kelurahan = [];
        },
        chooseFile() {
            this.single.ktp_path = "";
            this.single.ktp_file = "";

            $("#input-file").val("");
            setTimeout(() => {
                $("#input-file").click();
            }, 500);
        },
        imageChange(evt) {
            evt.preventDefault();
            evt.stopImmediatePropagation();

            const conteks = window.$(evt.target);
            const that = this;
            if (window.FileReader) {
                const fileReader = new FileReader();
                const files = document.getElementById(conteks.attr("id")).files;
                if (!files.length) {
                    return;
                }
                const file = files[0];
                // Hanya terima file video
                if (/^video\/\w+$/.test(file.type)) {
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function () {
                        var files =
                            evt.target.files || event.dataTransfer.files;
                        if (!files.length) {
                            return;
                        }

                        const size = file.size;

                        if (Math.round(size) > 100 * 1024 * 1024) {
                            that.$swal({
                                title: "Peringatan!",
                                text: "Ukuran video tidak boleh melebihi 100 MB",
                                icon: "warning",
                            });
                            return;
                        }

                        that.single.ktp_path = fileReader.result;
                        that.single.ktp_file = files[0];
                    };
                } else {
                    this.$swal({
                        title: "Peringatan!",
                        text: "File yang anda pilih belum termasuk video!",
                        icon: "warning",
                    });
                }
            }
        },
        choosePhoto() {
            this.single.photo_path = "";
            this.single.photo_file = "";

            $("#input-photo").val("");
            setTimeout(() => {
                $("#input-photo").click();
            }, 500);
        },
        imageChangePhoto(evt) {
            evt.preventDefault();
            evt.stopImmediatePropagation();

            const conteks = window.$(evt.target);
            const that = this;
            if (window.FileReader) {
                const fileReader = new FileReader();
                const files = document.getElementById(conteks.attr("id")).files;
                if (!files.length) {
                    return;
                }
                const file = files[0];
                // Hanya terima file video
                if (/^video\/\w+$/.test(file.type)) {
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function () {
                        var files =
                            evt.target.files || event.dataTransfer.files;
                        if (!files.length) {
                            return;
                        }

                        const size = file.size;

                        if (Math.round(size) > 5 * 1024 * 1024) {
                            that.$swal({
                                title: "Peringatan!",
                                text: "Ukuran video tidak boleh melebihi 5 MB",
                                icon: "warning",
                            });
                            return;
                        }

                        that.single.photo_path = fileReader.result;
                        that.single.photo_file = files[0];
                    };
                } else {
                    this.$swal({
                        title: "Peringatan!",
                        text: "File yang anda pilih belum termasuk video!",
                        icon: "warning",
                    });
                }
            }
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
