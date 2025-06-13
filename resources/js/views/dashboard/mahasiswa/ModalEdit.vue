<template>
    <dashboard-modal title="Edit Data Mahasiswa" id="modal-edit" dialog-class="modal-bs">
        <template #footer>
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="onSubmit">
                Simpan
            </button>
        </template>
    </dashboard-modal>
</template>

<script>
export default {
    methods: {
        onSubmit(){}
    }
}
</script>