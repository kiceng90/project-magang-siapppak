<template>
    <div id="kt_aside" class="aside aside-light aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
        <div class="aside-logo flex-column-auto" id="kt_aside_logo">
            <div class="d-flex justify-content-center w-100">
                <img alt="Logo" :src="$assetUrl() + 'siapppak/images/logo-without-text.png'" class="logo" style="height:70px !important; margin-bottom: -10px;" />
            </div>
            <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-warning aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
                <span class="svg-icon svg-icon-1 rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="black" />
                        <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="black" />
                    </svg>
                </span>
            </div>
        </div>
        <div class="aside-menu flex-column-fluid">
            <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
                <div class="menu menu-column menu-title-gray-800 menu-state-title-warning menu-state-icon-warning menu-state-bullet-warning menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID,ROLE_SUBKORD_ID,ROLE_KABID_ID,ROLE_KONSELOR_ID, ROLE_ASISTEN_ID,ROLE_PENULIS_KONTEN_ID])">
                        <router-link :to="{ name: 'dashboard' }" class="menu-link" :class="isCurrentUrl(['dashboard']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M14 3V21H10V3C10 2.4 10.4 2 11 2H13C13.6 2 14 2.4 14 3ZM7 14H5C4.4 14 4 14.4 4 15V21H8V15C8 14.4 7.6 14 7 14Z" fill="#5E6278" />
                                        <path d="M21 20H20V8C20 7.4 19.6 7 19 7H17C16.4 7 16 7.4 16 8V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </router-link>
                    </div>
                    <div class="menu-item"
                        v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID,ROLE_KABID_ID,ROLE_KONSELOR_ID,ROLE_SUBKORD_ID,ROLE_HOTLINE_ID])">
                        <router-link :to="{ name: 'cek-pengaduan' }" class="menu-link"
                            :class="isCurrentUrl(['cek-pengaduan']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.7 18.9008L18.6001 15.8008C17.9001 16.9008 16.9 17.9008 15.8 18.6008L18.9 21.7008C19.3 22.1008 19.9 22.1008 20.3 21.7008L21.7 20.3008C22.1 19.9008 22.1 19.3008 21.7 18.9008Z" fill="#5E6278" />
                                        <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Cek Pengaduan</span>
                        </router-link>
                    </div>
                    <div class="menu-item menu-accordion" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID,ROLE_KONSELOR_ID, ROLE_KADIS_ID])" :class="isCurrentUrl(['klien','klien-kel','klien-puspaga']) ? 'show' : ''" data-kt-menu-trigger="click">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M18 2H20C21.6569 2 23 3.34315 23 5V19C23 20.6569 21.6569 22 20 22H18V2Z" fill="#7E8299" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 2H17C18.6569 2 20 3.34315 20 5V19C20 20.6569 18.6569 22 17 22H5C4.44772 22 4 21.5523 4 21V3C4 2.44772 4.44772 2 5 2ZM12 11C13.1046 11 14 10.1046 14 9C14 7.89543 13.1046 7 12 7C10.8954 7 10 7.89543 10 9C10 10.1046 10.8954 11 12 11ZM7.00036 16.4995C6.98863 16.662 7.26484 17 7.40417 17C11.4637 17 14.5228 17 16.5815 17C16.9988 17 17.0053 16.6222 16.9988 16.5C16.836 13.4332 14.6507 12 11.9907 12C9.36773 12 7.2157 13.5166 7.00036 16.4995Z" fill="#7E8299" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Data Klien</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <router-link :to="{ name: 'klien' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_KONSELOR_ID])" :class="isCurrentUrl(['klien']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">DP3APPKB</span>
                                </router-link>
                                <router-link :to="{ name: 'klien-kel' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])" :class="isCurrentUrl(['klien-kel']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">LaporPPA Kelurahan</span>
                                </router-link>
                                <router-link :to="{ name: 'klien-puspaga' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])" :class="isCurrentUrl(['klien-puspaga']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Puspaga</span>
                                </router-link>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item menu-accordion" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_KECAMATAN_ID, ROLE_KELURAHAN_ID])" :class="isCurrentUrl(['d-psikolog-volunter','d-konselor','d-pkbm','d-satgas-ppa','d-puspaga', 'd-mahasiswa']) ? 'show' : ''" data-kt-menu-trigger="click">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M3.95712 8.41504L11.4786 3.81859C11.7987 3.62297 12.2014 3.62297 12.5215 3.81859L20.0429 8.41504C20.6374 8.77835 21 9.42487 21 10.1216V19C21 20.1046 20.1046 21 19 21L5 21C3.89543 21 3 20.1046 3 19C3 19 3 19 3 19L3.00002 10.1216C3.00002 9.42486 3.36261 8.77835 3.95712 8.41504Z" fill="#7E8299" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.8 12C13.1562 12 12.4033 12.7299 12 13.2C11.5967 12.7299 10.8438 12 10.2 12C9.06042 12 8.40002 12.8889 8.40002 14.0202C8.40002 15.2734 9.60002 16.6 12 18C14.4 16.6 15.6 15.3 15.6 14.1C15.6 12.9687 14.9396 12 13.8 12Z" fill="#7E8299" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Database</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <router-link :to="{ name: 'd-psikolog-volunter' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])" :class="isCurrentUrl(['d-psikolog-volunter']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Psikolog Volunteer</span>
                                </router-link>
                                <router-link :to="{ name: 'd-konselor' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])" :class="isCurrentUrl(['d-konselor']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Konselor</span>
                                </router-link>
                                <router-link :to="{ name: 'd-pkbm' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_KECAMATAN_ID, ROLE_ADMIN_ID])" :class="isCurrentUrl(['d-pkbm']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">PKBM</span>
                                </router-link>
                                <router-link :to="{ name: 'd-satgas-ppa' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_KELURAHAN_ID, ROLE_ADMIN_ID])" :class="isCurrentUrl(['d-satgas-ppa']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Satgas PPA</span>
                                </router-link>
                                <!-- <router-link :to="{ name: 'd-satgas-ppa' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_KELURAHAN_ID, ROLE_ADMIN_ID])" :class="isCurrentUrl(['d-satgas-ppa']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Lapor PPAK</span>
                                </router-link> -->
                                <!-- https://ppa-dp3appkb.surabaya.go.id/api/siapppak/sync-login -->
                                <a id="syncLaporPPAK" href="#" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_KELURAHAN_ID, ROLE_ADMIN_ID, ROLE_FASILITATOR_ID])"
                                @click="redirectToLaporPPAK">
                                <MenuBullet />
                                <span class="menu-title">Lapor PPAK</span>
                                </a>
                                <router-link :to="{ name: 'd-puspaga'}" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_KECAMATAN_ID, ROLE_ADMIN_ID])" :class="isCurrentUrl(['d-puspaga']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Puspaga RW</span>
                                </router-link>
                                <router-link :to="{ name: 'd-mahasiswa'}" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_KABID_ID, ROLE_SUBKORD_ID, ROLE_HOTLINE_ID])" :class="isCurrentUrl(['d-mahasiswa']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Mahasiswa</span>
                                </router-link>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item pt-3 pb-1" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])">
                        <span class="menu-content text-gray-700 mb-0 fs-7 text-uppercase" style="font-weight:500">
                            DATA MASTER
                        </span>
                    </div>
                    <div class="menu-item menu-accordion" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])" :class="isCurrentUrl(['m-sumber-keluhan','m-tipe-permasalahan','m-lokasi-kejadian','m-kebutuhan-layanan','m-hubungan-dengan-klien','m-status-pernikahan','m-agama','m-pekerjaan','m-pendidikan-terakhir','m-jurusan-sekolah','m-kota','m-wilayah','m-intervensi','m-kecamatan','m-kelurahan','m-konselor','m-opd','m-user','m-instansi-pendidikan','m-jabatan-dalam-instansi','m-jabatan-dalam-sk','m-kategori-konseling','m-jadwal-konseling','m-kategori-konseling','m-mitra','m-balai-puspaga-rw','m-jenis-mahasiswa','m-kategori-monev','m-sub-kategori-monev','m-kuisioner-monev','m-kategori-mitra','m-jasa-pelayanan','m-posisi-mahasiswa']) ? 'show' : ''" data-kt-menu-trigger="click">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-muted svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M5 2H19C20.1046 2 21 2.89543 21 4V6C21 7.10457 20.1046 8 19 8H5C3.89543 8 3 7.10457 3 6V4C3 2.89543 3.89543 2 5 2ZM11 4C10.4477 4 10 4.44772 10 5C10 5.55228 10.4477 6 11 6H16C16.5523 6 17 5.55228 17 5C17 4.44772 16.5523 4 16 4H11ZM7 6C7.55228 6 8 5.55228 8 5C8 4.44772 7.55228 4 7 4C6.44772 4 6 4.44772 6 5C6 5.55228 6.44772 6 7 6Z" fill="#7E8299" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 9H19C20.1046 9 21 9.89543 21 11V13C21 14.1046 20.1046 15 19 15H5C3.89543 15 3 14.1046 3 13V11C3 9.89543 3.89543 9 5 9ZM11 11C10.4477 11 10 11.4477 10 12C10 12.5523 10.4477 13 11 13H16C16.5523 13 17 12.5523 17 12C17 11.4477 16.5523 11 16 11H11ZM7 13C7.55228 13 8 12.5523 8 12C8 11.4477 7.55228 11 7 11C6.44772 11 6 11.4477 6 12C6 12.5523 6.44772 13 7 13Z" fill="#7E8299" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 16H19C20.1046 16 21 16.8954 21 18V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V18C3 16.8954 3.89543 16 5 16ZM11 18C10.4477 18 10 18.4477 10 19C10 19.5523 10.4477 20 11 20H16C16.5523 20 17 19.5523 17 19C17 18.4477 16.5523 18 16 18H11ZM7 20C7.55228 20 8 19.5523 8 19C8 18.4477 7.55228 18 7 18C6.44772 18 6 18.4477 6 19C6 19.5523 6.44772 20 7 20Z" fill="#7E8299" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Master</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <router-link :to="{ name: 'm-kebutuhan-layanan' }" class="menu-link py-3" :class="isCurrentUrl(['m-kebutuhan-layanan']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Kebutuhan Layanan</span>
                                </router-link>
                                <router-link :to="{ name: 'm-sumber-keluhan' }" class="menu-link py-3" :class="isCurrentUrl(['m-sumber-keluhan']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Sumber Keluhan</span>
                                </router-link>
                                <router-link :to="{ name: 'm-tipe-permasalahan' }" class="menu-link py-3" :class="isCurrentUrl(['m-tipe-permasalahan']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Tipe Permasalahan</span>
                                </router-link>
                                <router-link :to="{ name: 'm-intervensi' }" class="menu-link py-3" :class="isCurrentUrl(['m-intervensi']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Intervensi</span>
                                </router-link>
                                <router-link :to="{ name: 'm-lokasi-kejadian' }" class="menu-link py-3" :class="isCurrentUrl(['m-lokasi-kejadian']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Lokasi Kejadian</span>
                                </router-link>
                                <router-link :to="{ name: 'm-hubungan-dengan-klien'}" class="menu-link py-3" :class="isCurrentUrl(['m-hubungan-dengan-klien']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Hubungan Dengan Klien</span>
                                </router-link>
                                <router-link :to="{ name: 'm-status-pernikahan' }" class="menu-link py-3" :class="isCurrentUrl(['m-status-pernikahan']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Status Pernikahan</span>
                                </router-link>
                                <router-link :to="{ name: 'm-agama' }" class="menu-link py-3" :class="isCurrentUrl(['m-agama']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Agama</span>
                                </router-link>
                                <router-link :to="{ name: 'm-pekerjaan' }" class="menu-link py-3" :class="isCurrentUrl(['m-pekerjaan']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Pekerjaan</span>
                                </router-link>
                                <router-link :to="{ name: 'm-pendidikan-terakhir' }" class="menu-link py-3" :class="isCurrentUrl(['m-pendidikan-terakhir']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Pendidikan Terakhir</span>
                                </router-link>
                                <router-link :to="{ name: 'm-jurusan-sekolah' }" class="menu-link py-3" :class="isCurrentUrl(['m-jurusan-sekolah']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Jurusan Sekolah</span>
                                </router-link>
                                <router-link :to="{ name: 'm-kota' }" class="menu-link py-3" :class="isCurrentUrl(['m-kota']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Kabupaten/Kota</span>
                                </router-link>
                                <router-link :to="{ name: 'm-wilayah' }" class="menu-link py-3" :class="isCurrentUrl(['m-wilayah']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Wilayah</span>
                                </router-link>
                                <router-link :to="{ name: 'm-kecamatan' }" class="menu-link py-3" :class="isCurrentUrl(['m-kecamatan']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Kecamatan</span>
                                </router-link>
                                <router-link :to="{ name: 'm-kelurahan' }" class="menu-link py-3" :class="isCurrentUrl(['m-kelurahan']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Kelurahan</span>
                                </router-link>
                                <router-link :to="{ name: 'm-konselor' }" class="menu-link py-3" :class="isCurrentUrl(['m-konselor']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Konselor</span>
                                </router-link>
                                <router-link :to="{ name: 'm-opd' }" class="menu-link py-3" :class="isCurrentUrl(['m-opd']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">OPD</span>
                                </router-link>
                                <router-link :to="{ name: 'm-user' }" class="menu-link py-3" :class="isCurrentUrl(['m-user']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">User</span>
                                </router-link>
                                <router-link :to="{ name: 'm-instansi-pendidikan' }" class="menu-link py-3" :class="isCurrentUrl(['m-instansi-pendidikan']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Instansi Pendidikan</span>
                                </router-link>
                                <router-link :to="{ name: 'm-jabatan-dalam-instansi' }" class="menu-link py-3" :class="isCurrentUrl(['m-jabatan-dalam-instansi']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Jabatan Dalam Instansi</span>
                                </router-link>
                                 <router-link :to="{ name: 'm-jabatan-dalam-sk' }" class="menu-link py-3" :class="isCurrentUrl(['m-jabatan-dalam-sk']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Jabatan Dalam SK</span>
                                </router-link>
                                <router-link :to="{ name: 'm-kategori-konseling' }" class="menu-link py-3" :class="isCurrentUrl(['m-kategori-konseling']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Kategori Konseling</span>
                                </router-link>
                                 <router-link :to="{ name: 'm-jadwal-konseling' }" class="menu-link py-3" :class="isCurrentUrl(['m-jadwal-konseling']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Jadwal Konseling</span>
                                </router-link>
                                <router-link :to="{ name: 'm-kategori-mitra' }" class="menu-link py-3" :class="isCurrentUrl(['m-kategori-mitra']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Kategori Mitra</span>
                                </router-link>
                                <router-link :to="{ name: 'm-mitra' }" class="menu-link py-3" :class="isCurrentUrl(['m-mitra']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Mitra</span>
                                </router-link>
                                <router-link :to="{ name: 'm-balai-puspaga-rw' }" class="menu-link py-3" :class="isCurrentUrl(['m-balai-puspaga-rw']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Puspaga Balai RW</span>
                                </router-link>
                                <router-link :to="{ name: 'm-jenis-mahasiswa' }" class="menu-link py-3" :class="isCurrentUrl(['m-jenis-mahasiswa']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Jenis Mahasiswa</span>
                                </router-link>
                                <div class="menu-item menu-accordion" :class="isCurrentUrl(['m-laporan-monev','m-kategori-monev','m-sub-kategori-monev','m-kuisioner-monev']) ? 'show' : ''" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])" data-kt-menu-trigger="click">
                                    <a class="menu-link" href="javascript:void(0);" style="padding-left: calc(.75rem + 25px)">
                                        <MenuBullet />
                                        <span class="menu-title">Laporan Monev</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <router-link :to="{ name: 'm-kategori-monev'}" class="menu-link py-3" :class="isCurrentUrl(['m-kategori-monev']) ? 'active' : ''">
                                                <span class="menu-icon"></span>
                                                <MenuBullet />
                                                <span class="menu-title">Kategori</span>
                                            </router-link>
                                            <router-link :to="{ name: 'm-sub-kategori-monev' }" class="menu-link py-3" :class="isCurrentUrl(['m-sub-kategori-monev']) ? 'active' : ''">
                                                <span class="menu-icon"></span>
                                                <MenuBullet />
                                                <span class="menu-title">Sub Kategori</span>
                                            </router-link>
                                            <router-link :to="{ name: 'm-kuisioner-monev' }" class="menu-link py-3" :class="isCurrentUrl(['m-kuisioner-monev']) ? 'active' : ''">
                                                <span class="menu-icon"></span>
                                                <MenuBullet />
                                                <span class="menu-title">Kuisioner</span>
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                                <router-link :to="{ name: 'm-jasa-pelayanan' }" class="menu-link py-3" :class="isCurrentUrl(['m-jasa-pelayanan']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Jasa Pelayanan</span>
                                </router-link>
                                <router-link :to="{ name: 'm-posisi-mahasiswa' }" class="menu-link py-3" :class="isCurrentUrl(['m-posisi-mahasiswa']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Posisi Mahasiswa</span>
                                </router-link>
                                <div class="menu-item menu-accordion" :class="isCurrentUrl(['m-rumah-perubahan-kategori','m-rumah-perubahan-materi','laporan-database-rumahperubahan']) ? 'show' : ''" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])" data-kt-menu-trigger="click">
                                    <a class="menu-link" href="javascript:void(0);" style="padding-left: calc(.75rem + 25px)">
                                        <MenuBullet />
                                        <span class="menu-title">Master Rumah Perubahan</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <router-link :to="{ name: 'm-rumah-perubahan-kategori'}" class="menu-link py-3" :class="isCurrentUrl(['m-rumah-perubahan-kategori']) ? 'active' : ''">
                                                <span class="menu-icon"></span>
                                                <MenuBullet />
                                                <span class="menu-title">Kategori</span>
                                            </router-link>
                                            <router-link :to="{ name: 'm-rumah-perubahan-materi'}" class="menu-link py-3" :class="isCurrentUrl(['m-rumah-perubahan-materi']) ? 'active' : ''">
                                                <span class="menu-icon"></span>
                                                <MenuBullet />
                                                <span class="menu-title">Materi</span>
                                            </router-link>
                                            <router-link :to="{ name: 'laporan-database-rumahperubahan'}" class="menu-link py-3" :class="isCurrentUrl(['laporan-database-rumahperubahan']) ? 'active' : ''">
                                                <span class="menu-icon"></span>
                                                <MenuBullet />
                                                <span class="menu-title">Database</span>
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item pt-5 pb-1" v-if="$store.state.profile.role_id && $store.state.profile.role_id != ROLE_ASISTEN_ID && $store.state.profile.role_id != ROLE_KECAMATAN_ID && $store.state.profile.role_id != ROLE_KELURAHAN_ID">
                        <span class="menu-content text-gray-700 mb-0 fs-7 text-uppercase" style="font-weight:500">
                            MENU UTAMA
                        </span>
                    </div>
                    <div class="menu-item" v-if="notInRoles([ROLE_ASISTEN_ID, ROLE_KECAMATAN_ID, ROLE_KELURAHAN_ID, ROLE_KLIEN_ID, ROLE_PENULIS_KONTEN_ID, ROLE_MAHASISWA_ID, ROLE_FASILITATOR_ID, ROLE_PSIKOLOG_ID])">
                        <router-link :to="{ name: 'pengaduan' }" class="menu-link" :class="isCurrentUrl(['pengaduan']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Pengaduan</span>
                        </router-link>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_KLIEN_ID, ROLE_KONSELOR_ID, ROLE_ADMIN_ID, ROLE_PSIKOLOG_ID])">
                        <router-link :to="{name: 'riwayat-konseling'}" class="menu-link py-3" :class="isCurrentUrl(['riwayat-konseling']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Riwayat Konseling</span>
                        </router-link>
                    </div>
<<<<<<< Updated upstream
                    <!-- <div 
                        class="menu-item menu-accordion" 
                        v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_KONSELOR_ID, ROLE_SUBKORD_ID, ROLE_KABID_ID, ROLE_KECAMATAN_ID])" 
                        :class="isCurrentUrl(['standarisasi-puspaga', 'm-standarisasi-persyaratan','m-standarisasi-indikator','m-standarisasi-pertanyaan']) ? 'show' : ''" 
                        data-kt-menu-trigger="click"
                    >
                        <a class="menu-link" href="javascript:void(0);">
=======
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID, ROLE_ADMIN_ID])">
                        <router-link :to="{name: 'buku-tamu-dashboard'}" class="menu-link py-3" :class="isCurrentUrl(['buku-tamu-dashboard']) ? 'active' : ''">
>>>>>>> Stashed changes
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
<<<<<<< Updated upstream
                            <span class="menu-title">Standarisasi Puspaga</span>
                            <span class="menu-arrow"></span>
                        </a> -->

                        <!-- Submenu Standarisasi Puspaga -->
                        <!-- <div class="menu-sub menu-sub-accordion"> -->
                            <!-- Master Standarisasi 2 (Only for Admin) -->
                            <!-- <div 
                                class="menu-item menu-accordion" 
                                v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])" 
                                :class="isCurrentUrl(['m-standarisasi-persyaratan','m-standarisasi-indikator','m-standarisasi-pertanyaan']) ? 'show' : ''" 
                                data-kt-menu-trigger="click"
                            >
                                <a class="menu-link" href="javascript:void(0);" style="padding-left: calc(.75rem + 25px)">
                                    <MenuBullet />
                                    <span class="menu-title">Master Standarisasi</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item">
                                        <router-link 
                                            :to="{ name: 'm-standarisasi-persyaratan' }" 
                                            class="menu-link py-3" 
                                            :class="isCurrentUrl(['m-standarisasi-persyaratan']) ? 'active' : ''"
                                        >
                                            <MenuBullet />
                                            <span class="menu-title">Database Persyaratan</span>
                                        </router-link>

                                        <router-link 
                                            :to="{ name: 'm-standarisasi-indikator' }" 
                                            class="menu-link py-3" 
                                            :class="isCurrentUrl(['m-standarisasi-indikator']) ? 'active' : ''"
                                        >
                                            <MenuBullet />
                                            <span class="menu-title">Database Indikator</span>
                                        </router-link>

                                        <router-link 
                                            :to="{ name: 'm-standarisasi-pertanyaan' }" 
                                            class="menu-link py-3" 
                                            :class="isCurrentUrl(['m-standarisasi-pertanyaan']) ? 'active' : ''"
                                        >
                                            <MenuBullet />
                                            <span class="menu-title">Database Pertanyaan</span>
                                        </router-link>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Standarisasi Puspaga -->
                            <!-- <div class="menu-item">
                                <router-link 
                                    :to="{ name: 'standarisasi-puspaga' }" 
                                    class="menu-link py-3" 
                                    v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_KONSELOR_ID, ROLE_SUBKORD_ID, ROLE_KABID_ID, ROLE_KECAMATAN_ID])" 
                                    :class="isCurrentUrl(['standarisasi-puspaga']) ? 'active' : ''"
                                >
                                    <MenuBullet />
                                    <span class="menu-title">Standarisasi Puspaga</span>
                                </router-link>
                            </div>
                        </div>
                    </div> -->

                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID])">
                        <router-link :to="{name: 'rumah-perubahan'}" class="menu-link py-3" :class="isCurrentUrl(['rumah-perubahan']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Rumah Perubahan</span>
                        </router-link>
                    </div>

=======
                            <span class="menu-title">Tamu Puspaga</span>
                        </router-link>
                    </div>
>>>>>>> Stashed changes
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_KLIEN_ID, ROLE_KONSELOR_ID, ROLE_MAHASISWA_ID, ROLE_PSIKOLOG_ID])">
                        <router-link :to="{name: 'elearning-puspaga'}" class="menu-link py-3" :class="isCurrentUrl(['elearning-puspaga', 'elearningpuspaga-kategori', 'elearningpuspaga-subkategori', 'elearningpuspaga-riwayatlatihansoal', 'elearningpuspaga-materi-modul', 'elearningpuspaga-materi-video', 'elearningpuspaga-hasillatihansoal']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Elearning Puspaga</span>
                        </router-link>
                    </div>
                    <div class="menu-item menu-accordion" v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID, ROLE_ADMIN_ID, ROLE_PSIKOLOG_ID])" :class="isCurrentUrl(['elearning-materi','elearning-db', 'elearning-kategori', 'elearning-subkategori', 'elearning-latihansoal', 'detaillatihansoal', 'elearning-detail-materi']) ? 'show' : ''" data-kt-menu-trigger="click">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">E-Learning</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <router-link :to="{ name: 'elearning-kategori' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID, ROLE_ADMIN_ID, ROLE_PSIKOLOG_ID])" :class="isCurrentUrl(['elearning-kategori']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Kategori</span>
                                </router-link>
                                <router-link :to="{ name: 'elearning-subkategori' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID, ROLE_ADMIN_ID, ROLE_PSIKOLOG_ID])" :class="isCurrentUrl(['elearning-subkategori']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Sub Kategori</span>
                                </router-link>
                                <router-link :to="{ name: 'elearning-materi' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_KONSELOR_ID, ROLE_ADMIN_ID, ROLE_PSIKOLOG_ID])" :class="isCurrentUrl(['elearning-materi', 'elearning-detail-materi']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Materi</span>
                                </router-link>
                                <router-link :to="{ name: 'elearning-db' }" class="menu-link py-3" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID])" :class="isCurrentUrl(['elearning-db']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Database Peserta</span>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_PENULIS_KONTEN_ID])">
                        <router-link :to="{name: 'kie'}" class="menu-link py-3" :class="isCurrentUrl(['kie']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">KIE</span>
                        </router-link>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_PENULIS_KONTEN_ID, ROLE_MAHASISWA_ID])">
                        <router-link :to="{name: 'artikel'}" class="menu-link py-3" :class="isCurrentUrl(['artikel']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Artikel PPA</span>
                        </router-link>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_KONSELOR_ID, ROLE_SUBKORD_ID, ROLE_MAHASISWA_ID])">
                        <router-link :to="{name: 'kegiatan-mahasiswa'}" class="menu-link py-3" :class="isCurrentUrl(['kegiatan-mahasiswa']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Laporan Kegiatan Mahasiswa</span>
                        </router-link>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_FASILITATOR_ID])">
                        <router-link :to="{name: 'kegiatan-fasilitator'}" class="menu-link py-3" :class="isCurrentUrl(['kegiatan-fasilitator']) ? 'active' : ''">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="#5E6278" />
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="#5E6278" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Laporan Kegiatan Fasilitator Puspaga Balai RW</span>
                        </router-link>
                    </div>
                    <div
                        class="menu-item"
                        v-if="isSpecificHaveAccessMenu([ROLE_ADMIN_ID, ROLE_KONSELOR_ID])"
                    >
                        <router-link
                            :to="{ name: 'kegiatan-monev' }"
                            class="menu-link py-3"
                            :class="
                                isCurrentUrl(['kegiatan-monev']) ? 'active' : ''
                            "
                        >
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            opacity="0.3"
                                            d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z"
                                            fill="#5E6278"
                                        />
                                        <path
                                            d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z"
                                            fill="#5E6278"
                                        />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Laporan Monev</span>
                        </router-link>
                    </div>

                    <div class="menu-item pt-5 pb-1" v-if="notInRoles([ROLE_ASISTEN_ID, ROLE_KELURAHAN_ID, ROLE_KECAMATAN_ID, ROLE_KLIEN_ID, ROLE_PENULIS_KONTEN_ID, ROLE_MAHASISWA_ID, ROLE_FASILITATOR_ID, ROLE_PSIKOLOG_ID])">
                        <span class="menu-content text-gray-700 mb-0 fs-7 text-uppercase" style="font-weight:500">
                            LAPORAN
                        </span>
                    </div>
                    <div class="menu-item menu-accordion" :class="isCurrentUrl(['m-laporan','laporan-rekap','laporan-kasus-klien']) ? 'show' : ''" v-if="notInRoles([ROLE_ASISTEN_ID, ROLE_OPD_ID, ROLE_KELURAHAN_ID, ROLE_KECAMATAN_ID, ROLE_KLIEN_ID, ROLE_PENULIS_KONTEN_ID, ROLE_MAHASISWA_ID, ROLE_FASILITATOR_ID, ROLE_PSIKOLOG_ID])" data-kt-menu-trigger="click">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-muted svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 17V21C16 21.5523 15.5523 22 15 22H9C8.44772 22 8 21.5523 8 21V17H5C3.89543 17 3 16.1046 3 15V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V15C21 16.1046 20.1046 17 19 17H16ZM17.5 11C18.3284 11 19 10.3284 19 9.5C19 8.67157 18.3284 8 17.5 8C16.6716 8 16 8.67157 16 9.5C16 10.3284 16.6716 11 17.5 11ZM10 14V20H14V14H10Z" fill="#7E8299" />
                                        <path opacity="0.3" d="M15 2H9C8.44772 2 8 2.44772 8 3C8 3.55228 8.44772 4 9 4H15C15.5523 4 16 3.55228 16 3C16 2.44772 15.5523 2 15 2Z" fill="#7E8299" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Laporan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <router-link :to="{ name: 'laporan-rekap'}" class="menu-link py-3" :class="isCurrentUrl(['laporan-rekap']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Laporan Rekap</span>
                                </router-link>
                                <router-link :to="{ name: 'laporan-kasus-klien' }" class="menu-link py-3" :class="isCurrentUrl(['laporan-kasus-klien']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Laporan Kasus Klien</span>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item menu-accordion" :class="isCurrentUrl(['laporan-rekap-elearning','laporan-database-elearning']) ? 'show' : ''" v-if="notInRoles([ROLE_ASISTEN_ID, ROLE_OPD_ID, ROLE_KELURAHAN_ID, ROLE_KECAMATAN_ID, ROLE_KLIEN_ID, ROLE_PENULIS_KONTEN_ID, ROLE_MAHASISWA_ID, ROLE_FASILITATOR_ID, ROLE_PSIKOLOG_ID])" data-kt-menu-trigger="click">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-muted svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 17V21C16 21.5523 15.5523 22 15 22H9C8.44772 22 8 21.5523 8 21V17H5C3.89543 17 3 16.1046 3 15V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V15C21 16.1046 20.1046 17 19 17H16ZM17.5 11C18.3284 11 19 10.3284 19 9.5C19 8.67157 18.3284 8 17.5 8C16.6716 8 16 8.67157 16 9.5C16 10.3284 16.6716 11 17.5 11ZM10 14V20H14V14H10Z" fill="#7E8299" />
                                        <path opacity="0.3" d="M15 2H9C8.44772 2 8 2.44772 8 3C8 3.55228 8.44772 4 9 4H15C15.5523 4 16 3.55228 16 3C16 2.44772 15.5523 2 15 2Z" fill="#7E8299" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Laporan E-Learning</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <router-link :to="{ name: 'laporan-rekap-elearning' }" class="menu-link py-3" :class="isCurrentUrl(['laporan-rekap-elearning']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Laporan Rekap E-Learning</span>
                                </router-link>
                                <router-link :to="{ name: 'laporan-database-elearning' }" class="menu-link py-3" :class="isCurrentUrl(['laporan-database-elearning']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Laporan Database E-Learning</span>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item menu-accordion" :class="isCurrentUrl(['laporan-rekap-puspaga','laporan-database-puspaga']) ? 'show' : ''" v-if="notInRoles([ROLE_ASISTEN_ID, ROLE_OPD_ID, ROLE_KELURAHAN_ID, ROLE_KECAMATAN_ID, ROLE_KLIEN_ID, ROLE_PENULIS_KONTEN_ID, ROLE_MAHASISWA_ID, ROLE_FASILITATOR_ID, ROLE_PSIKOLOG_ID])" data-kt-menu-trigger="click">
                        <a class="menu-link" href="javascript:void(0);">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-muted svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 17V21C16 21.5523 15.5523 22 15 22H9C8.44772 22 8 21.5523 8 21V17H5C3.89543 17 3 16.1046 3 15V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V15C21 16.1046 20.1046 17 19 17H16ZM17.5 11C18.3284 11 19 10.3284 19 9.5C19 8.67157 18.3284 8 17.5 8C16.6716 8 16 8.67157 16 9.5C16 10.3284 16.6716 11 17.5 11ZM10 14V20H14V14H10Z" fill="#7E8299" />
                                        <path opacity="0.3" d="M15 2H9C8.44772 2 8 2.44772 8 3C8 3.55228 8.44772 4 9 4H15C15.5523 4 16 3.55228 16 3C16 2.44772 15.5523 2 15 2Z" fill="#7E8299" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Laporan Puspaga</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <router-link :to="{ name: 'laporan-rekap-puspaga' }" class="menu-link py-3" :class="isCurrentUrl(['laporan-rekap-puspaga']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Rekap Puspaga</span>
                                </router-link>
                                <router-link :to="{ name: 'laporan-database-puspaga' }" class="menu-link py-3" :class="isCurrentUrl(['laporan-database-puspaga']) ? 'active' : ''">
                                    <MenuBullet />
                                    <span class="menu-title">Database Puspaga</span>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside menu-->
    </div>
</template>

<script>
    import MenuBullet from './MenuBullet.vue'
    export default {
        components: {MenuBullet},
        data() {
            return {
                ROLE_ADMIN_ID: process.env.MIX_ROLE_ADMIN_ID,
                ROLE_KABID_ID: process.env.MIX_ROLE_KABID_ID,
                ROLE_KADIS_ID: process.env.MIX_ROLE_KADIS_ID,
                ROLE_KONSELOR_ID: process.env.MIX_ROLE_KONSELOR_ID,
                ROLE_PSIKOLOG_ID: process.env.MIX_ROLE_PSIKOLOG_ID,
                ROLE_SUBKORD_ID: process.env.MIX_ROLE_SUBKORD_ID,
                ROLE_OPD_ID: process.env.MIX_ROLE_OPD_ID,
                ROLE_HOTLINE_ID: process.env.MIX_ROLE_HOTLINE_ID,
                ROLE_ASISTEN_ID: process.env.MIX_ROLE_ASISTEN_ID,
                ROLE_KECAMATAN_ID: process.env.MIX_ROLE_KECAMATAN_ID,
                ROLE_KELURAHAN_ID: process.env.MIX_ROLE_KELURAHAN_ID,
                ROLE_KLIEN_ID: process.env.MIX_ROLE_KLIEN_ID,
                ROLE_PENULIS_KONTEN_ID: process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                ROLE_MAHASISWA_ID: process.env.MIX_ROLE_MAHASISWA_ID,
                ROLE_FASILITATOR_ID: process.env.MIX_ROLE_FASILITATOR_ID,
            }
        },
        mounted() {},
        methods: {
            isSpecificHaveAccessMenu(roles = []) {
                let response = false;
                if (roles.filter((e) => e == this.$store.state.profile.role_id).length > 0) {
                    response = true;
                }

                return response;
            },
            isCurrentUrl(routeName) {
                let response = false;
                for (let i = 0; i < routeName.length; i++) {
                    if (this.$route.name == routeName[i]) {
                        return true;
                    }
                }

                return response;
            },
            notInRoles(roles_id = []){
                return !roles_id.includes(`${this.$store.state.profile.role_id}`)
            },
            async redirectToLaporPPAK() {
                try {
                    // Ambil token dari localStorage atau Vuex (sesuai implementasi SIAPPPAK)
                    let token = localStorage.getItem('dp5a-token'); // Sesuaikan jika penyimpanan berbeda
                    
                    if (!token) {
                        alert('Token tidak ditemukan. Silakan login ulang.');
                        return;
                    }

                    // URL tujuan di LaporPPAK
                    let redirectUrl = `https://ppa-dp3appkb.surabaya.go.id/api_newpetra/api/siapppak/sync-login?token=${token}`;

                    // Redirect ke LaporPPAK
                    window.location.href = redirectUrl;
                } catch (error) {
                    console.error('Error redirecting to LaporPPAK:', error);
                }
            }
        },
        computed: {
            // getLaporPPAK() {
            //     const token = localStorage.getItem('dp5a-token');
            //     if (token) {
            //     return `https://ppa-dp3appkb.surabaya.go.id/laporppa/internal/auth/sync-login?token=${token}`;
            //     }
            //     return "https://ppa-dp3appkb.surabaya.go.id/laporppa/internal/dashboard";
            // }
            
            // dp5aToken() {
            //     return localStorage.getItem("dp5a-token") || '';
            // },            
        }

    };
</script>
