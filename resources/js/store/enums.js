import Api from "@/services/api";

const enums = {
    namespaced: true,
    state: {
        day: {},
        jenisKie: {},
        lang: {},
        statusKonseling: {},
        jenisKonsultan: {},
        jenisMahasiswaStatus: {},
        laporanKegiatanKonselingType: {},
        laporanKegiatanSosialisasiType: {},
        laporanKegiatanFileType: {},
        laporanKegiatanStatus: {},
        laporanMonevKuesionerInputType: {},
        optionsDay: [],
        optionsJenisKie: [],
        optionsJenisMahasiswaStatus: [],
        optionsLaporanKegiatanKonselingType: [],
        optionsLaporanKegiatanSosialisasiType: [],
        optionsLaporanMonevKuesionerInputType: [],
        isFetched: false,
    },
    mutations: {
        setData(state, payload) {
            state.day = payload.day;
            state.jenisKie = payload.jenisKie;
            state.lang = payload.lang;
            state.statusKonseling = payload.statusKonseling;
            state.jenisKonsultan = payload.jenisKonsultan;
            state.jenisMahasiswaStatus = payload.jenisMahasiswaStatus;
            state.laporanKegiatanKonselingType =
                payload.laporanKegiatanKonselingType;
            state.laporanKegiatanSosialisasiType =
                payload.laporanKegiatanSosialisasiType;
            state.laporanKegiatanFileType = payload.laporanKegiatanFileType;
            state.laporanKegiatanStatus = payload.laporanKegiatanStatus;
            state.laporanMonevKuesionerInputType =
                payload.laporanMonevKuesionerInputType;
            state.optionsDay = Object.values(payload.day)
                .sort((a, b) => a.value - b.value)
                .map((it) => ({ id: it.value, text: it.label }));
            state.optionsJenisKie = Object.values(payload.jenisKie)
                .sort((a, b) => a.value - b.value)
                .map((it) => ({ id: it.value, text: it.label }));
            state.optionsJenisMahasiswaStatus = Object.values(
                payload.jenisMahasiswaStatus
            )
                .sort((a, b) => a.value - b.value)
                .map((it) => ({ id: it.value, text: it.label }));
            state.optionsLaporanMonevKuesionerInputType = Object.values(
                payload.laporanMonevKuesionerInputType
            )
                .sort((a, b) => a.value - b.value)
                .map((it) => ({ id: it.value, text: it.label }));
            state.optionsLaporanKegiatanKonselingType = Object.values(
                payload.laporanKegiatanKonselingType
            )
                .sort((a, b) => a.value - b.value)
                .map((it) => ({
                    id: it.value,
                    text: `${it.label} - ${it.description}`,
                }));
            state.optionsLaporanKegiatanSosialisasiType = Object.values(
                payload.laporanKegiatanSosialisasiType
            )
                .sort((a, b) => a.value - b.value)
                .map((it) => ({
                    id: it.value,
                    text: `${it.label}`,
                }));
            state.optionsLaporanKegiatanPublikasiKontenType = Object.values(
                payload.laporanKegiatanPublikasiKontenType
            )
                .sort((a, b) => a.value - b.value)
                .map((it) => ({ id: it.value, text: `${it.label}` }));
            state.optionsLaporanKegiatanPublikasiKieType = Object.values(
                payload.laporanKegiatanPublikasiKieType
            )
                .sort((a, b) => a.value - b.value)
                .map((it) => ({ id: it.value, text: `${it.label}` }));
            state.optionsLaporanKegiatanRapatType = Object.values(
                payload.laporanKegiatanRapatType
            )
                .sort((a, b) => a.value - b.value)
                .map((it) => ({ id: it.value, text: `${it.label}` }));
            state.optionsLaporanKegiatanSosialisasiSasaran = Object.values(
                payload.laporanKegiatanSosialisasiSasaran
            )
                .sort((a, b) => a.value - b.value)
                .map((it) => ({ id: it.value, text: `${it.label}` }));
        },
        setIsFetched(state, payload) {
            state.isFetched = payload;
        },
    },
    actions: {
        getEnums({ commit, state }) {
            if (state.isFetched) return;
            Api()
                .get("public/all-enum")
                .then((response) => {
                    if (response.data) {
                        commit("setData", response.data);
                        commit("setIsFetched", true);
                    }
                });
        },
    },
};

export default enums;
