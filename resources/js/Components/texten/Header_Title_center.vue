<template>
    <div class="center-container">
        <h1 :class="titleClasses">{{ title }}</h1>
        <div class="mt-4">
            <Button
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
import Button from '@/Components/Button.vue'

const props = defineProps({
    title: {
        type: String,
        default: 'Header'
    },
    light: {
        type: Boolean,
        default: false
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
    lightBtn: {
        type: Boolean,
        default: false
    }
})

const titleClasses = computed(() => {
    return props.light ? 'text-light' : 'text-dark'
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
    color: #0B122A;
}

.text-light {
    color: #F4F7FB;
}

h1 {
    @apply relative inline-block text-6xl font-bold font-poppins;
}

h1::after {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: -9px;
    height: 3px;
    width: calc(100% + 40px);
    background-color: #EAB751;
    border-radius: 1px;
}
</style>
