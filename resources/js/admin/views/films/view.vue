<template>
  <div>
    <b-row>
      <b-col>
        <h2>{{ film.title }} ({{ film.release_year }})</h2>

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

    <b-button variant="primary" size="sm" v-b-modal.edit-modal>
      <i class="far fa-edit"></i>
      Edit
    </b-button>

    <b-button variant="danger" size="sm" @click="onDelete">
      <i class="far fa-times-circle"></i>
      Delete
    </b-button>

    <EditModal :populateWith="film" @saved="onSave"></EditModal>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { getCurrentInstance, onBeforeMount, ref } from "vue";
import { useRoute, useRouter } from "vue-router/composables";
import EditModal from "./components/EditModal.vue";

const { proxy } = getCurrentInstance();
const route = useRoute();
const router = useRouter();

const isLoaded = ref(false);
const film = ref({});

onBeforeMount(() => {
  const promise = axios.get("/films/" + route.params.id);

  return promise.then(({ data }) => {
    const item = data.data;

    film.value = item || {};
    isLoaded.value = true;
  });
});

const onSave = (filmObj) => {
  film.value = filmObj;
}

const onDelete = async () => {
  proxy.$bvModal
    .msgBoxConfirm("Do you really want to delete this film?", {})
    .then(value => {
      if (value) {
        const promise = axios.delete("/films/" + film.value.id);

        promise.then(() => {
          router.push({ name: "film-list" });
          proxy.$toasted.show("Film was deleted successfully", {
            type: "success",
            icon: "far fa-check-circle"
          });
        });
      }
    });
}
</script>

<style scoped>
</style>
