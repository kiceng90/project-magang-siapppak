<template>
    <dashboard-modal
        title="Pernyataan Persetujuan Pendaftaran"
        id="modal-pernyataan"
        dialog-class="modal-lg"
        style="max-width: 800px !important"
    >
        <table
            role="presentation"
            width="100%"
            style="border: 1px solid #b7b7b7"
        >
            <!-- Table Head -->
            <thead>
                <tr>
                    <th colspan="12" style="text-align: center; padding: 20px">
                        <h1>SURAT PERNYATAAN PERSETUJUAN PENDAFTARAN</h1>
                    </th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody>
                <tr>
                    <td></td>
                    <td colspan="2" class="fw-bolder">Nama Lengkap</td>
                    <td>:</td>
                    <td colspan="5">{{ this.data.name }}</td>
                    <td colspan="2" rowspan="9">
                        <img
                            :src="this.data.foto"
                            style="
                                border: 1px solid #b7b7b7;
                                box-sizing: border-box;
                                object-fit: cover;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                width: 150px;
                                aspect-ratio: 4/5;
                            "
                        />
                    </td>
                    <td></td>
                </tr>
                <tr v-for="field in fields" style="vertical-align: top">
                    <td></td>
                    <td colspan="2" class="fw-bolder">{{ field.label }}</td>
                    <td>:</td>
                    <td colspan="5">{{ field.value }}</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="p-3"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="11" class="fw-bolder">
                        Dengan ini menyatakan sesungguhnya bahwa :
                    </td>
                    <td></td>
                </tr>
                <tr v-for="(text, index) in pernyataan">
                    <td></td>
                    <td style="vertical-align: top">{{ index + 1 }}</td>
                    <td colspan="10">{{ text }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td class="p-2"></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="11" class="fw-bolder">
                        Demikian surat pernyataan ini saya buat dengan
                        sebenarnya, tanpa ada paksaan dari pihak manapun. Dan
                        saya bertanggungjawab terhadap pernyataan tersebut
                    </td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="p-2"></td>
                </tr>

                <tr>
                    <td colspan="7"></td>
                    <td colspan="5" style="text-align: center">
                        {{ data.city }}, {{ date }}
                    </td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td colspan="5" style="text-align: center">
                        Yang Membuat Pernyataan
                    </td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td colspan="5" rowspan="3" style="text-align: center">
                        <img
                            :src="this.data.tandaTangan"
                            style="height: 150px"
                        />
                    </td>
                </tr>
                <tr>
                    <td style="height: 2rem"></td>
                </tr>
                <tr>
                    <td style="height: 2rem"></td>
                </tr>
                <tr>
                    <td style="height: 2rem"></td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td colspan="5" style="text-align: center">
                        {{ this.data.name }}
                    </td>
                </tr>
                <tr>
                    <td style="height: 2rem"></td>
                </tr>
            </tbody>
        </table>
        <template #footer>
            <button
                type="button"
                class="btn btn-sm btn-light"
                data-bs-dismiss="modal"
            >
                Batal
            </button>
            <button
                class="btn btn-sm bg-second-primary-custom text-white"
                type="button"
                @click="onSubmit"
            >
                Simpan
            </button>
        </template>
    </dashboard-modal>
</template>

<script>
import moment from "moment";

export default {
    props: ["data"],
    data() {
        return {
            pernyataan: [
                "Saya bersedia mematuhi segala peraturan perundang-undangan yang berlaku di Negara Republik Indonesia",
                "Saya bersedia mengetahui, memahami dan sanggup mentaati segala peraturan yang berlaku di Pemerintah Kota Surabaya khususnya pada Dinas Pemberdayaan Perempuan Dan Perlindungan Anak Serta Pengendalian Penduduk Dan Keluarga Berencana Surabaya (DP3APPKB)",
                "Saya bersedia menjaga kondisi ketentraman di lingkungan Kota Surabaya dan tidak akan melakukan pelanggaran yang melanggar hukum pidana / perdata",
                "Saya tidak akan/sedang terlibat baik langsung maupun tidak langsung dalam tindakan asusila, prostitusi, dan penyalahgunaan narkotika, psikotropika dan zat adiktif lainnya (NAPZA). Saya sanggup sewaktu-waktu diuji di laboratorium, jika di kemudian hari saya diduga dan terbukti telah menyalahgunakan narkoba dan melakukan tindakan asusila serta prostitusi saya bersedia untuk diberhentikan dan di proses sesuai peraturan yang berlaku",
                "Apabila saya melanggar peraturan yang ditetapkan oleh Dinas Pemberdayaan Perempuan Dan Perlindungan Anak Serta Pengendalian Penduduk Dan Keluarga Berencana Kota Surabaya (DP3APPKB), maka saya bersedia dan sanggup untuk menerima sanksi sesuai dengan peraturan Pemerintah Kota Surabaya",
                "Saya bersedia untuk mengikuti seluruh tahapan proses pendaftaran pada Dinas Pemberdayaan Perempuan Dan Perlindungan Anak Serta Pengendalian Penduduk Dan Keluarga Berencana Kota Surabaya (DP3APPKB)",
                "Data yang saya berikan adalah data sebenar benarnya sesuai dengan kondisi saat ini",
            ],
            date: moment().format("DD/MM/YYYY"),
        };
    },
    methods: {
        onSubmit() {
            this.$emit("onSubmit");
        },
    },
    computed: {
        fields() {
            return [
                { label: "Email", value: this.data.email },
                { label: "NIK", value: this.data.nik },
                { label: "Status Mahasiswa", value: this.data.statusMahasiswa },
                { label: "Jenis Mahasiswa", value: this.data.jenisMahasiswa },
                { label: "Jurusan", value: this.data.jurusan },
                { label: "Semester", value: this.data.semester },
                { label: "IPK Terakhir", value: this.data.ipk },
                { label: "Asal Universitas", value: this.data.asalUniversitas },
                { label: "Alamat KK", value: this.data.address },
                { label: "RT", value: this.data.rt },
                { label: "RW", value: this.data.rw },
                { label: "Kelurahan KK", value: this.data.kelurahan },
                { label: "Kecamatan KK", value: this.data.kecamatan },
                { label: "Kota / Kabupaten", value: this.data.city },
            ];
        },
    },
};
</script>
