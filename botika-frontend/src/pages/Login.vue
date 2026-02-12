<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">


  <h2 class="text-2xl font-bold text-center mb-6">
    Login Botika Inventory
  </h2>

  <form @submit.prevent="handleLogin">
    <!-- Email -->
    <div class="mb-4 text-left">
      <label class="block text-sm font-medium mb-1">Email</label>
      <input
        v-model="email"
        type="email"
        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        placeholder="Masukkan email"
        required
      />
    </div>

    <!-- Password -->
    <div class="mb-6 text-left">
      <label class="block text-sm font-medium mb-1">Password</label>
      <input
        v-model="password"
        type="password"
        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        placeholder="Masukkan password"
        required
      />
    </div>

    <!-- Button -->
    <button
      type="submit"
      class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
    >
      Login
    </button>
  </form>

</div>

  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const email = ref("");
const password = ref("");
const loading = ref(false);

const handleLogin = async () => {
  loading.value = true;

  try {
    const response = await axios.post("http://127.0.0.1:8000/api/login", {
      email: email.value,
      password: password.value,
    });

    // ambil token dari Laravel
    const token = response.data.token;

    // simpan token ke browser
    localStorage.setItem("token", token);

    // redirect ke dashboard
    router.push("/dashboard");

  } catch (error) {
    alert("Login gagal! Email atau password salah.");
    console.error(error);
  } finally {
    loading.value = false;
  }
};
</script>
