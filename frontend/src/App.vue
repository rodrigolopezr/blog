<template>
  <v-app>
    <blog-view />
  </v-app>
</template>

<script>
import BlogView from "./components/BlogView.vue";

export default {
  name: "App",
  components: {
    BlogView,
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
