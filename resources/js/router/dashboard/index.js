import { createRouter, createWebHistory } from "vue-router";

import mainStore from "@/store/index.js";

import Api from "@/services/api";

import Login from "@/views/Login.vue";
import Maintenance from "@/views/Maintenance.vue";
import RegisterKonseling from "@/views/register-konseling/Index.vue";
import RegisterMahasiswa from "@/views/register-mahasiswa/Index.vue";
import BukuTamuOCR from "@/views/buku-tamu/OCR/Index.vue";
import UploadOCR from "@/views/buku-tamu/OCR/Upload.vue";
import BukuTamu from "@/views/buku-tamu/Index.vue";
import Pilihan from "@/views/buku-tamu/Pilih.vue";

import Dashboard from "@/views/dashboard/dashboard/Index.vue";

import DashboardDaftarOpdBelumTuntas from "@/views/dashboard/daftar-opd-belum-tuntas/Index.vue";

import CekPengaduan from "@/views/dashboard/cek-pengaduan/Index.vue";

import MasterKebutuhanLayanan from "@/views/dashboard/master/kebutuhan-layanan/Index.vue";
import MasterSumberKeluhan from "@/views/dashboard/master/sumber-keluhan/Index.vue";
import MasterLokasiKejadian from "@/views/dashboard/master/lokasi-kejadian/Index.vue";
import MasterHubunganDenganKlien from "@/views/dashboard/master/hubungan-dengan-klien/Index.vue";
import MasterTipePermasalahan from "@/views/dashboard/master/tipe-permasalahan/Index.vue";
import MasterStatusPernikahan from "@/views/dashboard/master/status-pernikahan/Index.vue";
import MasterAgama from "@/views/dashboard/master/agama/Index.vue";
import MasterPekerjaan from "@/views/dashboard/master/pekerjaan/Index.vue";
import MasterPendidikanTerakhir from "@/views/dashboard/master/pendidikan-terakhir/Index.vue";
import MasterJurusanSekolah from "@/views/dashboard/master/jurusan-sekolah/Index.vue";
import MasterKota from "@/views/dashboard/master/kota/Index.vue";
import MasterWilayah from "@/views/dashboard/master/wilayah/Index.vue";
import MasterIntervensi from "@/views/dashboard/master/intervensi/Index.vue";
import MasterKecamatan from "@/views/dashboard/master/kecamatan/Index.vue";
import MasterKelurahan from "@/views/dashboard/master/kelurahan/Index.vue";
import MasterKonselor from "@/views/dashboard/master/konselor/Index.vue";
import MasterOPD from "@/views/dashboard/master/opd/Index.vue";
import MasterUser from "@/views/dashboard/master/user/Index.vue";

import MasterInstansiPendidikan from "@/views/dashboard/master/instansi-pendidikan/Index.vue";
import MasterJabatanDalamInstansi from "@/views/dashboard/master/jabatan-dalam-instansi/Index.vue";
import MasterJabatanDalamSK from "@/views/dashboard/master/jabatan-dalam-sk/Index.vue";

import MasterKategoriKonseling from "@/views/dashboard/master/kategori-konseling/Index.vue";
import MasterJadwalKonseling from "@/views/dashboard/master/jadwal-konseling/Index.vue";
import MasterKategoriMitra from "@/views/dashboard/master/kategori-mitra/Index.vue";
import MasterMitra from "@/views/dashboard/master/mitra/Index.vue";
import MasterBalaiPuspagaRW from "@/views/dashboard/master/balai-puspaga-rw/Index.vue";
import MasterJenisMahasiswa from "@/views/dashboard/master/jenis-mahasiswa/Index.vue";
import MasterKategoriMonev from "@/views/dashboard/master/laporan-monev/kategori/Index.vue";
import MasterSubKategoriMonev from "@/views/dashboard/master/laporan-monev/subkategori/Index.vue";
import MasterKuisionerMonev from "@/views/dashboard/master/laporan-monev/kuisioner/Index.vue";
import MasterJasaPelayanan from "@/views/dashboard/master/jasa-pelayanan/Index.vue";
import MasterPosisiMahasiswa from "@/views/dashboard/master/posisi-mahasiswa/Index.vue";
import MasterKategoriRumahPerubahan from "@/views/dashboard/master/rumah-perubahan/kategori/Index.vue";
import MasterMateriRumahPerubahan from "@/views/dashboard/master/rumah-perubahan/materi/Index.vue";
import MasterMateriRumahPerubahanLatihanSoal from "@/views/dashboard/master/rumah-perubahan/soal/LatihanSoal.vue";
import MasterMateriRumahPerubahanDetailLatihanSoal from "@/views/dashboard/master/rumah-perubahan/soal/DetailLatihanSoal.vue";
import DatabaseRumahPerubahan from "@/views/dashboard/master/rumah-perubahan/Database.vue";

import Pengaduan from "@/views/dashboard/pengaduan/Index.vue";
import PengaduanDetail from "@/views/dashboard/pengaduan/Detail.vue";
import PengaduanEdit from "@/views/dashboard/pengaduan/Edit.vue";
import PengaduanInputDokumenPendukung from "@/views/dashboard/pengaduan/InputDokumenPendukung.vue";
import PengaduanInputDataKeluargaKlien from "@/views/dashboard/pengaduan/InputDataKeluargaKlien.vue";

import ElearningPuspaga from "@/views/dashboard/elearning/Index.vue";
import ElearningPuspagaKategori from "@/views/dashboard/elearning/Kategori.vue";
import ElearningPuspagaSubKategori from "@/views/dashboard/elearning/SubKategori.vue";
import ElearningPuspagaRiwayatLatihanSoal from "@/views/dashboard/elearning/RiwayatLatihanSoal.vue";
import ElearningPuspagaMateriModul from "@/views/dashboard/elearning/MateriModul.vue";
import ElearningPuspagaMateriVideo from "@/views/dashboard/elearning/MateriVideo.vue";
import ElearningPuspagaLatihanSoal from "@/views/dashboard/elearning/LatihanSoal.vue";
import ElearningPuspagaHasilLatihanSoal from "@/views/dashboard/elearning/HasilLatihanSoal.vue";
import ElearningDatabase from "@/views/dashboard/elearning/admin/Database.vue";
import ElearningMateri from "@/views/dashboard/elearning/admin/Materi.vue";
import ElearningKategori from "@/views/dashboard/elearning/admin/Kategori.vue";
import ElearningSubKategori from "@/views/dashboard/elearning/admin/Subkategori.vue";
import ElearningLatihanSoal from "@/views/dashboard/elearning/admin/LatihanSoal.vue";
import ElearningDetailMateri from "@/views/dashboard/elearning/admin/DetailMateri.vue";
import ElearningDetailLatihanSoal from "@/views/dashboard/elearning/admin/DetailLatihanSoal.vue";

import RumahPerubahan from "@/views/dashboard/rumah-perubahan/Index.vue";
import RumahPerubahanMateri from "@/views/dashboard/rumah-perubahan/Materi.vue";
import RumahPerubahanLatihanSoal from "@/views/dashboard/rumah-perubahan/LatihanSoal.vue";
import RumahPerubahanHasilLatihanSoal from "@/views/dashboard/rumah-perubahan/HasilLatihanSoal.vue";
import KlienPuspaga from "@/views/dashboard/buku-tamu/Klien.vue";
import LaporanDatabasePuspaga from "@/views/dashboard/laporan-buku-tamu/database-puspaga/Index.vue";
import LaporanRekapPuspaga from "@/views/dashboard/laporan-buku-tamu/rekap-puspaga/Index.vue";
import PenerimaanCetak from "@/views/dashboard/buku-tamu/cetak/CetakPenerimaan.vue";
import IdentifikasiCetak from "@/views/dashboard/buku-tamu/cetak/CetakIdentifikasi.vue";
import FormCetak from "@/views/dashboard/buku-tamu/cetak/CetakForm.vue";
import BukuTamuCetak from "@/views/dashboard/buku-tamu/PreviewCetak.vue";
import DetailBukuTamu from "@/views/dashboard/buku-tamu/Detail.vue";
import BukuTamuDashboard from "@/views/dashboard/buku-tamu/Index.vue";
import BukuTamuEdit from "@/views/dashboard/buku-tamu/Edit.vue";

import RiwayatKonseling from "@/views/dashboard/riwayat-konseling/Index.vue";
import BookingJadwalKonseling from "@/views/dashboard/booking-jadwal-konseling/Index.vue";

import PengaduanInputRencanaAnalisKebutuhanKlien from "@/views/dashboard/pengaduan/InputRencanaAnalisKebutuhanKlien.vue";
import PengaduanInputRencanaRujukanKebutuhanKlien from "@/views/dashboard/pengaduan/InputRencanaRujukanKebutuhanKlien.vue";

import PengaduanInputLangkahYangTelahDilakukan from "@/views/dashboard/pengaduan/InputLangkahYangTelahDilakukan.vue";
import PengaduanInputDataPelaku from "@/views/dashboard/pengaduan/InputDataPelaku.vue";

import PengaduanCetak from "@/views/dashboard/pengaduan/PreviewCetak.vue";

import PengaduanInputDataKlien from "@/views/dashboard/pengaduan/InputDataKlien.vue";

import KlienKel from "@/views/dashboard/klienkel/Index.vue";
import Klien from "@/views/dashboard/klien/Index.vue";
import KlienHistoryKasus from "@/views/dashboard/klien/HistoryKasus.vue";

import LaporanKasusKlien from "@/views/dashboard/laporan/kasus-klien/Index.vue";
import LaporanKasusKlienPreview from "@/views/dashboard/laporan/kasus-klien/Preview.vue";

import LaporanRekap from "@/views/dashboard/laporan/rekap/Index.vue";
import LaporanRekapPreview from "@/views/dashboard/laporan/rekap/Preview.vue";

import LaporanRekapElearning from "@/views/dashboard/laporan-elearning/rekap-elearning/Index.vue";

import LaporanDatabaseElearning from "@/views/dashboard/laporan-elearning/database-elearning/Index.vue";

import Puspaga from "@/views/dashboard/puspaga/Index.vue";
import SatgasPPA from "@/views/dashboard/satgas-ppa/Index.vue";
import PKBM from "@/views/dashboard/pkbm/Index.vue";
import PsikologVolunter from "@/views/dashboard/psikolog-volunter/Index.vue";
import Konselor from "@/views/dashboard/konselor/Index.vue";
import Mahasiswa from "@/views/dashboard/mahasiswa/Index.vue";

import Kie from "@/views/dashboard/kie/Index.vue";
import Artikel from "@/views/dashboard/artikel/Index.vue";
import KegiatanMahasiswa from "@/views/dashboard/kegiatan-mahasiswa/Index.vue";
import KegiatanFasilitator from "@/views/dashboard/kegiatan-fasilitator/Index.vue";
import KegiatanMonev from "@/views/dashboard/laporan-monev/Index.vue";
import KegiatanMonevAdd from "@/views/dashboard/laporan-monev/Add.vue";
import KegiatanMonevEdit from "@/views/dashboard/laporan-monev/Edit.vue";
import KegiatanMonevShow from "@/views/dashboard/laporan-monev/Show.vue";

import Notifikasi from "@/views/dashboard/notifikasi/Index.vue";

import NotFound from "@/views/errors/404.vue";
import ForbiddenAccess from "@/views/errors/403.vue";

const routesWithPrefix = (prefix, routes) => {
    return routes.map((route) => {
        route.path = `${prefix}${route.path}`;

        return route;
    });
};

var routes = [
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            guest: true,
        },
    },
    // {
    //     path: "/login",
    //     name: "login",
    //     component: Maintenance,
    //     meta: {
    //         guest: true,
    //     },
    // },
    {
        path: "/maintenis",
        name: "maintenance",
        component: Maintenance,
        meta: {
            guest: true,
        },
    },
    {
        path: "/registrasi-konseling",
        name: "registrasi-konseling",
        component: RegisterKonseling,
        meta: {
            guest: true,
        },
    },
    {
        path: "/registrasi-mahasiswa",
        name: "registrasi-mahasiswa",
        component: RegisterMahasiswa,
        meta: {
            guest: true,
        },
    },
    {
        path: "/pilihan",
        name: "pilihan",
        component: Pilihan,
        meta: {
            guest: true,
        },
    },
    {
        path: "/buku-tamu",
        name: "buku-tamu",
        component: BukuTamu,
        meta: {
            guest: true,
        },
    },
    {
        path: "/upload-OCR",
        name: "upload-OCR",
        component: UploadOCR,
        meta: {
            guest: true,
        },
    },
    {
        path: "/buku-tamu-OCR/:id",
        name: "buku-tamu-OCR",
        component: BukuTamuOCR,
        meta: {
            guest: true,
        },
    },    

    ...routesWithPrefix("/dashboard", [
        {
            path: "",
            name: "dashboard",
            component: Dashboard,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_KABID_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PSIKOLOG_ID,
                    process.env.MIX_ROLE_ASISTEN_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                    process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                ],
            },
        },
        {
            path: "/notifikasi",
            name: "notifikasi",
            component: Notifikasi,
            meta: {
                auth: true,
            },
        },
        {
            path: "/cek-pengaduan",
            name: "cek-pengaduan",
            component: CekPengaduan,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_HOTLINE_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_KABID_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                ],
            },
        },
        ...routesWithPrefix("/database", [
            {
                path: "/puspaga",
                name: "d-puspaga",
                component: Puspaga,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_KECAMATAN_ID,
                        process.env.MIX_ROLE_ADMIN_ID,
                    ],
                },
            },
            {
                path: "/satgas-ppa",
                name: "d-satgas-ppa",
                component: SatgasPPA,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_KELURAHAN_ID,
                        process.env.MIX_ROLE_ADMIN_ID,
                    ],
                },
            },
            {
                path: "/pkbm",
                name: "d-pkbm",
                component: PKBM,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_KECAMATAN_ID,
                        process.env.MIX_ROLE_ADMIN_ID,
                    ],
                },
            },
            {
                path: "/psikolog-volunter",
                name: "d-psikolog-volunter",
                component: PsikologVolunter,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/konselor",
                name: "d-konselor",
                component: Konselor,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/mahasiswa",
                name: "d-mahasiswa",
                component: Mahasiswa,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KABID_ID,
                        process.env.MIX_ROLE_SUBKORD_ID,
                        process.env.MIX_ROLE_HOTLINE_ID,
                    ],
                },
            },
        ]),
        ...routesWithPrefix("/master", [
            {
                path: "/instansi-pendidikan",
                name: "m-instansi-pendidikan",
                component: MasterInstansiPendidikan,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/jabatan-dalam-instansi",
                name: "m-jabatan-dalam-instansi",
                component: MasterJabatanDalamInstansi,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/jabatan-dalam-sk",
                name: "m-jabatan-dalam-sk",
                component: MasterJabatanDalamSK,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/jenis-mahasiswa",
                name: "m-jenis-mahasiswa",
                component: MasterJenisMahasiswa,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/kategori-konseling",
                name: "m-kategori-konseling",
                component: MasterKategoriKonseling,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/jadwal-konseling",
                name: "m-jadwal-konseling",
                component: MasterJadwalKonseling,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/kategori-mitra",
                name: "m-kategori-mitra",
                component: MasterKategoriMitra,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/mitra",
                name: "m-mitra",
                component: MasterMitra,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/balai-puspaga-rw",
                name: "m-balai-puspaga-rw",
                component: MasterBalaiPuspagaRW,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/sumber-keluhan",
                name: "m-sumber-keluhan",
                component: MasterSumberKeluhan,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/tipe-permasalahan",
                name: "m-tipe-permasalahan",
                component: MasterTipePermasalahan,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/kebutuhan-layanan",
                name: "m-kebutuhan-layanan",
                component: MasterKebutuhanLayanan,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/lokasi-kejadian",
                name: "m-lokasi-kejadian",
                component: MasterLokasiKejadian,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/hubungan-dengan-klien",
                name: "m-hubungan-dengan-klien",
                component: MasterHubunganDenganKlien,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/status-pernikahan",
                name: "m-status-pernikahan",
                component: MasterStatusPernikahan,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/agama",
                name: "m-agama",
                component: MasterAgama,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/pekerjaan",
                name: "m-pekerjaan",
                component: MasterPekerjaan,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/pendidikan-terakhir",
                name: "m-pendidikan-terakhir",
                component: MasterPendidikanTerakhir,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/jurusan-sekolah",
                name: "m-jurusan-sekolah",
                component: MasterJurusanSekolah,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/kota",
                name: "m-kota",
                component: MasterKota,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/wilayah",
                name: "m-wilayah",
                component: MasterWilayah,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/intervensi",
                name: "m-intervensi",
                component: MasterIntervensi,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/kecamatan",
                name: "m-kecamatan",
                component: MasterKecamatan,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/kelurahan",
                name: "m-kelurahan",
                component: MasterKelurahan,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/konselor",
                name: "m-konselor",
                component: MasterKonselor,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/opd",
                name: "m-opd",
                component: MasterOPD,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/user",
                name: "m-user",
                component: MasterUser,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/kategori-monev",
                name: "m-kategori-monev",
                component: MasterKategoriMonev,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/sub-kategori-monev",
                name: "m-sub-kategori-monev",
                component: MasterSubKategoriMonev,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/kuisioner-monev",
                name: "m-kuisioner-monev",
                component: MasterKuisionerMonev,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/jasa-pelayanan",
                name: "m-jasa-pelayanan",
                component: MasterJasaPelayanan,
                meta: {
                    auth: true,
                    specificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/posisi-mahasiswa",
                name: "m-posisi-mahasiswa",
                component: MasterPosisiMahasiswa,
                meta: {
                    auth: true,
                    spesificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            
            {
                path: "/kategori-rumah-perubahan",
                name: "m-rumah-perubahan-kategori",
                component: MasterKategoriRumahPerubahan,
                meta: {
                    auth: true,
                    spesificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/materi-rumah-perubahan",
                name: "m-rumah-perubahan-materi",
                component: MasterMateriRumahPerubahan,
                meta: {
                    auth: true,
                    spesificRole: [process.env.MIX_ROLE_ADMIN_ID],
                },
            },
            {
                path: "/rumahperubahan-latihansoal/:id",
                name: "m-rumahperubahan-latihansoal",
                component: MasterMateriRumahPerubahanLatihanSoal,
                props: true,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                    ],
                },
            },
            {
                path: "/rumahperubahan-latihansoal-detail/:id",
                name: "m-rumahperubahan-detaillatihansoal",
                component: MasterMateriRumahPerubahanDetailLatihanSoal,
                props: true,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                    ],
                },
            },
            {
                path: "/database-rumahperubahan",
                name: "laporan-database-rumahperubahan",
                component: DatabaseRumahPerubahan,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KABID_ID,
                        process.env.MIX_ROLE_KADIS_ID,
                    ],
                },
            },    

        ]),
        {
            path: "/pengaduan",
            name: "pengaduan",
            component: Pengaduan,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KABID_ID,
                    process.env.MIX_ROLE_KADIS_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_OPD_ID,
                    process.env.MIX_ROLE_HOTLINE_ID,
                ],
            },
        },
        {
            path: "/pengaduan/:id",
            name: "pengaduan-detail",
            component: PengaduanDetail,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KABID_ID,
                    process.env.MIX_ROLE_KADIS_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_OPD_ID,
                    process.env.MIX_ROLE_HOTLINE_ID,
                ],
            },
        },
        {
            path: "/pengaduan/edit/:id",
            name: "pengaduan-edit",
            component: PengaduanEdit,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KABID_ID,
                    process.env.MIX_ROLE_KADIS_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_HOTLINE_ID,
                ],
            },
        },
        {
            path: "/pengaduan/:id/penjangkauan/:idPenjangkauan/input-data-keluarga-klien",
            name: "pengaduan-input-data-keluarga-klien",
            component: PengaduanInputDataKeluargaKlien,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_KABID_ID,
                ],
            },
        },
        {
            path: "/pengaduan/:id/penjangkauan/:idPenjangkauan/input-dokumen-pendukung",
            name: "pengaduan-input-dokumen-pendukung",
            component: PengaduanInputDokumenPendukung,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_KABID_ID,
                ],
            },
        },
        {
            path: "/pengaduan/:id/penjangkauan/:idPenjangkauan/input-rencana-rujukan-kebutuhan-klien",
            name: "pengaduan-input-rencana-rujukan-kebutuhan-klien",
            component: PengaduanInputRencanaRujukanKebutuhanKlien,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_KABID_ID,
                ],
            },
        },
        {
            path: "/pengaduan/:id/penjangkauan/:idPenjangkauan/input-rencana-analis-kebutuhan-klien",
            name: "pengaduan-input-rencana-analis-kebutuhan-klien",
            component: PengaduanInputRencanaAnalisKebutuhanKlien,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_KABID_ID,
                ],
            },
        },
        {
            path: "/pengaduan/:id/penjangkauan/:idPenjangkauan/input-langkah-yang-telah-dilakukan",
            name: "pengaduan-input-langkah-yang-telah-dilakukan",
            component: PengaduanInputLangkahYangTelahDilakukan,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_KABID_ID,
                ],
            },
        },
        {
            path: "/pengaduan/:id/penjangkauan/:idPenjangkauan/input-data-pelaku",
            name: "pengaduan-input-data-pelaku",
            component: PengaduanInputDataPelaku,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_KABID_ID,
                ],
            },
        },
        {
            path: "/pengaduan/:id/penjangkauan/:idPenjangkauan/input-data-klien",
            name: "pengaduan-input-data-klien",
            component: PengaduanInputDataKlien,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_KABID_ID,
                ],
            },
        },
        {
            path: "/pengaduan/:id/cetak",
            name: "pengaduan-cetak",
            component: PengaduanCetak,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KABID_ID,
                    process.env.MIX_ROLE_KADIS_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_HOTLINE_ID,
                ],
            },
        },
        {
            path: "/riwayat-konseling",
            name: "riwayat-konseling",
            component: RiwayatKonseling,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PSIKOLOG_ID,
                    process.env.MIX_ROLE_KLIEN_ID,
                ],
            },
        },
        {
            path: "/buku-tamu/:id/cetak",
            name: "buku-tamu-cetak",
            component: BukuTamuCetak,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/buku-tamu/:id/penerimaan",
            name: "penerimaan-cetak",
            component: PenerimaanCetak,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/buku-tamu/:id/identifikasi",
            name: "identifikasi-cetak",
            component: IdentifikasiCetak,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/buku-tamu/:id/form",
            name: "form-cetak",
            component: FormCetak,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/buku-tamu/edit/:id",
            name: "buku-tamu-edit",
            component: BukuTamuEdit,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/buku-tamu-dashboard",
            name: "buku-tamu-dashboard",
            component: BukuTamuDashboard,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/detail-buku-tamu/:id",
            name: "detail-buku-tamu",
            component: DetailBukuTamu,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/elearning-puspaga",
            name: "elearning-puspaga",
            component: ElearningPuspaga,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KLIEN_ID,
                    process.env.MIX_ROLE_FASILITATOR_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },
        {
            path: "/elearning-puspaga/kategori/:id",
            name: "elearningpuspaga-kategori",
            component: ElearningPuspagaKategori,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KLIEN_ID,
                    process.env.MIX_ROLE_FASILITATOR_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },
        {
            path: "/elearning-puspaga/subkategori/:id",
            name: "elearningpuspaga-subkategori",
            component: ElearningPuspagaSubKategori,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KLIEN_ID,
                    process.env.MIX_ROLE_FASILITATOR_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },

        {
            path: "/elearning-puspaga/riwayat-latihan-soal/:id",
            name: "elearningpuspaga-riwayatlatihansoal",
            component: ElearningPuspagaRiwayatLatihanSoal,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KLIEN_ID,
                    process.env.MIX_ROLE_FASILITATOR_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },

        {
            path: "/elearning-puspaga/materi-id/video/:id",
            name: "elearningpuspaga-materi-video",
            component: ElearningPuspagaMateriVideo,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KLIEN_ID,
                    process.env.MIX_ROLE_FASILITATOR_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },

        {
            path: "/elearning-puspaga/materi-id/modul/:id",
            name: "elearningpuspaga-materi-modul",
            component: ElearningPuspagaMateriModul,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KLIEN_ID,
                    process.env.MIX_ROLE_FASILITATOR_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },

        {
            path: "/elearning-puspaga/latihan-soal/:id",
            name: "elearningpuspaga-latihansoal",
            component: ElearningPuspagaLatihanSoal,
            props: true,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KLIEN_ID,
                    process.env.MIX_ROLE_FASILITATOR_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },

        {
            path: "/elearning-puspaga/hasil-latihan-soal/:id",
            name: "elearningpuspaga-hasillatihansoal",
            component: ElearningPuspagaHasilLatihanSoal,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KLIEN_ID,
                    process.env.MIX_ROLE_FASILITATOR_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },

        // Admin Elearning
        {
            path: "/elearning-db",
            name: "elearning-db",
            component: ElearningDatabase,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PSIKOLOG_ID,
                ],
            },
        },
        {
            path: "/elearning-kategori",
            name: "elearning-kategori",
            component: ElearningKategori,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PSIKOLOG_ID,
                ],
            },
        },
        {
            path: "/elearning-subkategori",
            name: "elearning-subkategori",
            component: ElearningSubKategori,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PSIKOLOG_ID,
                ],
            },
        },
        {
            path: "/elearning-materi",
            name: "elearning-materi",
            component: ElearningMateri,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PSIKOLOG_ID,
                ],
            },
        },
        {
            path: "/elearning-materi/:id",
            name: "elearning-detail-materi",
            component: ElearningDetailMateri,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PSIKOLOG_ID,
                ],
            },
        },
        {
            path: "/elearning-latihansoal/:id",
            name: "elearning-latihansoal",
            component: ElearningLatihanSoal,
            props: true,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PSIKOLOG_ID,
                ],
            },
        },

        {
            path: "/elearning-latihansoal-detail/:id",
            name: "detaillatihansoal",
            component: ElearningDetailLatihanSoal,
            props: true,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_PSIKOLOG_ID,
                ],
            },
        },
        // End Admin Elearning

        //rumah-perubahan 
        {
            path: "/rumahperubahan",
            name: "rumah-perubahan",
            component: RumahPerubahan,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/rumahperubahan-materi/:id",
            name: "rumahperubahan-materi",
            component: RumahPerubahanMateri,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/rumah-perubahan/latihan-soal/:id",
            name: "rumahperubahan-latihansoal",
            component: RumahPerubahanLatihanSoal,
            props: true,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },

        {
            path: "/rumah-perubahan/hasil-latihan-soal/:id",
            name: "rumahperubahan-hasillatihansoal",
            component: RumahPerubahanHasilLatihanSoal,
            props: true,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        // End rumah-perubahan


        {
            path: "/booking-jadwal-konseling/:idKonsultan",
            name: "booking-jadwal-konseling",
            component: BookingJadwalKonseling,
            meta: {
                auth: true,
                specificRole: [process.env.MIX_ROLE_KLIEN_ID],
            },
        },
        {
            path: "/booking-jadwal-konseling-psikolog/:idKonsultan/:idKlien",
            name: "booking-jadwal-konseling-psikolog",
            component: BookingJadwalKonseling,
            meta: {
                auth: true,
                specificRole: [process.env.MIX_ROLE_KONSELOR_ID],
            },
        },
        {
            path: "/klien-puspaga",
            name: "klien-puspaga",
            component: KlienPuspaga,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KADIS_ID,
                ],
            },
        },
        {
            path: "/klien",
            name: "klien",
            component: Klien,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KADIS_ID,
                ],
            },
        },
        {
            path: "/klien-kel",
            name: "klien-kel",
            component: KlienKel,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_KABID_ID,
                ],
            },
        },
        {
            path: "/klien/:id/history-kasus",
            name: "klien-history-kasus",
            component: KlienHistoryKasus,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KABID_ID,
                    process.env.MIX_ROLE_KADIS_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_SUBKORD_ID,
                    process.env.MIX_ROLE_HOTLINE_ID,
                    process.env.MIX_ROLE_ASISTEN_ID,
                ],
            },
        },
        ...routesWithPrefix("/laporan", [
            {
                path: "/kasus-klien",
                name: "laporan-kasus-klien",
                component: LaporanKasusKlien,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KABID_ID,
                        process.env.MIX_ROLE_KADIS_ID,
                        process.env.MIX_ROLE_KONSELOR_ID,
                        process.env.MIX_ROLE_SUBKORD_ID,
                        process.env.MIX_ROLE_HOTLINE_ID,
                        process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                    ],
                },
            },
            {
                path: "/kasus-klien/preview",
                name: "laporan-kasus-klien-preview",
                component: LaporanKasusKlienPreview,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KABID_ID,
                        process.env.MIX_ROLE_KADIS_ID,
                        process.env.MIX_ROLE_KONSELOR_ID,
                        process.env.MIX_ROLE_SUBKORD_ID,
                        process.env.MIX_ROLE_HOTLINE_ID,
                        process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                    ],
                },
            },
            {
                path: "/rekap",
                name: "laporan-rekap",
                component: LaporanRekap,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KABID_ID,
                        process.env.MIX_ROLE_KADIS_ID,
                        process.env.MIX_ROLE_KONSELOR_ID,
                        process.env.MIX_ROLE_SUBKORD_ID,
                        process.env.MIX_ROLE_HOTLINE_ID,
                        process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                    ],
                },
            },
            {
                path: "/rekap/preview",
                name: "laporan-rekap-preview",
                component: LaporanRekapPreview,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KABID_ID,
                        process.env.MIX_ROLE_KADIS_ID,
                        process.env.MIX_ROLE_KONSELOR_ID,
                        process.env.MIX_ROLE_SUBKORD_ID,
                        process.env.MIX_ROLE_HOTLINE_ID,
                        process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                    ],
                },
            },
            {
                path: "/rekap-puspaga",
                name: "laporan-rekap-puspaga",
                component: LaporanRekapPuspaga,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KONSELOR_ID,
                    ],
                },
            },
            {
                path: "/database-puspaga",
                name: "laporan-database-puspaga",
                component: LaporanDatabasePuspaga,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KONSELOR_ID,
                    ],
                },
            },
            {
                path: "/rekap-elearning",
                name: "laporan-rekap-elearning",
                component: LaporanRekapElearning,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KABID_ID,
                        process.env.MIX_ROLE_KADIS_ID,
                        process.env.MIX_ROLE_KONSELOR_ID,
                        process.env.MIX_ROLE_SUBKORD_ID,
                        process.env.MIX_ROLE_HOTLINE_ID,
                        process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                    ],
                },
            },
            {
                path: "/database-elearning",
                name: "laporan-database-elearning",
                component: LaporanDatabaseElearning,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_KABID_ID,
                        process.env.MIX_ROLE_KADIS_ID,
                        process.env.MIX_ROLE_KONSELOR_ID,
                        process.env.MIX_ROLE_SUBKORD_ID,
                        process.env.MIX_ROLE_HOTLINE_ID,
                        process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                    ],
                },
            },
        ]),
        ...routesWithPrefix("/dashboard", [
            {
                path: "/daftar-opd-belum-tuntas",
                name: "dashboard-daftar-opd-belum-tuntas",
                component: DashboardDaftarOpdBelumTuntas,
                meta: {
                    auth: true,
                    specificRole: [
                        process.env.MIX_ROLE_ADMIN_ID,
                        process.env.MIX_ROLE_SUBKORD_ID,
                        process.env.MIX_ROLE_SUBKORD_ID,
                        process.env.MIX_ROLE_KABID_ID,
                        process.env.MIX_ROLE_KONSELOR_ID,
                        process.env.MIX_ROLE_ASISTEN_ID,
                    ],
                },
            },
        ]),
        {
            path: "/kie",
            name: "kie",
            component: Kie,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                ],
            },
        },
        {
            path: "/artikel",
            name: "artikel",
            component: Artikel,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_PENULIS_KONTEN_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },
        {
            path: "/kegiatan-mahasiswa",
            name: "kegiatan-mahasiswa",
            component: KegiatanMahasiswa,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                    process.env.MIX_ROLE_MAHASISWA_ID,
                ],
            },
        },
        {
            path: "/kegiatan-fasilitator",
            name: "kegiatan-fasilitator",
            component: KegiatanFasilitator,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_FASILITATOR_ID,
                ],
            },
        },
        {
            path: "/kegiatan-monev",
            name: "kegiatan-monev",
            component: KegiatanMonev,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/kegiatan-monev/tambah",
            name: "kegiatan-monev-tambah",
            component: KegiatanMonevAdd,
            meta: {
                auth: true,
                specificRole: [process.env.MIX_ROLE_KONSELOR_ID],
            },
        },
        {
            path: "/kegiatan-monev/:id/edit",
            name: "kegiatan-monev-edit",
            component: KegiatanMonevEdit,
            meta: {
                auth: true,
                specificRole: [process.env.MIX_ROLE_KONSELOR_ID],
            },
        },
        {
            path: "/kegiatan-monev/:id",
            name: "kegiatan-monev-show",
            component: KegiatanMonevShow,
            meta: {
                auth: true,
                specificRole: [
                    process.env.MIX_ROLE_ADMIN_ID,
                    process.env.MIX_ROLE_KONSELOR_ID,
                ],
            },
        },
        {
            path: "/404",
            component: NotFound,
        },
        {
            path: "/403",
            component: ForbiddenAccess,
            meta: {
                auth: true,
            },
        },
        {
            path: "/:pathMatch(.*)*",
            redirect: "/404",
        },
    ]),
        // {
        //     path: "/404",
        //     component: Maintenance,
        // },
        // {
        //     path: "/403",
        //     component: ForbiddenAccess,
        //     meta: {
        //         auth: true,
        //     },
        // },
        // {
        //     path: "/:pathMatch(.*)*",
        //     redirect: "/404",
        // },
];

// routes = routesWithPrefix('/new', routes);

const router = createRouter({
    history: createWebHistory(process.env.MIX_SUBPATH_DOMAIN),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return {
            top: 0,
        };
    },
});

router.beforeEach((to, from, next) => {
    mainStore.dispatch("enums/getEnums");

    if (to.matched.some((record) => record.meta.auth)) {
        if (!localStorage.getItem("dp5a-token")) {
            return next("/login");
        } else {
            if (mainStore.state.profile.isLoggedIn) {
                if (to.matched.some((record) => record.meta.specificRole)) {
                    if (
                        to.meta &&
                        to.meta.specificRole &&
                        to.meta.specificRole.length > 0
                    ) {
                        const hasAccess = to.meta.specificRole.filter(
                            (e) => e == mainStore.state.profile.role_id
                        );
                        if (hasAccess.length == 0) {
                            return next("/403");
                        }
                    }
                }
                return next();
            } else {
                return Api()
                    .get("profile")
                    .then(function (response) {
                        mainStore.commit(
                            "profile/SET_PROFILE_DATA",
                            response.data.data
                        );
                        if (
                            to.matched.some(
                                (record) => record.meta.specificRole
                            )
                        ) {
                            if (
                                to.meta &&
                                to.meta.specificRole &&
                                to.meta.specificRole.length > 0
                            ) {
                                const hasAccess = to.meta.specificRole.filter(
                                    (e) => e == response.data.data.id_role
                                );
                                if (hasAccess.length == 0) {
                                    return next("/403");
                                }
                            }
                        }
                        return next();
                    })
                    .catch(function (e) {
                        localStorage.clear();
                        mainStore.commit("profile/SET_PROFILE_DATA", null);
                        return next("/login");
                    });
            }
        }
    } else if (to.matched.some((record) => record.meta.guest)) {
        if (!localStorage.getItem("dp5a-token")) {
            return next();
        } else {
            return Api()
                .get("profile")
                .then(function (response) {
                    mainStore.commit(
                        "profile/SET_PROFILE_DATA",
                        response.data.data
                    );
                    let roleID = response.data.data.id_role;
                    if (process.env.MIX_ROLE_ADMIN_ID == roleID) {
                        return next({ name: "dashboard" });
                    } else if (process.env.MIX_ROLE_KABID_ID == roleID) {
                        return next({ name: "dashboard" });
                    } else if (process.env.MIX_ROLE_KADIS_ID == roleID) {
                        return next({ name: "pengaduan" });
                    } else if (process.env.MIX_ROLE_KONSELOR_ID == roleID) {
                        return next({ name: "dashboard" });
                    } else if (process.env.MIX_ROLE_SUBKORD_ID == roleID) {
                        return next({ name: "dashboard" });
                    } else if (process.env.MIX_ROLE_OPD_ID == roleID) {
                        return next({ name: "pengaduan" });
                    } else if (process.env.MIX_ROLE_HOTLINE_ID == roleID) {
                        return next({ name: "cek-pengaduan" });
                    } else if (process.env.MIX_ROLE_ASISTEN_ID == roleID) {
                        return next({ name: "dashboard" });
                    } else if (process.env.MIX_ROLE_KECAMATAN_ID == roleID) {
                        return next({ name: "d-puspaga" });
                    } else if (process.env.MIX_ROLE_KELURAHAN_ID == roleID) {
                        return next({ name: "d-satgas-ppa" });
                    } else if (process.env.MIX_ROLE_PSIKOLOG_ID == roleID) {
                        return next({ name: "dashboard" });
                    } else if (
                        process.env.MIX_ROLE_PENULIS_KONTEN_ID == roleID
                    ) {
                        return next({ name: "dashboard" });
                    } else if (process.env.MIX_ROLE_MAHASISWA_ID == roleID) {
                        return next({ name: "kegiatan-mahasiswa" });
                    } else if (process.env.MIX_ROLE_FASILITATOR_ID == roleID) {
                        return next({ name: "kegiatan-fasilitator" });
                    } else if (process.env.MIX_ROLE_KLIEN_ID == roleID) {
                        if (to.query.pathTo) {
                            return next({ path: to.query.pathTo });
                        }
                        return next({ name: "riwayat-konseling" });
                    } else if (process.env.MIX_ROLE_KLIEN_ID == roleID) {
                        if (to.query.pathTo) {
                            return next({ path: to.query.pathTo });
                        }
                        return next({ name: "buku-tamu-dashboard" });
                    } else if (process.env.MIX_ROLE_KLIEN_ID == roleID) {
                        if (to.query.pathTo) {
                            return next({ path: to.query.pathTo });
                        }
                        return next({ name: "elearning-materi" });
                    } else if (process.env.MIX_ROLE_KLIEN_ID == roleID) {
                        if (to.query.pathTo) {
                            return next({ path: to.query.pathTo });
                        }
                        return next({ name: "elearning-db" });
                    } else if (process.env.MIX_ROLE_KLIEN_ID == roleID) {
                        if (to.query.pathTo) {
                            return next({ path: to.query.pathTo });
                        }
                        return next({ name: "easy" });
                    } else {
                        localStorage.clear();
                        mainStore.commit("profile/SET_PROFILE_DATA", null);
                        return next();
                    }
                })
                .catch(function (e) {
                    localStorage.clear();
                    mainStore.profile.commit("profile/SET_PROFILE_DATA", null);
                    return next();
                });
        }
    } else {
        return next();
    }
});

export default router;
