<template>
  <div>
    <div class="pu_site_page">
      <!-- Header -->
      <app-header></app-header>

      <!-- Breadcrumb Section -->
      <section>
        <div class="article-detail">
          <div v-if="article">
            <h1>{{ article.title }}</h1>
            <img :src="article.file_thumbnail" alt="Article Image" v-if="article.file_thumbnail" />
            <p v-html="article.description"></p>
          </div>
          <div v-else>
            <p>Loading...</p>
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
      const articleId = this.$route.params.id; // Retrieve the article ID from route parameters
      axios
        .get(`/api/public/artikel/${articleId}`) // Ensure API endpoint is correct
        .then((response) => {
          if (response.data && response.data.data) {
            this.article = response.data.data; // Assign the article data
          } else {
            console.error("No data received:", response);
          }
        })
        .catch((error) => {
          console.error("Error fetching article:", error);
        });
    },
  },
  mounted() {
    // Call the fetchArticle method when the component is mounted
    this.fetchArticle();
  },
};
</script>

<style>
.article-detail {
  max-width: 800px;
  margin: auto;
  padding: 20px;
}
.article-detail img {
  max-width: 100%;
  margin: 20px 0;
}
</style>
