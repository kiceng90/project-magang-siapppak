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
                                    >Tambah Laporan Kegiatan Monev</span
                                >
                            </h3>
                        </div>

                        <div class="card-body pt-5">
                            <div class="col-12 col-lg-6">
                                <label class="form-label fw-bolder fs-6 mb-3 mt-5">Kecamatan</label>
                                <app-select-single
                                    v-model="kecamatan" :placeholder="'Pilih Kecamatan'"
                                    :options="kecamatanOptions" :loading="pageStatus == 'kecamatan-load'"
                                    :serverside="true"
                                    @change-search="getKecamatan" :show_button_clear="false"
                                    @option-change="resetFields(['kelurahan', 'balaiPuspaga'])"
                                />
                                <label class="form-label fw-bolder fs-6 mb-3 mt-5">Kelurahan</label>
                                <app-select-single
                                    v-model="kelurahan" :placeholder="'Pilih Kelurahan'"
                                    :options="kelurahanOptions" :loading="pageStatus == 'kelurahan-load'"
                                    :serverside="true"
                                    @change-search="getKelurahan" :show_button_clear="false"
                                    @option-change="resetFields(['balaiPuspaga'])"
                                    :disabled="!kecamatan.id"
                                />
                                <label class="form-label fw-bolder fs-6 mb-3 mt-5">Puspaga Balai RW</label>
                                <app-select-single
                                    v-model="balaiPuspaga" :placeholder="'Pilih Puspaga Balai RW'"
                                    :options="balaiPuspagaOptions" :loading="pageStatus == 'balai-puspaga-load'"
                                    :serverside="true"
                                    @change-search="getBalaiPuspagaRW" :show_button_clear="false"
                                    :disabled="!kelurahan.id"
                                    @option-change="getDataBalaiPuspagaRW"
                                />
                                <label class="form-label fw-bolder fs-6 mb-4 mt-5">Apakah Kegiatan Puspaga Balai RW Masih Aktif?</label>
                                <div class="form-check form-switch mb-6">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" v-model="is_active">
                                    <label class="form-check-label" for="is_active">Aktif</label>
                                </div>
                                <label class="form-label fw-bolder fs-6 mb-3">Jabatan Petugas </label>
                                <app-select-single
                                    v-model="jabatanPetugas" :placeholder="'Pilih Jabatan Petugas'"
                                    :options="jabatanPetugasOptions" :loading="pageStatus == 'jabatan-petugas-load'"
                                    :serverside="true"
                                    @change-search="getJabatanPetugas" :show_button_clear="false"/>
                                <input type="checkbox" class="form-control mb-5" v-model="isKegiatanActive">
                                <label class="form-label fw-bolder fs-6 mb-3">Tanggal Pelaksanaan Monev</label>
                                <input type="date" class="form-control mb-5" v-model="date">
                            </div>

                            <template v-for="kategori in listKuesioner">
                                <h1 class="mb-5 mt-8 pb-2 border-bottom">{{ kategori?.name }}</h1>
                                <template v-if="kategori?.sub_kategori" v-for="sub_kategori in kategori.sub_kategori">
                                    <h3 class="my-4">{{ sub_kategori?.name }}</h3>
                                    <div class="col-12 col-lg-8">
                                        <FormField 
                                            v-if="sub_kategori.kuesioner"
                                            v-for="kuesioner in sub_kategori.kuesioner"
                                            :inputType="kuesioner.input_type"
                                            :inputOptions="JSON.parse(kuesioner.input_options)"
                                            :label="kuesioner.question"
                                            :name="kuesioner.key"
                                            :value="answers[kuesioner.key]?.answer"
                                            @onChange="(value) => answers[kuesioner.key] = {id_kuesioner: kuesioner.id, answer: value, id_sub_kategori: sub_kategori.id}"
                                        />
                                    </div>
                                </template>
                            </template>
                            <div class="d-flex">
                                <button type="button" class="btn btn-sm btn-light" style="margin-right: 1rem;" data-bs-dismiss="modal" @click="backToIndex">Batal</button>
                                <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="onSave">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <ModalLembarLaporan
            :answers="answers"
            :categoriesWithQuestions="listKuesioner"
            :konselor="konselor"
            :balaiPuspaga="balaiPuspagaRW"
            :jabatan="jabatanPetugas.text"
            :date="date"
            @onSubmit="onSubmit"
        />
    </dashboard-base-layout>
</template>
<script>
import Api from "@/services/api";
import FormField from './form-field/FormField.vue';
import ModalLembarLaporan from './ModalLembarLaporan.vue';

export default {
    components: { FormField, ModalLembarLaporan },
    data: () => ({
        pageStatus: 'standby',
        kecamatanOptions: [],
        kecamatan: {},
        kelurahanOptions: [],
        kelurahan: {},
        balaiPuspagaOptions: [],
        balaiPuspaga: {},
        jabatanPetugasOptions: [],
        jabatanPetugas: {},
        isKegiatanActive: false,
        date: null,
        answers: {},
        listKuesioner: [],
        konselor: {},
        balaiPuspagaRW: {},
        flatKuesioner: [], // only kuesioner
        is_active: true,
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
                            prev = [...prev, ...kuesioners];
                        })
                        return prev;
                    },[]);
                    this.flatKuesioner = flatKuesioner;
                });
        },
        reset(){
            this.balaiPuspaga = {};
            this.jabatanPetugas = {};
            this.isKegiatanActive = false;
            this.date = null;
        },
        onSave(){
            $("#modal-lembar-laporan").modal("show");
        },
        onSubmit(){
            $("#modal-lembar-laporan").modal("hide");
            this.$ewpLoadingShow();

            const formData = new FormData();
            formData.append('id_jabatan_dalam_instansi', this.jabatanPetugas.id);
            formData.append('id_d_balai_puspaga_rw', this.balaiPuspaga.id);
            formData.append('id_konselor', this.$store.state.profile.id_konselor);
            formData.append('is_active', this.is_active ? 1 : 0);
            formData.append('date', this.date);

            Object.values(this.answers).map((value,i)=>{
                formData.append(`kuesioner[${i}][id_kuesioner]`, value.id_kuesioner);
                formData.append(`kuesioner[${i}][answer]`, value.answer);
            })

            this.flatKuesioner.forEach((kuesioner,i)=>{
                const value = this.answers[kuesioner.key];
                formData.append(`kuesioner[${i}][id_kuesioner]`, kuesioner.id);
                formData.append(`kuesioner[${i}][answer]`, value?.answer || null);
                formData.append(`kuesioner[${i}][id_answer]`, value?.id_answer || null);
            })

            Api().post('laporan-monev', formData)
                .then(response => {
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Menambahkan data laporan kegiatan monev',
                        icon: "success",
                    });
                    this.$ewpLoadingHide();
                    this.backToIndex();
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                    this.$ewpLoadingHide();
                });
        },
        onChangeFoto(e){
            const [file] = e.target.files;
            this.foto = file
        },
        getSelectList(url, listKey, pageStatus = 'select-load') {
            this.pageStatus = pageStatus

            Api().get(url)
                .then(response => {

                    this[listKey] = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this[listKey].push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })
                .catch(error => {
                    this[listKey] = [];
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.pageStatus = 'standby';
                })
        },
        getKecamatan(keyword, limit) {
            this.getSelectList(`m-kecamatan/lists?limit=${limit}&search=${keyword}&is_surabaya=true`, 'kecamatanOptions', 'kecamatan-load');
        },
        getKelurahan(keyword, limit) {
            this.getSelectList(`m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${this.kecamatan.id}`, 'kelurahanOptions', 'kelurahan-load');
        },
        getBalaiPuspagaRW(keyword, limit) {
            this.getSelectList(`d-balai-puspaga-rw/lists?limit=${limit}&search=${keyword}&id_kelurahan=${this.kelurahan.id}`, 'balaiPuspagaOptions', 'balai-puspaga-load');
        },
        getJabatanPetugas(keyword, limit) {
            this.getSelectList(`m-jabatan-dalam-instansi/lists?limit=${limit}&search=${keyword}`, 'jabatanPetugasOptions', 'jabatan-petugas-load');
        },
        backToIndex(){
            this.$router.replace({
                name: 'kegiatan-monev'
            })
        },
        resetFields(arrayField=[]){
            if(arrayField.includes('kelurahan')){
                this.kelurahan = {}
            }
            if(arrayField.includes('balaiPuspaga')){
                this.balaiPuspaga = {}
            }
        },
        getDataKonselor(){
            Api().get(`m-konselor/${this.$store.state.profile.id_konselor}`).then((res)=>{
                this.konselor = res.data?.data;
            })
        }, 
        getDataBalaiPuspagaRW(){
            Api().get(`d-balai-puspaga-rw/${this.balaiPuspaga.id}`).then((res)=>{
                this.balaiPuspagaRW = res.data?.data;
            })
        }, 
    },
    mounted() {
        this.getDataKonselor();
        this.getKuisioner()
    },
};
</script>