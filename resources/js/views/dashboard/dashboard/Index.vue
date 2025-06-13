<template>
    <div>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <app-navbar></app-navbar>
                    <!-- isi contentnya ya -->
                    <div id="main-content">
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-xxl">
                                <div class="row">
                                    <div class="col-lg-8 mb-5">
                                        <h1 class="pt-5 fw-bolder" style="font-size:28px;">Dashboard</h1>
                                        <div class="text-gray-600">Trend dan jumlah kasus kekerasan terdahap perempuan dan anak DP5A</div>
                                    </div>                                   
                                    <div class="col-lg-12 mb-5">
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card-header" style="border-bottom:0 !important;">
                                                        <h2 class="card-title fw-bolder" style="font-size:18px !important;flex-wrap: wrap;">Grafik Ketuntasan Penanganan OPD </h2>
                                                    </div>
                                                    <div class="card-body">
                                                        <div v-if="loader.grafikKetuntasanOpd == true" class="d-flex justify-content-center align-items-center mb-5">
                                                            <app-loader></app-loader>
                                                        </div>
                                                        <div v-else class="row align-items-center">
                                                            <div class="col-lg-7">
                                                                <app-chartjs-pie :chart-data="grafikKetuntasanOpdData" style="max-height:250px;"
                                                                :chart-options="grafikKetuntasanOpdOption"></app-chartjs-pie> 
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="d-flex">
                                                                    <div style="width:20px;height:20px">
                                                                        <div style="background:#50CD89;width:20px;height:20px;border-radius:100px"></div>
                                                                    </div>
                                                                    
                                                                    <div class="text-gray-700 " style="padding-left:10px;font-size:14px">Tuntas {{$rupiahFormat(dataKetuntasanOpd.tuntas)}} OPD</div>
                                                                </div>
                                                                <div class="d-flex mt-5">
                                                                    <div style="width:20px;height:20px">
                                                                        <div style="background:#F1416C;width:20px;height:20px;border-radius:100px"></div>
                                                                    </div>                                                                    
                                                                    <div class="text-gray-700 " style="padding-left:10px;font-size:14px">Tidak Tuntas {{$rupiahFormat(dataKetuntasanOpd.belum)}} OPD</div>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                     <div class="card-header d-flex align-items-center justify-content-between" style="border-bottom:0 !important;">
                                                        <div>
                                                            <h2 class="card-title fw-bolder " style="font-size:18px !important;flex-wrap: wrap;">Daftar OPD Belum Tuntas</h2>
                                                            <div><span style="color:#f1416c;" class="fw-bolder">{{OpdBelumTuntas}}</span> OPD belum tuntas menangani intervensi</div>
                                                        </div>
                                                        <router-link :to="{ name: 'dashboard-daftar-opd-belum-tuntas' }">
                                                            <button type="button" class="btn btn-sm text-white bg-primary-custom">
                                                                Lihat Semua
                                                            </button>
                                                        </router-link>
                                                    </div>
                                                    <div class="card-body">
                                                        <div v-if="loader.intervensiOpd == true" class="d-flex justify-content-center align-items-center mb-5">
                                                            <app-loader></app-loader>
                                                        </div>
                                                        <div v-else style="max-height:250px;overflow-y:auto;">
                                                            <div class="d-flex flex-column text-center justify-content-center align-items-center" v-if=" data?.intervensiOpd.length == 0">
                                                                <img :src="`${$assetUrl()}extends/img/empty.png`" />
                                                                <div class="text-gray-600 pt-5 text-center">
                                                                    Tidak ada data yang dapat ditampilkan
                                                                </div>
                                                            </div>
                                                            <template v-for="(context, index) in data.intervensiOpd" :key="index">
                                                                <div class="fw-bolder fs-4">{{context.opd_name}}</div>
                                                                <div class="c-primary-custom fw-bolder pb-3 ">{{$rupiahFormat(context.intervensi.length)}} Intervensi Kasus</div>
                                                                <template v-for="(detail, idxDetail) in context.intervensi" :key="idxDetail">
                                                                    <div class="row">
                                                                        <div class="col-lg-7 mb-5">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="me-3" style="width:25px;height:25px;">
                                                                                    <div class="text-white bg-primary  text-center d-flex justify-content-center align-items-center" style="border-radius:8px;width:25px;height:25px;font-size:10px !important;">
                                                                                        {{ idxDetail + 1 }}
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="text-primary fw-bolder c-pointer" style="border-bottom:1px #009ef7 solid;" @click="$router.push({ name: 'klien-history-kasus', params: { id: detail.client_id }})"> 
                                                                                        {{ $noNullable(detail.client_name) }}
                                                                                    </div>
                                                                                    <div>
                                                                                        {{ $noNullable(detail.intervention_name) }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5 mb-5 text-right">
                                                                            <div class="fw-bolder">Terakhir Diperbarui</div>
                                                                            <div class="text-gray-600" style="font-size:10px !important;">{{detail.date ? $moment(detail.date,'YYYY-MM-DD H:mm:ss').locale('id').format('DD-MM-YYYY HH:mm:ss') : '-'}}</div>
                                                                        </div>
                                                                    </div>
                                                                </template>
                                                            </template>                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-lg-12 mb-5">
                                        <div class="card">
                                            <div class="card-header pt-5" style="justify-content:space-between;flex-wrap:wrap;border-bottom:0 !important;">
                                                <div>
                                                    <h2 class="card-title fw-bolder " style="font-size:18px !important;flex-wrap: wrap;">
                                                        Trend Kasus Bulanan Semua Tipe Permasalahan </h2>
                                                    <div class="text-gray-600">Menampilkan jumlah kasus anak-anak maupun
                                                        dewasa setiap bulan.</div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-wrap align-items-center me-3">
                                                        <div style="background:#EE7B33;color:#fff;border-radius:5px;font-size:10px;"
                                                            class="px-3 py-1 me-2">Anak-anak</div>
                                                        <div style="background:#50CD89;color:#fff;border-radius:5px;font-size:10px;"
                                                            class="px-3 py-1">Dewasa</div>
                                                    </div>                                                    
                                                    <app-datepicker type="year" :format="'YYYY'" :value-type="'YYYY'" :clearable="false"
                                                        :style="'max-width:150px;'" v-model:value="single.filter.yearSection2" @change="getTrendKasus();">
                                                    </app-datepicker>
                                                    
                                                </div>
                                            </div>                                            
                                            <div class="card-body">                                               
                                                <div class="d-flex justify-content-center align-items-center my-10" v-if="loader.trendKasus">
                                                    <app-loader></app-loader>
                                                </div>
                                                <div class="w-100 mt-5" v-else>
                                                        <app-chartjs-line :chart-data="trenKasusChartData" class="w-100"
                                                            :chart-options="trenKasusChartOption"></app-chartjs-line>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-10">
                                                    <div class="col-lg-7">   
                                                        <div class="fw-bolder" style="font-size:17px;">Trend Kasus PerKecamatan Bulan
                                                    <span class="c-primary-custom">{{single.filter.monthSection3 ? $moment(single.filter.monthSection3, 'YYYY-MM').locale('id').format('MMMM YYYY') : '-'}}</span></div>                                                                                                             
                                                    <div class="text-gray-600">Menampilkan jumlah kasus perkecamatan dari tertinggi hingga terendah.</div>
                                                    </div>                                                                                                   
                                                    <div class="col-lg-5 d-flex flex-wrap justify-content-end">
                                                        <div class="d-flex flex-wrap align-items-center me-3">
                                                            <div style="background:#EE7B33;color:#fff;border-radius:5px;font-size:10px;"
                                                                class="px-3 py-1 me-2">Anak-anak</div>
                                                            <div style="background:#50CD89;color:#fff;border-radius:5px;font-size:10px;"
                                                                class="px-3 py-1">Dewasa</div>
                                                        </div>
                                                        <app-datepicker type="month" :format="'MM-YYYY'" :value-type="'YYYY-MM'" :clearable="false"
                                                            :style="'max-width:150px;'" v-model:value="single.filter.monthSection3" @change="getGrafikPerKecamatan">
                                                        </app-datepicker>
                                                    </div>
                                                </div>
                                                <div v-if="loader.kasusPerkecamatan == true" class="d-flex justify-content-center align-items-center mb-5">
                                                    <app-loader></app-loader>
                                                </div>
                                                <div  style="display:block;overflow-x:auto;" v-else>
                                                <app-chartjs-bar :chart-data="grafikPerkecamatanData" class="w-100" :style="`min-width:${minWidthKasusPerKecamatan}px !important`"
                                                            :chart-options="grafikPerkecamatanOption"></app-chartjs-bar>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                    <div class="col-lg-12 mb-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-10 align-items-center">
                                                    <div class="col-lg-3">                                                        
                                                        <div class="d-flex flex-wrap align-items-center">
                                                            <div style="background:#EE7B33;color:#fff;border-radius:5px;font-size:10px;"
                                                                class="px-3 py-1 me-2">Anak-anak</div>
                                                            <div style="background:#50CD89;color:#fff;border-radius:5px;font-size:10px;"
                                                                class="px-3 py-1">Dewasa</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">                                                        
                                                        <app-select-single v-model="single.filter.problemTypeMonthly" :loading="pageStatus == 'problem-load'" :show_button_clear="false" :placeholder="'Pilih tipe permasalahan'" :options="select.listProblemTypeMonthly" :serverside="true"  @change-search="getProblemMonthly" @option-change="getDataProblemMonthly();getDataProblemYearly()"></app-select-single>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <app-datepicker type="year" :format="'YYYY'" :value-type="'YYYY'" :clearable="false"
                                                            :style="'max-width:150px;'" v-model:value="single.filter.yearSection4" @change="getDataProblemYearly();getDataProblemMonthly()">
                                                        </app-datepicker>
                                                    </div>
                                                </div>
                                                <div class=" fw-bolder" style="font-size:17px;">Kasus Bulanan Berdasarkan Tipe Permasalahan
                                                    : <span class="c-primary-custom">{{single?.filter?.problemTypeMonthly?.text}}</span></div>
                                                <div class="text-grau-600">Menampilkan Jumlah kasus per kategori berdasarkan tipe permasalahan yang dipilih</div>
                                                <div class="card-body py-10" v-if="loader.kasusBulanan == true">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <app-loader></app-loader>
                                                    </div>
                                                </div>
                                                <div class="mt-5" style="display:block;overflow-x:auto;" v-else>
                                                    <app-chartjs-bar :chart-data="kasusBulananTipePermasalahanChartData"
                                                        :style="`min-width:${minWidthProblemTypeMonth}px !important;`"
                                                        class="w-100"
                                                        :chart-options="kasusBulananTipePermasalahanChartOption">
                                                    </app-chartjs-bar>
                                                </div>
                                                <div class="fw-bolder mt-10" style="font-size:17px;">Kasus Tahunan Berdasarkan Tipe Permasalahan
                                                    : <span class="c-primary-custom">{{single?.filter?.problemTypeMonthly?.text}}</span></div>
                                                <div class="text-gray-600">Menampilkan Jumlah kasus per kategori berdasarkan tipe permasalahan yang dipilih</div>
                                                <div class="card-body py-10" v-if="loader.kasusTahunan == true">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <app-loader></app-loader>
                                                    </div>
                                                </div>
                                                <div class="mt-5" style="display:block;overflow-x:auto;" v-else>
                                                    <app-chartjs-bar :chart-data="kasusTahunanTipePermasalahanChartData"
                                                       :style="`min-width:${minWidthProblemTypeYear}px !important;`"
                                                        class="w-100"
                                                        :chart-options="kasusTahunanTipePermasalahanChartOption">
                                                    </app-chartjs-bar>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- end content -->
                            </div>
                            <!--end::Container-->
                        </div>

                        <!--end::Post-->
                    </div>

                    <!-- end of content -->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
    import Api from "@/services/api";

    import _ from "lodash";    

    import 
        { Bar, Line, Pie}
     from 'vue-chartjs'

    import {
        Chart as ChartJS,
        Title,
        Tooltip,
        Legend,
        BarElement,
        LineElement,
        ArcElement,
        LinearScale,
        PointElement,
        CategoryScale,
        Plugin
    } from 'chart.js'

    import ChartJSPluginDatalabels from "chartjs-plugin-datalabels";

    ChartJS.register(
        Title,
        Tooltip,
        Legend,
        LineElement,
        LinearScale,
        PointElement,
        CategoryScale,
        BarElement,
        ArcElement,
        ChartJSPluginDatalabels
    )

    export default {
        components: {
            'app-chartjs-line': Line,
            'app-chartjs-bar': Bar,
            'app-chartjs-pie': Pie
        },
        data() {
            return {                     
                dataKetuntasanOpd: {
                    tuntas: 0,
                    belum: 0
                },
                OpdBelumTuntas: 0,
                kasusBulananTipePermasalahanChartData: null,
                kasusBulananTipePermasalahanChartOption: null,
                kasusTahunanTipePermasalahanChartData: null,
                kasusTahunanTipePermasalahanChartOption: null,
                minWidthProblemTypeMonth: 0,
                minWidthProblemTypeYear: 0,
                minWidthKasusPerKecamatan: 0,
                listProblemType: [
                    {
                        id: '0',
                        text: 'Semua'
                    },                 
                ],
                listMonthName:[
                    {number: 1, name: 'Januari'},
                    {number: 2, name: 'Februari'},
                    {number: 3, name: 'Maret'},
                    {number: 4, name: 'April'},
                    {number: 5, name: 'Mei'},
                    {number: 6, name: 'Juni'},
                    {number: 7, name: 'Juli'},
                    {number: 8, name: 'Agustus'},
                    {number: 9, name: 'September'},
                    {number: 10, name: 'Oktober'},
                    {number: 11, name: 'November'},
                    {number: 12, name: 'Desember'},
                ],
                trenKasusChartData: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus','September','Oktober', 'November', 'Desember'],
                    datasets: [{
                            label: 'Anak Anak',
                            backgroundColor: '#EE7B33',
                            borderColor: '#EE7B33',
                            pointRadius: 7,
                            pointHoverRadius: 7,
                            data: [40, 39, 10, 40, 39, 80, 40, 25, 10, 29, 22, 0]
                        },
                        {
                            label: 'Dewasa',
                            backgroundColor: '#50CD89',
                            borderColor: '#50CD89',
                            pointRadius: 7,
                            pointHoverRadius: 7,
                            data: [20, 15, 30, 20, 21, 45, 15, 5, 60, 40, 30, 60]
                        }
                    ]
                },
                trenKasusChartOption: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            display: false,
                        },
                    }
                },
                single: {
                    filter: {
                        yearSection2: '',
                        monthSection3: '',
                        yearSection4: '',
                        problemTypeMonthly: {
                            id: '-',
                            text: 'Semua'
                        },
                        problemTypeYearly: {
                            id: '-',
                            text: 'Semua'
                        },
                    }
                },
                select:{
                    listProblemTypeMonthly:[],
                    listProblemTypeYearly:[],
                },
                pageStatus: 'standby',
                loader: {
                    intervensiOpd: true,
                    trendKasus: true,
                    kasusBulanan: true,
                    kasusTahunan: true,
                    kasusPerkecamatan: true,
                    grafikKetuntasanOpd: true
                },
                data: {
                    intervensiOpd: [],
                    trendKasus: {},
                    kasusBulanan:{},
                    kasusTahunan:{}
                },
                labels:{
                    bulanan:[],
                    tahunan:[
                        "Permasalahan Sosial;Januari",
                        "Permasalahan Keuangan;Januari",
                        "Permasalahan Agama;Januari",
                        "Permasalahan Sosial;Februari",
                        "Permasalahan Keuangan;Februari",
                        "Permasalahan Agama;Februari"
                    ]
                },

                grafikKetuntasanOpdData: {
                    labels: ['Tuntas', 'Tidak Tuntas'],
                    datasets: [
                        {
                        backgroundColor: ['#50CD89', '#F1416C'],
                        data: [0, 0]
                        }
                    ]
                },
                grafikKetuntasanOpdOption: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = (value*100 / sum).toFixed(2)+"%";
                                return percentage;
                            },
                            color: '#fff',
                        }
                    }
                },
                grafikPerkecamatanData: {
                    labels: [],
                    datasets: [{
                            label: 'Anak Anak',
                            backgroundColor: '#EE7B33',
                            borderColor: '#EE7B33',
                            pointRadius: 7,
                            pointHoverRadius: 7,
                            barThickness : 70,
                            data: []
                        },
                        {
                            label: 'Dewasa',
                            backgroundColor: '#50CD89',
                            borderColor: '#50CD89',
                            pointRadius: 7,
                            pointHoverRadius: 7,
                            barThickness : 70,
                            data: []
                        }
                    ]
                },
                grafikPerkecamatanOption: {
                    responsive: true,
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            display: false,
                        },
                    }
                },
            }

        },

        mounted() {
            reinitializeAllPlugin();
            this.single.filter.yearSection2 = this.$moment(new Date()).format('YYYY');
            this.single.filter.monthSection3 = this.$moment(new Date()).format('YYYY-MM');
            this.single.filter.yearSection4 = this.$moment(new Date()).format('YYYY');

            this.getIntervensiOpd();
            this.getTrendKasus();
            this.getDataProblemMonthly();
            this.getDataProblemYearly();
            this.getGrafikKetuntasanOpd();
            this.getGrafikPerKecamatan();
        },
        methods: {
            calculateGroupLabels(data) {
                const scaleFactor = 100;
                var labels = _(data)
                    .groupBy((elem) => elem[0])
                    .map((entriesOnSameGroup, key) => {
                        var newSize = entriesOnSameGroup.length * scaleFactor;
                        var newArray = new Array(newSize);
                        newArray[0] = "";
                        newArray[newArray.length - 1] = "";
                        newArray[parseInt((newArray.length - 1) / 2)] = key;
                        return newArray;
                    }).flatten().value()
                return labels;
            },
            getIntervensiOpd(){
                this.loader.intervensiOpd = true;
                Api().get(`dashboard/intervention-opd-not-finish`,{
                    params: {
                        limit: 5
                    }
                })
                .then(response => {

                    this.data.intervensiOpd = [];

                    let data = response.data.data;                    
                    this.OpdBelumTuntas = response.data.total;

                    for(let i = 0 ; i < data.length; i++){
                        if(data[i].opd){
                            let check = this.data.intervensiOpd.findIndex((e) => e.opd_id == data[i].opd.id);

                            if(check >= 0){
                                this.data.intervensiOpd[check].intervensi.push({
                                    client_name: data[i].penjangkauan && data[i].penjangkauan.pengaduan && data[i].penjangkauan.pengaduan.klien ? data[i].penjangkauan.pengaduan.klien.name : '',
                                    client_id: data[i].penjangkauan && data[i].penjangkauan.pengaduan ? data[i].penjangkauan.pengaduan.id_klien : '',
                                    intervention_name: data[i].intervensi ? data[i].intervensi.name : '',
                                    date: data[i].realisasi_intervensi.length > 0 ? data[i].realisasi_intervensi[0].created_at : ''
                                });
                            }else{
                                this.data.intervensiOpd.push({
                                    opd_name: data[i].opd.name,
                                    opd_id: data[i].opd.id,
                                    intervensi: [
                                        {
                                            client_name: data[i].penjangkauan && data[i].penjangkauan.pengaduan && data[i].penjangkauan.pengaduan.klien ? data[i].penjangkauan.pengaduan.klien.name : '',
                                            client_id: data[i].penjangkauan && data[i].penjangkauan.pengaduan ? data[i].penjangkauan.pengaduan.id_klien : '',
                                            intervention_name: data[i].intervensi ? data[i].intervensi.name : '',
                                            date: data[i].realisasi_intervensi.length > 0 ? data[i].realisasi_intervensi[0].created_at : ''
                                        }
                                    ]
                                })
                            }
                        }
                        
                    }

                    this.loader.intervensiOpd = false;
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                });                
            },
            getTrendKasus(){
                this.loader.trendKasus = true;
                Api().get(`dashboard/trend-statistic-all?tahun=${this.single?.filter?.yearSection2}`)
                .then(response => {
                    let data = response.data.data;
                    this.data.trendKasus = data;
                    this.trenKasusChartData.datasets[0].data = [];
                    this.trenKasusChartData.datasets[1].data = [];
                    for(let i = 0; i < 12; i++){
                        let bool = false;
                        for(let j = 0; j < 12; j++){
                            if(data[j]?.month_number == i+1){
                                bool = true;
                                this.trenKasusChartData.datasets[0].data.push(data[j]?.total_child);
                                this.trenKasusChartData.datasets[1].data.push(data[j]?.total_adult);
                            }
                        }
                        if(bool == false){
                            this.trenKasusChartData.datasets[0].data.push(0);
                            this.trenKasusChartData.datasets[1].data.push(0);
                        }
                    }
                    this.loader.trendKasus = false;
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                });                
            },
            getProblemMonthly(keyword, limit){
                this.pageStatus = 'problem-load';
                Api().get(`m-tipe-permasalahan/lists?&search=${keyword}&limit=${limit}`)
                    .then(response => {

                        this.select.listProblemTypeMonthly = [];

                        this.select?.listProblemTypeMonthly.push({
                                id: '-',
                                text: 'Semua',
                        });
                        for (let i = 0; i < response.data.data.length; i++) {                            
                            this.select?.listProblemTypeMonthly.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }
                    })
                    .catch(error => {
                        this.select.listProblemTypeMonthly = [];
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    });
            },
            getDataProblemMonthly(){
                this.loader.kasusBulanan = true;
                this.pageStatus = 'problem-load';
                Api().get(`dashboard/trend-statistic-by-month-problem-type?tahun=${this.single?.filter?.yearSection4}&id_tipe_permasalahan=${this.single.filter.problemTypeMonthly?.id == '-' ? '' : this.single.filter.problemTypeMonthly?.id}`)
                    .then(response => {
                        let data = response?.data?.data;
                        let dataChild = [];
                        let dataAdult = [];
                        this.data.kasusBulanan = data;
                        this.labels.bulanan = [];

                        this.minWidthProblemTypeMonth = data.length * 300;
                        for(let i = 0; i < data.length; i++){
                            this.labels.bulanan.push(`${data[i].name}<br>${this.listMonthName[data[i].month_number-1].name}`);
                            dataChild.push(data[i].total_child ? data[i].total_child : null);
                            dataAdult.push(data[i].total_adult ? data[i].total_adult : null);
                        }

                        this.kasusBulananTipePermasalahanChartData = {
                            labels: this.labels.bulanan,
                            datasets: [{
                                    label: 'Anak Anak',
                                    data: dataChild,
                                    borderColor: '#EE7B33',
                                    backgroundColor: '#EE7B33',
                                    barThickness : 50,
                                    skipNull: true,
                                },
                                {
                                    label: 'Dewasa',
                                    data: dataAdult,
                                    borderColor: '#50CD89',
                                    backgroundColor: '#50CD89',
                                    barThickness : 50,
                                    skipNull: true,
                                },
                            ],
                        }

                        this.kasusBulananTipePermasalahanChartOption = {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                title: {
                                    display: false,
                                },
                                datalabels: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {                                    
                                        title: function(context) {
                                            let title = context[0].label;
                                            return title.split('<br>')[0] + " (" + title.split('<br>')[1] + ")";
                                        }
                                    },
                                }                                                                                          
                            },
                            scales: {                              
                                x1: {
                                    position: 'bottom',
                                    ticks: {
                                        callback: function (value, index, values) {
                                            return this.getLabelForValue(value).split('<br>')[0];
                                        }
                                    }
                                },
                                x2: {
                                    position: 'bottom',
                                    ticks: {
                                        callback: function (value, index, values) {
                                            return this.getLabelForValue(value).split('<br>')[1];
                                        }
                                    }
                                }
                            }
                        }                      
                        this.loader.kasusBulanan = false;
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    })
            },
            getDataProblemYearly(){
                this.loader.kasusTahunan = true;
                this.pageStatus = 'problem-load';
                Api().get(`dashboard/trend-statistic-by-year-problem-type?tahun=${this.single?.filter?.yearSection4}&id_tipe_permasalahan=${this.single.filter.problemTypeMonthly?.id == '-' ? '' : this.single.filter.problemTypeMonthly?.id}`)
                    .then(response => {
                        let data = response?.data?.data;
                        let dataChild = [];
                        let dataAdult = [];
                        this.data.kasusTahunan = data;
                        this.labels.tahunan = [];
                                          
                        this.minWidthProblemTypeYear = data.length * 300;

                        for(let i = 0; i < data.length; i++){
                            this.labels.tahunan.push(`${data[i].name}`);
                            dataChild.push(data[i].total_child ? data[i].total_child : null);
                            dataAdult.push(data[i].total_adult ? data[i].total_adult : null);
                        }
                        
                        

                        this.kasusTahunanTipePermasalahanChartData = {
                            labels: this.labels?.tahunan,
                            datasets: [{
                                    label: 'Anak Anak',
                                    data: dataChild,
                                    borderColor: '#EE7B33',
                                    backgroundColor: '#EE7B33',
                                    barThickness : 50,
                                    skipNull: true,
                                },
                                {
                                    label: 'Dewasa',
                                    data: dataAdult,
                                    borderColor: '#50CD89',
                                    backgroundColor: '#50CD89',
                                    barThickness : 50,
                                    skipNull: true,
                                },
                            ],
                        }

                        this.kasusTahunanTipePermasalahanChartOption = {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                title: {
                                    display: false,
                                }, 
                                datalabels: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {                                    
                                        title: function(context) {
                                            let title = context[0].label;
                                            return title;
                                        }
                                    },
                                }                                                                                          
                            },
                            scales: {
                                x1: {
                                    position: 'bottom',
                                    font: {
                                        size: 5
                                    },
                                    ticks: {
                                        callback: function (value, index, values) {
                                            return this.getLabelForValue(value).split('<br>')[0];
                                        }
                                    }
                                },                             
                            }
                        }    
                        this.loader.kasusTahunan = false;                  
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    });
            },
            getGrafikKetuntasanOpd(){
                this.loader.grafikKetuntasanOpd = true;
                Api().get(`dashboard/ketuntasan-opd`)
                .then(response => {
                    let context = response.data.data;

                    this.grafikKetuntasanOpdData.datasets[0].data[0] = context.tuntas;
                    this.grafikKetuntasanOpdData.datasets[0].data[1] = context.tidak_tuntas;

                    this.dataKetuntasanOpd.tuntas = context.tuntas;
                    this.dataKetuntasanOpd.belum = context.tidak_tuntas;

                    this.loader.grafikKetuntasanOpd = false;
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                });                
            },
            getGrafikPerKecamatan(){
                this.loader.kasusPerkecamatan = true;
                Api().get(`dashboard/trend-kasus-perkecamatan?month=${this.single.filter.monthSection3}`)
                .then(response => {
                    let data = response.data.data;
                    
                    this.grafikPerkecamatanData.labels = []
                    this.grafikPerkecamatanData.datasets[0].data = []
                    this.grafikPerkecamatanData.datasets[1].data = []

                    this.minWidthKasusPerKecamatan = data.length * 250;
                    for(let i = 0; i < data.length; i++){
                      this.grafikPerkecamatanData.labels.push(data[i].kecamatan_name);
                      this.grafikPerkecamatanData.datasets[0].data.push(data[i].anak);
                      this.grafikPerkecamatanData.datasets[1].data.push(data[i].dewasa);
                    }

                    this.loader.kasusPerkecamatan = false;
                })
                .catch(error => {
                    this.$axiosHandleError(error);
                });                
            }
        },

    }

</script>

<style scoped>

</style>
