<template>
    <div>
        <div class="pu_site_page">
            <app-header></app-header>

            <section class="pu_beadcrumb_part" data-bg-img="/img/fotokegiatan/famili2.jpg"
                :style="`background: url(${$assetUrl()}siapppak/images/fotokegiatan/famili2.jpg) center center / cover no-repeat;`">
                <div class="container custom_container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pu_breadcrumb_inner_content"></div>
                        </div>
                    </div>
                </div>
            </section>
            <section>
            <div id="main-content">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-xxl">

                                <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-body pt-5">
                                            <div class="head py-7">
                                                <div
                                                    class="d-flex justify-content-center align-items-center flex-column">
                                                    <h3 class="card-title text-center align-items-start flex-column"
                                                        style="font-size:2em;"><strong>Cek Pengaduan</strong></h3>
                                                    <div class="container py-5" style="width:60%;">
                                                        <h5 class="text-gray-700 text-center"><strong>Masukkan Nomor Registrasi,
                                                            NIK, atau nomor identitas untuk melacak progres pengaduan (Harap Login Terlebih Dahulu)</strong>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="search container py-3 px-10" style="width:90%;">
                                                <div class="row container px-10">
                                                    <div class="col-11">
                                                        <input type="text" class="form-control text-center" v-model="number"
                                                            placeholder="Masukkan Nomor">
                                                    </div>
                                                    <div class="col-1">
                                                        <button class="btn c-btn-orange"
                                                            :disabled="pageStatus == 'disabledButton'"
                                                            @click="search"><strong>Search</strong></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pengaduan py-10">
                                                <div v-if="pageStatus == 'disabledButton'"
                                                    class="w-100 d-flex justify-content-center mt-10 mb-10">
                                                    <app-loader></app-loader>
                                                </div>
                                                <template v-else>
                                                    <div class="empty d-flex" v-if="!listPengaduan.length"
                                                        style="justify-content:center;">
                                                        <img :src="`${$assetUrl()}extends/img/empty-pengaduan.svg`"
                                                            alt="">
                                                    </div>
                                                    <div class="progres" v-else>
                                                        <h1 class="text-orange text-center">Berikut Progres Pengaduan
                                                        </h1>
                                                        <div class="data">
                                                            <div class="timeline">
                                                                <div class="timeline-custom">
                                                                    <div class="container-timeline-custom right-timeline-custom"
                                                                        v-for="(context, index) in listPengaduan">
                                                                        <div class="container-timeline-custom-circle">
                                                                            <svg width="35" height="34"
                                                                                viewBox="0 0 35 34" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <rect x="0.5" width="34" height="34"
                                                                                    rx="17" fill="#E8FFF3" />
                                                                                <g clip-path="url(#clip0_318_924)">
                                                                                    <path opacity="0.3"
                                                                                        d="M24.0535 12.0143C24.3218 11.6986 24.7951 11.6603 25.1107 11.9285C25.4263 12.1968 25.4647 12.6701 25.1964 12.9857L18.8214 20.4857C18.549 20.8063 18.0662 20.8401 17.7517 20.5605L14.3767 17.5605C14.0671 17.2854 14.0392 16.8113 14.3144 16.5017C14.5896 16.1921 15.0637 16.1642 15.3733 16.4394L18.1751 18.93L24.0535 12.0143Z"
                                                                                        fill="#50CD89" />
                                                                                    <path
                                                                                        d="M20.3035 12.7643C20.5718 12.4486 21.0451 12.4103 21.3607 12.6785C21.6763 12.9468 21.7147 13.4201 21.4464 13.7357L15.0714 21.2357C14.799 21.5563 14.3162 21.5901 14.0017 21.3105L10.6267 18.3105C10.3171 18.0354 10.2892 17.5613 10.5644 17.2517C10.8396 16.9421 11.3137 16.9142 11.6233 17.1894L14.4251 19.68L20.3035 12.7643Z"
                                                                                        fill="#50CD89" />
                                                                                </g>
                                                                                <defs>
                                                                                    <clipPath id="clip0_318_924">
                                                                                        <rect width="18" height="18"
                                                                                            fill="white"
                                                                                            transform="translate(8.5 8)" />
                                                                                    </clipPath>
                                                                                </defs>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="content-timeline-custom py-3 pt-0 loop">
                                                                            <h6>{{context.title}}</h6>
                                                                            <div><span
                                                                                    class="text-muted">{{$moment(context.datetime).locale('id').format('DD MMMM YYYY  HH:mm:ss')}}</span>
                                                                            </div>

                                                                            <div class="row p-5 mt-4 pt-6"
                                                                                style="border: 1px dashed #E4E6EF;border-radius:12px;">
                                                                                <span>{{context.desc}}</span>
                                                                            </div>
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
                            <!--end::Container-->
                        </div>

                        <!--end::Post-->
                    </div>
                </section>
            <app-footer></app-footer>

    </div>

    <app-popupsearch></app-popupsearch>

    <app-mobilemenu></app-mobilemenu>
</div></template>

<script>

import Api from "@/services/api";

export default {
    data() {
        return {
            pageStatus: 'standby',
            number: '',
            listPengaduan: []
        }

    },
    mounted() {
        reinitializeAllPlugin();

    },
    methods: {
        search() {
            if (!this.number) {
                this.$toast.error("Nomor tidak boleh kosong!");
                return false;
            }


            this.listPengaduan = [];
            this.pageStatus = 'disabledButton';

            Api().get(`pengaduan/cek`,{
                params: {
                    number: this.number
                }
            })
                .then(response => {
                    for (let i = 0; i < response.data.data.length; i++) {
                        this.listPengaduan.push({
                            title: response.data.data[i].name,
                            datetime: response.data.data[i].created_at,
                            desc: response.data.data[i].description,
                        })
                    }
                })
                .catch(error => {
                    let code = error.response ? error.response.status : null;

                    if(code == 404){
                        this.$toast.info("Data pengaduan tidak ditemukan!");
                    }else{
                        this.$axiosHandleError(error);
                    }
                    
                }).then(() => {
                    this.pageStatus = 'standby';
                    this.$ewpLoadingHide();
                });
        }
    }
}

</script>

<style scoped>
    .c-btn-orange {
        background-color: #ee7b33 !important;
        color: white;
    }

    .c-btn-orange:hover {
        background-color: #e16517 !important;
    }

    .text-orange {
        color: #ee7b33 !important;
    }



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
        left: -17px;
        top: 0;
        z-index: 1;
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
