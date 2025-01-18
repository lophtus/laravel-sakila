/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import axios from "axios";
import Vue from "vue";
import { BootstrapVue } from "bootstrap-vue";
import CoreuiVue from "@coreui/vue";
import Toasted from "vue-toasted";
import VueProgressBar from "vue-progressbar";

Vue.config.performance = true;

Vue.use(BootstrapVue);
Vue.use(CoreuiVue);
Vue.use(Toasted, {
  theme: "toasted-primary",
  iconPack: "custom-class",
  position: "bottom-right",
  duration: 5000
});

const options = {
    color: '#3490dc',
    failedColor: '#e3342f',
}
Vue.use(VueProgressBar, options);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from "./App.vue";
import router from "./router";
import "./vee-validate";

const app = new Vue({
  el: "#app",
  router,
  components: {
    App
  },
  render: h => h(App)
});


axios.interceptors.request.use(config => {
  app.$Progress.start(); // for every request start the progress
  return config;
});

axios.interceptors.response.use(response => {
  app.$Progress.finish(); // finish when a response is received
  return response;
});
