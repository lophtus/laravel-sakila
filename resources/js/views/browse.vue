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

    <b-alert v-else variant="danger" show>No categories found.</b-alert>
  </div>
</template>

<script>
let isRouted = false;

import api from "@/api";
import CategorySlide from "@/components/CategorySlide";

export default {
  name: "BrowseView",
  components: {
    CategorySlide,
  },
  data() {
    return {
      items: [],
      isLoaded: false,
    };
  },
  beforeRouteEnter(to, from, next) {
    isRouted = true;

    const promise = api.getCategories();

    return promise.then(({ data }) => {
      next((vm) => {
        vm.items = data.data || [];
        vm.isLoaded = true;
      });
    });
  },
  created() {
    const vm = this;

    if (!vm.isLoaded && !isRouted) {
      vm.init(vm.$route.params.id);
    }
  },
  methods: {
    init: function (id) {
      const vm = this;

      const promise = api.getCategories();

      return promise.then(({ data }) => {
        vm.items = data.data;
        vm.isLoaded = true;
      });
    },
    onClick: function (item) {
      const vm = this;

      vm.$router.push({ name: "browse-by-category", params: { id: item.id } });
    },
  },
};
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
