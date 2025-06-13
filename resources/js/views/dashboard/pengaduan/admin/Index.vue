<template>
    <div>
        <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5 align-items-center">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Data
                            Pengaduan</span>
                    </h3>
                    <div class="d-flex align-items-center" style="width:300px;">
                        <app-datepicker type="date" placeholder="Pilih tanggal pengaduan" :format="'DD-MM-YYYY'"
                            :value-type="'YYYY-MM-DD'" :class="'me-3 w-100'" :range="true"
                            :style="'max-width:300px !important;'"
                            @change="tableConfig.config.current_page = 1; getDataTable()"
                            v-model:value="single.filter.daterange">
                        </app-datepicker>
                    </div>

                </div>
                <div class="card-body pt-5">
                    <div class="row align-items-center">
                        <div class="col-lg-2 fw-bolder mb-5" style="font-size:14px;">
                            Keterangan Status
                        </div>
                        <div class="col-lg-10">
                            <div class="d-flex flex-wrap">
                                <span class="badge badge-light-primary mb-5 me-3 c-pointer"
                                    @click="single.filter.id_status = '1'; tableConfig.config.current_page = 1; getDataTable()">Perlu
                                    Penanganan</span>
                                <span class="badge badge-light-info mb-5 me-3 c-pointer"
                                    @click="single.filter.id_status = '3,4,7,8,9'; tableConfig.config.current_page = 1; getDataTable()">Proses
                                    Verifikasi</span>
                                <span class="badge badge-light-warning mb-5 me-3 c-pointer"
                                    @click="single.filter.id_status = '5'; tableConfig.config.current_page = 1; getDataTable()">Proses
                                    Penjangkauan</span>
                                <span class="badge badge-light-danger mb-5 me-3 c-pointer"
                                    @click="single.filter.id_status = '2,6'; tableConfig.config.current_page = 1; getDataTable()">Di
                                    Revisi/Dirujuk</span>
                                <span class="badge badge-light-success mb-5 me-3 c-pointer"
                                    @click="single.filter.id_status = '10'; tableConfig.config.current_page = 1; getDataTable()">Pengaduan
                                    Selesai</span>
                            </div>
                        </div>
                    </div>
                    <app-datatable-serverside :table_config="tableConfig" @change-page="getDataTable"
                        v-model:show_per_page="tableConfig.config.show_per_page"
                        v-model:search="tableConfig.config.search" v-model:order="tableConfig.config.order"
                        v-model:sort_by="tableConfig.config.sort_by"
                        v-model:current_page="tableConfig.config.current_page">
                        <template v-slot:body>
                            <tr v-for="(context, index) in tableConfig.feeder.data">
                                <td class="text-center">{{index + 1}}</td>
                                <td class="text-left">{{context.registration_number}}</td>
                                <td class="text-left">
                                    <div>{{context.mama_klien}}</div>
                                    <div class="text-gray-500">
                                        {{context.is_has_nik ? context.nik_klien : context.identity_number}}</div>
                                    <div class="pt-2">{{context.alamat_klien}}</div>
                                    <div class="text-gray-600">{{context.nama_kelurahan}}, {{context.nama_kecamatan}}
                                    </div>
                                </td>
                                <td class="text-left">
                                    <div>{{context.nama_pelapor}}</div>
                                    <div class="text-gray-500">{{context.nik_pelapor}}</div>
                                </td>
                                <td class="text-left">
                                    <div>{{context.sumber}}</div>
                                    <div class="text-gray-500">
                                        {{$moment(context.tgl_pengaduan).locale('id').format('DD MMMM YYYY  hh:mm:ss')}}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>
                                        <span class="badge"
                                            :class="context.status.label_status">{{context.status.status}}</span>
                                    </div>
                                    <div class="text-gray-500" v-if="context.status.description">
                                        {{context.status.description}}</div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown" style="position:static !important;">
                                        <button class="btn btn-secondary btn-xs dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" style="padding:5px 10px !important;"
                                            aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <router-link class="dropdown-item py-3" :to="{name: 'pengaduan-detail', params: { id: context.id }}">
                                                    Detail Data
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link class="dropdown-item py-3" :to="{name: 'pengaduan-edit', params: { id: context.id }}" v-if="context.status.id != 10">
                                                    Edit Data
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link :to="{name: 'pengaduan-cetak', params: { id: context.id }}" class="dropdown-item py-3" v-if="context.status.id == 10">
                                                    Cetak Laporan
                                                </router-link>
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

        <div class="modal fade" tabindex="-1" id="modal-form">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{flag == 'insert' ? 'Tambah Data Pengaduan' : 'Edit Data Pengaduan'}}</h5>
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
                        <div class="row align-items-center pb-5 mb-5 border-bottom">
                            <div class="col-lg-3 fw-bolder mb-5">
                                Nomor Registrasi(Otomatis)
                            </div>
                            <div class="col-lg-3 mb-5">
                                <input type="text" class="form-control" placeholder=""
                                    v-model="single.form.registerNumber" disabled />
                            </div>
                            <div class="col-lg-2 fw-bolder mb-5"
                                :class="v$.single.form.sourceOfComplaint.$error ? 'text-danger' : ''">
                                Sumber
                            </div>
                            <div class="col-lg-4 mb-5">
                                <app-select-single v-model="single.form.sourceOfComplaint" :placeholder="'Pilih sumber'"
                                    :options="listSourceOfComplaint" :loading="pageStatus == 'source-of-complaint-load'"
                                    :serverside="true" @change-search="getSourceOfComplaint" :show_button_clear="false">
                                </app-select-single>
                                <div v-if="v$.single.form.sourceOfComplaint.$error" class="text-danger">Sumber tidak
                                    boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-3 fw-bolder mb-5"
                                :class="v$.single.form.date.$error ? 'text-danger' : ''">
                                Tanggal Pengaduan
                            </div>
                            <div class="col-lg-3 mb-5">
                                <app-datepicker type="date" :format="'DD-MM-YYYY'" :value-type="'YYYY-MM-DD'"
                                    v-model:value="single.form.date">
                                </app-datepicker>
                                <div v-if="v$.single.form.date.$error" class="text-danger">Tanggal Pengaduan tidak boleh
                                    kosong!
                                </div>
                            </div>
                            <div class="col-lg-2 fw-bolder mb-5"
                                :class="v$.single.form.time.$error ? 'text-danger' : ''">
                                Jam
                            </div>
                            <div class="col-lg-4 mb-5">
                                <app-datepicker type="time" :format="'HH:mm:ss'" :value-type="'HH:mm:ss'"
                                    v-model:value="single.form.time">
                                </app-datepicker>
                                <div v-if="v$.single.form.time.$error" class="text-danger">Jam tidak boleh kosong!
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 border-bottom pb-5 align-items-center">
                            <div class="col-lg-12 mb-5">
                                <h4 class="c-primary-custom fw-bolder pb-2">Identitas Pelapor</h4>
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder"
                                :class="v$.single.form.reportIdentity.fullName.$error ? 'text-danger' : ''">
                                Nama Lengkap Pelapor
                            </div>
                            <div class="col-lg-9 mb-5">
                                <input type="text" class="form-control" placeholder="Cth: Suyonto"
                                    v-model="single.form.reportIdentity.fullName" />
                                <div v-if="v$.single.form.reportIdentity.fullName.$error" class="text-danger">Nama
                                    Lengkap Pelapor tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder">
                                NIK Pelapor (Opsional)
                            </div>
                            <div class="col-lg-9 mb-5">
                                <input type="number" class="form-control" placeholder="Cth: 3514091234567890"
                                    v-model="single.form.reportIdentity.nik" />
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder">
                                Warga Surabaya
                            </div>
                            <div class="col-lg-2">
                                <div class="d-flex align-items-center">
                                    <button @click="single.form.reportIdentity.surabayaResidents = 1"
                                        :class="single.form.reportIdentity.surabayaResidents == 1 ? 'btn-active-selected' : ''"
                                        class="btn btn-outline btn-outline-solid btn-outline-default btn-sm mb-5 me-3"
                                        type="button">Ya</button>
                                    <button @click="single.form.reportIdentity.surabayaResidents = 0"
                                        :class="single.form.reportIdentity.surabayaResidents == 0 ? 'btn-active-selected' : ''"
                                        class="btn btn-outline btn-outline-solid btn-outline-default btn-sm mb-5"
                                        type="button">Tidak</button>
                                </div>
                            </div>
                            <div class="col-lg-2 mb-5 fw-bolder"
                                :class="v$.single.form.reportIdentity.districtOutsideSurabaya.$error ? 'text-danger' : ''">
                                <span v-if="single.form.reportIdentity.surabayaResidents == 0">Kabupaten/Kota</span>
                            </div>
                            <div class="col-lg-5 mb-5">
                                <app-select-single v-model="single.form.reportIdentity.districtOutsideSurabaya"
                                    @change-search="(keyword, limit) => getDistrict(keyword, limit, 'report-identity')"
                                    :loading="pageStatus == 'district-load'"
                                    v-if="single.form.reportIdentity.surabayaResidents == 0" :show_button_clear="false"
                                    :placeholder="'Pilih kabupaten/kota'" :options="listDistrict" :serverside="true">
                                </app-select-single>
                                <div v-if="v$.single.form.reportIdentity.districtOutsideSurabaya.$error"
                                    class="text-danger">Kabupaten/Kota tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder"
                                :class="v$.single.form.reportIdentity.phoneNumber.$error ? 'text-danger' : ''">
                                No. Telepon/Whatsapp
                            </div>
                            <div class="col-lg-9 mb-5">
                                <input type="text" class="form-control" placeholder="Cth: 08123456789"
                                    v-model="single.form.reportIdentity.phoneNumber" />
                                <div v-if="v$.single.form.reportIdentity.phoneNumber.$error" class="text-danger">
                                    No. Telepon/Whatsapp tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder"
                                :class="v$.single.form.reportIdentity.addressDomicile.$error ? 'text-danger' : ''">
                                Alamat Domisili
                            </div>
                            <div class="col-lg-9 mb-5">
                                <textarea class="form-control" rows="3" placeholder="Cth: Baratajaya gang 3 no 19"
                                    v-model="single.form.reportIdentity.addressDomicile"></textarea>
                                <div v-if="v$.single.form.reportIdentity.addressDomicile.$error" class="text-danger">
                                    Alamat Domisili tidak boleh kosong!
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 border-bottom pb-5 align-items-center">
                            <div class="col-lg-12 mb-5">
                                <h4 class="c-primary-custom fw-bolder pb-2">Identitas Klien</h4>
                            </div>
                            <div class="col-lg-3">
                            </div>
                            <div class="col-lg-9">
                                <div class="d-flex">
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid mb-5 me-5">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="checkbox_input" type="checkbox"
                                            value="2" id="kt_docs_formvalidation_checkbox_option_1"
                                            v-model="single.form.clientIdentity.type" @change="uniqueCheckTypeClient" />
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_docs_formvalidation_checkbox_option_1">
                                            <div class="fw-bolder text-gray-800">Pelapor Bukan Sebagai Klien</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->

                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid mb-5">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="checkbox_input" type="checkbox"
                                            value="3" id="kt_docs_formvalidation_checkbox_option_2"
                                            v-model="single.form.clientIdentity.type" @change="uniqueCheckTypeClient" />
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_docs_formvalidation_checkbox_option_2">
                                            <div class="fw-bolder text-gray-800">Pelapor Sebagai Klien</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->

                                </div>
                            </div>
                            <template v-if="getTypeClient == 1">
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.form.clientIdentity.old.client.$error ? 'text-danger' : ''">
                                    Nama Lengkap
                                </div>
                                <div class="col-lg-9 mb-5">
                                    <app-select-single v-model="single.form.clientIdentity.old.client"
                                        :placeholder="'Pilih Klien'" :options="listClient" :show_button_clear="false"
                                        :loading="pageStatus == 'client-load'" :serverside="true"
                                        @change-search="getClient" @option-change="getDetailClient">
                                    </app-select-single>
                                    <div v-if="v$.single.form.clientIdentity.old.client.$error" class="text-danger">
                                        Nama Lengkap tidak boleh kosong!
                                    </div>
                                </div>
                                <template v-if="single.form.clientIdentity.old.detail.show">
                                    <div class="col-lg-3 mb-5 fw-bolder">
                                        NIK/Nomor Identitas
                                    </div>
                                    <div class="col-lg-9 mb-5 fw-bolder">
                                        {{$noNullable(single.form.clientIdentity.old.detail.identityNumber)}}&ensp;<span
                                            class="badge badge-primary">{{$noNullable(single.form.clientIdentity.old.detail.typeIdentityNumber)}}</span>
                                    </div>
                                    <div class="col-lg-3 mb-5 fw-bolder">
                                        Warga Surabaya
                                    </div>
                                    <div class="col-lg-9 mb-5 fw-bolder">
                                        {{single.form.clientIdentity.old.detail.surabayaResidents == 1 ? 'Ya' : 'Tidak'}}
                                    </div>
                                    <div class="col-lg-3 mb-5 fw-bolder">
                                        Kabupaten/Kota
                                    </div>
                                    <div class="col-lg-9 mb-5 fw-bolder">
                                        {{$noNullable(single.form.clientIdentity.old.detail.surabayaResidents == 0 ? single.form.clientIdentity.old.detail.districtOutsideSurabaya : '-')}}
                                    </div>
                                    <div class="col-lg-3 mb-5 fw-bolder">
                                        Alamat Domisili
                                    </div>
                                    <div class="col-lg-9 mb-5 fw-bolder">
                                        {{$noNullable(single.form.clientIdentity.old.detail.addressDomicile)}}
                                    </div>
                                    <div class="col-lg-3 mb-5 fw-bolder">
                                        Kecamatan
                                    </div>
                                    <div class="col-lg-9 mb-5 fw-bolder">
                                        {{$noNullable(single.form.clientIdentity.old.detail.subDistrictDomicile)}}
                                    </div>
                                    <div class="col-lg-3 mb-5 fw-bolder">
                                        Kelurahan
                                    </div>
                                    <div class="col-lg-9 mb-5 fw-bolder">
                                        {{$noNullable(single.form.clientIdentity.old.detail.villageDomicile)}}
                                    </div>
                                    <div class="col-lg-3 mb-5 fw-bolder">
                                        No Telepon/Whatsapp
                                    </div>
                                    <div class="col-lg-9 mb-5 fw-bolder">
                                        {{$noNullable(single.form.clientIdentity.old.detail.phoneNumber)}}
                                    </div>
                                </template>
                            </template>
                            <template v-if="getTypeClient == 2">
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.form.clientIdentity.new.fullName.$error ? 'text-danger' : ''">
                                    Nama Lengkap
                                </div>
                                <div class="col-lg-5 mb-5">
                                    <input type="text" class="form-control" placeholder="Cth: Agus Rohman"
                                        v-model="single.form.clientIdentity.new.fullName" />
                                    <div v-if="v$.single.form.clientIdentity.new.fullName.$error" class="text-danger">
                                        Nama Lengkap tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-1 mb-5 fw-bolder"
                                    :class="v$.single.form.clientIdentity.new.initialName.$error ? 'text-danger' : ''">
                                    Inisial
                                </div>
                                <div class="col-lg-3 mb-5">
                                    <input type="text" class="form-control" placeholder="Cth: AR"
                                        v-model="single.form.clientIdentity.new.initialName" />
                                    <div v-if="v$.single.form.clientIdentity.new.initialName.$error"
                                        class="text-danger">
                                        Inisial tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.form.clientIdentity.new.nik.$error ? 'text-danger' : ''">
                                    NIK Klien
                                </div>
                                <div class="col-lg-6 mb-5">
                                    <input type="number" class="form-control" placeholder="Cth: 3514091234567890"
                                        v-model="single.form.clientIdentity.new.nik"
                                        :disabled="single.form.clientIdentity.new.notHaveNik.length > 0" />
                                    <div class="pt-2 text-gray-500" style="font-size:12px;">Masukkan 16 digit nomor
                                    </div>
                                    <div v-if="v$.single.form.clientIdentity.new.nik.$error" class="text-danger">
                                        NIK Klien tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder">
                                    <div class="form-check form-check-custom form-check-solid"
                                        style="position:relative;top:-10px;">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="checkbox_input" type="checkbox"
                                            value="1" id="has_nik"
                                            v-model="single.form.clientIdentity.new.notHaveNik" />
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="form-check-label" for="has_nik">
                                            <div class="fw-bolder text-gray-800">Tidak Punya NIK</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    v-if="single.form.clientIdentity.new.notHaveNik.length > 0">
                                    Nomor Identitas Dibuat Otomatis
                                </div>
                                <div class="col-lg-9 mb-5" v-if="single.form.clientIdentity.new.notHaveNik.length > 0">
                                    <input type="text" class="form-control"
                                        v-model="single.form.clientIdentity.new.identityNumber" disabled />
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder">
                                    Warga Surabaya
                                </div>
                                <div class="col-lg-2">
                                    <div class="d-flex align-items-center">
                                        <button @click="single.form.clientIdentity.new.surabayaResidents = 1"
                                            :class="single.form.clientIdentity.new.surabayaResidents == 1 ? 'btn-active-selected' : ''"
                                            class="btn btn-outline btn-outline-solid btn-outline-default btn-sm mb-5 me-3"
                                            type="button">Ya</button>
                                        <button @click="single.form.clientIdentity.new.surabayaResidents = 0"
                                            :class="single.form.clientIdentity.new.surabayaResidents == 0 ? 'btn-active-selected' : ''"
                                            class="btn btn-outline btn-outline-solid btn-outline-default btn-sm mb-5"
                                            type="button">Tidak</button>
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-5 fw-bolder"
                                    :class="v$.single.form.clientIdentity.new.districtOutsideSurabaya.$error ? 'text-danger' : ''">
                                    <span
                                        v-if="single.form.clientIdentity.new.surabayaResidents == 0">Kabupaten/Kota</span>
                                </div>
                                <div class="col-lg-5 mb-5">
                                    <app-select-single v-model="single.form.clientIdentity.new.districtOutsideSurabaya"
                                        v-if="single.form.clientIdentity.new.surabayaResidents == 0"
                                        :show_button_clear="false" :placeholder="'Pilih kabupaten/kota'"
                                        :loading="pageStatus == 'district-load'" :options="listDistrict"
                                        :serverside="true"
                                        @change-search="(keyword, limit) => getDistrict(keyword, limit, 'client-identity')">
                                    </app-select-single>
                                    <div v-if="v$.single.form.clientIdentity.new.districtOutsideSurabaya.$error"
                                        class="text-danger">
                                        Kabupaten/Kota tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.form.clientIdentity.new.phoneNumber.$error ? 'text-danger' : ''">
                                    No. Telepon/Whatsapp
                                </div>
                                <div class="col-lg-9 mb-5">
                                    <div class="input-group">
                                        <span class="input-group-text" style="background:#fff !important;">

                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_786_33802)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.99 13.5508L14.0104 11.5305C14.5684 10.9725 14.7067 10.12 14.3538 9.4142L14.2393 9.18525C13.8864 8.47944 14.0248 7.62699 14.5827 7.069L17.0878 4.56393C17.2668 4.38494 17.557 4.38494 17.736 4.56393C17.7708 4.59876 17.7998 4.63899 17.8219 4.68305L18.8338 6.707C19.608 8.25535 19.3045 10.1254 18.0805 11.3495L12.5815 16.8484C11.2491 18.1808 9.27828 18.646 7.49066 18.0502L5.27739 17.3124C5.03725 17.2324 4.90746 16.9728 4.98751 16.7327C5.01001 16.6652 5.04792 16.6038 5.09823 16.5535L7.52857 14.1232C8.08656 13.5652 8.93901 13.4269 9.64482 13.7798L9.87377 13.8942C10.5796 14.2471 11.432 14.1088 11.99 13.5508Z"
                                                        fill="#7E8299" />
                                                    <path opacity="0.3"
                                                        d="M12.969 5.50506L12.7935 7.32998C11.4382 7.19969 10.0921 7.67005 9.11095 8.65123C8.13298 9.6292 7.66241 10.9697 7.78847 12.3209L5.96307 12.4912C5.78684 10.6024 6.44666 8.7228 7.81459 7.35487C9.18702 5.98244 11.0744 5.32293 12.969 5.50506ZM13.2898 1.85228L13.1202 3.67775C10.6899 3.45193 8.27739 4.29934 6.51822 6.05851C4.76148 7.81525 3.91392 10.2235 4.13657 12.6507L2.3109 12.8182C2.03902 9.85429 3.07588 6.90813 5.22186 4.76215C7.37082 2.61319 10.3221 1.57652 13.2898 1.85228Z"
                                                        fill="#7E8299" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_786_33802">
                                                        <rect width="22" height="22" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                        </span>
                                        <input type="text" v-model="single.form.clientIdentity.new.phoneNumber"
                                            class="form-control" placeholder="Contoh: 081 234 567 890"
                                            style="border-left:0 !important;" />
                                    </div>
                                    <div v-if="v$.single.form.clientIdentity.new.phoneNumber.$error"
                                        class="text-danger">
                                        No. Telepon/Whatsapp tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.form.clientIdentity.new.addressDomicile.$error ? 'text-danger' : ''">
                                    Alamat Domisili
                                </div>
                                <div class="col-lg-9">
                                    <div class="mb-5 w-100">
                                        <textarea class="form-control" rows="2"
                                            v-model="single.form.clientIdentity.new.addressDomicile"
                                            placeholder="Cth: Jln ngagel 3 No. 20"></textarea>
                                        <div v-if="v$.single.form.clientIdentity.new.addressDomicile.$error"
                                            class="text-danger">
                                            Alamat Domisili tidak boleh kosong!
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-lg-2 mb-5 fw-bolder"
                                            :class="v$.single.form.clientIdentity.new.subDistrictDomicile.$error ? 'text-danger' : ''">
                                            Kecamatan
                                        </div>
                                        <div class="col-lg-4 mb-5">
                                            <app-select-single
                                                v-model="single.form.clientIdentity.new.subDistrictDomicile"
                                                :show_button_clear="false" :placeholder="'Pilih kecamatan'"
                                                :loading="pageStatus == 'sub-district-load'" :options="listSubDistrict"
                                                :serverside="true"
                                                @change-search="(keyword, limit) => getSubDistrict(keyword, limit, 'client-identity')">
                                            </app-select-single>
                                            <div v-if="v$.single.form.clientIdentity.new.subDistrictDomicile.$error"
                                                class="text-danger">
                                                Kecamatan tidak boleh kosong!
                                            </div>
                                        </div>
                                        <div class="col-lg-2 mb-5 fw-bolder"
                                            :class="v$.single.form.clientIdentity.new.villageDomicile.$error ? 'text-danger' : ''">
                                            Kelurahan
                                        </div>
                                        <div class="col-lg-4 mb-5">
                                            <app-select-single v-model="single.form.clientIdentity.new.villageDomicile"
                                                :disabled="!single.form.clientIdentity.new.subDistrictDomicile.id"
                                                :show_button_clear="false" :placeholder="'Pilih kelurahan'"
                                                :loading="pageStatus == 'village-load'"
                                                @change-search="(keyword, limit) => getVillage(keyword, limit)"
                                                :options="listVillage" :serverside="true">
                                            </app-select-single>
                                            <div v-if="v$.single.form.clientIdentity.new.villageDomicile.$error"
                                                class="text-danger">
                                                Kelurahan tidak boleh kosong!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="row mt-5 border-bottom pb-5">
                            <div class="col-lg-12 mb-5">
                                <h4 class="c-primary-custom fw-bolder pb-2">Permasalahan</h4>
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder"
                                :class="v$.single.form.problem.note.$error ? 'text-danger' : ''">
                                Uraian Singkat Permasalahan
                            </div>
                            <div class="col-lg-9 mb-5">
                                <textarea class="form-control" rows="3"
                                    placeholder="Cth: Anaknya tidak mau sekolah....."
                                    v-model="single.form.problem.note"></textarea>
                                <div v-if="v$.single.form.problem.note.$error" class="text-danger">
                                    Kelurahan tidak boleh kosong!
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-12 mb-5">
                                <h4 class="c-primary-custom fw-bolder pb-2">Dokumentasi Pengaduan</h4>
                            </div>
                            <div class="col-lg-12 mb-5 fw-bolder">
                                Unggah Dokumentasi, Cth: Screenshoot WA, dsb
                            </div>
                            <div class="col-lg-12 mb-5">
                                <div id="dropzone-container-1">
                                    <div class="dropzone dropzone-file-area dz-clickable"
                                        id="dropzone-documentation-complaint">
                                        <div class="dz-message needsclick">
                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                            <div class="ms-4">
                                                <h5 class="kt-dropzone__msg-title">Drop files here or
                                                    click
                                                    to upload</h5>
                                                <span class="kt-dropzone__msg-desc text-primary">
                                                    Upload up to 10 files with the format .jpg/.jpeg/.png
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row mt-3">
                                    <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-5"
                                        v-for="(context, index) in single.form.documentationComplaint.existing">
                                        <a :href="context.path" data-fancybox="gallery"><img :src="context.path"
                                                class="w-100" style="max-width:100%;height:100px;" /></a>
                                        <button class="btn btn-sm btn-danger mt-2 w-100"
                                            @click="single.form.documentationComplaint.existing.splice(index, 1)"
                                            style="padding:8px !important;" type="button">Hapus</button>
                                    </div>
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
                tableConfig: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center',
                            },
                            {
                                text: 'NO REGISTRASI',
                                sort_by: 'registration_number',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'KLIEN-NIK',
                                sort_by: 'mama_klien',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'PELAPOR-NIK',
                                sort_by: 'nama_pelapor',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'SUMBER - TGL PENGADUAN',
                                sort_by: 'tgl_pengaduan',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'STATUS',
                                sort_by: 'id_status',
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
                        sort_by: 'tgl_pengaduan',
                        total_data: 0,
                        current_page: 1,
                        loading: false,
                        show_search: true,
                    }
                },
                listSourceOfComplaint: [],
                listClient: [],
                listDistrict: [],
                listSubDistrict: [],
                listVillage: [],
                single: {
                    form: {
                        id: '',
                        registerNumber: '',
                        sourceOfComplaint: {},
                        date: '',
                        time: '',
                        reportIdentity: {
                            fullName: '',
                            nik: '',
                            phoneNumber: '',
                            surabayaResidents: 1,
                            districtOutsideSurabaya: {},
                            addressDomicile: '',
                        },
                        clientIdentity: {
                            type: [1],
                            old: {
                                client: {},
                                detail: {
                                    show: false,
                                    identityNumber: '',
                                    typeIdentityNumber: '',
                                    surabayaResidents: 1,
                                    districtOutsideSurabaya: '',
                                    subDistrictDomicile: '',
                                    villageDomicile: '',
                                    addressDomicile: '',
                                    phoneNumber: ''
                                }
                            },
                            new: {
                                fullName: '',
                                initialName: '',
                                nik: '',
                                notHaveNik: [],
                                identityNumber: '',
                                surabayaResidents: 1,
                                districtOutsideSurabaya: {},
                                phoneNumber: '',
                                addressDomicile: '',
                                subDistrictDomicile: {},
                                villageDomicile: {}
                            }
                        },
                        problem: {
                            note: ''
                        },
                        documentationComplaint: {
                            dropzoneUpload: null,
                            existing: []
                        }
                    },
                    filter: {
                        daterange: [],
                        id_status: ''
                    }
                }
            }

        },
        validations() {
            return {
                single: {
                    form: {
                        sourceOfComplaint: {
                            required
                        },
                        date: {
                            required
                        },
                        time: {
                            required
                        },
                        reportIdentity: {
                            fullName: {
                                required
                            },
                            districtOutsideSurabaya: {
                                required: requiredIf(function () {
                                    return this.single.form.reportIdentity.surabayaResidents == 0
                                })
                            },
                            phoneNumber: {
                                required
                            },
                            addressDomicile: {
                                required
                            },
                        },
                        clientIdentity: {
                            old: {
                                client: {
                                    required: requiredIf(function () {
                                        return this.single.form.clientIdentity.type[0] == 1
                                    })
                                }
                            },
                            new: {
                                fullName: {
                                    required: requiredIf(function () {
                                        return this.single.form.clientIdentity.type[0] == 2
                                    })
                                },
                                initialName: {
                                    required: requiredIf(function () {
                                        return this.single.form.clientIdentity.type[0] == 2
                                    })
                                },
                                nik: {
                                    required: requiredIf(function () {
                                        return this.single.form.clientIdentity.type[0] == 2 && this.single.form
                                            .clientIdentity.new.notHaveNik.length == 0
                                    })
                                },
                                districtOutsideSurabaya: {
                                    required: requiredIf(function () {
                                        return this.single.form.clientIdentity.type[0] == 2 && this.single.form
                                            .clientIdentity.new.surabayaResidents == 0;
                                    })
                                },
                                phoneNumber: {
                                    required: requiredIf(function () {
                                        return this.single.form.clientIdentity.type[0] == 2
                                    })
                                },
                                addressDomicile: {
                                    required: requiredIf(function () {
                                        return this.single.form.clientIdentity.type[0] == 2
                                    })
                                },
                                subDistrictDomicile: {
                                    required: requiredIf(function () {
                                        return this.single.form.clientIdentity.type[0] == 2
                                    })
                                },
                                villageDomicile: {
                                    required: requiredIf(function () {
                                        return this.single.form.clientIdentity.type[0] == 2
                                    })
                                }
                            }
                        },
                        problem: {
                            note: {
                                required
                            }
                        }
                    }

                },
            }
        },
        watch: {
            "single.form.reportIdentity.surabayaResidents": function () {
                this.single.form.reportIdentity.districtOutsideSurabaya = {};
            },
            "single.form.clientIdentity.type": function () {
                this.single.form.clientIdentity.old.client = {};

                this.single.form.clientIdentity.old.detail.show = false;
                this.single.form.clientIdentity.old.detail.identityNumber = '';
                this.single.form.clientIdentity.old.detail.typeIdentityNumber = '';
                this.single.form.clientIdentity.old.detail.surabayaResidents = 1;
                this.single.form.clientIdentity.old.detail.districtOutsideSurabaya = '';
                this.single.form.clientIdentity.old.detail.addressDomicile = '';
                this.single.form.clientIdentity.old.detail.phoneNumber = '';



                this.single.form.clientIdentity.new.fullName = '';
                this.single.form.clientIdentity.new.initialName = '';
                this.single.form.clientIdentity.new.nik = '';
                this.single.form.clientIdentity.new.notHaveNik = [];
                if (this.flag == 'insert') {
                    this.single.form.clientIdentity.new.identityNumber = '';
                }
                this.single.form.clientIdentity.new.surabayaResidents = 1;
                this.single.form.clientIdentity.new.districtOutsideSurabaya = {};
                this.single.form.clientIdentity.new.phoneNumber = '';
                this.single.form.clientIdentity.new.addressDomicile = '';
                this.single.form.clientIdentity.new.subDistrictDomicile = {};
                this.single.form.clientIdentity.new.villageDomicile = {};

            },
            "single.form.clientIdentity.new.notHaveNik": function () {
                this.single.form.clientIdentity.new.nik = '';

                if (this.flag == 'insert') {
                    this.single.form.clientIdentity.new.identityNumber = '';
                }
            },
            "single.form.clientIdentity.new.surabayaResidents": function () {
                this.single.form.clientIdentity.new.districtOutsideSurabaya = {};
            },
            "single.form.clientIdentity.new.districtOutsideSurabaya": function () {
                this.single.form.clientIdentity.new.subDistrictDomicile = {};
            },
            "single.form.clientIdentity.new.subDistrictDomicile": function () {
                this.single.form.clientIdentity.new.villageDomicile = {};
            }
        },
        computed: {
            getTypeClient() {
                return this.single.form.clientIdentity.type.length > 0 ? this.single.form.clientIdentity.type[0] :
                    1;
            }
        },
        mounted() {
            reinitializeAllPlugin();
            this.initDropzone();

            this.getDataTable();

        },
        beforeRouteLeave(to, from, next) {
            this.single.form.documentationComplaint.dropzoneUpload.destroy();
            next();
        },
        methods: {
            initDropzone() {
                const that = this;
                this.single.form.documentationComplaint.dropzoneUpload = new Dropzone(
                    "#dropzone-documentation-complaint", {
                        url: "/",
                        dictCancelUpload: "Cancel",
                        maxFilesize: 20,
                        parallelUploads: 1,
                        uploadMultiple: false,
                        maxFiles: 10,
                        addRemoveLinks: true,
                        acceptedFiles: '.png,.jpg,.jpeg',
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

                if (this.single.filter.id_status) {
                    Object.assign(params, {
                        id_status: this.single.filter.id_status,
                    })
                }

                if (this.single.filter.daterange.length > 0) {
                    Object.assign(params, {
                        start_date: this.single.filter.daterange[0],
                        end_date: this.single.filter.daterange[1],
                    })
                }

                Api().get(`pengaduan`, {
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
            getSourceOfComplaint(keyword, limit) {

                this.pageStatus = 'source-of-complaint-load';

                Api().get(`m-sumber-keluhan/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.listSourceOfComplaint = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listSourceOfComplaint.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listSourceOfComplaint = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getDistrict(keyword, limit, from) {

                this.pageStatus = 'district-load';

                let paramSurabayaResidents = '';

                if (from == 'report-identity') {
                    if (this.single.form.reportIdentity.surabayaResidents == 1) {
                        paramSurabayaResidents = "&is_surabaya=1"
                    } else {
                        paramSurabayaResidents = "&is_surabaya=0"
                    }
                } else if (from == 'client-identity') {
                    if (this.single.form.clientIdentity.new.surabayaResidents == 1) {
                        paramSurabayaResidents = "&is_surabaya=1"
                    } else {
                        paramSurabayaResidents = "&is_surabaya=0"
                    }
                }
                Api().get(`m-kabupaten/lists?limit=${limit}&search=${keyword}${paramSurabayaResidents}`)
                    .then(response => {

                        this.listDistrict = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listDistrict.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listDistrict = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getSubDistrict(keyword, limit, from) {

                this.pageStatus = 'sub-district-load';

                let paramSurabayaResidents = '';

                let paramDistrictOutsideSurabaya = '';

                if (from == 'client-identity') {
                    if (this.single.form.clientIdentity.new.surabayaResidents == 1) {
                        paramSurabayaResidents = "&is_surabaya=1"
                    } else {
                        paramSurabayaResidents = "&is_surabaya=0";
                        paramDistrictOutsideSurabaya = '&id_kabupaten=' + this.single.form.clientIdentity.new
                            .districtOutsideSurabaya.id
                    }
                }

                Api().get(
                        `m-kecamatan/lists?limit=${limit}&search=${keyword}${paramSurabayaResidents}${paramDistrictOutsideSurabaya}`
                    )
                    .then(response => {
                        this.listSubDistrict = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listSubDistrict.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listSubDistrict = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getVillage(keyword, limit) {

                this.pageStatus = 'village-load';

                let paramSubDistrictOutsideSurabaya = '';


                if (this.single.form.clientIdentity.new.subDistrictDomicile.id) {
                    paramSubDistrictOutsideSurabaya = "&id_kecamatan=" + this.single.form.clientIdentity.new
                        .subDistrictDomicile.id;
                }


                Api().get(
                        `m-kelurahan/lists?limit=${limit}&search=${keyword}${paramSubDistrictOutsideSurabaya}`
                    )
                    .then(response => {
                        this.listVillage = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listVillage.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listVillage = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },

            getClient(keyword, limit) {

                this.pageStatus = 'client-load';

                Api().get(`daftar-klien/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {
                        this.listClient = [];
                        for (let i = 0; i < response.data.data.length; i++) {

                            let nik_number = response.data.data[i].nik ? response.data.data[i].nik : '-';

                            this.listClient.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name + '(' + nik_number + ')',
                            });
                        }

                    })
                    .catch(error => {
                        this.listClient = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            uniqueCheckTypeClient(e) {
                this.single.form.clientIdentity.type = [1];
                if (e.target.checked) {
                    this.single.form.clientIdentity.type = [e.target.value];
                }
            },
            getDetailClient() {

                this.$ewpLoadingShow();

                this.single.form.clientIdentity.old.detail.show = false;
                this.single.form.clientIdentity.old.detail.identityNumber = '';
                this.single.form.clientIdentity.old.detail.typeIdentityNumber = '';
                this.single.form.clientIdentity.old.detail.surabayaResidents = 1;
                this.single.form.clientIdentity.old.detail.districtOutsideSurabaya = '';
                this.single.form.clientIdentity.old.detail.addressDomicile = '';
                this.single.form.clientIdentity.old.detail.phoneNumber = '';

                Api().get(`daftar-klien/` + this.single.form.clientIdentity.old.client.id)
                    .then(response => {

                        let context = response.data.data;
                        this.single.form.clientIdentity.old.detail.show = true;
                        this.single.form.clientIdentity.old.detail.identityNumber = context.nik;
                        this.single.form.clientIdentity.old.detail.typeIdentityNumber = context.label_nik;
                        this.single.form.clientIdentity.old.detail.surabayaResidents = context.warga_surabaya ? 1 :
                            0;
                        this.single.form.clientIdentity.old.detail.districtOutsideSurabaya = context.kabupaten_name;
                        this.single.form.clientIdentity.old.detail.subDistrictDomicile = context.kecamatan_name;
                        this.single.form.clientIdentity.old.detail.villageDomicile = context.kelurahan_name;
                        this.single.form.clientIdentity.old.detail.addressDomicile = context.alamat;
                        this.single.form.clientIdentity.old.detail.phoneNumber = context.phone_number;

                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    })
            },

            reset() {

                this.pageStatus = 'standby';

                this.flag = 'insert';

                this.v$.$reset();

                this.single.form.id = '';
                this.single.form.registerNumber = '';
                this.single.form.sourceOfComplaint = {};
                this.single.form.date = '';
                this.single.form.time = '';
                this.single.form.reportIdentity = {
                    fullName: '',
                    nik: '',
                    phoneNumber: '',
                    surabayaResidents: 1,
                    districtOutsideSurabaya: {},
                    addressDomicile: '',
                }
                this.single.form.clientIdentity = {
                    type: [1],
                    old: {
                        client: {},
                        detail: {
                            show: false,
                            identityNumber: '',
                            typeIdentityNumber: '',
                            surabayaResidents: 1,
                            districtOutsideSurabaya: '',
                            addressDomicile: '',
                            phoneNumber: ''
                        }
                    },
                    new: {
                        fullName: '',
                        initialName: '',
                        nik: '',
                        notHaveNik: [],
                        identityNumber: '',
                        surabayaResidents: 1,
                        districtOutsideSurabaya: {},
                        phoneNumber: '',
                        addressDomicile: '',
                        subDistrictDomicile: {},
                        villageDomicile: {}
                    }
                }
                this.single.form.problem = {
                    note: ''
                }
                this.single.form.documentationComplaint.dropzoneUpload.removeAllFiles(true);
                this.single.form.documentationComplaint.dropzoneUpload.files = [];
                this.single.form.documentationComplaint.existing = [];

            }
        }
    }

</script>
<style scoped>
    .border-bottom {
        border-bottom: 1px #f2f2 solid !important;
    }

    .btn-active-selected {
        color: #EE7B33 !important;
        background: #f9ceb3 !important;
        border: 0 !important;
    }

</style>
