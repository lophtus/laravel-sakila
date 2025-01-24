import axios from 'axios';
import store from "@/store";
import { useRouter } from "vue-router";

const handleUnauthorized = (error) => {
  const router = useRouter();

  if (error.response && error.response.status === 401) {
    store.commit('logoutUser');
    router.push({name: 'login'});
  }
}

const axiosInstance = axios.create();

axiosInstance.defaults.baseURL = "http://" + window.location.host + "/api";

// add authorization header to requests when logged in
axiosInstance.interceptors.request.use(function (config) {
  if (store.getters.user != null) {
    config.headers.Authorization = 'Bearer ' + store.getters.user.access_token;
  }

  return config;
});

axiosInstance.interceptors.response.use(
  (response) => response,
  (error) => {
    handleUnauthorized(error);
    return Promise.reject(error);
  }
);

export default {

  getCategories() {
    return axiosInstance.get('/categories');
  },

  getCategory(categoryId) {
    return axiosInstance.get('/categories/' + categoryId);
  },

  getFilmsByCategory(categoryId, page = 1, perPage = 30) {
    return axiosInstance.get('/categories/' + categoryId + '/films', {
      params: {
        'page[number]': page,
        'page[size]': perPage,
      }
    });
  },

  getFilms(page = 1, perPage = 30) {
    return axiosInstance.get('/films', {
      params: {
        'page[number]': page,
        'page[size]': perPage,
      }
    });
  },

  getFilm(filmId, includes = null, filters = null) {
    return axiosInstance.get('/films/' + filmId, {
      params: {
        ...(includes ? { 'include': includes } : {}),
        ...(filters ? { 'filters': filters } : {})
      }
    });
  },

  searchFilms(search, page = 1, perPage = 30) {
    return axiosInstance.get('/films', {
      params: {
        'filter[search]': search,
        'page[number]': page,
        'page[size]': perPage,
      }
    });
  },

  reserveFilm(filmId, storeId) {
    return axiosInstance.post('/stores/' + storeId + '/films/' + filmId + '/rent');
  },

  login(email, password) {
    return axiosInstance.post('/login', {
      email: email,
      password: password,
    });
  },

  getSuggestions() {
    return axiosInstance.get('/my/suggestions', {
      params: { }
    });
  }
}
