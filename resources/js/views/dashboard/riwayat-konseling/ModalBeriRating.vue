<template>
    <dashboard-modal title="Beri Rating" id="modal-beri-rating" dialog-class="modal-bs">
        <label class="form-label fw-bolder fs-6 mb-3">Rating</label>
        <star-rating class="form-control mb-5" :show-rating="false" :star-size="25" :rating="rating" @update:rating="rating = $event"></star-rating>
        <label class="form-label fw-bolder fs-6 mb-3">Review</label>
        <!-- <app-editor class="form-control" v-model="review" ref="editor" contentType="html"></app-editor> -->
        <textarea class="form-control mb-5" v-model="review"></textarea>
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
            rating: 0,
            review: '',
        }
    },
    methods: {
        reset(){
            this.rating = 0;
            this.review = '';
        },
        onSubmit(){
            this.$ewpLoadingShow();

            let formData = {
                _method: 'PUT',
                rating: this.rating,
                review: this.review,
            }
            
            console.log('tes formdata', formData);

            Api().post(`konseling-review/${this.data.id}`, formData)
                .then(response => {
                    $("#modal-beri-rating").modal('hide');
                    this.$emit('onSuccess');
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: 'Memberikan rating',
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
                this.rating = this.data.rating;
                this.review = this.data.review;
            }
        }
    }
}
</script>