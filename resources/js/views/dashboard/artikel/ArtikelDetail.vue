<template>
  <div>
    <div class="pu_site_page">
      <!-- Header -->
      <app-header></app-header>
      <br>
      <!-- Artikel Detail Section -->
      <section class="article-detail">
        <br>
        <br>
        <div class="container">
          <div class="artikel-container">
            <!-- Back Button -->
            <div class="back-link">
              <button @click="$router.go(-1)" class="bi bi-chevron-double-left btn btn-sm custom-button-back">
                 Kembali
              </button>
            </div>
            <br>
            <!-- Artikel Detail -->
            <div v-if="article" class="article-detail-content">
              <!-- Judul dan Meta -->
              <div class="article-header text-center">
                <h1 class="article-title">{{ article.title || "Judul Artikel" }}</h1>
                <p class="article-meta">
                  <span class="author">Penulis: {{ article.nama_mahasiswa || "Admin" }}</span> |
                  <span class="date">Diterbitkan: {{ formatDate(article.created_at) }}</span>
                </p>
              </div>

              <!-- Thumbnail -->
              <div v-if="article.file_thumbnail" class="article-thumbnail">
                <img
                  :src="article.file_thumbnail"
                  :alt="article.title"
                  class="thumbnail-image"
                />
              </div>

              <!-- Konten Artikel -->
              <div
                class="article-body"
                v-html="article.description || 'Konten tidak tersedia.'"
              ></div>
            </div>

            <!-- Loading State -->
            <div v-else class="loading-state">
              <div class="loading-spinner"></div>
              <p>Loading artikel...</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Footer -->
      <app-footer></app-footer>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      article: null,
    };
  },
  methods: {
    fetchArticle() {
      const articleId = this.$route.params.id; // Ambil ID dari route
      axios
        .get(`/api/public/artikel/${articleId}`)
        .then((response) => {
          this.article = response.data?.data || null; // Simpan data artikel
        })
        .catch((error) => {
          console.error("Gagal mengambil artikel:", error);
        });
    },
    formatDate(date) {
      if (!date) return "Tanggal tidak diketahui";
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(date).toLocaleDateString("id-ID", options);
    },
  },
  mounted() {
    this.fetchArticle();
  },
};
</script>

<style scoped>
/* General Styling */
.container {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
}

/* Back Button */
.custom-button-back {
  background-color: #52b1a3;
  color: white;
  border-radius: 5px;
  padding: 0.5rem 1rem;
  transition: all 0.3s ease-in-out;
  display: flex;
  align-items: center;
  gap: 5px;
}

.custom-button-back:hover {
  background-color: #c81e4f;
  color: #fff;
}

.btn-icon i {
  margin-right: 5px;
  font-size: 1rem;
}

/* Artikel Container */
.artikel-container {
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
  animation: fadeIn 0.5s ease-in-out;
}

/* Article Header */
.article-header {
  margin-bottom: 20px;
}

.article-title {
  font-size: 2.5rem;
  font-weight: bold;
  color: #2c3e50;
  margin-bottom: 10px;
}

.article-meta {
  font-size: 0.9rem;
  color: #7f8c8d;
}

.article-meta .author,
.article-meta .date {
  margin-right: 10px;
}

/* Thumbnail */
.article-thumbnail {
  text-align: center;
  margin: 20px 0;
}

.thumbnail-image {
  max-width: 100%;
  height: auto;
  border-radius: 12px;
  box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.thumbnail-image:hover {
  transform: scale(1.05);
  box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.3);
}

/* Article Body */
.article-body {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #34495e;
  text-align: justify;
}

/* Loading State */
.loading-state {
  text-align: center;
  padding: 50px 20px;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.loading-state p {
  margin-top: 15px;
  color: #7f8c8d;
  font-size: 1rem;
}

/* Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
