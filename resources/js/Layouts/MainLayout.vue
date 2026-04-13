<script setup>
import Navbar from '@/Components/Navbar.vue'
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <Navbar />

        <main class="flex-1">
            <slot />
        </main>

        <footer class="bg-gray-100 text-center p-4">
            Footer
        </footer>
    </div>
</template>
