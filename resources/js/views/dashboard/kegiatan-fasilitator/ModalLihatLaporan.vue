<template>
    <dashboard-modal
        title="Lihat Laporan Kegiatan"
        id="modal-lihat-laporan"
        dialog-class="modal-xl"
        style="max-width: 1000px !important"
    >
        <table
            role="presentation"
            width="100%"
            style="border: 1px solid #b7b7b7"
        >
            <tbody>
                <tr>
                    <td style="width: 10px; height: 10px"></td>
                    <td style="width: 20px"></td>
                    <td style="min-width: 170px"></td>
                    <td style="width: 10px"></td>
                    <td style="width: 300px"></td>
                    <td style="width: 200px"></td>
                    <td style="width: 400px"></td>
                    <td style="width: 10px"></td>
                </tr>
                <tr>
                    <td></td>
                    <td
                        class="text-center fw-bolder"
                        colspan="6"
                        style="font-size: 16px"
                    >
                        LAPORAN PELAKSANAAN KEGIATAN HARIAN
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="6" style="font-size: 14px">
                        FASILITATOR PUSPAGA RW
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="6">{{ tanggal }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>

                <tr v-for="field in baseFields" style="vertical-align: top">
                    <td></td>
                    <td class="fw-bolder" colspan="2">{{ field.label }}</td>
                    <td>:</td>
                    <td>{{ field.value || "-" }}</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr style="border-bottom: 1px solid #b7b7b7">
                    <td></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="fw-bolder" colspan="4">
                        Kegiatan Konseling / Konsultasi Klien
                    </td>
                    <td></td>
                    <td rowspan="9" style="vertical-align: top">
                        <div
                            style="
                                width: 250px;
                                height: 200px;
                                border: 1px solid #b7b7b7;
                            "
                        >
                            <img
                                v-if="fotoKlien"
                                :src="fotoKlien"
                                alt="Foto Kegiatan Konseling"
                                style="
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                "
                            />
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="field in konselingFields"
                    style="vertical-align: top"
                >
                    <td></td>
                    <td></td>
                    <td>{{ field.label }}</td>
                    <td>:</td>
                    <td>{{ field.value || (field.label ? "-" : "") }}</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr style="border-bottom: 1px solid #b7b7b7">
                    <td></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="fw-bolder" colspan="4">
                        <p class="mb-0">
                            Kegiatan Sosialisasi / Parenting /<br />Pembelajaran
                            Keluarga / Promosi / Edukasi
                        </p>
                    </td>
                    <td></td>
                    <td rowspan="9" style="vertical-align: top">
                        <div
                            style="
                                width: 250px;
                                height: 200px;
                                border: 1px solid #b7b7b7;
                            "
                        >
                            <img
                                v-if="fotoKegiatan"
                                :src="fotoKegiatan"
                                alt="Foto Kegiatan Sosialisasi"
                                style="
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                "
                            />
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="field in sosialisasiFields"
                    style="vertical-align: top"
                >
                    <td></td>
                    <td></td>
                    <td>{{ field.label }}</td>
                    <td>{{ field.label ? ":" : "&nbsp;" }}</td>
                    <td
                        v-if="field.isHtml"
                        v-html="field.value"
                        class="row-text-laporan"
                    ></td>
                    <td v-else>
                        {{ field.value || (field.label ? "-" : "") }}
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr style="border-bottom: 1px solid #b7b7b7">
                    <td></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="fw-bolder" colspan="4">
                        Kegiatan Rapat / Koordinasi
                    </td>
                    <td></td>
                    <td rowspan="9" style="vertical-align: top">
                        <div
                            style="
                                width: 250px;
                                height: 200px;
                                border: 1px solid #b7b7b7;
                            "
                        >
                            <img
                                v-if="fotoRapat"
                                :src="fotoRapat"
                                alt="Foto Kegiatan Rapat"
                                style="
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                "
                            />
                        </div>
                    </td>
                </tr>
                <tr v-for="field in rapatFields" style="vertical-align: top">
                    <td></td>
                    <td></td>
                    <td>{{ field.label }}</td>
                    <td>{{ field.label ? ":" : "&nbsp;" }}</td>
                    <td
                        v-if="field.isHtml"
                        v-html="field.value"
                        class="row-text-laporan"
                    ></td>
                    <td v-else>
                        {{ field.value || (field.label ? "-" : "") }}
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr style="border-top: 1px solid #b7b7b7">
                    <td></td>
                    <td class="p-3"></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="fw-bolder" colspan="4">
                        Kegiatan Piket Layanan
                    </td>
                    <td></td>
                    <td rowspan="9" style="vertical-align: top">
                        <div
                            style="
                                width: 250px;
                                height: 200px;
                                border: 1px solid #b7b7b7;
                            "
                        >
                            <img
                                v-if="fotoPiket"
                                :src="fotoPiket"
                                alt="Foto Kegiatan Piket"
                                style="
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                "
                            />
                        </div>
                    </td>
                </tr>
                <tr v-for="field in piketFields" style="vertical-align: top">
                    <td></td>
                    <td></td>
                    <td>{{ field.label }}</td>
                    <td>{{ field.label ? ":" : "&nbsp;" }}</td>
                    <td>{{ field.value || (field.label ? "-" : "") }}</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr style="border-bottom: 1px solid #b7b7b7">
                    <td></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="fw-bolder" colspan="4">
                        Kegiatan Publikasi KIE
                    </td>
                    <td></td>
                    <td rowspan="9" style="vertical-align: top">
                        <div
                            style="
                                width: 250px;
                                height: 200px;
                                border: 1px solid #b7b7b7;
                            "
                        >
                            <img
                                v-if="fotoKonten"
                                :src="fotoKonten"
                                alt="Screenshot Konten"
                                style="
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                "
                            />
                        </div>
                    </td>
                </tr>
                <tr v-for="field in kieFields" style="vertical-align: top">
                    <td></td>
                    <td></td>
                    <td>{{ field.label }}</td>
                    <td>{{ field.label ? ":" : "&nbsp;" }}</td>
                    <td v-if="field.isHtml" v-html="field.value"></td>
                    <td v-else>
                        {{ field.value || (field.label ? "-" : "") }}
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr style="border-bottom: 1px solid #b7b7b7">
                    <td></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="text-center" colspan="6">
                        {{ kabupaten }}, {{ tanggal }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="6">
                        Yang Membuat Laporan
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td class="text-center" colspan="6" rowspan="5">
                        <img
                            v-if="data?.fasilitator?.ttd_url"
                            :src="data.fasilitator?.ttd_url"
                            style="height: 150px"
                        />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center" colspan="6">
                        {{ data?.fasilitator?.name || "-" }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="height: 10px"></td>
                </tr>
            </tbody>
        </table>

        <template #footer>
            <button
                type="button"
                class="btn btn-sm btn-light"
                data-bs-dismiss="modal"
            >
                Tutup
            </button>
        </template>
    </dashboard-modal>
</template>

<script>
export default {
    props: ["data"],
    computed: {
        kabupaten() {
            return (
                this.data?.fasilitator?.kelurahan?.kecamatan?.kabupaten?.name ??
                ""
            );
        },
        baseFields() {
            const item = this.data.fasilitator ?? {};
            return [
                { label: "Nama Lengkap Petugas", value: item.name },
                { label: "Jabatan Petugas", value: item.jabatan?.name ?? "-" },
                { label: "Nomor HP (WhatsApp)", value: item.no_hp },
                { label: "Nomor KTP (NIK)", value: item.nik },
                { label: "Alamat Petugas", value: item.alamat_domisili },
                {
                    label: "Kelurahan Petugas",
                    value: item.kelurahan_domisili?.name,
                },
                {
                    label: "Kecamatan Petugas",
                    value: item.kelurahan_domisili?.kecamatan?.name,
                },
                { label: "Puspaga Balai RW", value: item.rw },
                { label: "Kelurahan Puspaga RW", value: item.kelurahan?.name },
                {
                    label: "Kecamatan Puspaga RW",
                    value: item.kelurahan?.kecamatan?.name,
                },
            ];
        },
        konselingFields() {
            if (this.data) {
                const data = this.data.laporan_konseling ?? {};
                return [
                    { label: "Nama Klien", value: data.name },
                    { label: "NIK", value: data.nik },
                    { label: "Warga Surabaya", value: data.warga_surabaya },
                    { label: "Alamat Domisili", value: data.address },
                    {
                        label: "Kecamatan Domisili",
                        value: data.kelurahan?.kecamatan?.name,
                    },
                    {
                        label: "Kelurahan Domisili",
                        value: data.kelurahan?.name,
                    },
                    { label: "No. Telpon Klien", value: data.phone },
                    {
                        label: "Uraian Singkat Permasalahan",
                        value: data.description,
                    },
                ];
            }

            return [];
        },
        sosialisasiFields() {
            if (this.data) {
                const data = this.data.laporan_sosialisasi ?? {};
                return [
                    { label: "Tipe Sosialisasi", value: data.type },
                    { label: "Sasaran", value: data.sasaran },
                    { label: "Lokasi", value: data.lokasi },
                    { label: "Jumlah Peserta", value: data.total_participant },
                    { label: "Jenis Sosialisasi", value: data.type },
                    {
                        label: "Instansi Asal Narasumber",
                        value: data.organization,
                    },
                    {
                        label: "Materi yang disampaikan",
                        value: data.description,
                        isHtml: true,
                    },
                    {
                        label: "Materi",
                        value: data.file_materi
                            ? `<a href="${data.materi_url}" download="${data.file_materi.name}">${data.file_materi.name}</a>`
                            : "-",
                        isHtml: true,
                    },
                    {},
                    {},
                    {},
                ];
            }

            return [];
        },
        rapatFields() {
            if (this.data) {
                const data = this.data.laporan_rapat ?? {};
                return [
                    { label: "Jumlah Peserta", value: data.total_participant },
                    { label: "Pimpinan Rapat", value: data.name },
                    {
                        label: "Kecamatan Lokasi",
                        value: data.kelurahan?.kecamatan?.name,
                    },
                    { label: "Kelurahan Lokasi", value: data.kelurahan?.name },
                    { label: "Topik Rapat", value: data.description },
                    { label: "Resume Rapat", value: data.resume, isHtml: true },
                    {},
                    {},
                    {},
                ];
            }

            return [];
        },
        piketFields() {
            if (this.data) {
                const data = this.data.laporan_piket ?? {};
                return [
                    {
                        label: "Kecamatan",
                        value: data.kelurahan?.kecamatan?.name,
                    },
                    { label: "Kelurahan", value: data.kelurahan?.name },
                    { label: "Balai Puspaga RW", value: data.rw },
                    { label: "Jam Mulai Pelayanan", value: data.opening_time },
                    { label: "Jam Akhir Pelayanan", value: data.closing_time },
                    { label: "Keterangan", value: data.description },
                    {},
                    {},
                    {},
                ];
            }

            return [];
        },
        kieFields() {
            if (this.data) {
                const data = this.data.laporan_kegiatan_publikasi_k_i_e ?? {};
                return [
                    { label: "Jenis Kegiatan", value: data.jenis_kegiatan },
                    {
                        label: "Deskripsi Kegiatan",
                        value: data.deskripsi_kegiatan,
                    },
                    { label: "Jenis Konten", value: data.jenis_konten },
                    { label: "Tema Konten", value: data.tema_konten },
                    { label: "Judul Konten", value: data.judul_konten },
                    { label: "Deskripsi Konten", value: data.deskripsi_konten },
                    {
                        label: "Link Konten",
                        value: data.link_konten
                            ? `<a href="${data.link_konten}" target="_blank">${data.link_konten}</a>`
                            : "-",
                        isHtml: true,
                    },
                    {},
                    {},
                    {},
                ];
            }

            return [];
        },
        laporanKegiatanFileType() {
            return this.$store.state.enums.laporanKegiatanFileType;
        },
        fotoKlien() {
            if (
                this.data &&
                this.data.laporan_konseling &&
                this.data.laporan_konseling
            ) {
                return this.data.laporan_konseling.foto_url;
            }
            return null;
        },
        fotoKegiatan() {
            if (
                this.data &&
                this.data.laporan_sosialisasi &&
                this.data.laporan_sosialisasi
            ) {
                return this.data.laporan_sosialisasi.foto_url;
            }
            return null;
        },
        fotoRapat() {
            if (
                this.data &&
                this.data.laporan_rapat &&
                this.data.laporan_rapat
            ) {
                return this.data.laporan_rapat.foto_url;
            }
            return null;
        },
        fotoPiket() {
            if (
                this.data &&
                this.data.laporan_piket &&
                this.data.laporan_piket
            ) {
                return this.data.laporan_piket.foto_url;
            }
            return null;
        },
        fotoKonten() {
            if (
                this.data &&
                this.data.laporan_kegiatan_publikasi_k_i_e &&
                this.data.laporan_kegiatan_publikasi_k_i_e
            ) {
                return this.data.laporan_kegiatan_publikasi_k_i_e.foto_url;
            }
            return null;
        },

        tanggal() {
            return this.data?.date
                ? this.$moment(this.data.date)
                      .locale("id")
                      .format("DD MMMM YYYY")
                : "-";
        },
    },
};
</script>

<style>
.row-text-laporan p {
    margin-bottom: 0 !important;
    word-break: break-all;
}
</style>
