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
                                                    <h4>Dokumen Pendukung</h4>
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
                                                        - Dokumen Pendukung
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-5">
                                    <div class="col-lg-5">
                                        <h1>Dokumen Pendukung</h1>
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
                                                    style="font-size:17px !important;">Unggah Dokumen Pendukung</span>
                                            </h3>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div v-if="pageStatus == 'page-load'"
                                                class="w-100 d-flex justify-content-center mt-10 mb-10">
                                                <app-loader></app-loader>
                                            </div>
                                            <div v-show="pageStatus != 'page-load'" class="row">
                                                <div class="col-lg-4 mb-5 fw-bolder">
                                                    Foto Klien
                                                </div>
                                                <div class="col-lg-8 mb-5">
                                                    <div class="dropzone dropzone-file-area dz-clickable"
                                                        id="dropzone-client-photo">
                                                        <div class="dz-message needsclick">
                                                            <i
                                                                class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <div class="ms-4">
                                                                <h5 class="kt-dropzone__msg-title">Drop files here
                                                                    or
                                                                    click
                                                                    to upload</h5>
                                                                <span class="kt-dropzone__msg-desc text-primary">
                                                                    Upload up to 10 files with the format
                                                                    .jpg/.jpeg/.png maksimum
                                                                    size file 2 MB
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-4 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                                            v-for="(contextX, indexX) in exitingPhotos.clientPhoto" :key="indexX">
                                                            <a v-if="contextX.isImage" :href="contextX.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="contextX.path" target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <div><i @click="exitingPhotos.clientPhoto.splice(indexX, 1)"
                                                                    class="fa fa-times text-danger"
                                                                    style="font-size:20px;cursor:pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-5 fw-bolder">
                                                    Foto Tempat Tinggal Klien
                                                </div>
                                                <div class="col-lg-8 mb-5">
                                                    <div class="dropzone dropzone-file-area dz-clickable"
                                                        id="dropzone-client-residence-photo">
                                                        <div class="dz-message needsclick">
                                                            <i
                                                                class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <div class="ms-4">
                                                                <h5 class="kt-dropzone__msg-title">Drop files here
                                                                    or
                                                                    click
                                                                    to upload</h5>
                                                                <span class="kt-dropzone__msg-desc text-primary">
                                                                    Upload up to 10 files with the format
                                                                    .jpg/.jpeg/.png maksimum
                                                                    size file 2 MB
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-4 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                                            v-for="(contextX, indexX) in exitingPhotos.clientResidencePhoto" :key="indexX">
                                                            <a v-if="contextX.isImage" :href="contextX.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="contextX.path" target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <div><i @click="exitingPhotos.clientResidencePhoto.splice(indexX, 1)"
                                                                    class="fa fa-times text-danger"
                                                                    style="font-size:20px;cursor:pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-5 fw-bolder">
                                                    Foto Pendampingan Awal
                                                </div>
                                                <div class="col-lg-8 mb-5">
                                                    <div class="dropzone dropzone-file-area dz-clickable"
                                                        id="dropzone-initial-monitoring-photo">
                                                        <div class="dz-message needsclick">
                                                            <i
                                                                class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <div class="ms-4">
                                                                <h5 class="kt-dropzone__msg-title">Drop files here
                                                                    or
                                                                    click
                                                                    to upload</h5>
                                                                <span class="kt-dropzone__msg-desc text-primary">
                                                                    Upload up to 10 files with the format
                                                                    .jpg/.jpeg/.png maksimum
                                                                    size file 2 MB
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-4 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                                            v-for="(contextX, indexX) in exitingPhotos.initialMonitoringPhoto" :key="indexX">
                                                            <a v-if="contextX.isImage" :href="contextX.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="contextX.path" target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <div><i @click="exitingPhotos.initialMonitoringPhoto.splice(indexX, 1)"
                                                                    class="fa fa-times text-danger"
                                                                    style="font-size:20px;cursor:pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-5 fw-bolder">
                                                    Foto Pendampingan Lanjutan
                                                </div>
                                                <div class="col-lg-8 mb-5">
                                                    <div class="dropzone dropzone-file-area dz-clickable"
                                                        id="dropzone-followup-monitoring-photo">
                                                        <div class="dz-message needsclick">
                                                            <i
                                                                class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <div class="ms-4">
                                                                <h5 class="kt-dropzone__msg-title">Drop files here
                                                                    or
                                                                    click
                                                                    to upload</h5>
                                                                <span class="kt-dropzone__msg-desc text-primary">
                                                                    Upload up to 10 files with the format
                                                                    .jpg/.jpeg/.png maksimum
                                                                    size file 2 MB
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-4 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                                            v-for="(contextX, indexX) in exitingPhotos.followUpMonitoringPhoto" :key="indexX">
                                                            <a v-if="contextX.isImage" :href="contextX.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="contextX.path" target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <div><i @click="exitingPhotos.followUpMonitoringPhoto.splice(indexX, 1)"
                                                                    class="fa fa-times text-danger"
                                                                    style="font-size:20px;cursor:pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-5 fw-bolder">
                                                    Foto Pendampingan Monitoring
                                                </div>
                                                <div class="col-lg-8 mb-5">
                                                    <div class="dropzone dropzone-file-area dz-clickable"
                                                        id="dropzone-monitoring-assistance-photo">
                                                        <div class="dz-message needsclick">
                                                            <i
                                                                class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <div class="ms-4">
                                                                <h5 class="kt-dropzone__msg-title">Drop files here
                                                                    or
                                                                    click
                                                                    to upload</h5>
                                                                <span class="kt-dropzone__msg-desc text-primary">
                                                                    Upload up to 10 files with the format
                                                                    .jpg/.jpeg/.png maksimum size file 2 MB
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-4 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                                            v-for="(contextX, indexX) in exitingPhotos.monitoringAssistancePhoto" :key="indexX">
                                                            <a v-if="contextX.isImage" :href="contextX.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="contextX.path" target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <div><i @click="exitingPhotos.monitoringAssistancePhoto.splice(indexX, 1)"
                                                                    class="fa fa-times text-danger"
                                                                    style="font-size:20px;cursor:pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-5 fw-bolder">
                                                    Foto Identitas Klien(KK)
                                                </div>
                                                <div class="col-lg-8 mb-5">
                                                    <div class="dropzone dropzone-file-area dz-clickable"
                                                        id="dropzone-identity-client-photo">
                                                        <div class="dz-message needsclick">
                                                            <i
                                                                class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <div class="ms-4">
                                                                <h5 class="kt-dropzone__msg-title">Drop files here
                                                                    or
                                                                    click
                                                                    to upload</h5>
                                                                <span class="kt-dropzone__msg-desc text-primary">
                                                                    Upload up to 10 files with the format
                                                                    .jpg/.jpeg/.png maksimum size file 2 MB
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-4 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                                            v-for="(contextX, indexX) in exitingPhotos.identityClientPhoto" :key="indexX">
                                                            <a v-if="contextX.isImage" :href="contextX.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="contextX.path" target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <div><i @click="exitingPhotos.identityClientPhoto.splice(indexX, 1)"
                                                                    class="fa fa-times text-danger"
                                                                    style="font-size:20px;cursor:pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-4 mb-5 fw-bolder">
                                                    Dokumen Pendukung
                                                </div>
                                                <div class="col-lg-8 mb-5">
                                                    <div class="dropzone dropzone-file-area dz-clickable"
                                                        id="dropzone-dokumen-pendukung">
                                                        <div class="dz-message needsclick">
                                                            <i
                                                                class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <div class="ms-4">
                                                                <h5 class="kt-dropzone__msg-title">Drop files here
                                                                    or
                                                                    click
                                                                    to upload</h5>
                                                                <span class="kt-dropzone__msg-desc text-primary">
                                                                    Upload up to 10 files with the format
                                                                    .pdf maksimum size file 2 MB
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-4 col-md-6 mb-5 d-flex justify-content-between align-items-center"
                                                            v-for="(contextX, indexX) in exitingPhotos.dokumenPendukung" :key="indexX">
                                                            <a v-if="contextX.isImage" :href="contextX.path"
                                                                data-fancybox="gallery">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_img.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a :href="contextX.path" target="_blank" v-else>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <img :src="$assetUrl() + 'extends/img/ic_files_pdf.png'"
                                                                            style="width:35px;" />
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bolder text-primary"
                                                                            style="word-break: break-word;">
                                                                            {{$noNullable(contextX.name)}}
                                                                        </div>
                                                                        <div class="text-gray-500">
                                                                            {{$formatBytes(contextX.size)}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <div><i @click="exitingPhotos.dokumenPendukung.splice(indexX, 1)"
                                                                    class="fa fa-times text-danger"
                                                                    style="font-size:20px;cursor:pointer;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
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
                dropzoneClientPhoto: null,
                dropzoneClientResidencePhoto: null,
                dropzoneInitialMonitoringPhoto: null,
                dropzoneFollowUpMonitoringPhoto: null,
                dropzoneMonitoringAssistancePhoto: null,
                dropzoneIdentityClientPhoto: null,
                dropzoneDokumenPendukung: null,
                idPenjangkauan: this.$route.params.idPenjangkauan,
                exitingPhotos: {
                    clientPhoto: [],
                    clientResidencePhoto: [],
                    initialMonitoringPhoto: [],
                    followUpMonitoringPhoto: [],
                    monitoringAssistancePhoto: [],
                    identityClientPhoto: [],
                    dokumenPendukung: []
                }
            }

        },
        mounted() {
            reinitializeAllPlugin();

            this.initDropzone();

            this.pageStatus = 'page-load';

            this.$store.dispatch('complaint/getDetailComplaintOutreachSupportingDocuments', this.$route.params
                .idPenjangkauan).then((res) => {
                if (res.status == 200 || res.status == 201) {
                    this.exitingPhotos.clientPhoto = res.data.data.foto_klien ? res.data.data.foto_klien : [];
                    this.exitingPhotos.clientResidencePhoto = res.data.data.foto_tempat_tinggal_klien ? res.data
                        .data.foto_tempat_tinggal_klien : [];
                    this.exitingPhotos.initialMonitoringPhoto = res.data.data.foto_pendampingan_awal_klien ? res
                        .data.data.foto_pendampingan_awal_klien : [];
                    this.exitingPhotos.followUpMonitoringPhoto = res.data.data
                        .foto_pendampingan_lanjutan_klien ? res.data.data.foto_pendampingan_lanjutan_klien : [];
                    this.exitingPhotos.monitoringAssistancePhoto = res.data.data
                        .foto_pendampingan_monitoring_klien ? res.data.data.foto_pendampingan_monitoring_klien :
                        [];
                    this.exitingPhotos.identityClientPhoto = res.data.data.foto_identitas_klien ? res.data.data
                        .foto_identitas_klien : [];

                    this.exitingPhotos.dokumenPendukung = res.data.data.surat ? res.data.data
                        .surat : [];
                } else {
                    this.$axiosHandleError(res);
                }

                setTimeout(() => {
                    this.pageStatus = 'standby';
                }, 1000);
            });
        },
        beforeRouteLeave(to, from, next) {
            this.dropzoneClientPhoto.destroy();
            this.dropzoneClientResidencePhoto.destroy();
            this.dropzoneInitialMonitoringPhoto.destroy();
            this.dropzoneFollowUpMonitoringPhoto.destroy();
            this.dropzoneMonitoringAssistancePhoto.destroy();
            this.dropzoneIdentityClientPhoto.destroy();
            this.dropzoneDokumenPendukung.destroy();
            next();
        },
        methods: {
            initDropzone() {
                const that = this;
                this.dropzoneClientPhoto = new Dropzone("#dropzone-client-photo", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 2,
                    parallelUploads: 1,
                    uploadMultiple: false,
                    maxFiles: 20,
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

                this.dropzoneClientResidencePhoto = new Dropzone("#dropzone-client-residence-photo", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 2,
                    parallelUploads: 1,
                    uploadMultiple: false,
                    maxFiles: 20,
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

                this.dropzoneInitialMonitoringPhoto = new Dropzone("#dropzone-initial-monitoring-photo", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 2,
                    parallelUploads: 1,
                    uploadMultiple: false,
                    maxFiles: 20,
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

                this.dropzoneFollowUpMonitoringPhoto = new Dropzone("#dropzone-followup-monitoring-photo", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 2,
                    parallelUploads: 1,
                    uploadMultiple: false,
                    maxFiles: 20,
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

                this.dropzoneMonitoringAssistancePhoto = new Dropzone("#dropzone-monitoring-assistance-photo", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 2,
                    parallelUploads: 1,
                    uploadMultiple: false,
                    maxFiles: 20,
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

                this.dropzoneIdentityClientPhoto = new Dropzone("#dropzone-identity-client-photo", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 2,
                    parallelUploads: 1,
                    uploadMultiple: false,
                    maxFiles: 20,
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

                this.dropzoneDokumenPendukung = new Dropzone("#dropzone-dokumen-pendukung", {
                    url: "/",
                    dictCancelUpload: "Cancel",
                    maxFilesize: 2,
                    parallelUploads: 1,
                    uploadMultiple: false,
                    maxFiles: 20,
                    addRemoveLinks: true,
                    acceptedFiles: '.pdf',
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

                let formData = new FormData()

                formData.append('is_publish', is_publish);

                if (!$.isEmptyObject(this.dropzoneClientPhoto.files)) {
                    for (let file in this.dropzoneClientPhoto.files) {
                        formData.append('foto_klien[]', this.dropzoneClientPhoto.files[file]);
                    }
                }

                if (!$.isEmptyObject(this.dropzoneClientResidencePhoto.files)) {
                    for (let file in this.dropzoneClientResidencePhoto.files) {
                        formData.append('foto_tempat_tinggal_klien[]', this.dropzoneClientResidencePhoto.files[file]);
                    }
                }

                if (!$.isEmptyObject(this.dropzoneInitialMonitoringPhoto.files)) {
                    for (let file in this.dropzoneInitialMonitoringPhoto.files) {
                        formData.append('foto_pendampingan_awal_klien[]', this.dropzoneInitialMonitoringPhoto.files[
                            file]);
                    }
                }

                if (!$.isEmptyObject(this.dropzoneFollowUpMonitoringPhoto.files)) {
                    for (let file in this.dropzoneFollowUpMonitoringPhoto.files) {
                        formData.append('foto_pendampingan_lanjutan_klien[]', this.dropzoneFollowUpMonitoringPhoto
                            .files[file]);
                    }
                }

                if (!$.isEmptyObject(this.dropzoneMonitoringAssistancePhoto.files)) {
                    for (let file in this.dropzoneMonitoringAssistancePhoto.files) {
                        formData.append('foto_pendampingan_monitoring_klien[]', this.dropzoneMonitoringAssistancePhoto
                            .files[file]);
                    }
                }

                if (!$.isEmptyObject(this.dropzoneIdentityClientPhoto.files)) {
                    for (let file in this.dropzoneIdentityClientPhoto.files) {
                        formData.append('foto_identitas_klien[]', this.dropzoneIdentityClientPhoto.files[file]);
                    }
                }

                if (!$.isEmptyObject(this.dropzoneDokumenPendukung.files)) {
                    for (let file in this.dropzoneDokumenPendukung.files) {
                        formData.append('surat[]', this.dropzoneDokumenPendukung.files[file]);
                    }
                }

                if (this.exitingPhotos.clientPhoto) {
                    for (let i = 0; i < this.exitingPhotos.clientPhoto.length; i++) {
                        formData.append('foto_klien_existing[]', this.exitingPhotos.clientPhoto[i].id);
                    }
                }


                if (this.exitingPhotos.clientResidencePhoto) {
                    for (let i = 0; i < this.exitingPhotos.clientResidencePhoto.length; i++) {
                        formData.append('foto_tempat_tinggal_klien_existing[]', this.exitingPhotos.clientResidencePhoto[
                                i]
                            .id);
                    }
                }


                if (this.exitingPhotos.initialMonitoringPhoto) {
                    for (let i = 0; i < this.exitingPhotos.initialMonitoringPhoto.length; i++) {
                        formData.append('foto_pendampingan_awal_klien_existing[]', this.exitingPhotos
                            .initialMonitoringPhoto[i].id);
                    }
                }

                if (this.exitingPhotos.followUpMonitoringPhoto) {
                    for (let i = 0; i < this.exitingPhotos.followUpMonitoringPhoto.length; i++) {
                        formData.append('foto_pendampingan_lanjutan_klien_existing[]', this.exitingPhotos
                            .followUpMonitoringPhoto[i].id);
                    }
                }


                if (this.exitingPhotos.monitoringAssistancePhoto) {
                    for (let i = 0; i < this.exitingPhotos.monitoringAssistancePhoto.length; i++) {
                        formData.append('foto_pendampingan_monitoring_klien_existing[]', this.exitingPhotos
                            .monitoringAssistancePhoto[i].id);
                    }
                }

                if (this.exitingPhotos.identityClientPhoto) {
                    for (let i = 0; i < this.exitingPhotos.identityClientPhoto.length; i++) {
                        formData.append('foto_identitas_klien_existing[]', this.exitingPhotos.identityClientPhoto[i]
                            .id);
                    }
                }

                if (this.exitingPhotos.dokumenPendukung) {
                    for (let i = 0; i < this.exitingPhotos.dokumenPendukung.length; i++) {
                        formData.append('surat_existing[]', this.exitingPhotos.dokumenPendukung[i]
                            .id);
                    }
                }


                this.$ewpLoadingShow();

                Api().post('penjangkauan/' + this.$route.params.idPenjangkauan + '/dokumen-pendukung', formData)
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
        }
    }

</script>

<style scoped>

</style>
