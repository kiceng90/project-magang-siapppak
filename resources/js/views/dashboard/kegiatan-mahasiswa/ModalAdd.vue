<template>
    <dashboard-modal
        title="Tambah Laporan Kegiatan"
        id="modal-tambah"
        dialog-class="modal-lg"
    >
        <div class="alert alert-warning">
            <div class="d-flex align-items-center">
                <div class="me-2">
                    <i class="fa fa-fw fa-bullhorn"></i>
                </div>
                <div>
                    Laporan kegiatan yang telah disimpan tidak dapat diubah.
                    Pastikan tidak terjadi kesalahan dalam pengisian laporan
                </div>
            </div>
        </div>

        <div>
            <label class="form-label fw-bolder fs-6 mb-3"
                >Tanggal Pelaksanaan Kegiatan</label
            >
            <input
                type="date"
                class="form-control mb-5"
                v-model="tanggalPelaksanaan"
                :min="minDate()"
                :max="maxDate()"
            />
        </div>

        <h3 class="mb-5 pt-5 border-bottom">Piket Layanan</h3>
        <div class="form-check form-switch mb-5">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="has-piket"
                v-model="hasPiket"
            />
            <label class="form-check-label" for="has-piket"
                >Apakah Ada Kegiatan ?</label
            >
        </div>
        <template v-if="hasPiket">
            <label class="form-label fw-bolder fs-6 mb-3 mt-3">Kecamatan</label>
            <app-select-single
                v-model="piket.kecamatan"
                :placeholder="'Pilih Kecamatan'"
                :options="kecamatanOptions"
                :loading="pageStatus == 'kecamatan-load'"
                :serverside="true"
                @change-search="getKecamatan"
                :show_button_clear="false"
                @option-change="reset(['kelurahanPiket', 'balaiPuspaga'])"
            />
            <label class="form-label fw-bolder fs-6 mb-3 mt-5">Kelurahan</label>
            <app-select-single
                v-model="piket.kelurahan"
                :placeholder="'Pilih Kelurahan'"
                :options="kelurahanOptions"
                :loading="pageStatus == 'kelurahan-load'"
                :serverside="true"
                @change-search="getKelurahan"
                :show_button_clear="false"
                @option-change="reset(['balaiPuspaga'])"
            />
            <label class="form-label fw-bolder fs-6 mb-3 mt-5"
                >Balai Puspaga RW</label
            >
            <app-select-single
                v-model="piket.rw"
                :placeholder="'Pilih Balai Puspaga RW'"
                :options="balaiPuspagaOptions"
                :loading="pageStatus == 'balai-puspaga-load'"
                :serverside="true"
                @change-search="getBalaiPuspagaRW"
                :show_button_clear="false"
            />

            <label class="form-label fw-bolder fs-6 mb-3 mt-5"
                >Jam Mulai Pelayanan</label
            >
            <input
                class="form-control mb-5"
                type="time"
                v-model="piket.jamMulaiTugas"
            />

            <label class="form-label fw-bolder fs-6 mb-3"
                >Jam Akhir Pelayanan</label
            >
            <input
                class="form-control"
                type="time"
                :disabled="piket.jamMulaiTugas == ''"
                v-model="piket.jamAkhirTugas"
            />

            <label class="form-label fw-bolder fs-6 mb-3"
                >Uraian Aktivitas</label
            >
            <textarea
                class="form-control mb-5"
                v-model="piket.keterangan"
                placeholder="Misal: Piket di Puspaga balai RW bersama ..."
                cols="30"
                rows="10"
            ></textarea>

            <div class="row mt-5">
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Foto Geotag</label
                    >
                    <input
                        type="file"
                        class="form-control"
                        v-on:change="onChangeFotoPiket"
                        accept="image/*"
                    />
                    <small class="form-text text-muted mb-5 d-inline-block">
                        Maksimal ukuran file yang dapat diunggah adalah 2 MB.
                    </small>
                </div>
            </div>
        </template>


        <h3 class="mb-5 pt-5 border-bottom">Konseling / Konsultasi</h3>
        <div class="form-check form-switch mb-5">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="has-konseling"
                v-model="hasKonseling"
            />
            <label class="form-check-label" for="has-konseling"
                >Apakah Ada Kegiatan ?</label
            >
        </div>
        <template v-if="hasKonseling">
            <div class="row">
                <div class="col-lg-8">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Nama Klien</label
                    >
                    <input
                        type="text"
                        class="form-control mb-5"
                        v-model="konseling.nama"
                    />
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-bolder fs-6 mb-3">NIK</label>
                    <input
                        type="number"
                        maxlength="16"
                        class="form-control mb-5"
                        v-model="konseling.nik"
                    />
                </div>
            </div>
            <div class="form-group">
                <label class="form-label fw-bolder fs-6 mb-3 mt-5"
                    >Tipe Konseling</label
                >
                <select
                    class="form-control mb-5"
                    placeholder="Pilih Jenis Konten"
                    v-model="konseling.type"
                    v-on:change="onChangeType"
                >
                    <option disabled value="">-- PILIH TIPE --</option>
                    <option
                        v-for="item in optionsLaporanKegiatanKonselingType"
                        :value="item.id"
                    >
                        {{ item.text }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label fw-bolder fs-6 mb-3 mt-5"
                    >Kategori Kasus</label
                >
                <app-select-single
                    class="mb-5"
                    v-model="konseling.kategoriKasus"
                    :placeholder="'Pilih kategori kasus'"
                    :show_button_clear="false"
                    :options="kategoriKasusOptions"
                    :serverside="true"
                    :loading="pageStatus == 'kategori-kasus-load'"
                    @change-search="getKategoriKasus"
                >
                </app-select-single>
            </div>
            <label class="form-label fw-bolder fs-6 mb-3">Warga Surabaya</label>
            <div class="form-check mb-5">
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="is-warga-surabaya"
                    v-model="konseling.wargaSurabaya"
                    v-on:change="
                        reset([
                            'kotaKonseling',
                            'kecamatanKonseling',
                            'kelurahanKonseling',
                        ])
                    "
                />
                <label class="form-check-label" for="is-warga-surabaya">
                    Apakah klien merupakan warga surabaya?
                </label>
            </div>
            <template v-if="!konseling.wargaSurabaya">
                <label class="form-label fw-bolder fs-6 mb-3"
                    >Kota/Kabupaten Domisili</label
                >
                <app-select-single
                    class="mb-5"
                    v-model="konseling.kota"
                    :placeholder="'Pilih kota/kabupaten'"
                    :show_button_clear="false"
                    :options="kotaKonselingOptions"
                    :serverside="true"
                    :loading="pageStatus == 'kota-konseling-load'"
                    @change-search="getKotaKonseling"
                    @option-change="
                        reset(['kecamatanKonseling', 'kelurahanKonseling'])
                    "
                >
                </app-select-single>
            </template>
            <div class="row">
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Kecamatan Domisili</label
                    >
                    <app-select-single
                        class="mb-5"
                        v-model="konseling.kecamatan"
                        :placeholder="'Pilih kecamatan'"
                        :show_button_clear="false"
                        :options="kecamatanKonselingOptions"
                        :serverside="true"
                        :loading="pageStatus == 'kecamatan-konseling-load'"
                        @change-search="getKecamatanKonseling"
                        @option-change="reset(['kelurahanKonseling'])"
                    >
                    </app-select-single>
                </div>
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Kelurahan Domisili</label
                    >
                    <app-select-single
                        class="mb-5"
                        v-model="konseling.kelurahan"
                        :placeholder="'Pilih kelurahan'"
                        :show_button_clear="false"
                        :options="kelurahanKonselingOptions"
                        :serverside="true"
                        :loading="pageStatus == 'kelurahan-konseling-load'"
                        @change-search="getKelurahanKonseling"
                    >
                    </app-select-single>
                </div>
            </div>
            <label class="form-label fw-bolder fs-6 mb-3"
                >Alamat Domisili</label
            >
            <input
                type="text"
                class="form-control mb-5"
                v-model="konseling.alamat"
            />
            <label class="form-label fw-bolder fs-6 mb-3"
                >Uraian Singkat Permasalahan
                <div class="text-gray-400">(Maksimal 500 text)</div></label
            >

            <app-editor
                class="form-control mb-5"
                v-model:content="konseling.deskripsi"
                ref="editor"
                contentType="html"
            ></app-editor>
            <label class="form-label fw-bolder fs-6 mt-5"
                >Tindak Lanjut
                <div class="text-gray-400">(Maksimal 500 text)</div></label
            >
            <app-editor
                class="form-control mb-5"
                v-model:content="konseling.solusi"
                ref="editor"
                contentType="html"
            ></app-editor>
            <div class="row mt-5">
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Telp. Klien</label
                    >
                    <input
                        type="tel"
                        class="form-control mb-5"
                        v-model="konseling.telp"
                    />
                </div>
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Foto Klien</label
                    >
                    <input
                        type="file"
                        class="form-control mb-5"
                        v-on:change="onChangeFotoKlien"
                        accept="image/*"
                    />
                    <small class="form-text text-muted mb-5 d-inline-block">
                        Maksimal ukuran file yang dapat diunggah adalah 2 MB.
                    </small>
                </div>
            </div>
        </template>

        <h3 class="mb-5 pt-5 border-bottom">
            Sosialisasi / Parenting / Pembelajaran Keluarga / Promosi / Edukasi
        </h3>
        <div class="form-check form-switch mb-5">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="has-sosialisasi"
                v-model="hasSosialisasi"
            />
            <label class="form-check-label" for="has-sosialisasi"
                >Apakah Ada Kegiatan ?</label
            >
        </div>
        <template v-if="hasSosialisasi">
            <div class="form-group">
                <label class="form-label fw-bolder fs-6 mb-3 mt-5"
                    >Tipe Sosialisasi</label
                >
                <select
                    class="form-control mb-5"
                    placeholder="Pilih Jenis Konten"
                    v-model="sosialisasi.type"
                    v-on:change="onChangeType"
                >
                    <option disabled value="">-- PILIH TIPE --</option>
                    <option
                        v-for="item in optionsLaporanKegiatanSosialisasiType"
                        :value="item.text"
                    >
                        {{ item.text }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label fw-bolder fs-6 mb-3">Sasaran</label>
                <select
                    class="form-control mb-5"
                    placeholder="Pilih Sasaran"
                    v-model="sosialisasi.sasaran"
                    v-on:change="onChangeType"
                >
                    <option disabled value="">-- PILIH SASARAN --</option>
                    <option
                        v-for="item in optionsLaporanKegiatanSosialisasiSasaran"
                        :value="item.text"
                    >
                        {{ item.text }}
                    </option>
                </select>
            </div>
            <div v-if="sosialisasi.sasaran == 'Lainnya'">
                <label class="form-label fw-bolder fs-6 mb-3"
                    >Sasaran Lainnya</label
                >
                <textarea
                    class="form-control mb-5"
                    v-model="sosialisasi.sasaranLain"
                ></textarea>
            </div>
            <label class="form-label fw-bolder fs-6 mb-3">Lokasi</label>
            <textarea
                class="form-control mb-5"
                v-model="sosialisasi.lokasi"
            ></textarea>
            <label class="form-label fw-bolder fs-6 mb-3">Jumlah Peserta</label>
            <input
                type="number"
                class="form-control mb-5"
                v-model="sosialisasi.jumlahPeserta"
            />
            <div class="row">
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Narasumber</label
                    >
                    <input
                        type="text"
                        class="form-control mb-5"
                        v-model="sosialisasi.narasumber"
                    />
                </div>
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Instansi Asal Narasumber</label
                    >
                    <input
                        type="text"
                        class="form-control mb-5"
                        v-model="sosialisasi.instansiNarasumber"
                    />
                </div>
            </div>
            <label class="form-label fw-bolder fs-6 mb-3"
                >Materi yang disampaikan</label
            >
            <app-editor
                class="form-control"
                v-model:content="sosialisasi.materi"
                ref="editor"
                contentType="html"
            ></app-editor>
            <div class="row mt-5">
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Upload Materi</label
                    >
                    <input
                        type="file"
                        class="form-control mb-5"
                        v-on:change="onChangeFileMateri"
                    />
                </div>
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >URL Video</label
                    >
                    <input
                        type="text"
                        class="form-control mb-5"
                        v-model="sosialisasi.urlVideo"
                    />
                </div>
            </div>
            <label class="form-label fw-bolder fs-6 mb-3">Foto Kegiatan</label>
            <input
                type="file"
                class="form-control mb-5"
                v-on:change="onChangeFotoKegiatan"
                accept="image/*"
            />
            <small class="form-text text-muted mb-5 d-inline-block">
                        Maksimal ukuran file yang dapat diunggah adalah 2 MB.
            </small>
        </template>

        <h3 class="mb-5 pt-5 border-bottom">Rapat / Koordinasi</h3>
        <div class="form-check form-switch mb-5">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="has-rapat"
                v-model="hasRapat"
            />
            <label class="form-check-label" for="has-rapat"
                >Apakah Ada Kegiatan ?</label
            >
        </div>
        <template v-if="hasRapat">
            <div class="form-group">
                <label class="form-label fw-bolder fs-6 mb-3 mt-5"
                    >Tipe Kegiatan</label
                >
                <select
                    class="form-control mb-5"
                    v-model="rapat.type"
                    v-on:change="onChangeType"
                >
                    <option disabled value="">-- PILIH KEGIATAN --</option>
                    <option
                        v-for="item in optionsLaporanKegiatanRapatType"
                        :value="item.text"
                    >
                        {{ item.text }}
                    </option>
                </select>
            </div>
            <label class="form-label fw-bolder fs-6 mb-3">Pimpinan Rapat</label>
            <input
                type="text"
                class="form-control mb-5"
                v-model="rapat.pimpinan"
            />
            <div class="row">
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Kecamatan Lokasi</label
                    >
                    <app-select-single
                        class="mb-5"
                        v-model="rapat.kecamatan"
                        :placeholder="'Pilih kecamatan'"
                        :show_button_clear="false"
                        :options="kecamatanRapatOptions"
                        :serverside="true"
                        :loading="pageStatus == 'kecamatan-rapat-load'"
                        @change-search="getKecamatanRapat"
                        @option-change="reset(['kelurahanRapat'])"
                    >
                    </app-select-single>
                </div>
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Kelurahan Lokasi</label
                    >
                    <app-select-single
                        class="mb-5"
                        v-model="rapat.kelurahan"
                        :placeholder="'Pilih kelurahan'"
                        :show_button_clear="false"
                        :options="kelurahanRapatOptions"
                        :serverside="true"
                        :loading="pageStatus == 'kelurahan-rapat-load'"
                        @change-search="getKelurahanRapat"
                    >
                    </app-select-single>
                </div>
            </div>
            <label class="form-label fw-bolder fs-6 mb-3">Topik Rapat</label>
            <textarea
                type="text"
                class="form-control mb-5"
                v-model="rapat.topik"
            ></textarea>
            <label class="form-label fw-bolder fs-6 mb-3">Jumlah Peserta</label>
            <input
                type="number"
                class="form-control mb-5"
                v-model="rapat.jumlahPeserta"
            />
            <label class="form-label fw-bolder fs-6 mb-3">Resume Rapat</label>
            <app-editor
                class="form-control"
                v-model:content="rapat.resume"
                ref="editor"
                contentType="html"
            ></app-editor>
            <div class="row mt-5">
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >URL Video</label
                    >
                    <input
                        type="text"
                        class="form-control mb-5"
                        v-model="rapat.urlVideo"
                    />
                </div>
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Foto Rapat</label
                    >
                    <input
                        type="file"
                        class="form-control mb-5"
                        v-on:change="onChangeFotoRapat"
                        accept="image/*"
                    />
                    <small class="form-text text-muted mb-5 d-inline-block">
                        Maksimal ukuran file yang dapat diunggah adalah 2 MB.
                    </small>
                </div>
            </div>
        </template>

        <h3 class="mb-5 pt-5 border-bottom">Publikasi Konten Sosial Media</h3>
        <div class="form-check form-switch mb-5">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="has-kie"
                v-model="hasKIE"
            />
            <label class="form-check-label" for="has-kie"
                >Apakah Ada Kegiatan ?</label
            >
        </div>
        <template v-if="hasKIE">
            <label class="form-label fw-bolder fs-6 mb-3 mt-5"
                >Jenis Konten</label
            >
            <select
                class="form-control mb-5"
                placeholder="Pilih Jenis Konten"
                v-model="publikasiKie.jenisKonten"
                v-on:change="onChangeType"
            >
                <option disabled value="" selected>-- PILIH TIPE --</option>
                <option v-for="item in optionsKontenType" :value="item.text">
                    {{ item.text }}
                </option>
            </select>

            <label class="form-label fw-bolder fs-6 mb-3"
                >Jenis Aktivitas</label
            >
            <select
                class="form-control mb-5"
                placeholder="Pilih Jenis Konten"
                v-model="publikasiKie.jenisKegiatan"
                v-on:change="onChangeType"
            >
                <option disabled value="" selected>-- PILIH TIPE --</option>
                <option v-for="item in optionsKieType" :value="item.text">
                    {{ item.text }}
                </option>
            </select>

            <label class="form-label fw-bolder fs-6 mb-3"
                >Jelaskan singkat aktivitas hari ini sesuai jenis aktivitas
                diatas!</label
            >
            <textarea
                class="form-control mb-5"
                v-model="publikasiKie.deskripsiKegiatan"
            ></textarea>

            <label class="form-label fw-bolder fs-6 mb-3">Tema Konten</label>
            <textarea
                class="form-control mb-5"
                v-model="publikasiKie.temaKonten"
            ></textarea>

            <label class="form-label fw-bolder fs-6 mb-3">Judul Konten</label>
            <textarea
                class="form-control mb-5"
                v-model="publikasiKie.judulKonten"
            ></textarea>

            <label class="form-label fw-bolder fs-6 mb-3"
                >Narasi Singkat Konten</label
            >
            <textarea
                class="form-control mb-5"
                v-model="publikasiKie.deskripsiKonten"
            ></textarea>

            <div class="row mt-5">
                <div class="col-lg-6">
                    <label class="form-label fw-bolder fs-6 mb-3"
                        >Screenshot Konten</label
                    >
                    <input
                        type="file"
                        class="form-control"
                        v-on:change="onChangeFotoKonten"
                        accept="image/*"
                    />
                    <small class="form-text text-muted mb-5 d-inline-block">
                        Maksimal ukuran file yang dapat diunggah adalah 2 MB.
                    </small>
                </div>
            </div>

            <label class="form-label fw-bolder fs-6 mt-5">Link Konten</label>
            <input
                type="text"
                class="form-control"
                placeholder="Url"
                v-model="publikasiKie.linkKonten"
            />
            <small class="form-text text-muted mb-5 d-inline-block">
                (Drive / YT / IG / dsb)
            </small>
        </template>

        <div class="form-check mb-5 mt-4">
            <input
                type="checkbox"
                class="form-check-input"
                id="validasi"
                v-model="isChecked"
            />
            <label class="form-check-label" for="validasi"
                >Dengan ini menyatakan bahwa data dan informasi yang saya
                sampaikan dalam form ini adalah benar, lengkap, dan sesuai
                dengan keadaan yang sebenarnya. Saya memahami bahwa segala
                bentuk kesalahan atau ketidakbenaran dalam data dan informasi
                yang saya berikan menjadi tanggung jawab pribadi saya
                sepenuhnya.</label
            >
        </div>

        <template #footer>
            <button
                type="button"
                class="btn btn-sm btn-light"
                data-bs-dismiss="modal"
            >
                Batal
            </button>
            <button
                class="btn btn-sm"
                :class="{'bg-second-primary-custom text-white': isChecked }" 
                :disabled="!isChecked"
                type="button"
                @click="onSubmit"
            >
                Simpan
            </button>
        </template>
    </dashboard-modal>
</template>

<script>
import Api from "@/services/api";

export default {
    data: () => ({
        pageStatus: "standby",
        tanggalPelaksanaan: null,

        hasKonseling: false,
        hasSosialisasi: false,
        hasRapat: false,
        hasPiket: false,
        hasKIE: false,
        isChecked: false,

        kotaKonselingOptions: [],
        kecamatanKonselingOptions: [],
        kelurahanKonselingOptions: [],

        kategoriKasusOptions: [],

        kecamatanSosialisasiOptions: [],
        kelurahanSosialisasiOptions: [],

        kecamatanRapatOptions: [],
        kelurahanRapatOptions: [],

        kecamatanOptions: [],
        kelurahanOptions: [],
        balaiPuspagaOptions: [],

        konseling: {
            nama: "",
            nik: "",
            kategoriKasus: {},
            wargaSurabaya: false,
            kota: {},
            kecamatan: {},
            kelurahan: {},
            alamat: "",
            telp: "",
            deskripsi: "",
            solusi: "",
            type: "",
            fotoKlien: null,
        },
        sosialisasi: {
            type: "",
            sasaran: "",
            sasaranLain: "",
            lokasi: "",
            jumlahPeserta: null,
            narasumber: "",
            instansiNarasumber: "",
            materi: "",
            urlVideo: "",
            fileMateri: null,
            fotoKegiatan: null,
        },
        rapat: {
            pimpinan: "",
            kecamatan: {},
            kelurahan: {},
            topik: "",
            jumlahPeserta: null,
            resume: "",
            urlVideo: "",
            fotoRapat: null,
        },
        piket: {
            kecamatan: {},
            kelurahan: {},
            rw: "",
            jamMulaiTugas: "",
            jamAkhirTugas: "",
            keterangan: "",
            fotoGeotag: null,
        },
        publikasiKie: {
            jenisKonten: "",
            deskripsiKegiatan: "",
            jenisKegiatan: "",
            temaKonten: "",
            judulKonten: "",
            deskripsiKonten: "",
            fotoKonten: null,
            linkKonten: "",
        },
    }),
    mounted() {
        this.reset();
    },
    methods: {
        reset(arrayField = []) {
            // if (arrayField.includes("kecamatan")) {
            //     this.kecamatan = {};
            // }
            // if (arrayField.includes("kelurahan")) {
            //     this.kelurahan = {};
            // }
            // if (arrayField.includes("balaiPuspaga")) {
            //     this.balaiPuspaga = {};
            // }
            // if (arrayField.includes("kecamatanKonseling")) {
            //     this.konseling.kecamatan = {};
            // }
            // if (arrayField.includes("kotaKonseling")) {
            //     this.konseling.kota = {};
            // }
            // if (arrayField.includes("kelurahanKonseling")) {
            //     this.konseling.kelurahan = {};
            // }
            // if (arrayField.includes("kategoriKasus")) {
            //     this.konseling.kategoriKasus = {};
            // }
            // if (arrayField.includes("kelurahanRapat")) {
            //     this.rapat.kelurahan = {};
            // }
            // if (arrayField.includes("kelurahanSosialisasi")) {
            //     this.sosialisasi.kelurahan = {};
            // }
            if (arrayField.includes("kecamatan")) {
                this.kecamatan = {};
            }
            if (arrayField.includes("kelurahan")) {
                this.kelurahan = {};
            }
            if (arrayField.includes("balaiPuspaga")) {
                this.balaiPuspaga = {};
            }
            if (arrayField.includes("kecamatanKonseling")) {
                this.konseling.kecamatan = {};
            }
            if (arrayField.includes("kotaKonseling")) {
                this.konseling.kota = {};
            }
            if (arrayField.includes("kelurahanKonseling")) {
                this.konseling.kelurahan = {};
            }
            if (arrayField.includes("kategoriKasus")) {
                this.konseling.kategoriKasus = {};
            }
            if (arrayField.includes("kelurahanRapat")) {
                this.rapat.kelurahan = {};
            }
            if (arrayField.includes("kelurahanSosialisasi")) {
                this.sosialisasi.kelurahan = {};
            }
            if (arrayField.includes("kecamatanPiket")) {
                this.piket.kecamatan = {};
            }
            if (arrayField.includes("kelurahanPiket")) {
                this.piket.kelurahan = {};
            }
            if (arrayField.includes("balaiPuspaga")) {
                this.piket.rw = "";
            }
        },

        minDate() {
            const today = new Date();
            const sevenDaysAgo = new Date(today);
            sevenDaysAgo.setDate(today.getDate() - 7);
            const formattedDate = sevenDaysAgo.toISOString().split("T")[0];
            return formattedDate;
        },

        maxDate() {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 0);
            const formattedDate = tomorrow.toISOString().split("T")[0];
            return formattedDate;
        },

        onSubmit() {
            this.$ewpLoadingShow();

            const formData = new FormData();

            const laporan = [];

            formData.append(`date`, this.tanggalPelaksanaan);

            if (this.hasKonseling) {
                laporan.push({
                    kegiatan_type: "konseling",
                    name: this.konseling.nama,
                    description: this.konseling.deskripsi,
                    solution: this.konseling.solusi,
                    id_kelurahan: this.konseling.kelurahan.id,

                    nik: this.konseling.nik,
                    phone: this.konseling.telp,
                    is_surabaya_citizen: this.konseling.wargaSurabaya
                        ? 1
                        : undefined,
                    address: this.konseling.alamat,
                    konseling_type: this.konseling.type,
                    id_m_kategori_kasus: this.konseling.kategoriKasus.id,
                    files: [
                        {
                            file: this.konseling.fotoKlien,
                            type: this.laporanKegiatanFileType.FOTO.value,
                        },
                    ],
                });
            }

            if (this.hasSosialisasi) {
                if (this.sosialisasi.sasaran == "Lainnya") {
                    this.sosialisasi.sasaran = this.sosialisasi.sasaranLain;
                }
                laporan.push({
                    kegiatan_type: "sosialisasi",
                    sosialisasi_type: this.sosialisasi.type,
                    sasaran: this.sosialisasi.sasaran,
                    lokasi: this.sosialisasi.lokasi,
                    name: this.sosialisasi.narasumber,
                    description: this.sosialisasi.materi,
                    total_participant: this.sosialisasi.jumlahPeserta,
                    organization: this.sosialisasi.instansiNarasumber,
                    url_video: this.sosialisasi.urlVideo,
                    files: [
                        {
                            file: this.sosialisasi.fotoKegiatan,
                            type: this.laporanKegiatanFileType.FOTO.value,
                        },
                        {
                            file: this.sosialisasi.fileMateri,
                            type: this.laporanKegiatanFileType.MATERI.value,
                        },
                    ],
                });
            }

            if (this.hasRapat) {
                laporan.push({
                    kegiatan_type: "rapat",
                    rapat_type: this.rapat.type,
                    name: this.rapat.pimpinan,
                    description: this.rapat.topik,
                    id_kelurahan: this.rapat.kelurahan.id,
                    total_participant: this.rapat.jumlahPeserta,
                    resume: this.rapat.resume,
                    url_video: this.rapat.urlVideo,
                    files: [
                        {
                            file: this.rapat.fotoRapat,
                            type: this.laporanKegiatanFileType.FOTO.value,
                        },
                    ],
                });
            }

            if (this.hasPiket) {
                laporan.push({
                    kegiatan_type: "piket",
                    id_kelurahan: this.piket.kelurahan.id,
                    rw: this.piket.rw.text,
                    opening_time: this.piket.jamMulaiTugas,
                    closing_time: this.piket.jamAkhirTugas,
                    description: this.piket.keterangan,
                    files: [
                        {
                            file: this.piket.fotoGeotag,
                            type: this.laporanKegiatanFileType.FOTO.value,
                        },
                    ],
                });
            }

            if (this.hasKIE) {
                laporan.push({
                    kegiatan_type: "publikasi_kie",
                    jenis_konten: this.publikasiKie.jenisKonten,
                    deskripsi_kegiatan: this.publikasiKie.deskripsiKegiatan,
                    jenis_kegiatan: this.publikasiKie.jenisKegiatan,
                    tema_konten: this.publikasiKie.temaKonten,
                    judul_konten: this.publikasiKie.judulKonten,
                    deskripsi_konten: this.publikasiKie.deskripsiKonten,
                    link_konten: this.publikasiKie.linkKonten,
                    files: [
                        {
                            file: this.publikasiKie.fotoKonten,
                            type: this.laporanKegiatanFileType.FOTO.value,
                        },
                    ],
                });
            }

            laporan.forEach((v, i) => {
                Object.entries(v).forEach(([key, value]) => {
                    if (key === "files") {
                        if (value.length > 0) {
                            value.forEach((it, index) => {
                                formData.append(
                                    `laporan[${i}][files][${index}][file]`,
                                    it.file
                                );
                                formData.append(
                                    `laporan[${i}][files][${index}][type]`,
                                    it.type
                                );
                            });
                        }
                    } else {
                        formData.append(`laporan[${i}][${key}]`, value);
                    }
                });
            });

            Api()
                .post("laporan-mahasiswa/store", formData)
                .then((response) => {
                    $("#modal-tambah").modal("hide");
                    this.$emit("onSuccess");
                    this.reset();

                    this.$swal({
                        title: "Berhasil!",
                        text: "Menambahkan laporan kegiatan",
                        icon: "success",
                    });
                })
                .catch((error) => {
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.$ewpLoadingHide();
                });
        },
        getSelectList(url, listKey, pageStatus = "select-load") {
            this.pageStatus = pageStatus;

            Api()
                .get(url)
                .then((response) => {
                    this[listKey] = [];

                    for (let i = 0; i < response.data.data.length; i++) {
                        this[listKey].push({
                            id: response.data.data[i].id,
                            text: response.data.data[i].name,
                        });
                    }
                })
                .catch((error) => {
                    this[listKey] = [];
                    this.$axiosHandleError(error);
                })
                .finally(() => {
                    this.pageStatus = "standby";
                });
        },
        getKecamatanKonseling(keyword, limit) {
            this.getSelectList(
                `m-kecamatan/lists?limit=${limit}&search=${keyword}&is_surabaya=${
                    this.konseling.wargaSurabaya
                }&id_kabupaten=${this.konseling.kota?.id ?? ""}`,
                "kecamatanKonselingOptions",
                "kecamatan-konseling-load"
            );
        },
        getKotaKonseling(keyword, limit) {
            this.getSelectList(
                `m-kabupaten/lists?limit=${limit}&search=${keyword}`,
                "kotaKonselingOptions",
                "kota-konseling-load"
            );
        },
        getKelurahanKonseling(keyword, limit) {
            this.getSelectList(
                `m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${this.konseling.kecamatan.id}`,
                "kelurahanKonselingOptions",
                "kelurahan-konseling-load"
            );
        },
        getKecamatanRapat(keyword, limit) {
            this.getSelectList(
                `m-kecamatan/lists?limit=${limit}&search=${keyword}&is_surabaya=true`,
                "kecamatanRapatOptions",
                "kecamatan-rapat-load"
            );
        },
        getKelurahanRapat(keyword, limit) {
            this.getSelectList(
                `m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${this.rapat.kecamatan.id}`,
                "kelurahanRapatOptions",
                "kelurahan-rapat-load"
            );
        },
        getKategoriKasus(keyword, limit) {
            this.getSelectList(
                `m-kategori-kasus/lists?limit=${limit}&search=${keyword}`,
                "kategoriKasusOptions",
                "kategori-kasus-load"
            );
        },
        getKecamatan(keyword, limit) {
            this.getSelectList(
                `m-kecamatan/lists?limit=${limit}&search=${keyword}&is_surabaya=true`,
                "kecamatanOptions",
                "kecamatan-load"
            );
        },
        getKelurahan(keyword, limit) {
            this.getSelectList(
                `m-kelurahan/lists?limit=${limit}&search=${keyword}&id_kecamatan=${this.piket.kecamatan.id}`,
                "kelurahanOptions",
                "kelurahan-load"
            );
        },
        getBalaiPuspagaRW(keyword, limit) {
            this.getSelectList(
                `d-balai-puspaga-rw/lists?limit=${limit}&search=${keyword}&id_kelurahan=${this.piket.kelurahan.id}`,
                "balaiPuspagaOptions",
                "balai-puspaga-load"
            );
        },
        onChangeFotoKlien(e) {
            const [file] = e.target.files;
            this.konseling.fotoKlien = file;
        },
        onChangeFileMateri(e) {
            const [file] = e.target.files;
            this.sosialisasi.fileMateri = file;
        },
        onChangeFotoKegiatan(e) {
            const [file] = e.target.files;
            this.sosialisasi.fotoKegiatan = file;
        },
        onChangeFotoRapat(e) {
            const [file] = e.target.files;
            this.rapat.fotoRapat = file;
        },
        onChangeFotoPiket(e) {
            const [file] = e.target.files;
            this.piket.fotoGeotag = file;
        },
        onChangeFotoKonten(e) {
            const [file] = e.target.files;
            this.publikasiKie.fotoKonten = file;
        },
    },
    computed: {
        optionsLaporanKegiatanKonselingType() {
            return this.$store.state.enums.optionsLaporanKegiatanKonselingType;
        },
        laporanKegiatanFileType() {
            return this.$store.state.enums.laporanKegiatanFileType;
        },
        optionsLaporanKegiatanSosialisasiType() {
            return this.$store.state.enums
                .optionsLaporanKegiatanSosialisasiType;
        },
        optionsLaporanKegiatanRapatType() {
            return this.$store.state.enums.optionsLaporanKegiatanRapatType;
        },
        optionsLaporanKegiatanSosialisasiSasaran() {
            return this.$store.state.enums
                .optionsLaporanKegiatanSosialisasiSasaran;
        },
        contentTypeOptions() {
            return this.$store.state.enums.optionsJenisKie;
        },
        enumType() {
            return this.$store.state.enums.jenisKie;
        },
        optionsKieType() {
            return this.$store.state.enums
                .optionsLaporanKegiatanPublikasiKieType;
        },
        optionsKontenType() {
            return this.$store.state.enums
                .optionsLaporanKegiatanPublikasiKontenType;
        },
    },
};
</script>
