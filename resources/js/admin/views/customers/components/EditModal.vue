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

<script>
import axios from "axios";
import { StateList, CountryList } from "../../../data/address_constants";

export default {
  name: "EditModal",
  props: {
    populateWith: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      isSaving: false,
      states: StateList,
      countries: CountryList,
      form: {}
    };
  },
  methods: {
    resetModal() {
      this.form = Object.assign({}, this.populateWith);
    },
    handleOkay(bvModalEvt) {
      bvModalEvt.preventDefault();

      this.onSubmit();
    },
    async onSubmit() {
      let vm = this;

      vm.isSaving = true;

      const promise = axios.patch("/customers/" + vm.form.id, vm.form);

      promise
        .then(({ data }) => {
          const customer = data.data;

          vm.$emit("saved", customer);

          vm.$refs.editModal.hide();

          vm.$toasted.show("Customer was updated successfully", {
            type: "success",
            icon: "far fa-check-circle"
          });
        })
        .catch(error => {
          if (error.response.data.errors) {
            vm.$refs.formObserver.setErrors(error.response.data.errors);
          }
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
