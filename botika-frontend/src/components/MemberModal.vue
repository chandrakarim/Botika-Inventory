<script setup>
import { ref, onMounted, watch } from "vue";
import api from "../api/axios";

const props = defineProps({
    member: Object
});

const emit = defineEmits(["close", "saved"]);

const form = ref({
    name: "",
    position_id: "",
    department_id: ""
});

const positions = ref([]);
const departments = ref([]);

const loadOptions = async () => {
    const pos = await api.get("/positions");
    const dep = await api.get("/departments");

    positions.value = pos.data.data;
    departments.value = dep.data.data;
};

watch(() => props.member, (m) => {
    if (m) {
        form.value.name = m.name;
        form.value.position_id = m.position.id;
        form.value.department_id = m.department.id;
    }
});

const save = async () => {
    if (props.member) {
        await api.put(`/members/${props.member.id}`, form.value);
    } else {
        await api.post("/members", form.value);
    }

    emit("saved");
    emit("close");
};

onMounted(loadOptions);
</script>

<template>
<div class="fixed inset-0 bg-black/40 flex items-center justify-center">
    <div class="bg-white w-[500px] rounded-xl p-6 shadow-lg">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Edit Data</h2>
            <button @click="$emit('close')" class="text-gray-500">✕</button>
        </div>

        <div class="space-y-4">

            <div>
                <label class="text-sm">Nama</label>
                <input v-model="form.name"
                    class="w-full border rounded-lg p-2 mt-1"/>
            </div>

            <div>
                <label class="text-sm">Jabatan</label>
                <select v-model="form.position_id"
                    class="w-full border rounded-lg p-2 mt-1">
                    <option value="">Pilih Jabatan</option>
                    <option v-for="p in positions" :key="p.id" :value="p.id">
                        {{ p.name }}
                    </option>
                </select>
            </div>

            <div>
                <label class="text-sm">Department</label>
                <select v-model="form.department_id"
                    class="w-full border rounded-lg p-2 mt-1">
                    <option value="">Pilih Department</option>
                    <option v-for="d in departments" :key="d.id" :value="d.id">
                        {{ d.name }}
                    </option>
                </select>
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">
            <button @click="$emit('close')" class="px-4 py-2">Cancel</button>
            <button @click="save"
                class="bg-black text-white px-4 py-2 rounded-lg">
                Save Changes
            </button>
        </div>

    </div>
</div>
</template>
