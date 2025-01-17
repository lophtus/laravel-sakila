import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    user: JSON.parse(localStorage.getItem("user")),
  },
  mutations: {
    loginUser(state) {
      state.user = JSON.parse(localStorage.getItem("user"));
    },
    logoutUser(state) {
      state.user = null;
      localStorage.removeItem("user");
    },
  },
  getters: {
    loggedIn: (state) => {
      return state.user !== null;
    },
    user: (state) => {
      return state.user;
    },
    getPermission: (state) => (permission) => {
      if (state.user !== null) {
        return state.user.permissions.some(e => e.identifier === permission);
      }

      return null;
    },
  }
});

export default store;
export const useStore = () => store;
