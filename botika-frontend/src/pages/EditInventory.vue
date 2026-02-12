<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Inventory</h1>

    <div class="bg-white shadow rounded-lg p-6 max-w-xl">

      <div class="mb-4">
        <label class="block mb-1">Nama Barang</label>
        <input v-model="form.name" class="w-full border rounded p-2">
      </div>

      <div class="mb-4">
        <label class="block mb-1">Type</label>
        <input v-model="form.type" class="w-full border rounded p-2">
      </div>

      <div class="mb-4">
        <label class="block mb-1">Serial Number</label>
        <input v-model="form.serial_number" class="w-full border rounded p-2">
      </div>

      <div class="mb-4">
        <label class="block mb-1">Spesifikasi</label>
        <input v-model="form.specification" class="w-full border rounded p-2">
      </div>

      <div class="mb-4">
        <label class="block mb-1">Status</label>
        <select v-model="form.status" class="w-full border rounded px-3 py-2">
        <option value="baik">Baik</option>
        <option value="rusak">Rusak</option>
        <option value="dilelang">Dilelang</option>
        <option value="tidak_dipakai">Tidak Dipakai</option>
        </select>
      </div>

      <button
        @click="updateInventory"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Update
      </button>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../api/axios";

const route = useRoute();
const router = useRouter();

const form = ref({
  name: "",
  type: "",
  serial_number: "",
  specification: "",
  status: ""
});

const id = route.params.id;

// ambil data lama
const getDetail = async () => {
  const res = await api.get(`/inventories/${id}`);
  form.value = res.data.data;
};

// update
const updateInventory = async () => {
  await api.put(`/inventories/${id}`, form.value);
  alert("Berhasil diupdate!");
  router.push("/dashboard/inventories");
};

onMounted(getDetail);
</script>
