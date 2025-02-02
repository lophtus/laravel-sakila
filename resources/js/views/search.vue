<template>
  <CContainer>
    <CForm @submit.prevent="onSubmit">
      <CInputGroup>
        <CFormInput v-model="search" />

        <CButton color="success" type="submit">Search</CButton>
        <CButton color="danger" @click="clearSearch()">Clear</CButton>
      </CInputGroup>
    </CForm>

    <div class="my-4">
      <template v-if="hasSearched">
        <CRow v-if="items.length">
          <CCol class="card-grid">
            <FilmSlide
              v-for="item in items"
              :key="item.id"
              v-bind:film="item"
              class="card-slide"
              @click="onSlideClick(item)"
            ></FilmSlide>
          </CCol>
        </CRow>

        <div v-else-if="!isBusy">
          <p>No results found</p>
        </div>

        <CRow v-if="canLoadMore">
          <CCol class="text-center">
            <CButton color="dark" @click="loadMore()">Load More</CButton>
          </CCol>
        </CRow>
      </template>

      <CSpinner v-show="isBusy"></CSpinner>
    </div>

    <FilmModal
      v-if="currentItem"
      :visible="isModalVisible"
      :filmId="currentItem.id"
      @close="onClose"
    ></FilmModal>
  </CContainer>
</template>

<script setup lang="ts">
import api from "@/api";
import FilmModal from "@/components/FilmModal.vue";
import FilmSlide from "@/components/FilmSlide.vue";
import { ref } from "vue";

const search = ref("");
const isBusy = ref(false);
const currentPage = ref(1);
const perPage = 12;
const items = ref([]);
const currentItem = ref({});
const isModalVisible = ref(false);
const canLoadMore = ref(false);
const hasSearched = ref(false);

const onSlideClick = (film) => {
  currentItem.value = film;
  isModalVisible.value = true;
}

const onClose = () => {
  currentItem.value = {};
  isModalVisible.value = false;
}

const clearSearch = () => {
  search.value = "";
  currentPage.value = 0;
  items.value = [];
  hasSearched.value = false;
}

const onSubmit = () => {
  items.value = [];
  fetchData(currentPage.value);
}

const loadMore = () => {
  fetchData(currentPage.value + 1);
}

const fetchData = (page) => {
  isBusy.value = true;

  const promise = api.searchFilms(search.value, page, perPage);

  return promise.then(({ data }) => {
    data.data.forEach((element) => {
      items.value.push(element);
    });

    hasSearched.value = true;

    currentPage.value = data.meta.current_page;

    canLoadMore.value = false;

    if (data.links.next != null) {
      canLoadMore.value = true;
    }

    isBusy.value = false;

    return items.value || [];
  });
}
</script>

<style lang="scss" scoped>
.card-grid {
  display: grid;
  justify-items: left;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  grid-gap: 0;
  grid-row-gap: 0;
}

$itemGrow: 1.2;
$duration: 250ms;

.card-slide {
  width: 300px;
  height: 150px;
  margin: 30px 0;
  transition: $duration all;

  &:hover {
    z-index: 9999;
    transform: scale($itemGrow);
  }
}
</style>
