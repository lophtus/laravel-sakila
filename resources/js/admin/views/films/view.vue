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
        <b-img src="https://via.placeholder.com/300x300"></b-img>
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

<script>
import axios from "axios";
import EditModal from "./components/EditModal";

export default {
  name: "FilmView",
  components: {
    EditModal
  },
  data() {
    return {
      isLoaded: false,
      film: {}
    };
  },
  beforeRouteEnter(to, from, next) {
    const promise = axios.get("/films/" + to.params.id);

    return promise.then(({ data }) => {
      const film = data.data;

      next(vm => {
        vm.film = film || {};
        vm.isLoaded = true;
      });
    });
  },
  methods: {
    onSave(film) {
      this.film = film;
    },
    async onDelete() {
      let vm = this;

      vm.$bvModal
        .msgBoxConfirm("Do you really want to delete this film?", {})
        .then(value => {
          if (value) {
            const promise = axios.delete("/films/" + vm.film.id);

            promise.then(() => {
              vm.$router.push({ name: "film-list" });
              vm.$toasted.show("Film was deleted successfully", {
                type: "success",
                icon: "far fa-check-circle"
              });
            });
          }
        });
    }
  }
};
</script>

<style scoped>
</style>
