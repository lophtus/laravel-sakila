<template>
  <div>
    <h2>CreateFilm</h2>

    <p>Use the form below to create a film.</p>

    <ValidationErrors v-if="validationErrors" :errors="validationErrors" />

    <ValidationObserver ref="observer" v-slot="{ passes }">
      <b-form @submit.prevent="passes(onSubmit)">
        <ValidationProvider rules="required" name="Title" v-slot="{ valid, errors }">
          <b-form-group label="Title">
            <b-input v-model="form.title" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider name="Description" v-slot="{ valid, errors }">
          <b-form-group label="Description">
            <b-textarea
              v-model="form.description"
              :state="errors[0] ? false : (valid ? true : null)"
            ></b-textarea>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="Length" v-slot="{ valid, errors }">
          <b-form-group label="Length">
            <b-input v-model="form.length" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="ReleaseYear" v-slot="{ valid, errors }">
          <b-form-group label="Release Year">
            <b-input
              v-model="form.release_year"
              :state="errors[0] ? false : (valid ? true : null)"
            />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="Rating" v-slot="{ valid, errors }">
          <b-form-group label="Rating">
            <b-select
              v-model="form.rating"
              :options="ratings"
              :state="errors[0] ? false : (valid ? true : null)"
            >
              <template v-slot:first>
                <b-form-select-option :value="null" disabled>Select a rating</b-form-select-option>
              </template>
            </b-select>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider name="SpecialFeatures" v-slot="{ valid, errors }">
          <b-form-group label="Special Features">
            <b-select
              v-model="form.special_features"
              :options="special_features"
              :state="errors[0] ? false : (valid ? true : null)"
            >
              <template v-slot:first>
                <b-form-select-option :value="null">None</b-form-select-option>
              </template>
            </b-select>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="RentalDuration" v-slot="{ valid, errors }">
          <b-form-group label="Rental Duration">
            <b-input
              v-model="form.rental_duration"
              :state="errors[0] ? false : (valid ? true : null)"
            />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="RentalRate" v-slot="{ valid, errors }">
          <b-form-group label="Rental Rate">
            <b-input v-model="form.rental_rate" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="ReplacementCost" v-slot="{ valid, errors }">
          <b-form-group label="Replacement Cost">
            <b-input
              v-model="form.replacement_cost"
              :state="errors[0] ? false : (valid ? true : null)"
            />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <b-button type="submit" variant="primary" :disabled="isSaving">
          <b-spinner v-if="isSaving" class="mr-2" small></b-spinner>Save
        </b-button>
        <b-link @click="$router.go(-1)">Cancel</b-link>
      </b-form>
    </ValidationObserver>
  </div>
</template>

<script>
import axios from "axios";
import ValidationErrors from "../../components/ValidationErrors";
import { RatingList, SpecialFeatureList } from "../../data/film_constants";

export default {
  name: "FilmEdit",
  components: {
    ValidationErrors
  },
  data() {
    return {
      isSaving: false,
      validationErrors: null,
      ratings: RatingList,
      special_features: SpecialFeatureList,
      form: {
        title: null,
        description: null,
        length: null,
        release_year: null,
        rating: null,
        special_features: null,
        rental_duration: null,
        rental_rate: null,
        replacement_cost: null
      },
    };
  },
  methods: {
    async onSubmit() {
      let vm = this;

      vm.isSaving = true;

      const promise = axios.post("/films", vm.form);

      promise
        .then(({ data }) => {
          const film = data.data;

          vm.$router.push({ name: "film-view", params: { id: film.id } });
          vm.$toasted.show("Film was created successfully", {
            type: "success",
            icon: "far fa-check-circle"
          });
        })
        .catch(error => {
          vm.validationErrors = error.response.data.errors;
          window.scrollTo(0, 0);
        })
        .finally(() => {
          vm.isSaving = false;
        });
    }
  }
};
</script>

<style scoped>
</style>
