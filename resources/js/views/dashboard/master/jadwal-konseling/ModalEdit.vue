<template>
    <dashboard-modal :title="`Edit Jadwal Konsultasi (${konsultan_type})`" id="modal-edit" dialog-class="modal-bs">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label fw-bolder fs-6">Konsultan</label>
            <div class="col-sm-8">
                <input class="form-control-plaintext" v-model="selectedKonsultan" readonly/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label fw-bolder fs-6">Hari</label>
            <div class="col-sm-8">
                <input class="form-control-plaintext mb-5" v-model="selectedDay" readonly/>
            </div>
        </div>

        <label class="form-label fw-bolder fs-6 mb-3">Sesi</label>
        <FormSesi 
            v-for="item in sessions"
            :key="item.id"
            :item="item"
            :id_jadwal_konseling="data.id"
            :kategoriKonselingOptions="kategoriKonselingOptions"
            @onRemoveSession="onRemoveSession(item.id)"
            @onSuccess="$emit('onSuccess')"
        />
        <div class="d-flex justify-content-center">
            <button class="btn btn-sm bg-second-primary-custom text-white" type="button" @click="onAddSession">
                Tambah Sesi
            </button>
        </div>
        <template #footer>
            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
        </template>
    </dashboard-modal>
</template>


<script>
import FormSesi from './FormSesi.vue';

const createGenId=() => {
    let id = 1;
    return () => {
        return id++;
    }
}

const genId = createGenId();

export default {
    props: ['data', 'kategoriKonselingOptions'],
    data() {
        return {
            konsultan_type: '',
            selectedKonsultan: '',
            selectedDay: '',
            sessions: []
        };
    },
    methods: {
        onSubmit() {
            $("#modal-edit").modal('hide');
        },
        onAddSession() {
            this.sessions.push({ id: genId() + '-create', start: '', end: '', category: '', isNew: true, });
        },
        onRemoveSession(id) {
            this.sessions = this.sessions.filter(it => it.id !== id);
        },
    },
    watch: {
        data(n, p) {
            if (n !== p) {
                this.konsultan_type = n.konsultan_type
                this.selectedKonsultan = n.konsultan_name;
                this.selectedDay = n.day_string;
                this.sessions = n.jadwal_detail.map(it => ({
                    ...it,
                    start: it.start_time,
                    end: it.end_time,
                    category: it.id_kategori_konseling,
                }));
            }
        }
    },
    components: { FormSesi }
}
</script>