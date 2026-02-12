<template>
  <div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Anggota</h1>

    <div class="bg-white p-6 rounded-lg shadow">
      <form @submit.prevent="updateMember">

        <!-- Nama -->
        <div class="mb-4">
          <label class="block mb-1">Nama</label>
          <input v-model="form.name" class="w-full border px-3 py-2 rounded" required>
        </div>

        <!-- Department -->
        <div class="mb-4">
          <label class="block mb-1">Departemen</label>
          <select v-model="form.department_id" class="w-full border px-3 py-2 rounded">
            <option v-for="d in departments" :key="d.id" :value="d.id">
              {{ d.name }}
            </option>
          </select>
        </div>

        <!-- Position -->
        <div class="mb-4">
          <label class="block mb-1">Jabatan</label>
          <select v-model="form.position_id" class="w-full border px-3 py-2 rounded">
            <option v-for="p in positions" :key="p.id" :value="p.id">
              {{ p.name }}
            </option>
          </select>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Update
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../services/api";

const route = useRoute();
const router = useRouter();

const form = ref({
  name: "",
  department_id: "",
  position_id: ""
});

const departments = ref([]);
const positions = ref([]);

// ambil member
const loadMember = async () => {
  const res = await api.get(`/members/${route.params.id}`);
  const data = res.data.data;

  form.value.name = data.name;
  form.value.department_id = data.department?.id;
  form.value.position_id = data.position?.id;
};

// ambil department
const loadDepartments = async () => {
  const res = await api.get("/departments");
  departments.value = res.data.data;
};

// ambil position
const loadPositions = async () => {
  const res = await api.get("/positions");
  positions.value = res.data.data;
};

// update
const updateMember = async () => {
  await api.put(`/members/${route.params.id}`, form.value);
  alert("Member berhasil diupdate");
  router.push("/dashboard/members");
};

onMounted(() => {
  loadMember();
  loadDepartments();
  loadPositions();
});
</script>
