<template>
  <b-modal ref="editModal" id="edit-modal" title="Edit Customer" @show="resetModal" @ok="handleOkay">
    <p>Use the form below to update the customer.</p>

    <ValidationObserver ref="formObserver" v-slot="{ passes }">
      <b-form @submit.stop.prevent="passes(onSubmit)">
        <ValidationProvider rules="required" name="first_name" v-slot="{ valid, errors }">
          <b-form-group label="First Name">
            <b-input v-model="form.first_name" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="last_name" v-slot="{ valid, errors }">
          <b-form-group label="Last Name">
            <b-input v-model="form.last_name" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="email" name="email" v-slot="{ valid, errors }">
          <b-form-group label="Email">
            <b-input v-model="form.email" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="address" v-slot="{ valid, errors }">
          <b-form-group label="Address">
            <b-input v-model="form.address" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules name="address2" v-slot="{ valid, errors }">
          <b-form-group label="Address2">
            <b-input v-model="form.address2" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="city" v-slot="{ valid, errors }">
          <b-form-group label="City">
            <b-input v-model="form.city" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="state" v-slot="{ valid, errors }">
          <b-form-group label="State">
            <b-select
              v-model="form.state"
              :options="states"
              :state="errors[0] ? false : (valid ? true : null)"
            >
              <template v-slot:first>
                <b-form-select-option :value="null" disabled>Select a state</b-form-select-option>
              </template>
            </b-select>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="country" v-slot="{ valid, errors }">
          <b-form-group label="Country">
            <b-select
              v-model="form.country"
              :options="countries"
              :state="errors[0] ? false : (valid ? true : null)"
            >
              <template v-slot:first>
                <b-form-select-option :value="null" disabled>Select a country</b-form-select-option>
              </template>
            </b-select>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="postal_code" v-slot="{ valid, errors }">
          <b-form-group label="Postal Code">
            <b-input v-model="form.postal_code" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="phone" v-slot="{ valid, errors }">
          <b-form-group label="Phone">
            <b-input v-model="form.phone" :state="errors[0] ? false : (valid ? true : null)" />
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
import { StateList, CountryList } from "@/admin/data/address_constants";

const props = defineProps({
  populateWith: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['saved']);

const { proxy } = getCurrentInstance();

const isSaving = ref(false);
const states = StateList;
const countries = CountryList;
const form = ref({});

const resetModal = () => {
  form.value = Object.assign({}, props.populateWith);
}

const handleOkay = (bvModalEvt) => {
  bvModalEvt.preventDefault();

  onSubmit();
}

const onSubmit = async () => {
  isSaving.value = true;

  const promise = axios.patch("/customers/" + form.value.id, form.value);

  promise
    .then(({ data }) => {
      const customer = data.data;

      emit("saved", customer);

      proxy.$refs.editModal.hide();

      proxy.$toasted.show("Customer was updated successfully", {
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
