<template>
  <div />
</template>

<script setup lang="ts">
import { useStore } from "@/store.js";
import { onBeforeMount } from "vue";
import { useRouter } from "vue-router/composables";

const store = useStore();
const router = useRouter();

onBeforeMount(() => {
  store.commit("logoutUser");
  router.push({name: "login"});
});
</script>
