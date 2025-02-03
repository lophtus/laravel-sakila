<template>
  <CCard>
    <CCardHeader as="h5">Edit Film</CCardHeader>
    <CCardBody>
      <CSpinner v-if="!isLoaded" />

      <template v-else>
        <p>Use the form below to update the film.</p>

        <CForm
          class="needs-validation"
          novalidate
          @submit.prevent="onSubmit"
        >
          <CFormInput
            v-model="formData.title"
            id="inputTitle"
            label="Title"
            :feedbackInvalid="errorMessage('title')"
            :invalid="hasErrors('title')"
          />

          <CFormInput
            v-model="formData.release_year"
            id="inputReleaseYear"
            label="Release Year"
            :feedbackInvalid="errorMessage('release_year')"
            :invalid="hasErrors('release_year')"
          />

          <CFormTextarea
            v-model="formData.description"
            id="inputDescription"
            label="Description"
            rows="3"
          ></CFormTextarea>

          <CFormInput
            v-model="formData.length"
            id="inputLength"
            label="Length"
            :feedbackInvalid="errorMessage('length')"
            :invalid="hasErrors('length')"
          />

          <CFormSelect
            v-model="formData.rating"
            :options="['Select a rating', ...RatingList]"
            id="inputRating"
            label="Rating"
            :feedbackInvalid="errorMessage('rating')"
            :invalid="hasErrors('rating')"
          />

          <CFormInput
            v-model="formData.rental_duration"
            id="inputRentalDuration"
            label="Rental Duration"
            :feedbackInvalid="errorMessage('rental_duration')"
            :invalid="hasErrors('rental_duration')"
          />

          <CFormInput
            v-model="formData.rental_rate"
            id="inputRentalRate"
            label="Rental Rate"
            :feedbackInvalid="errorMessage('rental_rate')"
            :invalid="hasErrors('rental_rate')"
          />

          <CFormInput
            v-model="formData.replacement_cost"
            id="inputReplacementCost"
            label="Replacement Cost"
            :feedbackInvalid="errorMessage('replacement_cost')"
            :invalid="hasErrors('replacement_cost')"
          />

          <div class="d-grid gap-1 d-md-flex justify-content-md-start mt-2">
            <CButton type="submit" color="primary">
              <CSpinner v-if="isSaving" class="mr-2" small /> Save
            </CButton>

            <router-link :to="{ name: 'film-view', params: { id: props.id }}" class="ms-2 mt-2">Cancel</router-link>
          </div>
        </CForm>
      </template>
    </CCardBody>
  </CCard>
</template>

<script setup lang="ts">
import axios from "axios";
import { ref, watch } from "vue";
import { useRouter } from "vue-router";
import useToast from "@/admin/composables/useToast";
import { RatingList } from "@/admin/data/film_constants";
import { type EntityIdentifier, type FilmWithDefaults } from "@/admin/types";

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['saved']);

const router = useRouter();
const { toastSuccess } = useToast();

const isLoaded = ref(false);
const isSaving = ref(false);
const isValidated = ref(false);
const formData = ref<FilmWithDefaults>({});
const errors = ref();

const fetchData = (id: EntityIdentifier) => {
  const promise = axios.get("/films/" + id);

  return promise.then(({ data }) => {
    const item = data.data;

    formData.value = Object.assign(item || {});
    isLoaded.value = true;
  });
}

watch(() => props.id, fetchData, { immediate: true });

const errorMessage = (name: string) => {
  if (hasErrors(name)) {
    return errors.value[name]?.[0];
  }
}

const hasErrors = (name: string) => {
  if (errors.value && name in errors.value) {
    return true;
  }

  return false;
}

const onSubmit = (evt: Event) => {
  const formElement = evt.currentTarget as HTMLFormElement;

  if (formElement.checkValidity() === false) {
    evt.preventDefault();
    evt.stopPropagation();
    return;
  }

  isValidated.value = true;
  isSaving.value = true;

  const promise = axios.patch("/films/" + props.id, formData.value);

  promise
    .then(({ data }) => {
      const film = data.data;

      emit("saved", film);

      toastSuccess("Film was updated successfully");

      router.push({
        name: "film-view",
        params: { id: film.id }
      });
    })
    .catch(error => {
      if (error.response.data.errors) {
        errors.value = error.response.data.errors || {};
      }
    })
    .finally(() => {
      isSaving.value = false;
    });
}
</script>

<style lang="sass" scoped>
</style>
