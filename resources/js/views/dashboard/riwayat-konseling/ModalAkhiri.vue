<template>
    <dashboard-modal title="Akhiri Konsultasi" id="modal-akhiri-konsultasi" dialog-class="modal-bs">
        <template v-if="!isPsikolog || !isKonselor">
            <label class="form-label fw-bolder fs-6 mb-3">Jenis Penyelesaian</label>
            <select class="form-control mb-5" placeholder="Pilih Jenis Penyelesaian" v-model="selectedJenisPenyelesaian">
                <option disabled value="">-- PILIH JENIS PENYELESAIAN --</option>
                <option v-for="item in getJenisPenyelesaianOptions" :value="item.id">{{ item.text }}</option>
            </select>
        </template>
        <template v-if="selectedJenisPenyelesaian === 3"> <!-- dengan rujukan -->
            <label class="form-label fw-bolder fs-6 mb-3">Pilih Psikolog Tujuan</label>
            <app-select-single
                class="" :show_button_clear="false"
                :placeholder="'Pilih Psikolog'"
                :serverside="true"
                :options="optionsPsikolog"
                v-model="selectedPsikolog"
                @change-search="getPsikolog"
            ></app-select-single>
            <small class="form-text mb-5 d-inline-block">
                Setelah membuat rujukan, pastikan untuk memesankan psikolog untuk klien anda.
            </small>
        </template>
        <label class="form-label fw-bolder fs-6 mb-3">Hasil Konseling</label>
        <!-- <app-editor class="form-control" v-model="result"></app-editor> -->
        <app-editor class="form-control" v-model:content="result" ref="editor" contentType="html"></app-editor>
        <template #footer>
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="onSubmit" :disabled="disableBtnSimpan">
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
            ROLE_PSIKOLOG_ID: process.env.MIX_ROLE_PSIKOLOG_ID,
            ROLE_KONSELOR_ID: process.env.MIX_ROLE_KONSELOR_ID,
            selectedJenisPenyelesaian: '',
            result: '',
            optionsPsikolog: [],
            selectedPsikolog: {},
        }
    },
    methods: {
        onSubmit(){
            this.$ewpLoadingShow();

            Api().post(`konselor-konseling-finish/${this.data.id}`, {
                _method: 'PUT',
                status: this.selectedJenisPenyelesaian,
                result: this.result,
                id_psikolog_volunteer: this.selectedPsikolog.id,
            })
                .then(() => {
                    $('#modal-akhiri-konsultasi').modal('hide');
                    this.selectedJenisPenyelesaian = '';
                    this.result = '';
                    this.selectedPsikolog = {};
                    this.$emit('onSuccess');
                    this.$swal({
                        title: "Berhasil mengakhiri!",
                        text: 'Konsultasi sudah diakhiri',
                        icon: "success",
                    });
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        getPsikolog(keyword, limit) {
            this.pageStatus = 'psikolog-load'
            Api().get(`database/psikolog-volunteer/hasschedulelists?limit=${limit}&search=${keyword}`)
                .then(response => {

                    const newKonsultanOptions = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        newKonsultanOptions.push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name + ' - ' + response.data.data[i]
                                .no_hp,
                        });
                    }

                    this.optionsPsikolog = newKonsultanOptions;

                })
                .catch(error => {
                    this.optionsPsikolog = [];
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.pageStatus = 'standby';
                })
        }
    },
    computed: {
        disableBtnSimpan(){
            return this.selectedJenisPenyelesaian === '' && !this.isPsikolog
        },
        isPsikolog(){
            return this.$store.state.profile.role_id == this.ROLE_PSIKOLOG_ID;
        },
        isKonselor(){
            return this.$store.state.profile.role_id == this.ROLE_KONSELOR_ID;
        },
        getJenisPenyelesaianOptions() {
            var jenisPenyelesaianOptions = [
                { id: 7, text: 'Tidak Hadir' },
                { id: 4, text: 'Selesai Tanpa Rujukan' },
            ];
            if (this.isKonselor) {
                jenisPenyelesaianOptions.push(
                    { id: 3, text: 'Selesai dengan Rujukan' }
                );
            }

            return jenisPenyelesaianOptions;
        }
    },
}
</script>