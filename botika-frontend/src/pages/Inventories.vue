<script setup>
import { ref, onMounted, nextTick } from "vue";
import api from "../services/api";
import Chart from "chart.js/auto";

const total = ref(0);
const baik = ref(0);
const rusak = ref(0);
const dilelang = ref(0);
const tidak_dipakai = ref(0);

let chartInstance = null;

const getAnalytics = async () => {
  try {
    const res = await api.get("/analytics");

    total.value = res.data.total_inventory;
    baik.value = res.data.status.baik;
    rusak.value = res.data.status.rusak;
    dilelang.value = res.data.status.dilelang;
    tidak_dipakai.value = res.data.status.tidak_dipakai;

    // tunggu DOM render dulu
    await nextTick();
    renderChart();

  } catch (err) {
    console.log("ANALYTICS ERROR:", err.response);
  }
};

const renderChart = () => {
  const ctx = document.getElementById("inventoryChart");

  if (!ctx) return;

  // hapus chart lama kalau ada
  if (chartInstance) {
    chartInstance.destroy();
  }

  chartInstance = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Baik", "Rusak", "Dilelang", "Tidak Dipakai"],
      datasets: [
        {
          label: "Jumlah Barang",
          data: [
            baik.value,
            rusak.value,
            dilelang.value,
            tidak_dipakai.value
          ],
          backgroundColor: [
            "#22c55e",
            "#ef4444",
            "#3b82f6",
            "#6b7280"
          ],
          borderRadius: 6
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });
};

onMounted(getAnalytics);
</script>

<template>
  <div class="p-6 space-y-8">

    <!-- ===== CARDS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">

      <div class="bg-white shadow rounded-xl p-5">
        <p class="text-gray-500">Total Inventory</p>
        <h1 class="text-3xl font-bold">{{ total }}</h1>
      </div>

      <div class="bg-green-100 shadow rounded-xl p-5">
        <p class="text-gray-700">Barang Baik</p>
        <h1 class="text-3xl font-bold text-green-600">{{ baik }}</h1>
      </div>

      <div class="bg-red-100 shadow rounded-xl p-5">
        <p class="text-gray-700">Barang Rusak</p>
        <h1 class="text-3xl font-bold text-red-600">{{ rusak }}</h1>
      </div>

      <div class="bg-blue-100 shadow rounded-xl p-5">
        <p class="text-gray-700">Dilelang</p>
        <h1 class="text-3xl font-bold text-blue-600">{{ dilelang }}</h1>
      </div>

      <div class="bg-gray-200 shadow rounded-xl p-5">
        <p class="text-gray-700">Tidak Dipakai</p>
        <h1 class="text-3xl font-bold text-gray-700">{{ tidak_dipakai }}</h1>
      </div>

    </div>

    <!-- ===== CHART ===== -->
    <div class="bg-white rounded-xl shadow p-6">
      <h2 class="text-lg font-semibold mb-4">Statistik Inventory</h2>

      <canvas id="inventoryChart" height="120"></canvas>
    </div>

  </div>
</template>
