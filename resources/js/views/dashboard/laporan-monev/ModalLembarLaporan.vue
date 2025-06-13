<template>
    <dashboard-modal
        title="Lihat Laporan Kegiatan"
        id="modal-lembar-laporan"
        dialog-class="modal-xl"
        style="max-width: 1000px !important"
    >
        <table
            role="presentation"
            width="100%"
            style="border: 1px solid #b7b7b7"
        >
            <tbody>
                <!-- Header -->
                <tr>
                    <td></td>
                    <td
                        colspan="5"
                        class="text-center fw-bolder"
                        style="font-size: 16px"
                    >
                        LAPORAN PELAKSANAAN KEGIATAN MONITORING DAN EVALUASI
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="5" class="text-center" style="font-size: 14px">
                        PETUGAS DP3APPKB
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="5" class="text-center">{{ tanggal }}</td>
                </tr>

                <!-- Details -->
                <tr>
                    <td></td>
                    <td class="fw-bolder" colspan="2">Nama Lengkap</td>
                    <td>:</td>
                    <td colspan="4">{{ konselor?.name || "-" }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="fw-bolder" colspan="2">NIK</td>
                    <td>:</td>
                    <td colspan="4">{{ konselor?.dkonselor?.nik || "-" }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="fw-bolder" colspan="2">Jabatan Petugas</td>
                    <td>:</td>
                    <td colspan="4">{{ jabatan || "-" }}</td>
                </tr>

                <!-- Dynamic Content -->
                <template
                    v-for="kategori in categoriesWithQuestions.filter(
                        (it) => it.name !== 'Dokumentasi'
                    )"
                >
                    <tr>
                        <td></td>
                        <td colspan="5" class="fw-bolder">
                            {{ kategori.name }}
                        </td>
                    </tr>
                    <tr v-for="sub_kategori in kategori.sub_kategori">
                        <td></td>
                        <td></td>
                        <td>{{ sub_kategori.name }}</td>
                        <td>:</td>
                        <td>
                            {{
                                Object.values(answers).filter(
                                    (it) =>
                                        it.id_sub_kategori === sub_kategori.id
                                ).length
                            }}
                            dari {{ sub_kategori.kuesioner.length }} Pertanyaan
                            Selesai
                        </td>
                    </tr>
                </template>

                <!-- Documentation Section -->
                <template v-if="dokumentasi">
                    <tr>
                        <td colspan="8">
                            <div
                                style="display: grid; height: 200px"
                                :style="{
                                    gridTemplateColumns: `repeat(${dokumentasi.length}, 1fr)`,
                                }"
                            >
                                <template v-for="d in dokumentasi">
                                    <img
                                        v-if="getImageUrl(d.key)"
                                        :src="getImageUrl(d.key)"
                                        :alt="d.question"
                                        style="
                                            width: 100%;
                                            height: 100%;
                                            object-fit: cover;
                                            outline: 1px solid #b7b7b7;
                                        "
                                    />
                                    <div
                                        v-else
                                        class="d-flex justify-content-center align-items-center"
                                        style="outline: 1px solid #b7b7b7"
                                    >
                                        {{ d.question }}
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>

        <!-- Actions -->
        <div class="d-flex mt-10 justify-content-center">
            <button
                type="button"
                class="btn btn-sm btn-light"
                style="margin-right: 1rem"
                data-bs-dismiss="modal"
                @click="closeModal"
            >
                Tutup
            </button>
            <button
                v-if="hideSubmit !== true"
                class="btn btn-sm bg-second-primary-custom text-white"
                type="button"
                @click="$emit('onSubmit')"
            >
                Simpan
            </button>
        </div>
    </dashboard-modal>
</template>

<script>
export default {
    props: [
        "answers",
        "categoriesWithQuestions",
        "konselor",
        "balaiPuspaga",
        "jabatan",
        "date",
        "hideSubmit",
    ],
    emits: ["onSubmit"],
    methods: {
        closeModal() {
            $("#modal-lembar-laporan").modal("hide");
        },
        getImageUrl(key) {
            if (this.answers[key]?.answer) {
                const answer = this.answers[key].answer;
                if (typeof answer === "string") return answer;
                return URL.createObjectURL(this.answers[key].answer);
            }
            return null;
        },
    },
    computed: {
        dokumentasi() {
            return (
                this.categoriesWithQuestions
                    .find((it) => it.name == "Dokumentasi")
                    ?.sub_kategori.reduce((prev, current) => {
                        current.kuesioner.forEach((kuesioner) => {
                            prev.push(kuesioner);
                        });
                        return prev;
                    }, []) || []
            );
        },
        tanggal() {
            return this.date
                ? this.$moment(this.date).locale("id").format("DD MMMM YYYY")
                : "-";
        },
        kabupaten() {
            return (
                this.balaiPuspaga.kelurahan?.kecamatan?.kabupaten?.name || "-"
            );
        },
    },
};
</script>
