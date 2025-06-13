<template>
    <div class="wrapper-print">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <button type="button"
                style="font-size:15px;border-radius:50px;background:#fff;color:black;padding:10px 25px;border:0 !important;"
                @click="$router.back()"><i class="fa fa-arrow-left" style="color:black"></i>&ensp;&ensp;Kembali</button>
            <div class="text-center" style="font-weight:600;font-size:24px">Laporan Hasil Penjangkauan</div>
            <div>
                <button type="button"
                    style="font-size:15px;border-radius:50px;background:#ee7b33;color:#fff;padding:10px 25px;border:0 !important;"
                    @click="generateReport"><i class="fa fa-file" style="color:#fff"></i>&ensp;&ensp;Unduh PDF</button>
            </div>
        </div>

        <div class="box-print">
            <div class="d-flex justify-content-center w-100" v-if="pageStatus == 'page-load'">
                <app-loader></app-loader>
            </div>
            <div class="box-container-print" v-else>
                <div style="border-bottom:4px black solid;padding-bottom:25px;margin-bottom:20px;">
                    <div class="d-flex justify-content-center">
                        <div>
                            <img :src="$assetUrl() + 'extends/img/pemkot-surabaya-hitam-putih.jpg'"
                                style="width:80px" />
                        </div>
                        <div class="text-center" style="padding-left:25px;">
                            <div style="font-size:18px;font-weight:700">PEMERINTAH KOTA SURABAYA</div>
                            <div style="font-size:18px;font-weight:700">DINAS PEMBERDAYAAN PEREMPUAN DAN<br>PERLINDUNGAN
                                ANAK SERTA PENGENDALIAN<br>PENDUDUK DAN KELUARGA BERENCANA</div>
                            <div>Jalan Kedungsari No. 18 Surabaya</div>
                            <div>Telp. (031) 5346317 Fax. (031) 5480904</div>
                        </div>
                    </div>
                </div>
                <table class="table-print table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="6">NOMOR REGISTER : {{complaint?.nomor_registrasi}}</td>
                        </tr>
                        <tr>
                            <td rowspan="4">PENGADUAN</td>
                            <td>HARI</td>
                            <td>{{complaint?.pengaduan?.hari}}</td>
                            <td rowspan="2">PETUGAS 1</td>
                            <td>NAMA</td>
                            <td>{{complaint?.petugas && complaint?.petugas.length > 0 ? complaint?.petugas[0].nama : ''}}
                            </td>
                        </tr>
                        <tr>
                            <td>TANGGAL</td>
                            <td>{{complaint?.pengaduan?.tanggal}}</td>
                            <td>NO HP</td>
                            <td>{{complaint?.petugas && complaint?.petugas.length > 0 ? complaint?.petugas[0].no_hp : ''}}
                            </td>
                        </tr>
                        <tr>
                            <td>WAKTU</td>
                            <td>{{complaint?.pengaduan?.waktu}}</td>
                            <td rowspan="2">PETUGAS 2</td>
                            <td>NAMA</td>
                            <td>{{complaint?.petugas && complaint?.petugas.length > 1 ? complaint?.petugas[1].nama : ''}}
                            </td>
                        </tr>
                        <tr>
                            <td>SUMBER ADUAN</td>
                            <td>{{complaint?.pengaduan?.sumber_aduan}}</td>
                            <td>NO HP</td>
                            <td>{{complaint?.petugas && complaint?.petugas.length > 1 ? complaint?.petugas[1].no_hp : ''}}
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="3">PENANGANAN AWAL</td>
                            <td>HARI</td>
                            <td>{{complaint?.penanganan_awal?.hari}}</td>
                            <td rowspan="3">TANGGAL PENJANGKAUAN / KONSELING</td>
                            <td>HARI</td>
                            <td>{{complaint?.tanggal_penjangkauan?.hari}}</td>
                        </tr>
                        <tr>
                            <td>TANGGAL</td>
                            <td>{{complaint?.penanganan_awal?.tanggal}}</td>
                            <td>TANGGAL</td>
                            <td>{{complaint?.tanggal_penjangkauan?.tanggal}}</td>
                        </tr>
                        <tr>
                            <td>WAKTU</td>
                            <td>{{complaint?.penanganan_awal?.waktu}}</td>
                            <td>WAKTU</td>
                            <td>{{complaint?.tanggal_penjangkauan?.waktu}}</td>
                        </tr>
                    </tbody>
                </table>
                <table
                    v-if="complaint?.data_pelapor || complaint?.data_klien || (complaint?.data_keluarga_klien ?? []).length > 0"
                    class="table-print table-bordered" style="margin-top:25px">
                    <tbody>
                        <template v-if="complaint?.data_pelapor">
                            <tr>
                                <td colspan="3"><b>DATA PELAPOR</b></td>
                            </tr>
                            <tr v-if="complaint?.data_pelapor?.nama_lengkap">
                                <td width="30%">Nama Lengkap</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_pelapor?.nama_lengkap}}</td>
                            </tr>
                            <tr v-if="complaint?.data_pelapor?.nik">
                                <td width="30%">NIK</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_pelapor?.nik}}</td>
                            </tr>
                            <tr v-if="complaint?.data_pelapor?.alamat_domisili">
                                <td width="30%">Alamat Domisili</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_pelapor?.alamat_domisili}}</td>
                            </tr>

                            <tr>
                                <td width="30%">Kabupaten/Kota</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_pelapor?.kabupaten ? complaint?.data_pelapor?.kabupaten : 'Surabaya'}}
                                </td>
                            </tr>
                            <tr v-if="complaint?.data_pelapor?.no_telepon">
                                <td width="30%">No. Telepon</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_pelapor?.no_telepon}}</td>
                            </tr>
                            <tr>
                                <td colspan="3">&ensp;</td>
                            </tr>
                        </template>
                        <template v-if="complaint?.data_klien">
                            <tr>
                                <td colspan="3"><b>DATA KLIEN</b></td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.nama_lengkap">
                                <td width="30%">Nama Lengkap</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.nama_lengkap}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.nik">
                                <td width="30%">NIK</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.nik}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.no_kk">
                                <td width="30%">No. KK</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.no_kk}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.ttl">
                                <td width="30%">TTL</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.ttl}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.usia">
                                <td width="30%">Usia</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.usia ?? '-'}} Tahun</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.jenis_kelamin">
                                <td width="30%">Jenis Kelamin</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.jenis_kelamin}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.agama">
                                <td width="30%">Agama</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.agama}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.pendidikan_terakhir">
                                <td width="30%">Pendidikan Terakhir</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.pendidikan_terakhir}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.pekerjaan">
                                <td width="30%">Pekerjaan</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.pekerjaan}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.status_pernikahan">
                                <td width="30%">Status Pernikahan</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.status_pernikahan}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.alamat_kk">
                                <td width="30%">Alamat KK</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.alamat_kk}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.alamat_domisili">
                                <td width="30%">Alamat Domisili</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.alamat_domisili}}</td>
                            </tr>
                            <tr v-if="complaint?.data_klien?.no_telepon">
                                <td width="30%">No. Telepon</td>
                                <td width="4%" class="text-center">:</td>
                                <td>{{complaint?.data_klien?.no_telepon}}</td>
                            </tr>
                        </template>
                        <template v-if="(complaint?.data_keluarga_klien ?? []).length > 0">
                            <tr>
                                <td colspan="3">&ensp;</td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>DATA KELUARGA KLIEN</b></td>
                            </tr>
                            <template v-for="(context,index) in complaint?.data_keluarga_klien ?? []">
                                <tr v-if="context.nama_lengkap">
                                    <td width="30%">Nama Lengkap</td>
                                    <td width="4%" class="text-center">:</td>
                                    <td>{{context.nama_lengkap}}</td>
                                </tr>
                                <tr v-if="context.nik">
                                    <td width="30%">NIK</td>
                                    <td width="4%" class="text-center">:</td>
                                    <td>{{context.nik}}</td>
                                </tr>
                                <tr v-if="context.alamat_kk">
                                    <td width="30%">Alamat KK</td>
                                    <td width="4%" class="text-center">:</td>
                                    <td>{{context.alamat_kk}}</td>
                                </tr>
                                <tr v-if="context.alamat_domisili">
                                    <td width="30%">Alamat Domisili</td>
                                    <td width="4%" class="text-center">:</td>
                                    <td>{{context.alamat_domisili}}</td>
                                </tr>
                                <tr v-if="context.pekerjaan">
                                    <td width="30%">Pekerjaan</td>
                                    <td width="4%" class="text-center">:</td>
                                    <td>{{context.pekerjaan}}</td>
                                </tr>
                                <tr v-if="context.hubungan_dengan_klien">
                                    <td width="30%">Hubungan Dengan Klien</td>
                                    <td width="4%" class="text-center">:</td>
                                    <td>{{context.hubungan_dengan_klien}}</td>
                                </tr>
                                <tr v-if="context.no_telepon">
                                    <td width="30%">No. Telepon</td>
                                    <td width="4%" class="text-center">:</td>
                                    <td>{{context.no_telepon}}</td>
                                </tr>
                                <tr v-if="index != (complaint?.data_keluarga_klien.length - 1)">
                                    <td colspan="3">&ensp;</td>
                                </tr>
                            </template>
                        </template>
                    </tbody>
                </table>
                <table v-if="complaint?.data_pelaku" class="table-print table-bordered" style="margin-top:25px">
                    <tbody>
                        <tr>
                            <td colspan="3"><b>DATA PELAKU</b></td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.nama_lengkap">
                            <td width="30%">Nama Lengkap</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.nama_lengkap}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.nik">
                            <td width="30%">NIK</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.nik}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.no_kk">
                            <td width="30%">No. KK</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.no_kk}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.ttl">
                            <td width="30%">TTL</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.ttl}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.usia">
                            <td width="30%">Usia</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.usia ?? '-'}} Tahun</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.jenis_kelamin">
                            <td width="30%">Jenis Kelamin</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.jenis_kelamin}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.agama">
                            <td width="30%">Agama</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.agama}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.pendidikan_terakhir">
                            <td width="30%">Pendidikan Terakhir</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.pendidikan_terakhir}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.pekerjaan">
                            <td width="30%">Pekerjaan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.pekerjaan}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.status_pernikahan">
                            <td width="30%">Status Pernikahan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.status_pernikahan}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.alamat_kk">
                            <td width="30%">Alamat KK</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.alamat_kk}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.alamat_domisili">
                            <td width="30%">Alamat Domisili</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.alamat_domisili}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.kewarganegaraan">
                            <td width="30%">Kewarganegaraan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.kewarganegaraan}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.nomor_telepon">
                            <td width="30%">Nomor Telepon</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.nomor_telepon}}</td>
                        </tr>
                        <tr v-if="complaint?.data_pelaku?.hubungan_pelaku">
                            <td width="30%">Hubungan Pelaku dengan Klien</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_pelaku?.hubungan_pelaku}}</td>
                        </tr>
                    </tbody>
                </table>
                <table
                    v-if="complaint?.data_kasus?.jenis_klien || complaint?.data_kasus?.kategori_klien || complaint?.data_kasus?.tipe_permasalahan || complaint?.data_kasus?.kategori_kasus || complaint?.data_kasus?.jenis_kasus || complaint?.data_kasus?.deskripsi || complaint?.data_kasus?.lokasi_kejadian || complaint?.data_kasus?.tanggal_dan_waktu"
                    class="table-print table-bordered" style="margin-top:25px">
                    <tbody>
                        <tr>
                            <td colspan="3"><b>DATA KASUS</b></td>
                        </tr>
                        <tr v-if="complaint?.data_kasus?.jenis_klien">
                            <td width="30%">Jenis Klien</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_kasus?.jenis_klien}}</td>
                        </tr>
                        <tr v-if="complaint?.data_kasus?.kategori_klien">
                            <td width="30%">Kategori Klien</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_kasus?.kategori_klien}}</td>
                        </tr>
                        <tr v-if="complaint?.data_kasus?.tipe_permasalahan">
                            <td width="30%">Tipe Permasalahan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_kasus?.tipe_permasalahan}}</td>
                        </tr>
                        <tr v-if="complaint?.data_kasus?.kategori_kasus">
                            <td width="30%">Kategori Kasus</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_kasus?.kategori_kasus}}</td>
                        </tr>
                        <tr v-if="complaint?.data_kasus?.jenis_kasus">
                            <td width="30%">Jenis Kasus</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_kasus?.jenis_kasus}}</td>
                        </tr>
                        <tr v-if="complaint?.data_kasus?.deskripsi">
                            <td width="30%">Deskripsi Singkat Kasus</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_kasus?.deskripsi}}</td>
                        </tr>
                        <tr v-if="complaint?.data_kasus?.lokasi_kejadian">
                            <td width="30%">Lokasi Kejadian</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_kasus?.lokasi_kejadian}}</td>
                        </tr>
                        <tr v-if="complaint?.data_kasus?.tanggal_dan_waktu">
                            <td width="30%">Tanggal dan Waktu Kejadian</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.data_kasus?.tanggal_dan_waktu}}</td>
                        </tr>
                    </tbody>
                </table>
                <table v-if="complaint?.situasi_keluarga || complaint?.kronologis_kejadian || complaint?.harapan_klien"
                    class="table-print table-bordered" style="margin-top:25px">
                    <tbody>
                        <template v-if="complaint?.situasi_keluarga">
                            <tr>
                                <td colspan="3"><b>SITUASI KELUARGA</b></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div style="min-height:150px">
                                        <div v-html="complaint?.situasi_keluarga"></div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template v-if="complaint?.kronologis_kejadian">
                            <tr>
                                <td colspan="3"><b>KRONOLOGI KEJADIAN</b></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div style="min-height:150px">
                                        <div v-html="complaint?.kronologis_kejadian"></div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template v-if="complaint?.harapan_klien">
                            <tr>
                                <td colspan="3"><b>HARAPAN KLIEN DAN KELUARGA</b></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div style="min-height:150px">
                                        <div v-html="complaint?.harapan_klien"></div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <table
                    v-if="complaint?.kondisi_klien?.fisik || complaint?.kondisi_klien?.psikologis || complaint?.kondisi_klien?.sosial || complaint?.kondisi_klien?.spiritual || (complaint?.rencana_analisis ?? []).length > 0 || (complaint?.rencana_rujukan ?? []).length > 0"
                    class="table-print table-bordered" style="margin-top:25px">
                    <tbody>
                        <tr>
                            <td colspan="3"><b>KONDISI KLIEN</b></td>
                        </tr>
                        <tr v-if="complaint?.kondisi_klien?.fisik">
                            <td width="30%">Fisik</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.kondisi_klien?.fisik}}</td>
                        </tr>
                        <tr v-if="complaint?.kondisi_klien?.psikologis">
                            <td width="30%">Psikologis</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.kondisi_klien?.psikologis}}</td>
                        </tr>
                        <tr v-if="complaint?.kondisi_klien?.sosial">
                            <td width="30%">Sosial</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.kondisi_klien?.sosial}}</td>
                        </tr>
                        <tr v-if="complaint?.kondisi_klien?.spiritual">
                            <td width="30%">Spiritual</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{complaint?.kondisi_klien?.spiritual}}</td>
                        </tr>
                        <tr
                            v-if="complaint?.kondisi_klien?.spiritual || complaint?.kondisi_klien?.sosial || complaint?.kondisi_klien?.psikologis">
                            <td colspan="3">&ensp;</td>
                        </tr>
                        <template v-if="(complaint?.rencana_analisis ?? []).length > 0">
                            <tr>
                                <td colspan="3"><b>RENCANA ANALISIS KEBUTUHAN KLIEN OLEH DP3KAPPKB</b></td>
                            </tr>
                            <template v-for="context in complaint?.rencana_analisis ?? []">
                                <tr>
                                    <td width="30%">{{context.name}}</td>
                                    <td width="4%" class="text-center">:</td>
                                    <td>{{context.deskripsi}}</td>
                                </tr>
                            </template>
                        </template>
                        <template v-if="(complaint?.rencana_rujukan ?? []).length > 0">
                            <tr>
                                <td colspan="3">&ensp;</td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>RENCANA RUJUKAN KEBUTUHAN KLIEN</b></td>
                            </tr>
                            <template v-for="context in complaint?.rencana_rujukan ?? []">
                                <tr>
                                    <td width="30%">{{context.name}}</td>
                                    <td width="4%" class="text-center">:</td>
                                    <td>{{context.deskripsi}}</td>
                                </tr>
                            </template>
                        </template>
                    </tbody>
                </table>
                <table v-if="(complaint?.langkah_dilakukan_dp3appkb ?? []).length > 0"
                    class="table-print table-bordered" style="margin-top:25px">
                    <tbody>
                        <tr>
                            <td colspan="3"><b>LANGKAH YANG TELAH DILAKUKAN DP3APPKB</b></td>
                        </tr>
                        <tr>
                            <td class="text-center">Tanggal Pelayanan</td>
                            <td class="text-center">Pelayanan Yang Diberikan</td>
                            <td class="text-center">Deskripsi Pelayanan</td>
                        </tr>
                        <template v-for="context in complaint?.langkah_dilakukan_dp3appkb ?? []">
                            <tr>
                                <td>{{context.tanggal_pelayanan}}</td>
                                <td>{{context.pelayanan_diberikan}}</td>
                                <td><div v-html="context.deskripsi"></div></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                
                <table v-if="(complaint?.langkah_dilakukan_cek ?? []).length > 0" class="table-print table-bordered"
                    style="margin-top:25px;margin-bottom:50px;">
                    <tbody>
                        <tr>
                            <td colspan="4"><b>LANGKAH YANG TELAH DILAKUKAN</b></td>
                        </tr>
                        <tr>
                            <td class="text-center">Tanggal Pelayanan</td>
                            <td class="text-center">Instansi</td>
                            <td class="text-center">Pelayanan Yang Diberikan</td>
                            <td class="text-center">Deskripsi Pelayanan</td>
                        </tr>
                        <template v-for="context in complaint?.langkah_dilakukan_cek ?? []">
                            <tr>
                                <td>{{context.tanggal_pelayanan}}</td>
                                <td>{{context.instansi}}</td>
                                <td>{{context.pelayanan_diberikan}}</td>
                                <td>{{context.deskripsi}}</td>
                            </tr>
                        </template>
                    </tbody>
                </table>    
                <div style="display:flex; justify-content:flex-end;margin-top:30px;">
                    <div style="width:300px;margin-right:50px;text-align:center;font-size:15px;">
                        <div>Surabaya, {{$moment().locale('id').format('DD MMMM YYYY')}}</div>
                        <div>KEPALA DINAS,</div>                       
                        <div style="text-decoration:underline;padding-top:80px">{{complaint.ttd_kadis.nama}}</div>
                        <div>{{complaint.ttd_kadis.jabatan}}</div>
                        <div>NIP {{complaint.ttd_kadis.nip}}</div>
                    </div>
                </div>
            
                <template
                    v-if="(complaint?.dokumen_pendukung?.foto_klien ?? []).length > 0 || (complaint?.dokumen_pendukung?.foto_identitas_klien ?? []).length > 0 || (complaint?.dokumen_pendukung?.foto_tempat_tinggal_klien ?? []).length > 0 || (complaint?.dokumen_pendukung?.foto_pendampingan_awal_klien ?? []).length > 0 || (complaint?.dokumen_pendukung?.foto_pendampingan_lanjutan_klien ?? []).length > 0 || (complaint?.dokumen_pendukung?.foto_pendampingan_monitoring_klien ?? []).length > 0">                    
                    <div style="font-size:15px"><b>Dokumen Pendukung</b></div>
                    <table class="table-print table-bordered" style="margin-top:25px">
                        <tbody>
                            <tr v-if="(complaint?.dokumen_pendukung?.foto_klien ?? []).length > 0">
                                <td>
                                    <div style="padding-bottom:5px"><b>Foto Klien</b></div>
                                    <div style="display:flex;flex-wrap:wrap;justify-content:center;">
                                        <div style="width:50%;padding:10px;"
                                            v-for="context in complaint?.dokumen_pendukung?.foto_klien ?? []">
                                            <img :src="context.path" style="height:200px;width:100%" />
                                            <div style="padding-top:20px;text-align:center">{{context.name}}</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="(complaint?.dokumen_pendukung?.foto_identitas_klien ?? []).length > 0">
                                <td>
                                    <div style="padding-bottom:5px"><b>Foto Identitas Klien(KK)</b></div>
                                    <div style="display:flex;flex-wrap:wrap;justify-content:center;">
                                        <div style="width:50%;padding:10px;"
                                            v-for="context in complaint?.dokumen_pendukung?.foto_identitas_klien ?? []">
                                            <img :src="context.path" style="height:200px;width:100%" />
                                            <div style="padding-top:20px;text-align:center">{{context.name}}</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="(complaint?.dokumen_pendukung?.foto_tempat_tinggal_klien ?? []).length > 0">
                                <td>
                                    <div style="padding-bottom:5px"><b>Foto Tempat Tinggal Klien</b></div>
                                    <div style="display:flex;flex-wrap:wrap;padding:10px;justify-content:center;">
                                        <div style="width:50%;padding:10px;"
                                            v-for="context in complaint?.dokumen_pendukung?.foto_tempat_tinggal_klien ?? []">
                                            <img :src="context.path" style="height:200px;width:100%" />
                                            <div style="padding-top:20px;text-align:center">{{context.name}}</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <template
                                v-if="(complaint?.dokumen_pendukung?.foto_pendampingan_awal_klien ?? []).length > 0 || (complaint?.dokumen_pendukung?.foto_pendampingan_lanjutan_klien ?? []).length > 0 || (complaint?.dokumen_pendukung?.foto_pendampingan_monitoring_klien ?? []).length > 0 || (complaint?.dokumen_pendukung?.surat ?? []).length > 0">
                                <tr
                                    v-if="(complaint?.dokumen_pendukung?.foto_pendampingan_awal_klien ?? []).length > 0">
                                    <td colspan="3"><b>Foto Pendampingan :</b></td>
                                </tr>
                                <tr
                                    v-if="(complaint?.dokumen_pendukung?.foto_pendampingan_awal_klien ?? []).length > 0">
                                    <td>
                                        <div style="padding-bottom:5px; "><b>Pendampingan Awal(Penjangkauan)</b>
                                        </div>
                                        <div style="display:flex;flex-wrap:wrap;padding:10px;justify-content:center;">
                                            <div style="width:50%;padding:10px;"
                                                v-for="context in complaint?.dokumen_pendukung?.foto_pendampingan_awal_klien ?? []">
                                                <img :src="context.path" style="height:200px;width:100%" />
                                                <div style="padding-top:20px;text-align:center">{{context.name}}</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr
                                    v-if="(complaint?.dokumen_pendukung?.foto_pendampingan_lanjutan_klien ?? []).length > 0">
                                    <td>
                                        <div style="padding-bottom:5px; "><b>Pendampingan
                                                Lanjutan(Psikologis/Medis/Hukum)</b></div>
                                        <div style="display:flex;flex-wrap:wrap;padding:10px;justify-content:center;">
                                            <div style="width:50%;padding:10px;"
                                                v-for="context in complaint?.dokumen_pendukung?.foto_pendampingan_lanjutan_klien ?? []">
                                                <img :src="context.path" style="height:200px;width:100%" />
                                                <div style="padding-top:20px;text-align:center">{{context.name}}</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr
                                    v-if="(complaint?.dokumen_pendukung?.foto_pendampingan_monitoring_klien ?? []).length > 0">
                                    <td>
                                        <div style="padding-bottom:5px; "><b>Monitoring</b></div>
                                        <div style="display:flex;flex-wrap:wrap;padding:10px;justify-content:center;">
                                            <div style="width:50%;padding:10px;"
                                                v-for="context in complaint?.dokumen_pendukung?.foto_pendampingan_monitoring_klien ?? []">
                                                <img :src="context.path" style="height:200px;width:100%" />
                                                <div style="padding-top:20px;text-align:center">{{context.name}}</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="(complaint?.dokumen_pendukung?.surat ?? []).length > 0">
                                    <td>
                                        <div style="padding-bottom:5px; "><b>Dokumen Pendukung</b></div>
                                        <iframe v-for="pdf in complaint?.dokumen_pendukung?.surat" :src="pdf.path"
                                            style="width:100%;height:500px;margin-bottom:20px;"></iframe>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
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
                complaint: null,
            }
        },
        mounted() {

            Api().get(`pengaduan/${this.$route.params.id}/cetak`)
                .then(response => {
                    this.complaint = response.data.data;
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                }).then(() => {
                    this.pageStatus = 'standby';
                });
        },
        methods: {
            generateReport() {
                this.$ewpLoadingShow();
                Api().get(`pengaduan/${this.$route.params.id}/cetak-pdf`, {
                    responseType: 'blob',
                }).then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'Laporan Hasil Penjangkauan.pdf');
                    document.body.appendChild(link);
                    link.click();
                }).catch(error => {
                    this.$axiosHandleError(error);
                }).then(() => {
                    this.$ewpLoadingHide();
                });

            },
        }
    }

</script>

<style scoped>
    .wrapper-print {
        max-width: 1000px;
        width: 100%;
        display: block;
        margin: 50px auto;
        font-family: Arial !important
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
        font-size: 15PX;
        page-break-inside: avoid;
    }

    .table-print tr {
        page-break-inside: avoid;
        page-break-after: auto
    }

</style>
