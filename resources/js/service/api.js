import axios from "axios";
import store from "../store";

// Создайте экземпляр axios
const api = axios.create({
    // baseURL: process.env.VUE_APP_DEVOPS_URL
});

api.interceptors.request.use((config) => {
        config.headers = { Accept: "application/json" };
        store.commit("SET_LOADING", true);
        return config;
    },
    (error) => Promise.reject(error));

api.interceptors.response.use(
    (response) => {
        store.commit("SET_LOADING", false);
        return response;
    },
    async (error) => {
        store.dispatch('showError', error)
        store.commit("SET_LOADING", false);
        return Promise.reject(error);
    }
);

export default api;
