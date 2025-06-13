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
                                                    style="font-size:20px !important;">Master User</span>
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
                                                <div class="col-lg-3">
                                                    <app-select-single v-model="single.filter.role"
                                                        :show_button_clear="false" :placeholder="'Pilih Role'"
                                                        :options="list_filter_role_computed" :serverside="false"
                                                        :loading="false" @option-change="getDataTable()">
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
                                                        <td class="text-left">
                                                            <span
                                                                v-if="context.id_role == ROLE_KONSELOR_ID">{{context.konselor_name}}</span>
                                                            <span
                                                                v-else-if="context.id_role == ROLE_OPD_ID">{{context.opd_name}}</span>
                                                            <span v-else>{{context.name}}</span>
                                                        </td>
                                                        <td class="text-left">{{context.username}}</td>
                                                        <td class="text-left fw-bolder">
                                                            <span
                                                                v-if="context.id_role == ROLE_ADMIN_ID">Administrator</span>
                                                            <span class="c-primary-custom"
                                                                v-if="context.id_role == ROLE_KABID_ID">Kabid</span>
                                                            <span class="text-danger"
                                                                v-if="context.id_role == ROLE_KADIS_ID">Kadis</span>
                                                            <span class="text-primary"
                                                                v-if="context.id_role == ROLE_KONSELOR_ID">Konselor</span>
                                                            <span class="text-info"
                                                                v-if="context.id_role == ROLE_SUBKORD_ID">Subkord</span>
                                                            <span class="text-success"
                                                                v-if="context.id_role == ROLE_OPD_ID">OPD</span>
                                                            <span class="text-dark"
                                                                v-if="context.id_role == ROLE_HOTLINE_ID">Hotline</span>
                                                            <span v-if="context.id_role == ROLE_KLIEN_ID">Klien</span>
                                                            <span v-if="context.id_role == ROLE_MAHASISWA_ID">Mahasiswa</span>
                                                            <span v-if="context.id_role == ROLE_FASILITATOR_ID">Fasilitator</span>
                                                            <span v-if="context.id_role == ROLE_PENULIS_KONTEN">Penulis Konten</span>
                                                            <span  class="text-primary" v-if="context.id_role == ROLE_PSIKOLOG_ID">Psikolog</span>
                                                            <span class="text-warning"
                                                                v-if="context.id_role == ROLE_ASISTEN_ID">Asisten</span>
                                                            <span class="text-warning" style="color:#75aa03 !important"
                                                                v-if="context.id_role == ROLE_KELURAHAN_ID">Kelurahan</span>
                                                            <span class="text-warning" style="color:#87006d !important"
                                                                v-if="context.id_role == ROLE_KECAMATAN_ID">Kecamatan</span>
                                                            <div class="text-gray-600" v-if="context.id_role == ROLE_KELURAHAN_ID">Kel. {{context.kelurahan_name ?? '-'}}, Kec. {{context.kecamatan_kelurahan_name ?? '-'}}</div>
                                                            <div class="text-gray-600" v-if="context.id_role == ROLE_KECAMATAN_ID">Kec. {{context.kecamatan_name ?? '-'}}</div>
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
                                                                    @click="confirmResetPassword(context.id)"
                                                                    style="cursor:pointer">


                                                                    <svg width="23" height="22" viewBox="0 0 23 22"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <g clip-path="url(#clip0_1232_44732)">
                                                                            <path opacity="0.3" fill-rule="evenodd"
                                                                                clip-rule="evenodd"
                                                                                d="M7.27406 2.59912C8.43123 2.10639 9.70465 1.83374 11.0417 1.83374C16.3575 1.83374 20.6667 6.143 20.6667 11.4587C20.6667 16.7745 16.3575 21.0837 11.0417 21.0837C5.72601 21.0837 1.41675 16.7745 1.41675 11.4587C1.41675 10.556 1.54104 9.68219 1.77345 8.85363L3.53866 9.34877C3.34791 10.0288 3.25008 10.7363 3.25008 11.4587C3.25008 15.762 6.73853 19.2504 11.0417 19.2504C15.345 19.2504 18.8334 15.762 18.8334 11.4587C18.8334 7.15553 15.345 3.66708 11.0417 3.66708C10.1698 3.66708 9.32058 3.81001 8.51974 4.08367L9.61127 5.38451C9.67482 5.46024 9.71218 5.55448 9.71777 5.65319C9.73209 5.90591 9.53883 6.12239 9.2861 6.13672L4.82471 6.38953C4.78028 6.39205 4.73573 6.38809 4.69244 6.37776C4.44622 6.31903 4.29422 6.07182 4.35296 5.82559L5.38742 1.48872C5.41024 1.39302 5.46326 1.3072 5.53863 1.24396C5.73254 1.08125 6.02164 1.10654 6.18435 1.30045L7.27406 2.59912Z"
                                                                                fill="#F1416C" />
                                                                            <path fill-rule="evenodd"
                                                                                clip-rule="evenodd"
                                                                                d="M13.7917 10.082C14.298 10.082 14.7084 10.4924 14.7084 10.9987V13.7487C14.7084 14.255 14.298 14.6654 13.7917 14.6654H9.20841C8.70215 14.6654 8.29175 14.255 8.29175 13.7487V10.9987C8.29175 10.4924 8.70215 10.082 9.20841 10.082V9.6237C9.20841 8.35805 10.2344 7.33203 11.5001 7.33203C12.7657 7.33203 13.7917 8.35805 13.7917 9.6237V10.082ZM11.5001 8.2487C10.7407 8.2487 10.1251 8.86431 10.1251 9.6237V10.082H12.8751V9.6237C12.8751 8.86431 12.2595 8.2487 11.5001 8.2487Z"
                                                                                fill="#F1416C" />
                                                                        </g>
                                                                        <defs>
                                                                            <clipPath id="clip0_1232_44732">
                                                                                <rect width="22" height="22"
                                                                                    fill="white"
                                                                                    transform="translate(0.5)" />
                                                                            </clipPath>
                                                                        </defs>
                                                                    </svg>


                                                                </div>
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
                            {{flag == 'insert' ? 'Tambah Data User' : 'Edit Data User'}}</h5>
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
                                :class="v$.single.role.$error ? 'text-danger' : ''">Role</label>
                            <app-select-single v-model="single.role" :placeholder="'Pilih Role'" :show_search="false"
                                :options="list_role" :serverside="false">
                            </app-select-single>
                            <div v-if="v$.single.role.$error" class="text-danger">Role tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5" v-if="single.role.id == ROLE_KONSELOR_ID">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.konselor.$error ? 'text-danger' : ''">Konselor</label>
                            <app-select-single v-model="single.konselor" :placeholder="'Pilih Konselor'"
                                :options="list_konselor" :serverside="true" :loading="pageStatus == 'konselor-load'"
                                @change-search="getKonselor">
                            </app-select-single>
                            <div v-if="v$.single.konselor.$error" class="text-danger">Konselor tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5" v-if="single.role.id == ROLE_PSIKOLOG_ID">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.psikolog.$error ? 'text-danger' : ''">Psikolog</label>
                            <app-select-single v-model="single.psikolog" :placeholder="'Pilih Psikolog'"
                                :options="list_psikolog" :serverside="true" :loading="pageStatus == 'psikolog-load'"
                                @change-search="getPsikolog">
                            </app-select-single>
                            <div v-if="v$.single.psikolog.$error" class="text-danger">Konselor tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5" v-if="single.role.id == ROLE_KECAMATAN_ID || single.role.id == ROLE_KELURAHAN_ID">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.kecamatan.$error ? 'text-danger' : ''">Kecamatan</label>
                            <app-select-single v-model="single.kecamatan" :placeholder="'Pilih Kecamatan'" :options="list_kecamatan" @option-change="single.kelurahan = {};list_kelurahan = []"
                                :serverside="true" :loading="pageStatus == 'kecamatan-load'" @change-search="getKecamatan">
                            </app-select-single>
                            <div v-if="v$.single.kecamatan.$error" class="text-danger">Kecamatan tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5" v-if="single.role.id == ROLE_KELURAHAN_ID">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.kelurahan.$error ? 'text-danger' : ''">Kelurahan</label>
                            <app-select-single v-model="single.kelurahan" :placeholder="'Pilih Kelurahan'" :options="list_kelurahan" :disabled="!single.kecamatan.id"
                                :serverside="true" :loading="pageStatus == 'kelurahan-load'" @change-search="getKelurahan">
                            </app-select-single>
                            <div v-if="v$.single.kelurahan.$error" class="text-danger">Kelurahan tidak boleh kosong!
                            </div>
                        </div>
                          <div class="mb-5" v-if="single.role.id == ROLE_OPD_ID">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.opd.$error ? 'text-danger' : ''">OPD</label>
                            <app-select-single v-model="single.opd" :placeholder="'Pilih OPD'" :options="list_opd"
                                :serverside="true" :loading="pageStatus == 'opd-load'" @change-search="getOpd">
                            </app-select-single>
                            <div v-if="v$.single.opd.$error" class="text-danger">OPD tidak boleh kosong!
                            </div>
                        </div>                     
                        <div class="mb-5" v-if="single.role.id != ROLE_KONSELOR_ID && single.role.id != ROLE_OPD_ID">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.name.$error ? 'text-danger' : ''">Nama Pengguna</label>
                            <input class="form-control" type="text" placeholder="Masukkan nama user" autocomplete="off"
                                v-model="single.name" />
                            <div v-if="v$.single.name.$error" class="text-danger">Nama pengguna tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.username.$error ? 'text-danger' : ''">Username</label>
                            <input class="form-control" type="text" placeholder="Masukkan username"
                                v-model="single.username" autocomplete="off" />
                            <div v-if="v$.single.username.$error" class="text-danger">Username tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-5" v-if="flag == 'insert'">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.password.$error ? 'text-danger' : ''">Password</label>
                            <div class="input-group">
                                <input :type="hidePassword ? 'password' : 'text'" class="form-control"
                                    v-model="single.password" placeholder="Masukkan password" />
                                <span class="input-group-text">
                                    <i @click="hidePassword = !hidePassword" style="cursor:pointer"
                                        :class="hidePassword ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                                </span>
                            </div>
                            <div v-if="v$.single.password.$error" class="text-danger">Minimal panjang 6 karakter
                            </div>
                        </div>
                        <div class="mb-5" v-if="flag == 'insert'">
                            <label class="form-label fw-bolder fs-6"
                                :class="v$.single.confirm_password.$error ? 'text-danger' : ''">Konfirmasi
                                Password</label>
                            <div class="input-group">
                                <input :type="hidePasswordConfirm ? 'password' : 'text'" class="form-control"
                                    v-model="single.confirm_password" placeholder="Masukkan password" />
                                <span class="input-group-text">
                                    <i @click="hidePasswordConfirm = !hidePasswordConfirm" style="cursor:pointer"
                                        :class="hidePasswordConfirm ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                                </span>
                            </div>
                            <div v-if="v$.single.confirm_password.$error" class="text-danger">Harus sama dengan
                                password!
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
        required,
        sameAs,
        requiredIf,
        minLength
    } from '@vuelidate/validators'

    export default {
        data() {
            return {
                v$: useVuelidate(),
                pageStatus: 'standby',
                flag: 'insert',
                hidePassword: true,
                hidePasswordConfirm: true,
                ROLE_ADMIN_ID: process.env.MIX_ROLE_ADMIN_ID,
                ROLE_KABID_ID: process.env.MIX_ROLE_KABID_ID,
                ROLE_KADIS_ID: process.env.MIX_ROLE_KADIS_ID,
                ROLE_KONSELOR_ID: process.env.MIX_ROLE_KONSELOR_ID,
                ROLE_KLIEN_ID: process.env.MIX_ROLE_KLIEN_ID,
                ROLE_PSIKOLOG_ID: process.env.MIX_ROLE_PSIKOLOG_ID,
                ROLE_SUBKORD_ID: process.env.MIX_ROLE_SUBKORD_ID,
                ROLE_OPD_ID: process.env.MIX_ROLE_OPD_ID,
                ROLE_HOTLINE_ID: process.env.MIX_ROLE_HOTLINE_ID,
                ROLE_ASISTEN_ID: process.env.MIX_ROLE_ASISTEN_ID,
                ROLE_KELURAHAN_ID: process.env.MIX_ROLE_KELURAHAN_ID,
                ROLE_KECAMATAN_ID: process.env.MIX_ROLE_KECAMATAN_ID,
                ROLE_MAHASISWA_ID: process.env.MIX_ROLE_MAHASISWA_ID,
                ROLE_FASILITATOR_ID: process.env.MIX_ROLE_FASILITATOR_ID,
                ROLE_PENULIS_KONTEN: process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                list_role: [{
                        id: process.env.MIX_ROLE_ADMIN_ID,
                        text: 'Administrator'
                    },
                    {
                        id: process.env.MIX_ROLE_HOTLINE_ID,
                        text: 'Hotline'
                    },
                    {
                        id: process.env.MIX_ROLE_KABID_ID,
                        text: 'Kabid'
                    },
                    {
                        id: process.env.MIX_ROLE_KADIS_ID,
                        text: 'Kadis'
                    },
                    {
                        id: process.env.MIX_ROLE_KONSELOR_ID,
                        text: 'Konselor'
                    },
                    {
                        id: process.env.MIX_ROLE_PSIKOLOG_ID,
                        text: 'Psikolog'
                    },
                    {
                        id: process.env.MIX_ROLE_SUBKORD_ID,
                        text: 'Subkord'
                    },
                    {
                        id: process.env.MIX_ROLE_OPD_ID,
                        text: 'OPD'
                    },
                    {
                        id: process.env.MIX_ROLE_ASISTEN_ID,
                        text: 'Asisten'
                    },
                    {
                        id: process.env.MIX_ROLE_KECAMATAN_ID,
                        text: 'Kecamatan'
                    },
                    {
                        id: process.env.MIX_ROLE_KELURAHAN_ID,
                        text: 'Kelurahan'
                    },
                    {
                        id: process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                        text: 'Penulis Konten'
                    },
                    {
                        id: process.env.MIX_ROLE_FASILITATOR_ID,
                        text: 'Fasilitator'
                    },
                    {
                        id: process.env.MIX_ROLE_MAHASISWA_ID,
                        text: 'Mahasiswa'
                    },
                    {
                        id: process.env.MIX_ROLE_KLIEN_ID,
                        text: 'Klien'
                    },
                ],
                list_konselor: [],
                list_psikolog: [],
                list_opd: [],
                list_kecamatan: [],
                list_kelurahan: [],
                single: {
                    id: '',
                    role: {},
                    name: '',
                    konselor: {},
                    psikolog: {},
                    kecamatan: {},
                    kelurahan: {},
                    opd: {},
                    password: '',
                    confirm_password: '',
                    username: '',
                    filter: {
                        role: {}
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
                                text: 'NAMA',
                                sort_by: 'name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'USERNAME',
                                sort_by: 'username',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'ROLE',
                                sort_by: 'id_role',
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
        watch: {
            'single.role'() {
                this.single.name = '';
                this.single.konselor = {};
                this.single.psikolog = {};
                this.single.opd = {};
                this.single.kecamatan = {};
                this.single.kelurahan = {};
            }
        },
        validations() {
            return {
                single: {
                    role: {
                        required
                    },
                    username: {
                        required
                    },
                    name: {
                        required: requiredIf(function () {
                            return this.single.role.id == this.ROLE_ADMIN_ID || this.single.role.id == this
                                .ROLE_KABID_ID || this.single.role
                                .id == this.ROLE_KADIS_ID || this.single.role.id == this.ROLE_SUBKORD_ID || this
                                .single.role.id == this.ROLE_HOTLINE_ID || this.single.role.id == this
                                .ROLE_ASISTEN_ID || this.single.role.id == this
                                .ROLE_KECAMATAN_ID || this.single.role.id == this
                                .ROLE_KELURAHAN_ID
                        })
                    },
                    konselor: {
                        require: requiredIf(function () {
                            return this.single.role.id == this.ROLE_KONSELOR_ID
                        })
                    },
                    psikolog: {
                        require: requiredIf(function () {
                            return this.single.role.id == this.ROLE_PSIKOLOG_ID
                        })
                    },
                    kecamatan: {
                        require: requiredIf(function () {
                            return this.single.role.id == this.ROLE_KECAMATAN_ID || this.single.role.id == this.ROLE_KELURAHAN_ID
                        })
                    },
                    kelurahan: {
                        require: requiredIf(function () {
                            return this.single.role.id == this.ROLE_KELURAHAN_ID
                        })
                    },
                    opd: {
                        require: requiredIf(function () {
                            return this.single.role.id == this.ROLE_OPD_ID
                        })
                    },
                    password: {
                        require: requiredIf(function () {
                            return this.flag == 'insert'
                        }),
                        minLength: minLength(6),
                    },
                    confirm_password: {
                        require: requiredIf(function () {
                            return this.flag == 'insert'
                        }),
                        sameAsPassword: sameAs(this.single.password),
                    },
                },
            }
        },
        computed: {
            list_filter_role_computed() {
                let response = [];

                let all = [{
                    id: '-',
                    text: 'Semua'
                }]

                response = all.concat(this.list_role);

                return response;
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

                    this.single.id = id;
                    if (this.tableConfig.feeder.data[index].id_role && this.tableConfig.feeder.data[index].role_name) {
                        this.single.role = {
                            id: this.tableConfig.feeder.data[index].id_role,
                            text: this.tableConfig.feeder.data[index].role_name
                        }
                    }

                    setTimeout(() => {
                        this.single.name = this.tableConfig.feeder.data[index].name;


                        if (this.tableConfig.feeder.data[index].id_role == this.ROLE_OPD_ID) {
                            if (this.tableConfig.feeder.data[index].id_opd && this.tableConfig.feeder.data[
                                    index]
                                .opd_name) {
                                this.single.opd = {
                                    id: this.tableConfig.feeder.data[index].id_opd,
                                    text: this.tableConfig.feeder.data[index].opd_name
                                }
                            }

                        } else if (this.tableConfig.feeder.data[index].id_role == this.ROLE_KONSELOR_ID) {
                            if (this.tableConfig.feeder.data[index].id_konselor && this.tableConfig.feeder.data[
                                    index]
                                .konselor_name) {
                                this.single.konselor = {
                                    id: this.tableConfig.feeder.data[index].id_konselor,
                                    text: this.tableConfig.feeder.data[index].konselor_name
                                }
                            }
                        }

                        if(this.tableConfig.feeder.data[index].id_role == this.ROLE_KECAMATAN_ID){
                            if (this.tableConfig.feeder.data[index].id_kecamatan && this.tableConfig.feeder.data[index].kecamatan_name) {
                                this.single.kecamatan = {
                                    id: this.tableConfig.feeder.data[index].id_kecamatan,
                                    text: this.tableConfig.feeder.data[index].kecamatan_name
                                }
                            }
                        }

                        if(this.tableConfig.feeder.data[index].id_role == this.ROLE_KELURAHAN_ID){
                            if (this.tableConfig.feeder.data[index].kecamatan_kelurahan_id && this.tableConfig.feeder.data[index].kecamatan_kelurahan_name) {
                                this.single.kecamatan = {
                                    id: this.tableConfig.feeder.data[index].kecamatan_kelurahan_id,
                                    text: this.tableConfig.feeder.data[index].kecamatan_kelurahan_name
                                }
                            }

                            if (this.tableConfig.feeder.data[index].id_kelurahan && this.tableConfig.feeder.data[index].kelurahan_name) {
                                this.single.kelurahan = {
                                    id: this.tableConfig.feeder.data[index].id_kelurahan,
                                    text: this.tableConfig.feeder.data[index].kelurahan_name
                                }
                            }
                        }

                        this.single.username = this.tableConfig.feeder.data[index].username;
                    }, 500);

                }


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

                if (this.single.filter.role.id && this.single.filter.role.id !== '-') {
                    Object.assign(params, {
                        id_role: this.single.filter.role.id,
                    })
                }

                Api().get(`m-user`, {
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
                    id_role: this.single.role.id,
                    id_konselor: this.single.role.id == this.ROLE_KONSELOR_ID ? this.single.konselor.id : '',
                    id_psikolog_volunteer: this.single.role.id == this.ROLE_PSIKOLOG_ID ? this.single.psikolog.id : '',
                    id_opd: this.single.role.id == this.ROLE_OPD_ID ? this.single.opd.id : '',
                    id_kecamatan: this.single.role.id == this.ROLE_KECAMATAN_ID ? this.single.kecamatan.id : '',
                    id_kelurahan: this.single.role.id == this.ROLE_KELURAHAN_ID ? this.single.kelurahan.id : '',
                    username: this.single.username,
                    password: this.single.password,
                    password_confirmation: this.single.confirm_password
                }

                if (this.single.role.id != this.ROLE_KONSELOR_ID && this.single.role.id != this.ROLE_OPD_ID) {
                    Object.assign(formData, {
                        name: this.single.name
                    })
                }


                Api().post('m-user', formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Menambahkan data user',
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
                    id_role: this.single.role.id,
                    id_konselor: this.single.role.id == this.ROLE_KONSELOR_ID ? this.single.konselor.id : '',
                    id_psikolog_volunteer: this.single.role.id == this.ROLE_PSIKOLOG_ID ? this.single.psikolog.id : '',
                    id_opd: this.single.role.id == this.ROLE_OPD_ID ? this.single.opd.id : '',
                    id_kecamatan: this.single.role.id == this.ROLE_KECAMATAN_ID ? this.single.kecamatan.id : '',
                    id_kelurahan: this.single.role.id == this.ROLE_KELURAHAN_ID ? this.single.kelurahan.id : '',
                    username: this.single.username,
                }

                if (this.single.role.id != this.ROLE_KONSELOR_ID && this.single.role.id != this.ROLE_OPD_ID) {
                    Object.assign(formData, {
                        name: this.single.name
                    })
                }
                

                this.$ewpLoadingShow();

                Api().put(`m-user/${this.single.id}`, formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Memperbarui data user',
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
                Api().put(`m-user/${id}/switch-status`)
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
            confirmResetPassword(id) {
                this.$swal({
                    title: 'Reset Password?',
                    text: "Password user akan dikembalikan ke default password yaitu:" + process.env
                        .MIX_DEFAULT_PASSWORD,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F64E60',
                    cancelButtonColor: '#FFFFFF',
                    cancelButtonTextColor: "black",
                    confirmButtonText: 'Ya, Reset',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.resetPassword(id);
                    }
                });
            },
            resetPassword(id) {

                this.$ewpLoadingShow();
                Api().put(`m-user/${id}/reset-password`)
                    .then(response => {
                        this.$toast.success(`Berhasil reset password user!`);
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            getOpd(keyword, limit) {

                this.pageStatus = 'opd-load';

                Api().get(`m-opd/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.list_opd = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_opd.push({
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
            getKonselor(keyword, limit) {

                this.pageStatus = 'konselor-load';

                Api().get(`m-konselor/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.list_konselor = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_konselor.push({
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
            getPsikolog(keyword, limit) {

                this.pageStatus = 'psikolog-load';

                Api().get(`database/psikolog-volunteer/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.list_psikolog = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_psikolog.push({
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
            getKelurahan(keyword, limit) {

                this.pageStatus = 'kelurahan-load';

                Api().get(`m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${this.single.kecamatan.id}`)
                    .then(response => {

                        this.list_kelurahan = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list_kelurahan.push({
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
                this.single.role = {};
                this.single.name = '';
                this.single.konselor = {};
                this.single.opd = {};
                this.single.kecamatan = {};
                this.single.kelurahan = {};
                this.single.password = '';
                this.single.confirm_password = '';
                this.single.username = '';

                this.list_kelurahan = [];
            }
        }
    }

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
