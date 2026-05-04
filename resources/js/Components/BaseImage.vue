<template>
    <div :class="containerClass" :style="containerStyle">
        <img 
            :src="imageSrc" 
            :alt="imageAlt" 
            class="image"
        />
    </div>
</template>

<script setup>
import { defineProps, computed } from 'vue'

const props = defineProps({
    imageSrc: {
        type: String,
        required: true,
        default: 'https://placehold.co/600x400/e5e7eb/6b7280?text=Image'
    },
    imageAlt: {
        type: String,
        default: 'Image'
    },
    ratio: {
        type: String,
        default: '16/9',
        validator: (value) => ['1/1', '4/3', '16/9', '9/16', '3/2'].includes(value)
    },
    maxWidth: {
        type: String,
        default: '600px'
    }
})

const containerStyle = computed(() => ({
    maxWidth: props.maxWidth,
    aspectRatio: props.ratio
}))

const containerClass = computed(() => `image-container ratio-${props.ratio.replace('/', '-')}`)
</script>

<style scoped>
.image-container {
    width: 100%;
}

.image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
    display: block;
    background: gray;
}
</style>
