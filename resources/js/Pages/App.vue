<script setup>
import Navbar from '@/Components/Navbar.vue'
</script>

<template>
    <Navbar />

    <main>
        <slot />
    </main>

    <footer>
        Footer
    </footer>
</template>
