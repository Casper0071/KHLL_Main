<template>
    <button
        :class="buttonClasses"
        :disabled="disabled"
        @click="handleClick"
    >
        <slot>{{ text }}</slot>
    </button>
</template>

<script setup>
import {defineProps, computed} from 'vue'

const props = defineProps({
    text: { type: String, default: 'Klik mij' },
    variant: { type: String, default: 'primary' }, // primary | secondary | outline
    disabled: { type: Boolean, default: false },
    lightBtn: { type: Boolean, default: false },
})

const handleClick = () => {
    if (!props.disabled) alert('Button clicked!')
}

const buttonClasses = computed(() => {
    let base = 'px-6 py-2 rounded-full font-poppins text-sm transition-all duration-200 ease-in-out shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2'

    const variants = {
        primary: 'bg-primary text-text-dark hover:bg-primary-hover active:translate-y-0 active:shadow-sm shadow-primary/30',
        secondary: 'bg-surface text-text-dark hover:bg-surface-soft active:translate-y-0 active:shadow-sm shadow-surface/30',
        outline: 'bg-transparent border-2 border-primary text-primary hover:bg-primary hover:text-text-dark active:translate-y-0 active:shadow-sm',
    }

    // Apply light text color when lightBtn is true
    let textColor = props.lightBtn ? 'text-white' : (props.variant === 'outline' ? 'text-primary' : 'text-text-dark')

    const disabledClass = props.disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : ''

    return `${base} ${variants[props.variant]} ${textColor} ${disabledClass}`
})
</script>
