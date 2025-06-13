<template>
    <div class="wrapper-print" style="position:relative;">
        <div class="d-flex justify-content-center align-items-center mb-5">
            <button type="button"
                style="font-size:15px;border-radius:50px;background:#fff;color:black;padding:10px 25px;border:0 !important;position:absolute;left:0;top:0"
                @click="$router.back()"><i class="fa fa-arrow-left" style="color:black"></i>&ensp;&ensp;Kembali</button>
            <div class="text-center" style="font-weight:600;font-size:24px">
                {{type == 'year' ? 'DATA LAPORAN REKAPITULASI KASUS (TAHUNAN)' : 'DATA LAPORAN REKAPITULASI KASUS (BULANAN)'}}
            </div>
            <div></div>
        </div>

        <div class="box-print mt-10">
            <div class="d-flex justify-content-center w-100" v-if="pageStatus == 'page-load'">
                <app-loader></app-loader>
            </div>
            <div class="box-container-print" v-else>
                <template v-if="type == 'year'">
                    <div class="table-responsive">
                        <table cellspacing="0" :style="minWidthTableYear">
                            <thead>
                                <tr>
                                    <th
                                        style="width:300px;background-color: #7e7e7e !important;text-align:left !important;">
                                        TIPE PERMASALAHAN
                                    </th>
                                    <th v-if="listTableHeadYear.length > 0"
                                        style="background-color: #7e7e7e !important;text-align:center !important;"
                                        :colspan="listTableHeadYear.length * 3">Tahun
                                    </th>
                                    <th rowspan="3" style="width:200px">Grand Total</th>
                                </tr>
                                <tr>
                                    <th
                                        style="width:300px;background-color: #7e7e7e !important;text-align:left !important;padding-left:15px;">
                                        KATEGORI
                                        KASUS
                                    </th>
                                    <template v-for="context in listTableHeadYear">
                                        <th colspan="2" style="width:300px">{{context}}</th>
                                        <th rowspan="2" style="width:200px">{{context}} Total</th>
                                    </template>
                                </tr>
                                <tr>
                                    <th
                                        style="width:300px;background-color: #7e7e7e !important;text-align:left !important;padding-left:30px;">
                                        JENIS
                                        KASUS
                                    </th>
                                    <template v-for="context in listTableHeadYear">
                                        <th style="width:150px;position:static !important;">ANAK</th>
                                        <th style="width:150px;position:static !important;">DEWASA</th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="tipe in dataTahunan">
                                    <tr style="background-color:#a6a6a6">
                                        <td style="color:black;font-weight:bold;background-color: #a6a6a6 !important;">
                                            {{tipe.name}}
                                        </td>
                                        <template v-for="yearTipe in tipe.tahun">
                                            <td style="color:black;font-weight:bold;" class="text-center">
                                                {{$rupiahFormat(yearTipe.anak)}}
                                            </td>
                                            <td style="color:black;font-weight:bold;" class="text-center">
                                                {{$rupiahFormat(yearTipe.dewasa)}}
                                            </td>
                                            <td style="color:black;font-weight:bold;" class="text-center">
                                                {{$rupiahFormat(yearTipe.total)}}
                                            </td>
                                        </template>
                                        <td style="color:black;font-weight:bold;" class="text-center">
                                            {{$rupiahFormat(tipe.grand_total)}}
                                        </td>
                                    </tr>

                                    <template v-for="kategori in tipe.kategori_kasus">
                                        <tr style="background-color:#d9d9d9">
                                            <td style="padding-left:15px;background-color: #d9d9d9">{{kategori.name}}
                                            </td>
                                            <template v-for="yearKategori in kategori.tahun">
                                                <td class="text-center">{{$rupiahFormat(yearKategori.anak)}}</td>
                                                <td class="text-center">{{$rupiahFormat(yearKategori.dewasa)}}</td>
                                                <td class="text-center">{{$rupiahFormat(yearKategori.total)}}</td>
                                            </template>
                                            <td class="text-center">{{$rupiahFormat(kategori.grand_total)}}</td>
                                        </tr>

                                        <template v-for="jenis in kategori.jenis_kasus">
                                            <tr style="background-color:#f2f0f0">
                                                <td style="padding-left:30px;background-color: #f2f0f0">{{jenis.name}}
                                                </td>
                                                <template v-for="yearJenis in jenis.tahun">
                                                    <td class="text-center">{{$rupiahFormat(yearJenis.anak)}}</td>
                                                    <td class="text-center">{{$rupiahFormat(yearJenis.dewasa)}}</td>
                                                    <td class="text-center">{{$rupiahFormat(yearJenis.total)}}</td>
                                                </template>
                                                <td class="text-center">{{$rupiahFormat(jenis.grand_total)}}</td>
                                            </tr>
                                        </template>
                                    </template>
                                </template>
                                <tr v-if="dataTahunan.length > 0">
                                    <td style="background:#fff !important;font-weight:bold;">Grand Total</td>
                                    <template v-for="(yearParent, index) in dataTahunan[0].tahun">
                                        <td style="color:black;font-weight:bold;background:#fff" class="text-center">
                                            {{$rupiahFormat(getGrandTotal('anak',index))}}
                                        </td>
                                        <td style="color:black;font-weight:bold;background:#fff" class="text-center">
                                            {{$rupiahFormat(getGrandTotal('dewasa',index))}}
                                        </td>
                                        <td style="color:black;font-weight:bold;background:#fff" class="text-center">
                                            {{$rupiahFormat(getGrandTotal('yearTotal',index))}}
                                        </td>
                                    </template>
                                    <td style="color:black;font-weight:bold;background:#fff" class="text-center">
                                        {{$rupiahFormat(getGrandTotal('grandTotal'))}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </template>
                <template v-else>
                    <div class="table-responsive">
                        <table cellspacing="0" :style="minWidthTableMonth">
                            <thead>
                                <tr>
                                    <th
                                        style="width:300px;background-color: #7e7e7e;color:#fff;text-align:left;font-weight:bold;">
                                        TIPE PERMASALAHAN</th>
                                    <th style="text-align:left;font-weight:bold;background-color: #7e7e7e;color:#fff;text-align:center;" v-if="listTableHeadMonth.length > 0"
                                        rowspan="2" :colspan="listTableHeadMonth.length">Bulan</th>
                                    <th rowspan="3"
                                        style="background-color: #7e7e7e;color:#fff;text-align:center;font-weight:bold;">
                                        GRAND TOTAL</th>
                                </tr>
                                <tr>
                                    <th
                                        style="width:300px;background-color: #7e7e7e;color:#fff;text-align:left;font-weight:bold;padding-left:15px;">
                                        KATEGORI KASUS</th>
                                </tr>
                                <tr>
                                    <th
                                        style="width:300px;background-color: #7e7e7e;color:#fff;text-align:left;font-weight:bold;padding-left:30px;">
                                        JENIS KASUS</th>
                                    <template v-for="context in listTableHeadMonth">
                                        <th
                                            style="background-color: #7e7e7e;color:#fff;text-align:center;font-weight:bold;">
                                            {{context.bulan}} {{context.tahun}}</th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="tipe in dataBulanan">
                                    <tr>
                                        <td style="background-color:#a6a6a6;font-weight:bold;">{{tipe.name}}</td>
                                        <template v-for="tipeBulan in tipe.bulan">
                                            <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                                                {{tipeBulan.count}}</td>
                                        </template>
                                        <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                                            {{tipe.grand_total}}</td>
                                    </tr>

                                    <template v-if="tipe.anak">
                                        <tr>
                                            <td style="background-color:#a6a6a6;font-weight:bold;padding-left:15px;">
                                                ANAK</td>
                                            <template v-for="tipeAnakBulan in tipe.anak.bulan">
                                                <td
                                                    style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                                                    {{tipeAnakBulan.count}}</td>
                                            </template>
                                            <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                                                {{tipe.anak.grand_total}}</td>
                                        </tr>

                                        <template v-for="kategoriAnak in tipe.anak.kategori_kasus">
                                            <tr>
                                                <td style="background-color:#d9d9d9;padding-left: 30px;">
                                                    {{kategoriAnak.name}}</td>
                                                <template v-for="kategoriAnakBulan in kategoriAnak.bulan">
                                                    <td style="background-color:#d9d9d9;text-align:center;">
                                                        {{kategoriAnakBulan.count}}</td>
                                                </template>
                                                <td
                                                    style="background-color:#d9d9d9;font-weight:bold;text-align:center;">
                                                    {{kategoriAnak.grand_total}}</td>
                                            </tr>

                                            <template v-for="jenisAnak in kategoriAnak.jenis_kasus">
                                                <tr>
                                                    <td style="background-color:#f2f0f0;padding-left: 45px;">
                                                        {{jenisAnak.name}}</td>
                                                    <template v-for="jenisAnakBulan in jenisAnak.bulan">
                                                        <td style="background-color:#f2f0f0;text-align:center;">
                                                            {{jenisAnakBulan.count}}</td>
                                                    </template>
                                                    <td
                                                        style="background-color:#f2f0f0;font-weight:bold;text-align:center;">
                                                        {{jenisAnak.grand_total}}</td>
                                                </tr>
                                            </template>
                                        </template>
                                    </template>
                                    <template v-if="tipe.dewasa">
                                        <tr>
                                            <td style="background-color:#a6a6a6;font-weight:bold;padding-left: 15px;">
                                                DEWASA</td>
                                            <template v-for="tipeDewasaBulan in tipe.dewasa.bulan">
                                                <td
                                                    style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                                                    {{tipeDewasaBulan.count}}</td>
                                            </template>
                                            <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                                                {{tipe.dewasa.grand_total}}</td>
                                        </tr>

                                        <template v-for="kategoriDewasa in tipe.dewasa.kategori_kasus">
                                            <tr>
                                                <td style="background-color:#d9d9d9;padding-left: 30px;">
                                                    {{kategoriDewasa.name}}</td>
                                                <template v-for="kategoriDewasaBulan in kategoriDewasa.bulan">
                                                    <td style="background-color:#d9d9d9;text-align:center;">
                                                        {{kategoriDewasaBulan.count}}</td>
                                                </template>
                                                <td
                                                    style="background-color:#d9d9d9;font-weight:bold;text-align:center;">
                                                    {{kategoriDewasa.grand_total}}</td>
                                            </tr>

                                            <template v-for="jenisDewasa in kategoriDewasa.jenis_kasus">
                                                <tr>
                                                    <td style="background-color:#f2f0f0;padding-left: 45px;">
                                                        {{jenisDewasa.name}}</td>
                                                    <template v-for="jenisDewasaBulan in jenisDewasa.bulan">
                                                        <td style="background-color:#f2f0f0;text-align:center;">
                                                            {{jenisDewasaBulan.count}}</td>
                                                    </template>
                                                    <td
                                                        style="background-color:#f2f0f0;font-weight:bold;text-align:center;">
                                                        {{jenisDewasa.grand_total}}</td>
                                                </tr>
                                            </template>
                                        </template>
                                    </template>
                                </template>
                                <tr v-if="dataBulanan.length > 0">
                                    <td style="background:#fff !important;font-weight:bold;">Grand Total</td>
                                    <template v-for="(yearParent, index) in dataBulanan[0].bulan">
                                        <td style="color:black;font-weight:bold;background:#fff" class="text-center">
                                            {{$rupiahFormat(getGrandTotalMonth(index))}}
                                        </td>
                                    </template>
                                    <td style="color:black;font-weight:bold;background:#fff" class="text-center">
                                        {{$rupiahFormat(getGrandTotalMonth())}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                type: '',
                dataTahunan: [],
                dataBulanan: [],
                dataBulananDewasa: []
            }
        },
        computed: {
            listTableHeadYear() {
                let response = [];

                if (this.dataTahunan.length > 0) {
                    for (let i = 0; i < this.dataTahunan[0].tahun.length; i++) {
                        response.push(this.dataTahunan[0].tahun[i].tahun)
                    }
                }

                return response;

            },
            listTableHeadMonth() {
                let response = [];

                if (this.dataBulanan.length > 0) {
                    for (let i = 0; i < this.dataBulanan[0].bulan.length; i++) {
                        response.push(this.dataBulanan[0].bulan[i])
                    }
                }

                return response;

            },
            minWidthTableYear() {
                if (this.listTableHeadYear.length > 1) {
                    let minWidthYear = (500 * this.listTableHeadYear.length) + 500;

                    return "min-width:" + minWidthYear + 'px !important;'
                }

                return 'width:100% !important';
            },
            minWidthTableMonth() {
                if (this.listTableHeadMonth.length > 5) {
                    let minWidthYear = (150 * this.listTableHeadMonth.length) + 500;

                    return "min-width:" + minWidthYear + 'px !important;'
                }

                return 'width:100% !important';
            }
        },
        mounted() {

            this.type = this.$route.query.type;
            if (this.$route.query.type == 'year') {
                this.getDataYear();
            } else if (this.$route.query.type == 'month') {
                this.getDataMonth();
            }

        },
        methods: {
            getDataYear() {
                let formData = {
                    is_download: 0
                }

                if (this.$route.query.startYear) {
                    Object.assign(formData, {
                        tahun_awal: this.$route.query.startYear
                    });
                }

                if (this.$route.query.endYear) {
                    Object.assign(formData, {
                        tahun_akhir: this.$route.query.endYear
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

                Api().get(`laporan/rekap-tahunan`, {
                        params: formData
                    })
                    .then(response => {
                        this.dataTahunan = response.data.data;
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    });
            },
            getDataMonth() {
                let formData = {
                    is_download: 0
                }


                if (this.$route.query.startMonth) {
                    Object.assign(formData, {
                        bulan_awal: this.$route.query.startMonth
                    });
                }

                if (this.$route.query.endMonth) {
                    Object.assign(formData, {
                        bulan_akhir: this.$route.query.endMonth
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

                Api().get(`laporan/rekap-bulanan`, {
                        params: formData
                    })
                    .then(response => {
                        this.dataBulanan = response.data.data;
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    });
            },
            getGrandTotal(type, index) {
                let response = 0;

                if (type == 'grandTotal') {
                    for (let i = 0; i < this.dataTahunan.length; i++) {
                        response += this.dataTahunan[i].grand_total;
                    }
                } else {
                    for (let i = 0; i < this.dataTahunan.length; i++) {
                        for (let x = 0; x < this.dataTahunan[i].tahun.length; x++) {
                            if (index == x) {
                                if (type == 'anak') {
                                    response += parseInt(this.dataTahunan[i].tahun[x].anak);
                                } else if (type == 'dewasa') {
                                    response += parseInt(this.dataTahunan[i].tahun[x].dewasa);
                                } else if (type == 'yearTotal') {
                                    response += parseInt(this.dataTahunan[i].tahun[x].total);
                                }
                            }

                        }
                    }
                }

                return response;
            },
            getGrandTotalMonth(index = null) {
                let response = 0;

                if (index === null) {
                    for (let i = 0; i < this.dataBulanan.length; i++) {
                        response += this.dataBulanan[i].grand_total;
                    }
                } else {
                    for (let i = 0; i < this.dataBulanan.length; i++) {
                        for (let x = 0; x < this.dataBulanan[i].bulan.length; x++) {
                            if (index == x) {
                                response += parseInt(this.dataBulanan[i].bulan[x].count);
                            }

                        }
                    }
                }

                return response;
            },
        }
    }

</script>

<style scoped>
    .wrapper-print {
        max-width: 1100px;
        width: 100%;
        display: block;
        margin: 50px auto;
        font-family: Arial !important
    }

    table {
        min-width: 100%;
    }

    table thead tr {
        background-color: #7e7e7e !important;

    }

    table thead tr th {
        vertical-align: middle;
        color: #fff;
    }

    table,
    th,
    td {
        border: 1px #8e8e8e solid !important;
        font-size: 14px;
        padding: 5px;
    }

    table th {
        font-weight: 600;
        text-align: center;
    }

    table tr th:first-child {
        position: sticky;
        left: 0;
        z-index: 2;
    }

    table tr td:first-child {
        position: sticky;
        left: 0;
        z-index: 2;
    }

</style>
