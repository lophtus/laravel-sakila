<template>
  <div>
    <div class="my-4">
      <div v-if="items.length">
        <CRow v-for="item in items" :key="item.id">
          <CCol>
            <CategoryDashboardWidget
              :category="item"
              @click="onSlideClick"
            ></CategoryDashboardWidget>
          </CCol>
        </CRow>
      </div>

      <div v-else-if="isBusy">
        <CSpinner></CSpinner>
      </div>

      <div v-else>
        <p>No results found</p>
      </div>
    </div>

    <FilmModal
      v-if="currentItem"
      :visible="isModalVisible"
      :filmId="currentItem.id"
      @close="onModalClose"
    ></FilmModal>
  </div>
</template>

<script setup lang="ts">
import api from "@/api";
import CategoryDashboardWidget from "@/components/CategoryDashboardWidget.vue";
import FilmModal from "@/components/FilmModal.vue";
import { onMounted, ref } from "vue";

const isBusy = ref(false);
const currentItem = ref({});
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
  currentItem.value = {};
  isModalVisible.value = false;
}
</script>

<style lang="scss" scoped>
</style>
