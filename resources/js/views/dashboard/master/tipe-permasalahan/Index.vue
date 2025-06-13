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
                                                    style="font-size:20px !important;">Master Tipe Permasalahan</span>
                                            </h3>
                                            <button type="button" class="btn btn-sm bg-primary-custom"
                                                @click="showModalAdd">
                                                <span class="text-white">Tambah Data</span>
                                            </button>

                                        </div>
                                        <div class="card-body pt-5">

                                            <div data-kt-buttons="true" class="row">
                                                <!--begin::Radio button-->
                                                <div class="col-lg-4 p-5">
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
                                                        <!--end::Description-->
                                                        <div class="d-flex align-items-center me-2">
                                                            <!--begin::Radio-->
                                                            <div
                                                                class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                                <input class="form-check-input" type="radio"
                                                                    name="tipe-filter" v-model="single.tipe_header"
                                                                    value="tipe-permasalahan" />
                                                            </div>
                                                            <!--end::Radio-->

                                                            <!--begin::Info-->
                                                            <div class="flex-grow-1">
                                                                <h2
                                                                    class="d-flex align-items-center fs-4 fw-bolder flex-wrap">
                                                                    Tipe Permasalahan
                                                                </h2>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::Description-->
                                                    </label>
                                                </div>
                                                <div class="col-lg-4 p-5">
                                                    <label
                                                        class=" btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
                                                        <!--end::Description-->
                                                        <div class="d-flex align-items-center me-2">
                                                            <!--begin::Radio-->
                                                            <div
                                                                class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                                <input class="form-check-input" type="radio"
                                                                    name="tipe-filter" v-model="single.tipe_header"
                                                                    value="kategori-kasus" />
                                                            </div>
                                                            <!--end::Radio-->

                                                            <!--begin::Info-->
                                                            <div class="flex-grow-1">
                                                                <h2
                                                                    class="d-flex align-items-center fs-4 fw-bolder flex-wrap">
                                                                    Kategori Kasus
                                                                </h2>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::Description-->
                                                    </label>
                                                </div>
                                                <div class="col-lg-4 p-5">
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
                                                        <!--end::Description-->
                                                        <div class="d-flex align-items-center me-2">
                                                            <!--begin::Radio-->
                                                            <div
                                                                class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                                <input class="form-check-input" type="radio"
                                                                    name="tipe-filter" v-model="single.tipe_header"
                                                                    value="jenis-kasus" />
                                                            </div>
                                                            <!--end::Radio-->

                                                            <!--begin::Info-->
                                                            <div class="flex-grow-1">
                                                                <h2
                                                                    class="d-flex align-items-center fs-4 fw-bolder flex-wrap">
                                                                    Jenis Kasus
                                                                </h2>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::Description-->
                                                    </label>
                                                </div>
                                                <!--end::Radio button-->

                                            </div>

                                            <div class="row mb-3"
                                                v-if="single.tipe_header == 'kategori-kasus' || single.tipe_header == 'jenis-kasus'">
                                                <div class="col-lg-2 pb-5">
                                                    <div style="font-size:20px;font-weight:600;" class="pt-2">Filter
                                                        Data</div>
                                                </div>
                                                <div :class="single.tipe_header == 'kategori-kasus' ? 'col-lg-10' : 'col-lg-5'"
                                                    v-if="single.tipe_header == 'kategori-kasus' || single.tipe_header == 'jenis-kasus'">
                                                    <app-select-single v-model="single.filter.tipePermasalahan"
                                                        :show_button_clear="false"
                                                        :placeholder="'Pilih Tipe Permasalahan'"
                                                        :options="filter_list_tipe_permasalahan_computed"
                                                        :serverside="true"
                                                        :loading="pageStatus == 'tipe-permasalahan-filter-load'"
                                                        @change-search="getTipePermasalahanFilter"
                                                        @option-change="resetDataTable()">
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-5 pb-5">
                                                    <app-select-single v-model="single.filter.kategoriKasus"
                                                        :disabled="single.filter.tipePermasalahan.id == '0'"
                                                        v-if="single.tipe_header == 'jenis-kasus'"
                                                        :show_button_clear="false" :placeholder="'Pilih Kategori Kasus'"
                                                        :options="filter_list_kategori_kasus_computed"
                                                        :serverside="true"
                                                        :loading="pageStatus == 'kategori-kasus-filter-load'"
                                                        @change-search="getKategoriKasusFilter"
                                                        @option-change="resetDataTable()">
                                                    </app-select-single>
                                                </div>
                                            </div>

                                            <app-datatable-serverside :table_config="tableTipePermasalahan"
                                                v-if="single.tipe_header == 'tipe-permasalahan'"
                                                @change-page="getDataTableTipePermasalahan"
                                                v-model:show_per_page="tableTipePermasalahan.config.show_per_page"
                                                v-model:search="tableTipePermasalahan.config.search"
                                                v-model:order="tableTipePermasalahan.config.order"
                                                v-model:sort_by="tableTipePermasalahan.config.sort_by"
                                                v-model:current_page="tableTipePermasalahan.config.current_page">
                                                <template v-slot:body>
                                                    <tr v-for="(context, index) in tableTipePermasalahan.feeder.data">
                                                        <td class="text-center">{{index + 1}}</td>
                                                        <td class="text-left">{{context.name}}</td>
                                                        <td class="text-center">
                                                            <div class="text-center w-100">
                                                                <div
                                                                    class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                                                    <input class="form-check-input h-20px w-40px"
                                                                        type="checkbox" value="1"
                                                                        :checked="context.is_active"
                                                                        @click="changeStatus(context.id, 'tipe-permasalahan')" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center flex-wrap">
                                                                <div class="action-datatable-column m-2"
                                                                    @click="edit(context.id, 'tipe-permasalahan')"
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
                                            <app-datatable-serverside :table_config="tableKategoriKasus"
                                                v-if="single.tipe_header == 'kategori-kasus'"
                                                @change-page="getDataTableKategoriKasus"
                                                v-model:show_per_page="tableKategoriKasus.config.show_per_page"
                                                v-model:search="tableKategoriKasus.config.search"
                                                v-model:order="tableKategoriKasus.config.order"
                                                v-model:sort_by="tableKategoriKasus.config.sort_by"
                                                v-model:current_page="tableKategoriKasus.config.current_page">
                                                <template v-slot:body>
                                                    <tr v-for="(context, index) in tableKategoriKasus.feeder.data">
                                                        <td class="text-center">{{index + 1}}</td>
                                                        <td class="text-left">{{context.tipe_permasalahan_name}}</td>
                                                        <td class="text-left">{{context.name}}</td>
                                                        <td class="text-center">
                                                            <div class="text-center w-100">
                                                                <div
                                                                    class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                                                    <input class="form-check-input h-20px w-40px"
                                                                        type="checkbox" value="1"
                                                                        :checked="context.is_active"
                                                                        @click="changeStatus(context.id, 'kategori-kasus')" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center flex-wrap">
                                                                <div class="action-datatable-column m-2"
                                                                    @click="edit(context.id, 'kategori-kasus')"
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
                                            <app-datatable-serverside :table_config="tableJenisKasus"
                                                v-if="single.tipe_header == 'jenis-kasus'"
                                                @change-page="getDataTableJenisKasus"
                                                v-model:show_per_page="tableJenisKasus.config.show_per_page"
                                                v-model:search="tableJenisKasus.config.search"
                                                v-model:order="tableJenisKasus.config.order"
                                                v-model:sort_by="tableJenisKasus.config.sort_by"
                                                v-model:current_page="tableJenisKasus.config.current_page">
                                                <template v-slot:body>
                                                    <tr v-for="(context, index) in tableJenisKasus.feeder.data">
                                                        <td class="text-center">{{index + 1}}</td>
                                                        <td class="text-left">{{context.tipe_permasalahan_name}}</td>
                                                        <td class="text-left">{{context.kategori_kasus_name}}</td>
                                                        <td class="text-left">{{context.name}}</td>
                                                        <td class="text-center">
                                                            <div class="text-center w-100">
                                                                <div
                                                                    class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                                                    <input class="form-check-input h-20px w-40px"
                                                                        type="checkbox" value="1"
                                                                        :checked="context.is_active"
                                                                        @click="changeStatus(context.id, 'jenis-kasus')" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center flex-wrap">
                                                                <div class="action-datatable-column m-2"
                                                                    @click="edit(context.id, 'jenis-kasus')"
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
            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width:1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{flag == 'insert' ? 'Tambah Data Tipe Permasalahan' : 'Edit Data Tipe Permasalahan'}}</h5>
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
                        <div data-kt-buttons="true" class="row">
                            <!--begin::Radio button-->
                            <div class="col-lg-4 p-5">
                                <label class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5"
                                    :class="flag == 'update' && single.tipe != 'tipe-permasalahan' ? 'radio-disabled-custom' : ''">
                                    <!--end::Description-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Radio-->
                                        <div
                                            class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                            <input class="form-check-input" type="radio" name="tipe"
                                                :disabled="flag == 'update'" v-model="single.tipe"
                                                value="tipe-permasalahan" />
                                        </div>
                                        <!--end::Radio-->

                                        <!--begin::Info-->
                                        <div class="flex-grow-1">
                                            <h2 class="d-flex align-items-center fs-4 fw-bolder flex-wrap">
                                                Tipe Permasalahan
                                            </h2>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::Description-->
                                </label>
                            </div>
                            <div class="col-lg-4 p-5">
                                <label class=" btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5"
                                    :class="flag == 'update' && single.tipe != 'kategori-kasus' ? 'radio-disabled-custom' : ''">
                                    <!--end::Description-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Radio-->
                                        <div
                                            class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                            <input class="form-check-input" type="radio" name="tipe"
                                                :disabled="flag == 'update'" v-model="single.tipe"
                                                value="kategori-kasus" />
                                        </div>
                                        <!--end::Radio-->

                                        <!--begin::Info-->
                                        <div class="flex-grow-1">
                                            <h2 class="d-flex align-items-center fs-4 fw-bolder flex-wrap">
                                                Kategori Kasus
                                            </h2>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::Description-->
                                </label>
                            </div>
                            <div class="col-lg-4 p-5">
                                <label class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5"
                                    :class="flag == 'update' && single.tipe != 'jenis-kasus' ? 'radio-disabled-custom' : ''">
                                    <!--end::Description-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Radio-->
                                        <div
                                            class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                            <input class="form-check-input" type="radio" name="tipe"
                                                :disabled="flag == 'update'" v-model="single.tipe"
                                                value="jenis-kasus" />
                                        </div>
                                        <!--end::Radio-->

                                        <!--begin::Info-->
                                        <div class="flex-grow-1">
                                            <h2 class="d-flex align-items-center fs-4 fw-bolder flex-wrap">
                                                Jenis Kasus
                                            </h2>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::Description-->
                                </label>
                            </div>
                            <!--end::Radio button-->

                        </div>
                        <div class="mb-5" v-if="single.tipe == 'kategori-kasus' || single.tipe == 'jenis-kasus'">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.tipePermasalahan.$error ? 'text-danger' : ''">Tipe
                                Permasalahan</label>
                            <app-select-single v-model="single.tipePermasalahan"
                                :placeholder="'Pilih tipe permasalahan'"
                                :loading="pageStatus == 'tipe-permasalahan-load'" :options="list_tipe_permasalahan"
                                :serverside="true" @change-search="getTipePermasalahan">
                            </app-select-single>
                            <div v-if="v$.single.tipePermasalahan.$error" class="text-danger">Tipe Permasalahan tidak
                                boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5" v-if="single.tipe == 'jenis-kasus'">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.kategoriKasus.$error ? 'text-danger' : ''">Kategori Kasus</label>
                            <app-select-single v-model="single.kategoriKasus" :placeholder="'Pilih kategori kasus'"
                                :loading="pageStatus == 'kategori-kasus-load'" :options="list_kategori_kasus"
                                :disabled="!single.tipePermasalahan.id" :serverside="true"
                                @change-search="getKategoriKasus">
                            </app-select-single>
                            <div v-if="v$.single.kategoriKasus.$error" class="text-danger">Kategori kasus tidak
                                boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.name.$error ? 'text-danger' : ''">Nama</label>
                            <input class="form-control" type="text" placeholder="Contoh: Permasalahan Sosial"
                                autocomplete="off" v-model="single.name" />
                            <div v-if="v$.single.name.$error" class="text-danger"> Nama tidak boleh kosong!
                            </div>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mt-5" v-if="single.tipe == 'tipe-permasalahan'">
                            <!--begin::Input-->
                            <input class="form-check-input me-3" name="checkbox_input" type="checkbox"
                                id="has_nik" v-model="single.isInputPreparator" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="form-check-label" for="has_nik">
                                <div class="fw-bolder text-gray-800">Tidak Perlu Input Data Pelaku Ketika Penjangkauan</div>
                            </label>
                            <!--end::Label-->
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
        required,
        requiredIf
    } from '@vuelidate/validators'

    export default {
        data() {
            return {
                v$: useVuelidate(),
                pageStatus: 'standby',
                flag: 'insert',
                list_tipe_permasalahan: [],
                list_kategori_kasus: [],
                list_kategori_kasus_filter: [],
                list_tipe_permasalahan_filter: [],
                single: {
                    tipe_header: 'tipe-permasalahan',

                    id: '',
                    tipe: '',
                    tipePermasalahan: {},
                    kategoriKasus: {},
                    name: '',
                    isInputPreparator: false,

                    filter: {
                        tipePermasalahan: {
                            id: '0',
                            text: 'Semua Tipe Permasalahan'
                        },
                        kategoriKasus: {
                            id: '0',
                            text: 'Semua Kategori'
                        },
                    }


                },
                tableTipePermasalahan: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                            {
                                text: 'TIPE PERMASALAHAN',
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

                tableKategoriKasus: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                            {
                                text: 'TIPE PERMASALAHAN',
                                sort_by: 'tipe_permasalahan_name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'KATEGORI KASUS',
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

                tableJenisKasus: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                            {
                                text: 'TIPE PERMASALAHAN',
                                sort_by: 'tipe_permasalahan_name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'KATEGORI KASUS',
                                sort_by: 'kategori_kasus_name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'JENIS KASUS',
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

                    tipePermasalahan: {
                        required: requiredIf(function () {
                            return this.single.tipe == 'kategori-kasus' || this.single.tipe ==
                                'jenis-kasus';
                        })
                    },
                    kategoriKasus: {
                        required: requiredIf(function () {
                            return this.single.tipe == 'jenis-kasus';
                        })
                    },

                    name: {
                        required
                    },

                },
            }
        },
        watch: {
            'single.tipe': function () {
                this.single.tipePermasalahan = {};
                this.single.name = '';
                this.single.isInputPreparator = false;
                this.single.kategoriKasus = {};

                this.v$.$reset();

                this.list_kategori_kasus = [];
                this.list_tipe_permasalahan = [];
            },
            'single.tipePermasalahan': function () {
                this.single.kategoriKasus = {};

                this.list_kategori_kasus = [];
                this.list_tipe_permasalahan = [];
            },
            'single.tipe_header': function (newValue) {

                this.single.filter.tipePermasalahan = {
                    id: '0',
                    text: 'Semua Tipe Permasalahan'
                };
                this.list_tipe_permasalahan_filter = [];


                this.single.filter.kategoriKasus = {
                    id: '0',
                    text: 'Semua Kategori'
                };
                this.list_kategori_kasus_filter = [];

                if (newValue == 'tipe-permasalahan') {
                    this.getDataTableTipePermasalahan();
                } else if (newValue == 'kategori-kasus') {
                    this.getDataTableKategoriKasus();
                } else if (newValue == 'jenis-kasus') {
                    this.getDataTableJenisKasus();
                }
            },
            'single.filter.tipePermasalahan': function () {
                this.single.filter.kategoriKasus = {
                    id: '0',
                    text: 'Semua Kategori'
                };
                this.list_kategori_kasus_filter = [];
            }
        },
        computed: {
            filter_list_kategori_kasus_computed() {
                let response = [];

                response.push({
                    id: '0',
                    text: 'Semua Kategori'
                });

                for (let i = 0; i < this.list_kategori_kasus_filter.length; i++) {
                    response.push(this.list_kategori_kasus_filter[i]);
                }

                return response;
            },
            filter_list_tipe_permasalahan_computed() {
                let response = [];

                response.push({
                    id: '0',
                    text: 'Semua Tipe Permasalahan'
                });

                for (let i = 0; i < this.list_tipe_permasalahan_filter.length; i++) {
                    response.push(this.list_tipe_permasalahan_filter[i]);
                }

                return response;
            }
        },
        mounted() {
            reinitializeAllPlugin();

            this.getDataTableTipePermasalahan();
        },
        methods: {
            resetDataTable() {

                setTimeout(() => {
                    if (this.single.tipe_header == 'tipe-permasalahan') {
                        this.tableTipePermasalahan.config.current_page = 1;
                        this.getDataTableTipePermasalahan();
                    } else if (this.single.tipe_header == 'kategori-kasus') {
                        this.tableKategoriKasus.config.current_page = 1;
                        this.getDataTableKategoriKasus();
                    } else if (this.single.tipe_header == 'jenis-kasus') {
                        this.tableJenisKasus.config.current_page = 1;
                        this.getDataTableJenisKasus();
                    }
                }, 100);


            },
            showModalAdd() {
                this.reset();

                $("#modal-form").modal('show');
            },
            edit(id, type) {
                this.reset();

                this.single.tipe = type;

                setTimeout(() => {
                    if (type == 'tipe-permasalahan') {
                        const index = this.tableTipePermasalahan.feeder.data.findIndex((e) => e.id == id);
                        if (index >= 0) {
                            this.single.id = this.tableTipePermasalahan.feeder.data[index].id;
                            this.single.name = this.tableTipePermasalahan.feeder.data[index].name;
                            this.single.isInputPreparator = !this.tableTipePermasalahan.feeder.data[index].butuh_pelaku;
                        }
                    } else if (type == 'kategori-kasus') {
                        const index = this.tableKategoriKasus.feeder.data.findIndex((e) => e.id == id);
                        if (index >= 0) {
                            this.single.id = this.tableKategoriKasus.feeder.data[index].id;
                            this.single.name = this.tableKategoriKasus.feeder.data[index].name;
                        }

                        setTimeout(() => {
                            if (this.tableKategoriKasus.feeder.data[index].id_tipe_permasalahan && this
                                .tableKategoriKasus.feeder.data[index].tipe_permasalahan_name) {
                                this.single.tipePermasalahan = {
                                    id: this.tableKategoriKasus.feeder.data[index]
                                        .id_tipe_permasalahan,
                                    text: this.tableKategoriKasus.feeder.data[index]
                                        .tipe_permasalahan_name
                                }
                            }
                        }, 300);
                    } else if (type == 'jenis-kasus') {
                        const index = this.tableJenisKasus.feeder.data.findIndex((e) => e.id == id);
                        if (index >= 0) {
                            this.single.id = this.tableJenisKasus.feeder.data[index].id;
                            this.single.name = this.tableJenisKasus.feeder.data[index].name;
                        }

                        setTimeout(() => {
                            if (this.tableJenisKasus.feeder.data[index].id_tipe_permasalahan && this
                                .tableJenisKasus.feeder.data[index].tipe_permasalahan_name) {
                                this.single.tipePermasalahan = {
                                    id: this.tableJenisKasus.feeder.data[index]
                                        .id_tipe_permasalahan,
                                    text: this.tableJenisKasus.feeder.data[index]
                                        .tipe_permasalahan_name
                                }
                            }
                        }, 300);


                        setTimeout(() => {
                            if (this.tableJenisKasus.feeder.data[index].id_kategori_kasus && this
                                .tableJenisKasus.feeder.data[index].kategori_kasus_name) {
                                this.single.kategoriKasus = {
                                    id: this.tableJenisKasus.feeder.data[index]
                                        .id_kategori_kasus,
                                    text: this.tableJenisKasus.feeder.data[index]
                                        .kategori_kasus_name
                                }
                            }
                        }, 500);
                    }
                }, 200);


                this.flag = 'update';

                $("#modal-form").modal('show');
            },
            getDataTableTipePermasalahan() {
                this.tableTipePermasalahan.config.loading = true;
                this.tableTipePermasalahan.feeder.data = [];

                let params = {
                    page: this.tableTipePermasalahan.config.current_page,
                    limit: this.tableTipePermasalahan.config.show_per_page,
                    sortby: this.tableTipePermasalahan.config.sort_by,
                    order: this.tableTipePermasalahan.config.order,
                    search: this.tableTipePermasalahan.config.search
                }

                Api().get(`m-tipe-permasalahan`, {
                        params
                    })
                    .then(response => {

                        let data = response.data.data;

                        this.tableTipePermasalahan.feeder.data = data;
                        this.tableTipePermasalahan.config.total_data = response.data.total;

                        this.tableTipePermasalahan.config.loading = false;
                    })
                    .catch(error => {

                        this.tableTipePermasalahan.config.loading = false;

                        this.tableTipePermasalahan.feeder.data = [];
                        this.tableTipePermasalahan.config.total_data = 0;

                        this.$axiosHandleError(error);
                    });
            },
            getDataTableKategoriKasus() {
                this.tableKategoriKasus.config.loading = true;
                this.tableKategoriKasus.feeder.data = [];

                let params = {
                    page: this.tableKategoriKasus.config.current_page,
                    limit: this.tableKategoriKasus.config.show_per_page,
                    sortby: this.tableKategoriKasus.config.sort_by,
                    order: this.tableKategoriKasus.config.order,
                    search: this.tableKategoriKasus.config.search
                }

                if (this.single.filter.tipePermasalahan && this.single.filter.tipePermasalahan.id != '0') {
                    Object.assign(params, {
                        id_tipe_permasalahan: this.single.filter.tipePermasalahan.id
                    })
                }

                Api().get(`m-kategori-kasus`, {
                        params
                    })
                    .then(response => {

                        let data = response.data.data;

                        this.tableKategoriKasus.feeder.data = data;
                        this.tableKategoriKasus.config.total_data = response.data.total;

                        this.tableKategoriKasus.config.loading = false;
                    })
                    .catch(error => {

                        this.tableKategoriKasus.config.loading = false;

                        this.tableKategoriKasus.feeder.data = [];
                        this.tableKategoriKasus.config.total_data = 0;

                        this.$axiosHandleError(error);
                    });
            },

            getDataTableJenisKasus() {
                this.tableJenisKasus.config.loading = true;
                this.tableJenisKasus.feeder.data = [];

                let params = {
                    page: this.tableJenisKasus.config.current_page,
                    limit: this.tableJenisKasus.config.show_per_page,
                    sortby: this.tableJenisKasus.config.sort_by,
                    order: this.tableJenisKasus.config.order,
                    search: this.tableJenisKasus.config.search
                }


                if (this.single.filter.tipePermasalahan && this.single.filter.tipePermasalahan.id != '0') {
                    Object.assign(params, {
                        id_tipe_permasalahan: this.single.filter.tipePermasalahan.id
                    })
                }


                if (this.single.filter.kategoriKasus && this.single.filter.kategoriKasus.id != '0') {
                    Object.assign(params, {
                        id_kategori_kasus: this.single.filter.kategoriKasus.id
                    })
                }

                Api().get(`m-jenis-kasus`, {
                        params
                    })
                    .then(response => {

                        let data = response.data.data;

                        this.tableJenisKasus.feeder.data = data;
                        this.tableJenisKasus.config.total_data = response.data.total;

                        this.tableJenisKasus.config.loading = false;
                    })
                    .catch(error => {

                        this.tableJenisKasus.config.loading = false;

                        this.tableJenisKasus.feeder.data = [];
                        this.tableJenisKasus.config.total_data = 0;

                        this.$axiosHandleError(error);
                    });
            },
            save() {
                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }

                this.$ewpLoadingShow();

                let formData = null;

                let responseType = '';

                let urlX = '';

                if (this.single.tipe == 'tipe-permasalahan') {
                    urlX = 'm-tipe-permasalahan';
                    responseType = 'tipe permasalahan';
                    formData = {
                        name: this.single.name,
                        butuh_pelaku: this.single.isInputPreparator ? 0 : 1
                    }
                } else if (this.single.tipe == 'kategori-kasus') {
                    urlX = 'm-kategori-kasus';
                    responseType = 'kategori kasus';
                    formData = {
                        name: this.single.name,
                        id_tipe_permasalahan: this.single.tipePermasalahan.id,
                    }
                } else if (this.single.tipe == 'jenis-kasus') {
                    urlX = 'm-jenis-kasus';
                    responseType = 'jenis kasus';
                    formData = {
                        name: this.single.name,
                        id_kategori_kasus: this.single.kategoriKasus.id,
                    }
                }


                Api().post(urlX, formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Menambahkan data ' + responseType,
                            icon: "success",
                        }).then(result => {

                            if (this.single.tipe == 'tipe-permasalahan') {
                                this.tableTipePermasalahan.config.current_page = 1;
                                this.getDataTableTipePermasalahan();
                            } else if (this.single.tipe == 'kategori-kasus') {
                                this.tableKategoriKasus.config.current_page = 1;
                                this.getDataTableKategoriKasus();
                            } else if (this.single.tipe == 'jenis-kasus') {
                                this.tableJenisKasus.config.current_page = 1;
                                this.getDataTableJenisKasus();
                            }
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

                this.$ewpLoadingShow();

                let formData = null;

                let responseType = '';

                let urlX = '';

                if (this.single.tipe == 'tipe-permasalahan') {
                    urlX = 'm-tipe-permasalahan/' + this.single.id;
                    responseType = 'tipe permasalahan';
                    formData = {
                        name: this.single.name,
                        butuh_pelaku: this.single.isInputPreparator ? 0 : 1
                    }
                } else if (this.single.tipe == 'kategori-kasus') {
                    urlX = 'm-kategori-kasus/' + this.single.id;
                    responseType = 'kategori kasus';
                    formData = {
                        name: this.single.name,
                        id_tipe_permasalahan: this.single.tipePermasalahan.id,
                    }
                } else if (this.single.tipe == 'jenis-kasus') {
                    urlX = 'm-jenis-kasus/' + this.single.id;
                    responseType = 'jenis kasus';
                    formData = {
                        name: this.single.name,
                        id_kategori_kasus: this.single.kategoriKasus.id,
                    }
                }



                Api().put(urlX, formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Memperbarui data ' + responseType,
                            icon: "success",
                        }).then(result => {

                            if (this.single.tipe == 'tipe-permasalahan') {
                                this.getDataTableTipePermasalahan();
                            } else if (this.single.tipe == 'kategori-kasus') {
                                this.getDataTableKategoriKasus();
                            } else if (this.single.tipe == 'jenis-kasus') {
                                this.getDataTableJenisKasus();
                            }
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            changeStatus(id, type) {
                this.$ewpLoadingShow();

                let urlX = '';

                if (type == 'tipe-permasalahan') {
                    urlX = 'm-tipe-permasalahan/' + id + '/switch-status';
                } else if (type == 'kategori-kasus') {
                    urlX = 'm-kategori-kasus/' + id + '/switch-status';
                } else if (type == 'jenis-kasus') {
                    urlX = 'm-jenis-kasus/' + id + '/switch-status';
                }
                Api().put(urlX)
                    .then(response => {
                        this.$toast.success("Status berhasil diubah!");
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                        if (type == 'tipe-permasalahan') {
                            this.getDataTableTipePermasalahan();
                        } else if (type == 'kategori-kasus') {
                            this.getDataTableKategoriKasus();
                        } else if (type == 'jenis-kasus') {
                            this.getDataTableJenisKasus();
                        } else {
                            return false;
                        }
                    }).then(() => {
                        this.$ewpLoadingHide();
                    })
            },

            getTipePermasalahan(keyword, limit) {

                this.pageStatus = 'tipe-permasalahan-load';

                Api().get(`m-tipe-permasalahan/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.list_tipe_permasalahan = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_tipe_permasalahan.push({
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
            getKategoriKasus(keyword, limit) {

                this.pageStatus = 'kategori-kasus-load';

                let idTipePermasalahan = this.single.tipePermasalahan.id;

                Api().get(
                        `m-kategori-kasus/lists?limit=${limit}&search=${keyword}&id_tipe_permasalahan=${idTipePermasalahan}`
                    )
                    .then(response => {

                        this.list_kategori_kasus = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_kategori_kasus.push({
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


            getTipePermasalahanFilter(keyword, limit) {

                this.pageStatus = 'tipe-permasalahan-filter-load';

                Api().get(`m-tipe-permasalahan/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.list_tipe_permasalahan_filter = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_tipe_permasalahan_filter.push({
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
            getKategoriKasusFilter(keyword, limit) {

                this.pageStatus = 'kategori-kasus-filter-load';

                let idTipePermasalahan = this.single.filter.tipePermasalahan.id;

                Api().get(
                        `m-kategori-kasus/lists?limit=${limit}&search=${keyword}&id_tipe_permasalahan=${idTipePermasalahan}`
                    )
                    .then(response => {

                        this.list_kategori_kasus_filter = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_kategori_kasus_filter.push({
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
                this.single.tipe = 'tipe-permasalahan';
                this.single.tipePermasalahan = {};
                this.single.kategoriKasus = {};
                this.single.name = '';
                this.single.isInputPreparator = false;
            }
        }
    }

</script>

<style scoped>
    .radio-disabled-custom {
        border: 0 !important;
        background-color: #f2f2f2 !important;
        background: #f2f2f2 !important;
    }

</style>
