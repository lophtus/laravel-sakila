<template>
  <div>
    <h2>
      <router-link
        :to="{
          name: 'browse-by-category',
          params: { id: category.id },
        }"
        >{{ category.name }}</router-link
      >
    </h2>

    <div class="swiper-container">
      <div class="swiper-wrapper">
        <FilmSlide
          v-for="item in category.films"
          :key="item.id"
          :film="item"
          class="swiper-slide"
          @click="onClick(item)"
        ></FilmSlide>

        <div
          class="swiper-slide view-more border d-flex justify-content-center"
        >
          <div class="my-auto">
            <router-link
              :to="{ name: 'browse-by-category', params: { id: category.id } }"
              >View More</router-link
            >
          </div>
        </div>
      </div>
      <div class="swiper-button-prev" slot="button-prev"></div>
      <div class="swiper-button-next" slot="button-next"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
import FilmSlide from "./FilmSlide.vue";
import "swiper/swiper-bundle.css";
import Swiper, { Navigation } from "swiper";
import { onMounted } from "vue";

Swiper.use(Navigation);

const props = defineProps({
  category: Object,
});

const emit = defineEmits([ 'click' ]);

onMounted(() => {
  const swiperOptions = {
    slidesPerView: "auto",
    spaceBetween: 10,
    observer: true,
    observeParents: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  };

  const swiper = new Swiper(".swiper-container", swiperOptions);
});

const onClick = (film) => {
  emit("click", film);
}
</script>

<style lang="scss" scoped>
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

.view-more {
  background-color: #fff;
}
</style>
