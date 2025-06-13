<template>
    <div>
        <div class="head my-5">
            <div class="row pt-5 mt-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap">
                        <div class="" style="border-right:1px solid grey;padding-right:10px;">
                            <h4>Detail Pengaduan</h4>
                        </div>
                        <div>
                            &ensp;
                            <span class="text-muted">
                                <a href="javascript:void(0)" @click="$router.push({name:'pengaduan'})" class="text-muted" style="text-decoration:none;">
                                    Pengaduan
                                </a>
                                - Detail Data
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center mt-5">
            <div class="col-lg-8">
                <h1>Detail Pengaduan</h1>
            </div>
            <div class="col-lg-4 d-flex" style="justify-content:flex-end;">
                <button type="button" class="btn" style="background-color:#fff8dd;" @click="$router.push({name:'pengaduan'})">
                    <span class="text-warning d-flex">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
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
            </div>
        </div>
        <div class="d-flex justify-content-center flex-wrap mb-10 mt-5"
            v-if="$store.state.complaint.detailComplaint.id && $store.state.complaint.detailComplaint.status.id != 1">
            <a href="javascript:void(0)" style="font-size:15px;border-radius:5px" class="text-gray-800 py-2 px-4"
                @click="flagTab = 'pengaduan'"
                :class="flagTab == 'pengaduan' ? 'bg-primary-custom text-white' : ''">Pengaduan</a>
            <a v-if="$store.state.complaint.detailComplaint.id && $store.state.complaint.detailComplaint.status.id != 1"
                href="javascript:void(0)" style="font-size:15px;border-radius:5px" class="text-gray-800 py-2 px-4"
                @click="flagTab = 'penanganan-awal'; getInitialTreatment()"
                :class="flagTab == 'penanganan-awal' ? 'bg-primary-custom text-white' : ''">Penanganan Awal</a>
            <a v-if="$store.state.complaint.detailComplaint.id && parseInt($store.state.complaint.detailComplaint.status.id) > 3"
                href="javascript:void(0)" style="font-size:15px;border-radius:5px" class="text-gray-800 py-2 px-4"
                @click="flagTab = 'penjangkauan';getOutreachComplaint()"
                :class="flagTab == 'penjangkauan' ? 'bg-primary-custom text-white' : ''">Penjangkauan</a>
            <a v-if="$store.state.complaint.detailComplaint.id && parseInt($store.state.complaint.detailComplaint.status.id) >= 7"
                href="javascript:void(0)" style="font-size:15px;border-radius:5px" class="text-gray-800 py-2 px-4"
                @click="flagTab = 'kebutuhan-intervensi';getDetailComplaintOutreachClientNeedsReferralPlan()"
                :class="flagTab == 'kebutuhan-intervensi' ? 'bg-primary-custom text-white' : ''">Kebutuhan
                Intervensi</a>
        </div>
        <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view" v-if="flagTab == 'pengaduan'">
            <div v-if="$store.state.complaint.detailComplaint.loading"
                class="w-100 d-flex justify-content-center mt-10 mb-10">
                <app-loader></app-loader>
            </div>
            <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                <div class="card-header border-0 pt-5 align-items-center">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Detail Data
                            Pengaduan<span
                                class="c-primary-custom ps-3">{{$noNullable($store.state.complaint.detailComplaint.reportIdentity.fullName)}}</span>&ensp;<span
                                class="badge" :class="$store.state.complaint.detailComplaint.status.label_status"
                                v-if="$store.state.complaint.detailComplaint.id">{{$noNullable($store.state.complaint.detailComplaint.status.status)}}</span></span>
                    </h3>
                </div>
                <div class="card-body pt-5">
                    <h4 class="c-primary-custom fw-bolder pb-2">Waktu Pengaduan</h4>
                    <div class="row">
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Nomor Registrasi
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.registerNumber)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Sumber Pengaduan
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.sourceOfComplaint)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Tanggal & Jam Pengaduan
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$moment($store.state.complaint.detailComplaint.datetime).locale('id').format('DD MMMM YYYY  HH:mm:ss')}}
                        </div>
                    </div>
                    <hr style="background-color:#8f8d8d !important" />
                    <h4 class="pt-2 c-primary-custom fw-bolder pb-2">Identitas Pelapor</h4>
                    <div class="row">
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Nama Lengkap
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.reportIdentity.fullName)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            NIK
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.reportIdentity.nik)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Warga Surabaya
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$store.state.complaint.detailComplaint.reportIdentity.surabayaResidents  == 1 ? 'Ya' : 'Tidak'}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Kabupaten/Kota
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.reportIdentity.surabayaResidents == 1 ? '-' : $store.state.complaint.detailComplaint.reportIdentity.districtOutsideSurabaya)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Alamat Domisili
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.reportIdentity.addressDomicile)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            No. Telepon/Whatsapp
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.reportIdentity.phoneNumber)}}
                        </div>
                    </div>
                    <hr style="background-color:#8f8d8d !important" />
                    <h4 class="pt-2 c-primary-custom fw-bolder pb-2">Identitas Klien</h4>
                    <div class="row">
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Nama Lengkap (Inisial)
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.clientIdentity.fullName)}}
                            ({{$noNullable($store.state.complaint.detailComplaint.clientIdentity.initialName)}})
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            NIK/Nomor Identitas
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.clientIdentity.identityNumber)}}&ensp;<span
                                class="badge badge-primary ms">{{$noNullable($store.state.complaint.detailComplaint.clientIdentity.typeIdentityNumber)}}</span>
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Warga Surabaya
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$store.state.complaint.detailComplaint.clientIdentity.surabayaResidents == 1 ? 'Ya' : 'Tidak'}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Kabupaten/Kota
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.clientIdentity.surabayaResidents == 1 ? '-' : $store.state.complaint.detailComplaint.clientIdentity.districtOutsideSurabaya)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Alamat Domisili
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.clientIdentity.addressDomicile)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Kecamatan
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.clientIdentity.subDistrictDomicile)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Kelurahan
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.clientIdentity.villageDomicile)}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            No. Telepon/Whatsapp
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.clientIdentity.phoneNumber)}}
                        </div>
                    </div>
                    <hr style="background-color:#8f8d8d !important" />
                    <h4 class="pt-2 c-primary-custom fw-bolder pb-2">Permasalahan</h4>
                    <div class="row">
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Uraian Singkat Permasalahan
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5" v-html="$noNullable($store.state.complaint.detailComplaint.problem.note)"></div>
                    </div>
                    <hr style="background-color:#8f8d8d !important" />
                    <h4 class="pt-2 c-primary-custom fw-bolder pb-2">Dokumentasi Pengaduan</h4>
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-5"
                            v-for="(context, index) in $store.state.complaint.detailComplaint.documentation.file">
                            <a :href="context.path" data-fancybox="gallery"><img :src="context.path" class="w-100"
                                    style="height:100px;max-width:100%;" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view"
            v-if="flagTab == 'penanganan-awal'">
            <div v-if="$store.state.complaint.detailComplaint.initialTreatment.loading"
                class="w-100 d-flex justify-content-center mt-10 mb-10">
                <app-loader></app-loader>
            </div>
            <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                <div class="card-header border-0 pt-5 align-items-center">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Detail
                            Penanganan Awal<span
                                class="c-primary-custom ps-3">{{$noNullable($store.state.complaint.detailComplaint.reportIdentity.fullName)}}</span>&ensp;<span
                                class="badge" :class="$store.state.complaint.detailComplaint.status.label_status"
                                v-if="$store.state.complaint.detailComplaint.id">{{$noNullable($store.state.complaint.detailComplaint.status.status)}}</span></span>
                    </h3>
                </div>
                <div class="card-body pt-5">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-light btn-sm mb-3" @click="editPenangananAwal()" type="button">

                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M19.6166 7.65575L17.6375 9.63388L12.3612 4.35756L14.3394 2.37843C14.6893 2.02852 15.164 1.83203 15.6589 1.83203C16.1538 1.83203 16.6284 2.02852 16.9784 2.37843L19.6166 5.01664C19.9665 5.36663 20.1631 5.84123 20.1631 6.33614C20.1631 6.83105 19.9665 7.30576 19.6166 7.65575V7.65575ZM3.37968 20.1031L9.06301 18.2084L3.78668 12.9321L1.89192 18.6154C1.8224 18.823 1.81221 19.0459 1.8625 19.259C1.91278 19.4721 2.02155 19.6669 2.17655 19.8215C2.33155 19.9761 2.52664 20.0844 2.73984 20.1341C2.95305 20.1839 3.17591 20.1732 3.38334 20.1031H3.37968Z"
                                    fill="#50CD89" />
                                <path
                                    d="M5.10928 19.5255L3.38411 20.1011C3.17686 20.17 2.95451 20.18 2.74193 20.1298C2.52935 20.0796 2.33494 19.9712 2.18044 19.8168C2.02594 19.6624 1.91746 19.4681 1.86713 19.2556C1.81679 19.043 1.82659 18.8207 1.89544 18.6134L2.47111 16.8872L5.10928 19.5255ZM3.79019 12.93L9.06653 18.2063L17.641 9.63178L12.3647 4.35547L3.79019 12.93Z"
                                    fill="#50CD89" />
                            </svg>

                        </button>
                    </div>
                    <h4 class="c-primary-custom fw-bolder pb-2">Waktu Penanganan Awal</h4>
                    <div class="row align-items-center">
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Tanggal & Jam Penanganan
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$moment($store.state.complaint.detailComplaint.initialTreatment.datetime).locale('id').format('DD MMMM YYYY  HH:mm:ss')}}
                        </div>
                        <div class="col-lg-4 text-gray-600 mb-5">
                            Hasil Penanganan Awal
                        </div>
                        <div class="col-lg-8 fw-bolder mb-5">
                            {{$noNullable($store.state.complaint.detailComplaint.initialTreatment.note)}}
                        </div>
                    </div>
                    <h4 class="c-primary-custom fw-bolder pb-2">Dokumen Pendukung</h4>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-5"
                            v-for="(context, index) in $store.state.complaint.detailComplaint.initialTreatment.files">
                            <a v-if="context.isImage" :href="context.path" data-fancybox="gallery">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'" style="width:35px;" />
                                    </div>
                                    <div>
                                        <div class="fw-bolder text-primary" style="word-break: break-word;">
                                            {{$noNullable(context.name)}}
                                        </div>
                                        <div class="text-gray-500">
                                            {{$formatBytes(context.size)}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a :href="context.path" target="_blank" v-else>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'" style="width:35px;" />
                                    </div>
                                    <div>
                                        <div class="fw-bolder text-primary" style="word-break: break-word;">
                                            {{$noNullable(context.name)}}
                                        </div>
                                        <div class="text-gray-500">
                                            {{$formatBytes(context.size)}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-if="flagTab == 'penjangkauan'">
            <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                <div v-if="$store.state.complaint.outreachComplaint.loading"
                    class="w-100 d-flex justify-content-center mt-10 mb-10">
                    <app-loader></app-loader>
                </div>
                <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                    <div class="card-header border-0 pt-5 align-items-center">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Detail
                                Penjangkauan<span
                                    class="c-primary-custom ps-3">{{$noNullable($store.state.complaint.detailComplaint.reportIdentity.fullName)}}</span>&ensp;<span
                                    class="badge" :class="$store.state.complaint.detailComplaint.status.label_status"
                                    v-if="$store.state.complaint.detailComplaint.id">{{$noNullable($store.state.complaint.detailComplaint.status.status)}}</span></span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <h4 class="c-primary-custom fw-bolder pb-2">Penjadwalan</h4>
                        <div class="row">
                            <div class="col-lg-4 text-gray-600 mb-5">
                                Hari, Tanggal, Jam
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                {{$moment($store.state.complaint.outreachComplaint.plan.datetime, 'DD-MM-YYYY HH:mm').locale('id').format('DD MMMM YYYY  HH:mm')}}
                            </div>
                            <div class="col-lg-4 text-gray-600 mb-5">
                                Tempat
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                {{$noNullable($store.state.complaint.outreachComplaint.plan.place)}}
                            </div>
                            <div class="col-lg-4 text-gray-600 mb-5">
                                Alamat
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                {{$noNullable($store.state.complaint.outreachComplaint.plan.address)}}
                            </div>
                        </div>
                        <h4 class="c-primary-custom fw-bolder pb-2">Tim Outreach Yang Bertugas</h4>
                        <div class="row align-items-center">
                            <template v-for="(context, index) in $store.state.complaint.outreachComplaint.konselorTeam">
                                <div class="col-lg-4 text-gray-600 mb-5">
                                    Konselor {{index + 1}}
                                </div>
                                <div class="col-lg-8 fw-bolder mb-5">
                                    <div class="d-flex align-items-center">
                                        <img class="me-3" :src="context.konselor ? context.konselor.foto : ''"
                                            style="width:50px;height:50px;border-radius:5px;">
                                        <div>{{$noNullable(context.konselor ? context.konselor.name : '-')}}</div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div v-if="$store.state.complaint.detailComplaint.status.id == 6" class="mt-5 pt-8"
                            style="border-top:1px #f2f2 solid">
                            <h4 class="text-danger fw-bolder pb-2">Hasil Penjangkauan Di Revisi</h4>
                            <div class="row">
                                <div class="col-lg-4 text-gray-600 mb-5">
                                    Keterangan Pengembalian
                                </div>
                                <div class="col-lg-8 mb-5 fw-bolder">
                                    {{$noNullable($store.state.complaint.outreachComplaint.lastRollbackNote)}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view"
                v-if="$store.state.complaint.outreachComplaint.id && parseInt($store.state.complaint.detailComplaint.status.id) >= 5 && !$store.state.complaint.outreachComplaint.result.draftStatus">
                <div v-if="$store.state.complaint.outreachComplaint.loading"
                    class="w-100 d-flex justify-content-center mt-10 mb-10">
                    <app-loader></app-loader>
                </div>
                <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                    <div class="card-header border-0 pt-5 align-items-center justify-content-between flex-wrap">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Detail
                                Hasil Penjangkauan</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div v-if="!$store.state.complaint.outreachComplaint.result.pendampingan"
                            class="alert alert-dismissible bg-light-warning d-flex flex-column flex-sm-row p-5 align-items-center mb-10">
                            <!--begin::Icon-->
                            <span class="svg-icon svg-icon-2hx svg-icon-warning me-4 mb-5 mb-sm-0">

                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M29.3346 16.0003C29.3346 8.63653 23.3651 2.66699 16.0013 2.66699C8.63751 2.66699 2.66797 8.63653 2.66797 16.0003C2.66797 23.3641 8.63751 29.3337 16.0013 29.3337C23.3651 29.3337 29.3346 23.3641 29.3346 16.0003Z"
                                        fill="#FFC700" />
                                    <path
                                        d="M14.668 14.667V21.3337C14.668 22.07 15.2649 22.667 16.0013 22.667C16.7377 22.667 17.3346 22.07 17.3346 21.3337V14.667C17.3346 13.9306 16.7377 13.3337 16.0013 13.3337C15.2649 13.3337 14.668 13.9306 14.668 14.667Z"
                                        fill="#FFC700" />
                                    <path
                                        d="M16.0013 9.33333C15.2649 9.33333 14.668 9.93029 14.668 10.6667C14.668 11.403 15.2649 12 16.0013 12C16.7377 12 17.3346 11.403 17.3346 10.6667C17.3346 9.93029 16.7377 9.33333 16.0013 9.33333Z"
                                        fill="#FFC700" />
                                </svg>

                            </span>
                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                <!--begin::Title-->
                                <h4 class="fw-bold">Klien Tidak Bersedia Didampingi</h4>
                            </div>
                        </div>
                        <div class="accordion" id="kt_accordion_1">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                    <button class="accordion-button fs-4 fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1"
                                        aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                                        Detail Kasus Klien
                                    </button>
                                </h2>

                                <div id="kt_accordion_1_body_1" class="accordion-collapse collapse show"
                                    aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Tipe Kasus
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                <span
                                                    v-if="$store.state.complaint.outreachComplaint.result.caseType == 1">Kasus
                                                    Lama</span>
                                                <span
                                                    v-else-if="$store.state.complaint.outreachComplaint.result.caseType ==2">Kasus
                                                    Baru</span>
                                                <span v-else>-</span>
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Tipe Pemasalahan
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.problemType)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Kategori Kasus
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.caseCategory)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Jenis Kasus
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.caseSpecies)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Lokasi Kasus
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.caseLocation)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Uraian Singkat Permasalahan
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.note)}}
                                            </div>
                                            <div class="col-lg-2 text-gray-600 mb-5">
                                                Tanggal & Waktu Kejadian
                                            </div>
                                            <div class="col-lg-10 mb-5 fw-bolder">
                                                {{$noNullable($store.state.complaint.outreachComplaint.result.datetime)}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion mt-5" id="kt_accordion_2">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_2_header_1">
                                    <button class="accordion-button fs-4 fw-semibold" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_body_1"
                                        aria-expanded="true" aria-controls="kt_accordion_2_body_1">
                                        Dokumen Penyelesaian Kasus
                                    </button>
                                </h2>

                                <div id="kt_accordion_2_body_1" class="accordion-collapse collapse show"
                                    aria-labelledby="kt_accordion_2_header_1" data-bs-parent="#kt_accordion_2">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <template
                                                v-if="$store.state.complaint.outreachComplaint.result.pendampingan">
                                                <div class="col-lg-2 text-gray-600 mb-5">
                                                    Berita Acara Pendampingan Klien
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-6 mb-5"
                                                            v-for="(context, index) in $store.state.complaint.outreachComplaint.result.files.berita_acara_pendampingan">
                                                            <a v-if="context.isImage" :href="context.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(context.name)}}</div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(context.size)}}</div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="context.path" target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(context.name)}}</div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(context.size)}}</div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 text-gray-600 mb-5">
                                                    Surat Pernyataan Klien Bersedia (Informed Consent)
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row"
                                                        v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien">
                                                        <div class="col-lg-12 col-md-12 mb-5">
                                                            <a v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.isImage"
                                                                :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.path"
                                                                target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_klien.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 text-gray-600 mb-5">
                                                    Surat Pernyataan Telah Selesai Pendampingan
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row"
                                                        v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan">
                                                        <div class="col-lg-12 col-md-12 mb-5">
                                                            <a v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.isImage"
                                                                :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.path"
                                                                target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="col-lg-2 text-gray-600 mb-5">
                                                    Surat Pernyataan Klien Tidak Bersedia Didampingi
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row"
                                                        v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi">
                                                        <div class="col-lg-12 col-md-12 mb-5">
                                                            <a v-if="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.isImage"
                                                                :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="$store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.path"
                                                                target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes($store.state.complaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="c-primary-custom fw-bolder pt-5" style="font-size:18px">Hasil Penjangkauan</div>
                        <div class="text-gray-600">Berikut ini merupakan hasil penjangkauan ke klien</div>
                        <div class="timeline-custom mt-10">
                            <div class="container-timeline-custom right-timeline-custom"
                                v-for="context in single.listDataOutreachComplete">
                                <template v-if="showPreparatorStep(context.id)">
                                    <div class="container-timeline-custom-circle">

                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.7"
                                                d="M11.8 5.2L17.7 8.6V15.4L11.8 18.8L5.90001 15.4V8.6L11.8 5.2ZM11.8 2C11.5 2 11.2 2.1 11 2.2L3.8 6.4C3.3 6.7 3 7.3 3 7.9V16.2C3 16.8 3.3 17.4 3.8 17.7L11 21.9C11.3 22 11.5 22.1 11.8 22.1C12.1 22.1 12.4 22 12.6 21.9L19.8 17.7C20.3 17.4 20.6 16.8 20.6 16.2V7.9C20.6 7.3 20.3 6.7 19.8 6.4L12.6 2.2C12.4 2.1 12.1 2 11.8 2Z"
                                                fill="#50CD89" />
                                            <path
                                                d="M11.7984 8.7002L8.89844 10.3002V13.7002L11.7984 15.3002L14.6984 13.7002V10.3002L11.7984 8.7002Z"
                                                fill="#50CD89" />
                                        </svg>
                                    </div>
                                    <div class="content-timeline-custom">
                                        <h2 class="fw-bolder">
                                            {{context.text}}&ensp;<span v-if="context.status == 'done'"
                                                class="badge badge-success">Selesai</span>
                                            <span v-if="context.status == 'waiting'" class="badge badge-danger">Belum
                                                Diinput</span>
                                            <span v-if="context.status == 'draft'"
                                                class="badge badge-secondary">Draft</span>
                                        </h2>
                                        <div v-if="context.status == 'done' || context.status == 'draft'"
                                            class="text-gray-600 mb-3">Diperbarui:
                                            {{$moment(context.datetime).locale('id').format('DD MMMM YYYY  HH:mm:ss')}}
                                            oleh
                                            <span class="text-black fw-bolder">{{$noNullable(context.konselor)}}</span>
                                        </div>
                                        <div v-if="context.status == 'waiting'" class="text-gray-600 mb-3">Data belum
                                            ditambahkan oleh <span class="text-black fw-bolder">Konselor</span></div>
                                        <div class="p-3" style="border: 1px dashed #E4E6EF;border-radius:12px;">
                                            <div class="row align-items-center">
                                                <div class="col-lg-6 my-1 col-md-6">
                                                    {{context.desc}}
                                                </div>
                                                <div class="col-lg-6 my-1 col-md-6 justify-content-end text-right">
                                                    <button v-if="context.status == 'done'"
                                                        @click="detailOutreachComplete(context.id)"
                                                        class="btn btn-success btn-sm" type="button">Lihat
                                                        Detail</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view"
            v-if="flagTab == 'kebutuhan-intervensi'">
            <div v-if="$store.state.complaint.outreachComplaint.result.clientNeedsReferralPlan.loading"
                class="w-100 d-flex justify-content-center mt-10 mb-10">
                <app-loader></app-loader>
            </div>
            <div class="card card-xl-stretch mb-5 mb-xl-8" v-else>
                <div class="card-header border-0 pt-5 align-items-center">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder text-dark mb-2" style="font-size:20px !important;">Kebutuhan
                            Intervensi<span
                                class="c-primary-custom ps-3">{{$noNullable($store.state.complaint.detailComplaint.reportIdentity.fullName)}}</span>&ensp;<span
                                class="badge" :class="$store.state.complaint.detailComplaint.status.label_status"
                                v-if="$store.state.complaint.detailComplaint.id">{{$noNullable($store.state.complaint.detailComplaint.status.status)}}</span></span>
                    </h3>
                </div>
                <div class="card-body pt-5">
                    <div class="d-flex flex-column justify-content-center align-items-center"
                        v-if="$store.state.complaint.outreachComplaint.result.clientNeedsReferralPlan.data.length == 0">
                        <img :src="`${$assetUrl()}extends/img/empty.png`" />
                        <div class="text-gray-600 pt-5">Tidak ada kebutuhan intervensi yang ditambahkan.</div>
                    </div>

                    <div class="mb-8"
                        v-for="(context, index) in $store.state.complaint.outreachComplaint.result.clientNeedsReferralPlan.data">
                        <div class="row align-items-center pb-5 mb-5">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="c-primary-custom mb-8">Pelayanan {{index + 1}}</h4>
                                    <button type="button" class="btn btn-sm btn-success mb-3"
                                        @click="detailHistoryPenanganan(context.id)">Hasil
                                        Intervensi</button>
                                </div>
                            </div>
                            <div class="col-lg-4 text-gray-600 mb-5">
                                Status Intervensi
                            </div>
                            <div class="col-lg-8 fw-bolder mb-5">
                                <span class="badge badge-light-info" v-if="context.realisasi_draft_status">Proses
                                    Intervensi</span>
                                <span class="badge badge-light-success" v-else>Intervensi Selesai</span>

                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Kebutuhan
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(context.kebutuhan?.name)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                OPD
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(context.opd?.name)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600">
                                Pelayanan Yang Diberikan
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder">
                                {{$noNullable(context.intervensi?.name)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600 d-none">
                                Deskripsi Pelayanan Yang Diberikan
                            </div>
                            <div class="col-lg-8 mb-5 fw-bolder d-none">
                                {{$noNullable(context.description)}}
                            </div>
                            <div class="col-lg-4 mb-5 text-gray-600 d-none">
                                Dokumen Pendukung
                            </div>
                            <div class="col-lg-8 mb-5 d-none">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 mb-5" v-for="file in context.file">
                                        <a v-if="file.isImage" :href="file.path" data-fancybox="gallery">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                        style="width:35px;" />
                                                </div>
                                                <div>
                                                    <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                        {{$noNullable(file.name)}}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{$formatBytes(file.size)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a :href="file.path" target="_blank" v-else>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                        style="width:35px;" />
                                                </div>
                                                <div>
                                                    <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                        {{$noNullable(file.name)}}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{$formatBytes(file.size)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div class="modal fade" tabindex="-1" id="modal-update-penanganan-awal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Perbarui Penanganan Awal</h5>
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
                        <div class="row align-items-center">
                            <div class="col-lg-4 fw-bolder mb-5">
                                Tanggal Penangan Awal
                            </div>
                            <div class="col-lg-8">
                                <div class="row align-items-center">
                                    <div class="col-lg-5 mb-5">
                                        <app-datepicker type="date" placeholder="Pilih tanggal" :format="'DD-MM-YYYY'"
                                            :value-type="'YYYY-MM-DD'"
                                            v-model:value="single.dataUpdatePenangananAwal.date">
                                        </app-datepicker>
                                    </div>
                                    <div class="col-lg-2 mb-5 fw-bolder">
                                        Jam
                                    </div>
                                    <div class="col-lg-5 mb-5">
                                        <app-datepicker type="time" placeholder="Pilih jam" :format="'HH:mm:ss'"
                                            :value-type="'HH:mm:ss'"
                                            v-model:value="single.dataUpdatePenangananAwal.time">
                                        </app-datepicker>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 fw-bolder mb-5">
                                Hasil Penanganan Awal
                            </div>
                            <div class="col-lg-8 mb-5">
                                <textarea class="form-control" rows="4" placeholder="Deskripsikan hasil penanganan awal"
                                    v-model="single.dataUpdatePenangananAwal.note"></textarea>
                            </div>
                            <div class="col-lg-4 fw-bolder mb-5">
                                Dokumen Pendukung
                            </div>
                            <div class="col-lg-8 mb-5">
                                <div id="dropzone-container-1">
                                    <div class="dropzone dropzone-file-area dz-clickable"
                                        id="dropzone-update-penanganan-awal">
                                        <div class="dz-message needsclick">
                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                            <div class="ms-4">
                                                <h5 class="kt-dropzone__msg-title">Drop files here or
                                                    click
                                                    to upload</h5>
                                                <span class="kt-dropzone__msg-desc text-primary">
                                                    Upload up to 10 files with the format .jpg/.jpeg/.png/.pdf
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-lg-6 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                        v-for="(context, index) in single.dataUpdatePenangananAwal.existing">

                                        <a v-if="context.isImage" :href="context.path" data-fancybox="gallery">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                        style="width:35px;" />
                                                </div>
                                                <div>
                                                    <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                        {{$noNullable(context.name)}}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{$formatBytes(context.size)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a :href="context.path" target="_blank" v-else>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                        style="width:35px;" />
                                                </div>
                                                <div>
                                                    <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                        {{$noNullable(context.name)}}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{$formatBytes(context.size)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <div><i @click="single.dataUpdatePenangananAwal.existing.splice(index, 1)"
                                                class="fa fa-times text-danger"
                                                style="font-size:20px;cursor:pointer;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-sm bg-primary-custom text-white" type="button"
                            @click="updatePenangananAwal">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <app-pengaduan-data-keluarga-klien :data="$store.state.complaint.outreachComplaint.result.clientFamily">
        </app-pengaduan-data-keluarga-klien>
        <app-pengaduan-data-klien :data="$store.state.complaint.outreachComplaint.result.client.data">
        </app-pengaduan-data-klien>
        <app-pengaduan-data-pelaku :data="$store.state.complaint.outreachComplaint.result.perpetrator">
        </app-pengaduan-data-pelaku>
        <app-pengaduan-dokumen-pendukung :data="$store.state.complaint.outreachComplaint.result.supportingDocuments">
        </app-pengaduan-dokumen-pendukung>
        <app-pengaduan-harapan-klien-dan-keluarga :data="$store.state.complaint.outreachComplaint.result.hopeClient">
        </app-pengaduan-harapan-klien-dan-keluarga>
        <app-pengaduan-kondisi-klien :data="$store.state.complaint.outreachComplaint.result.clientCondition">
        </app-pengaduan-kondisi-klien>
        <app-pengaduan-kronologi-kejadian :data="$store.state.complaint.outreachComplaint.result.cronologyIncident">
        </app-pengaduan-kronologi-kejadian>
        <app-pengaduan-langkah-yang-diambil
            :data="$store.state.complaint.outreachComplaint.result.stepsThatHaveBeenTaken.data">
        </app-pengaduan-langkah-yang-diambil>
        <app-pengaduan-rencana-analis-kebutuhan-klien
            :data="$store.state.complaint.outreachComplaint.result.clientNeedsAnalysisPlan.data">
        </app-pengaduan-rencana-analis-kebutuhan-klien>
        <app-pengaduan-rencana-rujukan-kebutuhan-klien
            :data="$store.state.complaint.outreachComplaint.result.clientNeedsReferralPlan.data">
        </app-pengaduan-rencana-rujukan-kebutuhan-klien>
        <app-pengaduan-situasi-keluarga :data="$store.state.complaint.outreachComplaint.result.familySituation">
        </app-pengaduan-situasi-keluarga>

        <app-pengaduan-detail-hasil-intervensi-opd
            :data="$store.state.complaint.realizationPlanningInteventionOpd.data">
        </app-pengaduan-detail-hasil-intervensi-opd>
    </div>
</template>

<script>
    import Api from "@/services/api";

    import DataKeluargaKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/DataKeluargaKlien.vue";
    import DataKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/DataKlien.vue";
    import DataPelaku from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/DataPelaku.vue";
    import DokumenPendukung from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/DokumenPendukung.vue";
    import HarapanKlienDanKeluarga from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/HarapanKlienDanKeluarga.vue";
    import KondisiKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/KondisiKlien.vue";
    import KronologiKejadian from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/KronologiKejadian.vue";
    import LangkahYangTelahDilakukan from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/LangkahYangTelahDilakukan.vue";
    import RencanaAnalisKebutuhanKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/RencanaAnalisKebutuhanKlien.vue";
    import RencanaRujukanKebutuhanKlien from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/RencanaRujukanKebutuhanKlien.vue";
    import SituasiKeluarga from "@/views/dashboard/pengaduan/component/modal-detail-hasil-penjangkauan/SituasiKeluarga.vue";

    import DetailHasilIntervensiOpd from "@/views/dashboard/pengaduan/component/ModalHasilIntervensiOpd.vue";
    export default {
        components: {
            'app-pengaduan-data-keluarga-klien': DataKeluargaKlien,
            'app-pengaduan-data-klien': DataKlien,
            'app-pengaduan-data-pelaku': DataPelaku,
            'app-pengaduan-dokumen-pendukung': DokumenPendukung,
            'app-pengaduan-harapan-klien-dan-keluarga': HarapanKlienDanKeluarga,
            'app-pengaduan-kondisi-klien': KondisiKlien,
            'app-pengaduan-kronologi-kejadian': KronologiKejadian,
            'app-pengaduan-langkah-yang-diambil': LangkahYangTelahDilakukan,
            'app-pengaduan-rencana-analis-kebutuhan-klien': RencanaAnalisKebutuhanKlien,
            'app-pengaduan-rencana-rujukan-kebutuhan-klien': RencanaRujukanKebutuhanKlien,
            'app-pengaduan-situasi-keluarga': SituasiKeluarga,
            'app-pengaduan-detail-hasil-intervensi-opd': DetailHasilIntervensiOpd,
        },
        data() {
            return {
                id: '',
                flagTab: 'pengaduan',
                dropzoneUploadUpdatePenanganan: null,
                single: {
                    dataUpdatePenangananAwal: {
                        date: '',
                        time: '',
                        note: '',
                        existing: []
                    },
                    listDataOutreachComplete: [{
                            id: 'data-klien',
                            text: 'Data Klien',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi detail identitas klien hingga alamat.',
                        },
                        {
                            id: 'data-pelaku',
                            text: 'Data Pelaku',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi detail identitas pelaku hingga alamat.',
                        },
                        {
                            id: 'data-keluarga-klien',
                            text: 'Data Keluarga Klien',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi detail identitas keluarga klien terkait ayah, ibu dan saudara-saudara.',
                        },
                        {
                            id: 'situasi-keluarga',
                            text: 'Situasi Keluarga',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Deskripsikan kondisi situasi keluarga pada saat kejadian dan saat ini.',
                        },
                        {
                            id: 'kronologi-kejadian',
                            text: 'Kronologi Kejadian',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Deskripsikan kronologis kejadian secara lengkap.',
                        },
                        {
                            id: 'harapan-klien-dan-keluarga',
                            text: 'Harapan Klien dan Keluarga',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Deskripsikan harapan yang diinginkan oleh klien dan keluarga dari kejadian ini. ',
                        },
                        {
                            id: 'kondisi-klien',
                            text: 'Kondisi Klien',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi detail kondisi klien terkait kondisi fisik, psikologis dst.',
                        },
                        {
                            id: 'rencana-analis-kebutuhan-klien',
                            text: 'Rencana Analis Kebutuhan Klien Oleh DP3KAPPKB',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan detail rencana rujukan yang akan diberikan kepada klien.',
                        },
                        {
                            id: 'rencana-rujukan-kebutuhan-klien',
                            text: 'Rencana Rujukan Kebutuhan Klien',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan detail rencana rujukan yang akan diberikan kepada klien.',
                        },
                        {
                            id: 'langkah-yang-telah-dilakukan',
                            text: 'Langkah yang Telah Dilakukan',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Masukkan informasi pelayanan yang telah diberikan dari instansi terkait.'
                        },
                        {
                            id: 'dokumen-pendukung',
                            text: 'Dokumen Pendukung',
                            datetime: '',
                            konselor: '',
                            status: 'waiting',
                            desc: 'Unggah dokumen pendukung antara lain foto klien, KK, KTP, tempat tinggal dsb.',
                        }
                    ]
                }
            }
        },
        beforeRouteLeave(to, from, next) {
            this.dropzoneUploadUpdatePenanganan.destroy();
            next();
        },
        mounted() {

            this.id = this.$route.params.id;

            reinitializeAllPlugin();

            this.initDropzone();

            this.$store.dispatch('complaint/getDetailComplaint', this.$route.params.id).then((res) => {
                if (res.status == 200 || res.status == 201) {
                    if(this.$route.query.flag == 'penjangkauan'){
                        this.flagTab = 'penjangkauan';
                        this.getOutreachComplaint();
                    }
                    return true
                } else {
                    this.$axiosHandleError(res);
                }
            })        

        },
        methods: {
            initDropzone() {
                const that = this;
                this.dropzoneUploadUpdatePenanganan = new Dropzone("#dropzone-update-penanganan-awal", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 20,
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
            getDetailComplaintOutreachClientNeedsReferralPlan() {
                this.$store.dispatch('complaint/getDetailComplaintOutreachClientNeedsReferralPlan', this.$store.state
                    .complaint.detailComplaint
                    .outreachId).then((
                    res) => {
                    if (res.status == 200 || res.status == 201) {
                        return true
                    } else {
                        this.$axiosHandleError(res);
                    }
                })
            },
            getInitialTreatment() {
                this.$store.dispatch('complaint/getDetailComplaintInitialTreatment', this.$route.params.id).then((
                    res) => {
                    if (res.status == 200 || res.status == 201) {
                        return true
                    } else {
                        this.$axiosHandleError(res);
                    }
                })
            },
            getOutreachComplaint() {
                if(!this.$store.state.complaint.detailComplaint.outreachId){
                    return false;
                }
                this.$store.dispatch('complaint/getDetailComplaintOutreach', this.$store.state.complaint.detailComplaint
                    .outreachId).then((res) => {
                    if (res.status == 200 || res.status == 201) {

                        let context = res.data.data;

                        this.single.listDataOutreachComplete[0].status = this.getStatusOutreachResult(context
                            .klien_draft_status);
                        this.single.listDataOutreachComplete[0].datetime = context.klien_updated_at;
                        this.single.listDataOutreachComplete[0].konselor = context.klien_updated_by;

                        this.single.listDataOutreachComplete[1].status = this.getStatusOutreachResult(context
                            .pelaku_draft_status);
                        this.single.listDataOutreachComplete[1].datetime = context.pelaku_updated_at;
                        this.single.listDataOutreachComplete[1].konselor = context.pelaku_updated_by;

                        this.single.listDataOutreachComplete[2].status = this.getStatusOutreachResult(context
                            .keluarga_klien_draft_status);
                        this.single.listDataOutreachComplete[2].datetime = context.keluarga_klien_updated_at;
                        this.single.listDataOutreachComplete[2].konselor = context.keluarga_klien_updated_by;

                        this.single.listDataOutreachComplete[3].status = this.getStatusOutreachResult(context
                            .situasi_keluarga_draft_status);
                        this.single.listDataOutreachComplete[3].datetime = context.situasi_keluarga_updated_at;
                        this.single.listDataOutreachComplete[3].konselor = context.situasi_keluarga_updated_by;

                        this.single.listDataOutreachComplete[4].status = this.getStatusOutreachResult(context
                            .kronologi_kejadian_draft_status);
                        this.single.listDataOutreachComplete[4].datetime = context
                            .kronologi_kejadian_updated_at;
                        this.single.listDataOutreachComplete[4].konselor = context
                            .kronologi_kejadian_updated_by;

                        this.single.listDataOutreachComplete[5].status = this.getStatusOutreachResult(context
                            .harapan_klien_draft_status);
                        this.single.listDataOutreachComplete[5].datetime = context.harapan_klien_updated_at;
                        this.single.listDataOutreachComplete[5].konselor = context.harapan_klien_updated_by;

                        this.single.listDataOutreachComplete[6].status = this.getStatusOutreachResult(context
                            .kondisi_klien_draft_status);
                        this.single.listDataOutreachComplete[6].datetime = context.kondisi_klien_updated_at;
                        this.single.listDataOutreachComplete[6].konselor = context.kondisi_klien_updated_by;

                        this.single.listDataOutreachComplete[7].status = this.getStatusOutreachResult(context
                            .analisis_dp3kappkb_draft_status);
                        this.single.listDataOutreachComplete[7].datetime = context
                            .analisis_dp3kappkb_updated_at;
                        this.single.listDataOutreachComplete[7].konselor = context
                            .analisis_dp3kappkb_updated_by;

                        this.single.listDataOutreachComplete[8].status = this.getStatusOutreachResult(context
                            .rencana_intervensi_draft_status);
                        this.single.listDataOutreachComplete[8].datetime = context
                            .rencana_intervensi_updated_at;
                        this.single.listDataOutreachComplete[8].konselor = context
                            .rencana_intervensi_updated_by;

                        this.single.listDataOutreachComplete[9].status = this.getStatusOutreachResult(context
                            .langkah_dilakukan_draft_status);
                        this.single.listDataOutreachComplete[9].datetime = context.langkah_dilakukan_updated_at;
                        this.single.listDataOutreachComplete[9].konselor = context.langkah_dilakukan_updated_by;

                        this.single.listDataOutreachComplete[10].status = this.getStatusOutreachResult(context
                            .dokumen_pendukung_draft_status);
                        this.single.listDataOutreachComplete[10].datetime = context
                            .dokumen_pendukung_updated_at;
                        this.single.listDataOutreachComplete[10].konselor = context
                            .dokumen_pendukung_updated_by;

                        return true;
                    } else {
                        this.$axiosHandleError(res);
                    }
                })
            },
            detailOutreachComplete(id) {
                let urlFunction = '';
                if (id == 'situasi-keluarga') {
                    urlFunction = 'complaint/getDetailComplaintOutreachFamilySituation';
                } else if (id == 'kronologi-kejadian') {
                    urlFunction = 'complaint/getDetailComplaintOutreachCronologyIncident';
                } else if (id == 'harapan-klien-dan-keluarga') {
                    urlFunction = 'complaint/getDetailComplaintOutreachHopeClient';
                } else if (id == 'kondisi-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClientCondition';
                } else if (id == 'dokumen-pendukung') {
                    urlFunction = 'complaint/getDetailComplaintOutreachSupportingDocuments';
                } else if (id == 'data-pelaku') {
                    urlFunction = 'complaint/getDetailComplaintOutreachPerpetrator';
                } else if (id == 'data-keluarga-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClientFamily';
                } else if (id == 'data-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClient';
                } else if (id == 'rencana-analis-kebutuhan-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClientNeedsAnalysisPlan';
                } else if (id == 'rencana-rujukan-kebutuhan-klien') {
                    urlFunction = 'complaint/getDetailComplaintOutreachClientNeedsReferralPlan';
                } else if (id == 'langkah-yang-telah-dilakukan') {
                    urlFunction = 'complaint/getDetailComplaintOutreachStepsThatHaveBeenTaken';
                } else {
                    $("#modal-detail-" + id).modal('show');
                    return false;
                }

                this.$ewpLoadingShow();
                this.$store.dispatch(urlFunction, this.$store.state.complaint.detailComplaint.outreachId).then((
                    res) => {
                    this.$ewpLoadingHide();
                    if (res.status == 200 || res.status == 201) {
                        $("#modal-detail-" + id).modal('show');
                    } else {
                        this.$axiosHandleError(res);
                    }
                });

            },
            getStatusOutreachResult(status) {
                if (status === null) {
                    return 'waiting';
                } else {
                    if (status) {
                        return 'draft'
                    } else {
                        return 'done';
                    }
                }
            },
            detailHistoryPenanganan(id) {
                this.$ewpLoadingShow();
                this.$store.dispatch('complaint/getRealizationPlanningInterventionOpd', id).then((res) => {
                    this.$ewpLoadingHide();
                    if (res.status == 200 || res.status == 201) {
                        $("#modal-detail-hasil-intervensi-opd").modal('show');
                        return true;
                    } else {
                        this.$axiosHandleError(res);
                    }
                });

            },
            showPreparatorStep(id) {
                if (id == 'data-pelaku') {
                    if (this.$store.state.complaint.outreachComplaint.result.draftStatus) {
                        return true;
                    } else {
                        return this.$store.state.complaint.outreachComplaint.result.needPreparator;
                    }
                } else {
                    return true;
                }
            },
            editPenangananAwal() {

                this.single.dataUpdatePenangananAwal.date = '';
                this.single.dataUpdatePenangananAwal.time = '';
                this.single.dataUpdatePenangananAwal.note = '';


                this.single.dataUpdatePenangananAwal.existing = [];

                this.dropzoneUploadUpdatePenanganan.removeAllFiles(true);
                this.dropzoneUploadUpdatePenanganan.files = [];

                this.$ewpLoadingShow();
                Api().get(`pengaduan/` + this.$route.params.id + '/penanganan-awal')
                    .then(response => {
                        let context = response.data.data;

                        this.single.dataUpdatePenangananAwal.date = context.waktu ? context.waktu.split(' ')[0] :
                            '';
                        this.single.dataUpdatePenangananAwal.time = context.waktu ? context.waktu.split(' ')[1] :
                            '';
                        this.single.dataUpdatePenangananAwal.note = context.keterangan;

                        this.single.dataUpdatePenangananAwal.existing = context.files;
                        $("#modal-update-penanganan-awal").modal('show');
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    })
            },
            updatePenangananAwal() {

                if (!this.single.dataUpdatePenangananAwal.date) {
                    this.$swal({
                        title: "Peringatan!",
                        text: 'Tanggal tidak boleh kosong!',
                        icon: "warning",
                    })
                    return false;
                }

                if (!this.single.dataUpdatePenangananAwal.time) {
                    this.$swal({
                        title: "Peringatan!",
                        text: 'Jam tidak boleh kosong!',
                        icon: "warning",
                    })
                    return false;
                }

                if (!this.single.dataUpdatePenangananAwal.note) {
                    this.$swal({
                        title: "Peringatan!",
                        text: 'Keterangan tidak boleh kosong!',
                        icon: "warning",
                    })

                    return false;
                }
                this.$ewpLoadingShow();

                let files1 = []
                if (!$.isEmptyObject(this.dropzoneUploadUpdatePenanganan.files)) {
                    for (let file in this.dropzoneUploadUpdatePenanganan.files) {
                        files1.push(this.dropzoneUploadUpdatePenanganan.files[file])
                    }
                }

                let formData = new FormData()

                formData.append('waktu', this.single.dataUpdatePenangananAwal.date + " " + this.single
                    .dataUpdatePenangananAwal.time);
                formData.append('keterangan', this.single.dataUpdatePenangananAwal.note);

                for (var i = 0; i < files1.length; i++) {
                    let file = files1[i]
                    formData.append('dokumen[]', file)
                }

                for (let x = 0; x < this.single.dataUpdatePenangananAwal.existing.length; x++) {
                    formData.append('dokumen_existing[]', this.single.dataUpdatePenangananAwal.existing[x].id)
                }

                Api().post(`pengaduan/${this.$route.params.id}/penanganan-awal`, formData)
                    .then(response => {
                        $(".modal").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Memperbarui data penanganan awal',
                            icon: "success",
                        }).then(result => {
                            this.getInitialTreatment();
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
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

    .text-white {
        color: #fff !important;
    }

    .text-black {
        color: #000 !important
    }

    .card-header-penugasan .card-title {
        max-width: 320px !important;
    }

    @media(max-width:1100px) {
        .card-header-penugasan {
            flex-wrap: wrap !important;
        }
    }

    @media(max-width:991px) {
        .card-header-penugasan .right-column {
            flex-wrap: wrap;
        }
    }



    /* The actual timeline (the vertical ruler) */
    .timeline-custom {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* The actual timeline (the vertical ruler) */
    .timeline-custom::after {
        content: '';
        position: absolute;
        width: 2px;
        border: 1px #f2f2f2 dashed;
        top: 0;
        bottom: 0;
        left: 28px;
        margin-left: -3px;
    }

    /* Container around content */
    .container-timeline-custom {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 100%;
    }

    /* The circles on the timeline */
    .container-timeline-custom-circle {
        position: absolute;
        display: block;
        background-size: 40px 40px;
        height: 40px;
        width: 40px;
        left: -18px;
        top: 0;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #F5F8FA;
        border-radius: 100px;
    }

    /* Place the container to the left */
    .left-timeline-custom {
        right: 0;
    }

    /* Place the container to the right */
    .right-timeline-custom {
        left: 25px;
    }

    /* Add arrows to the left container (pointing right) */
    .left-timeline-custom::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid white;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent white;
    }

    /* Fix the circle for containers on the right side */
    .right-timeline-custom::after {
        left: -16px;
    }

    /* The actual content */
    .content-timeline-custom {
        padding: 0;
        background-color: white;
        position: relative;
        border-radius: 6px;
    }

</style>
