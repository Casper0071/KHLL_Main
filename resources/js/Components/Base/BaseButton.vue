<!-- Components/Base/BaseButton.vue -->
<template>
    <Link
        v-if="link && !disabled"
        :href="link"
        :class="buttonClasses"
        :target="target"
        :rel="target === '_blank' ? 'noopener noreferrer' : undefined"
    >
        <slot>{{ text }}</slot>
    </Link>
    <button
        v-else
        :class="buttonClasses"
        :disabled="disabled"
        :type="type"
        @click="handleClick"
    >
        <span v-if="loading" class="btn-loading-spinner"></span>
        <slot>{{ text }}</slot>
    </button>
</template>

<script setup>
import { defineProps, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    text: { type: String, default: 'Klik mij' },
    variant: { type: String, default: 'primary' }, // primary | secondary | outline | danger | success
    size: { type: String, default: 'md' }, // sm | md | lg
    disabled: { type: Boolean, default: false },
    loading: { type: Boolean, default: false },
    lightBtn: { type: Boolean, default: false },
    link: { type: String, default: null },
    target: { type: String, default: '_self' },
    type: { type: String, default: 'button' },
    fullWidth: { type: Boolean, default: false },
    icon: { type: String, default: null }, // left | right
    rounded: { type: String, default: 'full' }, // full | lg | md | none
})

const emit = defineEmits(['click'])

const handleClick = () => {
    if (!props.disabled && !props.loading) {
        emit('click')
    }
}

const buttonClasses = computed(() => {
    let classes = []

    // Base classes
    classes.push('btn-base')

    // Size variants
    const sizes = {
        sm: 'btn-sm',
        md: 'btn-md',
        lg: 'btn-lg'
    }
    classes.push(sizes[props.size] || 'btn-md')

    // Variant styles
    const variants = {
        primary: 'btn-primary',
        secondary: 'btn-secondary',
        outline: 'btn-outline',
        danger: 'btn-danger',
        success: 'btn-success'
    }
    classes.push(variants[props.variant] || 'btn-primary')

    // Light mode text
    if (props.lightBtn && props.variant !== 'outline') {
        classes.push('btn-light-text')
    }

    // Full width
    if (props.fullWidth) {
        classes.push('btn-full-width')
    }

    // Rounded corners
    const roundedVariants = {
        full: 'btn-rounded-full',
        lg: 'btn-rounded-lg',
        md: 'btn-rounded-md',
        none: 'btn-rounded-none'
    }
    classes.push(roundedVariants[props.rounded] || 'btn-rounded-full')

    // Disabled/Loading state
    if (props.disabled || props.loading) {
        classes.push('btn-disabled')
    }

    // Icon position
    if (props.icon === 'left') {
        classes.push('btn-icon-left')
    } else if (props.icon === 'right') {
        classes.push('btn-icon-right')
    }

    return classes
})
</script>

<style scoped>
/* ============================================
   BUTTON BASE STYLES
   ============================================ */
.btn-base {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    border: none;
    position: relative;
    overflow: hidden;
}

/* ============================================
   SIZE VARIANTS
   ============================================ */
.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    border-radius: 9999px;
}

.btn-md {
    padding: 0.625rem 1.5rem;
    font-size: 0.875rem;
    border-radius: 9999px;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1rem;
    border-radius: 9999px;
}

/* ============================================
   ROUNDED VARIANTS
   ============================================ */
.btn-rounded-full {
    border-radius: 9999px;
}

.btn-rounded-lg {
    border-radius: 0.5rem;
}

.btn-rounded-md {
    border-radius: 0.375rem;
}

.btn-rounded-none {
    border-radius: 0;
}

/* ============================================
   COLOR VARIANTS
   ============================================ */
/* Primary */
.btn-primary {
    background: var(--primary);
    color: var(--background);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.btn-primary:hover:not(:disabled) {
    background: var(--primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.btn-primary:active:not(:disabled) {
    transform: translateY(0);
}

/* Secondary */
.btn-secondary {
    background: var(--surface);
    color: var(--text-dark);
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.1);
}

.btn-secondary:hover:not(:disabled) {
    background: var(--surface-soft);
    transform: translateY(-1px);
}

/* Outline */
.btn-outline {
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.btn-outline:hover:not(:disabled) {
    background: var(--primary);
    color: var(--background);
    transform: translateY(-2px);
}

/* Danger */
.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover:not(:disabled) {
    background: #dc2626;
    transform: translateY(-2px);
}

/* Success */
.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover:not(:disabled) {
    background: #059669;
    transform: translateY(-2px);
}

/* ============================================
   LIGHT TEXT MODE
   ============================================ */
.btn-light-text {
    color: white !important;
}

.btn-outline.btn-light-text {
    color: var(--primary-light);
    border-color: var(--primary-light);
}

.btn-outline.btn-light-text:hover {
    background: var(--primary-light);
    color: var(--background);
}

/* ============================================
   FULL WIDTH
   ============================================ */
.btn-full-width {
    width: 100%;
}

/* ============================================
   DISABLED STATE
   ============================================ */
.btn-disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

/* ============================================
   LOADING SPINNER
   ============================================ */
.btn-loading-spinner {
    width: 1rem;
    height: 1rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: btn-spin 0.6s linear infinite;
    margin-right: 0.5rem;
}

@keyframes btn-spin {
    to {
        transform: rotate(360deg);
    }
}

/* ============================================
   ICON POSITIONS
   ============================================ */
.btn-icon-left :deep(svg),
.btn-icon-left svg {
    margin-right: 0.375rem;
}

.btn-icon-right :deep(svg),
.btn-icon-right svg {
    margin-left: 0.375rem;
}

/* ============================================
   HOVER RIPPLE EFFECT
   ============================================ */
.btn-base {
    position: relative;
    overflow: hidden;
}

.btn-base::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-base:active::after {
    width: 300%;
    height: 300%;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 640px) {
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.7rem;
    }

    .btn-md {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }

    .btn-lg {
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
    }
}
</style>
