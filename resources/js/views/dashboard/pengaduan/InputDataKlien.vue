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
                                <div class="head my-5">
                                    <div class="row pt-5 mt-4">
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap">
                                                <div class="" style="border-right:1px solid grey;padding-right:10px;">
                                                    <h4>Data Klien</h4>
                                                </div>
                                                <div>
                                                    &ensp;
                                                    <span class="text-muted">
                                                        <router-link :to="{ name: 'pengaduan' }" class="text-muted" style="text-decoration:none;">
                                                            Pengaduan
                                                        </router-link>
                                                        - 
                                                        <a href="javascript:void(0)" @click="$router.back()" class="text-muted" style="text-decoration:none;">
                                                            Detail Pengaduan
                                                        </a>
                                                        - Data Klien
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-5">
                                    <div class="col-lg-5">
                                        <h1>Data Klien</h1>
                                    </div>
                                    <div class="col-lg-7 d-flex flex-wrap" style="justify-content:flex-end;">
                                        <button type="button" class="btn me-3" style="background-color:#fff8dd;" @click="$router.push({ name: 'pengaduan', params: { id: this.$route.params.id }, query: { flag: 'penjangkauan' } })">
                                            <span class="text-warning d-flex">
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3"
                                                        d="M17.4166 10.0846C17.9228 10.0846 18.3333 10.495 18.3333 11.0013C18.3333 11.5076 17.9228 11.918 17.4166 11.918H10.0833C9.57699 11.918 9.16658 11.5076 9.16658 11.0013C9.16658 10.495 9.57699 10.0846 10.0833 10.0846H17.4166Z"
                                                        fill="#FFA800" />
                                                    <path
                                                        d="M11.6481 15.8531C12.0061 16.2111 12.0061 16.7915 11.6481 17.1495C11.2901 17.5075 10.7097 17.5075 10.3517 17.1495L4.85174 11.6495C4.50471 11.3025 4.49257 10.7437 4.8242 10.3819L9.86586 4.88189C10.208 4.5087 10.7878 4.48349 11.161 4.82558C11.5342 5.16767 11.5594 5.74752 11.2173 6.12072L6.76871 10.9737L11.6481 15.8531Z"
                                                        fill="#FFA800" />
                                                </svg>
                                                Kembali
                                            </span>
                                        </button>
                                        <div class="dropdown" v-if="$store.state.profile.role_id == ROLE_KONSELOR_ID">
                                            <button class="btn text-white bg-second-primary-custom dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Simpan
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item py-3" href="javascript:void(0);"
                                                        @click="save(1)">Draft</a>
                                                </li>
                                                <li><a class="dropdown-item py-3" href="javascript:void(0);"
                                                        @click="confirmPublishsave()">Publish</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <button class="btn text-white bg-second-primary-custom"
                                            @click="confirmPublishsave()" v-else>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                                <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-header border-0 pt-5 align-items-center">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder text-dark mb-2 c-primary-custom"
                                                    style="font-size:17px !important;">Identitas Klien</span>
                                            </h3>
                                        </div>
                                        <div class="card-body pt-5">
                                            <!--begin::Alert-->
                                            <div
                                                class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5 mb-10">
                                                <!--begin::Icon-->
                                                <span class="svg-icon svg-icon-2hx svg-icon-primary me-4 mb-5 mb-sm-0">

                                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M29.3346 16.0003C29.3346 8.63653 23.3651 2.66699 16.0013 2.66699C8.63751 2.66699 2.66797 8.63653 2.66797 16.0003C2.66797 23.3641 8.63751 29.3337 16.0013 29.3337C23.3651 29.3337 29.3346 23.3641 29.3346 16.0003Z"
                                                            fill="#009EF7" />
                                                        <path
                                                            d="M14.668 14.667V21.3337C14.668 22.07 15.2649 22.667 16.0013 22.667C16.7377 22.667 17.3346 22.07 17.3346 21.3337V14.667C17.3346 13.9306 16.7377 13.3337 16.0013 13.3337C15.2649 13.3337 14.668 13.9306 14.668 14.667Z"
                                                            fill="#009EF7" />
                                                        <path
                                                            d="M16.0013 9.33333C15.2649 9.33333 14.668 9.93029 14.668 10.6667C14.668 11.403 15.2649 12 16.0013 12C16.7377 12 17.3346 11.403 17.3346 10.6667C17.3346 9.93029 16.7377 9.33333 16.0013 9.33333Z"
                                                            fill="#009EF7" />
                                                    </svg>

                                                </span>
                                                <!--end::Icon-->

                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                                    <!--begin::Title-->
                                                    <!--end::Title-->
                                                    <!--begin::Content-->
                                                    <span>Sebagian data didapatkan ketika pengaduan namun anda tetap
                                                        bisa
                                                        mengubahnya apabila tidak sesuai dengan kondisi ketika
                                                        penjangkauan.</span>
                                                    <!--end::Content-->
                                                </div>
                                            </div>
                                            <div v-if="pageStatus == 'page-load'"
                                                class="w-100 d-flex justify-content-center mt-10 mb-10">
                                                <app-loader></app-loader>
                                            </div>
                                            <div v-else class="row align-items-center pb-5 mb-5"
                                                style="border-bottom:1px #ddd dashed">
                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.name.$error ? 'text-danger' : ''">
                                                    Nama Lengkap
                                                </div>
                                                <div class="col-lg-6 mb-5">
                                                    <input type="text" class="form-control" placeholder="Cth: Suwarni"
                                                        v-model="single.name" />
                                                    <div v-if="v$.single.name.$error" class="text-danger">
                                                        Nama Lengkap tidak boleh kosong!
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 mb-5"
                                                    :class="v$.single.inisial.$error ? 'text-danger' : ''">
                                                    Inisial
                                                </div>
                                                <div class="col-lg-2 mb-5">
                                                    <input type="text" class="form-control" placeholder="Cth: AR"
                                                        v-model="single.inisial" />
                                                    <div v-if="v$.single.inisial.$error" class="text-danger">
                                                        Tidak boleh kosong!
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.nik.$error ? 'text-danger' : ''">
                                                    NIK Klien
                                                </div>
                                                <div class="col-lg-7 mb-5">
                                                    <input type="number" class="form-control"
                                                        placeholder="Cth: 3578080907740004" v-model="single.nik"
                                                        :disabled="single.dontHaveNIK" />
                                                    <div v-if="v$.single.nik.$error" class="text-danger">
                                                        NIK tidak boleh kosong!
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 mb-5">
                                                    <div
                                                        class="form-check form-check-custom form-check-solid justify-content-center">
                                                        <input class="form-check-input h-20px w-20px me-2"
                                                            type="checkbox" v-model="single.dontHaveNIK" /> Tidak Punya
                                                        NIK
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder" v-show="single.dontHaveNIK">
                                                    Nomor Identitas Dibuat Otomatis
                                                </div>
                                                <div class="col-lg-7 mb-5" v-show="single.dontHaveNIK">
                                                    <input type="text" class="form-control"
                                                        v-model="single.identityNumber" disabled />
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.noKK.$error ? 'text-danger' : ''">
                                                    Nomor KK
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <input type="number" class="form-control"
                                                        placeholder="Cth: 330 708 150 108 017 2"
                                                        v-model="single.noKK" />
                                                    <div v-if="v$.single.noKK.$error" class="text-danger">
                                                        Nomor KK tidak boleh kosong!
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.nationality.$error ? 'text-danger' : ''">
                                                    Warga Surabaya
                                                </div>
                                                <div class="col-lg-2 mb-5">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <button class="btn btn-sm btn-not-selected"
                                                            v-for="(nationality, idxNationality) in listNationality"
                                                            :key="idxNationality" type="button"
                                                            @click="single.nationality = nationality.id"
                                                            :class="single.nationality == nationality.id ? 'active' : ''">{{nationality.text}}</button>
                                                    </div>
                                                    <div v-if="v$.single.nationality.$error" class="text-danger">
                                                        Pilih Salah Satu!
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 mb-5 fw-bolder"
                                                    :class="v$.single.city.$error ? 'text-danger' : ''"
                                                    v-if="single.nationality  == 2">
                                                    Kabupaten/Kota
                                                </div>

                                                <div class="col-lg-5 mb-5" v-if="single.nationality  == 2">
                                                    <app-select-single v-model="single.city"
                                                        :placeholder="'Pilih kota/kabupaten'" :options="listCity"
                                                        :serverside="true" :loading="pageStatus == 'city-load'"
                                                        @change-search="(keyword, limit) => getCity(keyword, limit, 'listCity', 0)">
                                                    </app-select-single>
                                                    <div v-if="v$.single.city.$error" class="text-danger">
                                                        Kabupaten/Kota tidak boleh kosong!
                                                    </div>
                                                </div>

                                                <div class="col-lg-7 mb-5 fw-bolder" v-else>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.addressFamilyCard.$error ? 'text-danger' : ''">
                                                    Alamat KK
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-12 mb-5">
                                                            <textarea class="form-control"
                                                                placeholder="Cth: Ngagel III No 20, RT001/RW001"
                                                                rows="2" v-model="single.addressFamilyCard"
                                                                @input="if(single.isSameAddress){single.addressResidence = single.addressFamilyCard;}"></textarea>
                                                            <div v-if="v$.single.addressFamilyCard.$error"
                                                                class="text-danger">
                                                                Alamat tidak boleh kosong!
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 mb-5 fw-bolder"
                                                            :class="v$.single.districtFamilyCardAddress.$error ? 'text-danger' : ''">
                                                            Kecamatan
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <app-select-single
                                                                :disabled="!single.nationality || (single.nationality == 2 && !single.city.id)"
                                                                v-model="single.districtFamilyCardAddress"
                                                                :placeholder="'Pilih kecamatan'"
                                                                :options="listDistrictFamilyCardAddress"
                                                                :serverside="true"
                                                                :loading="pageStatus == 'district-family-load'"
                                                                @option-change="(evt) => {if(single.isSameAddress){single.districtResidenceAddress = evt.value}}"
                                                                @change-search="(keyword, limit) => getDistrict(keyword, limit, 'listDistrictFamilyCardAddress','district-family-load',single.city.id, single.nationality == 1 ? '1' : '0')">
                                                            </app-select-single>
                                                            <div v-if="v$.single.districtFamilyCardAddress.$error"
                                                                class="text-danger">
                                                                Kecamatan tidak boleh kosong!
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 mb-5 fw-bolder"
                                                            :class="v$.single.subDistrictFamilyCardAddress.$error ? 'text-danger' : ''">
                                                            Kelurahan
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <app-select-single
                                                                :disabled="!single.districtFamilyCardAddress.id"
                                                                v-model="single.subDistrictFamilyCardAddress"
                                                                :placeholder="'Pilih kelurahan'"
                                                                :options="listSubDistrictFamilyCardAddress"
                                                                :serverside="true"
                                                                :loading="pageStatus == 'subdistrict-family-load'"
                                                                @option-change="(evt) => {if(single.isSameAddress){single.subDistrictResidenceAddress = evt.value}}"
                                                                @change-search="(keyword, limit) => getSubDistrict(keyword, limit, 'listSubDistrictFamilyCardAddress','subdistrict-family-load',single.districtFamilyCardAddress.id)">
                                                            </app-select-single>
                                                            <div v-if="v$.single.subDistrictFamilyCardAddress.$error"
                                                                class="text-danger">
                                                                Kelurahan tidak boleh kosong!
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.phone.$error ? 'text-danger' : ''">
                                                    No. Telepon/Whatsapp
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <div class="input-group">
                                                        <span class="input-group-text"
                                                            style="background:#fff !important;">

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
                                                        <input type="text" class="form-control" min="0"
                                                            placeholder="Contoh: 081 234 567 890"
                                                            style="border-left:0 !important;" v-model="single.phone" />
                                                    </div>
                                                    <div v-if="v$.single.phone.$error" class="text-danger">
                                                        No. Telepon/Whatsapp tidak boleh kosong!
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.addressResidence.$error ? 'text-danger' : ''">
                                                    <div>Alamat Domisili</div>
                                                    <div class="form-check form-check-custom form-check-solid mt-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            @change="ChangeCheckboxAddress()"
                                                            v-model="single.isSameAddress" id="flexCheckDefault" />
                                                        <label class="form-check-label"
                                                            style="font-size:12px;color:#605e5e !important"
                                                            for="flexCheckDefault">
                                                            Sama dengan alamat KK
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-12 mb-5">
                                                            <textarea class="form-control"
                                                                placeholder="Cth: Ngagel III No 20, RT001/RW001"
                                                                :disabled="single.isSameAddress" rows="2"
                                                                v-model="single.addressResidence"></textarea>
                                                            <div v-if="v$.single.addressResidence.$error"
                                                                class="text-danger">
                                                                Alamat tidak boleh kosong!
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 mb-5 fw-bolder"
                                                            :class="v$.single.districtResidenceAddress.$error ? 'text-danger' : ''">
                                                            Kecamatan
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <app-select-single v-model="single.districtResidenceAddress"
                                                                :placeholder="'Pilih kecamatan'"
                                                                :options="listDistrictResidenceAddress"
                                                                :serverside="true" :disabled="single.isSameAddress"
                                                                :loading="pageStatus == 'district-residence-load'"
                                                                @change-search="(keyword, limit) => getDistrict(keyword, limit, 'listDistrictResidenceAddress','district-residence-load','', '')">
                                                            </app-select-single>
                                                            <div v-if="v$.single.districtResidenceAddress.$error"
                                                                class="text-danger">
                                                                Kecamatan tidak boleh kosong!
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 mb-5 fw-bolder"
                                                            :class="v$.single.subDistrictResidenceAddress.$error ? 'text-danger' : ''">
                                                            Kelurahan
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <app-select-single
                                                                v-model="single.subDistrictResidenceAddress"
                                                                :placeholder="'Pilih kelurahan'"
                                                                :disabled="!single.districtResidenceAddress.id || single.isSameAddress"
                                                                :options="listSubDistrictResidenceAddress"
                                                                :serverside="true"
                                                                :loading="pageStatus == 'subdistrict-residence-load'"
                                                                @change-search="(keyword, limit) => getSubDistrict(keyword, limit, 'listSubDistrictResidenceAddress','subdistrict-residence-load',single.districtResidenceAddress.id)">
                                                            </app-select-single>
                                                            <div v-if="v$.single.subDistrictResidenceAddress.$error"
                                                                class="text-danger">
                                                                Kelurahan tidak boleh kosong!
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.placeOfBirth.$error || v$.single.dateOfBirth.$error ? 'text-danger' : ''">
                                                    Tempat, Tanggal Lahir
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="row">
                                                        <div class="col-lg-5 mb-5">
                                                            <app-select-single v-model="single.placeOfBirth"
                                                                :placeholder="'Pilih kota/kabupaten'"
                                                                :options="listPlaceOfBirth" :serverside="true"
                                                                :loading="pageStatus == 'city-load'"
                                                                @change-search="(keyword, limit) => getCity(keyword, limit, 'listPlaceOfBirth')">
                                                            </app-select-single>
                                                            <div v-if="v$.single.placeOfBirth.$error"
                                                                class="text-danger">
                                                                Tempat Lahir tidak boleh kosong!
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 mb-5">
                                                            <app-datepicker type="date" placeholder="Pilih tanggal"
                                                                :format="'DD-MM-YYYY'" :value-type="'YYYY-MM-DD'"
                                                                v-model:value="single.dateOfBirth">
                                                            </app-datepicker>
                                                            <div v-if="v$.single.dateOfBirth.$error"
                                                                class="text-danger">
                                                                Tanggal Lahir tidak boleh kosong!
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <div class="input-group mb-5">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Usia Otomatis" disabled
                                                                    :value="calculateAge(single.dateOfBirth)" />
                                                                <span class="input-group-text"
                                                                    style="color:#5E6278">Tahun</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.categoryClient.$error ? 'text-danger' : ''">
                                                    Kategori Klien
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <button class="btn btn-sm btn-not-selected"
                                                            v-for="(value, i) in listCategoryClient" :key="i"
                                                            type="button" @click="single.categoryClient = value.id"
                                                            :class="single.categoryClient == value.id ? 'active' : ''">{{value.text}}</button>
                                                    </div>
                                                    <div v-if="v$.single.categoryClient.$error" class="text-danger">
                                                        Pilih Salah Satu!
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.speciesClient.$error ? 'text-danger' : ''">
                                                    Jenis Klien
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <button class="btn btn-sm btn-not-selected"
                                                            v-for="(value, i) in listSpeciesClient" :key="i"
                                                            type="button" @click="single.speciesClient = value.id"
                                                            :class="single.speciesClient == value.id ? 'active' : ''">{{value.text}}</button>
                                                    </div>
                                                    <div v-if="v$.single.speciesClient.$error" class="text-danger">
                                                        Pilih Salah Satu!
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.gender.$error ? 'text-danger' : ''">
                                                    Jenis Kelamin
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <button class="btn btn-sm btn-not-selected"
                                                            v-for="(value, i) in listGender" :key="i" type="button"
                                                            @click="single.gender = value.id"
                                                            :class="single.gender == value.id ? 'active' : ''">{{value.text}}</button>
                                                    </div>
                                                    <div v-if="v$.single.gender.$error" class="text-danger">
                                                        Pilih Salah Satu!
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.religion.$error ? 'text-danger' : ''">
                                                    Agama
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <app-select-single v-model="single.religion"
                                                        :placeholder="'Pilih agama'" :options="listReligion"
                                                        :serverside="true" :loading="pageStatus == 'religion-load'"
                                                        @change-search="getReligion">
                                                    </app-select-single>
                                                    <div v-if="v$.single.religion.$error" class="text-danger">
                                                        Agama tidak boleh kosong!
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.work.$error ? 'text-danger' : ''">
                                                    Pekerjaan
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <app-select-single v-model="single.work"
                                                        :placeholder="'Pilih pekerjaan'" :options="listWork"
                                                        :serverside="true" :loading="pageStatus == 'profession-load'"
                                                        @change-search="getProfession">
                                                    </app-select-single>
                                                    <div v-if="v$.single.work.$error" class="text-danger">
                                                        Pekerjaan tidak boleh kosong!
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Penghasilan Perbulan (Opsional)
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <div class="input-group mb-5">
                                                        <span class="input-group-text" style="color:#5E6278">Rp</span>
                                                        <app-money class="form-control" v-model="single.monthlyIncome"
                                                            v-bind="moneyConfig">
                                                        </app-money>

                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.maritialStatus.$error ? 'text-danger' : ''">
                                                    Status Perkawinan
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <app-select-single v-model="single.maritialStatus"
                                                        :placeholder="'Pilih status pernikahan'"
                                                        :options="listMaritialStatus" :serverside="true"
                                                        :loading="pageStatus == 'marital-status-load'"
                                                        @change-search="getMaritalStatus">
                                                    </app-select-single>
                                                    <div v-if="v$.single.maritialStatus.$error" class="text-danger">
                                                        Status Perkawinan tidak boleh kosong!
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.bpjsOwnership.$error ? 'text-danger' : ''">
                                                    Kepemilikan BPJS
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-5">
                                                            <div class="d-flex align-items-center flex-wrap">
                                                                <button class="btn btn-sm btn-not-selected"
                                                                    v-for="(val, i) in listBpjsOwnership" :key="i"
                                                                    type="button" @click="single.bpjsOwnership = val.id"
                                                                    :class="single.bpjsOwnership == val.id ? 'active' : ''">{{val.text}}</button>
                                                            </div>
                                                            <div v-if="v$.single.bpjsOwnership.$error"
                                                                class="text-danger">
                                                                Pilih Salah Satu
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- PENDIDIKAN TERAKHIR -->
                                            <h4 class="c-primary-custom pb-5" v-if="pageStatus != 'page-load'">
                                                Pendidikan Terakhir</h4>
                                            <div class="row align-items-center" v-if="pageStatus != 'page-load'">
                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.lastEducation.$error ? 'text-danger' : ''">
                                                    Pendidikan
                                                </div>
                                                <div class="col-lg-3 mb-5">
                                                    <app-select-single v-model="single.lastEducation"
                                                        :placeholder="'Pilih pendidikan'" :options="listEducation"
                                                        :serverside="true" :loading="pageStatus == 'education-load'"
                                                        @change-search="getLatestEducation">
                                                    </app-select-single>
                                                    <div v-if="v$.single.lastEducation.$error" class="text-danger">
                                                        Pendidikan tidak boleh kosong!
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Jurusan Sekolah (Opsional)
                                                </div>
                                                <div class="col-lg-3 mb-5">
                                                    <app-select-single v-model="single.schoolMajors"
                                                        :placeholder="'Pilih jurusan sekolah'"
                                                        :options="listSchoolMajors" :serverside="true"
                                                        :loading="pageStatus == 'school-major-load'"
                                                        @change-search="getSchoolMajors">
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Kelas (Opsional)
                                                </div>
                                                <div class="col-lg-3 mb-5">
                                                    <app-select-single v-model="single.classEducation"
                                                        :placeholder="'Pilih kelas'" :options="listClassEducation"
                                                        :serverside="false">
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Tahun Lulus (Opsional)
                                                </div>
                                                <div class="col-lg-3 mb-5">
                                                    <app-datepicker type="year" placeholder="Pilih tanggal"
                                                        :format="'YYYY'" :value-type="'YYYY'"
                                                        v-model:value="single.graduationYear">
                                                    </app-datepicker>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Nama Instansi Sekolah
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <input type="text" class="form-control"
                                                        placeholder="Cth: SD 1 Surabaya" v-model="single.schoolName" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <app-scroll-top></app-scroll-top>
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
                moneyConfig: {
                    masked: false,
                    prefix: '',
                    suffix: '',
                    thousands: '.',
                    decimal: ',',
                    precision: 0,
                    disableNegative: false,
                    disabled: false,
                    min: null,
                    max: null,
                    allowBlank: false,
                    minimumNumberOfCharacters: 0,
                },
                listNationality: [{
                        id: 1,
                        text: 'Ya'
                    },
                    {
                        id: 2,
                        text: 'Tidak'
                    },
                ],
                listCity: [],
                listDistrictFamilyCardAddress: [],
                listSubDistrictFamilyCardAddress: [],
                listDistrictResidenceAddress: [],
                listSubDistrictResidenceAddress: [],
                listWork: [],
                listReligion: [],
                listPlaceOfBirth: [],
                listCategoryClient: [{
                        id: 1,
                        text: 'Anak-anak'
                    },
                    {
                        id: 2,
                        text: 'Dewasa'
                    }
                ],
                listSpeciesClient: [{
                        id: 1,
                        text: 'Umum'
                    },
                    {
                        id: 2,
                        text: 'Disabilitas'
                    },
                ],
                listGender: [{
                        id: 1,
                        text: 'Laki-Laki'
                    },
                    {
                        id: 2,
                        text: 'Perempuan'
                    }
                ],
                listMaritialStatus: [],
                listBpjsOwnership: [{
                        id: 1,
                        text: 'PBI'
                    },
                    {
                        id: 2,
                        text: 'Korporasi'
                    },
                    {
                        id: 3,
                        text: 'Mandiri'
                    },
                    {
                        id: 4,
                        text: 'Tidak Punya'
                    }
                ],
                listEducation: [],
                listSchoolMajors: [],
                single: {
                    id: '',
                    name: '',
                    inisial: '',
                    dontHaveNIK: false,
                    nik: '',
                    nationality: '',
                    identityNumber: '',
                    phone: '',
                    city: {},
                    districtFamilyCardAddress: {},
                    subDistrictFamilyCardAddress: {},
                    isSameAddress: false,
                    addressResidence: '',
                    districtResidenceAddress: {},
                    subDistrictResidenceAddress: {},

                    noKK: '',
                    addressFamilyCard: '',

                    placeOfBirth: {},
                    dateOfBirth: '',
                    categoryClient: '',
                    speciesClient: '',
                    gender: '',
                    religion: {},
                    work: {},
                    monthlyIncome: '',
                    maritialStatus: {},
                    bpjsOwnership: '',
                    lastEducation: {},
                    schoolMajors: {},
                    classEducation: {},
                    schoolName: '',
                    graduationYear: '',
                }
            }

        },
        watch: {
            'single.dontHaveNIK': function () {
                this.single.nik = '';
            },
            'single.nationality': function () {
                this.single.city = {};
                this.single.districtFamilyCardAddress = {};
                this.single.subDistrictFamilyCardAddress = {};

                if (this.single.isSameAddress) {
                    this.single.districtResidenceAddress = {};
                    this.single.subDistrictResidenceAddress = {};
                }
            },
            'single.city': function () {
                this.single.districtFamilyCardAddress = {};
                this.single.subDistrictFamilyCardAddress = {};
            },
            'single.districtFamilyCardAddress': function () {
                this.single.subDistrictFamilyCardAddress = {};
            },
            'single.districtResidenceAddress': function () {
                this.single.subDistrictResidenceAddress = {};
            }
        },
        computed: {
            listClassEducation() {
                let result = []
                for (let i = 1; i <= 12; i++) {
                    result.push({
                        id: i,
                        text: i
                    })
                }
                return result
            },
        },
        validations() {
            return {
                single: {
                    name: {
                        required
                    },
                    inisial: {
                        required
                    },
                    nik: {
                        required: requiredIf(function () {
                            return !this.single.dontHaveNIK
                        })
                    },
                    noKK: {
                        required
                    },
                    nationality: {
                        required
                    },
                    phone: {
                        required
                    },
                    city: {
                        required: requiredIf(function () {
                            return this.single.nationality == 2
                        })
                    },
                    addressResidence: {
                        required,
                    },
                    districtResidenceAddress: {
                        required
                    },
                    subDistrictResidenceAddress: {
                        required
                    },

                    addressFamilyCard: {
                        required
                    },
                    districtFamilyCardAddress: {
                        required
                    },
                    subDistrictFamilyCardAddress: {
                        required
                    },
                    placeOfBirth: {
                        required
                    },
                    dateOfBirth: {
                        required
                    },
                    categoryClient: {
                        required
                    },
                    speciesClient: {
                        required
                    },
                    gender: {
                        required
                    },
                    religion: {
                        required
                    },
                    work: {
                        required
                    },
                    maritialStatus: {
                        required
                    },
                    bpjsOwnership: {
                        required
                    },
                    lastEducation: {
                        required
                    },
                    schoolName: {
                        required
                    }

                },
            }
        },
        mounted() {
            reinitializeAllPlugin();

            this.pageStatus = 'page-load';
            this.$store.dispatch('complaint/getDetailComplaintOutreachClient', this.$route.params
                .idPenjangkauan).then((res) => {
                if (res.status == 200 || res.status == 201) {
                    if (res.data.data.klien) {
                        let context = res.data.data.klien;

                        this.single.id = context.id;
                        this.single.name = context.name;
                        this.single.inisial = context.initial_name
                        this.single.dontHaveNIK = context.is_has_nik ? false : true;

                        let addressKK = '';
                        let kecamatanKK = '';
                        let kelurahanKK = '';

                        let addressDomisili = '';
                        let kecamatanDomisili = '';
                        let kelurahanDomisili = '';

                        setTimeout(() => {
                            this.single.nik = context.nik_number;
                        }, 300);
                        this.single.nationality = context.is_surabaya_resident ? 1 : 2;
                        this.single.phone = context.phone_number;
                        this.single.identityNumber = context.identity_number;

                        if (context.klien_history) {
                            let clientHistory = context.klien_history;
                            if (clientHistory.kabupaten_tinggal) {
                                setTimeout(() => {
                                    this.single.city = {
                                        id: clientHistory.kabupaten_tinggal.id,
                                        text: clientHistory.kabupaten_tinggal.name
                                    }
                                }, 300);

                            }


                            this.single.addressFamilyCard = clientHistory.kk_address;
                            addressKK = clientHistory.kk_address;

                            if (clientHistory.kelurahan_kk) {
                                if (clientHistory.kelurahan_kk.kecamatan) {
                                    kecamatanKK = clientHistory.kelurahan_kk.kecamatan.id;
                                    setTimeout(() => {
                                        this.single.districtFamilyCardAddress = {
                                            id: clientHistory.kelurahan_kk.kecamatan.id,
                                            text: clientHistory.kelurahan_kk.kecamatan.name
                                        }
                                    }, 600);

                                }
                                kelurahanKK = clientHistory.kelurahan_kk.id;
                                setTimeout(() => {
                                    this.single.subDistrictFamilyCardAddress = {
                                        id: clientHistory.kelurahan_kk.id,
                                        text: clientHistory.kelurahan_kk.name
                                    }
                                }, 900);

                            }



                            this.single.addressResidence = clientHistory.residence_address;
                            addressDomisili = clientHistory.residence_address;

                            if (clientHistory.kelurahan_tinggal) {
                                if (clientHistory.kelurahan_tinggal.kecamatan) {
                                    setTimeout(() => {
                                        kecamatanDomisili = clientHistory.kelurahan_tinggal.kecamatan
                                        .id;
                                        this.single.districtResidenceAddress = {
                                            id: clientHistory.kelurahan_tinggal.kecamatan.id,
                                            text: clientHistory.kelurahan_tinggal.kecamatan.name
                                        }
                                    }, 300);
                                }
                                kelurahanDomisili = clientHistory.kelurahan_tinggal.id;
                                setTimeout(() => {
                                    this.single.subDistrictResidenceAddress = {
                                        id: clientHistory.kelurahan_tinggal.id,
                                        text: clientHistory.kelurahan_tinggal.name
                                    }
                                }, 500);


                            }


                            this.single.noKK = clientHistory.kk_number;
                            if (clientHistory.kabupaten_lahir) {
                                this.single.placeOfBirth = {
                                    id: clientHistory.kabupaten_lahir.id,
                                    text: clientHistory.kabupaten_lahir.name
                                }
                            }

                            if (clientHistory.birth_date) {
                                this.single.dateOfBirth = this.$moment(clientHistory.birth_date, 'DD-MM-YYYY')
                                    .format(
                                        'YYYY-MM-DD');
                            }

                            this.single.categoryClient = clientHistory.age_category;
                            this.single.speciesClient = clientHistory.physical_category;
                            this.single.gender = clientHistory.gender;
                            if (clientHistory.agama) {
                                this.single.religion = {
                                    id: clientHistory.agama.id,
                                    text: clientHistory.agama.name
                                }
                            }

                            if (clientHistory.pekerjaan) {
                                this.single.work = {
                                    id: clientHistory.pekerjaan.id,
                                    text: clientHistory.pekerjaan.name,
                                }
                            }

                            this.single.monthlyIncome = clientHistory.monthly_income;

                            if (clientHistory.status_pernikahan) {
                                this.single.maritialStatus = {
                                    id: clientHistory.status_pernikahan.id,
                                    text: clientHistory.status_pernikahan.name
                                }
                            }

                            this.single.bpjsOwnership = clientHistory.bpjs_category;
                            if (clientHistory.pendidikan_terakhir) {
                                this.single.lastEducation = {
                                    id: clientHistory.pendidikan_terakhir.id,
                                    text: clientHistory.pendidikan_terakhir.name
                                }
                            }

                            if (clientHistory.jurusan) {
                                this.single.schoolMajors = {
                                    id: clientHistory.jurusan.id,
                                    text: clientHistory.jurusan.name
                                };
                            }
                            if (clientHistory.highest_class) {
                                this.single.classEducation = {
                                    id: clientHistory.highest_class,
                                    text: clientHistory.highest_class
                                }
                            }

                            this.single.schoolName = clientHistory.nama_sekolah;
                            this.single.graduationYear = clientHistory.graduation_year ? String(clientHistory
                                .graduation_year) : '';

                            setTimeout(() => {
                                if (addressKK && kecamatanKK && kelurahanKK) {
                                    if (addressKK == addressDomisili && kecamatanKK ==
                                        kecamatanDomisili &&
                                        kelurahanKK == kelurahanDomisili) {
                                        this.single.isSameAddress = true;
                                    }
                                }
                            }, 1000);
                        }


                    } else if (res.data.data.m_klien) {
                        let context = res.data.data.m_klien;

                        this.single.name = context.name;
                        this.single.inisial = context.initial_name
                        this.single.dontHaveNIK = context.is_has_nik ? false : true;
                        setTimeout(() => {
                            this.single.nik = context.nik_number;
                        }, 300);
                        this.single.nationality = context.is_surabaya_resident ? 1 : 2;
                        this.single.phone = context.phone_number;

                        let addressKK = '';
                        let kecamatanKK = '';
                        let kelurahanKK = '';

                        let addressDomisili = '';
                        let kecamatanDomisili = '';
                        let kelurahanDomisili = '';


                        this.single.identityNumber = context.identity_number;

                        this.single.addressResidence = context.residence_address;
                        addressDomisili = context.residence_address;

                        if (context.kabupaten_tinggal) {
                            setTimeout(() => {
                                this.single.city = {
                                    id: context.kabupaten_tinggal.id,
                                    text: context.kabupaten_tinggal.name
                                }
                            }, 300);

                        }

                        if (context.kelurahan_tinggal) {
                            if (context.kelurahan_tinggal.kecamatan) {
                                kecamatanDomisili = context.kelurahan_tinggal.kecamatan.id;
                                setTimeout(() => {
                                    this.single.districtResidenceAddress = {
                                        id: context.kelurahan_tinggal.kecamatan.id,
                                        text: context.kelurahan_tinggal.kecamatan.name
                                    }
                                }, 600);

                            }
                            kelurahanDomisili = context.kelurahan_tinggal.id;
                            setTimeout(() => {
                                this.single.subDistrictResidenceAddress = {
                                    id: context.kelurahan_tinggal.id,
                                    text: context.kelurahan_tinggal.name
                                }
                            }, 900);


                        }


                        if (context.latest_klien_history) {
                            let clientHistory = context.latest_klien_history;

                            this.single.addressFamilyCard = clientHistory.kk_address;
                            addressKK = clientHistory.kk_address;
                            if (clientHistory.kelurahan_kk) {
                                if (clientHistory.kelurahan_kk.kecamatan) {
                                    kecamatanKK = clientHistory.kelurahan_kk.kecamatan.id;
                                    this.single.districtFamilyCardAddress = {
                                        id: clientHistory.kelurahan_kk.kecamatan.id,
                                        text: clientHistory.kelurahan_kk.kecamatan.name
                                    }
                                }
                                kelurahanKK = clientHistory.kelurahan_kk.id;
                                setTimeout(() => {
                                    this.single.subDistrictFamilyCardAddress = {
                                        id: clientHistory.kelurahan_kk.id,
                                        text: clientHistory.kelurahan_kk.name
                                    }
                                }, 300);

                            }

                            this.single.noKK = clientHistory.kk_number;
                            if (clientHistory.kabupaten_lahir) {
                                this.single.placeOfBirth = {
                                    id: clientHistory.kabupaten_lahir.id,
                                    text: clientHistory.kabupaten_lahir.name
                                }
                            }

                            if (clientHistory.birth_date) {
                                this.single.dateOfBirth = this.$moment(clientHistory.birth_date, 'DD-MM-YYYY')
                                    .format(
                                        'YYYY-MM-DD');
                            }

                            this.single.categoryClient = clientHistory.age_category;
                            this.single.speciesClient = clientHistory.physical_category;
                            this.single.gender = clientHistory.gender;
                            if (clientHistory.agama) {
                                this.single.religion = {
                                    id: clientHistory.agama.id,
                                    text: clientHistory.agama.name
                                }
                            }

                            if (clientHistory.pekerjaan) {
                                this.single.work = {
                                    id: clientHistory.pekerjaan.id,
                                    text: clientHistory.pekerjaan.name,
                                }
                            }

                            this.single.monthlyIncome = clientHistory.monthly_income;

                            if (clientHistory.status_pernikahan) {
                                this.single.maritialStatus = {
                                    id: clientHistory.status_pernikahan.id,
                                    text: clientHistory.status_pernikahan.name
                                }
                            }

                            this.single.bpjsOwnership = clientHistory.bpjs_category;
                            if (clientHistory.pendidikan_terakhir) {
                                this.single.lastEducation = {
                                    id: clientHistory.pendidikan_terakhir.id,
                                    text: clientHistory.pendidikan_terakhir.name
                                }
                            }

                            if (clientHistory.jurusan) {
                                this.single.schoolMajors = {
                                    id: clientHistory.jurusan.id,
                                    text: clientHistory.jurusan.name
                                };
                            }
                            if (clientHistory.highest_class) {
                                this.single.classEducation = {
                                    id: clientHistory.highest_class,
                                    text: clientHistory.highest_class
                                }
                            }

                            this.single.schoolName = clientHistory.nama_sekolah;
                            this.single.graduationYear = clientHistory.graduation_year ? String(clientHistory
                                .graduation_year) : '';
                        }

                        if (addressKK && kecamatanKK && kelurahanKK) {
                            if (addressKK == addressDomisili && kecamatanKK == kecamatanDomisili &&
                                kelurahanKK == kelurahanDomisili) {
                                this.single.isSameAddress = true;
                            }
                        }
                    }
                } else {
                    this.$axiosHandleError(res);
                }

                setTimeout(() => {
                    this.pageStatus = 'standby';
                }, 1000);
            });

        },
        beforeRouteLeave(to, from, next) {
            next();
        },
        methods: {
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
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getMaritalStatus(keyword, limit) {
                this.getSelectList(`m-status-pernikahan/lists?limit=${limit}&search=${keyword}`, 'listMaritialStatus',
                    'marital-status-load')
            },
            getReligion(keyword, limit) {
                this.getSelectList(`m-agama/lists?limit=${limit}&search=${keyword}`, 'listReligion', 'religion-load')
            },
            getCity(keyword, limit, listKey, surabayaResidents = '') {
                let surabayaResidentsParam = '';
                if (surabayaResidents !== '') {
                    surabayaResidentsParam = "&is_surabaya=" + surabayaResidents;
                }

                this.getSelectList(`m-kabupaten/lists?limit=${limit}&search=${keyword}${surabayaResidentsParam}`,
                    listKey,
                    'city-load')
            },
            getDistrict(keyword, limit, listKey, pageStatus, cityId = '', surabayaResidents = '') {

                let cityParam = '';
                let surabayaResidentsParam = '';
                if (cityId !== '') {
                    cityParam = "&id_kabupaten=" + cityId
                }

                if (surabayaResidents !== '') {
                    surabayaResidentsParam = "&is_surabaya=" + surabayaResidents
                }
                this.getSelectList(
                    `m-kecamatan/lists?limit=${limit}&search=${keyword}${cityParam}${surabayaResidentsParam}`,
                    listKey,
                    pageStatus)
            },

            getSubDistrict(keyword, limit, listKey, pageStatus, districtId = '') {
                this.getSelectList(`m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${districtId}`,
                    listKey,
                    pageStatus)
            },
            getProfession(keyword, limit) {
                this.getSelectList(`m-pekerjaan/lists?limit=${limit}&search=${keyword}`, 'listWork', 'profession-load')
            },
            calculateAge(val) {
                let result = this.$moment().diff(val, 'years');

                return result ? result : 0
            },
            getLatestEducation(keyword, limit) {
                this.getSelectList(`m-pendidikan-terakhir/lists?limit=${limit}&search=${keyword}`, 'listEducation',
                    'education-load')
            },
            getSchoolMajors(keyword, limit) {
                this.getSelectList(`m-jurusan-sekolah/lists?limit=${limit}&search=${keyword}`, 'listSchoolMajors',
                    'school-major-load')
            },
            confirmPublishsave() {
                if (this.$store.state.profile.role_id != this.ROLE_KONSELOR_ID) {
                    this.save(2);
                    return false;
                }

                this.$swal({
                    title: 'Publish Survey?',
                    text: "Data yang telah di publish tidak bisa di edit lagi",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F64E60',
                    cancelButtonColor: '#FFFFFF',
                    cancelButtonTextColor: "black",
                    confirmButtonText: 'Ya, Publish',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.save(2);
                    }
                });
            },
            save(tipe_simpan) {
                this.v$.$reset();
                if (tipe_simpan == 2) {
                    this.v$.$touch();

                    if (this.v$.$error) {
                        this.$toast.error("Silahkan lengkapi form dibawah!");
                        return false;
                    }
                }

                let formData = {
                    tipe_simpan: tipe_simpan,
                    id_penjangkauan_klien: this.single.id,
                    nama: this.single.name,
                    inisial: this.single.inisial,
                    nik: this.single.nik,
                    nomor_identitas: this.single.identityNumber,
                    warga_surabaya: this.single.nationality,
                    telepon: this.single.phone,
                    alamat_domisili: this.single.addressResidence,
                    id_kelurahan_tinggal: this.getValueSelect(this.single.subDistrictResidenceAddress),
                    no_kk: this.single.noKK,
                    alamat_kk: this.single.addressFamilyCard,
                    id_kelurahan_kk: this.getValueSelect(this.single.subDistrictFamilyCardAddress),
                    id_kabupaten_tinggal: this.getValueSelect(this.single.city),
                    id_kabupaten_lahir: this.getValueSelect(this.single.placeOfBirth),
                    tanggal_lahir: this.single.dateOfBirth ? this.$moment(this.single.dateOfBirth).format(
                        'DD-MM-YYYY') : '',
                    kategori_klien: this.single.categoryClient,
                    jenis_klien: this.single.speciesClient,
                    jenis_kelamin: this.single.gender,
                    tipe_bpjs: this.single.bpjsOwnership,
                    id_agama: this.getValueSelect(this.single.religion),
                    id_pekerjaan: this.getValueSelect(this.single.work),
                    id_status_pernikahan: this.getValueSelect(this.single.maritialStatus),
                    penghasilan: this.single.monthlyIncome,
                    id_pendidikan_terakhir: this.getValueSelect(this.single.lastEducation),

                }

                if (this.getValueSelect(this.single.schoolMajors)) {
                    Object.assign(formData, {
                        id_jurusan: this.getValueSelect(this.single.schoolMajors),
                    })
                }

                if (this.getValueSelect(this.single.classEducation)) {
                    Object.assign(formData, {
                        kelas: this.getValueSelect(this.single.classEducation),
                    })
                }

                if (this.single.graduationYear) {
                    Object.assign(formData, {
                        tahun_lulus: this.single.graduationYear
                    })
                }


                if (this.single.schoolName) {
                    Object.assign(formData, {
                        nama_sekolah: this.single.schoolName
                    })
                }

                formData = this.cleanObject(formData);

                this.$ewpLoadingShow();
                Api().post('penjangkauan/' + this.$route.params.idPenjangkauan + '/klien', formData)
                    .then(response => {
                        this.$swal({
                            title: "Berhasil!",
                            text: this.$store.state.profile.role_id == this.ROLE_KONSELOR_ID ?
                                tipe_simpan == 2 ? 'Data berhasil dipublish' :
                                'Data berhasil disimpan sebagai draft. Anda masih bisa mengubahnya dilain waktu' :
                                'Data berhasil disimpan',
                            icon: "success",
                        }).then(result => {
                            this.$router.push({
                                name: 'pengaduan',
                                params: { id: this.$route.params.id },
                                query: {
                                    flag: 'penjangkauan'
                                }
                            });
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            getValueSelect(obj) {
                if (!obj) {
                    return ''
                }

                return obj.id ? obj.id : ''
            },
            cleanObject(obj) {
                for (var propName in obj) {
                    if (obj[propName] === null || obj[propName] === undefined || obj[propName] === '') {
                        delete obj[propName];
                    }
                }
                return obj
            },
            ChangeCheckboxAddress() {

                this.single.districtResidenceAddress = {};
                this.single.subDistrictResidenceAddress = {};
                this.single.addressResidence = '';

                if (this.single.isSameAddress) {
                    if (this.single.districtFamilyCardAddress.id) {
                        this.single.districtResidenceAddress = {
                            id: this.single.districtFamilyCardAddress.id,
                            text: this.single.districtFamilyCardAddress.text
                        }
                    }

                    if (this.single.subDistrictFamilyCardAddress.id) {
                        setTimeout(() => {
                            this.single.subDistrictResidenceAddress = {
                                id: this.single.subDistrictFamilyCardAddress.id,
                                text: this.single.subDistrictFamilyCardAddress.text
                            }
                        }, 200);
                    }

                    this.single.addressResidence = this.single.addressFamilyCard;
                }
            }
        }
    }

</script>

<style scoped>
    .btn-not-selected {
        color: #a7a5a5;
        margin-right: 8px;
        margin-bottom: 8px;
        border: 1px #ddd solid !important;
    }

    .btn-not-selected.active {
        background-color: #EE7B33 !important;
        color: #fff !important
    }

</style>
