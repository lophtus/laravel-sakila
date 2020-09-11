<template>
  <div>
    <h2>{{ customer.first_name }} {{ customer.last_name }} (#{{ customer.id }})</h2>

    <address>
        {{ customer.address }}
        <br/>
        <span v-if="customer.address2">
            {{ customer.address2 }}
            <br/>
        </span>
        {{ customer.city }}, {{ customer.state }} {{ customer.country }} {{ customer.postal_code }}
    </address>

    <b-button variant="primary" size="sm" v-b-modal.edit-modal>
      <i class="far fa-edit"></i>
      Edit
    </b-button>

    <EditModal :populateWith="customer" @saved="onSave"></EditModal>
  </div>
</template>

<script>
import axios from "axios";
import EditModal from "./components/EditModal";

export default {
  name: "CustomerView",
  components: {
    EditModal
  },
  data() {
    return {
      isLoaded: false,
      customer: {}
    };
  },
  beforeRouteEnter(to, from, next) {
    const promise = axios.get("/customers/" + to.params.id);

    return promise.then(({ data }) => {
      const customer = data.data;

      next(vm => {
        vm.customer = customer || {};
        vm.isLoaded = true;
      });
    });
  },
  methods: {
    onSave(customer) {
      this.customer = customer;
    },
  }
};
</script>

<style scoped>
</style>
