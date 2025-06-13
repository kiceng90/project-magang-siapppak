<template>
    <dashboard-modal title="Lihat Rating" id="modal-lihat-rating" dialog-class="modal-sm">
        <label class="form-label fw-bolder fs-6 mb-3">Rating</label>
        <star-rating :show-rating="false" read-only :star-size="30" :rating="data.rating"></star-rating>
        <label class="form-label fw-bolder fs-6 mb-3 mt-5">Review</label>
        <div v-html="data.review"></div>
        <template #footer>
            <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="$emit('onClose')">
                OK
            </button>
        </template>
    </dashboard-modal>
</template>

<script>
import StarRating from 'vue-star-rating';

export default {
    components: {StarRating},
    props: ['data'],
}
</script>