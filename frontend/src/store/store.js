import Vue from "vue";
import Vuex from 'vuex';
import auth from "./modules/authentication/store";

Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  modules: {
    auth
  },
});

export default store;
