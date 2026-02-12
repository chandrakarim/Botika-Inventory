<template>
  <aside class="w-64 bg-white shadow-md min-h-screen p-4">

<h2 class="text-xl font-bold mb-6">Botika Inventory</h2>

<nav class="space-y-2">

  <router-link
    to="/dashboard"
    class="block px-4 py-2 rounded-lg hover:bg-blue-100"
  >
    Data Inventaris
  </router-link>

  <router-link
    to="/dashboard/members"
    class="block px-4 py-2 rounded-lg hover:bg-blue-100"
  >
    Management Anggota
  </router-link>

  <router-link
    to="/dashboard/inventories"
    class="block px-4 py-2 rounded-lg hover:bg-blue-100"
  >
    Analytics
  </router-link>

</nav>
  </aside>
</template>
