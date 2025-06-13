import Api from "@/services/api";

const client = {
    namespaced: true,
    state: {
        listComplaintHistory: {
            loading: false,
            data: [],
        },
        listHandlingHistory: {
            loading: false,
            data: []
        },
    },
    mutations: {
        SET_LOADING_COMPLAINT_HISTORY_DATA(state, payload) {
            state.listComplaintHistory.loading = payload;
        },
        SET_COMPLAINT_HISTORY_DATA(state, payload) {
            state.listComplaintHistory.data = [];
            for (let i = 0; i < payload.length; i++) {
                state.listComplaintHistory.data.push({
                    id: payload[i].id,
                    date: payload[i].date,
                    flagTab: 'pengaduan',
                    showDetailResultOutreach: false,
                    detailComplaint: {
                        loading: false,
                        id: '',
                        registerNumber: '',
                        sourceOfComplaint: '',
                        datetime: '',
                        createdAt: '',
                        outreachId: '',
                        reportIdentity: {
                            fullName: '',
                            nik: '',
                            phoneNumber: '',
                            surabayaResidents: 1,
                            districtOutsideSurabaya: '',
                            addressDomicile: '',
                        },
                        clientIdentity: {
                            fullName: '',
                            initialName: '',
                            identityNumber: '',
                            typeIdentityNumber: '',
                            surabayaResidents: 1,
                            districtOutsideSurabaya: '',
                            subDistrictDomicile: '',
                            villageDomicile: '',
                            addressDomicile: '',
                            phoneNumber: ''
                        },
                        problem: {
                            note: ''
                        },
                        documentation: {
                            existing: []
                        },
                        status: {
                            id: '',
                            description: '',
                            label_status: '',
                            status: '',
                        },
                        initialTreatment: {
                            loading: false,
                            id: '',
                            datetime: '',
                            note: '',
                            files: [],
                        },
                        outreachComplaint: {
                            id: '',
                            loading: false,
                            plan: {
                                datetime: '',
                                place: '',
                                address: '',
                            },
                            konselorTeam: [],
                            result: {
                                draftStatus: true,
                                caseType: '',
                                problemType: '',
                                needPreparator: true,
                                caseCategory: '',
                                caseSpecies: '',
                                caseLocation: '',
                                note: '',
                                datetime: '',
                                lastRollbackNote: '',
                                pendampingan: false,
                                files: {
                                    berita_acara_pendampingan: [],
                                    surat_pernyataan_klien: null,
                                    surat_pernyataan_selesai_pendampingan: null,
                                    surat_pernyataan_tidak_bersedia_didampingi: null,
                                },
                                listOutreach: [{
                                        id: 'data-klien',
                                        text: 'Data Klien',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Masukkan informasi detail identitas klien hingga alamat.',
                                    },
                                    {
                                        id: 'data-pelaku',
                                        text: 'Data Pelaku',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Masukkan informasi detail identitas pelaku hingga alamat.',
                                    },
                                    {
                                        id: 'data-keluarga-klien',
                                        text: 'Data Keluarga Klien',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Masukkan informasi detail identitas keluarga klien terkait ayah, ibu dan saudara-saudara.',
                                    },
                                    {
                                        id: 'situasi-keluarga',
                                        text: 'Situasi Keluarga',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Deskripsikan kondisi situasi keluarga pada saat kejadian dan saat ini.',
                                    },
                                    {
                                        id: 'kronologi-kejadian',
                                        text: 'Kronologi Kejadian',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Deskripsikan kronologis kejadian secara lengkap.',
                                    },
                                    {
                                        id: 'harapan-klien-dan-keluarga',
                                        text: 'Harapan Klien dan Keluarga',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Deskripsikan harapan yang diinginkan oleh klien dan keluarga dari kejadian ini. ',
                                    },
                                    {
                                        id: 'kondisi-klien',
                                        text: 'Kondisi Klien',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Masukkan informasi detail kondisi klien terkait kondisi fisik, psikologis dst.',
                                    },
                                    {
                                        id: 'rencana-analis-kebutuhan-klien',
                                        text: 'Rencana Analis Kebutuhan Klien Oleh DP3KAPPKB',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Masukkan detail rencana rujukan yang akan diberikan kepada klien.',
                                    },
                                    {
                                        id: 'rencana-rujukan-kebutuhan-klien',
                                        text: 'Rencana Rujukan Kebutuhan Klien',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Masukkan detail rencana rujukan yang akan diberikan kepada klien.',
                                    },
                                    {
                                        id: 'langkah-yang-telah-dilakukan',
                                        text: 'Langkah yang Telah Dilakukan',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Masukkan informasi pelayanan yang telah diberikan dari instansi terkait.'
                                    },
                                    {
                                        id: 'dokumen-pendukung',
                                        text: 'Dokumen Pendukung',
                                        datetime: '',
                                        konselor: '',
                                        status: 'waiting',
                                        desc: 'Unggah dokumen pendukung antara lain foto klien, KK, KTP, tempat tinggal dsb.',
                                    }
                                ]
                            }
                        }
                    },


                })
            }
        },
        SET_FLAG_TAB_COMPLAINT_HISTORY_DATA(state, payload) {
            if (state.listComplaintHistory.data.length > 0) {
                if (state.listComplaintHistory.data[payload.index]) {
                    state.listComplaintHistory.data[payload.index].flagTab = payload.data;
                }
            }
        },
        SET_TOGGLE_OUTREACH_RESULT_COMPLAINT_HISTORY_DATA(state, payload) {
            if (state.listComplaintHistory.data.length > 0) {
                if (state.listComplaintHistory.data[payload.index]) {
                    state.listComplaintHistory.data[payload.index].showDetailResultOutreach = payload.data;
                }
            }
        },
        SET_LOADING_DETAIL_COMPLAINT_HISTORY_DATA(state, payload) {
            if (state.listComplaintHistory.data.length > 0) {
                if (state.listComplaintHistory.data[payload.index]) {
                    state.listComplaintHistory.data[payload.index].detailComplaint.loading = payload.data;
                }
            }
        },
        SET_DETAIL_COMPLAINT_HISTORY_DATA(state, payload) {
            if (state.listComplaintHistory.data.length > 0) {
                if (state.listComplaintHistory.data[payload.index]) {
                    state.listComplaintHistory.data[payload.index].detailComplaint.id = payload.data ? payload.data.id : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.registerNumber = payload.data ? payload.data.waktu_pengaduan.nomor_registrasi : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.sourceOfComplaint = payload.data ? payload.data.waktu_pengaduan.sumber_pengaduan : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.datetime = payload.data ? payload.data.waktu_pengaduan.waktu_penngaduan : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.createdAt = payload.data ? payload.data.created_at : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachId = payload.data ? payload.data.penjangkauan_id : null;

                    state.listComplaintHistory.data[payload.index].detailComplaint.reportIdentity.fullName = payload.data ? payload.data.identitas_pelapor.nama : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.reportIdentity.nik = payload.data ? payload.data.identitas_pelapor.nik : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.reportIdentity.phoneNumber = payload.data ? payload.data.identitas_pelapor.nomor : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.reportIdentity.surabayaResidents = payload.data ? payload.data.identitas_pelapor
                        .warga_surabaya ? 1 : 0 : 1;
                    state.listComplaintHistory.data[payload.index].detailComplaint.reportIdentity.districtOutsideSurabaya = payload.data ? payload.data
                        .identitas_pelapor.kabupaten : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.reportIdentity.addressDomicile = payload.data ? payload.data.identitas_pelapor
                        .alamat : null;

                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.fullName = payload.data ? payload.data.identitas_klien.nama : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.initialName = payload.data ? payload.data.identitas_klien
                        .inisial_klien : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.identityNumber = payload.data ? payload.data.identitas_klien.nik : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.typeIdentityNumber = payload.data ? payload.data.identitas_klien
                        .label_nik : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.surabayaResidents = payload.data ? payload.data.identitas_klien
                        .warga_surabaya ? 1 : 0 : 1;
                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.districtOutsideSurabaya = payload.data ? payload.data
                        .identitas_klien.kabupaten : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.subDistrictDomicile = payload.data ? payload.data.identitas_klien
                        .kecamatan : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.villageDomicile = payload.data ? payload.data.identitas_klien
                        .kelurahan : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.addressDomicile = payload.data ? payload.data.identitas_klien
                        .alamat : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.clientIdentity.phoneNumber = payload.data ? payload.data.identitas_klien.nomor : null;

                    state.listComplaintHistory.data[payload.index].detailComplaint.problem.note = payload.data ? payload.data.permasalahan.uraian : null;

                    state.listComplaintHistory.data[payload.index].detailComplaint.documentation.file = payload.data ? payload.data.dokumentasi : null;

                    state.listComplaintHistory.data[payload.index].detailComplaint.status.id = payload.data ? payload.data.status.id : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.status.description = payload.data ? payload.data.status.description : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.status.label_status = payload.data ? payload.data.status.label_status : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.status.status = payload.data ? payload.data.status.status : null;
                }
            }
        },
        SET_LOADING_DETAIL_INITIAL_TREATMENT_COMPLAINT_HISTORY_DATA(state, payload) {
            if (state.listComplaintHistory.data.length > 0) {
                if (state.listComplaintHistory.data[payload.index]) {
                    state.listComplaintHistory.data[payload.index].detailComplaint.initialTreatment.loading = payload.data;
                }
            }
        },
        SET_DETAIL_INITIAL_TREATMENT_COMPLAINT_HISTORY_DATA(state, payload) {
            if (state.listComplaintHistory.data.length > 0) {
                if (state.listComplaintHistory.data[payload.index]) {
                    state.listComplaintHistory.data[payload.index].detailComplaint.initialTreatment.id = payload.data ? payload.data.id : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.initialTreatment.datetime = payload.data ? payload.data.waktu : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.initialTreatment.note = payload.data ? payload.data.keterangan : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.initialTreatment.files = payload.data ? payload.data.files : [];
                }
            }
        },
        SET_LOADING_DETAIL_OUTREACH_COMPLAINT_HISTORY_DATA(state, payload) {
            if (state.listComplaintHistory.data.length > 0) {
                if (state.listComplaintHistory.data[payload.index]) {
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.loading = payload.data;
                }
            }
        },
        SET_DETAIL_OUTREACH_COMPLAINT_HISTORY_DATA(state, payload) {

            if (state.listComplaintHistory.data.length > 0) {
                if (state.listComplaintHistory.data[payload.index]) {
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.id = payload.data ? payload.data.id : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.plan.datetime = payload.data ? (payload.data.tanggal_panjangkauan && payload.data.waktu_penjangkauan) ? payload.data.tanggal_panjangkauan + ' ' + payload.data.waktu_penjangkauan : '' : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.plan.place = payload.data ? payload.data.location : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.plan.address = payload.data ? payload.data.address : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.konselorTeam = payload.data ? payload.data.penjangkauan_konselor : [];

                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.draftStatus = payload.data ? payload.data.draft_status : true;
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.caseType = payload.data ? payload.data.case_type : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.problemType = payload.data ? payload.data.tipe_permaslahan ? payload.data.tipe_permaslahan.nama : '' : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.caseCategory = payload.data ? payload.data.kategori_kasus ? payload.data.kategori_kasus.nama : '' : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.caseSpecies = payload.data ? payload.data.jenis_kasus ? payload.data.jenis_kasus.name : '' : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.caseLocation = payload.data ? payload.data.lokasi_kejadian ? payload.data.lokasi_kejadian.name : '' : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.note = payload.data ? payload.data.case_description : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.datetime = payload.data ? (payload.data.tanggal_kejadian && payload.data.waktu_kejadian) ? payload.data.tanggal_kejadian + ' ' + payload.data.waktu_kejadian : '' : '';

                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.pendampingan = payload.data ? payload.data.pendampingan : false;
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.files.berita_acara_pendampingan = payload.data ? payload.data.files ? payload.data.files.berita_acara_pendampingan : [] : [];
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.files.surat_pernyataan_klien = payload.data ? payload.data.files ? payload.data.files.surat_pernyataan_klien : null : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan = payload.data ? payload.data.files ? payload.data.files.surat_pernyataan_selesai_pendampingan : null : null;
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi = payload.data ? payload.data.files ? payload.data.files.surat_pernyataan_tidak_bersedia_didampingi : null : null;

                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.lastRollbackNote = payload.data && payload.data.last_rollback ? payload.data.last_rollback.description : '';
                    state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.needPreparator = payload.data ? payload.data.tipe_permaslahan ? payload.data.tipe_permaslahan.butuh_pelaku : true : true;
                }
            }
        },
        SET_LIST_OUTREACH_RESULT_COMPLAINT_HISTORY_DATA(state, payload) {
            if (state.listComplaintHistory.data.length > 0) {
                if (state.listComplaintHistory.data[payload.index]) {
                    for (let x = 0; x < payload.data.length; x++) {
                        state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.listOutreach[x].status = payload.data[x].status;
                        state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.listOutreach[x].datetime = payload.data[x].datetime;
                        state.listComplaintHistory.data[payload.index].detailComplaint.outreachComplaint.result.listOutreach[x].konselor = payload.data[x].konselor;
                    }
                }
            }
        },
        SET_LOADING_HANDLING_HISTORY_DATA(state, payload) {
            state.listHandlingHistory.loading = payload;
        },
        SET_HANDLING_HISTORY_DATA(state, payload) {
            state.listHandlingHistory.data = payload;
        }
    },
    actions: {
        async getComplaintHistory({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_COMPLAINT_HISTORY_DATA', true);
                commit('SET_COMPLAINT_HISTORY_DATA', []);
                const response = await Api().get('daftar-klien/' + payload + '/histori-pengaduan');

                if (response.status === 200) {
                    commit('SET_COMPLAINT_HISTORY_DATA', response.data.data);
                }

                commit('SET_LOADING_COMPLAINT_HISTORY_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_COMPLAINT_HISTORY_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintHistory({
            commit,
            state
        }, payload) {
            const index = state.listComplaintHistory.data.findIndex((e) => e.id == payload);
            try {

                commit('SET_LOADING_DETAIL_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: true
                });
                commit('SET_DETAIL_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: null
                });

                const response = await Api().get('pengaduan/' + payload);

                if (response.status === 200) {

                    let responseX = {
                        index: index,
                        data: response.data.data
                    }

                    commit('SET_DETAIL_COMPLAINT_HISTORY_DATA', responseX);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: null
                });
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: null
                });
                return _error;
            }
        },
        async getInitialTreatmentComplaintHistory({
            commit,
            state
        }, payload) {
            const index = state.listComplaintHistory.data.findIndex((e) => e.id == payload);
            try {

                commit('SET_LOADING_DETAIL_INITIAL_TREATMENT_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: true
                });
                commit('SET_DETAIL_INITIAL_TREATMENT_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: null
                });

                const response = await Api().get('pengaduan/' + payload + '/penanganan-awal');

                if (response.status === 200) {

                    let responseX = {
                        index: index,
                        data: response.data.data
                    }

                    commit('SET_DETAIL_INITIAL_TREATMENT_COMPLAINT_HISTORY_DATA', responseX);
                }

                commit('SET_LOADING_DETAIL_INITIAL_TREATMENT_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: false
                });
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_INITIAL_TREATMENT_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: false
                });
                return _error;
            }
        },
        getStatusOutreachResult({
            commit
        }, payload) {
            if (payload === null) {
                return 'waiting';
            } else {
                if (payload) {
                    return 'draft'
                } else {
                    return 'done';
                }
            }
        },
        async getOutreachComplaintHistory({
            commit,
            dispatch,
            state

        }, payload) {
            const index = state.listComplaintHistory.data.findIndex((e) => e.id == payload);

            let outreachId = '';
            if (index >= 0) {
                outreachId = state.listComplaintHistory.data[index].detailComplaint.outreachId;
            }
            try {

                commit('SET_LOADING_DETAIL_OUTREACH_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: true
                });
                commit('SET_DETAIL_OUTREACH_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: null
                });

                let listResultOutreachReset = [{
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    },
                    {
                        status: 'waiting',
                        datetime: '',
                        konselor: ''
                    }
                ]

                let responseO = {
                    index: index,
                    data: listResultOutreachReset
                }
                commit('SET_LIST_OUTREACH_RESULT_COMPLAINT_HISTORY_DATA', responseO);

                const response = await Api().get('penjangkauan/' + outreachId);

                if (response.status === 200) {

                    let responseX = {
                        index: index,
                        data: response.data.data
                    }

                    let context = response.data.data;

                    let listResultOutreach = [{
                            status: await dispatch('getStatusOutreachResult', context.klien_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.klien_updated_at,
                            konselor: context.klien_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.pelaku_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.pelaku_updated_at,
                            konselor: context.pelaku_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.keluarga_klien_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.keluarga_klien_updated_at,
                            konselor: context.keluarga_klien_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.situasi_keluarga_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.situasi_keluarga_updated_at,
                            konselor: context.situasi_keluarga_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.kronologi_kejadian_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.kronologi_kejadian_updated_at,
                            konselor: context.kronologi_kejadian_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.harapan_klien_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.harapan_klien_updated_at,
                            konselor: context.harapan_klien_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.kondisi_klien_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.kondisi_klien_updated_at,
                            konselor: context.kondisi_klien_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.analisis_dp3kappkb_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.analisis_dp3kappkb_updated_at,
                            konselor: context.analisis_dp3kappkb_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.rencana_intervensi_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.rencana_intervensi_updated_at,
                            konselor: context.rencana_intervensi_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.langkah_dilakukan_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.langkah_dilakukan_updated_at,
                            konselor: context.langkah_dilakukan_updated_by
                        },
                        {
                            status: await dispatch('getStatusOutreachResult', context.dokumen_pendukung_draft_status).then((res) => {
                                return res;
                            }),
                            datetime: context.dokumen_pendukung_updated_at,
                            konselor: context.dokumen_pendukung_updated_by
                        }
                    ]

                    let responseO = {
                        index: index,
                        data: listResultOutreach
                    }
                    commit('SET_LIST_OUTREACH_RESULT_COMPLAINT_HISTORY_DATA', responseO);
                    commit('SET_DETAIL_OUTREACH_COMPLAINT_HISTORY_DATA', responseX);
                }

                commit('SET_LOADING_DETAIL_OUTREACH_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: false
                });
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_OUTREACH_COMPLAINT_HISTORY_DATA', {
                    index: index,
                    data: false
                });
                return _error;
            }
        },
        async getHandlingHistory({
            commit
        }, payload) {
            try {

                commit('SET_LOADING_HANDLING_HISTORY_DATA', true);
                commit('SET_HANDLING_HISTORY_DATA', []);

                const response = await Api().get('daftar-klien/' + payload + '/histori-penanganan');

                if (response.status === 200) {

                    commit('SET_HANDLING_HISTORY_DATA', response.data.data);
                }

                commit('SET_LOADING_HANDLING_HISTORY_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_HANDLING_HISTORY_DATA', false);
                return _error;
            }
        },



    },
}

export default client;
