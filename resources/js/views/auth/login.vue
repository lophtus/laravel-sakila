<template>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol :md="8">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CForm @submit.prevent="login">
                  <h1>Login</h1>
                  <p class="text-medium-emphasis">Sign In to your account</p>

                  <CAlert color="danger" :visible="hasErrors">
                    {{ errorMessage }}

                    <ul v-if="Object.keys(errors).length">
                      <li v-for="(error, key) in errors" :key="key">
                        {{ error[0] }}
                      </li>
                    </ul>
                  </CAlert>

                  <CInputGroup class="mb-3">
                    <CInputGroupText>
                      <CIcon name="cil-user" />
                    </CInputGroupText>
                    <CFormInput
                      v-model="form.email"
                      placeholder="Email"
                      autocomplete="email"
                    />
                  </CInputGroup>

                  <CInputGroup class="mb-4">
                    <CInputGroupText>
                      <CIcon name="cil-lock-locked" />
                    </CInputGroupText>
                    <CFormInput
                      v-model="form.password"
                      type="password"
                      placeholder="Password"
                      autocomplete="current-password"
                    />
                  </CInputGroup>

                  <CRow>
                    <CCol :xs="6">
                      <CButton
                        type="submit"
                        :disabled="disabled"
                        color="primary"
                        class="px-4"
                      > Login </CButton>
                    </CCol>
                    <CCol :xs="6" class="text-right">
                      <CButton color="link" class="px-0">
                        Forgot password?
                      </CButton>
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
            <CCard class="text-white bg-primary py-5" style="width: 44%">
              <CCardBody class="text-center">
                <div>
                  <h2>Sign up</h2>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                  </p>
                  <CButton color="light" variant="outline" class="mt-3:">
                    Register Now!
                  </CButton>
                </div>
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
import { ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

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
