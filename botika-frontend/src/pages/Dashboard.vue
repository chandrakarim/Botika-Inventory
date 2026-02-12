<template>
  <div>
   <div class="flex items-center justify-between mb-6">
  <h1 class="text-2xl font-bold">Data Inventaris</h1>
    <button
    @click="goCreate"
    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
    + Tambah Data
    </button>
    </div>

    

    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-6 py-3">No</th>
            <th class="px-6 py-3">Inventaris ID</th>
            <th class="px-6 py-3">Barang</th>
            <th class="px-6 py-3">Type</th>
            <th class="px-6 py-3">Serial Number</th>
            <th class="px-6 py-3">Spesifikasi</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3">Assign</th>
            <th class="px-6 py-3">Departemen</th>
            <th class="px-6 py-3">Action</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="item in inventories" :key="item.id" class="border-t">
            <td class="px-6 py-3">{{ item.id }}</td>
            <td class="px-6 py-3">{{ item.inventory_code }}</td>
            <td class="px-6 py-3">{{ item.name }}</td>
            <td class="px-6 py-3">{{ item.type }}</td>
            <td class="px-6 py-3">{{ item.serial_number }}</td>
            <td class="px-6 py-3">{{ item.specification }}</td>
            <td class="px-6 py-3">{{ item.status }}</td>
            <td class="px-6 py-3">{{ item.member?.name || '-' }}</td>
            <td class="px-6 py-3">{{ item.member?.department?.name ?? '-' }}</td>
            <td class="px-6 py-3 flex gap-2">
            <button
                @click="goEdit(item.id)"
                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm"
            >
                Edit
            </button>

            <button
                @click="deleteItem(item.id)"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm"
            >
                Hapus
            </button>
            </td>

          </tr>

          <tr v-if="inventories.length === 0">
            <td colspan="5" class="text-center py-6 text-gray-400">
              Tidak ada data inventaris
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
import api from "../services/api";

const router = useRouter();
const inventories = ref([]);

// ================= LOAD DATA =================
const loadInventories = async () => {
  try {
    const response = await api.get("/inventories");
    inventories.value = response.data.data;
  } catch (error) {
    console.log("Gagal ambil data:", error);
  }
};

// ================= EDIT =================
const goEdit = (id) => {
  console.log("klik edit id:", id); // <- nanti muncul di F12
  router.push(`/dashboard/inventories/edit/${id}`);
};

// ================= DELETE =================
const deleteItem = async (id) => {
  if (!confirm("Yakin ingin menghapus data?")) return;

  try {
    await api.delete(`/inventories/${id}`);
    loadInventories();
  } catch (error) {
    console.log("Gagal hapus:", error);
  }
};

onMounted(loadInventories);

const goCreate = () => {
router.push("/dashboard/inventories/create");
};

</script>

