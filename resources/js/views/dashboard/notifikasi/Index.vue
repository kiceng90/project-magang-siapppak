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

                                <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-header border-0 pt-5 align-items-center">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder text-dark mb-2"
                                                    style="font-size:20px !important;">Notifikasi</span>
                                            </h3>
                                            <div v-if="listNotification.length > 0" style="cursor:pointer;"
                                                class="text-primary fw-bolder" @click="confirmReadAll()">Tandai Semua
                                                Telah Dibaca</div>

                                        </div>
                                        <div class="card-body pt-5">
                                            <template v-if="pageStatus == 'page-load'">
                                                <div
                                                    class="d-flex mt-8 mb-10 justify-content-center align-items-center">
                                                    <app-loader></app-loader>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="d-flex flex-column text-center justify-content-center align-items-center"
                                                    v-if="listNotification.length == 0">
                                                    <img :src="`${$assetUrl()}extends/img/empty.png`" />
                                                    <div class="text-gray-600 pt- text-center5">Tidak ada data
                                                        notifikasi</div>
                                                </div>
                                                <div class="d-flex flex-stack py-4 px-4"
                                                    :style="context.read_at ? '' : 'background:#FFF8DD !important;'"
                                                    v-for="context in listNotification">
                                                    <!--begin::Section-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-35px me-4">
                                                            <span class="symbol-label"
                                                                style="background:#fff !important;">
                                                                <!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
                                                                <span class="svg-icon svg-icon-2 svg-icon-warning"
                                                                    v-if="context?.data?.type == 0">

                                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
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


                                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                                                {{$noNullable(context.data ? context.data.description : '')}}
                                                            </div>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Section-->
                                                    <!--begin::Label-->
                                                    <span class="badge badge-light fs-8"
                                                        style="font-size:9px !important;">{{createdAgo(context.created_at)}}</span>
                                                    <!--end::Label-->
                                                </div>

                                                <template v-if="nextUrlNotification && pageStatus != 'load-more'">
                                                    <div class="d-flex justify-content-center">
                                                        <button type="button" @click="getMoreNotification"
                                                            class="btn btn-md bg-primary-custom text-white mt-10">Muat
                                                            Lainnya</button>
                                                    </div>
                                                </template>
                                                <template v-if="pageStatus == 'load-more'">
                                                    <div
                                                        class="d-flex mt-8 mb-10 justify-content-center align-items-center">
                                                        <app-loader></app-loader>
                                                    </div>
                                                </template>
                                            </template>
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
                listNotification: [],
                pageStatus: 'standby',
                nextUrlNotification: null,
            }

        },
        mounted() {
            reinitializeAllPlugin();

            this.getNotification();
        },
        methods: {
            getNotification() {
                this.pageStatus = 'page-load';
                Api().get(`notif?limit=8&page=1`)
                    .then(response => {
                        this.listNotification = response.data.data;

                        if (response.data.next_page_url) {
                            this.nextUrlNotification = 2;
                        }
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    });
            },
            getMoreNotification() {
                this.pageStatus = 'load-more';
                Api().get(`notif?limit=8&page=${this.nextUrlNotification}`)
                    .then(response => {

                        let result = this.listNotification.concat(response.data.data);

                        this.listNotification = result;

                        if (response.data.next_page_url) {
                            this.nextUrlNotification++;
                        } else {
                            this.nextUrlNotification = null
                        }

                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    });
            },
            readNotif(id, pengaduanId, readAt, to, puspagaRwId, pkbmId, satgasPpaId) {
                if (readAt) {
                    if (!to || to == 'pengaduan') {
                        this.$router.push({
                            name: 'pengaduan-detail',
                            params: { id: id}
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
                                name: 'pengaduan-detail',
                                params: { id: id }
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
            confirmReadAll() {
                this.$swal({
                    title: 'Konfirmasi!',
                    text: 'Semua notifikasi akan ditandai udah dibaca',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F64E60',
                    cancelButtonColor: '#FFFFFF',
                    cancelButtonTextColor: "black",
                    confirmButtonText: 'Ya, Tandai',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.readAll();
                    }
                });
            },
            readAll() {
                this.$ewpLoadingShow();
                Api().get(`notif/read`)
                    .then(response => {
                        this.$toast.success("Semua notifikasi berhasil ditandai telah dibaca!");
                        for (let i = 0; i < this.listNotification.length; i++) {
                            this.listNotification[i].read_at = 'now';
                        }
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$ewpLoadingHide();
                    });
            },
            createdAgo(datetime) {
                return moment(datetime).locale('id').fromNow();
            }
        }
    }

</script>

<style scoped>

</style>
