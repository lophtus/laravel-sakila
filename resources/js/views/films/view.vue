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
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FilmView",
  data() {
    return {
      film: {}
    };
  },
  beforeRouteEnter(to, from, next) {
    const promise = axios.get("/films/" + to.params.id);

    return promise.then(({ data }) => {
      const film = data.data;

      next(vm => {
        vm.film = film || {};
      });
    });
  }
};
</script>

<style scoped>
</style>
