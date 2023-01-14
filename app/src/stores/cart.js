import { ref, computed } from "vue";
import { defineStore } from "pinia";
const baseUrl = import.meta.env.VITE_BASE_URL;

export const useCartStore = defineStore("cart", () => {
  const cart = ref([]);
  const noPayment = ref(0);
  const method = ref("");
  const amount = ref(0);

  const getCart = computed(() => cart.value);
  const getNoPayment = computed(() => noPayment.value);
  const getMethod = computed(() => method.value);
  const getAmount = computed(() => {
    return amount.value;
  });

  const priceTotal = computed(() => {
    return cart.value.reduce((sum, item) => sum + item.price * item.qty, 0);
  });

  function setNoPayment(no) {
    noPayment.value = no;
  }

  function setMethod(methods) {
    method.value = methods;
  }

  function setAmount(amounts) {
    amount.value = amounts;
  }

  const getQty = computed(() => {
    let sum = 0;
    cart.value.forEach((item) => {
      sum += item.qty;
    });
    return sum;
  });

  function addToCart(book) {
    const existing = cart.value.find((item) => item.id === book.id);
    if (existing) {
      existing.qty++;
      return;
    }

    cart.value.push(book);
  }

  function removeFromCart(book) {
    const existing = cart.value.find((item) => item.id === book.id);
    if (existing.qty > 1) {
      existing.qty--;
      return;
    }
    cart.value = cart.value.filter((item) => item.id !== book.id);
  }

  function clearCart() {
    cart.value = [];
  }

  async function checkout(payload) {
    await fetch(`${baseUrl}/api/checkout`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + localStorage.getItem("token"),
      },
      body: JSON.stringify({
        method: payload.method,
        amount: payload.priceTotal,
        products: payload.products,
        total: payload.total,
      }),
    })
      .then((response) => response.json())
      .then((json) => {
        if (json.code === 200) {
          setNoPayment(json.no_payment);
          setMethod(json.method);
          setAmount(json.amount);
          clearCart();
        } else {
          alert(json.message);
        }
      });
  }

  return {
    cart,
    getCart,
    priceTotal,
    getQty,
    addToCart,
    removeFromCart,
    clearCart,
    checkout,
    getNoPayment,
    getMethod,
    getAmount,
  };
});
