import { ref, computed } from "vue";
import { defineStore } from "pinia";
const baseUrl = import.meta.env.VITE_BASE_URL;

export const usePaymentStore = defineStore("payment", () => {
  const payments = ref([]);

  const getPayments = computed(() => payments.value);

  function setPayments(data) {
    payments.value = data;
  }

  async function fetchPayments() {
    await fetch(`${baseUrl}/api/payment`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    })
      .then((response) => response.json())
      .then((json) => {
        if (json.code === 200) {
          setPayments(json.data);
        } else {
          alert(json.message);
        }
      });
  }

  async function changeStatus(id, status) {
    await fetch(`${baseUrl}/api/payment/change-status/${id}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
      body: JSON.stringify({ status }),
    })
      .then((response) => response.json())
      .then((json) => json);
  }

  return { getPayments, fetchPayments, changeStatus };
});
