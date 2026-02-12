<script setup>
import { useAuthStore } from "../stores/auth";
import { ref } from "vue";

const auth = useAuthStore();
const showMenu = ref(false);

const logout = () => {
    auth.logout();
    window.location.href = "/login";
};
</script>

<template>
<header class="bg-white shadow-sm h-16 flex items-center justify-between px-6">

    <!-- Search -->
    <div class="w-1/3">
        <input
            type="text"
            placeholder="Search..."
            class="w-full bg-gray-100 rounded-lg px-4 py-2 focus:outline-none"
        />
    </div>

    <!-- User -->
    <div class="relative">
        <div
            @click="showMenu = !showMenu"
            class="flex items-center gap-3 cursor-pointer"
        >
            <img
                src="https://i.pravatar.cc/40"
                class="w-10 h-10 rounded-full"
            />
            <span class="font-medium">Admin</span>
        </div>

        <!-- Dropdown -->
        <div
            v-if="showMenu"
            class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg"
        >
            <button
                @click="logout"
                class="block w-full text-left px-4 py-2 hover:bg-gray-100"
            >
                Logout
            </button>
        </div>
    </div>

</header>
</template>
