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
                                <!-- start -->
                                <div>
                                    <div class="row align-items-center mt-5">
                                        <div class="col-lg-8">
                                            <h1>Detail Pengunjung</h1>
                                        </div>
                                        <div
                                            class="col-lg-4 d-flex"
                                            style="justify-content: flex-end"
                                        >
                                            <button
                                                type="button"
                                                class="btn"
                                                style="
                                                    background-color: #fff8dd;
                                                "
                                                @click="
                                                    $router.push({
                                                        name: 'buku-tamu-dashboard',
                                                    })
                                                "
                                            >
                                                <span
                                                    class="text-warning d-flex"
                                                >
                                                    <svg
                                                        width="22"
                                                        height="22"
                                                        viewBox="0 0 22 22"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            opacity="0.3"
                                                            d="M17.4166 10.0846C17.9228 10.0846 18.3333 10.495 18.3333 11.0013C18.3333 11.5076 17.9228 11.918 17.4166 11.918H10.0833C9.57699 11.918 9.16658 11.5076 9.16658 11.0013C9.16658 10.495 9.57699 10.0846 10.0833 10.0846H17.4166Z"
                                                            fill="#FFA800"
                                                        />
                                                        <path
                                                            d="M11.6481 15.8531C12.0061 16.2111 12.0061 16.7915 11.6481 17.1495C11.2901 17.5075 10.7097 17.5075 10.3517 17.1495L4.85174 11.6495C4.50471 11.3025 4.49257 10.7437 4.8242 10.3819L9.86586 4.88189C10.208 4.5087 10.7878 4.48349 11.161 4.82558C11.5342 5.16767 11.5594 5.74752 11.2173 6.12072L6.76871 10.9737L11.6481 15.8531Z"
                                                            fill="#FFA800"
                                                        />
                                                    </svg>
                                                    Kembali
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex justify-content-center flex-wrap mb-10 mt-5"
                                    >
                                        <a
                                            href="javascript:void(0)"
                                            class="text-gray-800 py-2 px-4"
                                            style="
                                                font-size: 15px;
                                                border-radius: 5px;
                                            "
                                            @click="flagTab = 'penerimaan'"
                                            :class="
                                                flagTab == 'penerimaan'
                                                    ? 'bg-primary-custom text-white'
                                                    : ''
                                            "
                                        >
                                            Penerimaan
                                        </a>

                                        <a
                                            href="javascript:void(0)"
                                            class="text-gray-800 py-2 px-4"
                                            style="
                                                font-size: 15px;
                                                border-radius: 5px;
                                            "
                                            @click="
                                                flagTab =
                                                    'identifikasi-kebutuhan'
                                            "
                                            :class="
                                                flagTab ==
                                                'identifikasi-kebutuhan'
                                                    ? 'bg-primary-custom text-white'
                                                    : ''
                                            "
                                        >
                                            Identifikasi Kebutuhan
                                        </a>

                                        <a
                                            v-if="identifikasiKebutuhan.id"
                                            href="javascript:void(0)"
                                            class="text-gray-800 py-2 px-4"
                                            style="font-size: 15px; border-radius: 5px;"
                                            @click="flagTab = 'form-kebutuhan'"
                                            :class="flagTab == 'form-kebutuhan' ? 'bg-primary-custom text-white' : ''"
                                            >
                                            Form Kebutuhan
                                        </a>

                                    </div>
                                    
                                    <div
                                        class="card card-flush mt-5 mb-5 mb-xl-10"
                                        id="kt_profile_details_view"
                                        v-if="flagTab == 'form-kebutuhan'"
                                    >
                                        <div
                                            v-if="pageStatus === 'loading'"
                                            class="w-100 d-flex justify-content-center mt-10 mb-10"
                                        >
                                            <app-loader></app-loader>
                                        </div>

                                        <div v-else>
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
                                                        >Form Kebutuhan<span
                                                            class="c-primary-custom ps-3"
                                                        ></span
                                                        >&ensp;<span
                                                            class="badge"
                                                        ></span
                                                    ></span>
                                                </h3>
                                            </div>
                                            <div v-for="(selectedLayanan, index) in layananBukuTamu"
                                                :key="index" class="card-body pt-5">
                                                <div class="accordion" :id="'kt_accordion_' + index">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" :id="'kt_accordion_header_' + index">
                                                            <button class="accordion-button fs-4 fw-semibold" type="button"
                                                                data-bs-toggle="collapse"
                                                                :data-bs-target="'#kt_accordion_body_' + index"
                                                                aria-expanded="true"  
                                                                :aria-controls="'kt_accordion_body_' + index">
                                                                Layanan {{ selectedLayanan.name }}
                                                            </button>
                                                        </h2>
                                                        <div
                                                            :id="'kt_accordion_body_' + index"
                                                            class="accordion-collapse collapse show" 
                                                            :aria-labelledby="'kt_accordion_header_' + index"
                                                            :data-bs-parent="'#kt_accordion_' + index"
                                                        >
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        <div class="row">
                                                                            <div class="col-lg-4 text-gray-600 mb-5">
                                                                                Layanan
                                                                            </div>
                                                                            <div class="col-lg-8 mb-5 fw-bolder">
                                                                                <div class="badge bg-success text-dark">
                                                                                    {{ selectedLayanan.name }}
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                v-if="
                                                                                    [
                                                                                        1, 2, 8, 9, 10, 11, 13, 14, 15,
                                                                                    ].includes(selectedLayanan.layanan_id)
                                                                                "
                                                                            >
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-lg-4 text-gray-600 mb-5"
                                                                                    >
                                                                                        Keterangan
                                                                                    </div>
                                                                                    <div class="col-lg-8 mb-5 fw-bolder">
                                                                                        {{
                                                                                            selectedLayanan.singkat_keterangan ||
                                                                                            "Belum Diisi"
                                                                                        }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div v-if="selectedLayanan.layanan_id === 3">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-lg-4 text-gray-600 mb-5"
                                                                                    >
                                                                                        Tujuan Rujukan
                                                                                    </div>
                                                                                    <div class="col-lg-8 mb-5 fw-bolder">
                                                                                        <template
                                                                                            v-if="
                                                                                                selectedLayanan.rujukan_tujuan
                                                                                            "
                                                                                        >
                                                                                            {{
                                                                                                selectedLayanan.rujukan_tujuan
                                                                                            }}
                                                                                        </template>
                                                                                        <div v-else class="text-muted">
                                                                                            Belum Diisi
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div v-if="[4, 5, 6, 7].includes(selectedLayanan.layanan_id)">
                                                                                <div class="row">
                                                                                    <div class="col-lg-4 text-gray-600 mb-5">Nomor Telepon</div>
                                                                                    <div class="col-lg-8 mb-5 fw-bolder">
                                                                                        <template v-if="selectedLayanan.telekonsultasi_nomor">
                                                                                            {{ selectedLayanan.telekonsultasi_nomor }}
                                                                                        </template>
                                                                                        <div v-else class="text-muted">Belum Diisi</div>
                                                                                    </div>
                                                                                    <div class="col-lg-4 text-gray-600 mb-5">Jadwal Konsultasi</div>
                                                                                    <div class="col-lg-8 mb-5 fw-bolder">
                                                                                        <span
                                                                                            :class="{
                                                                                                'text-muted': !selectedLayanan.telekonsultasi_jadwal,
                                                                                            }"
                                                                                        >
                                                                                            {{
                                                                                                selectedLayanan.telekonsultasi_jadwal
                                                                                                    ? new Date(
                                                                                                        selectedLayanan.telekonsultasi_jadwal
                                                                                                    ).toLocaleString("id-ID", {
                                                                                                        weekday: "long",
                                                                                                        day: "2-digit",
                                                                                                        month: "long",
                                                                                                        year: "numeric",
                                                                                                        hour: "2-digit",
                                                                                                        minute: "2-digit",
                                                                                                        hour12: false,
                                                                                                    })
                                                                                                    : "Belum Diisi"
                                                                                            }}
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="col-lg-4 text-gray-600 mb-5">Keluhan</div>
                                                                                    <div class="col-lg-8 mb-5 fw-bolder">
                                                                                        <template v-if="selectedLayanan.telekonsultasi_keluhan">
                                                                                            {{ selectedLayanan.telekonsultasi_keluhan }}
                                                                                        </template>
                                                                                        <div v-else class="text-muted">Belum Diisi</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        v-if="
                                                                            !selectedLayanan.is_filled &&
                                                                            [1, 2, 8, 9, 10, 11, 13, 14, 15].includes(
                                                                                selectedLayanan.layanan_id
                                                                            )
                                                                        "
                                                                        class="col-lg-2"
                                                                    >
                                                                        <button 
                                                                            v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID])"
                                                                            type="button"
                                                                            class="btn btn-sm bg-primary-custom"
                                                                            @click="
                                                                                openSingkatModal(
                                                                                    selectedLayanan.kebutuhan_layanan_id
                                                                                )
                                                                            "
                                                                        >
                                                                            <span class="text-white">Isi Form</span>
                                                                        </button>
                                                                    </div>
                                                                    <div
                                                                        v-if="
                                                                            selectedLayanan.is_filled &&
                                                                            [1, 2, 8, 9, 10, 11, 13, 14, 15].includes(
                                                                                selectedLayanan.layanan_id
                                                                            )
                                                                        "
                                                                        class="col-lg-2"
                                                                    >
                                                                        <div class="row g-2">
                                                                            <div class="col-auto">
                                                                                <button
                                                                                    v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID])"
                                                                                    type="button"
                                                                                    class="btn btn-sm bg-primary-custom w-100 mb-2"
                                                                                    @click="
                                                                                        editSingkatModal(
                                                                                             selectedLayanan.singkat_id
                                                                                        )
                                                                                    "
                                                                                >
                                                                                    <span class="text-white">Update</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <button
                                                                                    type="button"
                                                                                    class="btn btn-sm c-primary-custom w-100 mb-2"
                                                                                    style="
                                                                                        background: #fff4dd !important;
                                                                                        color: #ee7b33 !important;
                                                                                    "
                                                                                    @click="
                                                                                        $router.push({
                                                                                            name: 'form-cetak',
                                                                                            params: {
                                                                                                id: selectedLayanan.kebutuhan_layanan_id,
                                                                                            },
                                                                                        })
                                                                                    "
                                                                                >
                                                                                    <span> Cetak </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        v-if="!selectedLayanan.is_filled && [4, 5, 6, 7].includes(selectedLayanan.layanan_id)"
                                                                        class="col-lg-2"
                                                                    >
                                                                        <button
                                                                            v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID])"
                                                                            type="button"
                                                                            class="btn btn-sm bg-primary-custom"
                                                                            @click="
                                                                                openTelekonsultasiModal(
                                                                                    selectedLayanan.kebutuhan_layanan_id
                                                                                )
                                                                            "
                                                                        >
                                                                            <span class="text-white">Isi Form</span>
                                                                        </button>
                                                                    </div>
                                                                    <div
                                                                        v-if="selectedLayanan.is_filled && [4, 5, 6, 7].includes(selectedLayanan.layanan_id)"
                                                                        class="col-lg-2"
                                                                    >
                                                                        <div class="row g-2">
                                                                            <div class="col">
                                                                                <button
                                                                                    type="button"
                                                                                    class="btn btn-sm bg-primary-custom w-100 mb-2"
                                                                                    @click="
                                                                                        editTelekonsultasiModal(
                                                                                            selectedLayanan.telekonsultasi_id
                                                                                        )
                                                                                    "
                                                                                >
                                                                                    <span class="text-white">Update</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="col">
                                                                                <button
                                                                                    type="button"
                                                                                    class="btn btn-sm c-primary-custom w-100 mb-2"
                                                                                    style="
                                                                                        background: #fff4dd !important;
                                                                                        color: #ee7b33 !important;
                                                                                    "
                                                                                    @click="
                                                                                        $router.push({
                                                                                            name: 'form-cetak',
                                                                                            params: {
                                                                                                id: selectedLayanan.kebutuhan_layanan_id,
                                                                                            },
                                                                                        })
                                                                                    "
                                                                                >
                                                                                    <span> Cetak </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        v-if="
                                                                            !selectedLayanan.is_filled &&
                                                                            selectedLayanan.layanan_id === 3
                                                                        "
                                                                        class="col-lg-2"
                                                                    >
                                                                        <button 
                                                                            v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID])"
                                                                            type="button"
                                                                            class="btn btn-sm bg-primary-custom"
                                                                            @click="
                                                                                openRujukanModal(
                                                                                    selectedLayanan.kebutuhan_layanan_id
                                                                                )
                                                                            "
                                                                        >
                                                                            <span class="text-white">Isi Form</span>
                                                                        </button>
                                                                    </div>
                                                                    <div
                                                                        v-if="
                                                                            selectedLayanan.is_filled &&
                                                                            selectedLayanan.layanan_id === 3
                                                                        "
                                                                        class="col-lg-2"
                                                                    >
                                                                        <div class="row g-2">
                                                                            <div class="col">
                                                                                <button
                                                                                    type="button"
                                                                                    class="btn btn-sm bg-primary-custom w-100 mb-2"
                                                                                    @click="
                                                                                        editRujukanModal(
                                                                                            selectedLayanan.rujukan_id
                                                                                        )
                                                                                    "
                                                                                >
                                                                                    <span class="text-white">Update</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="col">
                                                                                <button
                                                                                    type="button"
                                                                                    class="btn btn-sm c-primary-custom w-100 mb-2"
                                                                                    style="
                                                                                        background: #fff4dd !important;
                                                                                        color: #ee7b33 !important;
                                                                                    "
                                                                                    @click="
                                                                                        $router.push({
                                                                                            name: 'form-cetak',
                                                                                            params: {
                                                                                                id: selectedLayanan.kebutuhan_layanan_id,
                                                                                            },
                                                                                        })
                                                                                    "
                                                                                >
                                                                                    <span> Cetak </span>
                                                                                </button>
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

                                    <div
                                        class="card card-flush mt-5 mb-5 mb-xl-10"
                                        id="kt_profile_details_view"
                                        v-if="
                                            flagTab == 'identifikasi-kebutuhan'
                                        "
                                    >
                                        <!-- Loader while data is being fetched -->
                                        <div
                                            v-if="pageStatus === 'loading'"
                                            class="w-100 d-flex justify-content-center mt-10 mb-10"
                                        >
                                            <app-loader></app-loader>
                                        </div>

                                        <!-- Content displays when data has been fetched -->
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
                                                        >Identifikasi
                                                        Kebutuhan<span
                                                            class="c-primary-custom ps-3"
                                                        ></span
                                                        >&ensp;<span
                                                            class="badge"
                                                        ></span
                                                    ></span>
                                                </h3>
                                                <div
                                                    class="card-title align-items-start flex-column"
                                                >
                                                <div v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID])">
                                                <button
                                                    v-if="!identifikasiKebutuhan?.id" 
                                                    type="button"
                                                    class="btn btn-sm bg-primary-custom"
                                                    @click="identifikasiSubmit"
                                                >
                                                    <span 
                                                    class="text-white">Identifikasi</span>
                                                </button>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-auto">
                                                        <div v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID])">
                                                        <button
                                                            v-if="identifikasiKebutuhan?.id"
                                                            type="button"
                                                            class="btn btn-sm bg-primary-custom"
                                                            @click="identifikasiEdit()"
                                                        >
                                                            <span 
                                                            class="text-white">Update</span>
                                                        </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button
                                                            v-if="identifikasiKebutuhan?.id"
                                                            type="button"
                                                            class="btn btn-sm c-primary-custom w-auto px-3 py-2 d-flex align-items-center"
                                                            style="background: #fff4dd !important; color: #ee7b33 !important;"
                                                            @click="
                                                                $router.push({
                                                                    name: 'identifikasi-cetak',
                                                                    params: {
                                                                        id: bukuTamu.id,
                                                                    },
                                                                })
                                                            "
                                                        >
                                                            <span class="d-flex align-items-center">
                                                                <svg
                                                                    width="22"
                                                                    height="23"
                                                                    viewBox="0 0 22 23"
                                                                    fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                >
                                                                    <path
                                                                        opacity="0.3"
                                                                        d="M5.36913 2.33203H12.5918C12.9169 2.33203 13.2315 2.44724 13.4798 2.65721L17.8464 6.35064C18.1553 6.6119 18.3334 6.99592 18.3334 7.40047V18.9084C18.3334 20.5497 18.3147 20.6654 16.631 20.6654H5.36913C3.68549 20.6654 3.66675 20.5497 3.66675 18.9084V4.08898C3.66675 2.44765 3.68549 2.33203 5.36913 2.33203Z"
                                                                        fill="#EE7B33"
                                                                    />
                                                                    <path
                                                                        fill-rule="evenodd"
                                                                        clip-rule="evenodd"
                                                                        d="M8.20541 13.1654H9.99885V15.0057C9.99885 15.2589 10.2041 15.4641 10.4572 15.4641H11.3952C11.6483 15.4641 11.8535 15.2589 11.8535 15.0057V13.1654H13.647C13.9001 13.1654 14.1053 12.9602 14.1053 12.707C14.1053 12.5986 14.0668 12.4936 13.9968 12.4109L11.276 9.19734C11.1124 9.00415 10.8232 8.98014 10.63 9.1437C10.6107 9.16007 10.5928 9.17801 10.5764 9.19734L7.85562 12.4109C7.69205 12.604 7.71606 12.8933 7.90925 13.0568C7.99202 13.1269 8.09696 13.1654 8.20541 13.1654Z"
                                                                        fill="#EE7B33"
                                                                    />
                                                                </svg>
                                                                &ensp;Cetak Data
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>

                                                </div>
                                            </div>
                                            <div class="card-body pt-5">
                                                <h4
                                                    class="c-primary-custom fw-bolder pb-2"
                                                >
                                                    Waktu Identifikasi Kebutuhan
                                                </h4>
                                                <div class="row">
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Jam & Tanggal
                                                        Identifikasi
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        <template
                                                            v-if="
                                                                identifikasiKebutuhan.tgl_identifikasi
                                                            "
                                                        >
                                                            <span
                                                                class="fw-bold"
                                                            >
                                                                {{
                                                                    new Date(
                                                                        identifikasiKebutuhan.tgl_identifikasi
                                                                    ).toLocaleTimeString(
                                                                        "id-ID",
                                                                        {
                                                                            hour: "2-digit",
                                                                            minute: "2-digit",
                                                                            second: "2-digit",
                                                                            hour12: false,
                                                                        }
                                                                    )
                                                                }}
                                                                WIB
                                                            </span>
                                                            <br />
                                                            <span>
                                                                {{
                                                                    new Date(
                                                                        identifikasiKebutuhan.tgl_identifikasi
                                                                    ).toLocaleDateString(
                                                                        "id-ID",
                                                                        {
                                                                            day: "2-digit",
                                                                            month: "long",
                                                                            year: "numeric",
                                                                        }
                                                                    )
                                                                }}
                                                            </span>
                                                        </template>
                                                        <template v-else>
                                                            <span
                                                                class="text-muted"
                                                                >Belum
                                                                diisi</span
                                                            >
                                                        </template>
                                                    </div>
                                                </div>
                                                <hr
                                                    style="
                                                        background-color: #8f8d8d !important;
                                                    "
                                                />
                                                <div class="row">
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Pemberian Dukungan
                                                        Psikologis Awal (DPA)
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        <template
                                                            v-if="
                                                                identifikasiKebutuhan.dpa ===
                                                                true
                                                            "
                                                        >
                                                            Terdapat narasi
                                                            singkat DPA yang
                                                            dilakukan
                                                        </template>
                                                        <template
                                                            v-else-if="
                                                                identifikasiKebutuhan.dpa ===
                                                                false
                                                            "
                                                        >
                                                            Tidak ada isian
                                                        </template>
                                                        <template v-else>
                                                            <span
                                                                class="text-muted"
                                                                >Belum
                                                                diisi</span
                                                            >
                                                        </template>
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Narasi
                                                    </div>
                                                    <div class="col-lg-8 fw-bolder mb-5">
                                                        <template v-if="identifikasiKebutuhan.dpa == 1">
                                                            <div v-if="identifikasiKebutuhan.narasi">
                                                                {{ identifikasiKebutuhan.narasi }}
                                                            </div>
                                                            <div v-else>
                                                                <span class="text-muted">Belum diisi</span>
                                                            </div>
                                                        </template>
                                                        <template v-else-if="identifikasiKebutuhan.dpa == 0">
                                                            -
                                                        </template>
                                                        <template v-else>
                                                            <span class="text-muted">Belum diisi</span>
                                                        </template>
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Hasil Assesment /
                                                        Wawancara Singkat
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        <template
                                                            v-if="
                                                                identifikasiKebutuhan.hasil_assesment
                                                            "
                                                        >
                                                            {{
                                                                identifikasiKebutuhan.hasil_assesment
                                                            }}
                                                        </template>
                                                        <template v-else>
                                                            <span
                                                                class="text-muted"
                                                                >Belum
                                                                diisi</span
                                                            >
                                                        </template>
                                                    </div>

                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Disposisi Pimpinan
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        <template
                                                            v-if="
                                                                identifikasiKebutuhan.disposisi_pimpinan ===
                                                                true
                                                            "
                                                        >
                                                            Warga Surabaya
                                                            (Berikan layanan
                                                            puspaga sesuai
                                                            kebutuhan klien)<br />
                                                            Layanan yang
                                                            dibutuhkan:
                                                            <div
                                                                class="mt-2"
                                                                v-if="
                                                                    bukuTamu
                                                                        .m_kebutuhan_layanan_id
                                                                        .length >
                                                                    0
                                                                "
                                                            >
                                                                <div
                                                                    v-for="(
                                                                        item,
                                                                        index
                                                                    ) in bukuTamu.kebutuhan_layanan"
                                                                    :key="index"
                                                                > <div class="badge bg-success text-dark mb-2">
                                                                    {{
                                                                        index +
                                                                        1
                                                                    }}.
                                                                    {{ item.name }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div v-else>
                                                                <span
                                                                    class="text-muted"
                                                                    >Tidak ada
                                                                    kebutuhan
                                                                    layanan</span
                                                                >
                                                            </div>
                                                        </template>
                                                        <template
                                                            v-else-if="
                                                                identifikasiKebutuhan.disposisi_pimpinan ===
                                                                false
                                                            "
                                                        >
                                                            Jika Warga Non
                                                            Surabaya (Berikan
                                                            layanan puspaga
                                                            sesuai ketentuan)<br />
                                                            Layanan yang
                                                            dibutuhkan:
                                                            <div
                                                                v-if="
                                                                    bukuTamu
                                                                        .m_kebutuhan_layanan_id
                                                                        .length >
                                                                    0
                                                                "
                                                            >
                                                                <div
                                                                    v-for="(
                                                                        item,
                                                                        index
                                                                    ) in bukuTamu.kebutuhan_layanan"
                                                                    :key="index"
                                                                    class="mb-3"
                                                                >
                                                                    {{
                                                                        index +
                                                                        1
                                                                    }}.
                                                                    {{ item.name }}
                                                                </div>
                                                            </div>
                                                            <div v-else>
                                                                <span
                                                                    class="text-muted"
                                                                    >Tidak ada
                                                                    kebutuhan
                                                                    layanan</span
                                                                >
                                                            </div>
                                                        </template>
                                                        <template v-else>
                                                            <span
                                                                class="text-muted"
                                                                >Belum
                                                                diisi</span
                                                            >
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div
                                        class="card card-flush mt-5 mb-5 mb-xl-10"
                                        id="kt_profile_details_view"
                                        v-if="flagTab == 'penerimaan'"
                                    >
                                        <div
                                            v-if="pageStatus === 'loading'"
                                            class="w-100 d-flex justify-content-center mt-10 mb-10"
                                        >
                                            <app-loader></app-loader>
                                        </div>

                                        <div
                                            class="card card-xl-stretch mb-5 mb-xl-8"
                                            v-else
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
                                                        >Penerimaan<span
                                                            class="c-primary-custom ps-3"
                                                        ></span
                                                        >&ensp;<span
                                                            class="badge"
                                                        ></span
                                                    ></span>
                                                </h3>
                                                <div class="row mt-3">
                                                    <div class="col-auto">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm c-primary-custom w-auto px-3 py-2 d-flex align-items-center"
                                                            style="background: #fff4dd !important; color: #ee7b33 !important;"
                                                            @click="
                                                                $router.push({
                                                                    name: 'penerimaan-cetak',
                                                                    params: {
                                                                        id: bukuTamu.id,
                                                                    },
                                                                })
                                                            "
                                                        >
                                                            <span class="d-flex align-items-center">
                                                                <svg
                                                                    width="22"
                                                                    height="23"
                                                                    viewBox="0 0 22 23"
                                                                    fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                >
                                                                    <path
                                                                        opacity="0.3"
                                                                        d="M5.36913 2.33203H12.5918C12.9169 2.33203 13.2315 2.44724 13.4798 2.65721L17.8464 6.35064C18.1553 6.6119 18.3334 6.99592 18.3334 7.40047V18.9084C18.3334 20.5497 18.3147 20.6654 16.631 20.6654H5.36913C3.68549 20.6654 3.66675 20.5497 3.66675 18.9084V4.08898C3.66675 2.44765 3.68549 2.33203 5.36913 2.33203Z"
                                                                        fill="#EE7B33"
                                                                    />
                                                                    <path
                                                                        fill-rule="evenodd"
                                                                        clip-rule="evenodd"
                                                                        d="M8.20541 13.1654H9.99885V15.0057C9.99885 15.2589 10.2041 15.4641 10.4572 15.4641H11.3952C11.6483 15.4641 11.8535 15.2589 11.8535 15.0057V13.1654H13.647C13.9001 13.1654 14.1053 12.9602 14.1053 12.707C14.1053 12.5986 14.0668 12.4936 13.9968 12.4109L11.276 9.19734C11.1124 9.00415 10.8232 8.98014 10.63 9.1437C10.6107 9.16007 10.5928 9.17801 10.5764 9.19734L7.85562 12.4109C7.69205 12.604 7.71606 12.8933 7.90925 13.0568C7.99202 13.1269 8.09696 13.1654 8.20541 13.1654Z"
                                                                        fill="#EE7B33"
                                                                    />
                                                                </svg>
                                                                &ensp;Cetak Data
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="card-body pt-5">
                                                <h4
                                                    class="c-primary-custom fw-bolder pb-2"
                                                >
                                                    Waktu Penerimaan
                                                </h4>
                                                <div class="row">
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Nomor Pendaftaran
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    > <div class="badge bg-primary text-dark">
                                                        {{
                                                            bukuTamu.nomor_pendaftaran
                                                        }}
                                                    </div>
                                                        
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Jam & Tanggal Penerimaan
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        <div>
                                                            <span
                                                                class="fw-bold"
                                                            >
                                                                {{
                                                                    new Date(
                                                                        bukuTamu.tgl_penerimaan
                                                                    ).toLocaleTimeString(
                                                                        "id-ID",
                                                                        {
                                                                            hour: "2-digit",
                                                                            minute: "2-digit",
                                                                            second: "2-digit",
                                                                            hour12: false,
                                                                        }
                                                                    )
                                                                }}
                                                                WIB
                                                            </span>
                                                            <br />
                                                            <span>
                                                                {{
                                                                    new Date(
                                                                        bukuTamu.tgl_penerimaan
                                                                    ).toLocaleDateString(
                                                                        "id-ID",
                                                                        {
                                                                            day: "2-digit",
                                                                            month: "long",
                                                                            year: "numeric",
                                                                        }
                                                                    )
                                                                }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr
                                                    style="
                                                        background-color: #8f8d8d !important;
                                                    "
                                                />
                                                <h4
                                                    class="c-primary-custom fw-bolder pb-2"
                                                >
                                                    Identitas Pengunjung
                                                </h4>
                                                <div class="row">
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        nama
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{ bukuTamu.nama }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        NIK
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{ bukuTamu.nik }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Tempat & Tanggal Lahir
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{
                                                            bukuTamu.tempat_lahir
                                                        }},
                                                        {{
                                                            bukuTamu.tanggal_lahir
                                                        }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Agama
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{ bukuTamu.agama }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Jenis Kelamin
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{
                                                            bukuTamu.jenis_kelamin
                                                        }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Status Perkawinan
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{
                                                            bukuTamu.status_perkawinan
                                                        }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Kewarganegaraan
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{
                                                            bukuTamu.kewarganegaraan
                                                        }}
                                                    </div>
                                                </div>
                                                <hr
                                                    style="
                                                        background-color: #8f8d8d !important;
                                                    "
                                                />
                                                <h4
                                                    class="c-primary-custom fw-bolder pb-2"
                                                >
                                                    Alamat Pengunjung
                                                </h4>
                                                <div class="row">
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Alamat
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{
                                                            bukuTamu.alamat_ktp
                                                        }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        RT/RW
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{ bukuTamu.rt_ktp }}/{{
                                                            bukuTamu.rw_ktp
                                                        }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Kelurahan/Desa
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{
                                                            bukuTamu.kel_desa_ktp
                                                        }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Kecamatan
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{
                                                            bukuTamu.kecamatan_ktp
                                                        }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Kabupaten/Kota
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{
                                                            bukuTamu.kota_kabupaten_ktp
                                                        }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Provinsi
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        {{ bukuTamu.provinsi }}
                                                    </div>
                                                </div>
                                                <hr
                                                    style="
                                                        background-color: #8f8d8d !important;
                                                    "
                                                />
                                                <h4
                                                    class="c-primary-custom fw-bolder pb-2"
                                                >
                                                    Kebutuhan Layanan
                                                </h4>
                                                <div class="row">
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Disposisi Pimpinan
                                                    </div>
                                                    <div class="col-lg-8 fw-bolder mb-5">
                                                        {{ bukuTamu.disposisi ? 'Warga Surabaya (Segera Tindaklanjuti)' : 'Warga Non Surabaya (Segera Tindaklanjuti dengan ketentuan)' }}
                                                    </div>
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        Jenis Layanan
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        <div
                                                            v-if="
                                                                bukuTamu
                                                                    .m_kebutuhan_layanan_id
                                                                    .length > 0
                                                            "
                                                        >
                                                            <div
                                                                v-for="(
                                                                    item, index
                                                                ) in bukuTamu.kebutuhan_layanan"
                                                                :key="index"
                                                                class="mb-3"
                                                            >   <div class="badge bg-success text-dark">
                                                                    {{ index + 1 }}.
                                                                    {{ item.name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else>
                                                            <span
                                                                class="text-muted"
                                                                >Tidak ada
                                                                kebutuhan
                                                                layanan</span
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr
                                                    style="
                                                        background-color: #8f8d8d !important;
                                                    "
                                                />
                                                <h4
                                                    class="c-primary-custom fw-bolder pb-2"
                                                >
                                                    Foto
                                                </h4>
                                                <div class="row">
                                                    <div
                                                        class="col-lg-4 text-gray-600 mb-5"
                                                    >
                                                        KTP
                                                    </div>
                                                    <div
                                                        class="col-lg-8 fw-bolder mb-5"
                                                    >
                                                        <a
                                                            :href="
                                                                getImageUrl(
                                                                    bukuTamu.foto_ktp_url
                                                                )
                                                            "
                                                            data-fancybox="gallery"
                                                            v-if="
                                                                bukuTamu.foto_ktp_url
                                                            "
                                                        >
                                                            <img
                                                                :src="
                                                                    getImageUrl(
                                                                        bukuTamu.foto_ktp_url
                                                                    )
                                                                "
                                                                class="w-100"
                                                                style="
                                                                    height: 100px;
                                                                    max-width: 100%;
                                                                    object-fit: cover;
                                                                    cursor: pointer;
                                                                "
                                                                alt="Foto KTP"
                                                            />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end -->
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

        <div
            v-if="identifikasiKebutuhan"
            class="modal fade"
            tabindex="-1"
            id="modal-form-identifikasi"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lakukan Identifikasi</h5>
                        <button
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            ❌
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Hasil Assessment</label>
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Hasil Assessment"
                                autocomplete="off"
                                v-model="identifikasiKebutuhan.hasil_assesment"
                            ></textarea>
                            <div
                                v-if="errors.hasil_assesment"
                                class="text-danger"
                            >
                                Hasil Assessment tidak boleh kosong!
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Pemberian Dukungan Psikologis Awal (DPA)</label>
                            <app-select-single
                                v-model="identifikasiKebutuhan.dpa"
                                :placeholder="'Pilih DPA'"
                                :options="[
                                    {
                                        text: 'Ya, Terdapat narasi singkat DPA yang dilakukan',
                                        id: '1',
                                    },
                                    {
                                        text: 'Tidak, Tidak perlu isian',
                                        id: '0',
                                    },
                                ]"
                            ></app-select-single>
                            <div
                                v-if="errors.dpa"
                                class="text-danger"
                            >
                                Pilihan DPA tidak boleh kosong!
                            </div>
                        </div>

                        <div
                            v-if="identifikasiKebutuhan.dpa?.id == 1"
                            class="mb-3"
                        >
                            <label class="form-label fw-bolder fs-6">Narasi Singkat DPA</label>
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Narasi DPA"
                                autocomplete="off"
                                v-model="identifikasiKebutuhan.narasi"
                            ></textarea>
                            <div
                                v-if="errors.narasi"
                                class="text-danger"
                            >
                                Narasi DPA tidak boleh kosong!
                            </div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Disposisi Pimpinan</label>
                            <app-select-single
                                v-model="identifikasiKebutuhan.disposisi_pimpinan"
                                :placeholder="'Pilih Disposisi Pimpinan'"
                                :options="[
                                    {
                                        text: 'Ya, Warga Surabaya (Berikan layanan puspaga sesuai kebutuhan klien)',
                                        id: '1',
                                    },
                                    {
                                        text: 'Tidak, Warga Non Surabaya (Berikan layanan puspaga sesuai ketentuan)',
                                        id: '0',
                                    },
                                ]"
                            ></app-select-single>
                            <div
                                v-if="errors.disposisi_pimpinan"
                                class="text-danger"
                            >
                                Pilihan Disposisi Pimpinan tidak boleh kosong!
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
                            @click="onSubmit"
                            class="btn btn-sm bg-second-primary-custom text-white"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="identifikasiKebutuhan"
            class="modal fade"
            tabindex="-1"
            id="modal-edit-form-identifikasi"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Identifikasi</h5>
                        <button
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            ❌
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Hasil Assessment</label>
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Hasil Assessment"
                                autocomplete="off"
                                v-model="identifikasi.hasil_assesment"
                            ></textarea>
                            <div
                                v-if="errors.hasil_assesment"
                                class="text-danger"
                            >
                                Hasil Assessment tidak boleh kosong!
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Pemberian Dukungan Psikologis Awal (DPA)</label>
                            <app-select-single
                                v-model="identifikasi.dpa"
                                :placeholder="'Pilih DPA'"
                                :options="[
                                    {
                                        text: 'Ya, Terdapat narasi singkat DPA yang dilakukan',
                                        id: '1',
                                    },
                                    {
                                        text: 'Tidak, Tidak perlu isian',
                                        id: '0',
                                    },
                                ]"
                            ></app-select-single>
                            <div
                                v-if="errors.dpa"
                                class="text-danger"
                            >
                                Pilihan DPA tidak boleh kosong!
                            </div>
                        </div>

                        <div
                            v-if="identifikasi.dpa?.id == 1"
                            class="mb-3"
                        >
                            <label class="form-label fw-bolder fs-6">Narasi Singkat DPA</label>
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Narasi DPA"
                                autocomplete="off"
                                v-model="identifikasi.narasi"
                            ></textarea>
                            <div
                                v-if="errors.narasi"
                                class="text-danger"
                            >
                                Narasi DPA tidak boleh kosong!
                            </div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Disposisi Pimpinan</label>
                            <app-select-single
                                v-model="identifikasi.disposisi_pimpinan"
                                :placeholder="'Pilih Disposisi Pimpinan'"
                                :options="[
                                    {
                                        text: 'Ya, Warga Surabaya (Berikan layanan puspaga sesuai kebutuhan klien)',
                                        id: '1',
                                    },
                                    {
                                        text: 'Tidak, Warga Non Surabaya (Berikan layanan puspaga sesuai ketentuan)',
                                        id: '0',
                                    },
                                ]"
                            ></app-select-single>
                            <div
                                v-if="errors.disposisi_pimpinan"
                                class="text-danger"
                            >
                                Pilihan Disposisi Pimpinan tidak boleh kosong!
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
                            @click="onUpdate"
                            class="btn btn-sm bg-second-primary-custom text-white"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="formSingkat"
            class="modal fade"
            tabindex="-1"
            id="modal-isi-form-singkat"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lengkapi Form</h5>
                        <button
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            ❌
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6"
                                >Keterangan</label
                            >
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Keterangan"
                                autocomplete="off"
                                v-model="formSingkat.keterangan"
                            ></textarea>
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
                            @click="SubmitSingkat"
                            class="btn btn-sm bg-second-primary-custom text-white"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="formSingkat"
            class="modal fade"
            tabindex="-1"
            id="modal-edit-form-singkat"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Form</h5>
                        <button
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            ❌
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6"
                                >Keterangan</label
                            >
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Keterangan"
                                autocomplete="off"
                                v-model="formSingkat.keterangan"
                            ></textarea>
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
                            @click="UpdateSingkat"
                            class="btn btn-sm bg-second-primary-custom text-white"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="formRujukan"
            class="modal fade"
            tabindex="-1"
            id="modal-isi-form-rujukan"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lengkapi Form</h5>
                        <button
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            ❌
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6"
                                >Tujuan Rujukan</label
                            >
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Tujuan Rujukan"
                                autocomplete="off"
                                v-model="formRujukan.tujuan_rujukan"
                            ></textarea>
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
                            @click="SubmitRujukan"
                            class="btn btn-sm bg-second-primary-custom text-white"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="formRujukan"
            class="modal fade"
            tabindex="-1"
            id="modal-edit-form-rujukan"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Rujukan</h5>
                        <button
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            ❌
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6"
                                >Tujuan Rujukan</label
                            >
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Tujuan Rujukan"
                                autocomplete="off"
                                v-model="formRujukan.tujuan_rujukan"
                            ></textarea>
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
                            @click="UpdateRujukan"
                            class="btn btn-sm bg-second-primary-custom text-white"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="formTelekonsultasi"
            class="modal fade"
            tabindex="-1"
            id="modal-isi-form-telekonsultasi"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lengkapi Form</h5>
                        <button
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            ❌
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6"
                                >Nomor Telepon</label
                            >
                            <input
                                class="form-control"
                                placeholder="Masukkan Nomor Telepon"
                                autocomplete="off"
                                v-model="formTelekonsultasi.nomor_telepon"
                            ></input>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Tanggal Konsultasi</label>
                            <input
                                class="form-control"
                                type="date"
                                placeholder="Pilih Tanggal"
                                autocomplete="off"
                                v-model="formTelekonsultasi.tanggal"
                            />
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Jam Konsultasi</label>
                            <input
                                class="form-control"
                                type="time"
                                placeholder="Pilih Jam"
                                autocomplete="off"
                                v-model="formTelekonsultasi.jam"
                            />
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6"
                                >Keluhan</label
                            >
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Keluhan"
                                autocomplete="off"
                                v-model="formTelekonsultasi.keluhan"
                            ></textarea>
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
                            @click="SubmitTelekonsultasi"
                            class="btn btn-sm bg-second-primary-custom text-white"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="formTelekonsultasi"
            class="modal fade"
            tabindex="-1"
            id="modal-edit-form-telekonsultasi"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Form</h5>
                        <button
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            ❌
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6"
                                >Nomor Telepon</label
                            >
                            <input
                                class="form-control"
                                placeholder="Masukkan Nomor Telepon"
                                autocomplete="off"
                                v-model="formTelekonsultasi.nomor_telepon"
                            ></input>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Tanggal Konsultasi</label>
                            <input
                                class="form-control"
                                type="date"
                                placeholder="Pilih Tanggal"
                                autocomplete="off"
                                v-model="formTelekonsultasi.tanggal"
                            />
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6">Jam Konsultasi</label>
                            <input
                                class="form-control"
                                type="time"
                                placeholder="Pilih Jam"
                                autocomplete="off"
                                v-model="formTelekonsultasi.jam"
                            />
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bolder fs-6"
                                >Keluhan</label
                            >
                            <textarea
                                class="form-control"
                                type="text"
                                placeholder="Masukkan Keluhan"
                                autocomplete="off"
                                v-model="formTelekonsultasi.keluhan"
                            ></textarea>
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
                            @click="UpdateTelekonsultasi"
                            class="btn btn-sm bg-second-primary-custom text-white"
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
import * as pdfjsLib from "pdfjs-dist/build/pdf";
pdfjsLib.GlobalWorkerOptions.workerSrc = `https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js`;

export default {
    data() {
        return {
            ROLE_ADMIN_ID: process.env.MIX_ROLE_ADMIN_ID,
            ROLE_KONSELOR_ID: process.env.MIX_ROLE_KONSELOR_ID,
            flagTab: "penerimaan",
            pageStatus: "loading",
            bukuTamu: {
                tgl_penerimaan: "",
                nomor_pendaftaran: "",
                nama: "",
                nik: "",
                alamat_ktp: "",
                jenis_kelamin: "",
                tempat_lahir: "",
                tanggal_lahir: "",
                usia: "",
                rt_ktp: "",
                rw_ktp: "",
                kel_desa_ktp: "",
                kecamatan_ktp: "",
                kota_kabupaten_ktp: "",
                provinsi: "",
                agama: "",
                status_perkawinan: "",
                kewarganegaraan: "",
                disposisi: "",
                m_kebutuhan_layanan_id: [],
                foto_ktp_url: null,
            },
            identifikasiKebutuhan: {
                id: "",
                tgl_identifikasi: "",
                dpa: "",
                hasil_assesment: "",
                disposisi_pimpinan: "",
                narasi: "",
            },
                errors: {
                hasil_assesment: false,
                dpa: false,
                disposisi_pimpinan: false,
                narasi : false
            },
            identifikasi: {
                id: "",
                tgl_identifikasi: "",
                dpa: "",
                hasil_assesment: "",
                disposisi_pimpinan: "",
                narasi: "",
            },
            formRujukan: [],
            formSingkat: [],
            formTelekonsultasi: [],
            layananBukuTamu: null,
            daftarLayanan: [],
            pdfPages: [],
            currentPage: 0,
        };
    },
    async created() {
        await this.fetchAllData();
    },
    mounted() {
        this.fetchLayananBukuTamu();
        this.fetchLayanan();
        this.fetchIdentifikasiKebutuhanDetails();
        this.fetchBukuTamuDetails();
        reinitializeAllPlugin();
    },
    methods: {
        isSpecificHaveAccessMenu(roles = []) {
            let response = false;
            if (roles.filter((e) => e == this.$store.state.profile.role_id).length > 0) {
                response = true;
            }

            return response;
        },
        async fetchLayananBukuTamu() {
            this.pageStatus = 'loading';

            try {
                const response = await Api().get(
                    `/buku-tamu/${this.$route.params.id}/layanan`
                );
                this.layananBukuTamu = response.data;
                this.pageStatus = 'loaded';
            } catch (error) {
                console.error("Gagal mengambil layanan buku tamu:", error);
                throw error;
            }
        },
        async fetchLayanan() {
            this.pageStatus = "loading";
            try {
                const response = await Api().get(
                    "master-public/m-kebutuhan-layanan"
                );
                this.daftarLayanan = response.data.data; // Ambil dari response.data.data
                console.log("Daftar Layanan:", this.daftarLayanan);
            } catch (error) {
                console.error("Gagal mengambil data layanan:", error);
            }
        },
        singkat() {
            $("#modal-isi-form-singkat").modal("show");
        },
        singkatEdit() {
            $("#modal-edit-form-singkat").modal("show");
        },
        rujukan() {
            $("#modal-isi-form-rujukan").modal("show");
        },
        rujukanEdit() {
            $("#modal-edit-form-rujukan").modal("show");
        },
        telekonsultasi() {
            $("#modal-isi-form-telekonsultasi").modal("show");
        },
        telekonsultasiEdit() {
            $("#modal-edit-form-telekonsultasi").modal("show");
        },
        identifikasiSubmit() {
            $("#modal-form-identifikasi").modal("show");
        },
        identifikasiEdit() {
            Api().get(`/identifikasi-kebutuhan/${this.identifikasiKebutuhan.id}`)
                .then((response) => {
                    this.identifikasi = response.data.data;
                    
                    const dpaValue = this.identifikasi.dpa ? '1' : '0';
                    const disposisiValue = this.identifikasi.disposisi_pimpinan ? '1' : '0';

                    const dpaOptions = [
                        {
                            id: '1',
                            text: 'Ya, Terdapat narasi singkat DPA yang dilakukan'
                        },
                        {
                            id: '0',
                            text: 'Tidak, Tidak perlu isian'
                        }
                    ];

                    const disposisiOptions = [
                        {
                            id: '1',
                            text: 'Ya, Warga Surabaya (Berikan layanan puspaga sesuai kebutuhan klien) Layanan yang dibutuhkan'
                        },
                        {
                            id: '0',
                            text: 'Tidak, Warga Non Surabaya (Berikan layanan puspaga sesuai ketentuan) Layanan yang dibutuhkan'
                        }
                    ];

                    this.identifikasi.dpa = dpaOptions.find(opt => opt.id === dpaValue);
                    this.identifikasi.disposisi_pimpinan = disposisiOptions.find(opt => opt.id === disposisiValue);


                    const modal = new bootstrap.Modal(document.getElementById("modal-edit-form-identifikasi"));
                    modal.show();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        SubmitSingkat() {
            const formData = new FormData();
            formData.append("buku_tamu_kebutuhan_layanan_id", this.selectedKebutuhanLayananId); // Ambil dari state lokal
            formData.append("keterangan", this.formSingkat.keterangan);

            Api()
                .post("form-singkat", formData)
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data berhasil disimpan",
                        icon: "success",
                    });

                    this.formSingkat = response.data.data; 
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById("modal-isi-form-singkat"));
                    modal.hide();
                    this.fetchLayananBukuTamu();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        UpdateSingkat() { 
            const formData = new FormData();
            formData.append("_method", "PUT"); // Override metode menjadi PUT
            formData.append("keterangan", this.formSingkat.keterangan);

            Api()
                .post(`form-singkat/${this.selectedSingkatId}`, formData) // Tetap POST dengan _method PUT
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data berhasil diperbarui",
                        icon: "success",
                    });

                    this.formSingkat = response.data.data; 

                    const modal = bootstrap.Modal.getInstance(document.getElementById("modal-edit-form-singkat"));
                    modal.hide();
                    this.fetchLayananBukuTamu();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        openSingkatModal(kebutuhanLayananId) {
            this.selectedKebutuhanLayananId = kebutuhanLayananId; 
            this.formSingkat = { keterangan: "" }; 
            const modal = new bootstrap.Modal(document.getElementById("modal-isi-form-singkat"));
            modal.show();
        },
        editSingkatModal(singkat_id) { 
            this.selectedSingkatId = singkat_id;
            Api()
                .get(`form-singkat/${singkat_id}`)
                .then((response) => {
                    this.formSingkat = response.data.data; 
                    const modal = new bootstrap.Modal(document.getElementById("modal-edit-form-singkat"));
                    modal.show();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        SubmitRujukan() {
            const formData = new FormData();
            formData.append("buku_tamu_kebutuhan_layanan_id", this.selectedKebutuhanLayananId); // Ambil dari state lokal
            formData.append("tujuan_rujukan", this.formRujukan.tujuan_rujukan);

            Api()
                .post("form-rujukan", formData)
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data berhasil disimpan",
                        icon: "success",
                    });

                    this.formRujukan = response.data.data; 
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById("modal-isi-form-rujukan"));
                    modal.hide();
                    this.fetchLayananBukuTamu();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        UpdateRujukan() { 
            const formData = new FormData();
            formData.append("_method", "PUT"); 
            formData.append("tujuan_rujukan", this.formRujukan.tujuan_rujukan);

            Api()
                .post(`form-rujukan/${this.selectedRujukanId}`, formData)
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data berhasil diperbarui",
                        icon: "success",
                    });

                    this.formRujukan = response.data.data; 

                    const modal = bootstrap.Modal.getInstance(document.getElementById("modal-edit-form-rujukan"));
                    modal.hide();
                    this.fetchLayananBukuTamu();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        openRujukanModal(kebutuhanLayananId) {
            this.selectedKebutuhanLayananId = kebutuhanLayananId; 
            this.formRujukan = { tujuan_rujukan: "" }; 
            const modal = new bootstrap.Modal(document.getElementById("modal-isi-form-rujukan"));
            modal.show();
        },
        editRujukanModal(rujukan_id) { 
            this.selectedRujukanId = rujukan_id;
            Api()
                .get(`form-rujukan/${rujukan_id}`)
                .then((response) => {
                    this.formRujukan = response.data.data; 
                    const modal = new bootstrap.Modal(document.getElementById("modal-edit-form-rujukan"));
                    modal.show();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        SubmitTelekonsultasi() {
            const formData = new FormData();
            formData.append("buku_tamu_kebutuhan_layanan_id", this.selectedKebutuhanLayananId);
            formData.append("nomor_telepon", this.formTelekonsultasi.nomor_telepon);
            const jadwal_konsultasi = `${this.formTelekonsultasi.tanggal} ${this.formTelekonsultasi.jam}:00`;
            formData.append("jadwal_konsultasi", jadwal_konsultasi);
            formData.append("keluhan", this.formTelekonsultasi.keluhan);

            Api()
                .post("form-telekonsultasi", formData)
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data berhasil disimpan",
                        icon: "success",
                    });

                    this.formTelekonsultasi = response.data.data; 
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById("modal-isi-form-telekonsultasi"));
                    modal.hide();
                    this.fetchLayananBukuTamu();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        UpdateTelekonsultasi() { 
            const formData = new FormData();
            formData.append("_method", "PUT"); 
            formData.append("nomor_telepon", this.formTelekonsultasi.nomor_telepon);
            const jadwal_konsultasi = `${this.formTelekonsultasi.tanggal} ${this.formTelekonsultasi.jam}:00`;
            formData.append("jadwal_konsultasi", jadwal_konsultasi);
            formData.append("keluhan", this.formTelekonsultasi.keluhan);

            Api()
                .post(`form-telekonsultasi/${this.selectedTelekonsultasiId}`, formData) 
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data berhasil diperbarui",
                        icon: "success",
                    });

                    this.formTelekonsultasi = response.data.data; 

                    const modal = bootstrap.Modal.getInstance(document.getElementById("modal-edit-form-telekonsultasi"));
                    modal.hide();
                    this.fetchLayananBukuTamu();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        openTelekonsultasiModal(kebutuhanLayananId) {
            this.selectedKebutuhanLayananId = kebutuhanLayananId;
            this.formTelekonsultasi = { nomor_telepon: "",jadwal_konsultasi: "",keluhan: "" };
            const modal = new bootstrap.Modal(document.getElementById("modal-isi-form-telekonsultasi"));
            modal.show();
        },
        editTelekonsultasiModal(telekonsultasi_id) { 
            this.selectedTelekonsultasiId = telekonsultasi_id;
            Api()
                .get(`form-telekonsultasi/${telekonsultasi_id}`)
                .then((response) => {
                    let data = response.data.data;

                    if (data.jadwal_konsultasi) {
                        // Konversi dari "Y-m-d H:i:s" menjadi format yang sesuai untuk input HTML
                        let dateTime = new Date(data.jadwal_konsultasi);

                        let formattedDate = dateTime.toISOString().split("T")[0]; // "YYYY-MM-DD"
                        let formattedTime = dateTime.toTimeString().split(":").slice(0, 2).join(":"); // "HH:MM"
                        
                        this.formTelekonsultasi = {
                            nomor_telepon: data.nomor_telepon,
                            tanggal: formattedDate, // Set ke input tanggal
                            jam: formattedTime, // Set ke input jam
                            keluhan: data.keluhan
                        };
                    } else {
                        // Jika tidak ada jadwal, set default kosong
                        this.formTelekonsultasi = {
                            nomor_telepon: data.nomor_telepon,
                            tanggal: "",
                            jam: "",
                            keluhan: data.keluhan
                        };
                    }

                    const modal = new bootstrap.Modal(document.getElementById("modal-edit-form-telekonsultasi"));
                    modal.show();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        onSubmit() {
            this.errors.hasil_assesment = false;
            this.errors.dpa = false;
            this.errors.disposisi_pimpinan = false;
            this.errors.narasi = false;

            let valid = true;
            if (!this.identifikasiKebutuhan.hasil_assesment) {
                this.errors.hasil_assesment = true;
                valid = false;
            }
            if (!this.identifikasiKebutuhan.dpa) {
                this.errors.dpa = true;
                valid = false;
            }
            if (this.identifikasiKebutuhan.dpa?.id == 1 && !this.identifikasiKebutuhan.narasi) {
                this.errors.narasi = true;
                valid = false;
            }
            if (!this.identifikasiKebutuhan.disposisi_pimpinan) {
                this.errors.disposisi_pimpinan = true;
                valid = false;
            }

            if (!valid) {
                return;
            }

            const formData = new FormData();
            formData.append("buku_tamu_id", this.$route.params.id);
            formData.append("dpa", this.identifikasiKebutuhan.dpa?.id == 1 ? 1 : 0);
            formData.append("narasi",this.identifikasiKebutuhan.narasi);
            formData.append("hasil_assesment", this.identifikasiKebutuhan.hasil_assesment);
            formData.append("disposisi_pimpinan", this.identifikasiKebutuhan.disposisi_pimpinan?.id == 1 ? 1 : 0);

            Api()
                .post("identifikasi-kebutuhan", formData)
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Data berhasil disimpan.",
                        icon: "success",
                    });
                    this.identifikasiKebutuhan = response.data.data;
                    const modal = bootstrap.Modal.getInstance(document.getElementById("modal-form-identifikasi"));
                    modal.hide();
                    this.fetchIdentifikasiKebutuhanDetails();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        onUpdate() {
            this.errors.hasil_assesment = false;
            this.errors.dpa = false;
            this.errors.disposisi_pimpinan = false;
            this.errors.narasi = false;

            let valid = true;
            if (!this.identifikasi.hasil_assesment) {
                this.errors.hasil_assesment = true;
                valid = false;
            }
            if (!this.identifikasi.dpa) {
                this.errors.dpa = true;
                valid = false;
            }
            if (this.identifikasi.dpa?.id == 1 && !this.identifikasi.narasi) {
                this.errors.narasi = true;
                valid = false;
            }
            if (!this.identifikasi.disposisi_pimpinan) {
                this.errors.disposisi_pimpinan = true;
                valid = false;
            }

            if (!valid) {
                return;
            }
            
            const formData = new FormData();
            formData.append("_method", "PUT"); 
            formData.append("dpa", this.identifikasi.dpa?.id == 1 ? 1 : 0);
            formData.append("narasi",this.identifikasi.narasi);
            formData.append("hasil_assesment", this.identifikasi.hasil_assesment);
            formData.append("disposisi_pimpinan", this.identifikasi.disposisi_pimpinan?.id == 1 ? 1 : 0);


            Api()
                .post(`identifikasi-kebutuhan/${this.identifikasi.id}`, formData)
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text: "Perubahan berhasil",
                        icon: "success",
                    });
                    this.identifikasi = response.data.data;
                    const modal = bootstrap.Modal.getInstance(document.getElementById("modal-edit-form-identifikasi"));
                    modal.hide(); 
                    this.fetchIdentifikasiKebutuhanDetails();
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                });
        },
        formatTanggal(tanggal) {
            if (!tanggal) return "";
            const date = new Date(tanggal);
            return date.toLocaleDateString("id-ID", {
                day: "numeric",
                month: "long",
                year: "numeric",
            });
        },
        async fetchBukuTamuDetails() {
            this.pageStatus = "loading";
            try {
                const response = await Api().get(
                    `/buku-tamu/${this.$route.params.id}`
                );

                if (response.data.status === "success") {
                    this.bukuTamu = response.data.data;
                    this.pageStatus = "standby";
                } else {
                    console.warn("API returned a non-success status");
                    this.pageStatus = "error";
                }
            } catch (error) {
                console.error("Failed to fetch buku tamu details:", error);
                this.pageStatus = "error";
            }
        },
        async fetchIdentifikasiKebutuhanDetails() {
            this.pageStatus = "loading";
            try {
                const response = await Api().get(
                    `/identifikasi-kebutuhan/buku-tamu/${this.$route.params.id}`
                );

                if (response.data.status === "success") {
                    this.identifikasiKebutuhan = response.data.data;
                    this.pageStatus = "loaded";
                } else {
                    console.warn("API returned a non-success status");
                    this.pageStatus = "error";
                }
            } catch (error) {
                console.error("Failed to fetch buku tamu details:", error);
                this.pageStatus = "error";
            }
        },
        getImageUrl(path) {
            if (!path) return null;
            return `/storage/${path}`;
        },
    },
};
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

.loading-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: gray;
}

.error-indicator {
    color: grey;
    font-weight: 700;
    text-align: center;
}

.pdf-slider {
    position: relative;
}

.slide-image {
    width: 100%;
    border-radius: 7px;
}

.indikator {
    display: flex;
    justify-content: center;
    align-items: center;
}

.slide-indicator {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 500;
}

.prev,
.next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.7);
    border: none;
    padding: 8px;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.prev {
    left: 10px;
}

.next {
    right: 10px;
}
</style>
