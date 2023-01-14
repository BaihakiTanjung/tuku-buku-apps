import { ref, computed } from "vue";
import { defineStore } from "pinia";

const baseUrl = import.meta.env.VITE_BASE_URL;

export const useProductStore = defineStore("product", () => {
  const products = ref([
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
    // {
    //   id: 1,
    //   title: "The Hunger Games",
    //   description: "The Hunger",
    //   price: 100000,
    //   image:
    //     "https://images-na.ssl-images-amazon.com/images/I/51Zt3J9ZQWL._SX331_BO1,204,203,200_.jpg",
    // },
  ]);
  const productDetail = ref({});

  const getProducts = computed(() => products.value);
  const getProductDetail = computed(() => productDetail.value);

  function setProducts(data) {
    products.value = data;
  }

  function setProductDetail(data) {
    productDetail.value = data;
  }

  function searchProduct(title) {
    // search product
    if (title === "") {
      fetchProducts();
      return;
    }

    const searchResult = products.value.filter((product) => {
      return product.title.toLowerCase().includes(title.toLowerCase());
    });

    // set products
    setProducts(searchResult);
  }

  async function fetchProducts() {
    await fetch(`${baseUrl}/api/products`)
      .then((response) => response.json())
      .then((json) => setProducts(json));
  }

  async function addProduct(data) {
    await fetch(`${baseUrl}/api/products`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((json) => json);
  }

  async function deleteProduct(id) {
    await fetch(`${baseUrl}/api/products/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    })
      .then((response) => response.json())
      .then((json) => json);
  }

  return {
    products,
    getProducts,
    getProductDetail,
    setProducts,
    setProductDetail,
    fetchProducts,
    searchProduct,
    addProduct,
    deleteProduct,
  };
});
