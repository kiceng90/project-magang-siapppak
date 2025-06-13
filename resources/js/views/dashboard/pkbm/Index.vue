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
                                                    style="font-size:20px !important;">PKBM</span>
                                            </h3>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm c-primary-custom me-3"
                                                    style="background: #FFF4DD !important;color:#EE7B33 !important"
                                                    @click="exportData">
                                                    <span>
                                                        <svg width="22" height="23" viewBox="0 0 22 23" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M5.36913 2.33203H12.5918C12.9169 2.33203 13.2315 2.44724 13.4798 2.65721L17.8464 6.35064C18.1553 6.6119 18.3334 6.99592 18.3334 7.40047V18.9084C18.3334 20.5497 18.3147 20.6654 16.631 20.6654H5.36913C3.68549 20.6654 3.66675 20.5497 3.66675 18.9084V4.08898C3.66675 2.44765 3.68549 2.33203 5.36913 2.33203Z"
                                                                fill="#EE7B33" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M8.20541 13.1654H9.99885V15.0057C9.99885 15.2589 10.2041 15.4641 10.4572 15.4641H11.3952C11.6483 15.4641 11.8535 15.2589 11.8535 15.0057V13.1654H13.647C13.9001 13.1654 14.1053 12.9602 14.1053 12.707C14.1053 12.5986 14.0668 12.4936 13.9968 12.4109L11.276 9.19734C11.1124 9.00415 10.8232 8.98014 10.63 9.1437C10.6107 9.16007 10.5928 9.17801 10.5764 9.19734L7.85562 12.4109C7.69205 12.604 7.71606 12.8933 7.90925 13.0568C7.99202 13.1269 8.09696 13.1654 8.20541 13.1654Z"
                                                                fill="#EE7B33" />
                                                        </svg>
                                                        &ensp;Export Data</span>
                                                </button>
                                                <button type="button" class="btn btn-sm c-primary-custom me-3" v-if="$store.state.profile.role_id == ROLE_KECAMATAN_ID"
                                                    style="background: #FFF4DD !important;color:#EE7B33 !important"
                                                    @click="showModalImport">
                                                    <span>
                                                        <svg width="22" height="23" viewBox="0 0 22 23" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M5.36913 2.33203H12.5918C12.9169 2.33203 13.2315 2.44724 13.4798 2.65721L17.8464 6.35064C18.1553 6.6119 18.3334 6.99592 18.3334 7.40047V18.9084C18.3334 20.5497 18.3147 20.6654 16.631 20.6654H5.36913C3.68549 20.6654 3.66675 20.5497 3.66675 18.9084V4.08898C3.66675 2.44765 3.68549 2.33203 5.36913 2.33203Z"
                                                                fill="#EE7B33" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M8.20541 13.1654H9.99885V15.0057C9.99885 15.2589 10.2041 15.4641 10.4572 15.4641H11.3952C11.6483 15.4641 11.8535 15.2589 11.8535 15.0057V13.1654H13.647C13.9001 13.1654 14.1053 12.9602 14.1053 12.707C14.1053 12.5986 14.0668 12.4936 13.9968 12.4109L11.276 9.19734C11.1124 9.00415 10.8232 8.98014 10.63 9.1437C10.6107 9.16007 10.5928 9.17801 10.5764 9.19734L7.85562 12.4109C7.69205 12.604 7.71606 12.8933 7.90925 13.0568C7.99202 13.1269 8.09696 13.1654 8.20541 13.1654Z"
                                                                fill="#EE7B33" />
                                                        </svg>
                                                        &ensp;Import Data</span>
                                                </button>
                                                <button type="button" class="btn btn-sm bg-primary-custom" v-if="$store.state.profile.role_id == ROLE_KECAMATAN_ID"
                                                    @click="showModalAdd">
                                                    <span class="text-white">Tambah Data</span>
                                                </button>
                                            </div>

                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 mb-5">
                                                    <div class="w-100 py-5 px-3"
                                                        style="border-radius:10px;border:1px #ddd solid;height:100%">
                                                        <div class="fw-bolder text-center c-primary-custom"
                                                            style="font-size:20px;">
                                                            {{single.header.loading? 'Loading..' : $rupiahFormat(single.header.member) + ' Orang'}}
                                                        </div>
                                                        <div class="text-center text-gray-600 pt-3">Jumlah Anggota</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 mb-5">
                                                    <div class="w-100 py-5 px-3"
                                                        style="border-radius:10px;border:1px #ddd solid;height:100%">
                                                        <div class="fw-bolder text-center c-primary-custom"
                                                            style="font-size:20px;">
                                                            {{single.header.loading? 'Loading..' : $rupiahFormat(single.header.village)}}
                                                        </div>
                                                        <div class="text-center text-gray-600 pt-3">Jumlah Kelurahan
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 mb-5">
                                                    <div class="w-100 py-5 px-3"
                                                        style="border-radius:10px;border:1px #ddd solid;height:100%">
                                                        <div class="fw-bolder text-center c-primary-custom"
                                                            style="font-size:20px;">
                                                            {{single.header.loading? 'Loading..' : $rupiahFormat(single.header.subDistrict)}}
                                                        </div>
                                                        <div class="text-center text-gray-600 pt-3">Jumlah Kecamatan
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-2 pb-5">
                                                    <div style="font-size:20px;font-weight:600;" class="pt-2">Filter
                                                        Data</div>
                                                </div>
                                                <div class="col-lg-4 mb-5">
                                                    <app-select-single v-model="single.filter.subDistrict"
                                                        :show_button_clear="false" :placeholder="'Pilih kecamatan'"
                                                        :options="listSubDistrictFilter" :serverside="true"
                                                        :loading="pageStatus == 'sub-district-filter-load'"
                                                        @change-search="getSubDistrictFilter"
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
                                                        <td class="text-left">
                                                            <div class="d-flex align-items-center">
                                                                <img class="me-3" :src="context.foto"
                                                                    style="width:50px;height:50px;border-radius:5px;">
                                                                <div>
                                                                    <div>{{context.name}}</div>
                                                                    <div class="text-gray-600">{{context.nik}}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left">
                                                            <div>{{context.sk_number}}</div>
                                                            <div class="text-gray-600">{{context.sk_date}}</div>
                                                        </td>
                                                        <td class="text-left">
                                                            <div>{{context.jabatan_dalam_instansi_name}}</div>
                                                            <div><span class="text-gray-400">Dalam SK. </span><span
                                                                    class="text-gray-600">{{context.kedudukan_dalam_tim_name}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-left">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <div>{{context.creator_name}}</div>
                                                                    <!-- <div class="text-gray-600">Kel.
                                                                        {{context.kelurahan_domisili_name}}</div>-->
                                                                </div>
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
                                                                            @click="edit(context.id)">Edit</a></li>
                                                                    <li v-if="context.foto"><a class="dropdown-item py-3"
                                                                            :href="context.foto" target="_blank"
                                                                            download>Unduh Foto</a>
                                                                    </li>
                                                                    <li v-if="context.ktp_link"><a class="dropdown-item py-3"
                                                                            :href="context.ktp_link" target="_blank"
                                                                            download>Unduh KTP</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="skDownload(context.id, context.name)">Unduh
                                                                            SK</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item py-3"
                                                                            href="javascript:void(0);"
                                                                            @click="pdfGenerate(context.id, context.name)">Cetak
                                                                            PDF</a>
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
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{flag == 'insert' ? 'Tambah Data PKBM' : 'Edit Data PKBM'}}</h5>
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
                        <div class="row">
                            <div class="col-lg-6 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.name.$error ? 'text-danger' : ''">Nama Lengkap</label>
                                <input class="form-control" type="text" placeholder="Contoh: Ahmad Rizki"
                                    autocomplete="off" v-model="single.name" />
                                <div v-if="v$.single.name.$error" class="text-danger"> Nama Lengkap tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.nik.$error ? 'text-danger' : ''">NIK</label>
                                <input class="form-control" type="text" placeholder="Contoh: 1829485756389"
                                    autocomplete="off" v-model="single.nik" />
                                <div v-if="v$.single.nik.$error" class="text-danger"> panjang karakter harus 16!
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.phone.$error ? 'text-danger' : ''">No HP</label>
                                <input class="form-control" type="text" placeholder="Contoh: 081234567875"
                                    autocomplete="off" v-model="single.phone" />
                                <div v-if="v$.single.phone.$error" class="text-danger"> No HP tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.email.$error ? 'text-danger' : ''">Email</label>
                                <input class="form-control" type="text" placeholder="Contoh: nama@gmail.com"
                                    autocomplete="off" v-model="single.email" />
                                <div v-if="v$.single.email.$error" class="text-danger"> Email tidak boleh kosong dan
                                    harus valid!
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.skNumber.$error ? 'text-danger' : ''">Nomor SK</label>
                                <input class="form-control" type="text" placeholder="Contoh: 188.45/48/436.9.11/2022"
                                    autocomplete="off" v-model="single.skNumber" />
                                <div v-if="v$.single.skNumber.$error" class="text-danger"> Nomor SK tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.skDate.$error ? 'text-danger' : ''">Tanggal SK</label>
                                <app-datepicker type="date" placeholder="Pilih tanggal" :format="'DD-MM-YYYY'"
                                    :value-type="'YYYY-MM-DD'" v-model:value="single.skDate">
                                </app-datepicker>
                                <div v-if="v$.single.skDate.$error" class="text-danger"> Tanggal SK tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.positionInstansi.$error ? 'text-danger' : ''">Jabatan Dalam
                                    Instansi</label>
                                <app-select-single v-model="single.positionInstansi"
                                    :placeholder="'Pilih Jabatan Dalam Instansi'" :options="listPositionInstansi"
                                    :loading="pageStatus == 'position-instansi-load'" :serverside="true"
                                    @change-search="getpositionInstansi" :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.positionInstansi.$error" class="text-danger"> Jabatan Dalam
                                    Instansi tidak
                                    boleh kosong!
                                </div>
                            </div>

                            <div class="col-lg-6 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.positionSk.$error ? 'text-danger' : ''">Jabatan Dalam SK</label>
                                <app-select-single v-model="single.positionSk" :placeholder="'Pilih Jabatan Dalam SK'"
                                    :options="listPositionSK" :loading="pageStatus == 'position-sk-load'"
                                    :serverside="true" @change-search="getPositionSk" :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.positionSk.$error" class="text-danger"> Jabatan Dalam SK tidak
                                    boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.bank.$error ? 'text-danger' : ''">Nomor Rekening Bank Jatim</label>
                                <input class="form-control" type="text" placeholder="Contoh: 177729887"
                                    autocomplete="off" v-model="single.bank" />
                                <div v-if="v$.single.bank.$error" class="text-danger"> Nomor Rekening tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
				                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.subJasaPelayanan.$error ? 'text-danger' : ''">Penerima Jasa Pelayanan</label>
                                <app-select-single v-model="single.subJasaPelayanan" :placeholder="'Pilih Jasa Pelayanan'"
                                    :show_search="false" :options="listSubJasaPelayananComputed" 
                                    :serverside="false"
                                    :show_button_clear="false">
                                 </app-select-single>
                                 <div v-if="v$.single.subJasaPelayanan.$error" class="text-danger"> Penerima Jasa Pelayanan tidak boleh
                                    kosong!
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
				                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.jasaPelayanan.$error ? 'text-danger' : ''">Jenis Jasa 
                                    Pelayanan</label>
                                <app-select-single v-model="single.jasaPelayanan" :placeholder="'Pilih Jenis Jasa Pelayanan'"
                                    :options="listJasaPelayanan" :loading="pageStatus == 'jasa-pelayanan-load'"
                                    :serverside="true" :disabled="!single.subJasaPelayanan.id"
                                    @change-search="getJasaPelayanan" 
                                    :show_button_clear="false">
                                 </app-select-single>
                            </div>
                            <div class="col-lg-5 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.subDistrictDomicile.$error ? 'text-danger' : ''">Kecamatan
                                    Domisili</label>
                                <app-select-single v-model="single.subDistrictDomicile" :placeholder="'Pilih kecamatan'"
                                    :options="listSubDistrictDomicile"
                                    :loading="pageStatus == 'sub-district-domicile-load'"
                                    @option-change="single.villageDomicile = {}" :serverside="true"
                                    @change-search="(keyword, limit) => getSubDistrict(keyword, limit, 'listSubDistrictDomicile','sub-district-domicile-load')"
                                    :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.subDistrictDomicile.$error" class="text-danger"> Kecamatan tidak
                                    boleh
                                    kosong!
                                </div>
                                
                            </div>
                            <div class="col-lg-3 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.villageDomicile.$error ? 'text-danger' : ''">Kelurahan
                                    Domisili</label>
                                <app-select-single v-model="single.villageDomicile" :placeholder="'Pilih kelurahan'"
                                    :options="listVillageDomicile" :loading="pageStatus == 'village-domicile-load'"
                                    :serverside="true" :disabled="!single.subDistrictDomicile.id"
                                    @change-search="(keyword, limit) => getVillage(keyword, limit,single.subDistrictDomicile.id, 'listVillageDomicile','village-domicile-load')"
                                    :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.villageDomicile.$error" class="text-danger"> Kelurahan tidak boleh
                                    kosong!
                                </div>
                            </div>
                            <div class="col-lg-2 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.rtDomicile.$error ? 'text-danger' : ''">RT</label>
                                <app-select-single v-model="single.rtDomicile" :placeholder="'Pilih rt'"
                                    :show_search="false" :options="listRwComputed" :serverside="false"
                                    :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.rtDomicile.$error" class="text-danger"> RT tidak boleh
                                    kosong!
                                </div>
                            </div>
                            <div class="col-lg-2 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.rwDomicile.$error ? 'text-danger' : ''">RW</label>
                                <app-select-single v-model="single.rwDomicile" :placeholder="'Pilih rw'"
                                    :show_search="false" :options="listRwComputed" :serverside="false"
                                    :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.rwDomicile.$error" class="text-danger"> RW tidak boleh
                                    kosong!
                                </div>
                            </div>
                            <div class="col-lg-12 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.addressDomicile.$error ? 'text-danger' : ''">Alamat
                                    Domisili</label>
                                <textarea class="form-control" v-model="single.addressDomicile"></textarea>
                                <div v-if="v$.single.addressDomicile.$error" class="text-danger"> Alamat Domisili tidak
                                    boleh kosong!
                                </div>
                            </div>


                            <div class="col-lg-5 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.subDistrictKtp.$error ? 'text-danger' : ''">Kecamatan KTP</label>
                                <app-select-single v-model="single.subDistrictKtp" :placeholder="'Pilih kecamatan'"
                                    :options="listSubDistrictKtp" :loading="pageStatus == 'sub-district-ktp-load'"
                                    @option-change="single.villageKtp = {}" :serverside="true"
                                    @change-search="(keyword, limit) => getSubDistrict(keyword, limit, 'listSubDistrictKtp','sub-district-ktp-load')"
                                    :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.subDistrictKtp.$error" class="text-danger"> Kecamatan tidak boleh
                                    kosong!
                                </div>
                            </div>
                            <div class="col-lg-3 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.villageKtp.$error ? 'text-danger' : ''">Kelurahan KTP</label>
                                <app-select-single v-model="single.villageKtp" :placeholder="'Pilih kelurahan'"
                                    :options="listVillageKtp" :loading="pageStatus == 'village-ktp-load'"
                                    :serverside="true" :disabled="!single.subDistrictKtp.id"
                                    @change-search="(keyword, limit) => getVillage(keyword, limit,single.subDistrictKtp.id, 'listVillageKtp','village-ktp-load')"
                                    :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.villageKtp.$error" class="text-danger"> Kelurahan tidak boleh
                                    kosong!
                                </div>
                            </div>
                            <div class="col-lg-2 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.rtKtp.$error ? 'text-danger' : ''">RT</label>
                                <app-select-single v-model="single.rtKtp" :placeholder="'Pilih rt'" :show_search="false"
                                    :options="listRwComputed" :serverside="false" :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.rtKtp.$error" class="text-danger"> RT tidak boleh
                                    kosong!
                                </div>
                            </div>
                            <div class="col-lg-2 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.rwKtp.$error ? 'text-danger' : ''">RW</label>
                                <app-select-single v-model="single.rwKtp" :placeholder="'Pilih rw'" :show_search="false"
                                    :options="listRwComputed" :serverside="false" :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.rwKtp.$error" class="text-danger"> RW tidak boleh
                                    kosong!
                                </div>
                            </div>
                            <div class="col-lg-12 mb-5">
                                <label class="form-label fw-bolder fs-6"
                                    :class="v$.single.addressKtp.$error ? 'text-danger' : ''">Alamat KTP</label>
                                <textarea class="form-control" v-model="single.addressKtp"></textarea>
                                <div v-if="v$.single.addressKtp.$error" class="text-danger"> Alamat KTP tidak
                                    boleh kosong!
                                </div>
                            </div>



                            <div class="col-lg-4 mb-5">
                                <label class="form-label fw-bolder fs-6">Foto KTP<br><span
                                        style="font-size:12px;color:#706f6f;font-weight:normal !important;">Maksimal
                                        ukuran file 2 MB</span></label>
                                <div class="" style="position:relative;width:200px;">
                                    <img class="mb-3" v-if="single.ktp_path" :src="single.ktp_path"
                                        style="width:200px;height:130px;">
                                    <img class="mb-3" v-if="!single.ktp_path"
                                        :src="$assetUrl() + 'extends/img/noimage.png'"
                                        style="width:200px;height:130px;">
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
                                <div
                                    v-if="v$.single.existingSk.$error"
                                    class="text-danger"
                                    >
                                    File SK tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-8 mb-5">
                                <label class="form-label fw-bolder fs-6">Unggah File SK</label>
                                <div id="dropzone-container-1">
                                    <div class="dropzone dropzone-file-area dz-clickable" id="dropzone-upload">
                                        <div class="dz-message needsclick">
                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                            <div class="ms-4">
                                                <h5 class="kt-dropzone__msg-title">Drop files here or
                                                    click
                                                    to upload</h5>
                                                <span class="kt-dropzone__msg-desc text-primary">
                                                    Upload up to 10 files with the format .jpg/.jpeg/.png/.pdf maksimum
                                                    size file 2 MB
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        v-if="v$.single.existingSk.$error"
                                        class="text-danger"
                                        >
                                        File SK tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-lg-6 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                        v-for="(contextX, indexX) in single.existingSk">
                                        <a :href="contextX.path" target="_blank">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                        style="width:35px;" v-if="contextX.is_image" />
                                                    <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                        style="width:35px;" v-else />
                                                </div>
                                                <div>
                                                    <div class="fw-bolder text-primary" style="word-break:break-word">
                                                        {{$noNullable(contextX.name)}}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{$formatBytes(contextX.size)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <div><i @click="single.existingSk.splice(indexX, 1)"
                                                class="fa fa-times text-danger"
                                                style="font-size:20px;cursor:pointer;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label class="form-label fw-bolder fs-6">Foto<br><span
                                        style="font-size:12px;color:#706f6f;font-weight:normal !important;">Dimensi
                                        gambar harus 4x6 & maksimal ukuran file 2 MB</span></label>
                                <div class="" style="position:relative;width:130px;">
                                    <img class="mb-3" v-if="single.photo_path" :src="single.photo_path"
                                        style="width:130px;height:130px;">
                                    <img class="mb-3" v-if="!single.photo_path"
                                        :src="$assetUrl() + 'extends/img/noimage.png'"
                                        style="width:130px;height:130px;">
                                    <input :id="'input-photo'" type="file" class="d-none" accept="image/*"
                                        @change="imageChangePhoto($event)">
                                    <button class="btn d-flex align-items-center justify-content-center" type="button"
                                        style="padding:0 !important;border-radius:100px;width:40px;height:40px;background:#fff !important;;position:absolute;top:5px;right:-10px;box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important"
                                        @click="choosePhoto">
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



        <div class="modal fade" tabindex="-1" id="modal-import">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Import Data PKBM</h5>
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
                        <div class="row">

                            <div class="col-lg-12 mb-5">
                                <label class="form-label fw-bolder fs-6">File</label>
                                <div id="dropzone-container-1">
                                    <div class="dropzone dropzone-file-area dz-clickable" id="dropzone-import">
                                        <div class="dz-message needsclick">
                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                            <div class="ms-4">
                                                <h5 class="kt-dropzone__msg-title">Drop files here or
                                                    click
                                                    to upload</h5>
                                                <span class="kt-dropzone__msg-desc text-primary">
                                                    Upload 1 files with the format .xls/.xlsx
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive mt-5" v-if="listErrorImport.length > 0">
                                    <table class="table table-rounded table-striped border gy-7 gs-7">
                                        <thead>
                                            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                <th>Row</th>
                                                <th>Error</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="context in listErrorImport">
                                                <td>{{context.row}}</td>
                                                <td>
                                                    <ul>
                                                        <li v-for="error in context.note">{{error}}</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!--begin::Alert-->
                                <div
                                    class="alert mt-10 bg-light-primary d-flex flex-column flex-sm-row p-5 mb-10 align-items-center">
                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">

                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M15.9998 29.3346C23.3636 29.3346 29.3332 23.3651 29.3332 16.0013C29.3332 8.63751 23.3636 2.66797 15.9998 2.66797C8.63604 2.66797 2.6665 8.63751 2.6665 16.0013C2.6665 23.3651 8.63604 29.3346 15.9998 29.3346Z"
                                                fill="#009EF7" />
                                            <path
                                                d="M17.3332 14.6654C17.3332 13.929 16.7362 13.332 15.9998 13.332C15.2635 13.332 14.6665 13.929 14.6665 14.6654V21.332C14.6665 22.0684 15.2635 22.6654 15.9998 22.6654C16.7362 22.6654 17.3332 22.0684 17.3332 21.332V14.6654Z"
                                                fill="#009EF7" />
                                            <path
                                                d="M17.3332 10.6654C17.3332 9.92898 16.7362 9.33203 15.9998 9.33203C15.2635 9.33203 14.6665 9.92898 14.6665 10.6654C14.6665 11.4017 15.2635 11.9987 15.9998 11.9987C16.7362 11.9987 17.3332 11.4017 17.3332 10.6654Z"
                                                fill="#009EF7" />
                                        </svg>

                                    </span>
                                    <!--end::Icon-->

                                    <!--begin::Wrapper-->
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex flex-column w-100">
                                            <!--begin::Title-->
                                            <h4 class="mb-1 text-dark">Format Import.</h4>
                                            <!--end::Title-->
                                            <!--begin::Content-->
                                            <span>Silahkan download format import terlebih dahulu.</span>
                                            <!--end::Content-->
                                        </div>
                                        <button @click="getTemplateImport" type="button"
                                            class="btn btn-primary">Download</button>
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Alert-->
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                        <button @click="saveImport" class="btn btn-sm bg-second-primary-custom text-white"
                            type="button">
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
        email,
        minLength,
        maxLength
    } from '@vuelidate/validators'

    export default {
        data() {
            return {
                ROLE_ADMIN_ID: process.env.MIX_ROLE_ADMIN_ID,
                ROLE_KABID_ID: process.env.MIX_ROLE_KABID_ID,
                ROLE_KADIS_ID: process.env.MIX_ROLE_KADIS_ID,
                ROLE_KONSELOR_ID: process.env.MIX_ROLE_KONSELOR_ID,
                ROLE_SUBKORD_ID: process.env.MIX_ROLE_SUBKORD_ID,
                ROLE_OPD_ID: process.env.MIX_ROLE_OPD_ID,
                ROLE_HOTLINE_ID: process.env.MIX_ROLE_HOTLINE_ID,
                ROLE_ASISTEN_ID: process.env.MIX_ROLE_ASISTEN_ID,
                ROLE_KELURAHAN_ID: process.env.MIX_ROLE_KELURAHAN_ID,
                ROLE_KECAMATAN_ID: process.env.MIX_ROLE_KECAMATAN_ID,
                pageStatus: 'standby',
                v$: useVuelidate(),
                flag: 'insert',
                dropzoneUpload: null,
                dropzoneImport: null,
                isCheckedYes: false,
                isCheckedNo: false,
                listSubDistrictDomicile: [],
                listVillageDomicile: [],

                listSubDistrictKtp: [],
                listVillageKtp: [],

                listPositionInstansi: [],
                listPositionSK: [],

                listJasaPelayanan: [],

                listRw: [],
                listErrorImport: [],
                listSubDistrictFilter: [],
                listVillageFilter: [],
                listRwFilter: [],
                single: {
                    header: {
                        member: 0,
                        village: 0,
                        subDistrict: 0,
                        loading: true
                    },
                    id: '',
                    name: '',
                    nik: '',
                    skNumber: '',
                    skDate: '',
                    positionInstansi: {},
                    positionSk: {},
                    subJasaPelayanan: {},
                    jasaPelayanan: {},
                    subDistrictDomicile: {},
                    villageDomicile: {},
                    addressDomicile: '',
                    rwDomicile: {},
                    rtDomicile: {},
                    subDistrictKtp: {},
                    villageKtp: {},
                    addressKtp: '',
                    rwKtp: {},
                    rtKtp: {},
                    bank: '',
                    phone: '',
                    email: '',
                    ktp_path: '',
                    ktp_file: '',
                    photo_path: '',
                    photo_file: '',
                    existingSk: [],

                    filter: {
                        subDistrict: {
                            id: '0',
                            text: 'Semua'
                        },
                        village: {
                            id: '0',
                            text: 'Semua'
                        },
                        rw: {
                            id: '0',
                            text: 'Semua'
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
                                text: 'NAMA & NIK',
                                sort_by: 'name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'NOMOR & TGL SK',
                                sort_by: 'sk_number',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'JABATAN',
                                sort_by: 'jabatan_dalam_instansi_name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'KECAMATAN',
                                sort_by: 'creator_name',
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
                    nik: {
                        required,
                        minLength: minLength(16),
                        maxLength: maxLength(16)
                    },
                    skNumber: {
                        required
                    },
                    skDate: {
                        required
                    },
                    positionInstansi: {
                        required
                    },
                    positionSk: {
                        required
                    },
                    subJasaPelayanan: {
                        // required
                    },
                    bank: {
                        required
                    },
                    jasaPelayanan: {
                        // required
                    },
                    subDistrictDomicile: {
                        required
                    },
                    villageDomicile: {
                        required
                    },
                    addressDomicile: {
                        required
                    },
                    rwDomicile: {
                        required
                    },
                    rtDomicile: {
                        required
                    },
                    subDistrictKtp: {
                        required
                    },
                    villageKtp: {
                        required
                    },
                    addressKtp: {
                        required
                    },
                    rwKtp: {
                        required
                    },
                    rtKtp: {
                        required
                    },
                    phone: {
                        required
                    },
                    email: {
                        required,
                        email
                    },
                    existingSk: {
                    // required
                    },
                    ktp_file: {
                        // required
                    },
                },
            }
        },
        mounted() {
            reinitializeAllPlugin();
            this.initDropzone();

            this.getDataTable();

            this.getDataHeader();

        },
        beforeRouteLeave(to, from, next) {
            this.dropzoneUpload.destroy();
            this.dropzoneImport.destroy();
            next();
        },
        computed: {
            listRwComputed() {
                let response = [];
                for (let i = 0; i < 101; i++) {
                    response.push({
                        id: i,
                        text: i
                    })
                }

                return response;
            },
            listSubJasaPelayananComputed() {
                let response = [
                    {
                        id: 0,
                        text: 'Tidak'
                    },
                    {
                        id: 1,
                        text: 'Ya'
                    }
                ];
                
                return response;
            }
        },
        methods: {
            getDataHeader() {
                Api().get(`database/pkbm/rangkuman`)
                    .then(response => {
                        this.single.header.member = response.data.data.anggota;
                        this.single.header.village = response.data.data.kelurahan;
                        this.single.header.subDistrict = response.data.data.kecamatan;
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.single.header.loading = false;
                    });
            },
            initDropzone() {
                const that = this;
                this.dropzoneUpload = new Dropzone(
                    "#dropzone-upload", {
                        url: "/",
                        dictCancelUpload: "Cancel",
                        maxFilesize: 10,
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
                                    that.$swal(
                                        'Silahkan periksa file Anda lagi, ukuran maksimal 2 MB');
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

                this.dropzoneImport = new Dropzone(
                    "#dropzone-import", {
                        url: "/",
                        dictCancelUpload: "Cancel",
                        maxFilesize: 50,
                        parallelUploads: 1,
                        uploadMultiple: false,
                        maxFiles: 1,
                        addRemoveLinks: true,
                        acceptedFiles: '.xlsx,.xls',
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
            showModalAdd() {
                this.reset();

                $("#modal-form").modal('show');
            },
            edit(id) {
                this.reset();

                this.$ewpLoadingShow();
                Api().get(`database/pkbm/` + id)
                    .then(response => {
                        $("#modal-form").modal('show');

                        this.flag = 'update';

                        let context = response.data.data;

                        this.single.id = context.id;
                        this.single.name = context.name;
                        this.single.nik = context.nik;
                        this.single.skNumber = context.sk_number;
                        this.single.skDate = context.sk_date;
                        this.single.bank = context.no_bank;
                        this.single.phone = context.no_hp;
                        this.single.email = context.email;


                        if (context.jabatan_dalam_instansi_name && context.id_jabatan_dalam_instansi) {
                            this.single.positionInstansi = {
                                id: context.id_jabatan_dalam_instansi,
                                text: context.jabatan_dalam_instansi_name,
                            }
                        }

                        if (context.kedudukan_dalam_tim_name && context.id_kedudukan_dalam_tim) {
                            this.single.positionSk = {
                                id: context.id_kedudukan_dalam_tim,
                                text: context.kedudukan_dalam_tim_name,
                            }
                        }

                        if (context.kecamatan_domisili_name && context.kecamatan_domisili_id) {
                            this.single.subDistrictDomicile = {
                                id: context.kecamatan_domisili_id,
                                text: context.kecamatan_domisili_name,
                            }
                        }
                        if (context.kelurahan_domisili_name && context.kelurahan_domisili_id) {
                            this.single.villageDomicile = {
                                id: context.kelurahan_domisili_id,
                                text: context.kelurahan_domisili_name,
                            }
                        }
                        if (context.rt_domisili !== null) {
                            this.single.rtDomicile = {
                                id: context.rt_domisili,
                                text: context.rt_domisili,
                            }
                        }
                        if (context.rw_domisili !== null) {
                            this.single.rwDomicile = {
                                id: context.rw_domisili,
                                text: context.rw_domisili,
                            }
                        }
                        if (context.penerima_jaspel !== null) {
                            this.single.subJasaPelayanan = {
                                id: context.penerima_jaspel,
                                text: context.penerima_jaspel,
                            }
                        }

                        // this.single.subJasaPelayanan = {
                        //     id: context.penerima_jaspel,      // e.g., 1
                        //     text: context.penerima_jaspel_name // e.g., "Service Name"
                        // };

                        
                        if (context.jasa_pelayanan !== null) {
                            this.single.jasaPelayanan = {
                                id: context.jasa_pelayanan,
                                text: context.jasa_pelayanan,
                            }
                        }

                        this.single.bank = context.no_bank;
                        this.single.addressDomicile = context.alamat_domisili;


                        if (context.kecamatan_ktp_name && context.kecamatan_ktp_id) {
                            this.single.subDistrictKtp = {
                                id: context.kecamatan_ktp_id,
                                text: context.kecamatan_ktp_name,
                            }
                        }
                        if (context.kelurahan_ktp_name && context.kelurahan_ktp_id) {
                            this.single.villageKtp = {
                                id: context.kelurahan_ktp_id,
                                text: context.kelurahan_ktp_name,
                            }
                        }
                        if (context.rt_ktp !== null) {
                            this.single.rtKtp = {
                                id: context.rt_ktp,
                                text: context.rt_ktp,
                            }
                        }
                        if (context.rw_ktp !== null) {
                            this.single.rwKtp = {
                                id: context.rw_ktp,
                                text: context.rw_ktp,
                            }
                        }
                        this.single.addressKtp = context.alamat_ktp;


                        this.single.ktp_path = context.ktp ? context.ktp.path : '';
                        this.single.photo_path = context.foto;
                        this.single.existingSk = context.file_sk;
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
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

                if (this.single.filter.subDistrict.id && this.single.filter.subDistrict.id != '0') {
                    Object.assign(params, {
                        id_kecamatan: this.single.filter.subDistrict.id
                    })
                }

                if (this.single.filter.village.id && this.single.filter.village.id != '0') {
                    Object.assign(params, {
                        id_kelurahan: this.single.filter.village.id
                    })
                }

                Api().get(`database/pkbm`, {
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
                    this.$toast.error("Silahkan lengkapi form diatas!");
                    return false;
                }

                this.$ewpLoadingShow();

                let formData = new FormData();

                formData.append('nama_lengkap', this.single.name ? this.single.name : '');
                formData.append('nik', this.single.nik ? this.single.nik : '');
                formData.append('nomor_sk', this.single.skNumber ? this.single.skNumber : '');
                formData.append('tanggal_sk', this.single.skDate ? this.single.skDate : '');
                formData.append('ktp', this.single.ktp_file ? this.single.ktp_file : '');
                formData.append('foto', this.single.photo_file ? this.single.photo_file : '');

                if (!$.isEmptyObject(this.dropzoneUpload.files)) {
                    for (let file in this.dropzoneUpload.files) {
                        formData.append('file_sk[]', this.dropzoneUpload
                            .files[file]);
                    }
                }

                formData.append('id_jabatan_dalam_instansi', this.single.positionInstansi.id ? this.single
                    .positionInstansi.id : '');
                formData.append('no_bank', this.single.bank ? this.single.bank : '');
                formData.append('id_kedudukan_dalam_tim', this.single.positionSk.id ? this.single.positionSk.id : '');
                formData.append('penerima_jaspel', this.single.subJasaPelayanan.text);
                formData.append('jasa_pelayanan', this.single.jasaPelayanan.id ? this.single.jasaPelayanan.id : 0);
                formData.append('id_kelurahan_domisili', this.single.villageDomicile.id ? this.single.villageDomicile
                    .id : '');
                formData.append('alamat_domisili', this.single.addressDomicile ? this.single.addressDomicile : '');
                formData.append('rt_domisili', this.single.rtDomicile.id ? this.single.rtDomicile.id : 0);
                formData.append('rw_domisili', this.single.rwDomicile.id ? this.single.rwDomicile.id : 0);
                formData.append('id_kelurahan_ktp', this.single.villageKtp.id ? this.single.villageKtp.id : '');
                formData.append('alamat_ktp', this.single.addressKtp ? this.single.addressKtp : '');
                formData.append('rt_ktp', this.single.rtKtp.id ? this.single.rtKtp.id : 0);
                formData.append('rw_ktp', this.single.rwKtp.id ? this.single.rwKtp.id : 0);
                formData.append('no_hp', this.single.phone ? this.single.phone : '');
                formData.append('email', this.single.email ? this.single.email : '');
                Api().post('database/pkbm', formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Menambahkan data PKBM',
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
                    this.$toast.error("Silahkan lengkapi form diatas!");
                    return false;
                }
                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('nama_lengkap', this.single.name ? this.single.name : '');
                formData.append('nik', this.single.nik ? this.single.nik : '');
                formData.append('nomor_sk', this.single.skNumber ? this.single.skNumber : '');
                formData.append('tanggal_sk', this.single.skDate ? this.single.skDate : '');
                formData.append('ktp', this.single.ktp_file ? this.single.ktp_file : '');
                formData.append('foto', this.single.photo_file ? this.single.photo_file : '');

                if (!$.isEmptyObject(this.dropzoneUpload.files)) {
                    for (let file in this.dropzoneUpload.files) {
                        formData.append('file_sk[]', this.dropzoneUpload
                            .files[file]);
                    }
                }

                formData.append('id_jabatan_dalam_instansi', this.single.positionInstansi.id ? this.single
                    .positionInstansi.id : '');
                formData.append('no_bank', this.single.bank ? this.single.bank : '');
                formData.append('id_kedudukan_dalam_tim', this.single.positionSk.id ? this.single.positionSk.id : '');
                formData.append('penerima_jaspel', this.single.subJasaPelayanan.text);
                formData.append('jasa_pelayanan', this.single.jasaPelayanan.id ? this.single.jasaPelayanan.id : 0);
                formData.append('id_kelurahan_domisili', this.single.villageDomicile.id ? this.single.villageDomicile
                    .id : '');
                formData.append('alamat_domisili', this.single.addressDomicile ? this.single.addressDomicile : '');
                formData.append('rt_domisili', this.single.rtDomicile.id ? this.single.rtDomicile.id : 0);
                formData.append('rw_domisili', this.single.rwDomicile.id ? this.single.rwDomicile.id : 0);
                formData.append('id_kelurahan_ktp', this.single.villageKtp.id ? this.single.villageKtp.id : '');
                formData.append('alamat_ktp', this.single.addressKtp ? this.single.addressKtp : '');
                formData.append('rt_ktp', this.single.rtKtp.id ? this.single.rtKtp.id : 0);
                formData.append('rw_ktp', this.single.rwKtp.id ? this.single.rwKtp.id : 0);
                formData.append('no_hp', this.single.phone ? this.single.phone : '');
                formData.append('email', this.single.email ? this.single.email : '');

                for (let i = 0; i < this.single.existingSk.length; i++) {
                    formData.append('file_sk_existing[]', this.single.existingSk[i].id);
                }
                this.$ewpLoadingShow();

                Api().post(`database/pkbm/${this.single.id}`, formData)
                    .then(response => {
                        $("#modal-form").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Memperbarui data PKBM',
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
                Api().put(`database/pkbm/${id}/switch-status`)
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
            getSelectList(url, listKey, pageStatus = 'select-load') {
                this.pageStatus = pageStatus

                Api().get(url)
                    .then(response => {

                        this[listKey] = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this[listKey].push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this[listKey] = [];
                        this.$axiosHandleError(error);
                    }).finally(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getpositionInstansi(keyword, limit) {
                this.getSelectList(`m-jabatan-dalam-instansi/lists?limit=${limit}&search=${keyword}`,
                    'listPositionInstansi',
                    'position-instansi-load')
            },
            getPositionSk(keyword, limit) {
                this.getSelectList(`m-kedudukan-dalam-tim/lists?limit=${limit}&search=${keyword}`, 'listPositionSK',
                    'position-sk-load')
            },
            getJasaPelayanan(keyword, limit) {
                this.getSelectList(`m-jasa-pelayanan/lists?limit=${limit}&search=${keyword}`, 'listJasaPelayanan',
                    'listPositionInstansi')
            },
            getSubDistrict(keyword, limit, listKey, pageStatus) {
                this.getSelectList(`m-kecamatan/lists?limit=${limit}&search=${keyword}&is_surabaya=true`, listKey,
                    pageStatus)
            },
            getVillage(keyword, limit, subDistrictId = '', listKey, pageStatus) {
                this.getSelectList(
                    `m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${subDistrictId}&is_surabaya=true`,
                    listKey, pageStatus)
            },
            reset() {
                this.v$.$reset();

                this.flag = 'insert';


                this.single.id = '';
                this.single.name = '';
                this.single.nik = '';
                this.single.skNumber = '';
                this.single.skDate = '';
                this.single.noBank = '';
                this.single.positionInstansi = {};
                this.single.positionSk = {};
                this.single.subJasaPelayanan = {};
                this.single.jasaPelayanan = {};
                this.single.subDistrictDomicile = {};
                this.single.villageDomicile = {};
                this.single.addressDomicile = '';
                this.single.rwDomicile = {};
                this.single.rtDomicile = {};
                this.single.subDistrictKtp = {};
                this.single.villageKtp = {};
                this.single.addressKtp = '';
                this.single.rwKtp = {};
                this.single.rtKtp = {};
                this.single.phone = '';
                this.single.email = '';
                this.single.ktp_path = '';
                this.single.ktp_file = '';
                this.single.photo_file = '';
                this.single.photo_path = '';
                this.single.existingSk = [];

                this.dropzoneUpload.removeAllFiles(true);
                this.dropzoneUpload.files = [];
            },
            chooseFile() {
                this.single.ktp_path = '';
                this.single.ktp_file = '';

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

                            const size = file.size;

                            if (Math.round(size) > 5 * 1024 * 1024) {
                                that.$swal({
                                    title: "Peringatan!",
                                    text: 'Ukuran gambar tidak boleh melebihi 2 MB',
                                    icon: "warning",
                                })
                                return;
                            }

                            that.single.ktp_path = fileReader.result;
                            that.single.ktp_file = files[0];
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
            choosePhoto() {
                this.single.photo_path = '';
                this.single.photo_file = '';

                $('#input-photo').val('');
                setTimeout(() => {
                    $('#input-photo').click();
                }, 500);

            },
            imageChangePhoto(evt) {
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

                            const size = file.size;

                            if (Math.round(size) > 5 * 1024 * 1024) {
                                that.$swal({
                                    title: "Peringatan!",
                                    text: 'Ukuran gambar tidak boleh melebihi 2 MB',
                                    icon: "warning",
                                })
                                return;
                            }

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
            showModalImport() {

                this.dropzoneImport.removeAllFiles(true);
                this.dropzoneImport.files = [];

                this.listErrorImport = [];

                $("#modal-import").modal('show');
            },
            getTemplateImport() {
                this.$ewpLoadingShow();
                Api().get('database/pkbm/download-format', {
                    responseType: 'blob',
                }).then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'FORMAT IMPORT PKBM.xlsx');
                    document.body.appendChild(link);
                    link.click();
                }).catch(error => {
                    this.$axiosHandleError(error);
                }).then(() => {
                    this.$ewpLoadingHide();
                });
            },
            saveImport() {
                let formData = new FormData();

                let valid = false;
                if (!$.isEmptyObject(this.dropzoneImport.files)) {
                    for (let file in this.dropzoneImport.files) {
                        valid = true;
                        formData.append('file', this.dropzoneImport.files[file]);
                    }
                }

                if (!valid) {
                    this.$toast.info("Pilih file terlebih dahulu!");
                    return false;
                }
                this.listErrorImport = [];
                this.$ewpLoadingShow();

                Api().post(`database/pkbm/import`, formData)
                    .then(response => {
                        $(".modal").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Import data PKBM',
                            icon: "success",
                        }).then(result => {
                            this.tableConfig.config.current_page = 1;
                            this.getDataTable();
                        });
                    })
                    .catch(error => {
                        let res = error.response ? error.response.data.data : [];
                        let code = error.response ? error.response.status : null;

                        if (code == 422) {
                            for (let i = 0; i < res.length; i++) {
                                const index = this.listErrorImport.findIndex((e) => e.row == res[i].row)
                                if (index >= 0) {
                                    this.listErrorImport[index].note = this.listErrorImport[index].note.concat(res[
                                        i].errors);
                                } else {
                                    this.listErrorImport.push({
                                        row: res[i].row,
                                        note: res[i].errors
                                    })
                                }
                            }
                        }
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            getSubDistrictFilter(keyword, limit) {
                this.pageStatus = 'sub-district-filter-load';

                Api().get(`m-kecamatan/lists?search=${keyword}&limit=${limit}&is_surabaya=true`)
                    .then(response => {

                        this.listSubDistrictFilter = [{
                            id: '0',
                            text: 'Semua'
                        }];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listSubDistrictFilter.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listSubDistrictFilter = [{
                            id: '0',
                            text: 'Semua'
                        }];
                        this.$axiosHandleError(error);
                    }).finally(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getVillageFilter(keyword, limit) {
                this.pageStatus = 'village-filter-load';

                Api().get(
                        `m-kelurahan/lists?search=${keyword}&limit=${limit}&id_kecamatan=${this.single.filter.subDistrict.id}`
                    )
                    .then(response => {

                        this.listVillageFilter = [{
                            id: '0',
                            text: 'Semua'
                        }];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listVillageFilter.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listVillageFilter = [{
                            id: '0',
                            text: 'Semua'
                        }];
                        this.$axiosHandleError(error);
                    }).finally(() => {
                        this.pageStatus = 'standby';
                    })
            },
            skDownload(id, name){
                this.$ewpLoadingShow();
                Api().get(`database/pkbm/${id}/download-sk`, {
                    responseType: 'blob',
                }).then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', `FILE SK ${name}.zip`);
                    document.body.appendChild(link);
                    link.click();
                }).catch(error => {
                    let res = error.response ? error.response.data.data : null;                    
                    let code = error.response ? error.response.status : null;

                    if (code == 400) {
                        this.$toast.info('File tidak ditemukan!');
                    } else {
                        this.$axiosHandleError(error);
                    }
                }).then(() => {
                    this.$ewpLoadingHide();
                });
            },
            pdfGenerate(id, name){
                this.$ewpLoadingShow();
                Api().get(`database/pkbm/${id}/cetak-pdf`, {
                    responseType: 'blob',
                }).then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', `Profile ${name}.pdf`);
                    document.body.appendChild(link);
                    link.click();
                }).catch(error => {
                    this.$axiosHandleError(error);
                }).then(() => {
                    this.$ewpLoadingHide();
                });
            },
            exportData(){
                this.$ewpLoadingShow();
                Api().get(`database/pkbm/export`, {
                    responseType: 'blob',
                }).then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', `Export PKBM.xlsx`);
                    document.body.appendChild(link);
                    link.click();
                }).catch(error => {
                    this.$axiosHandleError(error);
                }).then(() => {
                    this.$ewpLoadingHide();
                });
            }
        }
    }

</script>

<style scoped>

</style>
