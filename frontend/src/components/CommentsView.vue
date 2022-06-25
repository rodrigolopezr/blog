<template>
  <v-container>
    <p class="title text-left" v-if="comments.length"></p>
    <v-list-item v-for="comment in comments" :key="comment.id">
      <v-list-item-icon>
        <v-icon>mdi-account-circle</v-icon>
      </v-list-item-icon>
      <v-list-item-content class="text-left">
        <v-list-item-title v-text="comment.UserName" />
        <v-list-item-subtitle v-text="comment.Comment" />
        <v-container>
          <p v-if="comment.replies.length">Replies</p>
          <v-list-item v-for="(reply, i) in comment.replies" :key="i">
            <v-list-item-icon>
              <v-icon>mdi-account-circle</v-icon>
            </v-list-item-icon>
            <v-list-item-content class="text-left">
              <v-list-item-title v-text="reply.UserName" />
              <v-list-item-subtitle v-text="reply.Comment" />
            </v-list-item-content>
          </v-list-item>
        </v-container>

        <v-btn class="ma-1" color="error" plain @click="reply(comment)">
          Reply
        </v-btn>
        <template v-if="showReply && commentId === comment.id">
          <form-comment
            reply
            :commentId="comment.id"
            @saved="refreshComments"
            @close="showReply = false"
          ></form-comment>
        </template>
      </v-list-item-content>
    </v-list-item>
    <v-snackbar v-model="snackbar">
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-container>
</template>

<script>
import FormComment from "./FormComment.vue";

export default {
  name: "CommentsView",
  components: {
    FormComment,
  },
  props: {
    comments: [],
  },
  data: () => ({
    showReply: false,
    snackbar: false,
    text: "",
    commentId: 0,
  }),
  methods: {
    reply(comment) {
      if (comment.replies.length < 3) {
        this.showReply = true;
        this.commentId = comment.id;
      } else {
        this.text = "Only 3 replies are allowed";
        this.snackbar = true;
      }
    },
    refreshComments() {
      this.showReply = false;
      this.$emit("refreshComments");
    },
  },
};
</script>

<style></style>
