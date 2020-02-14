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
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CustomerView",
  data() {
    return {
      customer: {}
    };
  },
  beforeRouteEnter(to, from, next) {
    const promise = axios.get("/customers/" + to.params.id);

    return promise.then(({ data }) => {
      const customer = data.data;

      next(vm => {
        vm.customer = customer || {};
      });
    });
  }
};
</script>

<style scoped>
</style>
