
<template>
  <CCard>
    <CCardHeader as="h5">Edit Store</CCardHeader>
    <CCardBody>
      <CSpinner v-if="!isLoaded" />

      <template v-else>
        <p>Use the form below to update the store.</p>

        <CForm
          class="needs-validation"
          novalidate
          @submit.prevent="onSubmit"
        >
          <CFormInput
            v-model="formData.address"
            id="inputAddress"
            label="Address"
            :feedbackInvalid="errorMessage('address')"
            :invalid="hasErrors('address')"
          />

          <CFormInput
            v-model="formData.address2"
            id="inputAddress2"
            label="Address 2"
            :feedbackInvalid="errorMessage('address2')"
            :invalid="hasErrors('address2')"
          />

          <CFormInput
            v-model="formData.city"
            id="inputCity"
            label="City"
            :feedbackInvalid="errorMessage('city')"
            :invalid="hasErrors('city')"
          />

          <CFormSelect
            v-model="formData.state"
            :options="['Select a state', ...states]"
            id="inputState"
            label="State"
            :feedbackInvalid="errorMessage('state')"
            :invalid="hasErrors('state')"
          />

          <CFormSelect
            v-model="formData.country"
            :options="['Select a country', ...countries]"
            id="inputCountry"
            label="Country"
            :feedbackInvalid="errorMessage('country')"
            :invalid="hasErrors('country')"
          />

          <CFormInput
            v-model="formData.postal_code"
            id="inputPostalCode"
            label="Postal Code"
            :feedbackInvalid="errorMessage('postal_code')"
            :invalid="hasErrors('postal_code')"
          />

          <CFormInput
            v-model="formData.phone"
            id="inputPhone"
            label="Phone"
            :feedbackInvalid="errorMessage('phone')"
            :invalid="hasErrors('phone')"
          />

          <div class="d-grid gap-1 d-md-flex justify-content-md-start mt-2">
            <CButton type="submit" color="primary">
              <CSpinner v-if="isSaving" class="mr-2" small /> Save
            </CButton>

            <router-link :to="{ name: 'store-view', params: { id: props.id }}" class="ms-2 mt-2">Cancel</router-link>
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
import { StateList, CountryList } from "@/admin/data/address_constants";
import { type EntityIdentifier, type CustomerWithDefaults } from "@/admin/types";

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
const states = StateList;
const countries = CountryList;
const formData = ref<CustomerWithDefaults>({});
const errors = ref();

const fetchData = (id: EntityIdentifier) => {
  const promise = axios.get("/stores/" + id);

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

  const promise = axios.patch("/stores/" + props.id, formData.value);

  promise
    .then(({ data }) => {
      const store = data.data;

      emit("saved", store);

      toastSuccess("Store was updated successfully");

      router.push({
        name: "store-view",
        params: { id: store.id }
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
