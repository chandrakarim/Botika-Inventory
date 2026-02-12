<template>
  <div class="flex min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <Sidebar />

    <!-- Content Area -->
    <div class="flex-1 flex flex-col">

      <!-- Navbar -->
      <Navbar />

      <!-- Page Content -->
      <main class="p-6">
        <router-view />
      </main>

    </div>
  </div>
</template>

<script setup>
import Sidebar from "../components/Sidebar.vue";
import Navbar from "../components/Navbar.vue";
</script>
