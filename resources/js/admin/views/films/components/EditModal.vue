<template>
  <CModal :visible="visible">
    <CModalHeader>
      <CModalTitle>Edit Film</CModalTitle>
    </CModalHeader>

    <CModalBody>
      <p>Use the form below to update the film.</p>

      <CForm
        class="needs-validation"
        novalidate
        :validated="isValidated"
        @submit.prevent="onSubmit"
      >
        <CFormInput
          v-model="form.title"
          id="inputTitle"
          label="Title"
          required
        />

        <CFormTextarea
          v-model="form.description"
          id="inputDescription"
          label="Description"
        ></CFormTextarea>

        <CFormInput
          v-model="form.length"
          id="inputLength"
          label="Length"
        />

        <CFormInput
          v-model="form.release_year"
          id="inputReleaseYear"
          label="Release Year"
        />

        <CFormSelect
          v-model="form.rating"
          :options="['Select a rating', ...ratings]"
          id="inputRating"
          label="Rating"
          feedbackInvalid="Please select a valid rating."
        />

        <CFormSelect
          v-model="form.special_features"
          :options="['None', ...ratings]"
          id="inputSpecialFeatures"
          label="Special Features"
        />

        <CFormInput
          v-model="form.release_duration"
          id="inputReleaseDuration"
          label="Release Duration"
          required
        />

        <CFormInput
          v-model="form.rental_rate"
          id="inputRentalRate"
          label="Rental Rate"
          required
        />

        <CFormInput
          v-model="form.replacement_cost"
          id="inputReplacementCost"
          label="Replacement Cost"
          required
        />
      </CForm>
    </CModalBody>

    <CModalFooter>
      <CButton color="primary" @click="onSubmit">
        <CSpinner v-if="isSaving" class="mr-2" small /> Save
      </CButton>
    </CModalFooter>
  </CModal>
</template>

<script setup lang="ts">
import axios from "axios";
import { getCurrentInstance, ref } from "vue";
import { useToasted } from "@hoppscotch/vue-toasted";
import { RatingList, SpecialFeatureList } from "@/admin/data/film_constants";

const props = defineProps({
  populateWith: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['saved']);

const { proxy } = getCurrentInstance();
const toasted = useToasted();

const isSaving = ref(false);
const isValidated = ref(false);
const ratings = RatingList;
const special_features = SpecialFeatureList;
const form = ref(Object.assign({}, props.populateWith));

const onSubmit = async () => {
  const form = event.currentTarget;

  if (form.checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();
  }

  isValidated.value = true;
  isSaving.value = true;

  const promise = axios.patch("/films/" + form.value.id, form.value);

  promise
    .then(({ data }) => {
      const film = data.data;

      emit('saved', film);

      proxy.$refs.editModal.hide();

      toasted.show("Film was updated successfully", {
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
