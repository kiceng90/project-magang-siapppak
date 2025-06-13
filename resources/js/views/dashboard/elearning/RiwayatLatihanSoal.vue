<template>
    <div>
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
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <button
                                                class="btn btn-link p-0"
                                                type="button"
                                                @click="
                                                    () =>
                                                        navigateTo(
                                                            'elearning-puspaga'
                                                        )
                                                "
                                            >
                                                Elearning Puspaga
                                            </button>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <button
                                                class="btn btn-link p-0"
                                                type="button"
                                                @click="
                                                    () =>
                                                        navigateTo(
                                                            'elearningpuspaga-kategori',
                                                            {
                                                                id: idKategori,
                                                            }
                                                        )
                                                "
                                            >
                                                Kategori {{ namaKategori }}
                                            </button>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <button
                                                class="btn btn-link p-0"
                                                type="button"
                                                @click="
                                                    () =>
                                                        navigateTo(
                                                            'elearningpuspaga-subkategori',
                                                            {
                                                                id: idSubKategori,
                                                            }
                                                        )
                                                "
                                            >
                                                {{ namaSubKategori }}
                                            </button>
                                        </li>
                                        <li
                                            class="breadcrumb-item active"
                                            aria-current="page"
                                        >
                                            Riwayat Latihan Soal
                                        </li>
                                    </ol>
                                </nav>

                                <div
                                    class="card card-flush mt-5 mb-5 mb-xl-10"
                                    id="kt_profile_details_view"
                                >
                                    <div
                                        class="card-body pt-6"
                                        id="start-content"
                                    >
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3"
                                        >
                                            <h3 class="card-title">
                                                Riwayat Latihan Soal
                                            </h3>
                                            <button
                                                type="button"
                                                class="btn btn-custom"
                                                @click="goBack"
                                            >
                                                <span
                                                    class="text-warning d-flex"
                                                >
                                                    <svg
                                                        width="18"
                                                        height="18"
                                                        viewBox="0 0 18 18"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            opacity="0.3"
                                                            d="M17.4166 10.0846C17.9228 10.0846 18.3333 10.495 18.3333 11.0013C18.3333 11.5076 17.9228 11.918 17.4166 11.918H10.0833C9.57699 11.918 9.16658 11.5076 9.16658 11.0013C9.16658 10.495 9.57699 10.0846 10.0833 10.0846H17.4166Z"
                                                            fill="#FFA800"
                                                        />
                                                        <path
                                                            d="M11.6481 15.8531C12.0061 16.2111 12.0061 16.7915 11.6481 17.1495C11.2901 17.5075 10.7097 17.5075 10.3517 17.1495L4.85174 11.6495C4.50471 11.3025 4.49257 10.7437 4.8242 10.3819L9.86586 4.88189C10.208 4.5087 10.7878 4.48349 11.161 4.82558C11.5342 5.16767 11.5594 5.74752 11.2173 6.12072L6.76871 10.9737L11.6481 15.8531Z"
                                                            fill="#FFA800"
                                                        />
                                                    </svg>
                                                    Kembali
                                                </span>
                                            </button>
                                        </div>
                                        <div
                                            class="accordion"
                                            id="riwayatAccordion"
                                        >
                                            <div
                                                v-for="(
                                                    soal, index
                                                ) in riwayatSoal"
                                                :key="soal.id"
                                                class="accordion-item custom-accordion-item"
                                            >
                                                <h2
                                                    class="accordion-header"
                                                    :id="'heading' + index"
                                                >
                                                    <button
                                                        class="accordion-button collapsed custom-accordion-button"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        :data-bs-target="
                                                            '#collapse' + index
                                                        "
                                                        aria-expanded="false"
                                                        :aria-controls="
                                                            'collapse' + index
                                                        "
                                                    >
                                                        {{ index + 1 }}.
                                                        {{ soal.nama }}
                                                    </button>
                                                </h2>
                                                <div
                                                    :id="'collapse' + index"
                                                    class="accordion-collapse collapse"
                                                    :aria-labelledby="
                                                        'heading' + index
                                                    "
                                                    data-bs-parent="#riwayatAccordion"
                                                >
                                                    <div class="accordion-body">
                                                        <!-- Conditional rendering for latihan soal data -->
                                                        <div
                                                            v-if="
                                                                soal.data &&
                                                                soal.data.length
                                                            "
                                                        >
                                                            <div
                                                                class="summary-table mt-3"
                                                            >
                                                                <h4>
                                                                    Ringkasan
                                                                    Nilai
                                                                    Latihan
                                                                </h4>
                                                                <table
                                                                    class="table table-striped"
                                                                >
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                Status
                                                                            </th>
                                                                            <th>
                                                                                Nilai
                                                                            </th>
                                                                            <th>
                                                                                Status
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr
                                                                            v-for="item in soal.data"
                                                                            :key="
                                                                                item.id
                                                                            "
                                                                        >
                                                                            <td>
                                                                                {{
                                                                                    formatTanggal(
                                                                                        item.tanggal
                                                                                    )
                                                                                }}
                                                                            </td>
                                                                            <td>
                                                                                {{
                                                                                    item.nilai
                                                                                }}
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
                                                        <div v-else>
                                                            <p
                                                                class="text-muted"
                                                            >
                                                                Anda belum
                                                                mengerjakan
                                                                latihan soal
                                                                pada materi ini.
                                                            </p>
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
                </div>
            </div>
        </div>

        <app-scroll-top></app-scroll-top>
    </div>
</template>

<script>
export default {
    data() {
        return {
            namaKategori: "",
            idKategori: "",
            namaSubKategori: "",
            idSubKategori: "",
            riwayatSoal: [],
        };
    },
    methods: {
        navigateTo(routeName, params = {}) {
            this.$router.push({ name: routeName, params });
        },
        goBack() {
            this.$router.go(-1);
        },
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
        async fetchSubKategori() {
            const id = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/subkategori/getSubKategori/${id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.namaSubKategori = response.data.name;
                this.idSubKategori = response.data.id;
                this.idKategori = response.data.id_kategori; // Ambil id_kategori dari response
            } catch (error) {
                console.error("Gagal mengambil data subkategori:", error);
            }
        },
        async fetchKategori() {
            if (!this.idKategori) {
                console.error("ID Kategori belum tersedia.");
                return;
            }
            try {
                const response = await axios.get(
                    `/api/kategori/getKategori/${this.idKategori}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.namaKategori = response.data.name;
            } catch (error) {
                console.error("Gagal mengambil data kategori:", error);
            }
        },
        async fetchRiwayatSoal() {
            const idSubKategori = this.$route.params.id;
            try {
                const materiResponse = await axios.get(
                    `/api/materi/getRiwayatLatihanSoal/${idSubKategori}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                const materiList = materiResponse.data;
                this.riwayatSoal = await Promise.all(
                    materiList.map(async (materi) => {
                        const jawabanResponse = await axios.get(
                            `/api/materi/getRiwayatLatihanSoal2/${materi.id}`,
                            {
                                headers: {
                                    Authorization: `Bearer ${localStorage.getItem(
                                        "dp5a-token"
                                    )}`,
                                },
                            }
                        );
                        return {
                            id: materi.id,
                            nama: materi.name,
                            data: jawabanResponse.data.map((jawaban) => ({
                                id: jawaban.id,
                                tanggal: jawaban.created_at,
                                nilai: jawaban.skor,
                            })),
                        };
                    })
                );
            } catch (error) {
                console.error("Gagal mengambil data riwayat soal:", error);
            }
        },
    },
    mounted() {
        this.fetchSubKategori().then(() => {
            this.fetchKategori();
        });
        this.fetchRiwayatSoal();
        reinitializeAllPlugin();
    },
};
</script>

<style scoped>
.breadcrumb {
    display: flex;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 0.95rem;
    flex-wrap: wrap;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    font-size: 1rem;
}

.breadcrumb-item:not(:last-child)::after {
    content: "|";
    color: #6c757d;
    padding: 0 0.5rem;
    font-size: 1.1rem;
}

.breadcrumb-item button {
    color: #ee7b33;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-item.active {
    color: #6c757d;
}

@media (max-width: 768px) {
    .breadcrumb {
        font-size: 0.85rem;
    }
    .breadcrumb-item {
        font-size: 0.9rem;
    }
    .breadcrumb-item:not(:last-child)::after {
        font-size: 1rem;
        padding: 0 0.3rem;
    }
}

@media (max-width: 480px) {
    .breadcrumb {
        font-size: 0.8rem;
    }
    .breadcrumb-item {
        font-size: 0.85rem;
    }
    .breadcrumb-item:not(:last-child)::after {
        font-size: 0.9rem;
        padding: 0 0.2rem;
    }
}

.btn-custom {
    background-color: #fff8dd;
}

.accordion-item {
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.custom-accordion-button {
    background-color: #f9f9f9;
    color: #333;
    font-weight: 500;
    border-radius: 0;
    padding: 15px;
}

.custom-accordion-button:focus {
    box-shadow: none;
}

.accordion-item .accordion-body {
    border-top: 1px solid #ddd;
    padding: 20px;
    background-color: #ffffff;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
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
</style>
