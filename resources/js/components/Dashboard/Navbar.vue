<template>
    <div>
        <div id="kt_header" class="header align-items-stretch">
            <!--begin::Container-->
            <div class="container-fluid d-flex align-items-stretch justify-content-between">
                <!--begin::Aside mobile toggle-->
                <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
                    <div class="btn btn-icon btn-active-light-danger w-30px h-30px w-md-40px h-md-40px"
                        id="kt_aside_mobile_toggle">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                    fill="black" />
                                <path opacity="0.3"
                                    d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Aside mobile toggle-->
                <!--begin::Mobile logo-->
                <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                    <a href="javascript:void(0)" class="d-lg-none">

                    </a>
                </div>
                <!--end::Mobile logo-->
                <!--begin::Wrapper-->
                <div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1">
                    <div class="d-flex align-items-stretch" id="kt_header_nav">
                        <div class="header-menu align-items-stretch bg-warning" data-kt-drawer="true"
                            data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                            data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                            data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle"
                            data-kt-swapper="true" data-kt-swapper-mode="prepend"
                            data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                            <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-warning menu-state-icon-warning menu-state-bullet-warning menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
                                id="#kt_header_menu" data-kt-menu="true">
                                <div class="menu-item p-2 me-10 d-none">
                                    <img :src="$assetUrl() + 'extends/img/logo-text.png'" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                        <!--begin::Menu- wrapper-->
                        <div class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                            style="position:relative;" data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                            @click="getNotificationTopnav()" data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen022.svg-->
                            <div v-if="unReadNotification > 0"
                                style="background:#F1416C;border-radius: 100px;width:10px;height:10px;position:absolute;right:8px;top:5px">
                            </div>
                            <span class="svg-icon svg-icon-1">

                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M13 23.833C14.7949 23.833 16.25 22.3779 16.25 20.583C16.25 18.7881 14.7949 17.333 13 17.333C11.2051 17.333 9.75 18.7881 9.75 20.583C9.75 22.3779 11.2051 23.833 13 23.833Z"
                                        fill="black" />
                                    <path
                                        d="M20.5837 16.2503V19.5003C20.5837 20.1503 20.1503 20.5837 19.5003 20.5837H6.50033C5.85033 20.5837 5.41699 20.1503 5.41699 19.5003V16.2503C6.60866 16.2503 7.58366 15.2753 7.58366 14.0837V10.8337C7.58366 8.23366 9.42533 6.06699 11.917 5.52532V3.25033C11.917 2.60033 12.3503 2.16699 13.0003 2.16699C13.6503 2.16699 14.0837 2.60033 14.0837 3.25033V5.52532C16.5753 6.06699 18.417 8.23366 18.417 10.8337V14.0837C18.417 15.2753 19.392 16.2503 20.5837 16.2503ZM11.917 10.8337C11.917 10.1837 12.3503 9.75033 13.0003 9.75033C13.6503 9.75033 14.0837 9.31699 14.0837 8.66699C14.0837 8.01699 13.6503 7.58366 13.0003 7.58366C11.1587 7.58366 9.75033 8.99199 9.75033 10.8337C9.75033 11.4837 10.1837 11.917 10.8337 11.917C11.4837 11.917 11.917 11.4837 11.917 10.8337Z"
                                        fill="#E4E6EF" />
                                </svg>

                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                            <!--begin::Heading-->
                            <div class="d-flex flex-column bgi-no-repeat rounded-top border-bottom">
                                <!--begin::Title-->
                                <h3 class="text-black fw-bold px-9 mt-10 mb-6">Notifikasi</h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Tab content-->

                            <!--begin::Tab panel-->
                            <!--begin::Items-->
                            <div class="d-flex mt-8 mb-10 justify-content-center align-items-center"
                                v-if="loadingNotificationTop">
                                <app-loader></app-loader>
                            </div>
                            <div class="scroll-y mh-325px my-5 px-8" v-else>
                                <!--begin::Item-->
                                <div class="d-flex flex-column justify-content-center align-items-center text-center"
                                    v-if="listNotificationTop.length == 0">
                                    <img :src="`${$assetUrl()}extends/img/empty.png`" style="width:150px" />
                                    <div class="text-gray-600 pt-5 text-center">Tidak ada data notifikasi</div>
                                </div>

                                <div class="d-flex flex-stack py-4 px-4"
                                    :style="context.read_at ? '' : 'background:#FFF8DD !important;'"
                                    v-for="context in listNotificationTop">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-35px me-4">
                                            <span class="symbol-label" style="background:#fff !important;">
                                                <!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
                                                <span class="svg-icon svg-icon-2 svg-icon-warning"
                                                    v-if="context?.data?.type == 0">

                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M4.85714 1H11.7364C12.0911 1 12.4343 1.12568 12.7051 1.35474L17.4687 5.38394C17.8057 5.66895 18 6.08788 18 6.5292V19.0833C18 20.8739 17.9796 21 16.1429 21H4.85714C3.02045 21 3 20.8739 3 19.0833V2.91667C3 1.12612 3.02045 1 4.85714 1ZM8 12C7.44772 12 7 12.4477 7 13C7 13.5523 7.44772 14 8 14H15C15.5523 14 16 13.5523 16 13C16 12.4477 15.5523 12 15 12H8ZM8 16C7.44772 16 7 16.4477 7 17C7 17.5523 7.44772 18 8 18H11C11.5523 18 12 17.5523 12 17C12 16.4477 11.5523 16 11 16H8Z"
                                                            fill="#FFC700" />
                                                        <path
                                                            d="M6.85714 3H14.7364C15.0911 3 15.4343 3.12568 15.7051 3.35474L20.4687 7.38394C20.8057 7.66895 21 8.08788 21 8.5292V21.0833C21 22.8739 20.9796 23 19.1429 23H6.85714C5.02045 23 5 22.8739 5 21.0833V4.91667C5 3.12612 5.02045 3 6.85714 3ZM8 12C7.44772 12 7 12.4477 7 13C7 13.5523 7.44772 14 8 14H15C15.5523 14 16 13.5523 16 13C16 12.4477 15.5523 12 15 12H8ZM8 16C7.44772 16 7 16.4477 7 17C7 17.5523 7.44772 18 8 18H11C11.5523 18 12 17.5523 12 17C12 16.4477 11.5523 16 11 16H8Z"
                                                            fill="#FFC700" />
                                                    </svg>
                                                </span>
                                                <span class="svg-icon svg-icon-2 svg-icon-success"
                                                    v-if="context?.data?.type == 1">


                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C9.9 15.3 9.9 14.7 10.3 14.3Z"
                                                            fill="#50CD89" />
                                                        <path
                                                            d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7L17.7 9.70001C18.1 9.30001 18.1 8.69999 17.7 8.29999C17.3 7.89999 16.7 7.89999 16.3 8.29999L11 13.6L7.70001 10.3C7.30001 9.89999 6.69999 9.89999 6.29999 10.3C5.89999 10.7 5.89999 11.3 6.29999 11.7L10.3 15.7C10.5 15.9 10.8 16 11 16C11.2 16 11.5 15.9 11.7 15.7Z"
                                                            fill="#50CD89" />
                                                    </svg>

                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div class="mb-0 me-2">
                                            <a href="javascript:void(0)"
                                                @click="readNotif(context.id, context.data?.id_pengaduan, context.read_at, context.data?.to, context.data?.id_puspaga_rw, context.data?.id_pkbm, context.data?.id_satgas_ppa)"
                                                class="fs-6 text-gray-800 text-hover-primary fw-bolder">{{$noNullable(context.data ? context.data.title : '')}}</a>
                                            <div class="text-gray-400 fs-7">
                                                {{$noNullable(context.data ? context.data.description : '')}}</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8"
                                        style="font-size:9px !important;">{{createdAgo(context.created_at)}}</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--begin::View more-->
                            <div class="py-3 text-center border-top" v-if="listNotificationTop.length > 0">
                                <router-link :to="{ name: 'notifikasi' }" class="btn btn-color-gray-600 btn-active-color-primary">
                                    Lihat Semua
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                transform="rotate(-180 18 13)" fill="currentColor" />
                                            <path
                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </router-link>
                                <!--end::View more-->

                                <!--end::Tab panel-->
                            </div>
                            <!--end::Tab content-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Menu wrapper-->
                    </div>
                    <div class="d-flex align-items-stretch flex-shrink-0">
                        <div class="d-flex align-items-stretch flex-shrink-0">
                            <div class="d-flex align-items-center ms-1 ms-lg-3">
                            </div>
                            <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                                <div class="btn btn-icon btn-color-primary btn-active-color-primary w-30px h-30px w-lg-40px h-lg-40px"
                                    data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <span class="symbol symbol-35px ml-4" style="margin-left: 10px !important;">
                                        <span
                                            class="symbol-label fs-3 bg-light-primary fw-bold text-primary _initial_profile"
                                            style="background:rgba(0, 180, 216, .24) !important;color:#00B4D8 !important">{{$store.state.profile.name ? $store.state.profile.name[0].toUpperCase() : '-'}}</span>
                                    </span>
                                </div>

                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-danger fw-bold py-4 fs-6 w-275px"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content d-flex align-items-center px-3">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-50px me-5">
                                                <span
                                                    class="symbol-label fs-3 bg-light-primary fw-bold text-primary _initial_profile"
                                                    style="background:rgba(0, 180, 216, .24) !important;color:#00B4D8 !important">{{$store.state.profile.name ? $store.state.profile.name[0].toUpperCase() : '-'}}</span>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Username-->
                                            <div class="d-flex flex-column">
                                                <div class="fw-bolder d-flex align-items-center fs-5" id="profil-nama">
                                                    {{$store.state.profile.name ? $store.state.profile.name : '-'}}
                                                </div>
                                                <a href="javascript:void(0)"
                                                    class="fw-bold text-muted text-hover-primary fs-7">{{$store.state.profile.role_name ? $store.state.profile.role_name : '-'}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-2"></div>
                                    <div class="menu-item px-5 my-1">
                                        <a href="javascript:void(0)" class="menu-link px-5"
                                            @click="showModalChangePassword">Ubah Password</a>
                                    </div>
                                    <div class="menu-item px-5">
                                        <a href="javascript:void(0)" class="menu-link px-5 text-danger" id="btn-logout"
                                            @click="logout">Keluar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <div class="modal fade" id="modal-change-password" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-500px">
                <div class="modal-content">
                    <div class="modal-header" id="ModalPassword_header">
                        <h2 class="invisible">Password</h2>
                        <div class="btn btn-sm btn-icon btn-active-color-warning" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="black" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body py-0">
                        <div class="card card-xxl-stretch mb-5 mb-xl-5">
                            <div class="card-body py-0">
                                <p class="fs-2 fw-bolder py-3 mb-10 text-center">Ubah Password
                                    <br /> <span class="text-gray-400 fs-5"> Pastikan untuk selalu mengingat password
                                        terbaru anda</span>
                                </p>

                                <div class="fv-row mb-5">
                                    <label class="form-label fw-bolder fs-6">Password Saat Ini</label>
                                    <input class="form-control" placeholder="Masukkan password"
                                        v-model="single.old_password" :type="hideOldPassword ? 'password' : 'text'"
                                        autocomplete="off" />
                                    <i id="icon-password" class="icon-password"
                                        @click="hideOldPassword = !hideOldPassword"
                                        :class="hideOldPassword ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>

                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label fw-bolder fs-6">Password Baru</label>
                                    <input class="form-control" placeholder="Masukkan password"
                                        v-model="single.new_password" :type="hideNewPassword ? 'password' : 'text'"
                                        autocomplete="off" />
                                    <i id="icon-password" class="icon-password"
                                        @click="hideNewPassword = !hideNewPassword"
                                        :class="hideNewPassword ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>

                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label fw-bolder fs-6">Konfirmasi Password Baru</label>
                                    <input class="form-control" placeholder="Masukkan password"
                                        v-model="single.confirm_password"
                                        :type="hideConfirmPassword ? 'password' : 'text'" autocomplete="off" />
                                    <i id="icon-password" class="icon-password"
                                        @click="hideConfirmPassword = !hideConfirmPassword"
                                        :class="hideConfirmPassword ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-right">
                        <button type="reset" class="btn btn-light me-3" :disabled="processChangePassword"
                            data-bs-dismiss="modal">Batal</button>
                        <button :disabled="processChangePassword" class="btn btn-primary bg-primary-custom"
                            @click="changePassword" type="button">
                            <span v-if="!processChangePassword" class="indicator-label text-white">Simpan</span>
                            <span v-if="processChangePassword" class="indicator-progress text-white">Please
                                wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    import Api from "@/services/api";

    export default {
        data() {
            return {
                hideOldPassword: true,
                hideNewPassword: true,
                hideConfirmPassword: true,
                processChangePassword: false,
                unReadNotification: 0,
                listNotificationTop: [],
                loadingNotificationTop: false,
                single: {
                    old_password: '',
                    new_password: '',
                    confirm_password: '',
                }
            }
        },
        mounted() {
            Api().get(`notif/check`)
                .then(response => {
                    this.unReadNotification = response.data ? parseInt(response.data) : 0;
                });
        },
        methods: {
            getNotificationTopnav() {
                if (this.loadingNotificationTop || this.listNotificationTop.length > 0) {
                    return false;
                }

                this.loadingNotificationTop = true;
                Api().get(`notif?limit=5&page=1`)
                    .then(response => {
                        this.listNotificationTop = response.data.data;
                    })
                    .catch(error => {

                    }).then(() => {
                        this.loadingNotificationTop = false;
                    });
            },
            readNotif(id, pengaduanId, readAt, to, puspagaRwId, pkbmId, satgasPpaId) {
                if (readAt) {
                    if (!to || to == 'pengaduan') {
                        this.$router.push({
                            name: 'pengaduan',
                            params: { id: pengaduanId }
                        })
                    }
                    if (to == 'puspaga_rw') {
                        this.$router.push({
                            name: 'd-puspaga',
                            query: {
                                data: puspagaRwId
                            }
                        })
                    }
                    if (to == 'pkbm') {
                        this.$router.push({
                            name: 'd-pkbm',
                            query: {
                                data: pkbmId
                            }
                        })
                    }
                    if (to == 'satgas_ppa') {
                        this.$router.push({
                            name: 'd-satgas-ppa',
                            query: {
                                data: satgasPpaId
                            }
                        })
                    }
                    return false;
                }

                this.$ewpLoadingShow();
                Api().get(`notif/read/${id}`)
                    .then(response => {
                        if (!to || to == 'pengaduan') {
                            this.$router.push({
                                name: 'pengaduan',
                                params: { id: pengaduanId }
                            })
                        }
                        if (to == 'puspaga_rw') {
                            this.$router.push({
                                name: 'd-puspaga',
                                query: {
                                    data: puspagaRwId
                                }
                            })
                        }
                        if (to == 'pkbm') {
                            this.$router.push({
                                name: 'd-pkbm',
                                query: {
                                    data: pkbmId
                                }
                            })
                        }
                        if (to == 'satgas_ppa') {
                            this.$router.push({
                                name: 'd-satgas-ppa',
                                query: {
                                    data: satgasPpaId
                                }
                            })
                        }
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            showModalChangePassword() {
                this.hideOldPassword = true;
                this.hideNewPassword = true;
                this.hideConfirmPassword = true;

                this.single.old_password = '';
                this.single.new_password = '';
                this.single.confirm_password = '';

                this.processChangePassword = false;

                $("#modal-change-password").modal('show');
            },
            changePassword() {
                this.processChangePassword = true;

                let formData = {
                    current_password: this.single.old_password,
                    password: this.single.new_password,
                    password_confirmation: this.single.confirm_password
                }

                Api().post('change-password', formData)
                    .then(response => {

                        $("#modal-change-password").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Mengubah Password Akun',
                            icon: "success",
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.processChangePassword = false;
                    });
            },
            logout() {

                Api().post('logout')
                    .then(response => {})
                    .catch(error => {}).then(() => {
                        localStorage.clear();

                        this.$store.commit('profile/SET_PROFILE_DATA', null);

                        this.$router.replace({
                            name: 'login'
                        })
                    });

            },
            createdAgo(datetime) {
                return moment(datetime).locale('id').fromNow();
            }
        }
    };

</script>
<style scoped>
    .icon-password {
        cursor: pointer;
        float: right;
        position: relative;
        bottom: 32px;
        right: 10px;
        font-size: 20px;
    }

</style>
