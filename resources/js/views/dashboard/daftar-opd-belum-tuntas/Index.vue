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
                                                    <h4>Daftar OPD Belum Tuntas</h4>
                                                </div>
                                                <div>
                                                    &ensp;<span class="text-muted">
                                                        <a href="javascript:void(0)" @click="$router.back()"
                                                            class="text-muted"
                                                            style="text-decoration:none;">Dashboard</a>
                                                        - Daftar OPD Belum Tuntas
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-5">
                                    <div class="col-lg-8">
                                        <h1>Daftar OPD Belum Tuntas</h1>
                                    </div>
                                    <div class="col-lg-4 d-flex" style="justify-content:flex-end;">
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
                                <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-header border-0 pt-5 align-items-center"
                                            style="flex-direction:column;justify-content:center">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder text-dark mb-2"
                                                    style="font-size:20px !important;">{{$rupiahFormat(data.totalOpd)}}
                                                    OPD Belum
                                                    Tuntas</span>
                                            </h3>
                                            <div class="text-gray-600 fs-4">Terdapat <span class="fw-bolder"
                                                    style="color:rgb(241, 65, 108) !important">{{$rupiahFormat(data.totalKasus)}}
                                                    Kasus Klien</span> belum tuntas ditangani oleh OPD</div>

                                        </div>
                                        <div class="card-body pt-5">
                                            <div v-if="loader.intervensiOpd == true"
                                                class="d-flex justify-content-center align-items-center mb-5">
                                                <app-loader></app-loader>
                                            </div>
                                            <div v-else>
                                                <div class="d-flex flex-column text-center justify-content-center align-items-center"
                                                    v-if=" data?.intervensiOpd.length == 0">
                                                    <img :src="`${$assetUrl()}extends/img/empty.png`" />
                                                    <div class="text-gray-600 pt-5 text-center">Tidak ada data yang
                                                        dapat
                                                        ditampilkan</div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-8">
                                                        <template v-for="(context, index) in data.intervensiOpd">
                                                            <div class="fw-bolder fs-4 ">{{context.opd_name}}</div>
                                                            <div class="c-primary-custom fw-bolder pb-3 ">
                                                                {{$rupiahFormat(context.intervensi.length)}}
                                                                Intervensi Kasus</div>
                                                            <template v-for="(detail, idxDetail) in context.intervensi">
                                                                <div class="row">
                                                                    <div class="col-lg-7 mb-5">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="text-white bg-primary me-3 text-center d-flex justify-content-center align-items-center"
                                                                                style="border-radius:8px;width:25px;height:25px;">
                                                                                {{idxDetail + 1}}
                                                                            </div>
                                                                            <div>
                                                                                <div class="text-primary fw-bolder c-pointer"
                                                                                    style="border-bottom:1px #009ef7 solid;"
                                                                                    @click="$router.push({name: 'klien-history-kasus', params: { id: detail.client_id }})">
                                                                                    {{$noNullable(detail.client_name)}}
                                                                                </div>
                                                                                <div>
                                                                                    {{$noNullable(detail.intervention_name)}}
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-5 mb-5 text-right">
                                                                        <div class="fw-bolder">Terakhir Diperbarui</div>
                                                                        <div class="text-gray-600 fs-6">
                                                                            {{detail.date ? $moment(detail.date,'YYYY-MM-DD H:mm:ss').locale('id').format('DD MMMM YYYY HH:mm:ss') : '-'}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </template>
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Api from "@/services/api";
    export default {
        data() {
            return {
                data: {
                    intervensiOpd: [],
                    totalOpd: 0,
                    totalKasus: 0,
                },
                loader: {
                    intervensiOpd: true
                }
            }

        },
        mounted() {
            reinitializeAllPlugin();

            this.getIntervensiOpd();
        },
        methods: {
            getIntervensiOpd() {
                this.loader.intervensiOpd = true;
                Api().get(`dashboard/intervention-opd-not-finish`)
                    .then(response => {

                        this.data.intervensiOpd = [];

                        let data = response.data.data;
                        this.data.totalOpd = response.data.total;
                        this.data.totalKasus = response.data.data.length;

                        for (let i = 0; i < data.length; i++) {
                            if (data[i].opd) {
                                let check = this.data.intervensiOpd.findIndex((e) => e.opd_id == data[i].opd.id);

                                if (check >= 0) {
                                    this.data.intervensiOpd[check].intervensi.push({
                                        client_name: data[i].penjangkauan && data[i].penjangkauan.pengaduan && data[i].penjangkauan.pengaduan.klien ? data[i].penjangkauan.pengaduan.klien.name : '',                                        
                                        client_id: data[i].penjangkauan && data[i].penjangkauan.pengaduan ?
                                            data[i].penjangkauan.pengaduan.id_klien : '',
                                        intervention_name: data[i].intervensi ? data[i].intervensi.name :
                                            '',
                                        date: data[i].realisasi_intervensi.length > 0 ? data[i]
                                            .realisasi_intervensi[0].created_at : ''
                                    });
                                } else {
                                    this.data.intervensiOpd.push({
                                        opd_name: data[i].opd.name,
                                        opd_id: data[i].opd.id,
                                        intervensi: [{
                                            client_name: data[i].penjangkauan && data[i].penjangkauan.pengaduan && data[i].penjangkauan.pengaduan.klien ? data[i].penjangkauan.pengaduan.klien.name : '',
                                            client_id: data[i].penjangkauan && data[i].penjangkauan
                                                .pengaduan ? data[i].penjangkauan.pengaduan
                                                .id_klien : '',
                                            intervention_name: data[i].intervensi ? data[i]
                                                .intervensi.name : '',
                                            date: data[i].realisasi_intervensi.length > 0 ? data[i]
                                                .realisasi_intervensi[0].created_at : ''
                                        }]
                                    })
                                }
                            }

                        }

                        this.loader.intervensiOpd = false;
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    });
            },
        }
    }

</script>
