<template>
    <dashboard-base-layout>
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <div
                    class="card card-flush mt-5 mb-5 mb-xl-10"
                    id="kt_profile_details_view"
                >
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div
                            class="card-header border-0 pt-5 align-items-center"
                        >
                            <h3
                                class="card-title align-items-start flex-column"
                            >
                                <span
                                    class="card-label fw-bolder text-dark mb-2"
                                    style="font-size: 20px !important"
                                    >Lihat Laporan Kegiatan Monev</span
                                >
                            </h3>
                            <router-link v-if="isKonselor" class="btn btn-sm bg-second-primary-custom text-white ms-auto" :to="{name: 'kegiatan-monev-edit', params: {id: $route.params.id}}">Edit</router-link>
                        </div>

                        <div class="card-body pt-5">
                            <div class="col-12 col-lg-6">
                                <label class="form-label fw-bolder fs-6 mb-2 mt-5">Kecamatan</label>
                                <div class="jawaban-text">{{ kecamatan.text }}</div>
                                <label class="form-label fw-bolder fs-6 mb-2 mt-5">Kelurahan</label>
                                <div class="jawaban-text">{{ kelurahan.text }}</div>
                                <label class="form-label fw-bolder fs-6 mb-2 mt-5">Puspaga Balai RW</label>
                                <div class="jawaban-text">{{ balaiPuspaga.text }}</div>
                                <label class="form-label fw-bolder fs-6 mb-4 mt-5">Apakah Kegiatan Puspaga Balai RW Masih Aktif?</label>
                                <div class="jawaban-text">{{ is_active ? 'Aktif' : 'Tidak Aktif' }}</div>
                                <label class="form-label fw-bolder fs-6 mb-2 mt-5">Jabatan Petugas </label>
                                <div class="jawaban-text">{{ jabatanPetugas.text }}</div>
                                <label class="form-label fw-bolder fs-6 mb-2 mt-5">Tanggal Pelaksanaan Monev</label>
                                <div class="jawaban-text">{{ date ? $moment(date).locale('id').format('DD MMMM YYYY') : '-' }}</div>
                            </div>

                            <template v-for="kategori in listKuesioner">
                                <h1 class="mb-5 mt-8 pb-2 border-bottom">{{ kategori?.name }}</h1>
                                <template v-if="kategori?.sub_kategori" v-for="sub_kategori in kategori.sub_kategori">
                                    <h3 class="my-4">{{ sub_kategori?.name }}</h3>
                                    <div class="col-12 col-lg-8">
                                        <template
                                            v-if="sub_kategori.kuesioner"
                                            v-for="kuesioner in sub_kategori.kuesioner"
                                        >
                                            <label class="form-label fw-bolder fs-6 mb-2">{{ kuesioner.question }}</label>
                                            <div class="jawaban-text mb-5 text-capitalize" v-if="kuesioner.input_type == inputType.RADIO.value">{{ answers[kuesioner.key]?.answer }}</div>
                                            <div class="jawaban-text mb-5" v-if="kuesioner.input_type == inputType.TEXT.value">{{ answers[kuesioner.key]?.answer }}</div>
                                            <div class="jawaban-text mb-5 w-100 w-md-50 w-lg-75" v-if="kuesioner.input_type == inputType.FILE.value">
                                                <img style="width: 100%;" :src="answers[kuesioner.key]?.answer" :alt="`Jawaban ${kuesioner.question}`"/>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </template>
                            <div class="d-flex">
                                <button type="button" class="btn btn-sm btn-light" style="margin-right: 1rem;" data-bs-dismiss="modal" @click="backToIndex">Kembali</button>
                                <router-link v-if="isKonselor" class="btn btn-sm bg-second-primary-custom text-white" :to="{name: 'kegiatan-monev-edit', params: {id: $route.params.id}}">Edit</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
    </dashboard-base-layout>
</template>
<script>
import Api from "@/services/api";
import FormField from './form-field/FormField.vue';

export default {
    components: { FormField },
    data: () => ({
        pageStatus: 'standby',
        kecamatan: {},
        kelurahan: {},
        balaiPuspaga: {},
        jabatanPetugas: {},
        date: null,
        answers: {},
        listKuesioner: [], // kategori.sub_kategori.kuesioner
        status: null,
        flatKuesioner: [], // only kuesioner
        is_active: false,
    }),
    methods: {
        getKuisioner(){
            return Api()
                .get('laporan-monev-list-kuesioner')
                .then(response=>{
                    const data = response?.data?.data || [];
                    this.listKuesioner = data;
                    const flatKuesioner = [...data].reduce((prev, current)=>{
                        current.sub_kategori.forEach(sub=>{
                            const kuesioners = sub.kuesioner;
                            prev = [...prev, ...kuesioners.filter(it=>it.input_type_string!=='file')];
                        })
                        return prev;
                    },[])
                    this.flatKuesioner = flatKuesioner;
                });
        },
        backToIndex(){
            this.$router.replace({
                name: 'kegiatan-monev'
            })
        },
        getData(){
            return Api().get(`laporan-monev/${this.$route.params.id}`).then((res)=>{
                if(res?.data?.data){
                    const data = res.data.data;

                    this.date = data.date;
                    this.status = data.status;
                    this.is_active = data.is_active;
                    this.kecamatan = {
                        id: data.balai_puspaga_rw.kelurahan.kecamatan.id,
                        text: data.balai_puspaga_rw.kelurahan.kecamatan.name,
                    }
                    this.kelurahan = {
                        id: data.balai_puspaga_rw.kelurahan.id,
                        text: data.balai_puspaga_rw.kelurahan.name,
                    }
                    this.balaiPuspaga = {
                        id: data.balai_puspaga_rw.id,
                        text: data.balai_puspaga_rw.name,
                    }
                    this.jabatanPetugas = {
                        id: data.jabatan.id,
                        text: data.jabatan.name,
                    }

                    const answers = data.jawaban.reduce((prev, current)=>{
                        const kuesioner = current.kuesioner;
                        prev[kuesioner.key] = {
                            id_answer: current.id,
                            id_kuesioner: kuesioner.id,
                            answer: current.answer,
                            id_sub_kategori: kuesioner.sub_kategori.id
                        }
                        return prev;
                    },{});
                    this.answers = answers;
                }
            })
        }
    },
    async mounted() {
        this.$ewpLoadingShow();
        await this.getKuisioner()
        await this.getData();
        this.$ewpLoadingHide();
    },
    computed: {
        inputType(){
            return this.$store.state.enums.laporanMonevKuesionerInputType;
        },
        isKonselor() {
            return this.$store.state.profile.role_id == process.env.MIX_ROLE_KONSELOR_ID;
        },
    },
};
</script>