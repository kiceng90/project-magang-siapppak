<template>
    <dashboard-base-layout>
        <!--begin::Post-->
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <!--begin::Container-->
                <div id="kt_content_container" class="container-xxl">

                    <div class="card card-flush mt-5 mb-5 mb-xl-10" id="kt_booking_jadwal_konseling_view">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-header border-0 pt-5 align-items-center">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder text-dark mb-2"
                                        style="font-size:20px !important;">Booking Jadwal Konseling</span>
                                </h3>
                            </div>
                            <div class="card-body pt-5">
                                <div class="row">
                                    <div class="col-lg-3 mb-5">
                                        <img class="rounded-circle" :src="konsultan.foto || $assetUrl() + '/siapppak/images/user.png'" alt="Avatar" style="object-fit: cover; width: 100%; max-width: 150px; aspect-ratio: 1/1;">
                                    </div>
                                    <div class="col-lg-9">
                                        <h4 class="text-muted text-uppercase">{{ konsultan.consultant_type }}</h4>
                                        <h2>{{ konsultan.name }}</h2>
                                        <div class="alert alert-warning">
                                            Silakan pilih hari konsultasi dahulu. Lalu pilih sesi, bahasa serta deskripsi pada form. Jika sesi tidak muncul pada hari yang telah dipilih, maka sesi tersebut tidak tersedia atau sudah dibooking oleh orang lain.
                                        </div>
                                        <label class="col-lg-8 fw-bolder mb-3" for="date">
                                            Pilih Hari
                                        </label>
                                        <div class="col-lg-8 mb-5">
                                            <div class="input-group">
                                                <select class="form-control" placeholder="Pilih Hari" v-on:change="onChangeDay" v-model="selectedDay">
                                                    <option disabled value="">-- PILIH HARI --</option>
                                                    <option v-for="item,index in dayOptions" :value="item.id" :key="index">{{ item.text }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div v-show="showSession">
                                            <div class="col-lg-8">
                                                <label class="fw-bolder mb-3" for="date">
                                                    Pilih Sesi
                                                </label>
                                                <div class="mb-5">
                                                    <select class="form-control" placeholder="Pilih sesi" v-model="selectedSession">
                                                        <option v-if="sessionOptions.length > 0" disabled value="">-- PILIH SESI --</option>
                                                        <option v-else disabled value="">-- TIDAK TERSEDIA --</option>
                                                        <option v-for="item,index in sessionOptions" :value="item.id" :key="index">{{ item.text }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="showRest">
                                            <div class="col-lg-8 mb-5">
                                                <label class="fw-bolder mb-3">
                                                    Form Screening Pra Sesi Konseling Online
                                                </label>
                                                <iframe src="https://docs.google.com/forms/d/e/1FAIpQLScJ4UDGLPpZ-23FYoxSWN1xNzutJjBhz6szahMinvX2edbUEw/viewform" title="Form Screening Pra Sesi Konseling Online" height="400" width="100%"></iframe>
                                            </div>
                                            <div class="col-lg-8">
                                                <label class="fw-bolder mb-3">
                                                    Pilih Bahasa
                                                </label>
                                                <div class="mb-5">
                                                    <div class="form-check mb-5" v-for="language,index in languages" :key="index">
                                                        <input class="form-check-input" type="radio" name="bahasa" :id="'bahasa-'+language.value" :value="language.value" v-model="selectedLanguage">
                                                        <label class="form-check-label" :for="'bahasa-'+language.value">
                                                            {{ language.name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <label class="fw-bolder mb-3">
                                                    Jelaskan secara singkat permasalahan anda
                                                </label>
                                                <div class="mb-10">
                                                    <app-editor class="form-control" v-model:content="description" ref="editor" contentType="html"></app-editor>
                                                </div>
                                            </div>
                                            <div class="form-check mb-5 mt-4">
                                                  <input
                                                      type="checkbox"
                                                      class="form-check-input"
                                                      id="validasi"
                                                      v-model="isChecked"
                                                  />
                                                  <!-- <label class="form-check-label" for="validasi"
                                                      >Dengan ini menyatakan bahwa data dan informasi yang saya
                                                      sampaikan dalam form ini adalah benar, lengkap, dan sesuai
                                                      dengan keadaan yang sebenarnya. Saya memahami bahwa segala
                                                      bentuk kesalahan atau ketidakbenaran dalam data dan informasi
                                                     yang saya berikan menjadi tanggung jawab pribadi saya
                                                      sepenuhnya.</label
                                                  > -->
                                                  <label class="form-check-label" for="validasi"
                                                  >Saya menyatakan SETUJU dan BERSEDIA mendapatkan pelayanan dari Tim Perlindungan Perempuan dan Anak (DP3APPKB) Kota Surabaya sebagai klien. Apabila ada permasalahan di kemudian hari, saya tidak akan melakukan tuntutan dalam bentuk apapun ke pihak Tim Perlindungan Perempuan dan Anak DP3APPKB Kota Surabaya.
                                                  Selama mendapatkan layanan ini, saya menyadari, memahami, menerima dan menyatakan bahwa:
                                                      <br>1.    Bersedia terlibat penuh dan aktif selama proses berlangsung,
                                                      <br>2.    Memberikan informasi yang benar dan sejujurnya berkaitan dengan masalah yang saya hadapi,
                                                      <br>3.    Menyetujui adanya perekaman proses pada saat pelayanan / penanganan kasus baik berupa tulisan, rekaman percakapan dan dokumentasi lainnya selama proses konseling berlangsung.
                                                      <br>4.    Layanan yang saya terima dari Tim PPA DP3APPKB merupakan layanan GRATIS tidak dipungut biaya apapun.
                                                  </label>
                                              </div>
                                            <div class="col-lg-8 mb-5">
                                                <button class="btn btn-sm" 
                                                :class="{ 'bg-second-primary-custom text-white': isChecked }" 
                                                :disabled="!isChecked"
                                                type="button" 
                                                @click="onSubmit">
                                                    DAFTAR KONSULTASI
                                                </button>
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
    </dashboard-base-layout>
</template>

<script>
import moment from "moment";
import Api from "@/services/api";

export default {
    data(){
        return {
            dayOptions: [],
            sessionOptions: [],
            languages: [],
            selectedDay: '',
            selectedSession: '',
            selectedLanguage: '',
            description: '',
            konsultan: {},
            isChecked: false,
        }
    },
    methods: {
        showRestFields(){
            this.showRest = !this.showRest;
        },
        onSuccess(){
            this.$swal({
                title: "Berhasil!",
                text: 'Data konsultasi sudah diterima, dan sedang menunggu persetujuan konsultan',
                icon: "success",
            }).then(() => {
                this.$router.push({
                    name: 'riwayat-konseling'
                })
            })
        },
        getLanguages(){
            Api().get(`konseling-languages`)
                .then(response=>{
                    this.languages = response.data.data;
                });
        },
        getData(){
            const {idKonsultan} = this.$route.params;
            const consultantType = this.$route.name === 'booking-jadwal-konseling-psikolog' ? this.$store.state.enums.jenisKonsultan['PSIKOLOG'].value : undefined;
            Api().get(`konseling-prepare-booking-day/${idKonsultan}?consultant_type=${consultantType}`)
                .then(response=>{
                    this.konsultan = response.data.data.konsultan;
                    const jadwal_hari = response.data.data.jadwal_hari;
                    this.dayOptions = Object.entries(jadwal_hari).map(([k, j])=>({id: j.date, text: j.dayname.replace('<br>', ' '), date: j.date}));
                });
        },
        onChangeDay(e){
            this.selectedSession = '';
            
            const {value} = e.target
            const {idKonsultan} = this.$route.params;
            const consultantType = this.$store.state.enums.jenisKonsultan[this.konsultan.consultant_type.toUpperCase()].value;
            Api().get(`konseling-prepare-booking-shift/${idKonsultan}/${value}?consultant_type=${consultantType}`)
                .then(response=>{
                    const jadwal_detail = response.data.data.jadwal_detail;
                    const sessions = jadwal_detail.map(j=>{
                        const start_time = moment(j.start_time).format('HH:mm')
                        const end_time = moment(j.end_time).format('HH:mm')
                        return {
                            id: j.id_jadwal_konseling_detail,
                            text: `${start_time} - ${end_time}, ${j.kategori}`
                        }
                    });

                    this.sessionOptions = sessions;
                })
        },
        onSubmit(){
            this.$ewpLoadingShow();

            const {idKlien} = this.$route.params;
            let formData = {
                date: this.dayOptions.find(it=>it.id===this.selectedDay).date,
                id_jadwal_konseling_detail: this.selectedSession,
                language: this.selectedLanguage,
                description: this.description,
            }

            Api().post(`konseling-booking?id_klien_konseling=${idKlien}`, formData)
                .then(response => {
                    this.onSuccess();
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
    },
    computed: {
        showSession(){
            return this.selectedDay !== ''
        },
        showRest(){
            return this.selectedDay !== '' && this.selectedSession != ''
        }
    },
    mounted(){
        this.getData();
        this.getLanguages();
    }
}
</script>