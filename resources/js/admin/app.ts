/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import { createApp } from "vue";
import CoreuiVue from "@coreui/vue";
import Toasted from "@hoppscotch/vue-toasted";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from "./App.vue";
import router from "./router";
import store from "./store/index";

// Make sure to include the default stylings
import "@hoppscotch/vue-toasted/style.css";

// Include CoreUI icon styling
import "@coreui/icons/css/free.min.css";

import { CIcon } from "@coreui/icons-vue";
import { iconsSet as icons } from '@/admin/assets/icons'

const app = createApp(App)
  .use(router)
  .use(store)
  .use(CoreuiVue)
  .use(Toasted, { iconPack: 'custom-class' })
  .provide('icons', icons)
  .component('CIcon', CIcon)
  .mount('#app');
