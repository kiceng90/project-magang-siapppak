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
                                <div class="head my-5">
                                    <div class="row pt-5 mt-4">
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap">
                                                <div
                                                    class=""
                                                    style="
                                                        border-right: 1px solid
                                                            grey;
                                                        padding-right: 10px;
                                                    "
                                                >
                                                    <h4>
                                                        Survey Data Keluarga
                                                        Klien
                                                    </h4>
                                                </div>
                                                <div>
                                                    &ensp;
                                                    <span class="text-muted">
                                                        <router-link
                                                            :to="{
                                                                name: 'pengaduan',
                                                            }"
                                                            class="text-muted"
                                                            style="
                                                                text-decoration: none;
                                                            "
                                                        >
                                                            Pengaduan
                                                        </router-link>
                                                        -
                                                        <a
                                                            href="javascript:void(0)"
                                                            @click="
                                                                $router.back()
                                                            "
                                                            class="text-muted"
                                                            style="
                                                                text-decoration: none;
                                                            "
                                                        >
                                                            Detail Pengaduan
                                                        </a>
                                                        - Survey Data Keluarga
                                                        Klien
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-5">
                                    <div class="col-lg-5">
                                        <h1>Data Keluarga Klien</h1>
                                    </div>
                                    <div
                                        class="col-lg-7 d-flex flex-wrap"
                                        style="justify-content: flex-end"
                                    >
                                        <button
                                            type="button"
                                            class="btn me-3"
                                            style="background-color: #fff8dd"
                                            @click="
                                                $router.push({
                                                    name: 'pengaduan',
                                                    params: {
                                                        id: this.$route.params
                                                            .id,
                                                    },
                                                    query: {
                                                        flag: 'penjangkauan',
                                                    },
                                                })
                                            "
                                        >
                                            <span class="text-warning d-flex">
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
                                        <div
                                            class="dropdown"
                                            v-if="
                                                $store.state.profile.role_id ==
                                                ROLE_KONSELOR_ID
                                            "
                                        >
                                            <button
                                                class="btn text-white bg-second-primary-custom dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                            >
                                                Simpan
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a
                                                        class="dropdown-item py-3"
                                                        href="javascript:void(0);"
                                                        @click="save(1)"
                                                        >Draft</a
                                                    >
                                                </li>
                                                <li>
                                                    <a
                                                        class="dropdown-item py-3"
                                                        href="javascript:void(0);"
                                                        @click="
                                                            confirmPublishsave()
                                                        "
                                                        >Publish</a
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                        <button
                                            class="btn text-white bg-second-primary-custom"
                                            @click="confirmPublishsave()"
                                            v-else
                                        >
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                                <div
                                    class="d-flex pt-5 mt-8 ps-5 pe-5 mb-8 bg-white"
                                >
                                    <div class="d-flex flex-wrap">
                                        <a
                                            href="javascript:void(0)"
                                            @click="flagTab = 'family'"
                                            :class="
                                                flagTab == 'family'
                                                    ? 'active'
                                                    : ''
                                            "
                                            class="nav-tab-custom-x"
                                            >Data Keluarga</a
                                        >
                                        <a
                                            href="javascript:void(0)"
                                            @click="flagTab = 'sibling'"
                                            :class="
                                                flagTab == 'sibling'
                                                    ? 'active'
                                                    : ''
                                            "
                                            class="nav-tab-custom-x"
                                            >Data Saudara</a
                                        >
                                    </div>
                                </div>
                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    v-if="flagTab == 'family'"
                                >
                                    <div
                                        v-if="pageStatus == 'page-load'"
                                        class="w-100 d-flex justify-content-center mt-10 mb-10"
                                    >
                                        <app-loader></app-loader>
                                    </div>
                                    <div
                                        v-else
                                        v-for="(
                                            context, index
                                        ) in single.listFamily"
                                        :key="index"
                                    >
                                        <div
                                            class="card card-xl-stretch mb-5 mb-xl-8"
                                        >
                                            <div
                                                class="card-header border-0 pt-5 align-items-center justify-content-between"
                                            >
                                                <h3
                                                    class="card-title align-items-start flex-column"
                                                >
                                                    <span
                                                        class="card-label fw-bolder text-dark mb-2 c-primary-custom"
                                                        style="
                                                            font-size: 17px !important;
                                                        "
                                                        >keluarga
                                                        {{ index + 1 }}</span
                                                    >
                                                </h3>
                                                <button
                                                    @click="
                                                        removeFamilyData(index)
                                                    "
                                                    v-if="index > 0"
                                                    class="btn btn-light-danger"
                                                    type="button"
                                                >
                                                    Hapus Item
                                                </button>
                                            </div>
                                            <div class="card-body pt-5">
                                                <div
                                                    class="row align-items-center"
                                                >
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            v$.$error &&
                                                            v$.single.listFamily
                                                                .$each.$response
                                                                .$data[index]
                                                                .relationshipWithClient
                                                                .$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Hubungan Dengan Klien
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <app-select-single
                                                            v-model="
                                                                context.relationshipWithClient
                                                            "
                                                            :placeholder="'Pilih hubungan dengan klien'"
                                                            :options="
                                                                listRelationshipWithClient
                                                            "
                                                            :serverside="true"
                                                            :loading="
                                                                pageStatus ==
                                                                'rel-client-load'
                                                            "
                                                            @change-search="
                                                                getRelationshipWithClient
                                                            "
                                                        >
                                                            >
                                                        </app-select-single>
                                                        <div
                                                            v-if="
                                                                v$.$error &&
                                                                v$.single
                                                                    .listFamily
                                                                    .$each
                                                                    .$response
                                                                    .$data[
                                                                    index
                                                                ]
                                                                    .relationshipWithClient
                                                                    .$error
                                                            "
                                                            class="text-danger"
                                                        >
                                                            Hubungan Dengan
                                                            Klien tidak boleh
                                                            kosong!
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            v$.$error &&
                                                            v$.single.listFamily
                                                                .$each.$response
                                                                .$data[index]
                                                                .name.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Nama Lengkap
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Cth: Suwarni"
                                                            v-model="
                                                                context.name
                                                            "
                                                        />
                                                        <div
                                                            v-if="
                                                                v$.$error &&
                                                                v$.single
                                                                    .listFamily
                                                                    .$each
                                                                    .$response
                                                                    .$data[
                                                                    index
                                                                ].name.$error
                                                            "
                                                            class="text-danger"
                                                        >
                                                            Nama Lengkap tidak
                                                            boleh kosong!
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            v$.$error &&
                                                            v$.single.listFamily
                                                                .$each.$response
                                                                .$data[index]
                                                                .phone.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        No. Telepon/Whatsapp
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <div
                                                            class="input-group"
                                                        >
                                                            <span
                                                                class="input-group-text"
                                                                style="
                                                                    background: #fff !important;
                                                                "
                                                            >
                                                                <svg
                                                                    width="22"
                                                                    height="22"
                                                                    viewBox="0 0 22 22"
                                                                    fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                >
                                                                    <g
                                                                        clip-path="url(#clip0_786_33802)"
                                                                    >
                                                                        <path
                                                                            fill-rule="evenodd"
                                                                            clip-rule="evenodd"
                                                                            d="M11.99 13.5508L14.0104 11.5305C14.5684 10.9725 14.7067 10.12 14.3538 9.4142L14.2393 9.18525C13.8864 8.47944 14.0248 7.62699 14.5827 7.069L17.0878 4.56393C17.2668 4.38494 17.557 4.38494 17.736 4.56393C17.7708 4.59876 17.7998 4.63899 17.8219 4.68305L18.8338 6.707C19.608 8.25535 19.3045 10.1254 18.0805 11.3495L12.5815 16.8484C11.2491 18.1808 9.27828 18.646 7.49066 18.0502L5.27739 17.3124C5.03725 17.2324 4.90746 16.9728 4.98751 16.7327C5.01001 16.6652 5.04792 16.6038 5.09823 16.5535L7.52857 14.1232C8.08656 13.5652 8.93901 13.4269 9.64482 13.7798L9.87377 13.8942C10.5796 14.2471 11.432 14.1088 11.99 13.5508Z"
                                                                            fill="#7E8299"
                                                                        />
                                                                        <path
                                                                            opacity="0.3"
                                                                            d="M12.969 5.50506L12.7935 7.32998C11.4382 7.19969 10.0921 7.67005 9.11095 8.65123C8.13298 9.6292 7.66241 10.9697 7.78847 12.3209L5.96307 12.4912C5.78684 10.6024 6.44666 8.7228 7.81459 7.35487C9.18702 5.98244 11.0744 5.32293 12.969 5.50506ZM13.2898 1.85228L13.1202 3.67775C10.6899 3.45193 8.27739 4.29934 6.51822 6.05851C4.76148 7.81525 3.91392 10.2235 4.13657 12.6507L2.3109 12.8182C2.03902 9.85429 3.07588 6.90813 5.22186 4.76215C7.37082 2.61319 10.3221 1.57652 13.2898 1.85228Z"
                                                                            fill="#7E8299"
                                                                        />
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath
                                                                            id="clip0_786_33802"
                                                                        >
                                                                            <rect
                                                                                width="22"
                                                                                height="22"
                                                                                fill="white"
                                                                            />
                                                                        </clipPath>
                                                                    </defs>
                                                                </svg>
                                                            </span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                placeholder="Contoh: 081 234 567 890"
                                                                style="
                                                                    border-left: 0 !important;
                                                                "
                                                                min="0"
                                                                v-model="
                                                                    context.phone
                                                                "
                                                            />
                                                        </div>
                                                        <div
                                                            v-if="
                                                                v$.$error &&
                                                                v$.single
                                                                    .listFamily
                                                                    .$each
                                                                    .$response
                                                                    .$data[
                                                                    index
                                                                ].phone.$error
                                                            "
                                                            class="text-danger"
                                                        >
                                                            No. Telepon/Whatsapp
                                                            tidak boleh kosong!
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            v$.$error &&
                                                            v$.single.listFamily
                                                                .$each.$response
                                                                .$data[index]
                                                                .maritalStatus
                                                                .$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Status Pernikahan
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <app-select-single
                                                            v-model="
                                                                context.maritalStatus
                                                            "
                                                            :placeholder="'Pilih status pernikahan'"
                                                            :loading="
                                                                pageStatus ==
                                                                'marital-status-load'
                                                            "
                                                            :options="
                                                                listMaritalStatus
                                                            "
                                                            :serverside="true"
                                                            @change-search="
                                                                getMaritalStatus
                                                            "
                                                        >
                                                        </app-select-single>
                                                        <div
                                                            v-if="
                                                                v$.$error &&
                                                                v$.single
                                                                    .listFamily
                                                                    .$each
                                                                    .$response
                                                                    .$data[
                                                                    index
                                                                ].maritalStatus
                                                                    .$error
                                                            "
                                                            class="text-danger"
                                                        >
                                                            Status Pernikahan
                                                            tidak boleh kosong!
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-lg-3 mb-5 fw-bolder"
                                                        :class="v$.$error && v$.single.listFamily.$each.$response.$data[index].maritalStatus.$error ? 'text-danger' : ''">
                                                        Pendidikan
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <app-select-single v-model="single.lastEducation"
                                                            :placeholder="'Pilih pendidikan'" :options="listEducation"
                                                            :serverside="true" :loading="pageStatus == 'education-load'"
                                                            @change-search="getLatestEducation">
                                                        </app-select-single>
                                                        <div v-if="v$.$error && v$.single.listFamily.$each.$response.$data[index].maritalStatus.$error" 
                                                            class="text-danger">
                                                            Pendidikan tidak boleh kosong!
                                                        </div>
                                                    </div> -->
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        Agama(Opsional)
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <app-select-single
                                                            v-model="
                                                                context.religion
                                                            "
                                                            :placeholder="'Pilih agama'"
                                                            :options="
                                                                listReligion
                                                            "
                                                            :loading="
                                                                pageStatus ==
                                                                'religion-load'
                                                            "
                                                            :serverside="true"
                                                            @change-search="
                                                                getReligion
                                                            "
                                                        >
                                                        </app-select-single>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        Tempat, Tanggal
                                                        Lahir(Opsional)
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="row">
                                                            <div
                                                                class="col-lg-5 mb-5"
                                                            >
                                                                <app-select-single
                                                                    v-model="
                                                                        context.placeOfBirth
                                                                    "
                                                                    :placeholder="'Pilih kota/kabupaten'"
                                                                    :options="
                                                                        listPlaceOfBirth
                                                                    "
                                                                    :serverside="
                                                                        true
                                                                    "
                                                                    :loading="
                                                                        pageStatus ==
                                                                        'city-load'
                                                                    "
                                                                    @change-search="
                                                                        getCity
                                                                    "
                                                                >
                                                                </app-select-single>
                                                            </div>
                                                            <div
                                                                class="col-lg-3 mb-5"
                                                            >
                                                                <app-datepicker
                                                                    type="date"
                                                                    placeholder="Pilih tanggal"
                                                                    :format="'DD-MM-YYYY'"
                                                                    :value-type="'DD-MM-YYYY'"
                                                                    v-model:value="
                                                                        context.dateOfBirth
                                                                    "
                                                                >
                                                                </app-datepicker>
                                                            </div>
                                                            <div
                                                                class="col-lg-4 mb-5"
                                                            >
                                                                <div
                                                                    class="input-group mb-5"
                                                                >
                                                                    <input
                                                                        type="text"
                                                                        class="form-control"
                                                                        :value="
                                                                            calculateAge(
                                                                                context.dateOfBirth,
                                                                                index
                                                                            )
                                                                        "
                                                                        placeholder="Usia Otomatis"
                                                                        disabled
                                                                    />
                                                                    <span
                                                                        class="input-group-text"
                                                                        style="
                                                                            color: #5e6278;
                                                                        "
                                                                        >Tahun</span
                                                                    >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        Nomor NIK (Opsional)
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            placeholder="Cth: 3578080907740004"
                                                            v-model="
                                                                context.nik
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        Nomor KK (Opsional)
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            placeholder="Cth: 330 708 150 108 017 2"
                                                            v-model="
                                                                context.noKK
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        Alamat KK (Opsional)
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div
                                                            class="row align-items-center"
                                                        >
                                                            <div
                                                                class="col-lg-12 mb-5"
                                                            >
                                                                <textarea
                                                                    class="form-control"
                                                                    placeholder="Cth: Ngagel III No 20, RT001/RW001"
                                                                    rows="2"
                                                                    @input="
                                                                        if (
                                                                            context.isSameAddress
                                                                        ) {
                                                                            context.addressResidence =
                                                                                context.addressFamilyCard;
                                                                        }
                                                                    "
                                                                    v-model="
                                                                        context.addressFamilyCard
                                                                    "
                                                                ></textarea>
                                                            </div>
                                                            <div
                                                                class="col-lg-2 mb-5 fw-bolder"
                                                            >
                                                                Kecamatan
                                                            </div>
                                                            <div
                                                                class="col-lg-4 mb-5"
                                                            >
                                                                <app-select-single
                                                                    v-model="
                                                                        context.districtFamilyCardAddress
                                                                    "
                                                                    :placeholder="'Pilih kecamatan'"
                                                                    :options="
                                                                        listDistrictFamilyCardAddress
                                                                    "
                                                                    :loading="
                                                                        pageStatus ==
                                                                        'district-family-load'
                                                                    "
                                                                    :serverside="
                                                                        true
                                                                    "
                                                                    @option-change="
                                                                        (
                                                                            evt
                                                                        ) => {
                                                                            context.subDistrictFamilyCardAddress =
                                                                                {};
                                                                            if (
                                                                                context.isSameAddress
                                                                            ) {
                                                                                context.districtResidenceAddress =
                                                                                    evt.value;
                                                                                context.subDistrictResidenceAddress =
                                                                                    {};
                                                                            }
                                                                        }
                                                                    "
                                                                    @change-search="
                                                                        (
                                                                            keyword,
                                                                            limit
                                                                        ) =>
                                                                            getDistrict(
                                                                                keyword,
                                                                                limit,
                                                                                'listDistrictFamilyCardAddress',
                                                                                'district-family-load'
                                                                            )
                                                                    "
                                                                >
                                                                </app-select-single>
                                                            </div>
                                                            <div
                                                                class="col-lg-2 mb-5 fw-bolder"
                                                            >
                                                                Kelurahan
                                                            </div>
                                                            <div
                                                                class="col-lg-4 mb-5"
                                                            >
                                                                <app-select-single
                                                                    v-model="
                                                                        context.subDistrictFamilyCardAddress
                                                                    "
                                                                    :placeholder="'Pilih kelurahan'"
                                                                    :options="
                                                                        listSubDistrictFamilyCardAddress
                                                                    "
                                                                    :serverside="
                                                                        true
                                                                    "
                                                                    :disabled="
                                                                        !context
                                                                            .districtFamilyCardAddress
                                                                            .id
                                                                    "
                                                                    :loading="
                                                                        pageStatus ==
                                                                        'subdistrict-family-load'
                                                                    "
                                                                    @option-change="
                                                                        (
                                                                            evt
                                                                        ) => {
                                                                            if (
                                                                                context.isSameAddress
                                                                            ) {
                                                                                context.subDistrictResidenceAddress =
                                                                                    evt.value;
                                                                            }
                                                                        }
                                                                    "
                                                                    @change-search="
                                                                        (
                                                                            keyword,
                                                                            limit
                                                                        ) =>
                                                                            getSubDistrict(
                                                                                keyword,
                                                                                limit,
                                                                                'listSubDistrictFamilyCardAddress',
                                                                                'subdistrict-family-load',
                                                                                context
                                                                                    .districtFamilyCardAddress
                                                                                    .id
                                                                            )
                                                                    "
                                                                >
                                                                </app-select-single>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        <div>
                                                            Alamat Domisili
                                                            (Opsional)
                                                        </div>
                                                        <div
                                                            class="form-check form-check-custom form-check-solid mt-2"
                                                        >
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                @change="
                                                                    ChangeCheckboxAddress(
                                                                        index
                                                                    )
                                                                "
                                                                v-model="
                                                                    context.isSameAddress
                                                                "
                                                                :id="
                                                                    'flexCheckDefault' +
                                                                    index
                                                                "
                                                            />
                                                            <label
                                                                class="form-check-label"
                                                                style="
                                                                    font-size: 12px;
                                                                    color: #605e5e !important;
                                                                "
                                                                :for="
                                                                    'flexCheckDefault' +
                                                                    index
                                                                "
                                                            >
                                                                Sama dengan
                                                                alamat KK
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div
                                                            class="row align-items-center"
                                                        >
                                                            <div
                                                                class="col-lg-12 mb-5"
                                                            >
                                                                <textarea
                                                                    class="form-control"
                                                                    placeholder="Cth: Ngagel III No 20, RT001/RW001"
                                                                    rows="2"
                                                                    :disabled="
                                                                        context.isSameAddress
                                                                    "
                                                                    v-model="
                                                                        context.addressResidence
                                                                    "
                                                                ></textarea>
                                                            </div>
                                                            <div
                                                                class="col-lg-2 mb-5 fw-bolder"
                                                            >
                                                                Kecamatan
                                                            </div>
                                                            <div
                                                                class="col-lg-4 mb-5"
                                                            >
                                                                <app-select-single
                                                                    v-model="
                                                                        context.districtResidenceAddress
                                                                    "
                                                                    :placeholder="'Pilih kecamatan'"
                                                                    :options="
                                                                        listDistrictResidenceAddress
                                                                    "
                                                                    :serverside="
                                                                        true
                                                                    "
                                                                    :disabled="
                                                                        context.isSameAddress
                                                                    "
                                                                    @option-change="
                                                                        context.subDistrictResidenceAddress =
                                                                            {}
                                                                    "
                                                                    :loading="
                                                                        pageStatus ==
                                                                        'district-residence-load'
                                                                    "
                                                                    @change-search="
                                                                        (
                                                                            keyword,
                                                                            limit
                                                                        ) =>
                                                                            getDistrict(
                                                                                keyword,
                                                                                limit,
                                                                                'listDistrictResidenceAddress',
                                                                                'district-residence-load'
                                                                            )
                                                                    "
                                                                >
                                                                </app-select-single>
                                                            </div>
                                                            <div
                                                                class="col-lg-2 mb-5 fw-bolder"
                                                            >
                                                                Kelurahan
                                                            </div>
                                                            <div
                                                                class="col-lg-4 mb-5"
                                                            >
                                                                <app-select-single
                                                                    v-model="
                                                                        context.subDistrictResidenceAddress
                                                                    "
                                                                    :placeholder="'Pilih kelurahan'"
                                                                    :options="
                                                                        listSubDistrictResidenceAddress
                                                                    "
                                                                    :serverside="
                                                                        true
                                                                    "
                                                                    :disabled="
                                                                        !context
                                                                            .districtResidenceAddress
                                                                            .id ||
                                                                        context.isSameAddress
                                                                    "
                                                                    :loading="
                                                                        pageStatus ==
                                                                        'subdistrict-residence-load'
                                                                    "
                                                                    @change-search="
                                                                        (
                                                                            keyword,
                                                                            limit
                                                                        ) =>
                                                                            getSubDistrict(
                                                                                keyword,
                                                                                limit,
                                                                                'listSubDistrictResidenceAddress',
                                                                                'subdistrict-residence-load',
                                                                                context
                                                                                    .districtResidenceAddress
                                                                                    .id
                                                                            )
                                                                    "
                                                                >
                                                                </app-select-single>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        Pekerjaan (Opsional)
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <app-select-single
                                                            v-model="
                                                                context.work
                                                            "
                                                            :placeholder="'Pilih pekerjaan'"
                                                            :options="listWork"
                                                            :serverside="true"
                                                            :loading="
                                                                pageStatus ==
                                                                'profession-load'
                                                            "
                                                            @change-search="
                                                                getProfession
                                                            "
                                                        >
                                                        </app-select-single>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        Penghasilan Perbulan
                                                        (Opsional)
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <div
                                                            class="input-group mb-5"
                                                        >
                                                            <span
                                                                class="input-group-text"
                                                                style="
                                                                    color: #5e6278;
                                                                "
                                                                >Rp</span
                                                            >
                                                            <app-money
                                                                class="form-control"
                                                                v-model="
                                                                    context.monthlyIncome
                                                                "
                                                                v-bind="
                                                                    moneyConfig
                                                                "
                                                            >
                                                            </app-money>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                    >
                                                        Sifat Pekerjaan
                                                        (Opsional)
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="row">
                                                            <div
                                                                class="col-lg-12"
                                                            >
                                                                <div
                                                                    class="d-flex align-items-center mb-5 group-option-nature-of-work"
                                                                >
                                                                    <div
                                                                        class="d-flex align-items-center"
                                                                        style="
                                                                            min-width: 290px;
                                                                        "
                                                                    >
                                                                        <button
                                                                            class="btn btn-sm btn-not-selected"
                                                                            v-for="(
                                                                                nature,
                                                                                idxNature
                                                                            ) in listNatureOfWork"
                                                                            :key="
                                                                                idxNature
                                                                            "
                                                                            type="button"
                                                                            @click="
                                                                                context.natureOfWork =
                                                                                    nature.id;
                                                                                context.textNatureOfWorkOther =
                                                                                    '';
                                                                            "
                                                                            :class="
                                                                                context.natureOfWork ==
                                                                                nature.id
                                                                                    ? 'active'
                                                                                    : ''
                                                                            "
                                                                        >
                                                                            {{
                                                                                nature.text
                                                                            }}
                                                                        </button>
                                                                    </div>
                                                                    <input
                                                                        type="text"
                                                                        class="form-control mb-5"
                                                                        v-model="
                                                                            context.textNatureOfWorkOther
                                                                        "
                                                                        placeholder="Lainnya"
                                                                        :disabled="
                                                                            context.natureOfWork !=
                                                                            'Lainnya'
                                                                        "
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            v$.$error &&
                                                            v$.single.listFamily
                                                                .$each.$response
                                                                .$data[index]
                                                                .bpjsOwnership
                                                                .$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Kepemilikan BPJS
                                                    </div>
                                                    <div class="col-lg-9 mb-5">
                                                        <div class="row">
                                                            <div
                                                                class="col-lg-12"
                                                            >
                                                                <div
                                                                    class="d-flex align-items-center flex-wrap"
                                                                >
                                                                    <button
                                                                        class="btn btn-sm btn-not-selected"
                                                                        v-for="(
                                                                            bpjs,
                                                                            i
                                                                        ) in listBpjsOwnership"
                                                                        :key="i"
                                                                        type="button"
                                                                        @click="
                                                                            context.bpjsOwnership =
                                                                                bpjs.id
                                                                        "
                                                                        :class="
                                                                            context.bpjsOwnership ==
                                                                            bpjs.id
                                                                                ? 'active'
                                                                                : ''
                                                                        "
                                                                    >
                                                                        {{
                                                                            bpjs.text
                                                                        }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            v-if="
                                                                v$.$error &&
                                                                v$.single
                                                                    .listFamily
                                                                    .$each
                                                                    .$response
                                                                    .$data[
                                                                    index
                                                                ].bpjsOwnership
                                                                    .$error
                                                            "
                                                            class="text-danger"
                                                        >
                                                            Pilih Salah Satu
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <h4
                                                            class="c-primary-custom pb-5"
                                                        >
                                                            Pendidikan Terakhir
                                                        </h4>
                                                        <div
                                                            class="row align-items-center"
                                                        >
                                                            <div
                                                                class="col-lg-3 mb-5 fw-bolder"
                                                            >
                                                                Pendidikan
                                                            </div>
                                                            <!-- <div class="col-lg-3 mb-5">
                                                                <app-select-single v-model="context.lastEducation"
                                                                    :placeholder="'Pilih pendidikan'" :options="listEducation"
                                                                    :serverside="true"
                                                                    >
                                                                </app-select-single>
                                                                <div>
                                                                    Pendidikan tidak boleh kosong!
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 mb-5 fw-bolder">
                                                                Jurusan Sekolah (Opsional)
                                                            </div>
                                                            <div class="col-lg-3 mb-5">
                                                                <app-select-single v-model="context.schoolMajors"
                                                                    :placeholder="'Pilih jurusan sekolah'"
                                                                    :options="listSchoolMajors" :serverside="true"
                                                                    :loading="pageStatus == 'school-major-load'"
                                                                    @change-search="getSchoolMajors">
                                                                </app-select-single>
                                                            </div> -->
                                                            <div
                                                                class="col-lg-3 mb-5"
                                                            >
                                                                <app-select-single
                                                                    v-model="
                                                                        context.lastEducation
                                                                    "
                                                                    :placeholder="'Pilih pendidikan'"
                                                                    :options="
                                                                        listEducation
                                                                    "
                                                                    :serverside="
                                                                        true
                                                                    "
                                                                    @change-search="
                                                                        getLatestEducation
                                                                    "
                                                                >
                                                                </app-select-single>
                                                                <!-- <div class="text-danger>
                                                                    Pendidikan tidak boleh kosong!
                                                                </div> -->
                                                            </div>
                                                            <div
                                                                class="col-lg-3 mb-5 fw-bolder"
                                                            >
                                                                Jurusan Sekolah
                                                                (Opsional)
                                                            </div>
                                                            <div
                                                                class="col-lg-3 mb-5"
                                                            >
                                                                <app-select-single
                                                                    v-model="
                                                                        context.schoolMajors
                                                                    "
                                                                    :placeholder="'Pilih jurusan sekolah'"
                                                                    :options="
                                                                        listSchoolMajors
                                                                    "
                                                                    :serverside="
                                                                        true
                                                                    "
                                                                    @change-search="
                                                                        getSchoolMajors
                                                                    "
                                                                >
                                                                </app-select-single>
                                                            </div>
                                                            <div
                                                                class="col-lg-3 mb-5 fw-bolder"
                                                            >
                                                                Kelas (Opsional)
                                                            </div>
                                                            <div
                                                                class="col-lg-3 mb-5"
                                                            >
                                                                <app-select-single
                                                                    v-model="
                                                                        single.highestClass
                                                                    "
                                                                    :placeholder="'Pilih kelas'"
                                                                    :options="
                                                                        listHighestClass
                                                                    "
                                                                    :serverside="
                                                                        false
                                                                    "
                                                                >
                                                                </app-select-single>
                                                            </div>
                                                            <div
                                                                class="col-lg-3 mb-5 fw-bolder"
                                                            >
                                                                Tahun Lulus
                                                                (Opsional)
                                                            </div>
                                                            <div
                                                                class="col-lg-3 mb-5"
                                                            >
                                                                <app-datepicker
                                                                    type="year"
                                                                    placeholder="Pilih tanggal"
                                                                    :format="'YYYY'"
                                                                    :value-type="'YYYY'"
                                                                    v-model:value="
                                                                        single.graduationYear
                                                                    "
                                                                >
                                                                </app-datepicker>
                                                            </div>
                                                            <div
                                                                class="col-lg-3 mb-5 fw-bolder"
                                                            >
                                                                Nama Instansi
                                                                Sekolah
                                                                (Opsional)
                                                            </div>
                                                            <div
                                                                class="col-lg-9 mb-5"
                                                            >
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    placeholder="Cth: SD 1 Surabaya"
                                                                    v-model="
                                                                        single.schoolName
                                                                    "
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    v-if="
                                        flagTab == 'family' &&
                                        pageStatus != 'page-load'
                                    "
                                    class="btn btn-success mb-10"
                                    type="button"
                                    @click="appendFamilyData(null)"
                                >
                                    <i class="fa fa-plus"></i>&ensp;Tambah
                                    Anggota Keluarga
                                </button>

                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    v-if="flagTab == 'sibling'"
                                >
                                    <div
                                        v-if="pageStatus == 'page-load'"
                                        class="w-100 d-flex justify-content-center mt-10 mb-10"
                                    >
                                        <app-loader></app-loader>
                                    </div>

                                    <div
                                        v-else
                                        class="card card-xl-stretch mb-5 mb-xl-8"
                                    >
                                        <div
                                            class="card-header border-0 pt-5 align-items-center justify-content-between"
                                        >
                                            <h3
                                                class="card-title align-items-start flex-column"
                                            >
                                                <span
                                                    class="card-label fw-bolder text-dark mb-2 c-primary-custom"
                                                    style="
                                                        font-size: 17px !important;
                                                    "
                                                    >Identitas Saudara</span
                                                >
                                            </h3>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row align-items-center">
                                                <template
                                                    v-for="(
                                                        context, index
                                                    ) in single.listSibling"
                                                    :key="index"
                                                >
                                                    <div
                                                        class="col-lg-3 mb-5 fw-bolder"
                                                        :class="
                                                            v$.$error &&
                                                            v$.single
                                                                .listSibling
                                                                .$each.$response
                                                                .$data[index]
                                                                .name.$error
                                                                ? 'text-danger'
                                                                : ''
                                                        "
                                                    >
                                                        Nama Saudara / Anak ke
                                                        {{ index + 1 }}
                                                    </div>
                                                    <div class="mb-5 col-lg-8">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            v-model="
                                                                context.name
                                                            "
                                                            placeholder="Cth: Yanto Ahmad"
                                                        />
                                                        <div
                                                            v-if="
                                                                v$.$error &&
                                                                v$.single
                                                                    .listSibling
                                                                    .$each
                                                                    .$response
                                                                    .$data[
                                                                    index
                                                                ].name.$error
                                                            "
                                                            class="text-danger"
                                                        >
                                                            Nama Saudara / Anak
                                                            tidak boleh kosong
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 mb-5">
                                                        <button
                                                            class="btn btn-light-danger"
                                                            type="button"
                                                            @click="
                                                                removeSiblingData(
                                                                    index
                                                                )
                                                            "
                                                        >
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </template>
                                                <div class="col-lg-12">
                                                    <button
                                                        class="btn btn-success mb-10"
                                                        type="button"
                                                        @click="
                                                            appendSiblingData(
                                                                null
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fa fa-plus"
                                                        ></i
                                                        >&ensp;Tambah Data
                                                        Saudara
                                                    </button>
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
import useVuelidate from "@vuelidate/core";

import every from "@/plugins/every";

import { helpers, required } from "@vuelidate/validators";

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
            flagTab: "family",
            pageStatus: "standby",
            v$: useVuelidate(),
            moneyConfig: {
                masked: false,
                prefix: "",
                suffix: "",
                thousands: ".",
                decimal: ",",
                precision: 0,
                disableNegative: false,
                disabled: false,
                min: null,
                max: null,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
            },
            idPenjangkauan: this.$route.params.idPenjangkauan,
            listRelationshipWithClient: [],
            listMaritalStatus: [],
            listReligion: [],
            listPlaceOfBirth: [],
            listDistrictFamilyCardAddress: [],
            listSubDistrictFamilyCardAddress: [],
            listDistrictResidenceAddress: [],
            listSubDistrictResidenceAddress: [],
            listEducation: [],
            listSchoolMajors: [],
            listClassEducation: [],
            listWork: [],
            listNatureOfWork: [
                {
                    id: "Tetap",
                    text: "Tetap",
                },
                {
                    id: "Tidak Tetap",
                    text: "Tidak Tetap",
                },
                {
                    id: "Lainnya",
                    text: "Lainnya",
                },
            ],
            listBpjsOwnership: [
                {
                    id: 1,
                    text: "PBI",
                },
                {
                    id: 2,
                    text: "Korporasi",
                },
                {
                    id: 3,
                    text: "Mandiri",
                },
                {
                    id: 4,
                    text: "Tidak Punya",
                },
            ],
            single: {
                listFamily: [],
                listSibling: [],
                // lastEducation: {},
                // schoolMajors: {},
                highestClass: {},
                schoolName: "",
                graduationYear: "",
            },
        };
    },
    validations() {
        return {
            single: {
                listFamily: {
                    $each: helpers.forEach({
                        relationshipWithClient: {
                            required,
                        },
                        name: {
                            required,
                        },
                        phone: {
                            required,
                        },
                        maritalStatus: {
                            required,
                        },
                        bpjsOwnership: {
                            required,
                        },
                        lastEducation: {
                            required,
                        },
                    }),
                },
                listSibling: {
                    $each: helpers.forEach({
                        name: {
                            required,
                        },
                    }),
                },
            },
        };
    },
    mounted() {
        reinitializeAllPlugin();

        this.pageStatus = "page-load";

        this.$store
            .dispatch(
                "complaint/getDetailComplaintOutreachClientFamily",
                this.$route.params.idPenjangkauan
            )
            .then((res) => {
                if (res.status == 200 || res.status == 201) {
                    for (
                        let i = 0;
                        i < res.data.data.keluarga_klien.length;
                        i++
                    ) {
                        this.appendFamilyData(res.data.data.keluarga_klien[i]);
                    }

                    for (
                        let i = 0;
                        i < res.data.data.saudara_klien.length;
                        i++
                    ) {
                        this.appendSiblingData(res.data.data.saudara_klien[i]);
                    }
                } else {
                    this.$axiosHandleError(res);
                }

                setTimeout(() => {
                    this.pageStatus = "standby";
                }, 1000);
            });
    },
    computed: {
        listHighestClass() {
            let result = [];
            for (let i = 1; i <= 12; i++) {
                result.push({
                    id: i,
                    text: i,
                });
            }
            return result;
        },
    },
    methods: {
        appendFamilyData(fromDB) {
            let isSameAddress = false;
            if (fromDB) {
                if (
                    fromDB.kk_address == fromDB.residence_address &&
                    fromDB.kelurahan_kk?.kecamatan?.id ==
                        fromDB.kelurahan_tinggal?.kecamatan?.id &&
                    fromDB.kelurahan_kk?.id == fromDB.kelurahan_tinggal?.id
                ) {
                    isSameAddress = true;
                }
            }
            this.single.listFamily.push({
                id: fromDB ? fromDB.id : "",
                relationshipWithClient:
                    fromDB && fromDB.hubungan
                        ? {
                              id: fromDB.hubungan.id,
                              text: fromDB.hubungan.name,
                          }
                        : {},
                name: fromDB ? fromDB.name : "",
                phone: fromDB ? fromDB.phone_number : "",
                maritalStatus:
                    fromDB && fromDB.status_pernikahan
                        ? {
                              id: fromDB.status_pernikahan.id,
                              text: fromDB.status_pernikahan.name,
                          }
                        : {},
                lastEducation:
                    fromDB && fromDB.pendidikan_terakhir
                        ? {
                              id: fromDB.pendidikan_terakhir.id,
                              text: fromDB.pendidikan_terakhir.name,
                          }
                        : {},
                schoolMajors:
                    fromDB && fromDB.jurusan
                        ? {
                              id: fromDB.jurusan.id,
                              text: fromDB.jurusan.name,
                          }
                        : {},
                classEducation: fromDB ? fromDB.classEducation : "",
                schoolName: fromDB ? fromDB.schoolName : "",
                graduationYear: fromDB ? fromDB.graduationYear : "",
                // schoolMajors: {
                //     id: '',
                //     text: ''
                // },
                religion:
                    fromDB && fromDB.agama
                        ? {
                              id: fromDB.agama.id,
                              text: fromDB.agama.name,
                          }
                        : {},
                placeOfBirth:
                    fromDB && fromDB.kabupaten_lahir
                        ? {
                              id: fromDB.kabupaten_lahir.id,
                              text: fromDB.kabupaten_lahir.name,
                          }
                        : {},
                dateOfBirth: fromDB ? fromDB.birth_date : "",
                nik: fromDB ? fromDB.nik_number : "",
                noKK: fromDB ? fromDB.kk_number : "",
                isSameAddress: isSameAddress,
                addressFamilyCard: fromDB ? fromDB.kk_address : "",
                districtFamilyCardAddress:
                    fromDB &&
                    fromDB.kelurahan_kk &&
                    fromDB.kelurahan_kk.kecamatan
                        ? {
                              id: fromDB.kelurahan_kk.kecamatan.id,
                              text: fromDB.kelurahan_kk.kecamatan.name,
                          }
                        : {},
                subDistrictFamilyCardAddress:
                    fromDB && fromDB.kelurahan_kk
                        ? {
                              id: fromDB.kelurahan_kk.id,
                              text: fromDB.kelurahan_kk.name,
                          }
                        : {},

                addressResidence: fromDB ? fromDB.residence_address : "",
                districtResidenceAddress:
                    fromDB &&
                    fromDB.kelurahan_tinggal &&
                    fromDB.kelurahan_tinggal.kecamatan
                        ? {
                              id: fromDB.kelurahan_tinggal.kecamatan.id,
                              text: fromDB.kelurahan_tinggal.kecamatan.name,
                          }
                        : {},
                subDistrictResidenceAddress:
                    fromDB && fromDB.kelurahan_tinggal
                        ? {
                              id: fromDB.kelurahan_tinggal.id,
                              text: fromDB.kelurahan_tinggal.name,
                          }
                        : {},

                work:
                    fromDB && fromDB.pekerjaan
                        ? {
                              id: fromDB.pekerjaan.id,
                              text: fromDB.pekerjaan.name,
                          }
                        : {},
                monthlyIncome: fromDB ? fromDB.monthly_income : "",
                natureOfWork: fromDB
                    ? fromDB.work_type == "Tetap" ||
                      fromDB.work_type == "Tidak Tetap"
                        ? fromDB.work_type
                        : "Lainnya"
                    : "",
                textNatureOfWorkOther: fromDB
                    ? fromDB.work_type != "Tetap" &&
                      fromDB.work_type != "Tidak Tetap"
                        ? fromDB.work_type
                        : ""
                    : "",
                bpjsOwnership: fromDB ? fromDB.bpjs_category : "",
            });
        },
        removeFamilyData(index) {
            this.single.listFamily.splice(index, 1);
        },
        appendSiblingData(fromDB) {
            this.single.listSibling.push({
                id: fromDB ? fromDB.id : "",
                name: fromDB ? fromDB.name : "",
            });
        },
        removeSiblingData(index) {
            this.single.listSibling.splice(index, 1);
        },
        getLatestEducation(keyword, limit) {
            this.getSelectList(
                `m-pendidikan-terakhir/lists?limit=${limit}&search=${keyword}`,
                "listEducation",
                "education-load"
            );
        },
        getSelectList(url, listKey, pageStatus = "select-load") {
            this.pageStatus = pageStatus;

            Api()
                .get(url)
                .then((response) => {
                    this[listKey] = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this[listKey].push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })
                .catch((error) => {
                    this[listKey] = [];
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.pageStatus = "standby";
                });
        },
        getRelationshipWithClient(keyword, limit) {
            this.getSelectList(
                `m-hubungan/lists?limit=${limit}&search=${keyword}`,
                "listRelationshipWithClient",
                "rel-client-load"
            );
        },
        getMaritalStatus(keyword, limit) {
            this.getSelectList(
                `m-status-pernikahan/lists?limit=${limit}&search=${keyword}`,
                "listMaritalStatus",
                "marital-status-load"
            );
        },
        getLatestEducation(keyword, limit) {
            this.getSelectList(
                `m-pendidikan-terakhir/lists?limit=${limit}&search=${keyword}`,
                "listEducation",
                "education-load"
            );
        },
        getReligion(keyword, limit) {
            this.getSelectList(
                `m-agama/lists?limit=${limit}&search=${keyword}`,
                "listReligion",
                "religion-load"
            );
        },
        getCity(keyword, limit) {
            this.getSelectList(
                `m-kabupaten/lists?limit=${limit}&search=${keyword}`,
                "listPlaceOfBirth",
                "city-load"
            );
        },
        getDistrict(keyword, limit, listKey, pageStatus = "district-load") {
            this.getSelectList(
                `m-kecamatan/lists?limit=${limit}&search=${keyword}`,
                listKey,
                pageStatus
            );
        },
        getSubDistrict(
            keyword,
            limit,
            listKey,
            pageStatus = "subdistrict-load",
            districtId = ""
        ) {
            this.getSelectList(
                `m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${districtId}`,
                listKey,
                pageStatus
            );
        },
        getProfession(keyword, limit) {
            this.getSelectList(
                `m-pekerjaan/lists?limit=${limit}&search=${keyword}`,
                "listWork",
                "profession-load"
            );
        },
        getSchoolMajors(keyword, limit) {
            this.getSelectList(
                `m-jurusan-sekolah/lists?limit=${limit}&search=${keyword}`,
                "listSchoolMajors",
                "school-major-load"
            );
        },
        calculateAge(val, index) {
            let x = this.$moment(val, "DD-MM-YYYY");
            let result = this.$moment().diff(x, "years");
            return result ? result : "0";
        },
        confirmPublishsave() {
            if (this.$store.state.profile.role_id != this.ROLE_KONSELOR_ID) {
                this.save(2);
                return false;
            }
            this.$swal({
                title: "Publish Survey?",
                text: "Data yang telah di publish tidak bisa di edit lagi",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#F64E60",
                cancelButtonColor: "#FFFFFF",
                cancelButtonTextColor: "black",
                confirmButtonText: "Ya, Publish",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.save(2);
                }
            });
        },
        save(is_publish) {
            this.v$.$reset();
            if (is_publish == 2) {
                this.v$.$touch();

                if (this.v$.$error) {
                    this.$toast.error("Silahkan lengkapi form dibawah!");
                    return false;
                }
            }

            let listFamily = [];
            let listSibling = [];

            for (let i = 0; i < this.single.listFamily.length; i++) {
                let family = this.single.listFamily[i];

                let objFamily = {
                    id: family.id,
                    nama: family.name,
                    id_hubungan: this.getValueSelect(
                        family.relationshipWithClient
                    ),
                    telepon: family.phone ? String(family.phone) : "",
                    id_status_pernikahan: this.getValueSelect(
                        family.maritalStatus
                    ),
                    id_agama: this.getValueSelect(family.religion),
                    id_kabupaten_lahir: this.getValueSelect(
                        family.placeOfBirth
                    ),
                    tanggal_lahir: family.dateOfBirth,
                    nik: family.nik,
                    no_kk: family.noKK,
                    alamat_domisili: family.addressResidence,
                    id_kelurahan_tinggal: this.getValueSelect(
                        family.subDistrictResidenceAddress
                    ),
                    alamat_kk: family.addressFamilyCard,
                    id_kelurahan_kk: this.getValueSelect(
                        family.subDistrictFamilyCardAddress
                    ),
                    id_pekerjaan: this.getValueSelect(family.work),
                    penghasilan: family.monthlyIncome,
                    sifat_pekerjaan:
                        family.natureOfWork == "Lainnya"
                            ? family.textNatureOfWorkOther
                            : family.natureOfWork,
                    tipe_bpjs: family.bpjsOwnership,
                    id_pendidikan_terakhir: this.getValueSelect(
                        family.lastEducation
                    ),
                    id_jurusan: this.getValueSelect(family.schoolMajors),
                    kelas: this.single.highestClass.text,
                    tahun_lulus: this.single.graduationYear,
                    nama_sekolah: this.single.schoolName,
                };

                objFamily = this.cleanObject(objFamily);

                listFamily.push(objFamily);
            }

            for (let i = 0; i < this.single.listSibling.length; i++) {
                let objSibling = {
                    id: this.single.listSibling[i].id,
                    nama: this.single.listSibling[i].name,
                    anak_ke: i + 1,
                };

                objSibling = this.cleanObject(objSibling);

                listSibling.push(objSibling);
            }
            let formData = {
                tipe_simpan: is_publish,
                keluarga: listFamily,
                saudara: listSibling,
            };

            this.$ewpLoadingShow();
            Api()
                .post(
                    "penjangkauan/" +
                        this.$route.params.idPenjangkauan +
                        "/keluarga_klien",
                    formData
                )
                .then((response) => {
                    this.$swal({
                        title: "Berhasil!",
                        text:
                            this.$store.state.profile.role_id ==
                            this.ROLE_KONSELOR_ID
                                ? is_publish == 2
                                    ? "Data berhasil dipublish"
                                    : "Data berhasil disimpan sebagai draft. Anda masih bisa mengubahnya dilain waktu"
                                : "Data berhasil disimpan",
                        icon: "success",
                    }).then((result) => {
                        this.$router.push({
                            name: "pengaduan",
                            params: { id: this.$route.params.id },
                            query: {
                                flag: "penjangkauan",
                            },
                        });
                    });
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .then(() => {
                    this.$ewpLoadingHide();
                });
        },
        getValueSelect(obj) {
            if (!obj) {
                return "";
            }
            return obj.id ? obj.id : "";
        },
        cleanObject(obj) {
            for (var propName in obj) {
                if (
                    obj[propName] === null ||
                    obj[propName] === undefined ||
                    obj[propName] === ""
                ) {
                    delete obj[propName];
                }
            }
            return obj;
        },
        ChangeCheckboxAddress(index) {
            this.single.listFamily[index].districtResidenceAddress = {};
            this.single.listFamily[index].subDistrictResidenceAddress = {};
            this.single.listFamily[index].addressResidence = "";

            if (this.single.listFamily[index].isSameAddress) {
                if (
                    this.single.listFamily[index].districtFamilyCardAddress.id
                ) {
                    this.single.listFamily[index].districtResidenceAddress = {
                        id: this.single.listFamily[index]
                            .districtFamilyCardAddress.id,
                        text: this.single.listFamily[index]
                            .districtFamilyCardAddress.text,
                    };
                }

                if (
                    this.single.listFamily[index].subDistrictFamilyCardAddress
                        .id
                ) {
                    setTimeout(() => {
                        this.single.listFamily[
                            index
                        ].subDistrictResidenceAddress = {
                            id: this.single.listFamily[index]
                                .subDistrictFamilyCardAddress.id,
                            text: this.single.listFamily[index]
                                .subDistrictFamilyCardAddress.text,
                        };
                    }, 200);
                }

                this.single.listFamily[index].addressResidence =
                    this.single.listFamily[index].addressFamilyCard;
            }
        },
    },
};
</script>

<style scoped>
.nav-tab-custom-x {
    padding: 10px;
    color: #a1a5b7;
    font-size: 15px;
}

.nav-tab-custom-x.active {
    border-bottom: 2px #ee7b33 solid;
    color: #ee7b33 !important;
    font-weight: 500;
}

.btn-not-selected {
    color: #a7a5a5;
    margin-right: 8px;
    margin-bottom: 8px;
    border: 1px #ddd solid !important;
}

.btn-not-selected.active {
    background-color: #ee7b33 !important;
    color: #fff !important;
}

@media (max-width: 991px) {
    .group-option-nature-of-work {
        display: block !important;
    }
}
</style>
