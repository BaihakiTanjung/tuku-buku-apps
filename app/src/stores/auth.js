import { ref, computed } from "vue";
import { defineStore } from "pinia";
const baseUrl = import.meta.env.VITE_BASE_URL;

export const useAuthStore = defineStore("auth", () => {
  const isAuth = ref(localStorage.getItem("isAuth") ? true : false);
  const isUser = ref(
    localStorage.getItem("user") ? JSON.parse(localStorage.getItem("user")) : {}
  );
  const isRole = ref(
    localStorage.getItem("role") ? localStorage.getItem("role") : ""
  );

  const getIsAuth = computed(() => isAuth.value);
  const getIsUser = computed(() => isUser.value);
  const getIsRole = computed(() => isRole.value);

  async function logout() {
    await fetch(`${baseUrl}/api/logout`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    })
      .then((response) => response.json())
      .then((json) => {
        if (json.code === 200) {
          isAuth.value = false;
          localStorage.removeItem("isAuth");
          localStorage.removeItem("token");
          localStorage.removeItem("user");
          localStorage.removeItem("role");
          window.location.href = "/";
        } else {
          alert(json.message);
        }
      });
  }

  async function login(payload) {
    await fetch(`${baseUrl}/api/login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    })
      .then((response) => response.json())
      .then((json) => {
        if (json.code === 200) {
          localStorage.setItem("isAuth", true);
          localStorage.setItem("token", json.access_token);
          localStorage.setItem("role", json.role);
          localStorage.setItem("user", JSON.stringify(json.user));
          isAuth.value = true;
          isUser.value = json.user;
          window.location.reload();
        } else {
          alert(json.message);
        }
      });
  }

  async function register(payload) {
    await fetch(`${baseUrl}/api/register`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    })
      .then((response) => response.json())
      .then((json) => {
        console.log(json);
        if (json.code === 200) {
          login(payload);
        } else {
          alert(json.message);
        }
      });
  }

  return { isAuth, getIsAuth, getIsUser, getIsRole, login, logout, register };
});
