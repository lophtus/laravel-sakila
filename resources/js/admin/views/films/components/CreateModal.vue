<template>
  <b-modal
    ref="createModal"
    id="create-modal"
    title="Create Film"
    @show="resetModal"
    @ok="handleOkay"
  >
    <p>Use the form below to create a new film.</p>

    <ValidationObserver ref="formObserver" v-slot="{ passes }">
      <b-form @submit.stop.prevent="passes(onSubmit)">
        <ValidationProvider rules="required" name="title" v-slot="{ valid, errors }">
          <b-form-group label="Title">
            <b-input v-model="form.title" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider name="description" v-slot="{ valid, errors }">
          <b-form-group label="Description">
            <b-textarea
              v-model="form.description"
              :state="errors[0] ? false : (valid ? true : null)"
            ></b-textarea>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider name="length" v-slot="{ valid, errors }">
          <b-form-group label="Length">
            <b-input v-model="form.length" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider name="release_year" v-slot="{ valid, errors }">
          <b-form-group label="Release Year">
            <b-input
              v-model="form.release_year"
              :state="errors[0] ? false : (valid ? true : null)"
            />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider name="rating" v-slot="{ valid, errors }">
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

        <ValidationProvider name="special_features" v-slot="{ valid, errors }">
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

        <ValidationProvider rules="required" name="rental_duration" v-slot="{ valid, errors }">
          <b-form-group label="Rental Duration">
            <b-input
              v-model="form.rental_duration"
              :state="errors[0] ? false : (valid ? true : null)"
            />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="rental_rate" v-slot="{ valid, errors }">
          <b-form-group label="Rental Rate">
            <b-input v-model="form.rental_rate" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="replacement_cost" v-slot="{ valid, errors }">
          <b-form-group label="Replacement Cost">
            <b-input
              v-model="form.replacement_cost"
              :state="errors[0] ? false : (valid ? true : null)"
            />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>
      </b-form>
    </ValidationObserver>

    <template v-slot:modal-ok>
      <b-spinner v-if="isSaving" class="mr-2" small></b-spinner>Save
    </template>
  </b-modal>
</template>

<script setup lang="ts">
import axios from "axios";
import { getCurrentInstance, ref } from "vue";
import { useRouter } from "vue-router/composables";
import { RatingList, SpecialFeatureList } from "@/admin/data/film_constants";

const { proxy } = getCurrentInstance();

const isSaving = ref(false);
const ratings = RatingList;
const special_features = SpecialFeatureList;
const form = ref({});

const resetModal = () => {
  form.value = {};
}

const handleOkay = (bvModalEvt) => {
  bvModalEvt.preventDefault();

  onSubmit();
}

const onSubmit = async () => {
  isSaving.value = true;

  const promise = axios.post("/films", form.value);

  promise
    .then(({ data }) => {
      const film = data.data;

      router.push({ name: "film-view", params: { id: film.id } });

      proxy.$toasted.show("Film was created successfully", {
        type: "success",
        icon: "far fa-check-circle"
      });
    })
    .catch(error => {
      if (error.response.data.errors) {
        proxy.$refs.formObserver.setErrors(error.response.data.errors);
      }
    })
    .finally(() => {
      isSaving.value = false;
    });
}
</script>

<style scoped>
</style>
