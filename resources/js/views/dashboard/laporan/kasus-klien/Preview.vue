<template>
    <div class="wrapper-print" style="position:relative;">
        <div class="d-flex justify-content-center align-items-center mb-5">
            <button type="button"
                style="font-size:15px;border-radius:50px;background:#fff;color:black;padding:10px 25px;border:0 !important;position:absolute;left:0;top:0"
                @click="$router.back()"><i class="fa fa-arrow-left" style="color:black"></i>&ensp;&ensp;Kembali</button>
            <div class="text-center" style="font-weight:600;font-size:24px">Laporan Kasus Klien</div>
            <div></div>
        </div>

        <div class="box-print">
            <div class="text-center fw-bolder pb-10" style="font-size:15px">DATA PUSAT PELAYANAN TERPADU PELINDUNGAN
                PEREMPUAN DAN ANAK(PPTP2A)</div>
            <div class="d-flex justify-content-center w-100" v-if="pageStatus == 'page-load'">
                <app-loader></app-loader>
            </div>
            <div class="box-container-print" v-else>
                <template v-if="$route.query.type == 'spesifik'">
                    <div class="table-responsive">
                        <table class="table" cellspacing="0" style="font-family:Arial;min-width:6000px">
                            <thead>
                                <tr>
                                    <th colspan="22" style="background:#f69546;text-align:center;">IDENTITAS KLIEN</th>
                                    <th colspan="6" style="background:#4aacc5;text-align:center;">ALAMAT KK</th>
                                    <th colspan="6" style="background:#4aacc5;text-align:center;">ALAMAT DOMISILI</th>
                                    <th colspan="7" style="background:#8064a1;text-align:center;">DETAIL KASUS</th>
                                    <th colspan="7" style="background:#1e477b;text-align:center;">LAINNYA</th>
                                    <th style="background:#d99491;text-align:center;">&ensp;</th>
                                </tr>
                                <tr>
                                    <th style="background:#f69546;text-align:center;">NO</th>
                                    <th style="background:#f69546;text-align:center;">NOMOR REGISTRASI</th>
                                    <th style="background:#f69546;text-align:center;">NAMA KLIEN</th>
                                    <th style="background:#f69546;text-align:center;">INISIAL</th>
                                    <th style="background:#f69546;text-align:center;">NIK</th>
                                    <th style="background:#f69546;text-align:center;">NO KK</th>
                                    <th style="background:#f69546;text-align:center;">L/P</th>
                                    <th style="background:#f69546;text-align:center;">PENDIDIKAN</th>
                                    <th style="background:#f69546;text-align:center;">KELAS</th>
                                    <th style="background:#f69546;text-align:center;">JURUSAN</th>
                                    <th style="background:#f69546;text-align:center;">TAHUN LULUS</th>
                                    <th style="background:#f69546;text-align:center;">NAMA INSTANSI / SEKOLAH</th>
                                    <th style="background:#f69546;text-align:center;">PEKERJAAN</th>
                                    <th style="background:#f69546;text-align:center;">PENGHASILAN PER BULAN</th>
                                    <th style="background:#f69546;text-align:center;">AGAMA</th>
                                    <th style="background:#f69546;text-align:center;">STATUS PERKAWINAN</th>
                                    <th style="background:#f69546;text-align:center;">TEMPAT LAHIR</th>
                                    <th style="background:#f69546;text-align:center;">TANGGAL LAHIR</th>
                                    <th style="background:#f69546;text-align:center;">USIA</th>
                                    <th style="background:#f69546;text-align:center;">KATEGORI KLIEN</th>
                                    <th style="background:#f69546;text-align:center;">JENIS KLIEN</th>
                                    <th style="background:#f69546;text-align:center;">TELP</th>
                                    <th style="background:#4aacc5;text-align:center;">ALAMAT</th>
                                    <th style="background:#4aacc5;text-align:center;">RT</th>
                                    <th style="background:#4aacc5;text-align:center;">RW</th>
                                    <th style="background:#4aacc5;text-align:center;">KELURAHAN</th>
                                    <th style="background:#4aacc5;text-align:center;">KECAMATAN</th>
                                    <th style="background:#4aacc5;text-align:center;">WILAYAH</th>
                                    <th style="background:#4aacc5;text-align:center;">ALAMAT</th>
                                    <th style="background:#4aacc5;text-align:center;">RT</th>
                                    <th style="background:#4aacc5;text-align:center;">RW</th>
                                    <th style="background:#4aacc5;text-align:center;">KELURAHAN</th>
                                    <th style="background:#4aacc5;text-align:center;">KECAMATAN</th>
                                    <th style="background:#4aacc5;text-align:center;">WILAYAH</th>
                                    <th style="background:#8064a1;text-align:center;">TIPE KASUS</th>
                                    <th style="background:#8064a1;text-align:center;">TIPE PERMASALAHAN</th>
                                    <th style="background:#8064a1;text-align:center;">KATEGORI KASUS</th>
                                    <th style="background:#8064a1;text-align:center;">JENIS KASUS</th>
                                    <th style="background:#8064a1;text-align:center;">URAIAN SINGKAT PERMASALAHAN</th>
                                    <th style="background:#8064a1;text-align:center;">LOKASI KASUS</th>
                                    <th style="background:#8064a1;text-align:center;">TANGGAL DAN JAM KEJADIAN</th>
                                    <th style="background:#1e477b;text-align:center;">KEPEMILIKAN BPJS</th>
                                    <th style="background:#1e477b;text-align:center;">TANGGAL DAN JAM PENGADUAN</th>
                                    <th style="background:#1e477b;text-align:center;">TANGGAL DAN JAM PENANGANAN AWAL
                                    </th>
                                    <th style="background:#1e477b;text-align:center;">TANGGAL DAN JAM PENJANGKAUAN</th>
                                    <th style="background:#1e477b;text-align:center;">KONSELOR 1</th>
                                    <th style="background:#1e477b;text-align:center;">KONSELOR 2</th>
                                    <th style="background:#1e477b;text-align:center;">SUMBER PENGADUAN</th>
                                    <th style="background:#d99491;text-align:center;">DURATION</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(context,index) in data">
                                    <td class="text-center">{{index + 1}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.no_registrasi}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.nama_klien}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.inisial}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.nik}} </td>
                                    <td style="text-align:center;">{{context.identitas_klien?.no_kk}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.l_p}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.pendidikan}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.kelas}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.jurusan}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.tahun_lulus}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.nama_instansi}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.pekerjaan}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.penghasilan_perbulan}}
                                    </td>
                                    <td style="text-align:center;">{{context.identitas_klien?.agama}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.status_perkawinan}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.tempat_lahir}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.tanggal_lahir}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.usia}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.kategori_klien}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.jenis_klien}}</td>
                                    <td style="text-align:center;">{{context.identitas_klien?.no_telpon}}</td>
                                    <td style="text-align:center;">{{context.alamat_kk?.alamat}}</td>
                                    <td style="text-align:center;">{{context.alamat_kk?.rt}}</td>
                                    <td style="text-align:center;">{{context.alamat_kk?.rw}}</td>
                                    <td style="text-align:center;">{{context.alamat_kk?.kelurahan}}</td>
                                    <td style="text-align:center;">{{context.alamat_kk?.kecamatan}}</td>
                                    <td style="text-align:center;">{{context.alamat_kk?.wilayah}}</td>
                                    <td style="text-align:center;">{{context.alamat_domisili?.alamat}}</td>
                                    <td style="text-align:center;">{{context.alamat_domisili?.rt}}</td>
                                    <td style="text-align:center;">{{context.alamat_domisili?.rw}}</td>
                                    <td style="text-align:center;">{{context.alamat_domisili?.kelurahan}}</td>
                                    <td style="text-align:center;">{{context.alamat_domisili?.kecamatan}}</td>
                                    <td style="text-align:center;">{{context.alamat_domisili?.wilayah}}</td>
                                    <td style="text-align:center;">{{context.kasus?.tipe_kasus}}</td>
                                    <td style="text-align:center;">{{context.kasus?.tipe_permasalahan}}</td>
                                    <td style="text-align:center;">{{context.kasus?.kategori_kasus}}</td>
                                    <td style="text-align:center;">{{context.kasus?.jenis_kasus}}</td>
                                    <td style="text-align:center;">{{context.kasus?.deskripsi}}</td>
                                    <td style="text-align:center;">{{context.kasus?.lokasi_kasus}}</td>
                                    <td style="text-align:center;">{{context.kasus?.tanggal_dan_jam}}</td>
                                    <td style="text-align:center;">{{context.lainnya?.kepemilikan_bpjs}}</td>
                                    <td style="text-align:center;">{{context.lainnya?.tanggal_pengaduan}}</td>
                                    <td style="text-align:center;">{{context.lainnya?.tanggal_penanganan_awal}}</td>
                                    <td style="text-align:center;">{{context.lainnya?.tanggal_penjangkauan}}</td>
                                    <td style="text-align:center;">
                                        {{context.lainnya?.konselor.length > 0 ? context.lainnya?.konselor[0].name : ''}}
                                    </td>
                                    <td style="text-align:center;">
                                        {{context.lainnya?.konselor.length > 1 ? context.lainnya?.konselor[1].name : ''}}
                                    </td>
                                    <td style="text-align:center;">{{context.lainnya?.sumber_pengaduan}}</td>
                                    <td style="text-align:center;">{{context.duration}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
                <template v-if="$route.query.type == 'default'">
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Pelapor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Klien</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">Pelaku</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4">Keluarga</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_5">Keterangan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_6">Intervensi DP3APPKB</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_7">Intervensi OPD</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table" cellspacing="0" style="font-family:Arial;min-width:2000px">
                                    <thead>
                                        <tr>
                                            <th colspan="7" style="background:#f69546;text-align:center;">IDENTITAS
                                                PELAPOR</th>
                                            <th colspan="3" style="background:#f69546;text-align:center;">URAIAN
                                                PENGADUAN</th>
                                            <th colspan="2" style="background:#f69546;text-align:center;">URAIAN
                                                PENANGANAN AWAL</th>
                                        </tr>
                                        <tr>
                                            <th style="background:#f69546;text-align:center;">NO</th>
                                            <th style="background:#f69546;text-align:center;">NO REGISTRASI</th>
                                            <th style="background:#f69546;text-align:center;">NAMA LENGKAP PELAPOR</th>
                                            <th style="background:#f69546;text-align:center;">NIK PELAPOR(OPSIONAL)</th>
                                            <th style="background:#f69546;text-align:center;">WARGA SURABAYA</th>
                                            <th style="background:#f69546;text-align:center;">NO TELEPON/WHATSAPP</th>
                                            <th style="background:#f69546;text-align:center;">ALAMAT DOMISILI</th>
                                            <th style="background:#f69546;text-align:center;">SUMBER PENGADUAN</th>
                                            <th style="background:#f69546;text-align:center;">TANGGAL DAN JAM PENGADUAN
                                            </th>
                                            <th style="background:#f69546;text-align:center;">URAIAN SINGKAT
                                                PERMASALAHAN</th>
                                            <th style="background:#f69546;text-align:center;">TANGGAL DAN JAM PENANGANAN
                                                AWAL</th>
                                            <th style="background:#f69546;text-align:center;">HASIL PENANGANAN AWAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for="(context,index) in data.pelapor ?? []">
                                            <td class="text-center">{{index + 1}}</td>
                                            <td style="text-align:center;">{{context.no_registrasi}}</td>
                                            <td style="text-align:center;">{{context.nama}}</td>
                                            <td style="text-align:center;">{{context.nik}}</td>
                                            <td style="text-align:center;">{{context.warga_surabaya}} </td>
                                            <td style="text-align:center;">{{context.no_telepon}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili}}</td>
                                            <td style="text-align:center;">{{context.sumber_pengaduan}}</td>
                                            <td style="text-align:center;">{{context.tgl_dan_jam_pengaduan}}</td>
                                            <td style="text-align:center;">{{context.uraian}}</td>
                                            <td style="text-align:center;">{{context.tgl_dan_jam_penanganan}}</td>
                                            <td style="text-align:center;">{{context.hasil_penanganan}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table" cellspacing="0" style="font-family:Arial;min-width:6000px">
                                    <thead>
                                        <tr>
                                            <th colspan="22" style="background:#f69546;text-align:center;">IDENTITAS
                                                KLIEN</th>
                                            <th colspan="6" style="background:#4aacc5;text-align:center;">ALAMAT KK</th>
                                            <th colspan="6" style="background:#4aacc5;text-align:center;">ALAMAT
                                                DOMISILI</th>
                                            <th colspan="7" style="background:#8064a1;text-align:center;">DETAIL KASUS
                                            </th>
                                            <th colspan="7" style="background:#1e477b;text-align:center;">LAINNYA</th>
                                            <th style="background:#d99491;text-align:center;">&ensp;</th>
                                        </tr>
                                        <tr>
                                            <th style="background:#f69546;text-align:center;">NO</th>
                                            <th style="background:#f69546;text-align:center;">NOMOR REGISTRASI</th>
                                            <th style="background:#f69546;text-align:center;">NAMA KLIEN</th>
                                            <th style="background:#f69546;text-align:center;">INISIAL</th>
                                            <th style="background:#f69546;text-align:center;">NIK</th>
                                            <th style="background:#f69546;text-align:center;">NO KK</th>
                                            <th style="background:#f69546;text-align:center;">L/P</th>
                                            <th style="background:#f69546;text-align:center;">PENDIDIKAN</th>
                                            <th style="background:#f69546;text-align:center;">KELAS</th>
                                            <th style="background:#f69546;text-align:center;">JURUSAN</th>
                                            <th style="background:#f69546;text-align:center;">TAHUN LULUS</th>
                                            <th style="background:#f69546;text-align:center;">NAMA INSTANSI / SEKOLAH
                                            </th>
                                            <th style="background:#f69546;text-align:center;">PEKERJAAN</th>
                                            <th style="background:#f69546;text-align:center;">PENGHASILAN PER BULAN</th>
                                            <th style="background:#f69546;text-align:center;">AGAMA</th>
                                            <th style="background:#f69546;text-align:center;">STATUS PERKAWINAN</th>
                                            <th style="background:#f69546;text-align:center;">TEMPAT LAHIR</th>
                                            <th style="background:#f69546;text-align:center;">TANGGAL LAHIR</th>
                                            <th style="background:#f69546;text-align:center;">USIA</th>
                                            <th style="background:#f69546;text-align:center;">KATEGORI KLIEN</th>
                                            <th style="background:#f69546;text-align:center;">JENIS KLIEN</th>
                                            <th style="background:#f69546;text-align:center;">TELP</th>
                                            <th style="background:#4aacc5;text-align:center;">ALAMAT</th>
                                            <th style="background:#4aacc5;text-align:center;">RT</th>
                                            <th style="background:#4aacc5;text-align:center;">RW</th>
                                            <th style="background:#4aacc5;text-align:center;">KELURAHAN</th>
                                            <th style="background:#4aacc5;text-align:center;">KECAMATAN</th>
                                            <th style="background:#4aacc5;text-align:center;">WILAYAH</th>
                                            <th style="background:#4aacc5;text-align:center;">ALAMAT</th>
                                            <th style="background:#4aacc5;text-align:center;">RT</th>
                                            <th style="background:#4aacc5;text-align:center;">RW</th>
                                            <th style="background:#4aacc5;text-align:center;">KELURAHAN</th>
                                            <th style="background:#4aacc5;text-align:center;">KECAMATAN</th>
                                            <th style="background:#4aacc5;text-align:center;">WILAYAH</th>
                                            <th style="background:#8064a1;text-align:center;">TIPE KASUS</th>
                                            <th style="background:#8064a1;text-align:center;">TIPE PERMASALAHAN</th>
                                            <th style="background:#8064a1;text-align:center;">KATEGORI KASUS</th>
                                            <th style="background:#8064a1;text-align:center;">JENIS KASUS</th>
                                            <th style="background:#8064a1;text-align:center;">URAIAN SINGKAT
                                                PERMASALAHAN</th>
                                            <th style="background:#8064a1;text-align:center;">LOKASI KASUS</th>
                                            <th style="background:#8064a1;text-align:center;">TANGGAL DAN JAM KEJADIAN
                                            </th>
                                            <th style="background:#1e477b;text-align:center;">KEPEMILIKAN BPJS</th>
                                            <th style="background:#1e477b;text-align:center;">TANGGAL DAN JAM PENGADUAN
                                            </th>
                                            <th style="background:#1e477b;text-align:center;">TANGGAL DAN JAM PENANGANAN
                                                AWAL
                                            </th>
                                            <th style="background:#1e477b;text-align:center;">TANGGAL DAN JAM
                                                PENJANGKAUAN</th>
                                            <th style="background:#1e477b;text-align:center;">KONSELOR 1</th>
                                            <th style="background:#1e477b;text-align:center;">KONSELOR 2</th>
                                            <th style="background:#1e477b;text-align:center;">SUMBER PENGADUAN</th>
                                            <th style="background:#d99491;text-align:center;">DURASI PENANGANAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for="(context,index) in data.klien ?? []">
                                            <td class="text-center">{{index + 1}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.no_registrasi}}
                                            </td>
                                            <td style="text-align:center;">{{context.identitas_klien?.nama}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.inisial}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.nik}} </td>
                                            <td style="text-align:center;">{{context.identitas_klien?.no_kk}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.l_p}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.pendidikan}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.kelas}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.jurusan}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.tahun_lulus}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.instansi}}
                                            </td>
                                            <td style="text-align:center;">{{context.identitas_klien?.pekerjaan}}</td>
                                            <td style="text-align:center;">
                                                {{context.identitas_klien?.penghasilan_perbulan}}
                                            </td>
                                            <td style="text-align:center;">{{context.identitas_klien?.agama}}</td>
                                            <td style="text-align:center;">
                                                {{context.identitas_klien?.status_perkawinan}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.tempat_lahir}}
                                            </td>
                                            <td style="text-align:center;">{{context.identitas_klien?.tanggal_lahir}}
                                            </td>
                                            <td style="text-align:center;">{{context.identitas_klien?.usia}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.kategori}}
                                            </td>
                                            <td style="text-align:center;">{{context.identitas_klien?.jenis}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien?.no_telepon}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk?.alamat}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk?.rt}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk?.rw}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk?.kelurahan}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk?.kecamatan}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk?.wilayah}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili?.alamat}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili?.rt}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili?.rw}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili?.kelurahan}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili?.kecamatan}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili?.wilayah}}</td>
                                            <td style="text-align:center;">{{context.detail_kasus?.tipe_kasus}}</td>
                                            <td style="text-align:center;">{{context.detail_kasus?.tipe_permasalahan}}
                                            </td>
                                            <td style="text-align:center;">{{context.detail_kasus?.kategori_kasus}}</td>
                                            <td style="text-align:center;">{{context.detail_kasus?.jenis_kasus}}</td>
                                            <td style="text-align:center;">{{context.detail_kasus?.uraian}}</td>
                                            <td style="text-align:center;">{{context.detail_kasus?.lokasi }}</td>
                                            <td style="text-align:center;">{{context.detail_kasus?.tanggal_dan_jam}}
                                            </td>
                                            <td style="text-align:center;">{{context.lainnya?.kepemilikan_bpjs}}</td>
                                            <td style="text-align:center;">
                                                {{context.lainnya?.tanggal_dan_jam_pengaduan}}</td>
                                            <td style="text-align:center;">
                                                {{context.lainnya?.tanggal_dan_jam_penanganan}}
                                            </td>
                                            <td style="text-align:center;">
                                                {{context.lainnya?.tanggal_dan_jam_penjangkauan}}
                                            </td>
                                            <td style="text-align:center;">
                                                {{context.lainnya?.konselor_1 ? context.lainnya?.konselor_1.name : ''}}
                                            </td>
                                            <td style="text-align:center;">
                                                {{context.lainnya?.konselor_2 ? context.lainnya?.konselor_2.name : ''}}
                                            </td>
                                            <td style="text-align:center;">{{context.lainnya?.sumber_pengaduan}}</td>
                                            <td style="text-align:center;">{{context.durasi}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sticky-custom" cellspacing="0"
                                    style="font-family:Arial;min-width:4000px">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background:#f69546;text-align:center;">IDENTITAS
                                                KLIEN</th>
                                            <th colspan="19" style="background:#4bacc6;text-align:center;">IDENTITAS
                                                PELAKU</th>
                                            <th colspan="6" style="background:#4bacc6;text-align:center;">ALAMAT KK</th>
                                            <th colspan="6" style="background:#4bacc6;text-align:center;">ALAMAT
                                                DOMISILI</th>
                                        </tr>
                                        <tr>
                                            <th style="background:#f69546;text-align:center;">NO</th>
                                            <th style="background:#f69546;text-align:center;">NAMA KLIEN</th>
                                            <th style="background:#f69546;text-align:center;">NIK</th>
                                            <th style="background:#4bacc6;text-align:center;">NAMA PELAKU</th>
                                            <th style="background:#4bacc6;text-align:center;">NIK</th>
                                            <th style="background:#4bacc6;text-align:center;">KK</th>
                                            <th style="background:#4bacc6;text-align:center;">L/P</th>
                                            <th style="background:#4bacc6;text-align:center;">PENDIDIKAN</th>
                                            <th style="background:#4bacc6;text-align:center;">JURUSAN</th>
                                            <th style="background:#4bacc6;text-align:center;">TAHUN LULUS</th>
                                            <th style="background:#4bacc6;text-align:center;">NAMA INSTANSI / SEKOLAH
                                            </th>
                                            <th style="background:#4bacc6;text-align:center;">PEKERJAAN</th>
                                            <th style="background:#4bacc6;text-align:center;">AGAMA</th>
                                            <th style="background:#4bacc6;text-align:center;">STATUS PERKAWINAN</th>
                                            <th style="background:#4bacc6;text-align:center;">TEMPAT LAHIR</th>
                                            <th style="background:#4bacc6;text-align:center;">TANGGAL LAHIR</th>
                                            <th style="background:#4bacc6;text-align:center;">USIA</th>
                                            <th style="background:#4bacc6;text-align:center;">KATEGORI</th>
                                            <th style="background:#4bacc6;text-align:center;">TELP</th>
                                            <th style="background:#4bacc6;text-align:center;">TANGGAL MULAI KENAL PELAKU
                                            </th>
                                            <th style="background:#4bacc6;text-align:center;">HUB. PELAKU DGN KORBAN
                                            </th>
                                            <th style="background:#4bacc6;text-align:center;">KEWARGANEGARAAN</th>
                                            <th style="background:#4bacc6;text-align:center;">ALAMAT</th>
                                            <th style="background:#4bacc6;text-align:center;">RT</th>
                                            <th style="background:#4bacc6;text-align:center;">RW</th>
                                            <th style="background:#4bacc6;text-align:center;">KELURAHAN</th>
                                            <th style="background:#4bacc6;text-align:center;">KECAMATAN</th>
                                            <th style="background:#4bacc6;text-align:center;">WILAYAH</th>
                                            <th style="background:#4bacc6;text-align:center;">ALAMAT</th>
                                            <th style="background:#4bacc6;text-align:center;">RT</th>
                                            <th style="background:#4bacc6;text-align:center;">RW</th>
                                            <th style="background:#4bacc6;text-align:center;">KELURAHAN</th>
                                            <th style="background:#4bacc6;text-align:center;">KECAMATAN</th>
                                            <th style="background:#4bacc6;text-align:center;">WILAYAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for="(context,index) in data.pelaku ?? []">
                                            <td class="text-center">{{index + 1}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nama}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nik}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.nama}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.nik}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.kk}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.l_p}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.pendidikan}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.jurusan}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.tahun_lulus}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.instansi}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.pekerjaan}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.agama}}</td>
                                            <td style="text-align:center;">
                                                {{context.identitas_pelaku.status_perkawinan}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.tempat_lahir}}
                                            </td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.tanggal_lahir}}
                                            </td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.usia}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.kategori}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.no_telepon}}</td>
                                            <td style="text-align:center;">
                                                {{context.identitas_pelaku.tanggal_kenal_pelaku}}</td>
                                            <td style="text-align:center;">
                                                {{context.identitas_pelaku.hub_dengan_korban}}</td>
                                            <td style="text-align:center;">{{context.identitas_pelaku.kewarganegaraan}}
                                            </td>
                                            <td style="text-align:center;">{{context.alamat_kk.alamat}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk.rt}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk.rw}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk.kelurahan}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk.kecamatan}}</td>
                                            <td style="text-align:center;">{{context.alamat_kk.wilayah}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili.alamat}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili.rt}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili.rw}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili.kelurahan}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili.kecamatan}}</td>
                                            <td style="text-align:center;">{{context.alamat_domisili.wilayah}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sticky-custom" cellspacing="0"
                                    style="font-family:Arial;min-width:3000px">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background:#f69546;text-align:center;">IDENTITAS
                                                KLIEN</th>
                                            <template v-for="i in maxCountFamily">
                                                <th colspan="14" style="background:#4bacc6;text-align:center;">IDENTITAS
                                                    KELUARGA {{i}}</th>
                                                <th colspan="6" style="background:#4bacc6;text-align:center;">ALAMAT KK
                                                </th>
                                                <th colspan="6" style="background:#4bacc6;text-align:center;">ALAMAT
                                                    DOMISILI</th>
                                            </template>
                                            <th v-if="maxCountSibling > 0" :colspan="maxCountSibling"
                                                style="background:#538dd5;text-align:center;">SAUDARA</th>
                                        </tr>
                                        <tr>
                                            <th style="background:#f69546;text-align:center;">NO</th>
                                            <th style="background:#f69546;text-align:center;">NAMA KLIEN</th>
                                            <th style="background:#f69546;text-align:center;">NIK</th>
                                            <!-- KELUARGA 1 -->
                                            <template v-for="i in maxCountFamily">
                                                <th style="background:#4bacc6;text-align:center;">HUBUNGAN DENGAN KLIEN
                                                </th>
                                                <th style="background:#4bacc6;text-align:center;">NAMA LENGKAP</th>
                                                <th style="background:#4bacc6;text-align:center;">NIK</th>
                                                <th style="background:#4bacc6;text-align:center;">KK</th>
                                                <th style="background:#4bacc6;text-align:center;">PEKERJAAN</th>
                                                <th style="background:#4bacc6;text-align:center;">SIFAT PEKERJAAN</th>
                                                <th style="background:#4bacc6;text-align:center;">PENGHASILAN PER BULAN
                                                </th>
                                                <th style="background:#4bacc6;text-align:center;">STATUS PERNIKAHAN</th>
                                                <th style="background:#4bacc6;text-align:center;">AGAMA</th>
                                                <th style="background:#4bacc6;text-align:center;">TEMPAT LAHIR</th>
                                                <th style="background:#4bacc6;text-align:center;">TANGGAL LAHIR</th>
                                                <th style="background:#4bacc6;text-align:center;">USIA</th>
                                                <th style="background:#4bacc6;text-align:center;">NO TELP</th>
                                                <th style="background:#4bacc6;text-align:center;">KEPEMILIKAN BPJS</th>
                                                <th style="background:#4bacc6;text-align:center;">ALAMAT</th>
                                                <th style="background:#4bacc6;text-align:center;">RT</th>
                                                <th style="background:#4bacc6;text-align:center;">RW</th>
                                                <th style="background:#4bacc6;text-align:center;">KELURAHAN </th>
                                                <th style="background:#4bacc6;text-align:center;">KECAMATAN</th>
                                                <th style="background:#4bacc6;text-align:center;">WILAYAH</th>
                                                <th style="background:#4bacc6;text-align:center;">ALAMAT</th>
                                                <th style="background:#4bacc6;text-align:center;">RT</th>
                                                <th style="background:#4bacc6;text-align:center;">RW</th>
                                                <th style="background:#4bacc6;text-align:center;">KELURAHAN</th>
                                                <th style="background:#4bacc6;text-align:center;">KECAMATAN</th>
                                                <th style="background:#4bacc6;text-align:center;">WILAYAH</th>
                                            </template>
                                            <!-- SAUDARA -->
                                            <template v-for="i in maxCountSibling">
                                                <th style="background:#538dd5;text-align:center;">SAUDARA {{i}}</th>
                                            </template>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for="(context,index) in data.keluarga ?? []">
                                            <td class="text-center">{{index + 1}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nama}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nik}}</td>
                                            <template v-for="i in maxCountFamily">
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].hubungan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].nama : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].nik : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].kk : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].pekerjaan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].sifat_pekerjaan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].penghasilan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].status_pernikahan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].agama : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].tempat_lahir : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].tanggal_lahir : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].usia : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].no_telp : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].kepemilikan_bpjs : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_kk.alamat : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_kk.rt : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_kk.rw : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_kk.kelurahan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_kk.kecamatan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_kk.wilayah : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_domisili.alamat : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_domisili.rt : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_domisili.rw : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_domisili.kelurahan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_domisili.kecamatan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.keluarga && context.keluarga.length > 0 && context.keluarga[i - 1] ? context.keluarga[i - 1].alamat_domisili.wilayah : ''}}
                                                </td>
                                            </template>

                                            <template v-for="i in maxCountSibling">
                                                <td style="text-align:center;">
                                                    {{context.saudara && context.saudara.length > 0 && context.saudara[i - 1] ? context.saudara[i - 1].nama : ''}}
                                                </td>
                                            </template>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sticky-custom" cellspacing="0"
                                    style="font-family:Arial;min-width:1800px">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background:#f69546;text-align:center;">IDENTITAS
                                                KLIEN</th>
                                            <th style="background:#9bbb59;text-align:center;">&ensp;</th>
                                            <th style="background:#9bbb59;text-align:center;">&ensp;</th>
                                            <th style="background:#9bbb59;text-align:center;">&ensp;</th>
                                            <th colspan="4" style="background:#9bbb59;text-align:center;">KONDISI KLIEN
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="background:#f69546;text-align:center;">NO</th>
                                            <th style="background:#f69546;text-align:center;">NAMA KLIEN</th>
                                            <th style="background:#f69546;text-align:center;">NIK</th>
                                            <th style="background:#9bbb59;text-align:center;">SITUASI KELUARGA</th>
                                            <th style="background:#9bbb59;text-align:center;">KRONOLOGI KEJADIAN</th>
                                            <th style="background:#9bbb59;text-align:center;">HARAPAN KLIEN DAN KELUARGA
                                            </th>
                                            <th style="background:#9bbb59;text-align:center;">FISIK</th>
                                            <th style="background:#9bbb59;text-align:center;">PSIKOLOGIS</th>
                                            <th style="background:#9bbb59;text-align:center;">SOSIAL</th>
                                            <th style="background:#9bbb59;text-align:center;">SPIRITUAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for="(context,index) in data.keterangan ?? []">
                                            <td class="text-center">{{index + 1}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nama}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nik}}</td>
                                            <td style="text-align:center;"><div v-html="context.situasi_keluarga"></div></td>
                                            <td style="text-align:center;"><div v-html="context.kronologi_kejadian"></div></td>
                                            <td style="text-align:center;"><div v-html="context.harapan_klien"></div></td>
                                            <td style="text-align:center;">{{context.kondisi_klien.fisik}}</td>
                                            <td style="text-align:center;">{{context.kondisi_klien.psikologi}}</td>
                                            <td style="text-align:center;">{{context.kondisi_klien.sosial}}</td>
                                            <td style="text-align:center;">{{context.kondisi_klien.spiritual}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_6" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sticky-custom" cellspacing="0"
                                    style="font-family:Arial;">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background:#f69546;text-align:center;">IDENTITAS
                                                KLIEN</th>
                                            <template v-for="i in maxCountPelayananDp5a">
                                                <th colspan="2" style="background:#9bbb59;text-align:center;">PELAYANAN
                                                    {{i}}
                                                </th>
                                            </template>
                                        </tr>
                                        <tr>
                                            <th style="background:#f69546;text-align:center;">NO</th>
                                            <th style="background:#f69546;text-align:center;">NAMA KLIEN</th>
                                            <th style="background:#f69546;text-align:center;">NIK</th>
                                            <template v-for="i in maxCountPelayananDp5a">                                                
                                                <th style="background:#9bbb59;text-align:center;">PELAYANAN YANG
                                                    DIBERIKAN
                                                </th>
                                                <th style="background:#9bbb59;text-align:center;">DESKRIPSI PELAYANAN
                                                </th>
                                            </template>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for="(context,index) in data.intervensi_dp3appkb ?? []">
                                            <td class="text-center">{{index + 1}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nama}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nik}}</td>
                                            <template v-for="i in maxCountPelayananDp5a">                                              
                                                <td style="text-align:center;">
                                                    {{context.pelayanan && context.pelayanan.length > 0 && context.pelayanan[i - 1] ? context.pelayanan[i - 1].pelayanan_diberikan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.pelayanan && context.pelayanan.length > 0 && context.pelayanan[i - 1] ? context.pelayanan[i - 1].deskripsi : ''}}
                                                </td>
                                            </template>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sticky-custom" cellspacing="0"
                                    style="font-family:Arial;">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background:#f69546;text-align:center;">IDENTITAS
                                                KLIEN</th>
                                            <template v-for="i in maxCountPelayananOpd">
                                                <th colspan="3" style="background:#9bbb59;text-align:center;">PELAYANAN
                                                    {{i}}
                                                </th>
                                            </template>
                                        </tr>
                                        <tr>
                                            <th style="background:#f69546;text-align:center;">NO</th>
                                            <th style="background:#f69546;text-align:center;">NAMA KLIEN</th>
                                            <th style="background:#f69546;text-align:center;">NIK</th>
                                            <template v-for="i in maxCountPelayananOpd">
                                                <th style="background:#9bbb59;text-align:center;">KEBUTUHAN</th>
                                                <th style="background:#9bbb59;text-align:center;">OPD/INSTANSI RUJUKAN
                                                </th>                                               
                                                <th style="background:#9bbb59;text-align:center;">PELAYANAN YANG
                                                    DIBERIKAN
                                                </th>                                             
                                            </template>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr v-for="(context,index) in data.intervensi_opd ?? []">
                                            <td class="text-center">{{index + 1}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nama}}</td>
                                            <td style="text-align:center;">{{context.identitas_klien.nik}}</td>
                                            <template v-for="i in maxCountPelayananOpd">
                                                <td style="text-align:center;">
                                                    {{context.pelayanan && context.pelayanan.length > 0 && context.pelayanan[i - 1] ? context.pelayanan[i - 1].kebutuhan : ''}}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{context.pelayanan && context.pelayanan.length > 0 && context.pelayanan[i - 1] ? context.pelayanan[i - 1].opd : ''}}
                                                </td>                                               
                                                <td style="text-align:center;">
                                                    {{context.pelayanan && context.pelayanan.length > 0 && context.pelayanan[i - 1] ? context.pelayanan[i - 1].pelayanan_diberikan : ''}}
                                                </td>                                              
                                            </template>                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
    import Api from "@/services/api";
    export default {
        data() {
            return {
                pageStatus: 'page-load',
                data: null,
            }
        },
        computed: {
            maxCountFamily() {
                let response = 0;

                if (this.$route.query.type == 'default') {
                    for (let i = 0; i < this.data.keluarga.length; i++) {
                        if (this.data.keluarga[i].keluarga) {
                            if (response < this.data.keluarga[i].keluarga.length) {
                                response = this.data.keluarga[i].keluarga.length;
                            }
                        }

                    }
                }

                return response;

            },
            maxCountSibling() {
                let response = 0;

                if (this.$route.query.type == 'default') {
                    for (let i = 0; i < this.data.keluarga.length; i++) {
                        if (this.data.keluarga[i].saudara) {
                            if (response < this.data.keluarga[i].saudara.length) {
                                response = this.data.keluarga[i].saudara.length;
                            }
                        }

                    }
                }

                return response;

            },
            maxCountPelayananDp5a() {
                let response = 0;

                if (this.$route.query.type == 'default') {
                    for (let i = 0; i < this.data.intervensi_dp3appkb.length; i++) {
                        if (this.data.intervensi_dp3appkb[i].pelayanan) {
                            if (response < this.data.intervensi_dp3appkb[i].pelayanan.length) {
                                response = this.data.intervensi_dp3appkb[i].pelayanan.length;
                            }
                        }

                    }
                }

                return response;

            },
            maxCountPelayananOpd() {
                let response = 0;

                if (this.$route.query.type == 'default') {
                    for (let i = 0; i < this.data.intervensi_opd.length; i++) {
                        if (this.data.intervensi_opd[i].pelayanan) {
                            if (response < this.data.intervensi_opd[i].pelayanan.length) {
                                response = this.data.intervensi_opd[i].pelayanan.length;
                            }
                        }

                    }
                }

                return response;

            }
        },
        mounted() {

            let formData = {
                is_download: 0,
                type: this.$route.query.type
            }

            if (this.$route.query.periode && this.$route.query.periode != 'all') {
                Object.assign(formData, {
                    periode: this.$route.query.periode
                });
            }

            if (this.$route.query.startDate) {
                Object.assign(formData, {
                    start_date: this.$route.query.startDate
                });
            }

            if (this.$route.query.endDate) {
                Object.assign(formData, {
                    end_date: this.$route.query.endDate
                });
            }

            if (this.$route.query.category) {
                Object.assign(formData, {
                    kategori: this.$route.query.category
                });
            }

            if (this.$route.query.problemType) {
                Object.assign(formData, {
                    id_tipe_permasalahan: this.$route.query.problemType
                });
            }

            if (this.$route.query.caseCategory) {
                Object.assign(formData, {
                    id_kategori_kasus: this.$route.query.caseCategory
                });
            }
            if (this.$route.query.subDistrict) {
                Object.assign(formData, {
                    id_kecamatan: this.$route.query.subDistrict
                });
            }
            if (this.$route.query.lastEducation) {
                Object.assign(formData, {
                    id_pendidikan_terakhir: this.$route.query.lastEducation
                });
            }

            Api().get(`laporan/kasus-klien`, {
                    params: formData
                })
                .then(response => {
                    this.data = response.data.data;
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).then(() => {
                    this.pageStatus = 'standby';
                });
        },
        methods: {}
    }

</script>

<style scoped>
    .wrapper-print {
        max-width: 1200px;
        width: 100%;
        display: block;
        margin: 50px auto;
        font-family: Arial !important
    }

    .box-print {
        background: #fff;
        padding: 30px;
    }

    table,
    th,
    td {
        border: 1px solid;
        font-size: 14px;
        padding: 5px;
    }

    table th {
        font-weight: 600;
        text-align: center;
    }

</style>
