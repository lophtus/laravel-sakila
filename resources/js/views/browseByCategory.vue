<template>
  <div>
    <h1>{{ pageTitle }}</h1>

    <div>
      <template v-if="isLoaded">
        <CRow v-if="items.length">
          <CCol class="card-grid">
            <FilmSlide
              v-for="item in items"
              :key="item.id"
              v-bind:film="item"
              class="swiper-slide"
              @click="onSlideClick(item)"
            ></FilmSlide>
          </CCol>
        </CRow>

        <CRow v-else-if="! isBusy">
          <CCol>
            <p>No results found</p>
          </CCol>
        </CRow>

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
      @close="onModalClose"
    ></FilmModal>
  </div>
</template>

<script setup lang="ts">
import api from "@/api";
import FilmModal from "@/components/FilmModal.vue";
import FilmSlide from "@/components/FilmSlide.vue";
import { computed, onBeforeMount, ref, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const isRouted = ref(false);
const isLoaded = ref(false);
const isBusy = ref(false);
const currentPage = ref(1);
const perPage = 12;
const category = ref({});
const items = ref([]);
const currentItem = ref({});
const isModalVisible = ref(false);
const canLoadMore = ref(false);

onBeforeMount(() => {
  watch(
    () => route,
    (newRoute, oldRoute) => {
      isRouted.value = true;

      const promise = api.getCategory(newRoute.params.id);

      promise
        .then(({ data }) => {
          const category = data.data;

          category.value = category;
          isLoaded.value = true;
          fetchData(currentPage.value);
        })
        .catch(() => {
          next({ name: "not-found" });
        });
    },
    { deep: true }
  );

  if (!isLoaded.value && !isRouted.value) {
    init(route.params.id);
  }
});

const pageTitle = computed(() => {
  return !isLoaded.value ? "Loading" : category.value.name;
});

const init = (id) => {
  const promise = api.getCategory(id);

  return promise.then(({ data }) => {
    category.value = data.data;
    isLoaded.value = true;
    fetchData(currentPage.value);
  });
}

const loadMore = () => {
  fetchData(currentPage.value + 1);
}

const fetchData = (page) => {
  const promise = api.getFilmsByCategory(category.value.id, page, perPage);

  isBusy.value = true;

  return promise.then(({ data }) => {
    data.data.forEach((element) => {
      items.value.push(element);
    });

    currentPage.value = data.meta.current_page;

    canLoadMore.value = false;

    if (data.links.next != null) {
      canLoadMore.value = true;
    }

    isBusy.value = false;

    return items.value || [];
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
.card-grid {
  display: grid;
  justify-items: left;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  grid-gap: 0;
  grid-row-gap: 0;
}

$itemGrow: 1.2;
$duration: 250ms;

.swiper-slide {
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
