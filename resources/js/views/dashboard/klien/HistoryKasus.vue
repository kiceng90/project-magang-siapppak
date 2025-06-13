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
                                                    <h4>Histori Kasus</h4>
                                                </div>
                                                <div>
                                                    &ensp;<span class="text-muted">
                                                        <a href="javascript:void(0)" @click="$router.back()"
                                                            class="text-muted" style="text-decoration:none;">Data
                                                            Klien</a>
                                                        - Histori Kasus
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-5">
                                    <div class="col-lg-5">
                                        <h1>Histori Kasus</h1>
                                    </div>
                                    <div class="col-lg-7 d-flex flex-wrap" style="justify-content:flex-end;">
                                        <button type="button" class="btn" style="background-color:#fff8dd;"
                                            @click="$router.back()">
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
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center flex-wrap mb-10 mt-5">
                                    <a href="javascript:void(0)" style="font-size:15px;border-radius:5px"
                                        class="text-gray-800 py-2 px-4" @click="flagTab = 'history-pengaduan'"
                                        :class="flagTab == 'history-pengaduan' ? 'bg-primary-custom text-white' : ''">Histori
                                        Pengaduan</a>
                                    <a href="javascript:void(0)" style="font-size:15px;border-radius:5px"
                                        class="text-gray-800 py-2 px-4" @click="flagTab = 'history-penanganan'"
                                        :class="flagTab == 'history-penanganan' ? 'bg-primary-custom text-white' : ''">Histori
                                        Penanganan</a>
                                </div>
                                <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view"
                                    v-if="flagTab == 'history-pengaduan'">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-header border-0 pt-5 align-items-center">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder text-dark mb-2"
                                                    style="font-size:20px !important;">Histori
                                                    Pengaduan</span>
                                            </h3>
                                        </div>
                                        <div class="card-body pt-5">

                                            <div class="accordion mb-5" :id="`accordion_primary`">

                                                <template v-if="$store.state.client.listComplaintHistory.loading">
                                                    <div class="w-100 d-flex justify-content-center mt-10 mb-10">
                                                        <app-loader></app-loader>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="d-flex flex-column text-center justify-content-center align-items-center mt-8 mb-8"
                                                        v-if=" $store.state.client.listComplaintHistory.data.length == 0">
                                                        <img :src="`${$assetUrl()}extends/img/empty.png`" />
                                                        <div class="text-gray-600 pt-5 text-center">Tidak ada pengaduan
                                                            yang dapat
                                                            ditampilkan</div>
                                                    </div>
                                                    <template
                                                        v-for="(context, index) in $store.state.client.listComplaintHistory.data">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header"
                                                                :id="`accordion_primary_header_${index}`"
                                                                @click="getDataComplaintByDate(context.id, context.detailComplaint.loading)">
                                                                <button class="accordion-button fs-4 fw-bold collapsed"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    :data-bs-target="`#accordion_primary_body_${index}`"
                                                                    aria-expanded="false"
                                                                    :aria-controls="`accordion_primary_body_${index}`">
                                                                    {{context.date}}
                                                                </button>
                                                            </h2>
                                                            <div :id="`accordion_primary_body_${index}`"
                                                                class="accordion-collapse collapse"
                                                                :aria-labelledby="`accordion_primary_header_${index}`"
                                                                data-bs-parent="#accordion_primary">
                                                                <div class="accordion-body">
                                                                    <template v-if="context.detailComplaint.loading">
                                                                        <div
                                                                            class="w-100 d-flex justify-content-center mt-10 mb-10">
                                                                            <app-loader></app-loader>
                                                                        </div>
                                                                    </template>
                                                                    <template v-else>
                                                                        <div
                                                                            class="d-flex justify-content-center flex-wrap mb-10 mt-5">
                                                                            <a href="javascript:void(0)"
                                                                                v-if="context.detailComplaint.id"
                                                                                style="font-size:15px;border-radius:5px"
                                                                                class="text-gray-800 py-2 px-4"
                                                                                @click="changeTabComplaint(index, 'pengaduan')"
                                                                                :class="context.flagTab == 'pengaduan' ? 'bg-primary-custom text-white' : ''">Pengaduan</a>
                                                                            <a href="javascript:void(0)"
                                                                                v-if="context.detailComplaint.id && context.detailComplaint.status.id != 1"
                                                                                style="font-size:15px;border-radius:5px"
                                                                                class="text-gray-800 py-2 px-4"
                                                                                @click="changeTabComplaint(index, 'penanganan-awal')"
                                                                                :class="context.flagTab == 'penanganan-awal' ? 'bg-primary-custom text-white' : ''">Penanganan
                                                                                Awal</a>
                                                                            <a href="javascript:void(0)"
                                                                                v-if="context.detailComplaint.id && parseInt(context.detailComplaint.status.id) > 3"
                                                                                style="font-size:15px;border-radius:5px"
                                                                                class="text-gray-800 py-2 px-4"
                                                                                @click="changeTabComplaint(index, 'penjangkauan')"
                                                                                :class="context.flagTab == 'penjangkauan' ? 'bg-primary-custom text-white' : ''">Penjangkauan</a>
                                                                        </div>
                                                                        <div class="p-5"
                                                                            v-if="context.flagTab == 'pengaduan'"
                                                                            style="border: 1px solid #E5EAEE;border-radius: 12px;">
                                                                            <h3
                                                                                class="card-title align-items-start flex-column">
                                                                                <span
                                                                                    class="card-label fw-bolder text-dark mb-2"
                                                                                    style="font-size:20px !important;">Detail
                                                                                    Data
                                                                                    Pengaduan<span
                                                                                        class="c-primary-custom ps-3">{{$noNullable(context.detailComplaint.reportIdentity.fullName)}}</span>&ensp;<span
                                                                                        class="badge"
                                                                                        :class="context.detailComplaint.status.label_status"
                                                                                        v-if="context.detailComplaint.id">{{$noNullable(context.detailComplaint.status.status)}}</span></span>
                                                                            </h3>
                                                                            <h4
                                                                                class="c-primary-custom fw-bolder pb-2 pt-5">
                                                                                Waktu
                                                                                Pengaduan</h4>
                                                                            <div class="row">
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Nomor Registrasi
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.registerNumber)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Sumber Pengaduan
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.sourceOfComplaint)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Tanggal & Jam Pengaduan
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$moment(context.detailComplaint.datetime).locale('id').format('DD MMMM YYYY  HH:mm:ss')}}
                                                                                </div>
                                                                            </div>
                                                                            <hr
                                                                                style="background-color:#8f8d8d !important" />
                                                                            <h4
                                                                                class="pt-2 c-primary-custom fw-bolder pb-2">
                                                                                Identitas Pelapor</h4>
                                                                            <div class="row">
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Nama Lengkap
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.reportIdentity.fullName)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    NIK
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.reportIdentity.nik)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Warga Surabaya
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{context.detailComplaint.reportIdentity.surabayaResidents  == 1 ? 'Ya' : 'Tidak'}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Kabupaten/Kota
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.reportIdentity.surabayaResidents == 1 ? '-' : context.detailComplaint.reportIdentity.districtOutsideSurabaya)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Alamat Domisili
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.reportIdentity.addressDomicile)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    No. Telepon/Whatsapp
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.reportIdentity.phoneNumber)}}
                                                                                </div>
                                                                            </div>
                                                                            <hr
                                                                                style="background-color:#8f8d8d !important" />
                                                                            <h4
                                                                                class="pt-2 c-primary-custom fw-bolder pb-2">
                                                                                Identitas Klien</h4>
                                                                            <div class="row">
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Nama Lengkap (Inisial)
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.clientIdentity.fullName)}}
                                                                                    ({{$noNullable(context.detailComplaint.clientIdentity.initialName)}})
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    NIK/Nomor Identitas
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.clientIdentity.identityNumber)}}&ensp;<span
                                                                                        class="badge badge-primary ms">{{$noNullable(context.detailComplaint.clientIdentity.typeIdentityNumber)}}</span>
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Warga Surabaya
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{context.detailComplaint.clientIdentity.surabayaResidents == 1 ? 'Ya' : 'Tidak'}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Kabupaten/Kota
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.clientIdentity.surabayaResidents == 1 ? '-' : context.detailComplaint.clientIdentity.districtOutsideSurabaya)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Kecamatan
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.clientIdentity.subDistrictDomicile)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Kelurahan
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.clientIdentity.villageDomicile)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Alamat Domisili
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.clientIdentity.addressDomicile)}}
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    No. Telepon/Whatsapp
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.clientIdentity.phoneNumber)}}
                                                                                </div>
                                                                            </div>
                                                                            <hr
                                                                                style="background-color:#8f8d8d !important" />
                                                                            <h4
                                                                                class="pt-2 c-primary-custom fw-bolder pb-2">
                                                                                Permasalahan</h4>
                                                                            <div class="row">
                                                                                <div
                                                                                    class="col-lg-4 text-gray-600 mb-5">
                                                                                    Uraian Singkat Permasalahan
                                                                                </div>
                                                                                <div class="col-lg-8 fw-bolder mb-5">
                                                                                    {{$noNullable(context.detailComplaint.problem.note)}}
                                                                                </div>
                                                                            </div>
                                                                            <hr
                                                                                style="background-color:#8f8d8d !important" />
                                                                            <h4
                                                                                class="pt-2 c-primary-custom fw-bolder pb-2">
                                                                                Dokumentasi Pengaduan</h4>
                                                                            <div class="row mt-3">
                                                                                <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-5"
                                                                                    v-for="(file, idxFile) in context.detailComplaint.documentation.file">
                                                                                    <a :href="file.path"
                                                                                        data-fancybox="gallery"><img
                                                                                            :src="file.path"
                                                                                            class="w-100"
                                                                                            style="height:100px;max-width:100%;" /></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <template
                                                                            v-if="context.flagTab == 'penanganan-awal'">
                                                                            <div v-if="context.detailComplaint.initialTreatment.loading"
                                                                                class="w-100 d-flex justify-content-center mt-10 mb-10">
                                                                                <app-loader></app-loader>
                                                                            </div>
                                                                            <div class="p-5" v-else
                                                                                style="border: 1px solid #E5EAEE;border-radius: 12px;">
                                                                                <h3
                                                                                    class="card-title align-items-start flex-column">
                                                                                    <span
                                                                                        class="card-label fw-bolder text-dark mb-2"
                                                                                        style="font-size:20px !important;">Detail
                                                                                        Penanganan Awal<span
                                                                                            class="c-primary-custom ps-3">{{$noNullable(context.detailComplaint.reportIdentity.fullName)}}</span>&ensp;<span
                                                                                            class="badge"
                                                                                            :class="context.detailComplaint.status.label_status"
                                                                                            v-if="context.detailComplaint.id">{{$noNullable(context.detailComplaint.status.status)}}</span></span>
                                                                                </h3>
                                                                                <h4
                                                                                    class="c-primary-custom fw-bolder pb-2 pt-5">
                                                                                    Waktu
                                                                                    Penanganan Awal</h4>
                                                                                <div class="row align-items-center">
                                                                                    <div
                                                                                        class="col-lg-4 text-gray-600 mb-5">
                                                                                        Tanggal & Jam Penanganan
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-lg-8 fw-bolder mb-5">
                                                                                        {{$moment(context.detailComplaint.initialTreatment.datetime).locale('id').format('DD MMMM YYYY  HH:mm:ss')}}
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-lg-4 text-gray-600 mb-5">
                                                                                        Hasil Penanganan Awal
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-lg-8 fw-bolder mb-5">
                                                                                        {{$noNullable(context.detailComplaint.initialTreatment.note)}}
                                                                                    </div>
                                                                                </div>
                                                                                <h4
                                                                                    class="c-primary-custom fw-bolder pb-2">
                                                                                    Dokumen Pendukung</h4>
                                                                                <div class="row">
                                                                                    <div class="col-lg-3 col-md-6 mb-5"
                                                                                        v-for="(file, idxFile) in context.detailComplaint.initialTreatment.files">
                                                                                        <a v-if="file.isImage"
                                                                                            :href="file.path"
                                                                                            data-fancybox="gallery">
                                                                                            <div
                                                                                                class="d-flex align-items-center">
                                                                                                <div class="me-3">
                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                                                        style="width:35px;" />
                                                                                                </div>
                                                                                                <div>
                                                                                                    <div class="fw-bolder text-primary"
                                                                                                        style="word-break: break-word;">
                                                                                                        {{$noNullable(file.name)}}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="text-gray-500">
                                                                                                        {{$formatBytes(file.size)}}
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>
                                                                                        <a :href="file.path"
                                                                                            target="_blank" v-else>
                                                                                            <div
                                                                                                class="d-flex align-items-center">
                                                                                                <div class="me-3">
                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                                                        style="width:35px;" />
                                                                                                </div>
                                                                                                <div>
                                                                                                    <div class="fw-bolder text-primary"
                                                                                                        style="word-break: break-word;">
                                                                                                        {{$noNullable(file.name)}}
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="text-gray-500">
                                                                                                        {{$formatBytes(file.size)}}
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </template>
                                                                        <template
                                                                            v-if="context.flagTab == 'penjangkauan'">
                                                                            <div v-if="context.detailComplaint.outreachComplaint.loading"
                                                                                class="w-100 d-flex justify-content-center mt-10 mb-10">
                                                                                <app-loader></app-loader>
                                                                            </div>
                                                                            <div class="p-5" v-else
                                                                                style="border: 1px solid #E5EAEE;border-radius: 12px;">
                                                                                <h3
                                                                                    class="card-title align-items-start flex-column">
                                                                                    <span
                                                                                        class="card-label fw-bolder text-dark mb-2"
                                                                                        style="font-size:20px !important;">Detail
                                                                                        Penjangkauan<span
                                                                                            class="c-primary-custom ps-3">{{$noNullable(context.detailComplaint.reportIdentity.fullName)}}</span>&ensp;<span
                                                                                            class="badge"
                                                                                            :class="context.detailComplaint.status.label_status"
                                                                                            v-if="context.detailComplaint.id">{{$noNullable(context.detailComplaint.status.status)}}</span></span>
                                                                                </h3>
                                                                                <h4
                                                                                    class="c-primary-custom fw-bolder pb-2 pt-5">
                                                                                    Penjadwalan</h4>
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-lg-4 text-gray-600 mb-5">
                                                                                        Hari, Tanggal, Jam
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-lg-8 fw-bolder mb-5">
                                                                                        {{$moment(context.detailComplaint.outreachComplaint.plan.datetime, 'DD-MM-YYYY HH:mm').locale('id').format('DD MMMM YYYY  HH:mm')}}
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-lg-4 text-gray-600 mb-5">
                                                                                        Tempat
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-lg-8 fw-bolder mb-5">
                                                                                        {{$noNullable(context.detailComplaint.outreachComplaint.plan.place)}}
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-lg-4 text-gray-600 mb-5">
                                                                                        Alamat
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-lg-8 fw-bolder mb-5">
                                                                                        {{$noNullable(context.detailComplaint.outreachComplaint.plan.address)}}
                                                                                    </div>
                                                                                </div>
                                                                                <h4
                                                                                    class="c-primary-custom fw-bolder pb-2">
                                                                                    Tim
                                                                                    Outreach Yang Bertugas</h4>

                                                                                <div class="row align-items-center">
                                                                                    <template
                                                                                        v-for="(context, index) in context.detailComplaint.outreachComplaint.konselorTeam">
                                                                                        <div
                                                                                            class="col-lg-4 text-gray-600 mb-5">
                                                                                            Konselor {{index + 1}}
                                                                                        </div>
                                                                                        <div
                                                                                            class="col-lg-8 fw-bolder mb-5">
                                                                                            <div
                                                                                                class="d-flex align-items-center">
                                                                                                <img class="me-3"
                                                                                                    :src="context.konselor ? context.konselor.foto : ''"
                                                                                                    style="width:50px;height:50px;border-radius:5px;">
                                                                                                <div>
                                                                                                    {{$noNullable(context.konselor ? context.konselor.name : '-')}}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </template>
                                                                                </div>
                                                                                <div v-if="context.detailComplaint.status.id == 6"
                                                                                    class="mt-5 pt-8"
                                                                                    style="border-top:1px #f2f2 solid">
                                                                                    <h4
                                                                                        class="text-danger fw-bolder pb-2">
                                                                                        Hasil Penjangkauan Di Revisi
                                                                                    </h4>
                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="col-lg-4 text-gray-600 mb-5">
                                                                                            Keterangan Pengembalian
                                                                                        </div>
                                                                                        <div
                                                                                            class="col-lg-8 mb-5 fw-bolder">
                                                                                            {{$noNullable(context.detailComplaint.outreachComplaint.lastRollbackNote)}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="p-5 mt-5"
                                                                                v-if="context.detailComplaint.outreachComplaint.id && parseInt(context.detailComplaint.status.id) >= 5 && !context.detailComplaint.outreachComplaint.result.draftStatus"
                                                                                style="border: 1px solid #E5EAEE;border-radius: 12px;">
                                                                                <div
                                                                                    class="d-flex align-items-center justify-content-between">
                                                                                    <h3>
                                                                                        <span
                                                                                            class="fw-bolder text-dark mb-2"
                                                                                            style="font-size:20px !important;">Detail
                                                                                            Hasil Penjangkauan</span>
                                                                                    </h3>
                                                                                    <button class="btn"
                                                                                        @click="setToggleShowDetailResultOutreach(index, !context.showDetailResultOutreach)"
                                                                                        :class="context.showDetailResultOutreach ? 'btn-secondary' : 'btn-light'"
                                                                                        type="button">{{context.showDetailResultOutreach ? 'Tampilkan Lebih Sedikit' : 'Tampilkan Lebih Banyak'}}
                                                                                        &ensp;<i
                                                                                            v-if="!context.showDetailResultOutreach"
                                                                                            class="fa fa-chevron-up"></i><i
                                                                                            v-if="context.showDetailResultOutreach"
                                                                                            class="fa fa-chevron-down"></i></button>
                                                                                </div>
                                                                                <template
                                                                                    v-if="context.showDetailResultOutreach">
                                                                                    <div v-if="!context.detailComplaint.outreachComplaint.result.pendampingan"
                                                                                        class="alert alert-dismissible bg-light-warning d-flex flex-column flex-sm-row p-5 align-items-center mb-10 mt-5">
                                                                                        <!--begin::Icon-->
                                                                                        <span
                                                                                            class="svg-icon svg-icon-2hx svg-icon-warning me-4 mb-5 mb-sm-0">

                                                                                            <svg width="32" height="32"
                                                                                                viewBox="0 0 32 32"
                                                                                                fill="none"
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
                                                                                        <div
                                                                                            class="d-flex flex-column pe-0 pe-sm-10">
                                                                                            <!--begin::Title-->
                                                                                            <h4 class="fw-bold">Klien
                                                                                                Tidak Bersedia
                                                                                                Didampingi</h4>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="accordion mt-5"
                                                                                        id="kt_accordion_1">
                                                                                        <div class="accordion-item">
                                                                                            <h2 class="accordion-header"
                                                                                                id="kt_accordion_1_header_1">
                                                                                                <button
                                                                                                    class="accordion-button fs-4 fw-semibold"
                                                                                                    type="button"
                                                                                                    data-bs-toggle="collapse"
                                                                                                    data-bs-target="#kt_accordion_1_body_1"
                                                                                                    aria-expanded="true"
                                                                                                    aria-controls="kt_accordion_1_body_1">
                                                                                                    Detail Kasus Klien
                                                                                                </button>
                                                                                            </h2>
                                                                                            <div id="kt_accordion_1_body_1"
                                                                                                class="accordion-collapse collapse show"
                                                                                                aria-labelledby="kt_accordion_1_header_1"
                                                                                                data-bs-parent="#kt_accordion_1">
                                                                                                <div
                                                                                                    class="accordion-body">
                                                                                                    <div class="row">
                                                                                                        <div
                                                                                                            class="col-lg-2 text-gray-600 mb-5">
                                                                                                            Tipe Kasus
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-10 mb-5 fw-bolder">
                                                                                                            <span
                                                                                                                v-if="context.detailComplaint.outreachComplaint.result.caseType == 1">Kasus
                                                                                                                Lama</span>
                                                                                                            <span
                                                                                                                v-else-if="context.detailComplaint.outreachComplaint.result.caseType ==2">Kasus
                                                                                                                Baru</span>
                                                                                                            <span
                                                                                                                v-else>-</span>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-2 text-gray-600 mb-5">
                                                                                                            Tipe
                                                                                                            Pemasalahan
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-10 mb-5 fw-bolder">
                                                                                                            {{$noNullable(context.detailComplaint.outreachComplaint.result.problemType)}}
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-2 text-gray-600 mb-5">
                                                                                                            Kategori
                                                                                                            Kasus
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-10 mb-5 fw-bolder">
                                                                                                            {{$noNullable(context.detailComplaint.outreachComplaint.result.caseCategory)}}
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-2 text-gray-600 mb-5">
                                                                                                            Jenis Kasus
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-10 mb-5 fw-bolder">
                                                                                                            {{$noNullable(context.detailComplaint.outreachComplaint.result.caseSpecies)}}
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-2 text-gray-600 mb-5">
                                                                                                            Lokasi Kasus
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-10 mb-5 fw-bolder">
                                                                                                            {{$noNullable(context.detailComplaint.outreachComplaint.result.caseLocation)}}
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-2 text-gray-600 mb-5">
                                                                                                            Uraian
                                                                                                            Singkat
                                                                                                            Permasalahan
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-10 mb-5 fw-bolder">
                                                                                                            {{$noNullable(context.detailComplaint.outreachComplaint.result.note)}}
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-2 text-gray-600 mb-5">
                                                                                                            Tanggal &
                                                                                                            Waktu
                                                                                                            Kejadian
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-10 mb-5 fw-bolder">
                                                                                                            {{$noNullable(context.detailComplaint.outreachComplaint.result.datetime)}}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="accordion mt-5"
                                                                                        id="kt_accordion_2">
                                                                                        <div class="accordion-item">
                                                                                            <h2 class="accordion-header"
                                                                                                id="kt_accordion_2_header_1">
                                                                                                <button
                                                                                                    class="accordion-button fs-4 fw-semibold"
                                                                                                    type="button"
                                                                                                    data-bs-toggle="collapse"
                                                                                                    data-bs-target="#kt_accordion_2_body_1"
                                                                                                    aria-expanded="true"
                                                                                                    aria-controls="kt_accordion_2_body_1">
                                                                                                    Dokumen Penyelesaian
                                                                                                    Kasus
                                                                                                </button>
                                                                                            </h2>

                                                                                            <div id="kt_accordion_2_body_1"
                                                                                                class="accordion-collapse collapse show"
                                                                                                aria-labelledby="kt_accordion_2_header_1"
                                                                                                data-bs-parent="#kt_accordion_2">
                                                                                                <div
                                                                                                    class="accordion-body">
                                                                                                    <div class="row">
                                                                                                        <template
                                                                                                            v-if="context.detailComplaint.outreachComplaint.result.pendampingan">
                                                                                                            <div
                                                                                                                class="col-lg-2 text-gray-600 mb-5">
                                                                                                                Berita
                                                                                                                Acara
                                                                                                                Pendampingan
                                                                                                                Klien
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="col-lg-10">
                                                                                                                <div
                                                                                                                    class="row">
                                                                                                                    <div class="col-lg-3 col-md-6 mb-5"
                                                                                                                        v-for="(contextF, indexF) in context.detailComplaint.outreachComplaint.result.files.berita_acara_pendampingan">
                                                                                                                        <a v-if="contextF.isImage"
                                                                                                                            :href="contextF.path"
                                                                                                                            data-fancybox="gallery">
                                                                                                                            <div
                                                                                                                                class="d-flex align-items-center">
                                                                                                                                <div
                                                                                                                                    class="me-3">
                                                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                                                                                        style="width:35px;" />
                                                                                                                                </div>
                                                                                                                                <div>
                                                                                                                                    <div class="fw-bolder text-primary"
                                                                                                                                        style="word-break: break-word;">
                                                                                                                                        {{$noNullable(contextF.name)}}
                                                                                                                                    </div>
                                                                                                                                    <div
                                                                                                                                        class="text-gray-500">
                                                                                                                                        {{$formatBytes(contextF.size)}}
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </a>
                                                                                                                        <a :href="contextF.path"
                                                                                                                            target="_blank"
                                                                                                                            v-else>
                                                                                                                            <div
                                                                                                                                class="d-flex align-items-center">
                                                                                                                                <div
                                                                                                                                    class="me-3">
                                                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                                                                                        style="width:35px;" />
                                                                                                                                </div>
                                                                                                                                <div>
                                                                                                                                    <div class="fw-bolder text-primary"
                                                                                                                                        style="word-break: break-word;">
                                                                                                                                        {{$noNullable(contextF.name)}}
                                                                                                                                    </div>
                                                                                                                                    <div
                                                                                                                                        class="text-gray-500">
                                                                                                                                        {{$formatBytes(contextF.size)}}
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="col-lg-2 text-gray-600 mb-5">
                                                                                                                Surat
                                                                                                                Pernyataan
                                                                                                                Klien
                                                                                                                Bersedia
                                                                                                                (Informed
                                                                                                                Consent)
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="col-lg-10">
                                                                                                                <div class="row"
                                                                                                                    v-if="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_klien">
                                                                                                                    <div
                                                                                                                        class="col-lg-12 col-md-12 mb-5">
                                                                                                                        <a v-if="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_klien.isImage"
                                                                                                                            :href="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_klien.path"
                                                                                                                            data-fancybox="gallery">
                                                                                                                            <div
                                                                                                                                class="d-flex align-items-center">
                                                                                                                                <div
                                                                                                                                    class="me-3">
                                                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                                                                                        style="width:35px;" />
                                                                                                                                </div>
                                                                                                                                <div>
                                                                                                                                    <div class="fw-bolder text-primary"
                                                                                                                                        style="word-break: break-word;">
                                                                                                                                        {{$noNullable(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_klien.name)}}
                                                                                                                                    </div>
                                                                                                                                    <div
                                                                                                                                        class="text-gray-500">
                                                                                                                                        {{$formatBytes(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_klien.size)}}
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </a>
                                                                                                                        <a :href="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_klien.path"
                                                                                                                            target="_blank"
                                                                                                                            v-else>
                                                                                                                            <div
                                                                                                                                class="d-flex align-items-center">
                                                                                                                                <div
                                                                                                                                    class="me-3">
                                                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                                                                                        style="width:35px;" />
                                                                                                                                </div>
                                                                                                                                <div>
                                                                                                                                    <div class="fw-bolder text-primary"
                                                                                                                                        style="word-break: break-word;">
                                                                                                                                        {{$noNullable(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_klien.name)}}
                                                                                                                                    </div>
                                                                                                                                    <div
                                                                                                                                        class="text-gray-500">
                                                                                                                                        {{$formatBytes(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_klien.size)}}
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="col-lg-2 text-gray-600 mb-5">
                                                                                                                Surat
                                                                                                                Pernyataan
                                                                                                                Telah
                                                                                                                Selesai
                                                                                                                Pendampingan
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="col-lg-10">
                                                                                                                <div class="row"
                                                                                                                    v-if="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan">
                                                                                                                    <div
                                                                                                                        class="col-lg-12 col-md-12 mb-5">
                                                                                                                        <a v-if="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.isImage"
                                                                                                                            :href="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.path"
                                                                                                                            data-fancybox="gallery">
                                                                                                                            <div
                                                                                                                                class="d-flex align-items-center">
                                                                                                                                <div
                                                                                                                                    class="me-3">
                                                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                                                                                        style="width:35px;" />
                                                                                                                                </div>
                                                                                                                                <div>
                                                                                                                                    <div class="fw-bolder text-primary"
                                                                                                                                        style="word-break: break-word;">
                                                                                                                                        {{$noNullable(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.name)}}
                                                                                                                                    </div>
                                                                                                                                    <div
                                                                                                                                        class="text-gray-500">
                                                                                                                                        {{$formatBytes(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.size)}}
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </a>
                                                                                                                        <a :href="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.path"
                                                                                                                            target="_blank"
                                                                                                                            v-else>
                                                                                                                            <div
                                                                                                                                class="d-flex align-items-center">
                                                                                                                                <div
                                                                                                                                    class="me-3">
                                                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                                                                                        style="width:35px;" />
                                                                                                                                </div>
                                                                                                                                <div>
                                                                                                                                    <div class="fw-bolder text-primary"
                                                                                                                                        style="word-break: break-word;">
                                                                                                                                        {{$noNullable(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.name)}}
                                                                                                                                    </div>
                                                                                                                                    <div
                                                                                                                                        class="text-gray-500">
                                                                                                                                        {{$formatBytes(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan.size)}}
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </template>
                                                                                                        <template
                                                                                                            v-else>
                                                                                                            <div
                                                                                                                class="col-lg-2 text-gray-600 mb-5">
                                                                                                                Surat
                                                                                                                Pernyataan
                                                                                                                Klien
                                                                                                                Tidak
                                                                                                                Bersedia
                                                                                                                Didampingi
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="col-lg-10">
                                                                                                                <div class="row"
                                                                                                                    v-if="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi">
                                                                                                                    <div
                                                                                                                        class="col-lg-12 col-md-12 mb-5">
                                                                                                                        <a v-if="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.isImage"
                                                                                                                            :href="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.path"
                                                                                                                            data-fancybox="gallery">
                                                                                                                            <div
                                                                                                                                class="d-flex align-items-center">
                                                                                                                                <div
                                                                                                                                    class="me-3">
                                                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                                                                                        style="width:35px;" />
                                                                                                                                </div>
                                                                                                                                <div>
                                                                                                                                    <div class="fw-bolder text-primary"
                                                                                                                                        style="word-break: break-word;">
                                                                                                                                        {{$noNullable(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.name)}}
                                                                                                                                    </div>
                                                                                                                                    <div
                                                                                                                                        class="text-gray-500">
                                                                                                                                        {{$formatBytes(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.size)}}
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </a>
                                                                                                                        <a :href="context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.path"
                                                                                                                            target="_blank"
                                                                                                                            v-else>
                                                                                                                            <div
                                                                                                                                class="d-flex align-items-center">
                                                                                                                                <div
                                                                                                                                    class="me-3">
                                                                                                                                    <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                                                                                        style="width:35px;" />
                                                                                                                                </div>
                                                                                                                                <div>
                                                                                                                                    <div class="fw-bolder text-primary"
                                                                                                                                        style="word-break: break-word;">
                                                                                                                                        {{$noNullable(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.name)}}
                                                                                                                                    </div>
                                                                                                                                    <div
                                                                                                                                        class="text-gray-500">
                                                                                                                                        {{$formatBytes(context.detailComplaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi.size)}}
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
                                                                                    <div class="c-primary-custom fw-bolder pt-5"
                                                                                        style="font-size:18px">Hasil
                                                                                        Penjangkauan</div>
                                                                                    <div class="text-gray-600">Berikut
                                                                                        ini
                                                                                        merupakan hasil penjangkauan ke
                                                                                        klien</div>
                                                                                    <div class="timeline-custom mt-10">
                                                                                        <div class="container-timeline-custom right-timeline-custom"
                                                                                            v-for="timeline in context.detailComplaint.outreachComplaint.result.listOutreach">
                                                                                            <template
                                                                                                v-if="showPreparatorStep(timeline.id, context.detailComplaint.outreachComplaint.result.needPreparator)">
                                                                                                <div
                                                                                                    class="container-timeline-custom-circle">

                                                                                                    <svg width="24"
                                                                                                        height="24"
                                                                                                        viewBox="0 0 24 24"
                                                                                                        fill="none"
                                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                                        <path
                                                                                                            opacity="0.7"
                                                                                                            d="M11.8 5.2L17.7 8.6V15.4L11.8 18.8L5.90001 15.4V8.6L11.8 5.2ZM11.8 2C11.5 2 11.2 2.1 11 2.2L3.8 6.4C3.3 6.7 3 7.3 3 7.9V16.2C3 16.8 3.3 17.4 3.8 17.7L11 21.9C11.3 22 11.5 22.1 11.8 22.1C12.1 22.1 12.4 22 12.6 21.9L19.8 17.7C20.3 17.4 20.6 16.8 20.6 16.2V7.9C20.6 7.3 20.3 6.7 19.8 6.4L12.6 2.2C12.4 2.1 12.1 2 11.8 2Z"
                                                                                                            fill="#50CD89" />
                                                                                                        <path
                                                                                                            d="M11.7984 8.7002L8.89844 10.3002V13.7002L11.7984 15.3002L14.6984 13.7002V10.3002L11.7984 8.7002Z"
                                                                                                            fill="#50CD89" />
                                                                                                    </svg>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="content-timeline-custom">
                                                                                                    <h2
                                                                                                        class="fw-bolder">
                                                                                                        {{$noNullable(timeline.text)}}&ensp;<span
                                                                                                            v-if="timeline.status == 'done'"
                                                                                                            class="badge badge-success">Selesai</span>
                                                                                                        <span
                                                                                                            v-if="timeline.status == 'waiting'"
                                                                                                            class="badge badge-danger">Belum
                                                                                                            Diinput</span>
                                                                                                        <span
                                                                                                            v-if="timeline.status == 'draft'"
                                                                                                            class="badge badge-secondary">Draft</span>
                                                                                                    </h2>
                                                                                                    <div v-if="timeline.status == 'done' || timeline.status == 'draft'"
                                                                                                        class="text-gray-600 mb-3">
                                                                                                        Diperbarui:
                                                                                                        {{$moment(timeline.datetime).locale('id').format('DD MMMM YYYY  HH:mm:ss')}}
                                                                                                        oleh
                                                                                                        <span
                                                                                                            class="text-black fw-bolder">{{$noNullable(timeline.konselor)}}</span>
                                                                                                    </div>
                                                                                                    <div v-if="timeline.status == 'waiting'"
                                                                                                        class="text-gray-600 mb-3">
                                                                                                        Data belum
                                                                                                        ditambahkan oleh
                                                                                                        <span
                                                                                                            class="text-black fw-bolder">Konselor</span>
                                                                                                    </div>
                                                                                                    <div class="p-3"
                                                                                                        style="border: 1px dashed #E4E6EF;border-radius:12px;">
                                                                                                        <div
                                                                                                            class="row align-items-center">
                                                                                                            <div
                                                                                                                class="col-lg-6 my-1 col-md-6">
                                                                                                                {{timeline.desc}}
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="col-lg-6 my-1 col-md-6 justify-content-end text-right">
                                                                                                                <button
                                                                                                                    v-if="timeline.status == 'done'"
                                                                                                                    @click="detailOutreachComplete(timeline.id, context.detailComplaint.outreachComplaint.id)"
                                                                                                                    class="btn btn-success btn-sm"
                                                                                                                    type="button">Lihat
                                                                                                                    Detail</button>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </template>
                                                                                        </div>
                                                                                    </div>
                                                                                </template>

                                                                            </div>
                                                                        </template>
                                                                    </template>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view"
                                    v-if="flagTab == 'history-penanganan'">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <div
                                            class="card-header border-0 pt-5 align-items-center justify-content-between">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder text-dark mb-2"
                                                    style="font-size:20px !important;">Histori
                                                    Penanganan</span>
                                            </h3>
                                            <button type="button" class="btn btn-sm bg-primary-custom" v-if="canAccessPenangananKasus.filter((e) => e == $store.state.profile.role_id).length > 0"
                                                @click="showModalAdd">
                                                <span class="text-white">Tambah Data</span>
                                            </button>
                                        </div>
                                        <div class="card-body pt-5">
                                            <template v-if="$store.state.client.listHandlingHistory.loading">
                                                <div class="w-100 d-flex justify-content-center mt-10 mb-10">
                                                    <app-loader></app-loader>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="d-flex flex-column justify-content-center align-items-center mt-8 mb-8"
                                                    v-if="$store.state.client.listHandlingHistory.data.length == 0">
                                                    <img :src="`${$assetUrl()}extends/img/empty.png`" />
                                                    <div class="text-gray-600 pt-5">Tidak ada penanganan yang dapat
                                                        ditampilkan</div>
                                                </div>
                                                <div class="timeline-custom mt-10">
                                                    <div class="container-timeline-custom right-timeline-custom"
                                                        v-for="(context, index) in $store.state.client.listHandlingHistory.data">
                                                        <div class="container-timeline-custom-circle">
                                                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none"
                                                                v-if="context.type == 1"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M13.5 0.5C11.8905 0.5 10.0083 2.32463 9 3.5C7.99175 2.32463 6.1095 0.5 4.5 0.5C1.651 0.5 0 2.72218 0 5.55041C0 8.68347 3 12 9 15.5C15 12 18 8.75 18 5.75C18 2.92177 16.349 0.5 13.5 0.5Z"
                                                                    fill="#50CD89" />
                                                            </svg>

                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                v-if="context.type == 2"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M3.95712 8.41504L11.4786 3.81859C11.7987 3.62297 12.2014 3.62297 12.5215 3.81859L20.0429 8.41504C20.6374 8.77835 21 9.42487 21 10.1216V19C21 20.1046 20.1046 21 19 21L5 21C3.89543 21 3 20.1046 3 19L3.00002 10.1216C3.00002 9.42486 3.36261 8.77835 3.95712 8.41504ZM10 12.9999C9.44773 12.9999 9.00002 13.4476 9.00002 13.9999V16.9999C9.00002 17.5522 9.44773 17.9999 10 17.9999H14C14.5523 17.9999 15 17.5522 15 16.9999V13.9999C15 13.4476 14.5523 12.9999 14 12.9999H10Z"
                                                                    fill="#FFC700" />
                                                            </svg>

                                                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                                                v-if="context.type == 3"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M20 20.2266V19.2266C20 18.6266 19.6 18.2266 19 18.2266H5C4.4 18.2266 4 18.6266 4 19.2266V20.2266H3C2.4 20.2266 2 20.6266 2 21.2266V22.2266H22V21.2266C22 20.6266 21.6 20.2266 21 20.2266H20Z"
                                                                    fill="#009EF7" />
                                                                <path opacity="0.3"
                                                                    d="M22 7.225V8.225C22 8.825 21.6 9.225 21 9.225H18C18.6 9.225 19 9.625 19 10.225C19 10.825 18.6 11.225 18 11.225V16.225C18.6 16.225 19 16.625 19 17.225V18.225H15V17.225C15 16.625 15.4 16.225 16 16.225V11.225C15.4 11.225 15 10.825 15 10.225C15 9.625 15.4 9.225 16 9.225H13C13.6 9.225 14 9.625 14 10.225C14 10.825 13.6 11.225 13 11.225V16.225C13.6 16.225 14 16.625 14 17.225V18.225H10V17.225C10 16.625 10.4 16.225 11 16.225V11.225C10.4 11.225 10 10.825 10 10.225C10 9.625 10.4 9.225 11 9.225H8C8.6 9.225 9 9.625 9 10.225C9 10.825 8.6 11.225 8 11.225V16.225C8.6 16.225 9 16.625 9 17.225V18.225H5V17.225C5 16.625 5.4 16.225 6 16.225V11.225C5.4 11.225 5 10.825 5 10.225C5 9.625 5.4 9.225 6 9.225H3C2.4 9.225 2 8.825 2 8.225V7.225L11 2.725C11.6 2.425 12.4 2.425 13.1 2.725L22 7.225ZM12 4.225C11.2 4.225 10.5 4.925 10.5 5.725C10.5 6.525 11.2 7.225 12 7.225C12.8 7.225 13.5 6.525 13.5 5.725C13.5 4.925 12.8 4.225 12 4.225Z"
                                                                    fill="#009EF7" />
                                                            </svg>

                                                        </div>
                                                        <div class="content-timeline-custom">
                                                            <h2 class="fw-bolder">
                                                                <span v-if="context.type == 1">Pendampingan
                                                                    Lanjutan</span>
                                                                <span v-if="context.type == 2">Monitoring/Home
                                                                    Visit</span>
                                                                <span v-if="context.type == 3">Intervensi OPD</span>
                                                            </h2>
                                                            <div class="text-gray-600">
                                                                {{$moment(context.created_at).locale('id').format('DD MMMM YYYY  HH:mm:ss')}}
                                                                oleh <span
                                                                    class="text-black fw-bolder">{{$noNullable(context.created_by)}}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button class="btn btn-light btn-sm mb-3"
                                                                    v-if="(context.type == 1 || context.type == 2) && canAccessPenangananKasus.filter((e) => e == $store.state.profile.role_id).length > 0" 
                                                                    @click="editHistoryPenanganan(context.id)"
                                                                    type="button">

                                                                    <svg width="22" height="22" viewBox="0 0 22 22"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path opacity="0.3"
                                                                            d="M19.6166 7.65575L17.6375 9.63388L12.3612 4.35756L14.3394 2.37843C14.6893 2.02852 15.164 1.83203 15.6589 1.83203C16.1538 1.83203 16.6284 2.02852 16.9784 2.37843L19.6166 5.01664C19.9665 5.36663 20.1631 5.84123 20.1631 6.33614C20.1631 6.83105 19.9665 7.30576 19.6166 7.65575V7.65575ZM3.37968 20.1031L9.06301 18.2084L3.78668 12.9321L1.89192 18.6154C1.8224 18.823 1.81221 19.0459 1.8625 19.259C1.91278 19.4721 2.02155 19.6669 2.17655 19.8215C2.33155 19.9761 2.52664 20.0844 2.73984 20.1341C2.95305 20.1839 3.17591 20.1732 3.38334 20.1031H3.37968Z"
                                                                            fill="#50CD89" />
                                                                        <path
                                                                            d="M5.10928 19.5255L3.38411 20.1011C3.17686 20.17 2.95451 20.18 2.74193 20.1298C2.52935 20.0796 2.33494 19.9712 2.18044 19.8168C2.02594 19.6624 1.91746 19.4681 1.86713 19.2556C1.81679 19.043 1.82659 18.8207 1.89544 18.6134L2.47111 16.8872L5.10928 19.5255ZM3.79019 12.93L9.06653 18.2063L17.641 9.63178L12.3647 4.35547L3.79019 12.93Z"
                                                                            fill="#50CD89" />
                                                                    </svg>

                                                                </button>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="button" v-if="context.type == 3"
                                                                    class="btn btn-sm btn-success mb-3"
                                                                    @click="detailHistoryPenanganan(context.id)">Hasil
                                                                    Intervensi</button>
                                                            </div>
                                                            <div class="p-3"
                                                                style="border: 1px dashed #E4E6EF;border-radius:12px;">
                                                                <div class="row align-items-center"
                                                                    v-if="context.type == 1 || context.type == 2">
                                                                    <div class="col-lg-4 text-gray-600 mb-5">
                                                                        Tanggal Pelayanan
                                                                    </div>
                                                                    <div class="col-lg-8 fw-bolder mb-5">
                                                                        {{$moment(context.tanggal_pelayanan).locale('id').format('DD MMMM YYYY')}}
                                                                    </div>
                                                                    <div class="col-lg-4 text-gray-600 mb-5">
                                                                        Kebutuhan
                                                                    </div>
                                                                    <div class="col-lg-8 fw-bolder mb-5">
                                                                        {{$noNullable(context.nama_pelayanan)}}
                                                                    </div>
                                                                    <div class="col-lg-4 text-gray-600 mb-5"
                                                                        v-if="context.id_pelayanan == 5">
                                                                        Kebutuhan Shelter
                                                                    </div>
                                                                    <div class="col-lg-8 fw-bolder mb-5"
                                                                        v-if="context.id_pelayanan == 5">
                                                                        <!-- {{$noNullable(context.shelter_type == 1 ?'Shelter ABH' : 'Shelter Anak Perempuan')}} -->
                                                                        {{ $noNullable(
                                                                            context.shelter_type == 1 ? 'Shelter ABH' : 
                                                                            context.shelter_type == 2 ? 'Shelter Anak Perempuan' : 
                                                                            context.shelter_type == 3 ? 'Shelter Perempuan' : 
                                                                            'Shelter LSM/LKSA/Fasilitas Lainnya'
                                                                        ) }}
                                                                    </div>
                                                                    <div class="col-lg-4 text-gray-600 mb-5">
                                                                        Deskripsi Pelayanan Yang Diberikan
                                                                    </div>
                                                                    <div class="col-lg-8 fw-bolder mb-5">
                                                                        <div v-html="context.deskripsi"></div>
                                                                    </div>
                                                                    <div class="col-lg-4 text-gray-600 mb-5">
                                                                        Dokumen Pendukung
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <div class="row">
                                                                            <div class="col-lg-4 col-md-6 mb-5"
                                                                                v-for="(file, idxFile) in context.files">
                                                                                <a v-if="file.isImage" :href="file.path"
                                                                                    data-fancybox="gallery">
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                                                style="width:35px;" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <div class="fw-bolder text-primary"
                                                                                                style="word-break: break-word;">
                                                                                                {{$noNullable(file.name)}}
                                                                                            </div>
                                                                                            <div class="text-gray-500">
                                                                                                {{$formatBytes(file.size)}}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                                <a :href="file.path" target="_blank"
                                                                                    v-else>
                                                                                    <div
                                                                                        class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                                                style="width:35px;" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <div class="fw-bolder text-primary"
                                                                                                style="word-break: break-word;">
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

                                                                <div class="row align-items-center"
                                                                    v-if="context.type == 3">
                                                                    <div class="col-lg-4 text-gray-600 mb-5">
                                                                        Status Intervensi
                                                                    </div>
                                                                    <div class="col-lg-8 fw-bolder mb-5">
                                                                        <span class="badge badge-light-info"
                                                                            v-if="context.status">Proses
                                                                            Intervensi</span>
                                                                        <span class="badge badge-light-success"
                                                                            v-else>Intervensi Selesai</span>

                                                                    </div>
                                                                    <div class="col-lg-4 text-gray-600 mb-5">
                                                                        OPD
                                                                    </div>
                                                                    <div class="col-lg-8 fw-bolder mb-5">
                                                                        {{$noNullable(context.nama_opd)}}
                                                                    </div>
                                                                    <div class="col-lg-4 text-gray-600 mb-5">
                                                                        Pelayanan Yang Diberikan
                                                                    </div>
                                                                    <div class="col-lg-8 fw-bolder mb-5">
                                                                        {{$noNullable(context.nama_pelayanan)}}
                                                                    </div>                                                                   
                                                                </div>
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
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" tabindex="-1" id="modal-form-history-penanganan">
            <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:1100px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{flagFormPenanganan == 'insert' ? 'Tambah' : 'Edit' }} Data Penanganan
                            Kasus</h5>
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


                        <div class="row mb-5 pb-5">
                            <div class="col-lg-12 mb-5">
                                <!--begin::Radio group-->
                                <div data-kt-buttons="true" class="row">
                                    <!--begin::Radio button-->
                                    <div class="col-lg-6 p-5">
                                        <label
                                            class=" btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div
                                                    class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                    <input class="form-check-input" type="radio"
                                                        :disabled="flagFormPenanganan == 'update'"
                                                        name="form-history-penanganan"
                                                        v-model="single.formHistoryPenanganan.type" value="1" />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center fs-3 fw-bolder flex-wrap">
                                                        Pendampingan Lanjutan
                                                    </h2>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                    </div>
                                    <div class="col-lg-6 p-5">
                                        <label
                                            class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div
                                                    class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                    <input class="form-check-input" type="radio"
                                                        name="form-history-penanganan"
                                                        :disabled="flagFormPenanganan == 'update'"
                                                        v-model="single.formHistoryPenanganan.type" value="2" />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center fs-3 fw-bolder flex-wrap">
                                                        Monitoring/Home Visit
                                                    </h2>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                    </div>                                  
                                    <!--end::Radio button-->

                                </div>
                                <!--end::Radio group-->
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder"
                                :class="v$.single.formHistoryPenanganan.date.$error ? 'text-danger' : ''"
                                v-show="single.formHistoryPenanganan.type">
                                Tanggal Pelayanan
                            </div>
                            <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.type">
                                <app-datepicker type="date" placeholder="Pilih tanggal" :format="'DD-MM-YYYY'"
                                    :value-type="'YYYY-MM-DD'" v-model:value="single.formHistoryPenanganan.date">
                                </app-datepicker>
                                <div v-if="v$.single.formHistoryPenanganan.date.$error" class="text-danger"> Tanggal
                                    tidak boleh kosong!
                                </div>
                            </div>
                            <template
                                v-if="single.formHistoryPenanganan.type == 1 || single.formHistoryPenanganan.type == 2">
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.service.$error ? 'text-danger' : ''"
                                    v-show="single.formHistoryPenanganan.type">
                                    Pelayanan Yang Diberikan
                                </div>
                                <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.type">
                                    <app-select-single v-model="single.formHistoryPenanganan.service"
                                        @option-change="single.formHistoryPenanganan.shelter_type = ''"
                                        :loading="pageStatus == 'service-load'" :placeholder="'Pilih Pelayanan'"
                                        :options="listService" @change-search="getService" :serverside="true">
                                    </app-select-single>
                                    <div v-if="v$.single.formHistoryPenanganan.service.$error" class="text-danger">
                                        Pelayanan
                                        tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.shelter_type.$error ? 'text-danger' : ''"
                                    v-show="single.formHistoryPenanganan.service.id == 5">
                                    Kebutuhan Shelter
                                </div>
                                <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.service.id == 5">
                                    <div class="d-flex flex-wrap">
                                        <div class="form-check form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="radio" value="1" name="shelter-type"
                                                v-model="single.formHistoryPenanganan.shelter_type" id="shelter1" />
                                            <label class="form-check-label" for="shelter1">
                                                Shelter ABH
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="radio" value="2" name="shelter-type"
                                                v-model="single.formHistoryPenanganan.shelter_type" id="shelter2" />
                                            <label class="form-check-label" for="shelter2">
                                                Shelter Anak Perempuan
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="radio" value="3" name="shelter-type"
                                                v-model="single.formHistoryPenanganan.shelter_type" id="shelter3" />
                                            <label class="form-check-label" for="shelter3">
                                                Shelter Perempuan
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="4" name="shelter-type"
                                                v-model="single.formHistoryPenanganan.shelter_type" id="shelter4" />
                                            <label class="form-check-label" for="shelter4">
                                                Shelter LSM/LKSA/Fasilitas Lainnya
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if="v$.single.formHistoryPenanganan.shelter_type.$error" class="text-danger">
                                        Pilih Salah Satu!
                                    </div>
                                </div>
                            </template>
                            <template v-if="single.formHistoryPenanganan.type == 3">
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.need.$error ? 'text-danger' : ''">
                                    Pelayanan Yang Diberikan
                                </div>
                                <div class="col-lg-9 mb-5">
                                    <app-select-single v-model="single.formHistoryPenanganan.need"
                                        :loading="pageStatus == 'need-load'" :placeholder="'Pilih Kebutuhan'"
                                        :options="listNeed" @change-search="getNeed" :serverside="true">
                                    </app-select-single>
                                    <div v-if="v$.single.formHistoryPenanganan.need.$error" class="text-danger">
                                        Kebutuhan
                                        tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.opd.$error ? 'text-danger' : ''">
                                    OPD/Instansi Rujukan
                                </div>
                                <div class="col-lg-9 mb-5">
                                    <app-select-single v-model="single.formHistoryPenanganan.opd"
                                        @option-change="single.formHistoryPenanganan.intervensi = {}"
                                        :loading="pageStatus == 'opd-load'" :placeholder="'Pilih OPD'"
                                        :options="listOPD" @change-search="getOPD" :serverside="true">
                                    </app-select-single>
                                    <div v-if="v$.single.formHistoryPenanganan.opd.$error" class="text-danger">
                                        OPD
                                        tidak boleh kosong!
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-5 fw-bolder"
                                    :class="v$.single.formHistoryPenanganan.intervensi.$error ? 'text-danger' : ''">
                                    Pelayanan Yang Diberikan(Intervensi)
                                </div>
                                <div class="col-lg-9 mb-5">
                                    <app-select-single :disabled="!single.formHistoryPenanganan.opd.id"
                                        v-model="single.formHistoryPenanganan.intervensi"
                                        :loading="pageStatus == 'intervensi-load'" :placeholder="'Pilih Pelayanan'"
                                        :options="listIntervensi" @change-search="getIntervensi" :serverside="true">
                                    </app-select-single>
                                    <div v-if="v$.single.formHistoryPenanganan.intervensi.$error" class="text-danger">
                                        Pelayanan
                                        tidak boleh kosong!
                                    </div>
                                </div>
                            </template>
                            <div class="col-lg-3 mb-5 fw-bolder"
                                :class="v$.single.formHistoryPenanganan.note.$error ? 'text-danger' : ''"
                                v-show="single.formHistoryPenanganan.type">
                                Deskripsi Pelayanan Yang Diberikan
                            </div>
                            <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.type">
                                <!-- <app-editor v-model="single.formHistoryPenanganan.note"></app-editor>                                -->
                                <app-editor class="form-control" v-model:content="single.formHistoryPenanganan.note" ref="editor" contentType="html"></app-editor>
                                <div v-if="v$.single.formHistoryPenanganan.note.$error" class="text-danger"> Deskripsi
                                    tidak boleh kosong!
                                </div>
                            </div>
                            <div class="col-lg-3 mb-5 fw-bolder" v-show="single.formHistoryPenanganan.type">
                                Dokumen Pendukung
                            </div>
                            <div class="col-lg-9 mb-5" v-show="single.formHistoryPenanganan.type">

                                <div class="dropzone dropzone-file-area dz-clickable"
                                    :id="`dropzone-form-history-penanganan`">
                                    <div class="dz-message needsclick">
                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                        <div class="ms-4">
                                            <h5 class="kt-dropzone__msg-title">Drop
                                                files here or
                                                click
                                                to upload</h5>
                                            <span class="kt-dropzone__msg-desc text-primary">
                                                Upload up to 10 files with the
                                                format
                                                .jpg/.jpeg/.png/.pdf
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-lg-4 col-md-6 mb-5  d-flex align-items-center justify-content-between"
                                        v-for="(file, idxFile) in single.formHistoryPenanganan.existingFile">
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
                                        <div><i @click="single.formHistoryPenanganan.existingFile.splice(idxFile, 1)"
                                                class="fa fa-times text-danger"
                                                style="font-size:20px;cursor:pointer;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button v-if="flagFormPenanganan == 'insert'" @click="saveHistoryPenanganan"
                            class="btn btn-sm bg-second-primary-custom text-white" type="button">
                            Simpan
                        </button>
                        <button v-if="flagFormPenanganan == 'update'" @click="updateHistoryPenanganan"
                            class="btn btn-sm bg-second-primary-custom text-white" type="button">
                            Simpan
                        </button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal detail -->
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

    import useVuelidate from '@vuelidate/core'
    import {
        required,
        requiredIf
    } from '@vuelidate/validators'


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
                canAccessPenangananKasus: [process.env.MIX_ROLE_ADMIN_ID, process.env.MIX_ROLE_KABID_ID, process.env
                    .MIX_ROLE_KONSELOR_ID, process.env.MIX_ROLE_SUBKORD_ID
                ],
                v$: useVuelidate(),
                pageStatus: 'standby',
                flagTab: 'history-pengaduan',
                flagFormPenanganan: 'insert',
                listService: [],
                listNeed: [],
                listOPD: [],
                listIntervensi: [],
                single: {
                    formHistoryPenanganan: {
                        id: '',
                        type: '',
                        date: '',
                        service: {},
                        shelter_type: '',
                        need: {},
                        opd: {},
                        intervensi: {},
                        note: '',
                        existingFile: [],
                        dropzoneUpload: null,
                    }
                }
            }
        },
        validations() {
            return {
                single: {
                    formHistoryPenanganan: {
                        type: {
                            required
                        },
                        service: {
                            required: requiredIf(function () {
                                return (this.single.formHistoryPenanganan.type == 1 || this.single
                                    .formHistoryPenanganan.type == 2);
                            })
                        },
                        shelter_type: {
                            required: requiredIf(function () {
                                return (this.single.formHistoryPenanganan.type == 1 || this.single
                                        .formHistoryPenanganan.type == 2) && this.single
                                    .formHistoryPenanganan.service.id == 5;
                            })
                        },
                        date: {
                            required
                        },
                        note: {
                            required
                        },
                        need: {
                            required: requiredIf(function () {
                                return this.single.formHistoryPenanganan.type == 3;
                            })
                        },
                        opd: {
                            required: requiredIf(function () {
                                return this.single.formHistoryPenanganan.type == 3;
                            })
                        },
                        intervensi: {
                            required: requiredIf(function () {
                                return this.single.formHistoryPenanganan.type == 3;
                            })
                        }
                    }
                }
            }
        },
        watch: {
            'single.formHistoryPenanganan.type': function () {
                this.single.formHistoryPenanganan.service = {};
                this.single.formHistoryPenanganan.shelter_type = '';
                this.single.formHistoryPenanganan.need = {};
                this.single.formHistoryPenanganan.opd = {};
                this.single.formHistoryPenanganan.intervensi = {};
            }
        },
        beforeRouteLeave(to, from, next) {
            this.single.formHistoryPenanganan.dropzoneUpload.destroy();
            next();
        },
        mounted() {
            reinitializeAllPlugin();

            this.$store.dispatch('client/getComplaintHistory', this.$route.params.id).then((res) => {
                if (res.status == 200 || res.status == 201) {

                    return true;
                } else {
                    this.$axiosHandleError(res);
                }
            });

            this.getHandlingHistory();

            this.initDropzone();
        },
        methods: {
            getHandlingHistory() {
                this.$store.dispatch('client/getHandlingHistory', this.$route.params.id).then((res) => {
                    if (res.status == 200 || res.status == 201) {
                        return true;
                    } else {
                        this.$axiosHandleError(res);
                    }
                });
            },
            setToggleShowDetailResultOutreach(index, data) {
                let payload = {
                    index,
                    data
                }
                this.$store.commit('client/SET_TOGGLE_OUTREACH_RESULT_COMPLAINT_HISTORY_DATA', payload)
            },
            changeTabComplaint(index, data) {
                let payload = {
                    index,
                    data
                }

                const id = this.$store.state.client.listComplaintHistory.data[index].id;

                this.$store.commit('client/SET_FLAG_TAB_COMPLAINT_HISTORY_DATA', payload)

                if (data == 'penanganan-awal' || data == 'penjangkauan') {

                    let urlFunction = '';
                    if (data == 'penanganan-awal') {
                        urlFunction = 'client/getInitialTreatmentComplaintHistory';
                    } else if (data == 'penjangkauan') {
                        urlFunction = 'client/getOutreachComplaintHistory';
                    }
                    this.$store.dispatch(urlFunction, id).then((res) => {
                        if (res.status == 200 || res.status == 201) {
                            return true;
                        } else {
                            console.log(res);
                            this.$axiosHandleError(res);
                        }
                    });
                }
            },
            getDataComplaintByDate(id, loading) {
                if (loading) {
                    return false;
                }

                const index = this.$store.state.client.listComplaintHistory.data.findIndex((e) => e.id == id);
                if (index >= 0) {
                    if (this.$store.state.client.listComplaintHistory.data[index].detailComplaint.id) {
                        return false;
                    }
                }

                this.$store.dispatch('client/getDetailComplaintHistory', id).then((res) => {
                    if (res.status == 200 || res.status == 201) {
                        return true;
                    } else {
                        this.$axiosHandleError(res);
                    }
                });
            },
            initDropzone() {
                const that = this;
                this.single.formHistoryPenanganan.dropzoneUpload = new Dropzone("#dropzone-form-history-penanganan", {
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
            detailOutreachComplete(id, outreachId) {
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
                this.$store.dispatch(urlFunction, outreachId).then((
                    res) => {
                    this.$ewpLoadingHide();
                    if (res.status == 200 || res.status == 201) {
                        $("#modal-detail-" + id).modal('show');
                    } else {
                        this.$axiosHandleError(res);
                    }
                });

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
            showModalAdd() {
                this.reset();

                this.flagFormPenanganan = 'insert';

                $("#modal-form-history-penanganan").modal('show');
            },
            editHistoryPenanganan(id) {
                this.$ewpLoadingShow();

                this.reset();

                this.flagFormPenanganan = 'update';


                Api().get(`daftar-klien/penanganan/` + id)
                    .then(response => {
                        this.$ewpLoadingHide();

                        let context = response.data.data;
                        this.single.formHistoryPenanganan.id = id;
                        this.single.formHistoryPenanganan.type = context.service_type;

                        setTimeout(() => {
                            this.single.formHistoryPenanganan.existingFile = context.dokumen;
                            if (context.id_pelayanan && context.pelayanan) {
                                this.single.formHistoryPenanganan.service = {
                                    id: context.pelayanan.id,
                                    text: context.pelayanan.name,
                                };
                            }

                            this.single.formHistoryPenanganan.shelter_type = context.shelter_type;
                            this.single.formHistoryPenanganan.date = context.service_date;
                            this.single.formHistoryPenanganan.note = context.description;
                        }, 300);
                        $("#modal-form-history-penanganan").modal('show');
                    })
                    .catch(error => {
                        this.$ewpLoadingHide();
                        this.$axiosHandleError(error);
                    });

            },
            saveHistoryPenanganan() {
                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }
                let formData = new FormData();

                let filesUpload = []
                if (!$.isEmptyObject(this.single.formHistoryPenanganan.dropzoneUpload.files)) {
                    for (let file in this.single.formHistoryPenanganan.dropzoneUpload.files) {
                        filesUpload.push(this.single.formHistoryPenanganan.dropzoneUpload.files[file])
                    }
                }
                formData.append('tipe_penanganan', this.single.formHistoryPenanganan.type);
                formData.append('tanggal_pelayanan', this.single.formHistoryPenanganan.date);
                formData.append('deskripsi', this.single.formHistoryPenanganan.note);
                if (this.single.formHistoryPenanganan.type == 1 || this.single.formHistoryPenanganan.type == 2) {
                    formData.append('id_pelayanan', this.single.formHistoryPenanganan.service.id);
                }

                if (this.single.formHistoryPenanganan.type == 3) {
                    formData.append('id_kebutuhan', this.single.formHistoryPenanganan.need.id);
                    formData.append('id_opd', this.single.formHistoryPenanganan.opd.id);
                    formData.append('id_intervensi', this.single.formHistoryPenanganan.intervensi.id);
                }

                if (filesUpload.length > 0) {
                    for (let x = 0; x < filesUpload.length; x++) {
                        let fileX = filesUpload[x]
                        formData.append('dokumen[]', fileX);
                    }
                }

                this.$ewpLoadingShow();
                Api().post('daftar-klien/' + this.$route.params.id + '/penanganan-kasus', formData)
                    .then(response => {
                        $(".modal").modal('hide');
                        this.getHandlingHistory();
                        this.$swal({
                            title: "Berhasil!",
                            text: 'Menambahkan data penanganan kasus klien',
                            icon: "success",
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            updateHistoryPenanganan() {
                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }

                this.$ewpLoadingShow();

                let formData = new FormData()

                formData.append('_method', 'PUT');
                formData.append('id_pelayanan', this.single.formHistoryPenanganan.service.id);
                formData.append('tanggal_pelayanan', this.single.formHistoryPenanganan.date);
                formData.append('deskripsi', this.single.formHistoryPenanganan.note);
                if (this.single.formHistoryPenanganan.service.id == 5) {
                    formData.append('shelter_type', this.single.formHistoryPenanganan.shelter_type);
                }


                let filesUpload = []
                if (!$.isEmptyObject(this.single.formHistoryPenanganan.dropzoneUpload.files)) {
                    for (let file in this.single.formHistoryPenanganan.dropzoneUpload.files) {
                        filesUpload.push(this.single.formHistoryPenanganan.dropzoneUpload.files[file])
                    }
                }

                if (filesUpload.length > 0) {
                    for (let x = 0; x < filesUpload.length; x++) {
                        let fileX = filesUpload[x]
                        formData.append('dokumen[]', fileX);
                    }
                }

                for (let x = 0; x < this.single.formHistoryPenanganan.existingFile.length; x++) {
                    formData.append('dokumen_existing[]', this.single.formHistoryPenanganan.existingFile[x]
                        .id);
                }

                Api().post('daftar-klien/penanganan/' + this.single.formHistoryPenanganan.id, formData)
                    .then(response => {
                        $(".modal").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Memperbarui data history penanganan',
                            icon: "success",
                        }).then(result => {
                            this.getHandlingHistory();

                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            getService(keyword, limit) {

                this.pageStatus = 'service-load';


                Api().get(`m-pelayanan/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {
                        this.listService = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listService.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listService = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getNeed(keyword, limit) {

                this.pageStatus = 'need-load';


                Api().get(`m-kebutuhan/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {
                        this.listNeed = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listNeed.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listNeed = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            getOPD(keyword, limit) {

                this.pageStatus = 'opd-load';


                Api().get(`m-opd/lists?limit=${limit}&search=${keyword}`)
                    .then(response => {
                        this.listOPD = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listOPD.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listOPD = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },

            getIntervensi(keyword, limit) {

                this.pageStatus = 'intervensi-load';


                Api().get(
                        `m-intervensi/lists?limit=${limit}&search=${keyword}&id_opd=${this.single.formHistoryPenanganan.opd.id}`
                    )
                    .then(response => {
                        this.listIntervensi = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listIntervensi.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.listIntervensi = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            reset() {

                this.flagFormPenanganan = 'insert';

                this.pageStatus = 'standby';

                this.v$.$reset();

                this.single.formHistoryPenanganan.type = '';
                this.single.formHistoryPenanganan.date = '';
                this.single.formHistoryPenanganan.service = {};
                this.single.formHistoryPenanganan.shelter_type = '';

                this.single.formHistoryPenanganan.need = {};
                this.single.formHistoryPenanganan.opd = {};
                this.single.formHistoryPenanganan.intervensi = {};

                this.single.formHistoryPenanganan.note = '';
                this.single.formHistoryPenanganan.existingFile = [];

                this.single.formHistoryPenanganan.dropzoneUpload.removeAllFiles(true);
                this.single.formHistoryPenanganan.dropzoneUpload.files = [];
            },
            showPreparatorStep(id, preparator) {
                if (id == 'data-pelaku') {
                    return preparator;
                } else {
                    return true;
                }
            }

        }
    }

</script>

<style scoped>
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
