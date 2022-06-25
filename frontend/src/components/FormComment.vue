<template>
  <div>
    <p class="text-h6">Leave a {{ reply ? "Reply" : "comment" }}</p>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-text-field
        v-model="userName"
        :rules="[(v) => !!v || 'Is required']"
        label="User Name"
        required
      ></v-text-field>

      <v-textarea
        v-model="comment"
        :rules="[(v) => !!v || 'Is required']"
        label="Comment"
        required
        multi-line
      />
      <v-btn color="success" class="mr-4" @click="addComment"> Send </v-btn>
      <v-btn color="error" class="mr-4" @click="close" v-if="reply">
        Close
      </v-btn>
      <v-progress-circular
        :size="50"
        color="primary"
        indeterminate
        v-if="loading"
      ></v-progress-circular>
    </v-form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormComment",
  props: {
    reply: {
      type: Boolean,
      default: false,
    },
    commentId: {
      type: Number,
      default: 0,
    },
  },
  data: () => ({
    userName: null,
    comment: null,
    valid: false,
    loading: false,
  }),
  methods: {
    async addComment() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        const payload = {
          UserName: this.userName,
          Comment: this.comment,
          CommentId: this.commentId > 0 ? this.commentId : null,
        };

        if (!this.reply) await this.saveComment(payload);
        else await this.saveReply(payload);

        this.userName = null;
        this.comment = null;
        this.loading = false;

        this.$emit("saved");
      }
    },
    async saveComment(payload) {
      return new Promise((resolve, reject) => {
        axios
          .post(
            `${process.env.VUE_APP_HTTP}${process.env.VUE_APP_ENDPOINT}/comments/new`,
            payload
          )
          .then((response) => {
            // eslint-disable-next-line no-console
            const { data } = response.data;
            resolve(data);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
    async saveReply(payload) {
      return new Promise((resolve, reject) => {
        axios
          .post(
            `${process.env.VUE_APP_HTTP}${process.env.VUE_APP_ENDPOINT}/comments/reply`,
            payload
          )
          .then((response) => {
            // eslint-disable-next-line no-console
            const { data } = response.data;
            resolve(data);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
    close() {
      this.$emit("close");
    },
  },
};
</script>

<style></style>
