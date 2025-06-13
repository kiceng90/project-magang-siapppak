<template>
    <dashboard-modal title="Tambah Balai Puspaga RW" id="modal-tambah" dialog-class="modal-bs">
        <label class="form-label fw-bolder fs-6 mb-3">Pilih Wilayah</label>
        <app-select-single 
            class="mb-5"
            v-model="wilayah"
            :placeholder="'Pilih wilayah'"
            :show_button_clear="false"
            :options="wilayahOptions" :serverside="true"
            :loading="pageStatus == 'wilayah-load'"
            @change-search="getWilayah"
            @option-change="reset(['kecamatan','kelurahan'])"
        >
        </app-select-single>
        <template v-if="!!wilayah?.id">
            <label class="form-label fw-bolder fs-6 mb-3">Pilih Kecamatan</label>
            <app-select-single 
                class="mb-5"
                v-model="kecamatan"
                :placeholder="'Pilih kecamatan'"
                :show_button_clear="false"
                :options="kecamatanOptions" :serverside="true"
                :loading="pageStatus == 'kecamatan-load'"
                @change-search="getKecamatan"
                @option-change="reset(['kelurahan'])"
            >
            </app-select-single>
        </template>
        <template v-if="!!kecamatan?.id">
            <label class="form-label fw-bolder fs-6 mb-3">Pilih Kelurahan</label>
            <app-select-single 
                class="mb-5"
                v-model="kelurahan"
                :placeholder="'Pilih kelurahan'"
                :show_button_clear="false"
                :options="kelurahanOptions" :serverside="true"
                :loading="pageStatus == 'kelurahan-load'"
                @change-search="getKelurahan">
            </app-select-single>
        </template>
        <label class="form-label fw-bolder fs-6 mb-3">RW</label>
        <input class="form-control mb-5" type="number" min="1" v-model="rw"/>

        <label class="form-label fw-bolder fs-6 mb-3">Nama Balai RW</label>
        <input class="form-control mb-5" v-model="namaBalaiRW"/>

        <label class="form-label fw-bolder fs-6 mb-3">Alamat Balai RW</label>
        <textarea class="form-control mb-5" v-model="alamatBalaiRW"></textarea>

        <label class="form-label fw-bolder fs-6 mb-3">Nama Ketua RW</label>
        <input class="form-control mb-5" v-model="namaKetuaRW"/>

        <label class="form-label fw-bolder fs-6 mb-3">No. Telpon Ketua RW</label>
        <input class="form-control mb-5" v-model="nomorKetuaRW"/>

        <label class="form-label fw-bolder fs-6 mb-3">Hari Pelayanan</label>
        <div class="form-check mb-2" v-for="day in this.$store.state.enums.optionsDay" :key="day.id">
            <input
                class="form-check-input"
                type="checkbox"
                v-model="hariPelayanan"
                :id="day.text"
                :value="day"
            >
            <label class="form-check-label" :for="day.text">
                {{ day.text }}
            </label>
        </div>

        <label class="form-label fw-bolder fs-6 mb-3">Jam Mulai Pelayanan</label>
        <input class="form-control mb-5" type="time" v-model="startTimePelayanan"/>

        <label class="form-label fw-bolder fs-6 mb-3">Jam Akhir Pelayanan</label>
        <input class="form-control mb-5" type="time" v-model="endTimePelayanan"/>

        <label class="form-label fw-bolder fs-6 mb-3">Tahun Pembentukan</label>
        <input class="form-control mb-5" type="number" min="1945" v-model="tahunPembentukan"/>

        <label class="form-label fw-bolder fs-6 mb-3">Petugas Monev</label>
        <app-select-single
            v-model="konselor" :placeholder="'Pilih Konselor'"
            :options="konselorOptions" :loading="pageStatus == 'konselor-load'"
            :serverside="true"
            @change-search="getKonselor" :show_button_clear="false">
        </app-select-single>
        
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

export default {
    data(){
        return {
            pageStatus: 'standby',
            wilayahOptions: [],
            kecamatanOptions: [],
            kelurahanOptions: [],
            konselorOptions: [],
            wilayah: {},
            kecamatan: {},
            kelurahan: {},
            rw: null,
            namaBalaiRW: '',
            alamatBalaiRW: '',
            namaKetuaRW: '',
            nomorKetuaRW: '',
            hariPelayanan: [],
            startTimePelayanan: '',
            endTimePelayanan: '',
            tahunPembentukan: null,
            konselor: {},
        }
    },
    methods: {
        onSubmit(){
            this.$ewpLoadingShow();

            let formData = {
                name: this.namaBalaiRW,
                id_wilayah: this.wilayah.id,
                id_kelurahan: this.kelurahan.id,
                id_konselor: this.konselor.id,
                rw: this.rw,
                address: this.alamatBalaiRW,
                rw_name: this.namaKetuaRW,
                rw_phone: this.nomorKetuaRW,
                operational_day: this.hariPelayanan.sort((a,b)=>a.id - b.id).map(it=>it.text).join(', '),
                operational_start_time: this.startTimePelayanan,
                operational_end_time: this.endTimePelayanan,
                inauguration_year: this.tahunPembentukan,
                is_active: true,
            }


            Api().post('d-balai-puspaga-rw', formData)
                .then(response => {
                    $("#modal-tambah").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Menambahkan data balai puspaga rw',
                        icon: "success",
                    })
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
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
        getWilayah(keyword, limit) {
            this.getSelectList(`m-wilayah/lists?limit=${limit}&search=${keyword}`, 'wilayahOptions', 'wilayah-load');
        },
        getKecamatan(keyword, limit) {
            this.getSelectList(`m-kecamatan/lists?limit=${limit}&search=${keyword}&is_surabaya=true&id_wilayah=${this.wilayah.id}`, 'kecamatanOptions', 'kecamatan-load');
        },
        getKelurahan(keyword, limit) {
            this.getSelectList(`m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${this.kecamatan.id}`, 'kelurahanOptions', 'kelurahan-load');
        },
        reset(arrayField=[]){
            if(arrayField.includes('kecamatan')){
                this.kecamatan = {}
            }
            if(arrayField.includes('kelurahan')){
                this.kelurahan = {}
            }
        },
        getKonselor(keyword, limit) {
            this.getSelectList(`m-konselor/lists?limit=${limit}&search=${keyword}`, 'konselorOptions', 'konselor-load');
        },
    },
}

</script>