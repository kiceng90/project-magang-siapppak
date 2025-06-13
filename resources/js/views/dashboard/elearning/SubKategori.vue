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
                                                                id:
                                                                    categoryId,
                                                            }
                                                        )
                                                "
                                            >
                                                Kategori {{ categoryName }}
                                            </button>
                                        </li>
                                        <li
                                            class="breadcrumb-item active"
                                            aria-current="page"
                                        >
                                            {{ subCategoryName }}
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
                                                {{ subCategoryName }}
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
                                        <p class="description">
                                            Selamat datang! Kamu berada di
                                            langkah berikutnya dalam perjalanan
                                            belajarmu. Di sub kategori ini, kita
                                            akan mengeksplorasi materi yang
                                            menarik dan penting. Setiap
                                            pembelajaran di sini akan
                                            memberikanmu pemahaman yang lebih
                                            mendalam tentang perlindungan anak
                                            dan peran penting dalam pengasuhan.
                                            Ambillah waktu untuk memahami setiap
                                            bagian, dan ingatlah bahwa setiap
                                            langkah kecil membawa kita lebih
                                            dekat pada tujuan besar. Selamat
                                            belajar dan nikmati prosesnya!
                                        </p>

                                        <!-- Materi Section -->
                                        <div class="materi-section">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h1 class="mb-3">Materi</h1>
                                                    <div
                                                        class="card-soal"
                                                        v-for="(
                                                            materi, index
                                                        ) in materiList"
                                                        :key="index"
                                                    >
                                                        <div
                                                            class="d-flex justify-content-between align-items-center"
                                                        >
                                                            <div class="col-10">
                                                                <span
                                                                    class="namamateri"
                                                                    >{{
                                                                        index +
                                                                        1
                                                                    }}.
                                                                    {{
                                                                        materi.name
                                                                    }}</span
                                                                >
                                                            </div>
                                                            <div class="col-2">
                                                                <button
                                                                    class="btn btn-outline"
                                                                    :class="
                                                                        materi.isCompleted
                                                                            ? 'btn-custom-completed'
                                                                            : 'btn-custom-pending'
                                                                    "
                                                                    @click="
                                                                        openModal(
                                                                            index
                                                                        )
                                                                    "
                                                                >
                                                                    {{
                                                                        materi.isCompleted
                                                                            ? "Selesai"
                                                                            : "Mulai"
                                                                    }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div
                                                        class="card-right mb-5"
                                                    >
                                                        <div class="card-body">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2"
                                                            >
                                                                <span
                                                                    class="motivasi"
                                                                >
                                                                    Kamu makin
                                                                    hebat,
                                                                    Teruskan!
                                                                    ({{
                                                                        completedMateriCount
                                                                    }}/{{
                                                                        materiList.length
                                                                    }})
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="progress"
                                                            >
                                                                <div
                                                                    class="progress-bar"
                                                                    role="progressbar"
                                                                    :style="`width: ${progressPercentage}%`"
                                                                    :aria-valuenow="
                                                                        progressPercentage
                                                                    "
                                                                    aria-valuemin="0"
                                                                    aria-valuemax="100"
                                                                >
                                                                    {{
                                                                        formattedProgressPercentage
                                                                    }}%
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="card-right mb-5"
                                                    >
                                                        <div class="card-body">
                                                            <div
                                                                class="d-flex justify-content-center align-items-center mb-2"
                                                            >
                                                                <span
                                                                    class="motivasi"
                                                                >
                                                                    Lihat Rekam
                                                                    Jejak
                                                                    Latihan
                                                                    Soalmu di
                                                                    Sini!
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="riwayat d-flex justify-content-center align-items-center"
                                                            >
                                                                <button
                                                                    class="btn btn-riwayat-latihan"
                                                                    @click="
                                                                        $router.push(
                                                                            {
                                                                                name: 'elearningpuspaga-riwayatlatihansoal',
                                                                                params: {
                                                                                    id: $route
                                                                                        .params
                                                                                        .id,
                                                                                },
                                                                            }
                                                                        )
                                                                    "
                                                                >
                                                                    Lihat
                                                                    Riwayat
                                                                    Latihan Soal
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-right">
                                                        <div
                                                            class="card-body d-flex flex-column align-items-center"
                                                        >
                                                            <img
                                                                src="/assets/siapppak/images/celebrate.png"
                                                                alt="Celebration"
                                                                class="img-fluid mb-3"
                                                            />
                                                            <button
                                                                class="btn btn-download-sertifikat"
                                                                :disabled="
                                                                    !allMateriCompleted
                                                                "
                                                                :style="{
                                                                    cursor: allMateriCompleted
                                                                        ? 'pointer'
                                                                        : 'not-allowed',
                                                                }"
                                                                @click="
                                                                    downloadSertifikat
                                                                "
                                                            >
                                                                Unduh Piagam
                                                            </button>
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

        <!-- Modal Section -->
        <div v-if="showModal" class="modal-overlay">
            <div class="modal-content">
                <button @click="closeModal" class="close-modal text-right">
                    <i class="bi bi-x fs-1" style="color: black"></i>
                </button>
                <div class="modal-header">
                    <span
                        >Anda telah memilih materi yang menarik!<br />Bagaimana
                        cara Anda ingin mempelajarinya?</span
                    >
                </div>
                <div class="modal-body">
                    <div class="modal-options">
                        <button
                            class="btn-modal mx-3"
                            @click="
                                goToPage(
                                    'video',
                                    materiList[selectedMateriIndex].id
                                )
                            "
                        >
                            <i class="bi bi-camera-reels"></i> Lihat Video
                        </button>
                        <button
                            class="btn-modal mx-3"
                            @click="
                                goToPage(
                                    'materi',
                                    materiList[selectedMateriIndex].id
                                )
                            "
                        >
                            <i class="bi bi-journal-richtext"></i> Baca Materi
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <p>Klik pada salah satu pilihan untuk melanjutkan!</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import html2canvas from "html2canvas";
import jsPDF from "jspdf";
export default {
    data() {
        return {
            showModal: false,
            selectedMateriIndex: null,
            showCertificate: false,
            materiList: [],
            subCategoryName: "",
            categoryName: "",
            categoryId: "",
            username: "",
            tanggalSertifikat: "",
            nosurat: "",
        };
    },
    computed: {
        formattedTanggalSertifikat() {
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(this.tanggalSertifikat).toLocaleDateString(
                "id-ID",
                options
            );
        },
        formattedProgressPercentage() {
            return Number.isInteger(this.progressPercentage)
                ? this.progressPercentage
                : this.progressPercentage.toFixed(2);
        },
        completedMateriCount() {
            return this.materiList.filter((materi) => materi.isCompleted)
                .length;
        },
        progressPercentage() {
            return (this.completedMateriCount / this.materiList.length) * 100;
        },
        allMateriCompleted() {
            return this.materiList.every((materi) => materi.isCompleted);
        },
    },

    methods: {
        navigateTo(routeName, params = {}) {
            this.$router.push({ name: routeName, params });
        },
        goBack() {
            this.$router.go(-1);
        },
        async fetchSubCategory() {
            const idSubKategori = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/subkategori/getSubKategori/${idSubKategori}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                console.log(response.data);
                this.subCategoryName = response.data.name;
                this.categoryName = response.data.kategori.name;
                this.categoryId = response.data.id_kategori;
            } catch (error) {
                console.error("Error fetching category data:", error);
            }
        },
        async fetchMateries() {
            const idSubKategori = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/materi/getMateris/${idSubKategori}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.materiList = response.data.map((materi) => ({
                    id: materi.id,
                    name: materi.name,
                    isCompleted: materi.isCompleted,
                }));
            } catch (error) {
                console.error("Error fetching materi data:", error);
            }
        },
        async downloadSertifikat() {
            const idSubKategori = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/subkategori/piagam/${idSubKategori}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                console.log(response.data);
                this.tanggalSertifikat = response.data.tanggalSertifikat;
                this.nosurat = response.data.nosurat;
                this.username = response.data.username;
            } catch (error) {
                console.error("Error fetching category data:", error);
            }
            const pdf = new jsPDF({
                orientation: "landscape",
                unit: "px",
                format: [2000, 1414],
            });

            const page1 = document.createElement("div");
            page1.style.position = "relative";
            page1.style.width = "2000px";
            page1.style.height = "1414px";
            page1.innerHTML = `
        <img src="/assets/siapppak/filesertif/bg-sertiff.png" style="width:100%; height:100%;" />
        <div style="position:absolute; top:470px; left:50%; transform: translateX(-50%); font-size:20px; font-weight: bold; text-align: center; white-space: nowrap; color: black"; font-family: Arial, Helvetica, sans-serif;>
            ${this.nosurat || "No Surat"}
        </div>
        <div style="position:absolute; top:645px; left:50%; transform: translateX(-50%); font-size:58px; font-weight: bolder; text-align: center; white-space: nowrap; color: #022448"; font-family: Arial, Helvetica, sans-serif;>
            ${this.username || "Nama Default"}
        </div>
        <div style="position:absolute; top:776px; left:50%; transform: translateX(-50%); font-size:30px; font-weight:bold; text-align: center; color: #022448; width:100%;">
            Sebagai Peserta E-Learning ${
                this.subCategoryName || "Kategori Default"
            }
        </div>
        <div style="position:absolute; top:971px; left:948px; font-size:24px; font-weight: 800; text-align: left; white-space: nowrap; color: black;">
            ${this.formattedTanggalSertifikat || "11 November 2024"}
        </div>
    `;

            document.body.appendChild(page1);
            const canvas1 = await html2canvas(page1, {
                useCORS: true,
                scale: 2,
            });
            pdf.addImage(canvas1, "JPEG", 0, 0, 2000, 1414);
            document.body.removeChild(page1);

            const page2 = document.createElement("div");
            page2.style.position = "relative";
            page2.style.width = "2000px";
            page2.style.height = "1414px";

            let materiListHTML = `
    <div style="
        display: table;
        width: 90%;
        position: absolute;
        top: 320px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 27px;
        text-align: center;
        border-collapse: collapse;
        font-weight: 500;
    ">
        <!-- Heading -->
        <div style="display: table-header-group; background-color: #f5f5f5; font-weight: bold;">
            <div style="display: table-row;">
                <div style="display: table-cell; padding: 10px; border: 2px solid black; width: 10%;">No</div>
                <div style="display: table-cell; padding: 10px; border: 2px solid black; width: 90%;">Materi</div>
            </div>
        </div>
        <!-- Rows -->
        <div style="display: table-row-group;">
`;

            this.materiList.forEach((materi, index) => {
                materiListHTML += `
            <div style="display: table-row;">
                <div style="display: table-cell; padding: 10px; border: 2px solid black;">${
                    index + 1
                }</div>
                <div style="display: table-cell; padding: 10px; border: 2px solid black; text-align: left; padding-left: 10px;">
                    ${materi.name || "Judul Materi"}
                </div>
            </div>
    `;
            });

            materiListHTML += `
        </div>
    </div>
`;

            page2.innerHTML = `
    <img src="/assets/siapppak/filesertif/bg-sertif2.png" style="width:100%; height:100%;" />
    ${materiListHTML}
`;

            document.body.appendChild(page2);
            const canvas2 = await html2canvas(page2, {
                useCORS: true,
                scale: 2,
            });
            pdf.addPage();
            pdf.addImage(canvas2, "JPEG", 0, 0, 2000, 1414);
            document.body.removeChild(page2);
            pdf.save(`${this.username || "Sertifikat"}.pdf`);
        },
        openModal(index) {
            this.selectedMateriIndex = index;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        chooseMethod(method) {
            console.log(`Metode dipilih: ${method}`);
            this.closeModal();
        },
        goToPage(type, id) {
            if (type === "video") {
                this.$router.push({
                    name: "elearningpuspaga-materi-video",
                    params: { id: id },
                });
            } else if (type === "materi") {
                this.$router.push({
                    name: "elearningpuspaga-materi-modul",
                    params: { id: id },
                });
            }
        },
    },
    async mounted() {
        await this.fetchSubCategory();
        await this.fetchMateries();
        reinitializeAllPlugin();
    },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap");
.breadcrumb {
    display: flex;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 0.95rem;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
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

p.description {
    color: grey;
    line-height: 1.6;
    padding: 10px 0;
    font-size: 1rem;
}

.btn-custom {
    background-color: #fff8dd;
}

.d-flex span.namamateri {
    font-size: 13px;
}

.materi-section {
    padding: 20px 0;
}

.card-right {
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
}

.card-soal {
    box-shadow: 0 5px rgb(0, 0, 0, 0.2);
    border-radius: 8px;
    background-color: #f4f4f4ed;
    padding: 8px 25px;
    margin-bottom: 20px;
}

.card-soal span {
    color: black;
    font-weight: 500;
    font-size: 10px;
    margin-right: 10px;
}

.btn.btn-outline {
    width: 80px;
}

.btn-custom-completed {
    border: 0.15rem solid #f19a4f;
    color: #f19a4f;
    padding: 5px 16px;
    font-size: 0.875rem;
    font-weight: 900;
}

.btn-custom-pending {
    border: 0.15rem solid #ff5c67;
    color: #ff5c67;
    padding: 5px 16px;
    font-size: 0.875rem;
    font-weight: 900;
    width: 100px;
}

.btn-custom-completed:hover,
.btn-custom-pending:hover {
    background-color: transparent !important;
    color: inherit !important;
    border-color: inherit !important;
}

.motivasi {
    font-size: 0.875rem;
}

.progress-bar {
    background-color: #f19a4f;
}

.btn-download-sertifikat {
    background-color: #f19a4f;
    color: white;
    font-size: 10px;
    padding: 6px 12px;
}

.btn-riwayat-latihan {
    background-color: #f19a4f;
    color: white;
    font-size: 10px;
    margin-top: 10px;
    padding: 6px 12px;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    max-width: 400px;
    width: 100%;
}

.modal-header {
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-header span {
    font-weight: 600;
    font-size: 13px;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
}

.modal-body {
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-modal {
    background-color: #fff4dd;
    border: none;
    border-radius: 20px;
    color: #e17517;
    padding: 9px 18px;
    font-size: 0.89rem;
    font-weight: 600;
    cursor: pointer;
    border-radius: 5px;
}

.btn-modal .bi {
    color: #e17517;
    font-weight: 600;
}

.btn-modal:hover {
    background-color: #f7e7b7;
}

.modal-footer {
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-footer p {
    margin-top: 20px;
    font-size: 0.85rem;
    color: #555555;
}

@media (max-width: 1024px) {
    .breadcrumb {
        font-size: 0.9rem;
    }

    .btn-custom,
    .btn-download-sertifikat,
    .btn-riwayat-latihan,
    .btn-modal {
        padding: 5px 10px;
        font-size: 0.85rem;
    }

    .card-right,
    .card-soal {
        padding: 8px 15px;
    }

    .modal-content {
        max-width: 350px;
    }
}

@media (max-width: 768px) {
    .breadcrumb {
        font-size: 0.85rem;
    }

    p.description {
        font-size: 0.8rem;
    }

    .btn-custom,
    .btn-download-sertifikat,
    .btn-riwayat-latihan,
    .btn-modal {
        font-size: 0.75rem;
        padding: 5px 8px;
    }

    .card-soal span {
        font-size: 9px;
    }

    .modal-content {
        max-width: 300px;
        padding: 15px;
    }

    .modal-header span {
        font-size: 12px;
    }

    .btn-custom-completed,
    .btn-custom-pending {
        font-size: 0.8rem;
        width: 90px;
    }
}

@media (max-width: 480px) {
    .breadcrumb {
        font-size: 0.8rem;
    }

    p.description {
        font-size: 0.75rem;
        padding: 8px 0;
    }

    .btn-custom,
    .btn-download-sertifikat,
    .btn-riwayat-latihan,
    .btn-modal {
        font-size: 0.7rem;
        padding: 4px 6px;
    }

    .card-soal span {
        font-size: 8px;
    }

    .modal-content {
        max-width: 90%;
        padding: 10px;
    }

    .modal-footer p {
        font-size: 0.8rem;
    }
}
</style>
