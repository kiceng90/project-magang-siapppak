<template>
    <dashboard-modal :title="`Tambah Jadwal Konsultasi (${type})`" id="modal-tambah" dialog-class="modal-bs">
        <template v-if="type === 'Konselor'">
            <label class="form-label fw-bolder fs-6 mb-3">Pilih Konsultan (Konselor)</label>
            <app-select-single
                class="mb-5" :show_button_clear="false"
                :placeholder="'Pilih Konsultan (Konselor)'"
                :serverside="true"
                :options="konsultanOptions"
                v-model="selectedKonsultan"
                @change-search="getKonselor"
                @option-change="reset(['hari','sesi'])"
            ></app-select-single>
        </template>
        <template v-if="type === 'Psikolog'">
            <label class="form-label fw-bolder fs-6 mb-3">Pilih Konsultan (Psikolog)</label>
            <app-select-single
                class="mb-5" :show_button_clear="false"
                :placeholder="'Pilih Konsultan (Psikolog)'"
                :serverside="true"
                :options="konsultanOptions"
                v-model="selectedKonsultan"
                @change-search="getPsikolog"
                @option-change="reset(['hari','sesi'])"
            ></app-select-single>
        </template>
        <template v-if="showSelectDay">
            <label class="form-label fw-bolder fs-6 mb-3">Pilih Hari Konsultasi</label>
            <select class="form-control mb-5" placeholder="Pilih Hari" v-model="selectedDay" @change="reset(['sesi'])">
                <option disabled value="">-- PILIH HARI --</option>
                <option v-for="item in dayOptions" :value="item.id">{{ item.text }}</option>
            </select>
        </template>
        <template v-if="showSelectSessions">
            <label class="form-label fw-bolder fs-6 mb-3">Sesi</label>
            <div class="border rounded p-5 mb-5" v-for="item in sessions" :key="item.id">
                <div class="form-group row mb-5">
                    <label :for="`sesi-${item.id}-start`" class="col-sm-5 col-form-label">Sesi Awal Konsultasi</label>
                    <div class="col-sm-7">
                        <input type="time" class="form-control" :id="`sesi-${item.id}-start`" v-model="item.start">
                    </div>
                </div>
                <div class="form-group row mb-5">
                    <label :for="`sesi-${item.id}-end`" class="col-sm-5 col-form-label">Sesi Akhir Konsultasi</label>
                    <div class="col-sm-7">
                        <input type="time" class="form-control" :id="`sesi-${item.id}-end`" v-model="item.end">
                    </div>
                </div>
                <div class="form-group row mb-5">
                    <label :for="`sesi-${item.id}-category`" class="col-sm-5 col-form-label">Kategori Konsultasi</label>
                    <div class="col-sm-7">
                        <select class="form-control" placeholder="Pilih Kategori Konseling" :id="`sesi-${item.id}-category`" v-model="item.category">
                            <option disabled value="">-- PILIH KATEGORI KONSELING --</option>
                            <option v-for="item in kategoriKonselingOptions" :value="item.id">{{ item.text }}</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-light" type="button" @click="onRemoveSession(item.id)">
                        Hapus Sesi
                    </button>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="onAddSession">
                    Tambah Sesi
                </button>
            </div>
        </template>
        <template #footer>
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="onSubmit">
                Simpan
            </button>
        </template>
    </dashboard-modal>
</template>


<script>
import Api from "@/services/api";

const createGenId=() => {
    let id = 1;
    return () => {
        return id++;
    }
}

const genId = createGenId();

export default {
    props: ['kategoriKonselingOptions', 'type'],
    data(){
        return {
            konsultanOptions: [],
            selectedKonsultan: {},
            selectedDay: '',
            sessions: [],
            pageStatus: 'standby',
        }
    },
    methods: {
        onSubmit(){
            this.$ewpLoadingShow();

            let formData = {
                id_konselor: this.type === 'Konselor' ? this.selectedKonsultan.id : undefined,
                id_psikolog_volunteer: this.type === 'Psikolog' ? this.selectedKonsultan.id : undefined,
                day: this.selectedDay,
                is_active: true,
                detail: this.sessions.map(it=>({
                    start_time: it.start,
                    end_time: it.end,
                    id_kategori_konseling: it.category,
                }))
            }


            Api().post('m-jadwal-konseling', formData)
                .then(response => {
                    $("#modal-tambah").modal('hide');
                    this.$emit('onSuccess');
                    this.resetAll();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Menambahkan data jadwal konseling',
                        icon: "success",
                    })
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        onAddSession(){
            this.sessions.push({id: genId(), start: '', end: '', category: ''})
        },
        onRemoveSession(id){
            this.sessions = this.sessions.filter(it=>it.id !== id)
        },
        reset(arrayField=[]){
            if(arrayField.includes('hari')){
                this.selectedDay = ''
            }
            if(arrayField.includes('sesi')){
                this.sessions = []
            }
        },
        resetAll(){
            this.konsultanOptions = [];
            this.selectedKonsultan = {};
            this.selectedDay = '';
            this.sessions = [];
            this.pageStatus = 'standby';
        },
        getKonselor(keyword, limit) {
            this.pageStatus = 'konselor-load'
            Api().get(`m-konselor/lists?limit=${limit}&search=${keyword}`)
                .then(response => {

                    const newKonsultanOptions = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        newKonsultanOptions.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name + ' - ' + response.data.data[i]
                                .phone_number,
                        });
                    }

                    this.konsultanOptions = newKonsultanOptions;

                })
                .catch(error => {
                    this.konsultanOptions = [];
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.pageStatus = 'standby';
                })
        },
        getPsikolog(keyword, limit) {
            this.pageStatus = 'konselor-load'
            Api().get(`database/psikolog-volunteer/lists?limit=${limit}&search=${keyword}`)
                .then(response => {

                    const newKonsultanOptions = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        newKonsultanOptions.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name + ' - ' + response.data.data[i]
                                .no_hp,
                        });
                    }

                    this.konsultanOptions = newKonsultanOptions;

                })
                .catch(error => {
                    this.konsultanOptions = [];
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.pageStatus = 'standby';
                })
        }
    },
    computed:{
        showSelectDay(){
            return !!this.selectedKonsultan.id
        },
        showSelectSessions(){
            return this.selectedDay !== ''
        },
        dayOptions(){
            return this.$store.state.enums.optionsDay
        }
    }
}
</script>