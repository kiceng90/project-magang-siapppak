import Api from "@/services/api";

const complaint = {
    namespaced: true,
    state: {

        detailComplaint: {
            loading: false,
            id: '',
            registerNumber: '',
            sourceOfComplaint: '',
            datetime: '',
            remainingTimeApproval: '',
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
            }
        },
        outreachComplaint: {
            loading: false,
            id: '',
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
                client: {
                    loading: false,
                    data: null,
                },
                perpetrator: {
                    name: '',
                    gender: '', //1 = laki laki, 2 = perempuan
                    citizenship: '', //1 = WNI, 2 = WNA
                    relationship: '',
                    phoneNumber: '',
                    dateOfBirth: '',
                    placeOfBirth: '',
                    nik: '',
                    kk: '',
                    addressDomicile: '',
                    subDistrictDomicile: '',
                    villageDomicile: '',
                    addressKK: '',
                    subDistrictKK: '',
                    villageKK: '',
                    religion: '',
                    proffesion: '',
                    maritalStatus: '',
                    education: {
                        lastEducation: '',
                        schoolMajors: '',
                        class: '',
                        graduationYear: '',
                        schoolName: '',
                    }

                },
                clientFamily: {
                    family: [],
                    sibling: [],
                },
                familySituation: {
                    loading: false,
                    note: '',
                },
                cronologyIncident: {
                    loading: false,
                    note: '',
                },
                hopeClient: {
                    loading: false,
                    note: '',
                },
                clientCondition: {
                    loading: false,
                    physique: '',
                    psychological: '',
                    social: '',
                    spiritual: ''
                },
                supportingDocuments: {
                    loading: false,
                    clientPhoto: [],
                    clientResidencePhoto: [],
                    ClientInitialAssistancePhoto: [],
                    ClientContinuedAssistancePhoto: [],
                    ClientMonitoringAssistancePhoto: [],
                    clientIdentityPhoto: [],
                    surat: [],
                },
                clientNeedsAnalysisPlan: {
                    loading: false,
                    data: [],
                },
                clientNeedsReferralPlan: {
                    loading:false,
                    data: [],
                },
                stepsThatHaveBeenTaken: {
                    loading: false,
                    data: []
                }
            }
        },
        realizationPlanningInteventionOpd: {
            loading: false,
            data: []
        }
    },
    mutations: {
        SET_LOADING_DETAIL_COMPLAINT_DATA(state, payload) {
            state.detailComplaint.loading = payload;
        },
        SET_DETAIL_COMPLAINT_DATA(state, payload) {
            state.detailComplaint.id = payload ? payload.id : null;
            state.detailComplaint.registerNumber = payload ? payload.waktu_pengaduan.nomor_registrasi : null;
            state.detailComplaint.sourceOfComplaint = payload ? payload.waktu_pengaduan.sumber_pengaduan : null;
            state.detailComplaint.datetime = payload ? payload.waktu_pengaduan.waktu_penngaduan : null;
            state.detailComplaint.createdAt = payload ? payload.created_at : null;
            state.detailComplaint.outreachId = payload ? payload.penjangkauan_id : null;

            state.detailComplaint.reportIdentity.fullName = payload ? payload.identitas_pelapor.nama : null;
            state.detailComplaint.reportIdentity.nik = payload ? payload.identitas_pelapor.nik : null;
            state.detailComplaint.reportIdentity.phoneNumber = payload ? payload.identitas_pelapor.nomor : null;
            state.detailComplaint.reportIdentity.surabayaResidents = payload ? payload.identitas_pelapor
                .warga_surabaya ? 1 : 0 : 1;
            state.detailComplaint.reportIdentity.districtOutsideSurabaya = payload ? payload
                .identitas_pelapor.kabupaten : null;
            state.detailComplaint.reportIdentity.addressDomicile = payload ? payload.identitas_pelapor
                .alamat : null;

            state.detailComplaint.clientIdentity.fullName = payload ? payload.identitas_klien.nama : null;
            state.detailComplaint.clientIdentity.initialName = payload ? payload.identitas_klien
                .inisial_klien : null;
            state.detailComplaint.clientIdentity.identityNumber = payload ? payload.identitas_klien.nik : null;
            state.detailComplaint.clientIdentity.typeIdentityNumber = payload ? payload.identitas_klien
                .label_nik : null;
            state.detailComplaint.clientIdentity.surabayaResidents = payload ? payload.identitas_klien
                .warga_surabaya ? 1 : 0 : 1;
            state.detailComplaint.clientIdentity.districtOutsideSurabaya = payload ? payload
                .identitas_klien.kabupaten : null;
            state.detailComplaint.clientIdentity.subDistrictDomicile = payload ? payload.identitas_klien
                .kecamatan : null;
            state.detailComplaint.clientIdentity.villageDomicile = payload ? payload.identitas_klien
                .kelurahan : null;
            state.detailComplaint.clientIdentity.addressDomicile = payload ? payload.identitas_klien
                .alamat : null;
            state.detailComplaint.clientIdentity.phoneNumber = payload ? payload.identitas_klien.nomor : null;

            state.detailComplaint.problem.note = payload ? payload.permasalahan.uraian : null;

            state.detailComplaint.documentation.file = payload ? payload.dokumentasi : null;

            state.detailComplaint.status.id = payload ? payload.status.id : null;
            state.detailComplaint.status.description = payload ? payload.status.description : null;
            state.detailComplaint.status.label_status = payload ? payload.status.label_status : null;
            state.detailComplaint.status.status = payload ? payload.status.status : null;
        },
        SET_LOADING_DETAIL_COMPLAINT_INITIAL_TREATMENT_DATA(state, payload) {
            state.detailComplaint.initialTreatment.loading = payload;
        },
        SET_DETAIL_COMPLAINT_INITIAL_TREATMENT_DATA(state, payload) {
            state.detailComplaint.initialTreatment.id = payload ? payload.id : null;
            state.detailComplaint.initialTreatment.datetime = payload ? payload.waktu : null;
            state.detailComplaint.initialTreatment.note = payload ? payload.keterangan : null;
            state.detailComplaint.initialTreatment.files = payload ? payload.files : [];
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_DATA(state, payload) {
            state.outreachComplaint.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_DATA(state, payload) {
            state.outreachComplaint.id = payload ? payload.id : '';
            state.outreachComplaint.plan.datetime = payload ? (payload.tanggal_panjangkauan && payload.waktu_penjangkauan) ? payload.tanggal_panjangkauan + ' ' + payload.waktu_penjangkauan : '' : '';
            state.outreachComplaint.plan.place = payload ? payload.location : '';
            state.outreachComplaint.plan.address = payload ? payload.address : '';
            state.outreachComplaint.konselorTeam = payload ? payload.penjangkauan_konselor : [];
            state.outreachComplaint.lastRollbackNote = payload && payload.last_rollback ? payload.last_rollback.description : '';
            
            state.outreachComplaint.result.draftStatus = payload ? payload.draft_status : true;
            state.outreachComplaint.result.caseType = payload ? payload.case_type : '';
            state.outreachComplaint.result.problemType = payload ? payload.tipe_permaslahan ? payload.tipe_permaslahan.nama : '' : '';
            state.outreachComplaint.result.needPreparator = payload ? payload.tipe_permaslahan ? payload.tipe_permaslahan.butuh_pelaku : true : true;
            state.outreachComplaint.result.caseCategory = payload ? payload.kategori_kasus ? payload.kategori_kasus.nama : '' : '';
            state.outreachComplaint.result.caseSpecies = payload ? payload.jenis_kasus ? payload.jenis_kasus.name : '' : '';
            state.outreachComplaint.result.caseLocation = payload ? payload.lokasi_kejadian ? payload.lokasi_kejadian.name : '' : '';
            state.outreachComplaint.result.note = payload ? payload.case_description : '';
            state.outreachComplaint.result.pendampingan = payload ? payload.pendampingan : false;            
            state.outreachComplaint.result.files.berita_acara_pendampingan = payload ? payload.files ? payload.files.berita_acara_pendampingan : [] : [];
            state.outreachComplaint.result.files.surat_pernyataan_klien = payload ? payload.files ? payload.files.surat_pernyataan_klien : null : null;
            state.outreachComplaint.result.files.surat_pernyataan_selesai_pendampingan = payload ? payload.files ? payload.files.surat_pernyataan_selesai_pendampingan : null : null;
            state.outreachComplaint.result.files.surat_pernyataan_tidak_bersedia_didampingi = payload ? payload.files ? payload.files.surat_pernyataan_tidak_bersedia_didampingi : null : null;
            state.outreachComplaint.result.datetime = payload ? (payload.tanggal_kejadian && payload.waktu_kejadian) ? payload.tanggal_kejadian + ' ' + payload.waktu_kejadian : '' : '';
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_DATA(state, payload) {
            state.outreachComplaint.result.client.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_DATA(state, payload) {
            state.outreachComplaint.result.client.data = payload ? payload : null;
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_PERPETRATOR_DATA(state, payload) {
            state.outreachComplaint.result.perpetrator.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_PERPETRATOR_DATA(state, payload) {
            state.outreachComplaint.result.perpetrator.name = payload ? payload.name : '';
            state.outreachComplaint.result.perpetrator.gender = payload ? payload.gender : '';
            state.outreachComplaint.result.perpetrator.citizenship = payload ? payload.citizenship : '';
            state.outreachComplaint.result.perpetrator.relationship = payload ? payload.nama_hubungan : '';
            state.outreachComplaint.result.perpetrator.phoneNumber = payload ? payload.phone_number : '';
            state.outreachComplaint.result.perpetrator.dateOfBirth = payload ? payload.birth_date : '';
            state.outreachComplaint.result.perpetrator.placeOfBirth = payload ? payload.nama_kabupaten_lahir : '';
            state.outreachComplaint.result.perpetrator.nik = payload ? payload.nik_number : '';
            state.outreachComplaint.result.perpetrator.kk = payload ? payload.kk_number : '';
            state.outreachComplaint.result.perpetrator.addressDomicile = payload ? payload.residence_address : '';
            state.outreachComplaint.result.perpetrator.subDistrictDomicile = payload ? payload.nama_kecamatan_tinggal : '';
            state.outreachComplaint.result.perpetrator.villageDomicile = payload ? payload.nama_kelurahan_tinggal : '';
            state.outreachComplaint.result.perpetrator.addressKK = payload ? payload.kk_address : '';
            state.outreachComplaint.result.perpetrator.subDistrictKK = payload ? payload.nama_kecamatan_kk : '';
            state.outreachComplaint.result.perpetrator.villageKK = payload ? payload.nama_kelurahan_kk : '';
            state.outreachComplaint.result.perpetrator.religion = payload ? payload.nama_agama : '';
            state.outreachComplaint.result.perpetrator.proffesion = payload ? payload.nama_pekerjaan : '';
            state.outreachComplaint.result.perpetrator.maritalStatus = payload ? payload.nama_status_pernikahan : '';

            state.outreachComplaint.result.perpetrator.education.lastEducation = payload ? payload.nama_pendidikan_terakhir : '';
            state.outreachComplaint.result.perpetrator.education.schoolMajors = payload ? payload.nama_jurusan : '';
            state.outreachComplaint.result.perpetrator.education.class = payload ? payload.highest_class : '';
            state.outreachComplaint.result.perpetrator.education.graduationYear = payload ? payload.graduation_year : '';
            state.outreachComplaint.result.perpetrator.education.schoolName = payload ? payload.school_name : '';

        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_FAMILY_DATA(state, payload) {
            state.outreachComplaint.result.clientFamily.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_FAMILY_DATA(state, payload) {
            state.outreachComplaint.result.clientFamily.family = [];
            state.outreachComplaint.result.clientFamily.sibling = [];
            if(payload){
                for (let i = 0; i < payload.keluarga_klien.length; i++) {
                    let family = payload.keluarga_klien[i];
                    state.outreachComplaint.result.clientFamily.family.push({
                        relationship: family.hubungan?.name,
                        name: family.name,
                        nik: family.nik_number,
                        kk: family.kk_number,
                        phoneNumber: family.phone_number,
                        addressKK: family.kk_address,
                        districtKK: family.kelurahan_kk?.kecamatan?.kabupaten?.name,
                        subDistrictKK: family.kelurahan_kk?.kecamatan?.name,
                        villageKK: family.kelurahan_kk?.name,
                        addressDomicile: family.residence_address,
                        districtDomicile: family.kelurahan_tinggal?.kecamatan?.kabupaten?.name,
                        subDistrictDomicile: family.kelurahan_tinggal?.kecamatan?.name,
                        villageDomicile: family.kelurahan_tinggal?.name,
                        proffesion: family.pekerjaan?.name,
                        typeProffesion: family.work_type,
                        monthlyIncome: family.monthly_income,
                        religion: family.agama?.name,
                        placeOfBirth: family.kabupaten_lahir?.name,
                        dateOfBirth: family.birth_date,
                        bpjs_category: family.bpjs_category,
                    })
                }

                for(let i = 0; i < payload.saudara_klien.length; i++){
                    state.outreachComplaint.result.clientFamily.sibling.push({
                        name: payload.saudara_klien[i].name
                    });
                }
            }
            
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_FAMILY_SITUATION_DATA(state, payload) {
            state.outreachComplaint.result.familySituation.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_FAMILY_SITUATION_DATA(state, payload) {
            state.outreachComplaint.result.familySituation.note = payload ? payload.description : null;
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CRONOLOGY_INCIDENT_DATA(state, payload) {
            state.outreachComplaint.result.familySituation.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_CRONOLOGY_INCIDENT_DATA(state, payload) {
            state.outreachComplaint.result.cronologyIncident.note = payload ? payload.description : null;
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_HOPE_CLIENT_DATA(state, payload) {
            state.outreachComplaint.result.familySituation.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_HOPE_CLIENT_DATA(state, payload) {
            state.outreachComplaint.result.hopeClient.note = payload ? payload.description : null;
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_CONDITION_DATA(state, payload) {
            state.outreachComplaint.result.clientCondition.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_CONDITION_DATA(state, payload) {
            state.outreachComplaint.result.clientCondition.physique = payload ? payload.physical_description : null;
            state.outreachComplaint.result.clientCondition.psychological = payload ? payload.psycological_description : null;
            state.outreachComplaint.result.clientCondition.social = payload ? payload.social_description : null;
            state.outreachComplaint.result.clientCondition.spiritual = payload ? payload.spiritual_description : null;
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_SUPPORTING_DOCUMENTS_DATA(state, payload) {
            state.outreachComplaint.result.supportingDocuments.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_SUPPORTING_DOCUMENTS_DATA(state, payload) {
            state.outreachComplaint.result.supportingDocuments.clientPhoto = payload ? payload.foto_klien ? payload.foto_klien : [] : [];
            state.outreachComplaint.result.supportingDocuments.clientResidencePhoto = payload ? payload.foto_tempat_tinggal_klien ? payload.foto_tempat_tinggal_klien : [] : [];
            state.outreachComplaint.result.supportingDocuments.ClientInitialAssistancePhoto = payload ? payload.foto_pendampingan_awal_klien ? payload.foto_pendampingan_awal_klien : [] : [];
            state.outreachComplaint.result.supportingDocuments.ClientContinuedAssistancePhoto = payload ? payload.foto_pendampingan_lanjutan_klien ? payload.foto_pendampingan_lanjutan_klien : [] : [];
            state.outreachComplaint.result.supportingDocuments.ClientMonitoringAssistancePhoto = payload ? payload.foto_pendampingan_monitoring_klien ? payload.foto_pendampingan_monitoring_klien : [] : [];
            state.outreachComplaint.result.supportingDocuments.clientIdentityPhoto = payload ? payload.foto_identitas_klien ? payload.foto_identitas_klien : [] : [];
            state.outreachComplaint.result.supportingDocuments.surat = payload ? payload.surat ? payload.surat : [] : [];
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_ANALYSIS_PLAN_DATA(state, payload){
            state.outreachComplaint.result.clientNeedsAnalysisPlan.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_ANALYSIS_PLAN_DATA(state, payload){
            state.outreachComplaint.result.clientNeedsAnalysisPlan.data = payload;
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_REFFERAL_PLAN_DATA(state, payload){
            state.outreachComplaint.result.clientNeedsReferralPlan.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_REFFERAL_PLAN_DATA(state, payload){
            state.outreachComplaint.result.clientNeedsReferralPlan.data = payload;
        },
        SET_LOADING_DETAIL_COMPLAINT_OUTREACH_STEPS_THAT_HAVE_BEEK_TAKEN_DATA(state, payload){
            state.outreachComplaint.result.stepsThatHaveBeenTaken.loading = payload;
        },
        SET_DETAIL_COMPLAINT_OUTREACH_STEPS_THAT_HAVE_BEEK_TAKEN_DATA(state, payload){
            state.outreachComplaint.result.stepsThatHaveBeenTaken.data = payload;
        },
        SET_LOADING_REALIZATION_PLANNING_INTERVENTION_OPD_DATA(state, payload){
            state.realizationPlanningInteventionOpd.loading = payload;
        },
        SET_REALIZATION_PLANNING_INTERVENTION_OPD_DATA(state, payload){
            state.realizationPlanningInteventionOpd.data = payload;
        }
    },
    actions: {
        async getDetailComplaint({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_DATA', true);
                commit('SET_DETAIL_COMPLAINT_DATA', null);
                const response = await Api().get('pengaduan/' + payload);

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintInitialTreatment({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_INITIAL_TREATMENT_DATA', true);
                commit('SET_DETAIL_COMPLAINT_INITIAL_TREATMENT_DATA', null);
                const response = await Api().get('pengaduan/' + payload + '/penanganan-awal');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_INITIAL_TREATMENT_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_INITIAL_TREATMENT_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_INITIAL_TREATMENT_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreach({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_DATA', null);
                const response = await Api().get('penjangkauan/' + payload);

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachClient({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_DATA', null);

                const response = await Api().get('penjangkauan/' + payload + '/klien');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_DATA', response.data.data.klien);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachPerpetrator({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_PERPETRATOR_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_PERPETRATOR_DATA', null);

                const response = await Api().get('penjangkauan/' + payload + '/pelaku');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_PERPETRATOR_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_PERPETRATOR_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_PERPETRATOR_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachClientFamily({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_FAMILY_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_FAMILY_DATA', null);

                const response = await Api().get('penjangkauan/' + payload + '/keluarga_klien');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_FAMILY_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_FAMILY_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_FAMILY_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachFamilySituation({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_FAMILY_SITUATION_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_FAMILY_SITUATION_DATA', null);
                const response = await Api().get('penjangkauan/' + payload + '/situasi-keluarga');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_FAMILY_SITUATION_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_FAMILY_SITUATION_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_FAMILY_SITUATION_DATA', false);
                return _error;
            }
        },

        async getDetailComplaintOutreachCronologyIncident({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CRONOLOGY_INCIDENT_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_CRONOLOGY_INCIDENT_DATA', null);
                const response = await Api().get('penjangkauan/' + payload + '/kronologi-kejadian');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_CRONOLOGY_INCIDENT_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CRONOLOGY_INCIDENT_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CRONOLOGY_INCIDENT_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachHopeClient({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_HOPE_CLIENT_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_HOPE_CLIENT_DATA', null);
                const response = await Api().get('penjangkauan/' + payload + '/harapan-klien');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_HOPE_CLIENT_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_HOPE_CLIENT_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_HOPE_CLIENT_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachClientCondition({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_CONDITION_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_CONDITION_DATA', null);
                const response = await Api().get('penjangkauan/' + payload + '/kondisi-klien');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_CONDITION_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_CONDITION_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_CONDITION_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachClientNeedsAnalysisPlan({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_ANALYSIS_PLAN_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_ANALYSIS_PLAN_DATA', []);
                const response = await Api().get('penjangkauan/' + payload + '/analis-kebutuhan-klien');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_ANALYSIS_PLAN_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_ANALYSIS_PLAN_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_ANALYSIS_PLAN_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachClientNeedsReferralPlan({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_REFFERAL_PLAN_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_REFFERAL_PLAN_DATA', []);
                const response = await Api().get('penjangkauan/' + payload + '/rencana_intervensi');
                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_REFFERAL_PLAN_DATA', response.data.data.rencana_intervensi);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_REFFERAL_PLAN_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_CLIENT_NEED_REFFERAL_PLAN_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachStepsThatHaveBeenTaken({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_STEPS_THAT_HAVE_BEEK_TAKEN_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_STEPS_THAT_HAVE_BEEK_TAKEN_DATA', []);
                const response = await Api().get('penjangkauan/' + payload + '/langkah-telah-dilakukan');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_STEPS_THAT_HAVE_BEEK_TAKEN_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_STEPS_THAT_HAVE_BEEK_TAKEN_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_STEPS_THAT_HAVE_BEEK_TAKEN_DATA', false);
                return _error;
            }
        },
        async getDetailComplaintOutreachSupportingDocuments({
            commit
        }, payload) {
            try {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_SUPPORTING_DOCUMENTS_DATA', true);
                commit('SET_DETAIL_COMPLAINT_OUTREACH_SUPPORTING_DOCUMENTS_DATA', null);

                const response = await Api().get('penjangkauan/' + payload + '/dokumen-pendukung');

                if (response.status === 200) {
                    commit('SET_DETAIL_COMPLAINT_OUTREACH_SUPPORTING_DOCUMENTS_DATA', response.data.data);
                }

                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_SUPPORTING_DOCUMENTS_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_DETAIL_COMPLAINT_OUTREACH_SUPPORTING_DOCUMENTS_DATA', false);
                return _error;
            }
        },
        async getRealizationPlanningInterventionOpd({
            commit            
        }, planningInterventionId) {   
            try {

                commit('SET_LOADING_REALIZATION_PLANNING_INTERVENTION_OPD_DATA', true);
                commit('SET_REALIZATION_PLANNING_INTERVENTION_OPD_DATA', []);

                const response = await Api().get('pengaduan/realisasi-intervensi/' + planningInterventionId);

                if (response.status === 200) {                

                    commit('SET_REALIZATION_PLANNING_INTERVENTION_OPD_DATA', response.data.data);
                }

                commit('SET_LOADING_REALIZATION_PLANNING_INTERVENTION_OPD_DATA', false);
                return response;

            } catch (_error) {
                commit('SET_LOADING_REALIZATION_PLANNING_INTERVENTION_OPD_DATA', false);
                return _error;
            }
        },
    },
}

export default complaint;
