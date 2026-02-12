<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Tambah Inventaris</h1>
<div class="bg-white shadow rounded-lg p-6 max-w-3xl">

  <form @submit.prevent="saveData" class="grid grid-cols-2 gap-4">

    <!-- Inventory Code -->
    <div>
      <label class="block mb-1 font-medium">Kode Inventaris</label>
      <input v-model="form.inventory_code"
             class="w-full border rounded px-3 py-2"
             required>
    </div>

    <!-- Nama Barang -->
    <div>
      <label class="block mb-1 font-medium">Nama Barang</label>
      <input v-model="form.name"
             class="w-full border rounded px-3 py-2"
             required>
    </div>

    <!-- Type -->
    <div>
      <label class="block mb-1 font-medium">Type</label>
      <input v-model="form.type"
             class="w-full border rounded px-3 py-2">
    </div>

    <!-- Serial Number -->
    <div>
      <label class="block mb-1 font-medium">Serial Number</label>
      <input v-model="form.serial_number"
             class="w-full border rounded px-3 py-2">
    </div>

    <!-- Specification -->
    <div class="col-span-2">
      <label class="block mb-1 font-medium">Spesifikasi</label>
      <textarea v-model="form.specification"
                class="w-full border rounded px-3 py-2"></textarea>
    </div>

    <!-- Status -->
    <div>
      <label class="block mb-1 font-medium">Status</label>
      <select v-model="form.status" class="w-full border rounded px-3 py-2">
        <option value="baik">Baik</option>
        <option value="rusak">Rusak</option>
        <option value="dilelang">Dilelang</option>
        <option value="tidak_dipakai">Tidak Dipakai</option>
        </select>

    </div>

    <!-- Assign Member -->
    <div>
      <label class="block mb-1 font-medium">Assign (Member)</label>
      <select v-model="form.member_id"
              class="w-full border rounded px-3 py-2">
        <option value="">-- Pilih Member --</option>
        <option
          v-for="m in members"
          :key="m.id"
          :value="m.id">
          {{ m.name }} - {{ m.department?.name }}
        </option>
      </select>
    </div>

    <!-- FILE UPLOAD -->
<div class="mb-4">
  <label class="block mb-2 font-semibold">Upload Dokumen / Foto</label>

  <input type="file" multiple @change="handleFiles">


  <p class="text-xs text-gray-500 mt-1">
    Bisa upload banyak file (foto barang, invoice, dokumen, dll)
  </p>

  <!-- preview -->
  <ul class="mt-2 text-sm text-gray-700">
    <li v-for="(file, index) in selectedFiles" :key="index">
      📎 {{ file.name }}
    </li>
  </ul>
</div>


    <!-- Buttons -->
    <div class="col-span-2 flex gap-3 pt-4">
      <button
        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
        Simpan
      </button>

      <button
        type="button"
        @click="router.back()"
        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg">
        Batal
      </button>
    </div>

  </form>
</div>


  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import api from "../services/api";

const router = useRouter();
const members = ref([]);
const selectedFiles = ref([]);

// ================= FORM =================
const form = reactive({
  inventory_code: "",
  name: "",
  type: "",
  serial_number: "",
  specification: "",
  status: "baik",
  member_id: "",
});

// ================= HANDLE FILE =================
const handleFiles = (e) => {
  selectedFiles.value = Array.from(e.target.files);
};

// ================= LOAD MEMBERS =================
const loadMembers = async () => {
  try {
    const res = await api.get("/members");
    members.value = res.data.data;
  } catch (err) {
    console.log("Gagal ambil members", err);
  }
};

// ================= SAVE DATA =================
const saveData = async () => {
  try {

    // WAJIB pakai FormData untuk upload file
    const formData = new FormData();

    // kirim semua field text
    Object.keys(form).forEach(key => {
      formData.append(key, form[key] ?? "");
    });

    // kirim multiple files
    selectedFiles.value.forEach(file => {
      formData.append("files[]", file);
    });

    // POST ke Laravel
    await api.post("/inventories", formData);

    alert("Inventaris berhasil ditambahkan");
    router.push("/dashboard/inventories");

  } catch (err) {
    console.log(err.response?.data);
    alert("Gagal menambahkan inventaris");
  }
};

onMounted(loadMembers);
</script>
