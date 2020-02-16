<template>
  <div>
    <h2>Create Store</h2>

    <p>Use the form below to create a new store.</p>

    <ValidationErrors v-if="validationErrors" :errors="validationErrors" />

    <ValidationObserver ref="observer" v-slot="{ passes }">
      <b-form @submit.prevent="passes(onSubmit)">
        <ValidationProvider rules="required" name="Address" v-slot="{ valid, errors }">
          <b-form-group label="Address">
            <b-input v-model="form.address" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <b-form-group label="Address2">
          <b-input v-model="form.address2" />
        </b-form-group>

        <ValidationProvider rules="required" name="City" v-slot="{ valid, errors }">
          <b-form-group label="City">
            <b-input v-model="form.city" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="State" v-slot="{ valid, errors }">
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

        <ValidationProvider rules="required" name="Country" v-slot="{ valid, errors }">
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

        <ValidationProvider rules="required" name="PostalCode" v-slot="{ valid, errors }">
          <b-form-group label="Postal Code">
            <b-input v-model="form.postal_code" :state="errors[0] ? false : (valid ? true : null)" />
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider rules="required" name="Phone" v-slot="{ valid, errors }">
          <b-form-group label="Phone">
            <b-input v-model="form.phone" :state="errors[0] ? false : (valid ? true : null)" />
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
import { StateList, CountryList } from "../../data/form_constants";
import ValidationErrors from "../../components/ValidationErrors";

export default {
  name: "StoreCreate",
  components: {
    ValidationErrors
  },
  data() {
    return {
      isSaving: false,
      states: StateList,
      countries: CountryList,
      validationErrors: null,
      form: {
        address: null,
        address2: null,
        city: null,
        state: null,
        country: "US",
        postal_code: null,
        phone: null
      }
    };
  },
  methods: {
    async onSubmit() {
      let vm = this;

      vm.isSaving = true;

      const promise = axios.post("/stores", vm.form);

      promise
        .then(({ data }) => {
          const store = data.data;

          vm.$router.push({ name: "store-view", params: { id: store.id } });
          vm.$toasted.show("Store was created successfully", { type: "success", icon: "far fa-check-circle" });
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
