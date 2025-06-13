<template>
    <dashboard-modal title="Tolak Konsultasi" id="modal-tolak-konsultasi" dialog-class="modal-bs">
        <label class="form-label fw-bolder fs-6 mb-3">Alasan Menolak</label>
        <textarea class="form-control mb-5" v-model="note_reject"></textarea>
        <template #footer>
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="onSubmit">
                Simpan
            </button>
        </template>
    </dashboard-modal>
</template>
<script>
import StarRating from 'vue-star-rating';
import Api from "@/services/api";

export default {
    components: {StarRating},
    props: ['data'],
    data(){
        return {
            note_reject: '',
        }
    },
    methods: {
        reset(){
            this.note_reject = '';
        },
        onSubmit(){
            this.$ewpLoadingShow();

            let formData = {
                _method: 'PUT',
                note_reject: this.note_reject,
            }


            Api().post(`konselor-konseling-reject/${this.data.id}`, formData)
                .then(() => {
                    $("#modal-tolak-konsultasi").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Menolak konsultasi',
                        icon: "success",
                    })
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).finally(() => {
                    this.$ewpLoadingHide();
                });
        }
    },
    watch: {
        data(n,p){
            if(n!==p){
                this.note_reject = this.data.note_reject;
            }
        }
    }
}
</script>