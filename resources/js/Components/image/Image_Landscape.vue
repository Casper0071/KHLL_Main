<template>
    <div class="landscape-container">
        <img :src="imageSrc" :alt="imageAlt" class="landscape-image" />
    </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
    imageSrc: {
        type: String,
        default: 'https://via.placeholder.com/800x400'
    },
    imageAlt: {
        type: String,
        default: 'Landscape Image'
    }
})
</script>

<style scoped>
.landscape-container {
    width: 100%;
    max-width: 600px;
    aspect-ratio: 16 / 9;
}

.landscape-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
    display: block;
    background: gray;

}
</style>
