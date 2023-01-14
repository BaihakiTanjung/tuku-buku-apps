<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useProductStore } from "@/stores/product";
import { useCartStore } from "@/stores/cart";
import { useUserStore } from "@/stores/user";
import { usePaymentStore } from "@/stores/payment";
import {
  TrashIcon,
  ClipboardDocumentIcon,
  CheckCircleIcon,
} from "@heroicons/vue/24/solid";
import { watch } from "vue";

const authStore = useAuthStore();
const productStore = useProductStore();
const cartStore = useCartStore();
const userStore = useUserStore();
const paymentStore = usePaymentStore();

const isAuth = computed(() => authStore.getIsAuth);
const isUserName = computed(() => authStore.getIsUser?.name);
const products = computed(() => productStore.getProducts);
const carts = computed(() => cartStore.cart);
const getQty = computed(() => cartStore.getQty);
const priceTotal = computed(() => cartStore.priceTotal);
const productDetail = computed(() => productStore.getProductDetail);
const getNoPayment = computed(() => cartStore.getNoPayment);
const getMethod = computed(() => cartStore.getMethod);
const getAmount = computed(() => cartStore.getAmount);
const isRole = computed(() => authStore.getIsRole);
const users = computed(() => userStore.getUsers);
const payments = computed(() => paymentStore.getPayments);
const paymentGetQty = computed(() => paymentStore.getQty);

onMounted(() => {
  productStore.fetchProducts();
  userStore.fetchUsers();
  paymentStore.fetchPayments();
});

const currency = new Intl.NumberFormat("id-ID", {
  style: "currency",
  currency: "IDR",
  minimumFractionDigits: 0,
});

const handleModalLogin = () => {
  const a = document.createElement("a");
  a.href = "#modal-login";
  a.click();
};

const formLogin = reactive({
  email: "test@gmail.com",
  password: "12345678",
});

const handleModalRegister = () => {
  const a = document.createElement("a");
  a.href = "#modal-register";
  a.click();
};

const formRegister = reactive({
  name: "test",
  email: "test@gmail.com",
  password: "12345678",
  confirmPassword: "12345678",
});

const handleModalDetail = (product) => {
  const a = document.createElement("a");
  a.href = "#modal-detail";
  a.click();

  productStore.setProductDetail(product);
};

const handleLogin = () => {
  const a = document.createElement("a");
  a.href = "#";
  a.click();

  localStorage.setItem("isAuth", "true");
  authStore.login(formLogin);
};

const handleRegister = async () => {
  await authStore.register(formRegister);

  const a = document.createElement("a");
  a.href = "#";
  a.click();
};

const handleAddToCart = (product) => {
  cartStore.addToCart(product);
};

const handleRemoveFromCart = (product) => {
  cartStore.removeFromCart(product);
};

const handleLogout = () => {
  authStore.logout();
};

const handleCheckout = () => {
  const a = document.createElement("a");
  a.href = "#modal-checkout";
  a.click();
};

const method = ref("bca");

const handlePayment = () => {
  const payload = {
    method: method.value,
    priceTotal: priceTotal.value,
    products: carts.value,
    total: getQty.value,
  };

  cartStore.checkout(payload);
};

const handleSearch = (e) => {
  productStore.searchProduct(e.target.value);
};

const handleSaveClipboard = async (text) => {
  try {
    await navigator.clipboard.writeText(text);
    alert("Content copied to clipboard");
  } catch (err) {
    alert("Failed to copy: ", err);
  }
};

const tab = ref("user");

const handleTab = (val) => {
  tab.value = val;
};

watch(
  () => getNoPayment.value,
  (val) => {
    if (val !== "") {
      const a = document.createElement("a");
      a.href = "#modal-after-checkout";
      a.click();
    }
  }
);

const handleModalAddProduct = () => {
  const a = document.createElement("a");
  a.href = "#modal-add-product";
  a.click();
};

const formAddProduct = reactive({
  title: "test",
  description: "test",
  image: "test",
  qty: 1,
  price: 10,
  stock: 10,
});

const handleSubmitAddProduct = async () => {
  await productStore.addProduct(formAddProduct);

  const a = document.createElement("a");
  a.href = "#";
  a.click();

  productStore.fetchProducts();
};

const handleDeleteProduct = async (id) => {
  await productStore.deleteProduct(id);

  productStore.fetchProducts();
};

const handleDeleteUser = async (id) => {
  await userStore.deleteUser(id);

  userStore.fetchUsers();
};

const handleChangeStatus = async (id, status) => {
  await paymentStore.changeStatus(id, status);

  paymentStore.fetchPayments();
};
</script>


<template>
  <!-- Modal Login -->
  <div class="py-5 modal" id="modal-login">
    <div class="modal-box">
      <a
        href="#"
        for="modal-after-checkout"
        class="absolute btn btn-sm btn-circle right-2 top-2"
        >✕</a
      >
      <form @submit.prevent="handleLogin">
        <h3 class="mb-5 text-lg font-bold text-center">Login</h3>
        <div class="grid justify-center gap-3">
          <div class="email">
            <input
              type="email"
              v-model="formLogin.email"
              required
              placeholder="Type username"
              class="w-full max-w-xs input input-bordered input-primary"
            />
          </div>
          <div class="password">
            <input
              type="password"
              v-model="formLogin.password"
              required
              placeholder="Type password"
              class="w-full max-w-xs input input-bordered input-primary"
            />
          </div>
        </div>
        <div class="flex justify-center modal-action">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Login -->

  <!-- Modal Register -->
  <div class="py-5 modal modal-small" id="modal-register">
    <div class="modal-box">
      <a
        href="#"
        for="modal-after-checkout"
        class="absolute btn btn-sm btn-circle right-2 top-2"
        >✕</a
      >
      <form @submit.prevent="handleRegister">
        <h3 class="mb-5 text-lg font-bold text-center">Register</h3>
        <div class="grid justify-center gap-3">
          <div class="name">
            <input
              type="text"
              v-model="formRegister.name"
              required
              placeholder="Type name"
              class="w-full max-w-xs input input-bordered input-primary"
            />
          </div>
          <div class="email">
            <input
              type="email"
              v-model="formRegister.email"
              required
              placeholder="Type email"
              class="w-full max-w-xs input input-bordered input-primary"
            />
          </div>
          <div class="password">
            <input
              type="password"
              v-model="formRegister.password"
              required
              placeholder="Type password"
              class="w-full max-w-xs input input-bordered input-primary"
            />
          </div>
          <div class="confirm-password">
            <input
              type="password"
              v-model="formRegister.confirmPassword"
              required
              placeholder="Type confirm password"
              class="w-full max-w-xs input input-bordered input-primary"
            />
          </div>
        </div>
        <div class="flex justify-center modal-action">
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Regiter -->

  <!-- Modal Checkout -->
  <div class="py-5 modal" id="modal-checkout">
    <div class="w-11/12 max-w-5xl modal-box">
      <a
        href="#"
        for="modal-after-checkout"
        class="absolute btn btn-sm btn-circle right-2 top-2"
        >✕</a
      >
      <div
        class="p-5"
        v-for="cart in carts"
        :key="cart.id"
        v-if="carts?.length > 0"
      >
        <div class="flex justify-between">
          <div class="p-3">
            <figure>
              <img
                :src="cart.image || 'https://placeimg.com/80/80/tech'"
                alt="Shoes"
                width="80"
                height="300"
              />
            </figure>
          </div>
          <div>
            <div class="px-5">
              <div class="text-lg font-bold">
                {{ cart.title }}
              </div>
              <div class="font-bold">
                {{ currency.format(cart.price) }}
              </div>
              <div>
                {{ cart.description.substring(0, 60) + "..." }}
              </div>
            </div>
          </div>
          <div class="p-2">
            {{ cart.qty }}
          </div>

          <TrashIcon
            @click="handleRemoveFromCart(cart)"
            class="w-10 h-10 cursor-pointer text-error"
          ></TrashIcon>
        </div>
      </div>
      <div v-else>
        <div class="flex justify-center">
          <h2 class="mt-5 text-lg font-bold">Cart is empty</h2>
        </div>
      </div>
      <div class="flex justify-center">
        <h2 class="mt-5 text-2xl font-bold">
          Total : {{ currency.format(priceTotal) }}
        </h2>
      </div>
      <hr class="my-3" />
      <div class="flex justify-center">
        <h4 class="mt-5 text-lg font-bold">Payment Method</h4>
      </div>
      <div class="grid grid-cols-4 gap-5 px-5 py-5">
        <div class="flex justify-center align-middle">
          <input
            v-model="method"
            value="bca"
            type="radio"
            name="radio-1"
            class="mr-1 radio"
          />
          <label for="bca">BCA</label>
        </div>
        <div class="flex justify-center align-middle">
          <input
            v-model="method"
            value="gopay"
            type="radio"
            name="radio-1"
            class="mr-1 radio"
          />
          <label for="bca">Gopay</label>
        </div>
        <div class="flex justify-center align-middle">
          <input
            v-model="method"
            value="dana"
            type="radio"
            name="radio-1"
            class="mr-1 radio"
          />
          <label for="bca">Dana</label>
        </div>
        <div class="flex justify-center align-middle">
          <input
            v-model="method"
            value="ovo"
            type="radio"
            name="radio-1"
            class="mr-1 radio"
          />
          <label for="bca">Ovo</label>
        </div>
      </div>
      <div class="flex justify-center modal-action">
        <button @click="handlePayment" type="submit" class="btn btn-primary">
          Checkout
        </button>
      </div>
    </div>
  </div>
  <!-- End Modal Checkout -->

  <!-- Modal After Checkout -->
  <div class="py-5 modal" id="modal-after-checkout">
    <div class="relative modal-box">
      <a
        href="#"
        for="modal-after-checkout"
        class="absolute btn btn-sm btn-circle right-2 top-2"
        >✕</a
      >
      <div class="flex justify-center">
        <h2 class="mt-5 text-2xl font-bold">Payment Success</h2>
      </div>

      <div class="flex justify-center p-5 my-10">
        <img src="@/assets/img/payment.svg" alt="" width="250" height="250" />
      </div>

      <div class="flex justify-center">
        <h3 class="mt-5 text-lg">
          Payment Method : {{ getMethod?.toUpperCase() }}
        </h3>
      </div>

      <div class="flex justify-center">
        <h3 class="mt-5 text-lg">Total : {{ currency.format(getAmount) }}</h3>
      </div>

      <div class="flex justify-center">
        <h3 class="flex mt-5 text-lg">
          No Payment : {{ getNoPayment
          }}<ClipboardDocumentIcon
            @click="handleSaveClipboard(getNoPayment)"
            class="w-5 h-5 ml-3 cursor-pointer text-primary"
          ></ClipboardDocumentIcon>
        </h3>
      </div>

      <div class="flex justify-center mb-5">
        <h3 class="mt-5 text-lg">Thank you for your purchase</h3>
      </div>
    </div>
  </div>
  <!-- End Modal After Checkout -->

  <!-- Modal Detail -->
  <div class="py-5 modal modal-small" id="modal-detail">
    <div class="modal-box">
      <div class="flex justify-end">
        <a href="#" class="btn btn-ghost btn-sm">Close</a>
      </div>
      <div class="flex justify-center">
        <img :src="productDetail?.image || '-'" class="w-32 h-32 rounded-lg" />
      </div>
      <div class="flex justify-center">
        <h2 class="mt-5 text-2xl font-bold">
          {{ productDetail?.title || "-" }}
        </h2>
      </div>
      <div class="flex justify-center">
        <h3 class="mt-5 text-lg text-center">
          {{ productDetail?.description || "-" }}
        </h3>
      </div>
      <div class="flex justify-center">
        <h3 class="mt-5 text-lg font-bold">
          {{ currency.format(productDetail?.price) || "-" }}
        </h3>
      </div>
      <div class="flex justify-center">
        <button
          :disabled="!isAuth"
          @click="handleAddToCart(productDetail)"
          class="mt-5 btn btn-primary"
        >
          Add to cart
        </button>
      </div>
    </div>
  </div>
  <!-- End Modal Detail -->

  <!-- Modal Product Add -->
  <div class="py-5 modal modal-large" id="modal-add-product">
    <div class="modal-box">
      <div class="flex items-center justify-between align-middle">
        <h2 class="mt-5 text-xl font-bold">Add Product</h2>
        <a href="#" class="my-auto btn btn-ghost btn-sm">Close</a>
      </div>
      <form @submit.prevent="handleSubmitAddProduct" class="mt-5">
        <div class="grid grid-cols-2 gap-3">
          <input
            type="text"
            placeholder="Title"
            class="w-full col-span-2 input input-primary"
            v-model="formAddProduct.title"
          />
          <textarea
            class="col-span-2 textarea textarea-primary"
            placeholder="Description"
            v-model="formAddProduct.description"
          ></textarea>
          <input
            type="text"
            placeholder="URL Image"
            class="w-full col-span-2 input input-primary"
            v-model="formAddProduct.image"
          />
          <input
            type="number"
            placeholder="Price"
            class="w-full max-w-xs input input-primary"
            v-model="formAddProduct.price"
          />
          <input
            type="number"
            placeholder="Stock"
            class="w-full max-w-xs input input-primary"
            v-model="formAddProduct.stock"
          />
        </div>
        <div class="flex justify-center">
          <button type="submit" class="mt-5 btn btn-primary">
            Add Product
          </button>
        </div>
      </form>
    </div>
  </div>
  <!-- End Modal Product Add -->

  <!-- Navbar -->
  <div class="mt-5 rounded-lg navbar bg-base-300">
    <div class="flex-1">
      <a class="text-xl normal-case btn btn-ghost">TukuBuku.com</a>
    </div>
    <div class="flex-none">
      <div v-if="isAuth">
        <div v-if="isRole !== 'admin'" class="mr-2 dropdown dropdown-end">
          <label tabindex="0" class="btn btn-ghost btn-circle">
            <div class="indicator">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                />
              </svg>

              <span class="badge badge-sm badge-primary indicator-item">{{
                getQty || 0
              }}</span>
            </div>
          </label>

          <div
            tabindex="0"
            class="mt-3 shadow  card card-compact dropdown-content w-52 bg-base-100"
          >
            <div class="card-body">
              <span class="text-lg font-bold">{{ getQty || 0 }} Items</span>
              <span class="text-info"
                >Subtotal:
                {{ currency.format(priceTotal) || currency.format(0) }}</span
              >
              <div v-for="cart in carts" :key="cart.id">
                <div class="flex justify-between">
                  <div class="p-3">
                    <figure>
                      <img
                        :src="cart.image || 'https://placeimg.com/80/80/tech'"
                        alt="Shoes"
                        width="80"
                        height="300"
                      />
                    </figure>
                  </div>
                  <div class="px-5">
                    {{ cart.title.substring(0, 20) + ".." }}
                  </div>
                  <div>
                    {{ cart.qty }}
                  </div>
                </div>
                <button
                  @click="handleRemoveFromCart(cart)"
                  class="btn btn-xs btn-error btn-block"
                >
                  Remove
                </button>
              </div>
              <hr />
              <div class="card-actions">
                <button
                  v-if="carts?.length > 0"
                  @click="handleCheckout"
                  class="text-white btn btn-success btn-block"
                >
                  Checkout
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
              <img src="https://placeimg.com/80/80/people" />
            </div>
          </label>

          <ul
            tabindex="0"
            class="p-2 mt-3 shadow  menu menu-compact dropdown-content bg-base-100 rounded-box w-52"
          >
            <li><a @click="handleLogout">Logout</a></li>
          </ul>
        </div>
      </div>
      <div v-else>
        <button
          @click="handleModalLogin"
          class="mr-3 bg-transparent border-none btn"
        >
          Login
        </button>
        <button @click="handleModalRegister" class="btn btn-primary">
          Register
        </button>
      </div>
    </div>
  </div>
  <!-- End Navbar -->

  <!-- User -->
  <section v-if="isRole !== 'admin'">
    <!-- Content -->
    <h1 v-if="isAuth" class="px-5 mt-5 text-xl text-left">
      Hi,
      <span class="text-2xl font-bold">{{
        isUserName?.toUpperCase() || "-"
      }}</span>
    </h1>

    <!-- Search -->
    <div class="grid grid-cols-1">
      <div class="p-5 search">
        <input
          type="text"
          placeholder="Search..."
          @input="handleSearch"
          class="w-full w-100 input input-bordered input-lg"
        />
      </div>
    </div>
    <!-- End Search -->

    <div
      v-if="products?.length > 0"
      class="grid grid-cols-2 my-3 md:my-7 md:grid-cols-4 md:gap-x-8 gap"
    >
      <div
        v-for="product in products"
        :key="product.id"
        class="m-5 shadow-xl md:m-3 card card-compact bg-base-300"
      >
        <div class="shadow-xl card card-compact bg-base-100">
          <div @click="handleModalDetail(product)" class="static">
            <figure>
              <img
                width="250"
                height="250"
                :src="product.image || 'https://placeimg.com/80/80/tech'"
                alt="Shoes"
              />
            </figure>
            <div class="absolute top-1 left-1">
              <span class="badge badge-lg badge-primary">{{
                currency.format(product.price)
              }}</span>
            </div>
          </div>
          <div class="card-body">
            <h2
              @click="handleModalDetail(product)"
              class="cursor-pointer card-title"
            >
              {{ product.title.substring(0, 20) + ".." }}
            </h2>
            <p>{{ product.description.substring(0, 30) + ".." }}</p>
            <div class="justify-end mt-5 card-actions">
              <button
                :disabled="!isAuth"
                @click="handleAddToCart(product)"
                class="btn btn-primary"
              >
                Add to cart
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="my-5 text-center" v-else>
      <div class="text-2xl font-bold text-center">Book not found</div>
    </div>
  </section>

  <!-- Admin -->
  <section v-else class="m-5">
    <div class="flex justify-center tabs">
      <a
        class="tab"
        @click="handleTab('user')"
        :class="{ 'tab-active': tab === 'user' }"
        >User</a
      >
      <a
        class="tab"
        @click="handleTab('payment')"
        :class="{ 'tab-active': tab === 'payment' }"
        >Payment</a
      >
      <a
        class="tab"
        @click="handleTab('product')"
        :class="{ 'tab-active': tab === 'product' }"
        >Product</a
      >
    </div>
    <div class="w-full my-5 table-product" v-if="tab === 'product'">
      <div class="flex justify-end mb-3">
        <button
          @click="handleModalAddProduct"
          class="btn btn-primary"
          v-if="isRole === 'admin'"
        >
          Add Product
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="table w-full">
          <!-- head -->
          <thead>
            <tr>
              <th>Code</th>
              <th>Title</th>
              <th>Description</th>
              <th>Image</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Stock</th>
              <!-- <th>Supplier</th> -->
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products" :key="product.id">
              <td>{{ product.code }}</td>
              <td>{{ product.title }}</td>
              <td>{{ product.description.substring(0, 20) + "..." }}</td>
              <td><img :src="product.image" width="50" height="50" /></td>
              <td>{{ currency.format(product.price) }}</td>
              <td>{{ product.qty }}</td>
              <td>{{ product.stock }}</td>
              <!-- <td>{{ product.supplier_id }}</td> -->
              <td>
                <TrashIcon
                  @click="handleDeleteProduct(product.id)"
                  class="w-5 h-5 cursor-pointer text-error"
                ></TrashIcon>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="w-full my-5 table-product" v-if="tab === 'user'">
      <div class="overflow-x-auto">
        <table class="table w-full">
          <!-- head -->
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.role }}</td>
              <td>
                <TrashIcon
                  @click="handleDeleteUser(user.id)"
                  class="w-5 h-5 cursor-pointer text-error"
                ></TrashIcon>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="w-full my-5 table-product" v-if="tab === 'payment'">
      <div class="overflow-x-auto">
        <table class="table w-full">
          <!-- head -->
          <thead>
            <tr>
              <th>Transaction ID</th>
              <th>Method</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Jumlah Pembelian</th>
              <th>Nama Pembeli</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="payment in payments" :key="payment.id">
              <td>{{ payment.transaction_id }}</td>
              <td>{{ payment.method }}</td>
              <td>{{ currency.format(payment.amount) }}</td>
              <td>
                <span
                  v-if="payment.status === 'waiting'"
                  class="badge badge-warning"
                  >{{ payment.status }}</span
                >
                <span
                  v-if="payment.status === 'failed'"
                  class="badge badge-error"
                  >{{ payment.status }}</span
                >
                <span
                  v-if="payment.status === 'success'"
                  class="badge badge-success"
                  >{{ payment.status }}</span
                >
              </td>
              <td>{{ payment.transaction?.total }}</td>
              <td>{{ payment.transaction?.user?.name }}</td>
              <td class="flex gap-3">
                <CheckCircleIcon
                  @click="handleChangeStatus(payment.id, 'success')"
                  class="w-5 h-5 cursor-pointer text-success"
                ></CheckCircleIcon>
                <CheckCircleIcon
                  @click="handleChangeStatus(payment.id, 'failed')"
                  class="w-5 h-5 cursor-pointer text-error"
                ></CheckCircleIcon>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Footer  -->
  <footer
    class="p-4 mt-5 mb-5 rounded-lg  bg-base-300 footer footer-center text-base-content"
  >
    <div>
      <p>Copyright © 2023 - All right reserved by TukuBuku</p>
    </div>
  </footer>
  <!-- End Footer -->
</template>
