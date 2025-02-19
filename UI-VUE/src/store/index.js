import { createStore } from "vuex";

export default createStore({
  state: {
    token: localStorage.getItem("token") || null,
    user: JSON.parse(localStorage.getItem("user")) || null,
  },
  mutations: {
    SET_TOKEN(state, token) {
      state.token = token;
      localStorage.setItem("token", token);
    },
    SET_USER(state, user) {
      state.user = user;
      localStorage.setItem("user", JSON.stringify(user));
    },
    LOGOUT(state) {
      state.token = null;
      state.user = null;
      localStorage.removeItem("token");
      localStorage.removeItem("user");
    },
  },
  actions: {
    login({ commit }, { email, password }) {
      return axios
        .post("http://localhost:8000/api/login", { email, password })
        .then((response) => {
          commit("SET_TOKEN", response.data.token);
          commit("SET_USER", response.data.user);
          return response.data;
        });
    },
    logout({ commit }) {
      commit("LOGOUT");
    },
  },
  getters: {
    isAuthenticated: (state) => !!state.token,
    currentUser: (state) => state.user,
  },
});
