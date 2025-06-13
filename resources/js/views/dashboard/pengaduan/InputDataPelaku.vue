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
                                                    <h4>Survey Data Pelaku</h4>
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
                                                        - Survey Data Pelaku
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-5">
                                    <div class="col-lg-5">
                                        <h1>Data Pelaku</h1>
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
                                                        @click="save(0)">Draft</a>
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
                                                    style="font-size:17px !important;">Identitas Pelaku</span>
                                            </h3>
                                        </div>
                                        <div class="card-body pt-5">
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
                                                <div class="col-lg-9 mb-5">
                                                    <input type="text" class="form-control" placeholder="Cth: Suwarni"
                                                        v-model="single.name" />
                                                    <div v-if="v$.single.name.$error" class="text-danger">
                                                        Nama Lengkap tidak boleh kosong!
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.gender.$error ? 'text-danger' : ''">
                                                    Jenis Kelamin
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <button class="btn btn-sm btn-not-selected"
                                                            v-for="(gender, idxGender) in listGender" :key="idxGender"
                                                            type="button" @click="single.gender = gender.id"
                                                            :class="single.gender == gender.id ? 'active' : ''">{{gender.text}}</button>
                                                    </div>
                                                    <div v-if="v$.single.gender.$error" class="text-danger">
                                                        Pilih Salah Satu!
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.nationality.$error ? 'text-danger' : ''">
                                                    Kewarganegaraan
                                                </div>
                                                <div class="col-lg-9 mb-5">
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
                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.relationshipWithClient.$error ? 'text-danger' : ''">
                                                    Hubungan Dengan Klien
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <app-select-single v-model="single.relationshipWithClient"
                                                        :placeholder="'Pilih hubungan dengan klien'"
                                                        :options="listRelationshipWithClient" :serverside="true"
                                                        :loading="pageStatus == 'rel-client-load'"
                                                        @change-search="getRelationshipWithClient">
                                                    </app-select-single>
                                                    <div v-if="v$.single.relationshipWithClient.$error"
                                                        class="text-danger">
                                                        Hubungan Dengan Klien tidak boleh kosong!
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Tempat, Tanggal Lahir(Opsional)
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="row">
                                                        <div class="col-lg-5 mb-5">
                                                            <app-select-single v-model="single.placeOfBirth"
                                                                :placeholder="'Pilih kota/kabupaten'"
                                                                :options="listPlaceOfBirth" :serverside="true"
                                                                :loading="pageStatus == 'city-load'"
                                                                @change-search="getCity">
                                                            </app-select-single>
                                                        </div>
                                                        <div class="col-lg-3 mb-5">
                                                            <app-datepicker type="date" placeholder="Pilih tanggal"
                                                                :format="'DD-MM-YYYY'" :value-type="'YYYY-MM-DD'"
                                                                v-model:value="single.dateOfBirth"
                                                                @change="calculateAge(single.dateOfBirth)">
                                                            </app-datepicker>
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <div class="input-group mb-5">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Usia Otomatis" disabled
                                                                    v-model="single.age" />
                                                                <span class="input-group-text"
                                                                    style="color:#5E6278">Tahun</span>
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
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Nomor NIK (Opsional)
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <input type="number" class="form-control"
                                                        placeholder="Cth: 3578080907740004" v-model="single.nik" />
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Nomor KK (Opsional)
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <input type="number" class="form-control"
                                                        placeholder="Cth: 330 708 150 108 017 2"
                                                        v-model="single.noKK" />
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Alamat KK (Opsional)
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-12 mb-5">
                                                            <textarea class="form-control"
                                                                placeholder="Cth: Ngagel III No 20, RT001/RW001"
                                                                @input = "if(single.isSameAddress){single.addressResidence = single.addressFamilyCard;}"
                                                                rows="2" v-model="single.addressFamilyCard"></textarea>
                                                        </div>
                                                        <div class="col-lg-2 mb-5 fw-bolder">
                                                            Kecamatan
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <app-select-single
                                                                v-model="single.districtFamilyCardAddress"
                                                                :placeholder="'Pilih kecamatan'"
                                                                :options="listDistrictFamilyCardAddress"
                                                                :serverside="true"
                                                                :loading="pageStatus == 'district-family-load'"
                                                                @option-change="(evt) => {if(single.isSameAddress){single.districtResidenceAddress = evt.value; single.subDistrictResidenceAddress = {}} single.subDistrictFamilyCardAddress = {}}"                                                                
                                                                @change-search="(keyword, limit) => getDistrict(keyword, limit, 'listDistrictFamilyCardAddress','district-family-load')">
                                                            </app-select-single>
                                                        </div>
                                                        <div class="col-lg-2 mb-5 fw-bolder">
                                                            Kelurahan
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <app-select-single
                                                                v-model="single.subDistrictFamilyCardAddress"
                                                                :placeholder="'Pilih kelurahan'"
                                                                :options="listSubDistrictFamilyCardAddress"
                                                                :serverside="true"
                                                                :loading="pageStatus == 'subdistrict-family-load'"
                                                                @option-change="(evt) => {if(single.isSameAddress){single.subDistrictResidenceAddress = evt.value}}"
                                                                :disabled="!single.districtFamilyCardAddress.id"
                                                                @change-search="(keyword, limit) => getSubDistrict(keyword, limit, 'listSubDistrictFamilyCardAddress','subdistrict-family-load', single.districtFamilyCardAddress.id)">
                                                            </app-select-single>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    <div>Alamat Domisili (Opsional)</div>
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
                                                                :disabled="single.isSameAddress"
                                                                rows="2" v-model="single.addressResidence"></textarea>
                                                        </div>
                                                        <div class="col-lg-2 mb-5 fw-bolder">
                                                            Kecamatan
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <app-select-single v-model="single.districtResidenceAddress"
                                                                :placeholder="'Pilih kecamatan'"
                                                                :options="listDistrictResidenceAddress"
                                                                :serverside="true"
                                                                :disabled="single.isSameAddress"
                                                                @option-change="single.subDistrictResidenceAddress = {}"
                                                                :loading="pageStatus == 'district-residence-load'"
                                                                @change-search="(keyword, limit) => getDistrict(keyword, limit, 'listDistrictResidenceAddress','district-residence-load')">
                                                            </app-select-single>
                                                        </div>
                                                        <div class="col-lg-2 mb-5 fw-bolder">
                                                            Kelurahan
                                                        </div>
                                                        <div class="col-lg-4 mb-5">
                                                            <app-select-single
                                                                v-model="single.subDistrictResidenceAddress"
                                                                :placeholder="'Pilih kelurahan'"
                                                                :options="listSubDistrictResidenceAddress"
                                                                :serverside="true"
                                                                :disabled="!single.districtResidenceAddress.id || single.isSameAddress"
                                                                :loading="pageStatus == 'subdistrict-residence-load'"
                                                                @change-search="(keyword, limit) => getSubDistrict(keyword, limit, 'listSubDistrictResidenceAddress','subdistrict-residence-load',single.districtResidenceAddress.id)">
                                                            </app-select-single>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Agama(Opsional)
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <app-select-single v-model="single.religion"
                                                        :placeholder="'Pilih agama'" :options="listReligion"
                                                        :serverside="true" :loading="pageStatus == 'religion-load'"
                                                        @change-search="getReligion">
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Pekerjaan(Opsional)
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <app-select-single v-model="single.work"
                                                        :placeholder="'Pilih pekerjaan'" :options="listWork"
                                                        :serverside="true" :loading="pageStatus == 'profession-load'"
                                                        @change-search="getProfession">
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder"
                                                    :class="v$.single.maritialStatus.$error ? 'text-danger' : ''">
                                                    Status Pernikahan
                                                </div>
                                                <div class="col-lg-9 mb-5">
                                                    <app-select-single v-model="single.maritialStatus"
                                                        :placeholder="'Pilih status pernikahan'"
                                                        :options="listMaritialStatus" :serverside="true"
                                                        :loading="pageStatus == 'marital-status-load'"
                                                        @change-search="getMaritalStatus">
                                                    </app-select-single>
                                                    <div v-if="v$.single.maritialStatus.$error" class="text-danger">
                                                        Status Pernikahan tidak boleh kosong!
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="c-primary-custom pb-5" v-if="pageStatus != 'page-load'">
                                                Pendidikan Terakhir(Opsional)</h4>
                                            <div v-if="pageStatus != 'page-load'" class="row align-items-center">
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Pendidikan Terakhir
                                                </div>
                                                <div class="col-lg-3 mb-5">
                                                    <app-select-single v-model="single.lastEducation"
                                                        :placeholder="'Pilih pendidikan'" :options="listEducation"
                                                        :serverside="true" :loading="pageStatus == 'education-load'"
                                                        @change-search="getLatestEducation">
                                                    </app-select-single>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Jurusan Sekolah
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
                                                    Tahun Lulus(Opsional)
                                                </div>
                                                <div class="col-lg-3 mb-5">
                                                    <app-datepicker type="year" placeholder="Pilih tahun"
                                                        :format="'YYYY'" :value-type="'YYYY'"
                                                        v-model:value="single.graduationYear">
                                                    </app-datepicker>
                                                </div>
                                                <div class="col-lg-3 mb-5 fw-bolder">
                                                    Nama Instansi Sekolah(Opsional)
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
                v$: useVuelidate(),
                pageStatus: 'standby',
                idPenjangkauan: this.$route.params.idPenjangkauan,
                listGender: [{
                        id: '1',
                        text: 'Laki - Laki'
                    },
                    {
                        id: '2',
                        text: 'Perempuan'
                    }
                ],
                listNationality: [{
                        id: '1',
                        text: 'WNI'
                    },
                    {
                        id: '2',
                        text: 'WNA'
                    }
                ],
                listRelationshipWithClient: [],
                listPlaceOfBirth: [],
                listDistrictFamilyCardAddress: [],
                listSubDistrictFamilyCardAddress: [],
                listDistrictResidenceAddress: [],
                listSubDistrictResidenceAddress: [],
                listWork: [],
                listMaritialStatus: [],
                listReligion: [],
                listEducation: [],
                listMaritialStatus: [],
                listSchoolMajors: [],
                single: {
                    name: '',
                    gender: '',
                    nationality: '',
                    relationshipWithClient: {},

                    placeOfBirth: {},
                    dateOfBirth: '',
                    age: 0,
                    phone: '',
                    nik: '',
                    noKK: '',

                    isSameAddress: false,

                    addressResidence: '',
                    districtFamilyCardAddress: {},
                    subDistrictFamilyCardAddress: {},

                    addressFamilyCard: '',
                    districtResidenceAddress: {},
                    subDistrictResidenceAddress: {},

                    religion: {},
                    work: {},
                    maritialStatus: {},

                    lastEducation: {},
                    schoolMajors: {},
                    classEducation: {},
                    graduationYear: '',
                    schoolName: ''
                }
            }

        },
        validations() {
            return {
                single: {
                    name: {
                        required
                    },
                    gender: {
                        required
                    },
                    nationality: {
                        required
                    },
                    relationshipWithClient: {
                        required
                    },
                    phone: {
                        required
                    },
                    maritialStatus: {
                        required
                    }
                }
            }
        },
        mounted() {
            reinitializeAllPlugin();

            this.pageStatus = 'page-load';

            this.$store.dispatch('complaint/getDetailComplaintOutreachPerpetrator', this.$route.params
                .idPenjangkauan).then((res) => {
                if (res.status == 200 || res.status == 201) {

                    let context = res.data.data;

                    if (context) {
                        this.single.name = context.name;
                        this.single.gender = context.gender;
                        this.single.nationality = context.citizenship;

                        if (context.id_hubungan && context.nama_hubungan) {
                            this.single.relationshipWithClient = {
                                id: context.id_hubungan,
                                text: context.nama_hubungan
                            };
                        }


                        if (context.id_kabupaten_lahir && context.nama_kabupaten_lahir) {
                            this.single.placeOfBirth = {
                                id: context.id_kabupaten_lahir,
                                text: context.nama_kabupaten_lahir
                            };
                        }

                        this.single.dateOfBirth = context.birth_date;

                        this.calculateAge(context.birth_date);

                        this.single.phone = context.phone_number;
                        this.single.nik = context.nik_number;
                        this.single.noKK = context.kk_number;

                        let addressKK = '';
                        let kecamatanKK = '';
                        let kelurahanKK = '';

                        let addressDomisili = '';
                        let kecamatanDomisili = '';
                        let kelurahanDomisili = '';


                        this.single.addressFamilyCard = context.kk_address;
                        addressKK = context.kk_address;

                        if (context.id_kecamatan_kk && context.nama_kecamatan_kk) {
                            kecamatanKK = context.id_kecamatan_kk;
                            this.single.districtFamilyCardAddress = {
                                id: context.id_kecamatan_kk,
                                text: context.nama_kecamatan_kk
                            };
                        }

                        if (context.id_kelurahan_kk && context.nama_kelurahan_kk) {
                            kelurahanKK = context.id_kelurahan_kk;
                            this.single.subDistrictFamilyCardAddress = {
                                id: context.id_kelurahan_kk,
                                text: context.nama_kelurahan_kk
                            };
                        }


                        this.single.addressResidence = context.residence_address;
                        addressDomisili = context.residence_address;
                        if (context.id_kecamatan_tinggal && context.nama_kecamatan_tinggal) {
                            kecamatanDomisili = context.id_kecamatan_tinggal;
                            this.single.districtResidenceAddress = {
                                id: context.id_kecamatan_tinggal,
                                text: context.nama_kecamatan_tinggal,
                            };
                        }

                        if (context.id_kelurahan_tinggal && context.nama_kelurahan_tinggal) {
                            kelurahanDomisili = context.id_kelurahan_tinggal;
                            this.single.subDistrictResidenceAddress = {
                                id: context.id_kelurahan_tinggal,
                                text: context.nama_kelurahan_tinggal,
                            };
                        }

                        if (context.id_agama && context.nama_agama) {
                            this.single.religion = {
                                id: context.id_agama,
                                text: context.nama_agama
                            };
                        }

                        if (context.id_pekerjaan && context.nama_pekerjaan) {
                            this.single.work = {
                                id: context.id_pekerjaan,
                                text: context.nama_pekerjaan
                            };
                        }

                        if (context.id_status_pernikahan && context.nama_status_pernikahan) {
                            this.single.maritialStatus = {
                                id: context.id_status_pernikahan,
                                text: context.nama_status_pernikahan
                            };
                        }

                        if (context.id_pendidikan_terakhir && context.nama_pendidikan_terakhir) {
                            this.single.lastEducation = {
                                id: context.id_pendidikan_terakhir,
                                text: context.nama_pendidikan_terakhir
                            };
                        }

                        if (context.id_jurusan && context.nama_jurusan) {
                            this.single.schoolMajors = {
                                id: context.id_jurusan,
                                text: context.nama_jurusan
                            };
                        }

                        if (context.highest_class) {
                            this.single.classEducation = {
                                id: context.highest_class,
                                text: context.highest_class
                            };
                        }

                        this.single.graduationYear = context.graduation_year ? context.graduation_year
                            .toString() :
                            '';
                        this.single.schoolName = context.school_name;

                        
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
            }
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
            getRelationshipWithClient(keyword, limit) {
                this.getSelectList(`m-hubungan/lists?limit=${limit}&search=${keyword}`, 'listRelationshipWithClient',
                    'rel-client-load')
            },
            getMaritalStatus(keyword, limit) {
                this.getSelectList(`m-status-pernikahan/lists?limit=${limit}&search=${keyword}`, 'listMaritialStatus',
                    'marital-status-load')
            },
            getReligion(keyword, limit) {
                this.getSelectList(`m-agama/lists?limit=${limit}&search=${keyword}`, 'listReligion', 'religion-load')
            },
            getCity(keyword, limit, listKey) {
                this.getSelectList(`m-kabupaten/lists?limit=${limit}&search=${keyword}`, 'listPlaceOfBirth',
                    'city-load')
            },
            getDistrict(keyword, limit, listKey, pageStatus = 'district-load') {
                this.getSelectList(`m-kecamatan/lists?limit=${limit}&search=${keyword}`, listKey, pageStatus)
            },

            getSubDistrict(keyword, limit, listKey, pageStatus = 'subdistrict-load', districtId = '') {
                this.getSelectList(`m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${districtId}`,
                    listKey, pageStatus)
            },
            getProfession(keyword, limit) {
                this.getSelectList(`m-pekerjaan/lists?limit=${limit}&search=${keyword}`, 'listWork', 'profession-load')
            },
            calculateAge(val) {
                let result = this.$moment().diff(val, 'years');

                this.single.age = result ? result : '0';
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
                if(this.$store.state.profile.role_id != this.ROLE_KONSELOR_ID){
                    this.save(1);
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
                        this.save(1);
                    }
                });
            },
            save(is_publish) {
                this.v$.$reset();
                if (is_publish) {
                    this.v$.$touch();

                    if (this.v$.$error) {
                        this.$toast.error("Silahkan lengkapi form dibawah!");
                        return false;
                    }
                }


                let formData = {
                    is_publish: is_publish,
                    nama: this.single.name,
                    jenis_kelamin: this.single.gender,
                    kewarganegaraan: this.single.nationality,
                    id_hubungan: this.single.relationshipWithClient.id ? this.single.relationshipWithClient.id : '',
                    id_kabupaten_lahir: this.single.placeOfBirth.id,
                    tanggal_lahir: this.single.dateOfBirth,
                    nomor_telepon: this.single.phone ? String(this.single.phone) : '',
                    nomor_nik: this.single.nik,
                    nomor_kk: this.single.noKK,
                    alamat_domisili: this.single.addressResidence,
                    id_kelurahan_domisili: this.single.subDistrictResidenceAddress.id ? this.single
                        .subDistrictResidenceAddress.id : '',
                    alamat_kk: this.single.addressFamilyCard,
                    id_kelurahan_kk: this.single.subDistrictFamilyCardAddress.id ? this.single
                        .subDistrictFamilyCardAddress.id : '',
                    id_agama: this.single.religion.id ? this.single.religion.id : '',
                    id_pekerjaan: this.single.work.id ? this.single.work.id : '',
                    id_status_pernikahan: this.single.maritialStatus.id ? this.single.maritialStatus.id : '',
                    id_pendidikan: this.single.lastEducation.id ? this.single.lastEducation.id : '',
                    id_jurusan: this.single.schoolMajors.id ? this.single.schoolMajors.id : '',
                    kelas: this.single.classEducation.id ? this.single.classEducation.id : '',
                    tahun_lulus: this.single.graduationYear,
                    nama_sekolah: this.single.schoolName
                }

                formData = this.cleanObject(formData);

                this.$ewpLoadingShow();
                Api().post('penjangkauan/' + this.$route.params.idPenjangkauan + '/pelaku', formData)
                    .then(response => {
                        this.$swal({
                            title: "Berhasil!",                            
                            text: this.$store.state.profile.role_id == this.ROLE_KONSELOR_ID ? is_publish ? 'Data berhasil dipublish' :
                                'Data berhasil disimpan sebagai draft. Anda masih bisa mengubahnya dilain waktu' : 'Data berhasil disimpan',
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
