<script setup>
import Navbar from '@/Components/layouts/Navbar.vue'
import Footer from '@/Components/layouts/Footer.vue'
</script>

<template>
    <div class="min-h-screen flex flex-col overflow-hidden">
        <Navbar />

        <main class="flex-1">
            <slot />
        </main>

        <Footer />
    </div>
</template>

