<template>
    <div class="portrait-container">
        <img :src="imageSrc" :alt="imageAlt" class="portrait-image" />
    </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
    imageSrc: {
        type: String,
        default: 'https://via.placeholder.com/400x800'
    },
    imageAlt: {
        type: String,
        default: 'Portrait Image'
    }
})
</script>

<style scoped>
.portrait-container {
    width: 100%;
    max-width: 400px;
    aspect-ratio: 9 / 16;
}

.portrait-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
    display: block;
    background: gray;
}
</style>
