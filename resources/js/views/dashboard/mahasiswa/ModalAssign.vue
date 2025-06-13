<template>
    <dashboard-modal title="Penugasan" id="modal-assign" dialog-class="modal-bs">
        <label class="form-label fw-bolder fs-6 mb-3">Staff Konselor</label>
        <app-select-single
            v-model="konselor" :placeholder="'Pilih Konselor'"
            :options="konselorOptions" :loading="pageStatus == 'konselor-load'"
            :serverside="true"
            @change-search="getKonselor" :show_button_clear="false">
        </app-select-single>
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
        <label class="form-label fw-bolder fs-6 mb-3 mt-5">Balai Puspaga RW</label>
        <app-select-single
            v-model="balaiPuspaga" :placeholder="'Pilih Balai Puspaga RW'"
            :options="balaiPuspagaOptions" :loading="pageStatus == 'balai-puspaga-load'"
            :serverside="true"
            @change-search="getBalaiPuspagaRW" :show_button_clear="false"
            :disabled="!kelurahan.id"
        />

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
    props: ['data'],
    data(){
        return {
            pageStatus: 'standby',
            konselorOptions: [],
            konselor: {},
            kecamatanOptions: [],
            kecamatan: {},
            kelurahanOptions: [],
            kelurahan: {},
            balaiPuspagaOptions: [],
            balaiPuspaga: {},
        }
    },
    methods: {
        onSubmit(){
            this.$ewpLoadingShow();

            const formData = {
                id_konselor: this.konselor.id,
                id_balai_puspaga_rw: this.balaiPuspaga.id
            };

            Api().put(`d-mahasiswa/${this.data.id}/assign`, formData)
                .then(response => {
                    $("#modal-assign").modal('hide');
                    this.$emit('onSuccess');
                    this.konselor = {};
                    this.balaiPuspaga = {};

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Memperbarui data mahasiswa',
                        icon: "success",
                    });
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
        getKonselor(keyword, limit) {
            this.getSelectList(`m-konselor/lists?limit=${limit}&search=${keyword}`, 'konselorOptions', 'konselor-load');
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
        resetFields(arrayField=[]){
            if(arrayField.includes('kelurahan')){
                this.kelurahan = {}
            }
            if(arrayField.includes('balaiPuspaga')){
                this.balaiPuspaga = {}
            }
        },
    }
}
</script>