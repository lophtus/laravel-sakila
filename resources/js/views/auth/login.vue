<template>
  <div class="c-app flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="8">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CForm @submit="login($event)">
                  <h1>Login</h1>
                  <p class="text-muted">Sign In to your account</p>

                  <b-alert variant="danger" :show="hasErrors">
                    {{ errorMessage }}

                    <ul v-if="Object.keys(errors).length">
                      <li v-for="(error, key) in errors" :key="key">
                        {{ error[0] }}
                      </li>
                    </ul>
                  </b-alert>

                  <CInput
                    v-model="form.email"
                    placeholder="Email"
                    autocomplete="email"
                  >
                    <template #prepend-content>
                      <CIcon name="cil-user" />
                    </template>
                  </CInput>
                  <CInput
                    v-model="form.password"
                    placeholder="Password"
                    type="password"
                    autocomplete="curent-password"
                  >
                    <template #prepend-content>
                      <CIcon name="cil-lock-locked" />
                    </template>
                  </CInput>
                  <CRow>
                    <CCol col="6" class="text-left">
                      <CButton
                        type="submit"
                        :disabled="disabled"
                        color="primary"
                        class="px-4"
                        >Login</CButton
                      >
                    </CCol>
                    <CCol col="6" class="text-right">
                      <CButton color="link" class="px-0"
                        >Forgot password?</CButton
                      >
                      <CButton color="link" class="d-lg-none"
                        >Register now!</CButton
                      >
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
            <CCard
              color="primary"
              text-color="white"
              class="text-center py-5 d-md-down-none"
              body-wrapper
            >
              <CCardBody>
                <h2>Sign up</h2>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                  do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
                <CButton color="light" variant="outline" size="lg"
                  >Register Now!</CButton
                >
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script setup lang="ts">
import api from "@/api";
import { useStore } from "@/store.js";
import { ref } from "vue";
import { useRouter } from "vue-router/composables";

const router = useRouter();
const store = useStore();

const disabled = ref(false);
const hasErrors = ref(false);
const errorMessage = ref(null);
const errors = ref([]);
const form = ref({
  email: "",
  password: "",
});

const login = (evt) => {
  evt.preventDefault();

  if (disabled.value) return;

  disabled.value = true;
  hasErrors.value = false;
  errorMessage.value = null;
  errors.value = [];

  const promise = api.login(form.value.email, form.value.password);

  promise
    .then(({ data }) => {
      disabled.value = false;

      localStorage.setItem("user", JSON.stringify(data.data));

      store.commit("loginUser");
      router.push({ name: "dashboard" });
    })
    .catch((error) => {
      disabled.value = false;
      hasErrors.value = true;
      errorMessage.value = error.response.data.message;
      if (error.response.data.errors) {
        errors.value = error.response.data.errors;
      }
    });
}
</script>

<style lang="scss" scoped>
</style>
