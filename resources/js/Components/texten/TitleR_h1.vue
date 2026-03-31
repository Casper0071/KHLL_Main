<template>
    <div class="rtl-container">
        <h1 :class="['title-line', props.light ? 'text-text-light' : 'text-text-dark']">{{ title }}</h1>
        <p v-if="props.enableText" :class="['text', props.light ? 'text-text-light' : 'text-text-dark', 'slide-in-right']">{{ infoText }}</p>
    </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
    title: {
        type: String,
        default: 'Right Title'
    },
    infoText: {
        type: String,
        default: 'test als de text goed werkt.asdfsdafasdfdfd.asfsadfasdfasdfsd.afdasfa.dsfasfasf.'
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
.rtl-container {
    direction: rtl;
    text-align: right;
}

.title-line {
    @apply relative inline-block;
}

.title-line::after {
    content: '';
    position: absolute;
    bottom: -4px;
    height: 3px;
    width: calc(100% + 30px);
    background-color: #EAB751;
    border-radius: 1px;
    right: 0;
}

.text {
    @apply mt-3 ;
}

/* slide in from right animation */
.slide-in-right {
    transform: translateX(-20px);
    opacity: 0;
    animation: slideInRight 300ms ease-out forwards;
}

@keyframes slideInRight {
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
