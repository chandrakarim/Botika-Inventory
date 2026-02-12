<template>
  <div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Tambah Anggota</h1>

    <div class="bg-white p-6 rounded-lg shadow">
      <form @submit.prevent="saveMember">

        <!-- Nama -->
        <div class="mb-4">
          <label class="block mb-1">Nama</label>
          <input v-model="form.name" class="w-full border px-3 py-2 rounded" required>
        </div>

        <!-- Departemen -->
        <div class="mb-4">
          <label class="block mb-1">Departemen</label>
          <select v-model="form.department_id" class="w-full border px-3 py-2 rounded" required>
            <option value="">-- Pilih Departemen --</option>
            <option v-for="d in departments" :key="d.id" :value="d.id">
              {{ d.name }}
            </option>
          </select>
        </div>

        <!-- Jabatan -->
        <div class="mb-4">
          <label class="block mb-1">Jabatan</label>
          <select v-model="form.position_id" class="w-full border px-3 py-2 rounded" required>
            <option value="">-- Pilih Jabatan --</option>
            <option v-for="p in positions" :key="p.id" :value="p.id">
              {{ p.name }}
            </option>
          </select>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Simpan
        </button>

      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import api from "../services/api";


const router = useRouter();

const form = ref({
  name: "",
  department_id: "",
  position_id: ""
});

const departments = ref([]);
const positions = ref([]);

// load departments
const loadDepartments = async () => {
  const res = await api.get("/departments");
  departments.value = res.data.data;
};

// load positions
const loadPositions = async () => {
  const res = await api.get("/positions");
  positions.value = res.data.data;
};

// save member
const saveMember = async () => {
  try {
    await api.post("/members", form.value);
    alert("Anggota berhasil ditambahkan");
    router.push("/dashboard/members");
  } catch (err) {
    console.log(err);
    alert("Gagal menambahkan anggota");
  }
};

onMounted(() => {
  loadDepartments();
  loadPositions();
});
</script>
