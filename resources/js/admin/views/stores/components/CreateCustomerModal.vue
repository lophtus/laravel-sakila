<template>
  <CModal
    :visible="isVisible"
    @close="onClose"
  >
    <CModalHeader>
      <CModalTitle>Create Customer</CModalTitle>
    </CModalHeader>

    <CModalBody>
      <p>Use the form below to create a new customer.</p>

      <CForm
        class="needs-validation"
        novalidate
        :validated="isValidated"
        @submit.prevent="onSubmit"
      >
        <CFormInput
          v-model="formData.first_name"
          id="inputFirstName"
          label="First Name"
          required
        />

        <CFormInput
          v-model="formData.last_name"
          id="inputLastName"
          label="Last Name"
          required
        />

        <CFormInput
          v-model="formData.email"
          id="inputEmail"
          label="Email"
          required
        />

        <CFormInput
          v-model="formData.address"
          id="inputAddress"
          label="Address"
          required
        />

        <CFormInput
          v-model="formData.address2"
          id="inputAddress2"
          label="Address2"
        />

        <CFormInput
          v-model="formData.city"
          id="inputCity"
          label="City"
          feedbackInvalid="Please provide a valid city."
          required
        />

        <CFormSelect
          v-model="formData.state"
          :options="['Select a state', ...states]"
          id="inputState"
          label="State"
          feedbackInvalid="Please select a valid state."
          required
        />

        <CFormSelect
          v-model="formData.country"
          :options="['Select a country', ...countries]"
          id="inputCountry"
          label="Country"
          feedbackInvalid="Please select a valid country."
          required
        />

        <CFormInput
          v-model="formData.postal_code"
          id="inputPostalCode"
          label="Postal Code"
          required
        />

        <CFormInput
          v-model="formData.phone"
          id="inputPhone"
          label="Phone"
          required
        />
      </CForm>
    </CModalBody>

    <CModalFooter>
      <CButton color="success" @click="onSubmit">
        <CSpinner v-if="isSaving" class="mr-2" size="sm" /> Save
      </CButton>
    </CModalFooter>
  </CModal>
</template>

<script setup lang="ts">
import axios from "axios";
import { computed, PropType, ref } from "vue";
import { useRouter } from "vue-router";
import useToast from "@/admin/composables/useToast";
import { StateList, CountryList } from "@/admin/data/address_constants";
import { type CustomerWithDefaults, type Store } from "@/admin/types";

const props = defineProps({
  store: {
    type: Object as PropType<Store>,
    required: true
  },
  visible: Boolean,
});

const emit = defineEmits(['saved', 'closed']);

const router = useRouter();
const { toastSuccess } = useToast();

const isSaving = ref(false);
const isValidated = ref(false);
const states = StateList;
const countries = CountryList;
const formData = ref<CustomerWithDefaults>({});
const errors = ref();

const isVisible = computed<boolean>(() => {
  return props.visible;
});

const onSubmit = async (evt: Event) => {
  const formElement = evt.currentTarget as HTMLFormElement;

  if (formElement.checkValidity() === false) {
    evt.preventDefault();
    evt.stopPropagation();
    return;
  }

  isValidated.value = true;
  isSaving.value = true;

  const promise = axios.post("/stores/" + props.store.id + "/customers", formData.value);

  promise
    .then(({ data }) => {
      const customer = data.data;

      emit('saved', customer);

      toastSuccess("Customer was created successfully");

      router.push({ name: "customer-view", params: { id: customer.id } });
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

const onClose = () => {
  emit('closed');
}
</script>

<style scoped>
</style>
