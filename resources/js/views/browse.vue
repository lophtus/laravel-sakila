<template>
  <div>
    <b-spinner v-if="!isLoaded"></b-spinner>

    <div v-if="isLoaded && items.length">
      <div class="card-grid">
        <CategorySlide
          v-for="item in items"
          :key="item.id"
          :category="item"
          class="card-slide"
          @click="onClick(item)"
        ></CategorySlide>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import api from "@/api";
import CategorySlide from "@/components/CategorySlide";
import { onBeforeMount, ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router/composables";

const router = useRouter();
const route = useRoute();

const isRouted = ref(false);
const isLoaded = ref(false);
const items = ref([]);

onBeforeMount(() => {
  watch(
    () => route,
    (newRoute, oldRoute) => {
      isRouted.value = true;

      const promise = api.getCategories();

      promise.then(({ data }) => {
        items.value = data.data || [];
        isLoaded.value = true;
      });
    },
    { deep: true }
  );

  if (!isLoaded.value && !isRouted.value) {
    init(route.params.id);
  }
});

const init = (id) => {
  const promise = api.getCategories();

  return promise.then(({ data }) => {
    items.value = data.data;
    isLoaded.value = true;
  });
}

const onClick = (item) => {
  router.push({ name: "browse-by-category", params: { id: item.id } });
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
