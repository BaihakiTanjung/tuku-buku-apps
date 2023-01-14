import { ref, computed } from "vue";
import { defineStore } from "pinia";

const baseUrl = import.meta.env.VITE_BASE_URL;

export const useUserStore = defineStore("user", () => {
  const users = ref([]);

  const getUsers = computed(() => users.value);

  function setUser(data) {
    users.value = data;
  }

  async function fetchUsers() {
    await fetch(`${baseUrl}/api/list-user`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    })
      .then((response) => response.json())
      .then((json) => {
        if (json.code === 200) {
          setUser(json.data);
        } else {
          alert(json.message);
        }
      });
  }

  async function deleteUser(id) {
    await fetch(`${baseUrl}/api/users/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    })
      .then((response) => response.json())
      .then((json) => json);
  }

  return { getUsers, fetchUsers, deleteUser };
});
