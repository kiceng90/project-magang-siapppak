<template>
    <div>
        <audio
            ref="backgroundMusic"
            :src="
                score < 80
                    ? '/assets/siapppak/music/fail.mp3'
                    : '/assets/siapppak/music/success.mp3'
            "
            autoplay
        ></audio>
        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <app-sidebar></app-sidebar>
                <div
                    class="wrapper d-flex flex-column flex-row-fluid"
                    id="kt_wrapper"
                >
                    <app-navbar></app-navbar>
                    <div id="main-content">
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <div
                                id="kt_content_container"
                                class="container-xxl"
                            >
                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    id="kt_profile_details_view"
                                >
                                    <div
                                        class="card-body pt-6"
                                        id="start-content"
                                    >
                                        <div class="score-section text-center">
                                            <div class="judul mb-10">
                                                <h2>Rumah Perubahan</h2>
                                                <!-- <p class="subtitle">
                                                    Keterampilan dasar
                                                    konseling, bantuan psikologi
                                                    awal dan dukungan sosial
                                                    (PFA)
                                                </p> -->
                                            </div>

                                            <div
                                                class="score-circle"
                                                :class="scoreColor"
                                            >
                                                <span>{{ score }}</span>
                                            </div>
                                            <p
                                                v-if="score >= 80"
                                                class="message"
                                            >
                                                Hebat! Setiap usaha yang kamu
                                                lakukan <br />
                                                adalah langkah menuju
                                                kesuksesan.
                                            </p>
                                            <p v-else class="message">
                                                Masih ada kesempatan untuk jadi
                                                lebih baik. <br />
                                                Tetap Semangat!
                                            </p>

                                            <div class="button-group">
                                                <button
                                                    class="button"
                                                    @click="$router.push({ name: 'rumah-perubahan' })"
                                                >
                                                    Lanjutkan Ke Beranda Rumah Perubahan
                                                </button>
                                            </div>
                                        </div>

                                        <div class="summary-table mt-10">
                                            <h4>Ringkasan Nilai Latihan</h4>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Waktu Pengerjaan
                                                        </th>
                                                        <th>Nilai</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="item in data"
                                                        :key="item.id"
                                                    >
                                                        <td>
                                                            {{
                                                                formatTanggal(
                                                                    item.tanggal
                                                                )
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{ item.nilai }}
                                                        </td>
                                                        <td>
                                                            <img
                                                                class="icon-status"
                                                                :src="
                                                                    item.nilai >
                                                                    80
                                                                        ? '/assets/siapppak/img/success.png'
                                                                        : '/assets/siapppak/img/fail.png'
                                                                "
                                                            />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import confetti from "canvas-confetti";
export default {
    data() {
        return {
            data: [],
            showConfirmModal: false,
            score: "",
        };
    },
    computed: {
        scoreColor() {
            return this.score < 80 ? "score-low" : "score-high";
        },
    },
    mounted() {
        this.launchConfetti();
        reinitializeAllPlugin();
        this.hasilLatihanSoal();
        this.historyLatihanSoal();
    },
    methods: {
        formatTanggal(tanggal) {
            const hari = [
                "Minggu",
                "Senin",
                "Selasa",
                "Rabu",
                "Kamis",
                "Jumat",
                "Sabtu",
            ];
            const bulan = [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
            ];

            const date = new Date(tanggal);
            const namaHari = hari[date.getDay()];
            const tanggalNum = date.getDate();
            const namaBulan = bulan[date.getMonth()];
            const tahun = date.getFullYear();

            const jam = String(date.getHours()).padStart(2, "0");
            const menit = String(date.getMinutes()).padStart(2, "0");

            return `${namaHari}, ${tanggalNum} ${namaBulan} ${tahun}; ${jam}:${menit}`;
        },
        async hasilLatihanSoal() {
            const idJawaban = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/rumahperubahan-detailjawaban/hasil-latihan-soal/${idJawaban}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.score = response.data.skor;
            } catch (error) {
                console.error("Error fetching jawaban data:", error);
            }
        },
        async historyLatihanSoal() {
            const idJawaban = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/rumahperubahan-detailjawaban/history-latihan-soal/${idJawaban}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.data = response.data.map((history) => ({
                    tanggal: history.created_at,
                    nilai: history.skor,
                }));
            } catch (error) {
                console.error("Error fetching history data:", error);
            }
        },
        launchConfetti() {
            const duration = 4000;
            const end = Date.now() + duration;

            const frame = () => {
                confetti({
                    particleCount: 10,
                    startVelocity: 30,
                    spread: 60,
                    angle: 90,
                    origin: { x: Math.random(), y: 0 },
                    colors:
                        this.score >= 80
                            ? ["#FFC700", "#FF0000", "#2E3192", "#41BBC7"]
                            : "",
                    shapes:
                        this.score >= 80 ? ["circle", "square"] : ["square"],
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            };
            frame();
        },
        // async navigateToLearning() {
        //     const idMateri = this.$route.params.id_materi;
        //     try {
        //         const response = await axios.get(
        //             `/api/rumahperubahan-detailjawaban/lanjut-belajar/${idMateri}`,
        //             {
        //                 headers: {
        //                     Authorization: `Bearer ${localStorage.getItem(
        //                         "dp5a-token"
        //                     )}`,
        //                 },
        //             }
        //         );
        //         const idMateri = response.data.id_materi;
        //         this.$router.push({
        //             name: "rumahperubahan-materi",
        //             params: { id: idMateri },   
        //         });
        //     } catch (error) {
        //         console.error("Gagal mendapatkan data materi:", error);
        //     }
        // },
        // async confirmRetryQuiz() {
        //     this.showConfirmModal = false;
        //     const idJawaban = this.$route.params.id;

        //     try {
        //         const response = await axios.get(
        //             `/api/rumahperubahan-detailjawaban/hasil-latihan-soal/${idJawaban}`,
        //             {
        //                 headers: {
        //                     Authorization: `Bearer ${localStorage.getItem(
        //                         "dp5a-token"
        //                     )}`,
        //                 },
        //             }
        //         );

        //         const idMateri = response.data.id_materi; // Ambil `id_materi` dari respons
        //         this.$router.push({
        //             name: "rumahperubahan-latihansoal",
        //             params: { id: idMateri },
        //         });
        //     } catch (error) {
        //         console.error("Gagal mendapatkan data materi:", error);
        //         this.$swal({
        //             title: "Error",
        //             text: "Terjadi kesalahan saat memuat data. Silakan coba lagi.",
        //             icon: "error",
        //         });
        //     } finally {
        //         this.$ewpLoadingHide(); // Hide loading indicator if available
        //     }
        // },
        async confirmRetryQuiz() {
            this.showConfirmModal = false;
            const idJawaban = this.$route.params.id;

            try {
                this.$ewpLoadingShow(); // Show loading indicator if available
                
                const response = await axios.get(
                    `/api/rumahperubahan-detailjawaban/hasil-latihan-soal/${idJawaban}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("dp5a-token")}`,
                        },
                    }
                );

                const idMateri = response.data.id_materi;
                
                // Create a new entry in the jawaban table for this retry attempt
                const createNewAttempt = await axios.post(
                    `/api/rumahperubahan-jawaban/create-new-attempt`,
                    { 
                        id_jawaban_previous: idJawaban,
                        id_materi: idMateri 
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("dp5a-token")}`,
                        },
                    }
                );
                
                // Store the new jawaban ID in localStorage for the quiz page to use
                localStorage.setItem("idJawaban", createNewAttempt.data.id_jawaban);
                
                // Navigate to the quiz page
                this.$router.push({
                    name: "rumahperubahan-latihansoal",
                    params: { id: idMateri },
                });
            } catch (error) {
                console.error("Gagal mendapatkan data materi:", error);
                this.$swal({
                    title: "Error",
                    text: "Terjadi kesalahan saat memuat data. Silakan coba lagi.",
                    icon: "error",
                });
            } finally {
                this.$ewpLoadingHide();
            }
        }
    },
};
</script>

<style scoped>
.score-section {
    text-align: center;
    padding: 20px;
    background-image: url("/assets/siapppak/img/nilai.jpg");
    min-height: 500px;
    height: auto;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: scroll;
    color: #fff;
    border-radius: 4px;
    overflow: hidden;
}

.subtitle {
    color: black;
}

.score-circle {
    display: inline-block;
    width: 150px;
    height: 150px;
    background-color: #e4a05f;
    border-radius: 50%;
    font-size: 50px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px auto;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.score-circle.score-high {
    background-color: #adbcf7;
    color: #fff4dd;
}

.score-circle.score-low {
    background-color: #fe8282;
    color: #fff4dd;
}

.message {
    margin-top: 10px;
    font-weight: 500;
    color: black;
}

.button-group {
    margin-top: 15px;
}

.button-group button {
    margin: 5px;
    border-radius: 5px;
    color: #ee7b33;
    background-color: #fff4dd;
    font-size: 12px;
    font-weight: bold;
    padding: 10px 20px;
    border: none;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s, color 0.3s;
}

.button-group button:hover {
    background-color: #ee7b33;
    color: #fff;
}

.summary-table {
    margin-top: 20px;
}

.summary-table h4 {
    font-weight: 500;
}

.summary-table .table {
    width: 100%;
    margin-top: 10px;
    background-color: #fff4dd;
    color: black;
    border-radius: 4px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.summary-table .table th {
    font-weight: 600;
}

.summary-table .table th:first-child,
.summary-table .table td:first-child {
    padding-left: 20px;
}

.summary-table .table tbody tr {
    border-bottom: 1px solid #ccc;
    border-top: 1px solid #ccc;
}

.summary-table .table tbody tr:last-child {
    border-bottom: none;
}

.summary-table .table thead {
    background-color: #e4a05f;
    color: #fff;
}

.summary-table .table tbody {
    background-color: #fff4dd;
    color: black;
}

td img.icon-status {
    height: 70px;
    width: 70px;
}

.modal.fade {
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transform: translateY(-20px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.modal.fade.show {
    opacity: 1;
    transform: translateY(0);
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    max-width: 300px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.modal-body {
    color: black;
}

.modal-footer {
    display: flex;
    justify-content: center;
}

@media (max-width: 1200px) {
    .score-section {
        min-height: 400px;
        padding: 15px;
    }
}

@media (max-width: 768px) {
    .score-section {
        min-height: 300px;
    }

    .score-circle {
        width: 120px;
        height: 120px;
        font-size: 48px;
    }

    .button-group button {
        font-size: 10px;
        padding: 8px 16px;
    }

    .summary-table h4 {
        font-size: 1.2rem;
    }

    .summary-table .table {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .score-section {
        max-width: 300px;
        padding: 0 20px;
    }

    .message {
        font-size: 0.9rem;
    }

    .button-group button {
        width: 100%;
        margin-bottom: 10px;
    }

    .summary-table .table th,
    .summary-table .table td {
        padding: 10px;
    }
}

@media (max-width: 480px) {
    .score-section {
        background-size: contain;
        background-position: top;
        padding: 20px;
        min-height: 300px;
    }

    .judul p.subtitle {
        font-size: 10px;
    }
}
</style>
