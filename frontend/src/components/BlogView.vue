<template>
  <v-container class="fill-height mainContainer" fluid>
    <v-row no-gutters>
      <v-col md="6">
        <v-img
          class="fill-height"
          :src="require('@/assets/welcome.30b63204.png')"
        />
      </v-col>
      <v-col md="6">
        <base-buble1 style="transform: rotate(180deg) translateY(25%)" />
        <v-container>
          <span class="text-h2">My Blog</span>
          <v-container class="pa-10">
            <p class="font-weight-light text-justify">
              Contrary to popular belief, Lorem Ipsum is not simply random text.
              It has roots in a piece of classical Latin literature from 45 BC,
              making it over 2000 years old. Richard McClintock, a Latin
              professor at Hampden-Sydney College in Virginia, looked up one of
              the more obscure Latin words, consectetur, from a Lorem Ipsum
              passage, and going through the cites of the word in classical
              literature, discovered the undoubtable source. Lorem Ipsum comes
              from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et
              Malorum" (The Extremes of Good and Evil) by Cicero, written in 45
              BC. This book is a treatise on the theory of ethics, very popular
              during the Renaissance.
            </p>
          </v-container>
          <v-container>
            <v-progress-circular
              :size="50"
              color="primary"
              indeterminate
              v-if="loading"
            ></v-progress-circular>
            <comments-view
              :comments.sync="comments"
              @refreshComments="loadComments"
            />
            <form-comment @saved="loadComments" />
          </v-container>
        </v-container>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import BaseBuble1 from "./Bubble1.vue";
import FormComment from "./FormComment.vue";
import CommentsView from "./CommentsView.vue";
import axios from "axios";

export default {
  name: "BlogView",
  components: {
    BaseBuble1,
    FormComment,
    CommentsView,
  },
  data: () => ({
    comments: [],
    loading: false,
  }),
  created() {
    this.loadComments();
  },
  methods: {
    async loadComments() {
      this.loading = true;
      this.comments = await this.getComments();
      this.loading = false;
    },
    getComments() {
      return new Promise((resolve, reject) => {
        axios
          .get(
            `${process.env.VUE_APP_HTTP}${process.env.VUE_APP_ENDPOINT}/comments`
          )
          .then((response) => {
            const { data } = response;
            resolve(data.success);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
  },
};
</script>

<style lang="css" scoped>
.mainContainer {
  padding: 0px !important;
}
</style>
