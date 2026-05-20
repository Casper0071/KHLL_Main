<template>
    <div :class="containerClass">
        <h1 :class="titleClasses">{{ title }}</h1>
        <div v-if="enableButton" class="mt-4">
            <BaseButton
                :text="buttonText"
                :variant="buttonVariant"
                :disabled="buttonDisabled"
                :light-btn="lightBtn"
            />
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed } from 'vue'
import BaseButton from '@/Components/Base/BaseButton.vue'

const props = defineProps({
    title: {
        type: String,
        default: 'Header'
    },
    light: {
        type: Boolean,
        default: false
    },
    align: {
        type: String,
        default: 'left',
        validator: (value) => ['left', 'center'].includes(value)
    },
    buttonText: {
        type: String,
        default: 'klik mij'
    },
    buttonVariant: {
        type: String,
        default: 'primary'
    },
    buttonDisabled: {
        type: Boolean,
        default: false
    },
    enableButton: {
        type: Boolean,
        default: true
    },
    lightBtn: {
        type: Boolean,
        default: false
    }
})

const containerClass = computed(() => {
    return props.align === 'center' ? 'center-container' : ''
})

const titleClasses = computed(() => {
    return [
        'title',
        props.light ? 'text-light' : 'text-dark'
    ]
})
</script>

<style scoped>
.center-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    width: 100%;
}

.text-dark {
    color: var(--text-dark);
}

.text-light {
    color: var(--text-light);
}

.title {
    @apply relative inline-block text-6xl font-bold font-poppins;
}

.title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -9px;
    height: 3px;
    width: calc(100% + 40px);
    background-color: var(--primary);
    border-radius: 1px;
}

.center-container .title::after {
    left: 50%;
    transform: translateX(-50%);
}
@media (max-width: 400px) {

    .title{
        @apply text-5xl;
    }
}
</style>
