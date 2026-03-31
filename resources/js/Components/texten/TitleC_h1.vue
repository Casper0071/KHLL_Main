<template>
    <div class="center-container">
        <h1 :class="['title-line', props.light ? 'text-text-light' : 'text-text-dark']">{{ title }}</h1>
        <p v-if="props.enableText" :class="['text', props.light ? 'text-text-light' : 'text-text-dark', 'fade-in']">{{ infoText }}</p>
    </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
    title: {
        type: String,
        default: 'Center Title'
    },
    infoText: {
        type: String,
        default: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
    },
    enableText: {
        type: Boolean,
        default: false
    },
    light: {
        type: Boolean,
        default: false
    }
})
</script>

<style scoped>
.center-container {
    text-align: center;
}

.title-line {
    @apply relative inline-block;
}

.title-line::after {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: -4px;
    height: 3px;
    width: calc(100% + 40px);
    background-color: #EAB751;
    border-radius: 1px;
}

.text {
    @apply mt-3;
}

/* fade in animation */
.fade-in {
    opacity: 0;
    animation: fadeIn 300ms ease-out forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
    }
}
</style>
