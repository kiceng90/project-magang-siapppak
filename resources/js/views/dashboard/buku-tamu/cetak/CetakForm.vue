<template>
    <div class="wrapper-print">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <button
                type="button"
                style="
                    font-size: 15px;
                    border-radius: 50px;
                    background: #fff;
                    color: black;
                    padding: 10px 25px;
                    border: 0 !important;
                "
                @click="$router.back()"
            >
                <i class="fa fa-arrow-left" style="color: black"></i
                >&ensp;&ensp;Kembali
            </button>
            <div class="text-center" style="font-weight: 600; font-size: 24px">
                Laporan Buku Tamu
            </div>
            <div>
                <button
                    type="button"
                    style="
                        font-size: 15px;
                        border-radius: 50px;
                        background: #ee7b33;
                        color: #fff;
                        padding: 10px 25px;
                        border: 0 !important;
                    "
                    @click="generateReport"
                >
                    <i class="fa fa-file" style="color: #fff"></i
                    >&ensp;&ensp;Unduh PDF
                </button>
            </div>
        </div>

        <div class="box-print">
            <div class="d-flex justify-content-center w-100"></div>
            <div class="box-container-print">
                <div
                    style="
                        border-bottom: 4px black solid;
                        padding-bottom: 25px;
                        margin-bottom: 20px;
                    "
                >
                    <div class="d-flex justify-content-center">
                        <div>
                            <img
                                :src="
                                    $assetUrl() +
                                    'extends/img/pemkot-surabaya-hitam-putih.jpg'
                                "
                                style="width: 80px"
                            />
                        </div>
                        <div class="text-center" style="padding-left: 25px">
                            <div style="font-size: 18px; font-weight: 700">
                                PEMERINTAH KOTA SURABAYA
                            </div>
                            <div style="font-size: 18px; font-weight: 700">
                                DINAS PEMBERDAYAAN PEREMPUAN DAN<br />PERLINDUNGAN
                                ANAK SERTA PENGENDALIAN<br />PENDUDUK DAN
                                KELUARGA BERENCANA
                            </div>
                            <div>Jalan Kedungsari No. 18 Surabaya</div>
                            <div>Telp. (031) 5346317 Fax. (031) 5480904</div>
                        </div>
                    </div>
                </div>
                <table class="table-print table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="6">
                                NOMOR PENDAFTARAN :
                                {{ layananBukuTamu.nomor_pendaftaran }}
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="4">PENERIMAAN</td>
                            <td>HARI</td>
                            <td>
                                {{ getHari(layananBukuTamu.tgl_penerimaan) }}
                            </td>
                            <td>TANGGAL</td>
                            <td>
                                {{ getTanggal(layananBukuTamu.tgl_penerimaan) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table
                    class="table-print table-bordered"
                    style="margin-top: 25px"
                >
                    <tbody>
                        <tr v-if="layananBukuTamu.rujukan_id !== null">
                            <td colspan="3" style="text-align: center">
                                <b>SURAT RUJUKAN PUSPAGA</b>
                                <p style="margin: 5px 0; font-weight: bold">
                                    KEPADA LEMBAGA/INSTANSI LAYANAN (mengambil
                                    dari Tujuan Lembaga Rujukan)
                                </p>
                                <div
                                    style="
                                        margin-top: 10px;
                                        text-align: justify;
                                    "
                                >
                                    <p>
                                        PUSPAGA adalah singkatan dari Pusat
                                        Pembelajaran Keluarga, sebuah lembaga
                                        yang menyediakan beragam layanan untuk
                                        meningkatkan kualitas keluarga dalam
                                        mewujudkan kesetaraan gender dan hak
                                        anak. Layanan ini diberikan dalam
                                        prinsip satu pintu secara holistik dan
                                        integratif. PUSPAGA kami berdiri di
                                        tingkat Kota Surabaya sejak tahun 2017.
                                    </p>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3"><b>DATA PENGUNJUNG</b></td>
                        </tr>
                        <tr>
                            <td width="30%">Nama Lengkap</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.nama }}</td>
                        </tr>
                        <tr>
                            <td width="30%">NIK</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.nik }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Tempat/Tanggal Lahir</td>
                            <td width="4%" class="text-center">:</td>
                            <td>
                                {{ layananBukuTamu.tempat_lahir }},
                                {{ getTanggal(layananBukuTamu.tanggal_lahir) }}
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Agama</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.agama }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Kewarganegaraan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.kewarganegaraan }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Status Perkawinan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.status_perkawinan }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Alamat</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.alamat_ktp }}</td>
                        </tr>
                        <tr>
                            <td width="30%">RT/RW</td>
                            <td width="4%" class="text-center">:</td>
                            <td>
                                {{ layananBukuTamu.rt_ktp }}/{{
                                    layananBukuTamu.rw_ktp
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Kelurahan/Desa</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.kel_desa_ktp }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Kecamatan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.kecamatan_ktp }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Kabupaten/Kota</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.kota_kabupaten_ktp }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Provinsi</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.provinsi }}</td>
                        </tr>
                        <tr v-if="layananBukuTamu.rujukan_id !== null">
                            <td colspan="3" style="text-align: center">
                                <div
                                    style="
                                        margin-top: 10px;
                                        text-align: center;
                                    "
                                >
                                    <p>
                                        Demikian surat kami sampaikan. Atas
                                        bantuan dan kerjasamanya, kami ucapkan
                                        terima kasih.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table
                    class="table-print table-bordered"
                    style="margin-top: 25px"
                >
                    <tbody>
                        <tr>
                            <td colspan="3">
                                <b>KEBUTUHAN LAYANAN</b>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Jenis Layanan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.name }}</td>
                        </tr>
                        <tr v-if="layananBukuTamu.singkat_id !== null">
                            <td width="30%">Keterangan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.singkat_keterangan }}</td>
                        </tr>
                        <tr v-if="layananBukuTamu.rujukan_id !== null">
                            <td width="30%">Tujuan Rujukan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.rujukan_tujuan }}</td>
                        </tr>
                        <tr v-if="layananBukuTamu.telekonsultasi_id !== null">
                            <td width="30%">Nomor Telepon</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.telekonsultasi_nomor }}</td>
                        </tr>
                        <tr v-if="layananBukuTamu.telekonsultasi_id !== null">
                            <td width="30%">Jadwal</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ layananBukuTamu.telekonsultasi_jadwal }}</td>
                        </tr>
                        <tr v-if="layananBukuTamu.telekonsultasi_id !== null">
                            <td width="30%">Keluhan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>
                                {{ layananBukuTamu.telekonsultasi_keluhan }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div
                    style="
                        display: flex;
                        justify-content: flex-end;
                        margin-top: 30px;
                    "
                >
                    <div
                        style="
                            width: 300px;
                            margin-right: 50px;
                            text-align: center;
                            font-size: 15px;
                        "
                    >
                        <div>
                            Surabaya,
                            {{ $moment().locale("id").format("DD MMMM YYYY") }}
                        </div>
                        <div>PIMPINAN PUSPAGA,</div>
                        <div
                            style="
                                text-decoration: underline;
                                padding-top: 80px;
                            "
                        >
                            Thussy Apriliyandari, S.E, MPSDM
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Api from "@/services/api";
export default {
    data() {
        return {
            pageStatus: "page-load",
            layananBukuTamu: {
                name: "",
                singkat_keterangan: "",
            },
        };
    },
    mounted() {
        this.fetchLayananBukuTamu();
    },
    methods: {
        async fetchLayananBukuTamu() {
            try {
                const response = await Api().get(
                    `/buku-tamu/${this.$route.params.id}/Kebutuhan-layanan`
                );
                this.layananBukuTamu = response.data;
            } catch (error) {
                console.error("Gagal mengambil layanan buku tamu:", error);
                throw error;
            }
        },
        async generateReport() {
            this.isGeneratingPdf = true;
            this.$ewpLoadingShow();
            try {
                const response = await Api().get(
                    `/buku-tamu/${this.$route.params.id}/form-pdf`,
                    { responseType: "blob" }
                );

                const fileURL = window.URL.createObjectURL(
                    new Blob([response.data])
                );
                const fileLink = document.createElement("a");
                fileLink.href = fileURL;

                fileLink.setAttribute(
                    "download",
                    `layanan_${this.$route.params.id}.pdf`
                );

                document.body.appendChild(fileLink);
                fileLink.click();
                document.body.removeChild(fileLink);
            } catch (error) {
                console.error("Gagal menghasilkan PDF:", error);

                this.$notify({
                    title: "Error",
                    message: "Gagal menghasilkan PDF. Silakan coba lagi nanti.",
                    type: "error",
                });
            } finally {
                this.isGeneratingPdf = false;
                this.$ewpLoadingHide();
            }
        },
        getHari(tanggal) {
            if (!tanggal) return "";
            const options = { weekday: "long" };
            return new Date(tanggal).toLocaleDateString("id-ID", options);
        },
        getTanggal(tanggal) {
            if (!tanggal) return "";
            const options = { day: "2-digit", month: "long", year: "numeric" };
            return new Date(tanggal).toLocaleDateString("id-ID", options);
        },
    },
};
</script>

<style scoped>
.wrapper-print {
    max-width: 1000px;
    width: 100%;
    display: block;
    margin: 50px auto;
    font-family: Arial !important;
}

.text-center {
    text-align: center;
}

.box-print {
    background-color: #fff !important;
    padding: 60px 30px;
}

.box-container-print {
    max-width: 800px;
    width: 100%;
    display: block;
    margin: auto;
}

.table-print {
    width: 100%;
}

.table-print tr td {
    padding: 7.5px;
    font-size: 15px;
    page-break-inside: avoid;
}

.table-print tr {
    page-break-inside: avoid;
    page-break-after: auto;
}
</style>
