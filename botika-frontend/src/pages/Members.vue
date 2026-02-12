<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
  <h1 class="text-2xl font-bold">Management Anggota</h1>

  <button
    @click="goCreate"
    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow"
  >
    + Tambah Anggota
  </button>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">
  <table class="min-w-full text-sm text-left">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="px-6 py-3">No</th>
        <th class="px-6 py-3">Nama</th>
        <th class="px-6 py-3">Jabatan</th>
        <th class="px-6 py-3">Departemen</th>
        <th class="px-6 py-3">Aksi</th>
      </tr>
    </thead>

    <tbody>
      <tr
        v-for="(member, index) in members"
        :key="member.id"
        class="border-t hover:bg-gray-50"
      >
        <td class="px-6 py-3">{{ index + 1 }}</td>
        <td class="px-6 py-3 font-medium">{{ member.name }}</td>

        <td class="px-6 py-3">
          {{ member.position?.name || '-' }}
        </td>

        <td class="px-6 py-3">
          {{ member.department?.name || '-' }}
        </td>

        <td class="px-6 py-3 flex gap-2">
        <button
            @click="goEdit(member.id)"
            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm"
        >
            Edit
        </button>

        <button
            @click="deleteMember(member.id)"
            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm"
        >
            Hapus
        </button>
        </td>
      </tr>

      <tr v-if="members.length === 0">
        <td colspan="5" class="text-center py-6 text-gray-400">
          Data anggota kosong
        </td>
      </tr>
    </tbody>
  </table>
</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import api from "../api/axios";

const router = useRouter();
const members = ref([]);

// ================= AMBIL DATA =================
const getMembers = async () => {
  try {
    const response = await api.get("/members");
    members.value = response.data.data;
    console.log("DATA MEMBERS:", members.value);
  } catch (error) {
    console.error("Gagal ambil members:", error);
  }
};

onMounted(getMembers);

// ================= TAMBAH DATA =================
const goCreate = () => {
  router.push({ name: "create-member" });
};

// ================= EDIT =================
const goEdit = (id) => {
  router.push(`/dashboard/members/edit/${id}`);
};

// ================= DELETE =================
const deleteMember = async (id) => {
  if (!confirm("Yakin ingin menghapus anggota ini?")) return;

  try {
    await api.delete(`/members/${id}`);
    alert("Anggota berhasil dihapus");
    getMembers(); // reload tabel
  } catch (err) {
    console.log(err);
    alert("Gagal menghapus anggota");
  }
};
</script>
