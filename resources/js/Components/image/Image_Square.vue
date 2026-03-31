<template>
    <div class="square-container">
        <img :src="imageSrc" :alt="imageAlt" class="square-image" />
    </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
    imageSrc: {
        type: String,
        default: 'https://via.placeholder.com/500x500'
    },
    imageAlt: {
        type: String,
        default: 'Square Image'
    }
})
</script>

<style scoped>
.square-container {
    width: 100%;
    max-width: 500px;
    aspect-ratio: 1 / 1;
}

.square-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
    display: block;
    background: gray;

}
</style>
