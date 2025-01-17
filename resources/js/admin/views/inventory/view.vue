<template>
  <div>
    <b-row>
      <b-col>
        <h2>Inventory (#{{ inventory.id }})</h2>

        <router-link v-if="isLoaded" :to="{name: 'store-view', params: {id: store.id}}">{{ store.address }} {{ store.city }}, {{ store.state }} {{ store.postal_code }}</router-link>

        <h4>{{ film.title }} ({{ film.release_year }})</h4>

        <p>{{ film.description }}</p>

        <b-row>
          <b-col>Length</b-col>
          <b-col>{{ film.length }}</b-col>
        </b-row>
        <b-row>
          <b-col>Rating</b-col>
          <b-col>{{ film.rating }}</b-col>
        </b-row>
        <b-row>
          <b-col>Special Features</b-col>
          <b-col>{{ film.special_features }}</b-col>
        </b-row>
        <b-row>
          <b-col>Rental Duration</b-col>
          <b-col>{{ film.rental_duration }}</b-col>
        </b-row>
        <b-row>
          <b-col>Rental Rate</b-col>
          <b-col>{{ film.rental_rate }}</b-col>
        </b-row>
        <b-row>
          <b-col>Replacement Cost</b-col>
          <b-col>{{ film.replacement_cost }}</b-col>
        </b-row>
      </b-col>
      <b-col cols="auto">
        <b-img src="https://dummyimage.com/300x300/e/5.png"></b-img>
      </b-col>
    </b-row>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { onBeforeMount, ref } from "vue";
import { useRoute } from "vue-router/composables";

const route = useRoute();

const isLoaded = ref(false);
const film = ref({});
const inventory = ref({});
const store = ref({});

onBeforeMount(() => {
    const promise = axios.get("/inventory/" + route.params.id + "?include=film,store");

    return promise.then(({ data }) => {
      const item = data.data;

      film.value = item.film || {};
      inventory.value = item || {};
      store.value = item.store || {};
      isLoaded.value = true;
    });
});
</script>

<style scoped>
</style>
