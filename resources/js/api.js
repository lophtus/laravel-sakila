import axios from 'axios';
import store from "@/store";
import Vue from "vue";

// add authorization header to requests when logged in
axios.interceptors.request.use(function (config) {
  if (store.getters.user != null) {
    config.headers.Authorization = 'Bearer ' + store.getters.user.access_token;
  }

  return config;
});

axios.interceptors.response.use(response => response, error => {
  const { status } = error.response;

  // handle unauthorized errors
  if (status == 401) {
    store.commit('logoutUser');
    Vue.$router.push({name: "login"});
  }
  return Promise.reject(error);
});

export default {

  getCategories() {
    return axios.get('/categories');
  },

  getCategory(categoryId) {
    return axios.get('/categories/' + categoryId);
  },

  getFilmsByCategory(categoryId, page = 1, perPage = 30) {
    return axios.get('/categories/' + categoryId + '/films', {
      params: {
        'page[number]': page,
        'page[size]': perPage,
      }
    });
  },

  getFilms(page = 1, perPage = 30) {
    return axios.get('/films', {
      params: {
        'page[number]': page,
        'page[size]': perPage,
      }
    });
  },

  getFilm(filmId, includes = null, filters = null) {
    return axios.get('/films/' + filmId, {
      params: {
        ...(includes ? { 'include': includes } : {}),
        ...(filters ? { 'filters': filters } : {})
      }
    });
  },

  searchFilms(search, page = 1, perPage = 30) {
    return axios.get('/films', {
      params: {
        'filter[search]': search,
        'page[number]': page,
        'page[size]': perPage,
      }
    });
  },

  reserveFilm(filmId, storeId) {
    return axios.post('/stores/' + storeId + '/films/' + filmId + '/rent');
  },

  login(email, password) {
    return axios.post('/login', {
      email: email,
      password: password,
    });
  },

  getSuggestions() {
    return axios.get('/my/suggestions', {
      params: { }
    });
  }
}
