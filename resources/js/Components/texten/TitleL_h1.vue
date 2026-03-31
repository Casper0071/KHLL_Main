<template>
    <div>
        <h1 :class="['title-line', props.light ? 'text-text-light' : 'text-text-dark']">{{ title }}</h1>
        <p v-if="props.enableText" :class="['text', props.light ? 'text-text-light' : 'text-text-dark', 'slide-in-left']">{{ infoText }}</p>
    </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
    title: {
        type: String,
        default: 'Left Title'
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
.title-line {
    @apply relative inline-block;
}
.title-line::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -4px;
    height: 3px;
    width: calc(100% + 30px);
    background-color: #EAB751;
    border-radius: 1px;
}

.text {
    @apply mt-3 ;
}

/* slide in from left animation */
.slide-in-left {
    transform: translateX(-20px);
    opacity: 0;
    animation: slideInLeft 300ms ease-out forwards;
}

@keyframes slideInLeft {
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
