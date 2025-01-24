<template>
  <div />
</template>

<script setup lang="ts">
import { onBeforeMount } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();

onBeforeMount(() => {
  store.commit("logoutUser");
  router.push({name: "login"});
});
</script>
