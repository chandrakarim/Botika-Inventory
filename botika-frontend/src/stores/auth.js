import { defineStore } from "pinia";
import api from "../api/axios";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token") || null,
  }),

  actions: {
    async login(credentials) {
      try {
        const res = await api.post("/login", credentials);

        this.token = res.data.token;
        localStorage.setItem("token", res.data.token);

        return true;
      } catch (err) {
        console.error(err);
        return false;
      }
    },

    logout() {
      this.user = null;
      this.token = null;
      localStorage.removeItem("token");
    },
  },
});
