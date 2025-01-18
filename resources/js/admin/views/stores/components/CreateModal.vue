<template>
  <b-modal
    ref="createModal"
    id="create-modal"
    title="Create Store"
    @show="resetModal"
    @ok="handleOkay"
  >
    <p>Use the form below to create a new store.</p>

    <ValidationObserver ref="formObserver" v-slot="{ passes }">
      <b-form @submit.stop.prevent="passes(onSubmit)">
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
import { useRouter } from "vue-router/composables";
import { StateList, CountryList } from "@/admin/data/address_constants";

const { proxy } = getCurrentInstance();
const router = useRouter();

const isSaving = ref(false);
const states = StateList;
const countries = CountryList;
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

  const promise = axios.post("/stores", form.value);

  promise
    .then(({ data }) => {
      const store = data.data;

      router.push({ name: "store-view", params: { id: store.id } });

      proxy.$toasted.show("Store was created successfully", {
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
