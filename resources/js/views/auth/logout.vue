<template>
  <div />
</template>

<script>
export default {
  name: "Logout",
  beforeMount() {
    this.$store.commit("logoutUser");
    this.$router.push({name: "login"});
  }
};
</script>
