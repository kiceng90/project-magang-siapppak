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
                                            <router-link
                                                :to="{
                                                    name: 'elearning-puspaga',
                                                }"
                                            >
                                                Elearning Puspaga
                                            </router-link>
                                        </li>
                                        <li
                                            class="breadcrumb-item active"
                                            aria-current="page"
                                        >
                                            Kategori {{ categoryName }}
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
                                            class="d-flex justify-content-between align-items-center mb-6"
                                        >
                                            <h3 class="card-title">
                                                Kategori {{ categoryName }}
                                            </h3>
                                            <button
                                                type="button"
                                                class="btn"
                                                style="
                                                    background-color: #fff8dd;
                                                "
                                                @click="
                                                    $router.push({
                                                        name: 'elearning-puspaga',
                                                    })
                                                "
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
                                        <p class="des mb-6">
                                            {{ categoryDescription }}
                                        </p>

                                        <div
                                            class="row d-flex justify-content-start px-3 mt-5"
                                        >
                                            <div
                                                class="col-4 mb-5"
                                                v-for="(
                                                    item, index
                                                ) in subCategories"
                                                :key="index"
                                            >
                                                <div
                                                    class="card-sub"
                                                    :style="{
                                                        borderTop:
                                                            '3px solid ' +
                                                            getBorderColor(
                                                                item.status
                                                            ),
                                                    }"
                                                    @click="
                                                        navigateToSubKategori(
                                                            item.id
                                                        )
                                                    "
                                                    role="button"
                                                >
                                                    <div class="name-card">
                                                        <h5>{{ item.name }}</h5>
                                                    </div>
                                                    <div class="image-card">
                                                        <img
                                                            class="img-logo-card"
                                                            :title="
                                                                getImageTitle(
                                                                    item.status
                                                                )
                                                            "
                                                            :src="
                                                                getImageSrc(
                                                                    item.status
                                                                )
                                                            "
                                                            alt="Card Icon"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div
                                            class="row d-flex justify-content-start px-3 mt-5"
                                        >
                                            <div
                                                class="col-4 mb-5"
                                                v-for="(
                                                    item, index
                                                ) in subCategories"
                                                :key="index"
                                            >
                                                <div class="card-item">
                                                    <div class="status">
                                                        <span
                                                            v-if="
                                                                item.status == 1
                                                            "
                                                            class="text-with-icon"
                                                        >
                                                            <i
                                                                class="bi bi-journal-text fs-2"
                                                            ></i
                                                            >&nbsp; Belum
                                                            Dimulai
                                                        </span>
                                                        <span
                                                            v-else-if="
                                                                item.status == 2
                                                            "
                                                            class="text-with-icon"
                                                        >
                                                            <i
                                                                class="bi bi-journal-text fs-2"
                                                            ></i
                                                            >&nbsp; Sedang
                                                            Berjalan
                                                        </span>
                                                        <span
                                                            v-else
                                                            class="text-with-icon"
                                                        >
                                                            <i
                                                                class="bi bi-journal-text fs-2"
                                                            ></i
                                                            >&nbsp; Selesai
                                                        </span>
                                                    </div>
                                                    <div class="title">
                                                        <span>{{
                                                            item.name
                                                        }}</span>
                                                    </div>
                                                    <button
                                                        v-if="item.status == 1"
                                                        class="btn-card"
                                                        @click="
                                                            navigateToSubKategori(
                                                                item.id
                                                            )
                                                        "
                                                    >
                                                        Mulai
                                                    </button>
                                                    <button
                                                        v-else-if="
                                                            item.status == 2
                                                        "
                                                        class="btn-card"
                                                        @click="
                                                            navigateToSubKategori(
                                                                item.id
                                                            )
                                                        "
                                                    >
                                                        Lanjutkan
                                                    </button>
                                                    <button
                                                        v-else
                                                        class="btn-card"
                                                        @click="
                                                            navigateToSubKategori(
                                                                item.id
                                                            )
                                                        "
                                                    >
                                                        Selesai
                                                    </button>
                                                </div>
                                            </div>
                                        </div> -->
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
import axios from "axios";
export default {
    data() {
        return {
            categoryName: "",
            categoryDescription: "",
            subCategories: [],
        };
    },
    methods: {
        getBorderColor(status) {
            switch (status) {
                case 1:
                    return "#e74c3c";
                case 2:
                    return "#2ecc71";
                default:
                    return "#3498db";
            }
        },
        getImageSrc(status) {
            switch (status) {
                case 1:
                    return "/assets/siapppak/img/start.png";
                case 2:
                    return "/assets/siapppak/img/progress.png";
                default:
                    return "/assets/siapppak/img/finish.png";
            }
        },
        getImageTitle(status) {
            switch (status) {
                case 1:
                    return "Belum Dimulai";
                case 2:
                    return "Sedang Berjalan";
                default:
                    return "Selesai";
            }
        },
        async fetchCategory() {
            const idKategori = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/kategori/getKategori/${idKategori}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                this.categoryName = response.data.name;
                this.categoryDescription = response.data.deskripsi;
            } catch (error) {
                console.error("Error fetching category data:", error);
            }
        },
        async fetchSubCategories() {
            const idKategori = this.$route.params.id;
            try {
                const response = await axios.get(
                    `/api/subkategori/getSubKategoris/${idKategori}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "dp5a-token"
                            )}`,
                        },
                    }
                );
                console.log(response.data);
                this.subCategories = response.data.map((sub) => ({
                    id: sub.id,
                    name: sub.name,
                    status: sub.status, // Status dari backend langsung
                }));
            } catch (error) {
                console.error("Error fetching subcategories:", error);
            }
        },
        goBack() {
            this.$router.go(-1);
        },
        navigateToSubKategori(id) {
            this.$router.push({
                name: "elearningpuspaga-subkategori",
                params: { id },
            });
        },
    },
    mounted() {
        this.fetchCategory();
        this.fetchSubCategories();
        reinitializeAllPlugin();
    },
};
</script>

<style scoped>
.card-sub {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    padding: 20px;
    text-align: left;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-sub:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.5);
}

.name-card {
    height: 60px;
    font-size: 16px;
}

.image-card {
    text-align: end;
}

.img-logo-card {
    width: 18%;
    height: 18%;
}

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

.breadcrumb-item a {
    color: #ee7b33;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-item.active {
    color: #6c757d;
}

p.des {
    color: grey;
    font-size: 1rem;
}

.card-item {
    background-color: #ffe1e9;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    text-align: left;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.status {
    display: flex;
    align-items: center;
    background-color: #ffffff;
    padding: 5px 10px;
    border-radius: 4px;
    color: #f1416c;
    font-weight: 600;
    margin-bottom: 1px;
}

.title span {
    font-size: 14px;
    font-weight: 750;
    color: #ff5678;
    margin-bottom: 10px;
    line-height: 1.4;
}

.btn-card {
    background-color: white;
    color: #ff5678;
    border: none;
    padding: 5px 10px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 800;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    transition: background-color 0.3s ease;
    align-self: flex-start;
}

.btn-card:hover {
    background-color: #ff5678;
    color: white;
}

.text-with-icon {
    display: flex;
    align-items: center;
    color: #f1416c;
    font-weight: 600;
}

.text-with-icon i {
    color: red;
}

@media (max-width: 480px) {
    .row {
        display: flex;
        flex-direction: column;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    .col-4 {
        max-width: 100%; /* Hindari batasan lebar */
        margin: 0; /* Hilangkan margin tambahan */
        padding: 0; /* Hilangkan padding tambahan */
    }

    .card-sub {
        width: 300%; /* Pastikan elemen card juga lebar penuh */
        margin: 0 auto; /* Pusatkan elemen jika diperlukan */
    }
}

@media (min-width: 768px) {
    .card-item {
        height: 200px;
    }
    .name-card {
        font-size: 12px; /* Font lebih kecil di smartphone */
    }
    .img-logo-card {
        width: 28%;
        height: 28%;
    }
}

@media (min-width: 992px) {
    .card-item {
        height: 180px;
    }
    .name-card {
        font-size: 14px; /* Font lebih kecil di tablet */
    }
    .img-logo-card {
        width: 22%;
        height: 22%;
    }
}
</style>
