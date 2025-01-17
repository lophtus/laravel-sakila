<template>
  <div>
    <div class="my-4">
      <div v-if="items.length">
        <b-row v-for="item in items" :key="item.id">
          <b-col>
            <CategoryDashboardWidget :category="item" @click="onSlideClick"></CategoryDashboardWidget>
          </b-col>
        </b-row>
      </div>

      <div v-else-if="isBusy">
        <b-spinner></b-spinner>
      </div>

      <div v-else>
        <p>No results found</p>
      </div>
    </div>

    <FilmModal v-if="currentItem" :visible="isModalVisible" :filmId="currentItem.id" @close="onModalClose"></FilmModal>

  </div>
</template>

<script setup lang="ts">
import api from "@/api";
import CategoryDashboardWidget from "@/components/CategoryDashboardWidget";
import FilmModal from "@/components/FilmModal";
import { onMounted, ref } from "vue";

const isBusy = ref(false);
const currentItem = ref();
const items = ref([]);
const isModalVisible = ref(false);

onMounted(() => {
    fetchData();
})

const fetchData = () => {
  isBusy.value = true;

  const promise = api.getSuggestions();

  return promise.then(({ data }) => {
    items.value = data.data;

    isBusy.value = false;

    return items || [];
  });
}

const onSlideClick = (film) => {
  currentItem.value = film;
  isModalVisible.value = true;
}

const onModalClose = () => {
  currentItem.value = null;
  isModalVisible.value = false;
}
</script>

<style lang="scss" scoped>
</style>
