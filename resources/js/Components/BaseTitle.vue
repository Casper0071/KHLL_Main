<template>
    <div :class="containerClass">
        <h1 :class="titleClasses">{{ title }}</h1>
        <p v-if="enableText" :class="textClasses">{{ infoText }}</p>
    </div>
</template>

<script setup>
import { defineProps, computed } from 'vue'

const props = defineProps({
    title: {
        type: String,
        required: true,
        default: 'Title'
    },
    infoText: {
        type: String,
        default: 'Ontdek onze innovatieve collectie van producten en diensten. We bieden het beste van kwaliteit, design en functionaliteit.'
    },
    enableText: {
        type: Boolean,
        default: false
    },
    light: {
        type: Boolean,
        default: false
    },
    align: {
        type: String,
        default: 'left',
        validator: (value) => ['left', 'center', 'right'].includes(value)
    }
})

const containerClass = computed(() => {
    const base = 'title-container'
    const alignClass = {
        left: '',
        center: 'text-center',
        right: 'rtl-container'
    }[props.align]
    return `${base} ${alignClass}`
})

const titleClasses = computed(() => {
    return [
        'title-line',
        props.light ? 'text-text-light' : 'text-text-dark'
    ]
})

const textClasses = computed(() => {
    const animationClass = {
        left: 'slide-in-left',
        center: 'fade-in',
        right: 'slide-in-right'
    }[props.align]

    return [
        'text',
        props.light ? 'text-text-light' : 'text-text-dark',
        animationClass
    ]
})
</script>

<style scoped>
.title-container {
    --underline-color: #EAB751;
    --underline-height: 3px;
    --underline-offset: 30px;
}

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
    bottom: calc(-4px - var(--underline-height));
    height: var(--underline-height);
    background-color: var(--underline-color);
    border-radius: 1px;
}

.text-center .title-line::after {
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% + 40px);
}

.title-line::after {
    left: 0;
    width: calc(100% + var(--underline-offset));
}

.rtl-container .title-line::after {
    left: auto;
    right: 0;
    width: calc(100% + var(--underline-offset));
}

.text {
    @apply mt-3;
}

/* Animations */
.slide-in-left {
    animation: slideInLeft 300ms ease-out forwards;
}

.slide-in-right {
    animation: slideInRight 300ms ease-out forwards;
}

.fade-in {
    animation: fadeIn 300ms ease-out forwards;
}

@keyframes slideInLeft {
    from {
        transform: translateX(-20px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideInRight {
    from {
        transform: translateX(20px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
