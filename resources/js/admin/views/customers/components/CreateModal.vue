<template>
  <CModal :visible="visible">
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
          v-model="form.first_name"
          id="inputFirstName"
          label="First Name"
          required
        />

        <CFormInput
          v-model="form.last_name"
          id="inputLastName"
          label="Last Name"
          required
        />

        <CFormInput
          v-model="form.email"
          id="inputEmail"
          label="Email"
          required
        />

        <CFormInput
          v-model="form.address"
          id="inputAddress"
          label="Address"
          required
        />

        <CFormInput
          v-model="form.address2"
          id="inputAddress2"
          label="Address2"
        />

        <CFormInput
          v-model="form.city"
          id="inputCity"
          label="City"
          feedbackInvalid="Please provide a valid city."
          required
        />

        <CFormSelect
          v-model="form.state"
          :options="['Select a state', ...states]"
          id="inputState"
          label="State"
          feedbackInvalid="Please select a valid state."
          required
        />

        <CFormSelect
          v-model="form.country"
          :options="['Select a country', ...countries]"
          id="inputCountry"
          label="Country"
          feedbackInvalid="Please select a valid country."
          required
        />

        <CFormInput
          v-model="form.postal_code"
          id="inputPostalCode"
          label="Postal Code"
          required
        />

        <CFormInput
          v-model="form.phone"
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
import { getCurrentInstance, ref } from "vue";
import { useRouter } from "vue-router";
import { useToasted } from "@hoppscotch/vue-toasted";
import { StateList, CountryList } from "@/admin/data/address_constants";

const props = defineProps({
  store: {
    type: Object,
    required: true
  },
  visible: Boolean,
});

const { proxy } = getCurrentInstance();
const router = useRouter();
const toasted = useToasted();

const isSaving = ref(false);
const isValidated = ref(false);
const states = StateList;
const countries = CountryList;
const form = ref({});

const onSubmit = async (event) => {
  const form = event.currentTarget;

  if (form.checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();
  }

  isValidated.value = true;
  isSaving.value = true;

  const promise = axios.post("/stores/" + props.store.id + "/customers", form.value);

  promise
    .then(({ data }) => {
      const customer = data.data;

      router.push({ name: "customer-view", params: { id: customer.id } });

      toasted.show("Customer was created successfully", {
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
