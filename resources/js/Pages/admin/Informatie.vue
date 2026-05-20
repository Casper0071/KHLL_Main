<template>
    <div class="page">
        <h1 class="text-3xl font-bold mb-2 text-text-dark px-6 pt-6">informatie</h1>




    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AdminLayout from "@/Layouts/AdminLayout.vue";

defineOptions({
    layout: AdminLayout
})
</script>

<style scoped>
.page {
    min-height: 100vh;
    background: var(--surface);
}

</style>

