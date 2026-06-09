<!-- Components/Base/BaseButton.vue -->
<template>
    <Link
        v-if="link && !disabled"
        v-intersect="'animate'"
        :href="link"
        :class="buttonClasses"
        :target="target"
        :rel="target === '_blank' ? 'noopener noreferrer' : undefined"
    >
        <slot>{{ text }}</slot>
    </Link>
    <button
        v-else
        v-intersect="'animate'"
        :class="buttonClasses"
        :disabled="disabled"
        :type="type"
        @click="handleClick"
    >
        <span v-if="loading" class="base-button__spinner"></span>
        <slot>{{ text }}</slot>
    </button>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

// ============================================
// Props (volledig intact gelaten)
// ============================================

const props = defineProps({
    text: { type: String, default: 'Klik mij' },
    variant: { type: String, default: 'primary' },
    size: { type: String, default: 'md' },
    disabled: { type: Boolean, default: false },
    loading: { type: Boolean, default: false },
    lightBtn: { type: Boolean, default: false },
    link: { type: String, default: null },
    target: { type: String, default: '_self' },
    type: { type: String, default: 'button' },
    fullWidth: { type: Boolean, default: false },
    icon: { type: String, default: null },
    rounded: { type: String, default: 'full' },
})

// ============================================
// Emits
// ============================================

const emit = defineEmits(['click'])

// ============================================
// Methods
// ============================================

const handleClick = () => {
    if (!props.disabled && !props.loading) {
        emit('click')
    }
}

// ============================================
// Computed Properties
// ============================================

const buttonClasses = computed(() => {
    const classes = ['base-button']

    // Size variant
    classes.push(`base-button--${props.size}`)

    // Color variant
    classes.push(`base-button--${props.variant}`)

    // Rounded variant
    classes.push(`base-button--rounded-${props.rounded}`)

    // Modifiers
    if (props.fullWidth) classes.push('base-button--full-width')
    if (props.disabled || props.loading) classes.push('base-button--disabled')
    if (props.lightBtn && props.variant !== 'outline') classes.push('base-button--light-text')
    if (props.icon === 'left') classes.push('base-button--icon-left')
    if (props.icon === 'right') classes.push('base-button--icon-right')

    return classes
})
</script>

<style scoped>
/* ============================================
   BASE BUTTON STYLES
   ============================================ */

.base-button {
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
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.base-button {
    opacity: 0;
    transform: translateY(15px);
    transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.base-button.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   SIZE VARIANTS
   ============================================ */

.base-button--sm {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
}

.base-button--md {
    padding: 0.625rem 1.5rem;
    font-size: 0.875rem;
}

.base-button--lg {
    padding: 0.75rem 2rem;
    font-size: 1rem;
}

/* ============================================
   ROUNDED VARIANTS
   ============================================ */

.base-button--rounded-full {
    border-radius: 9999px;
}

.base-button--rounded-lg {
    border-radius: 0.5rem;
}

.base-button--rounded-md {
    border-radius: 0.375rem;
}

.base-button--rounded-none {
    border-radius: 0;
}

/* ============================================
   COLOR VARIANTS
   ============================================ */

/* Primary */
.base-button--primary {
    background-color: var(--primary);
    color: var(--background);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.base-button--primary:hover:not(.base-button--disabled) {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.base-button--primary:active:not(.base-button--disabled) {
    transform: translateY(0);
}

/* Secondary */
.base-button--secondary {
    background-color: var(--surface);
    color: var(--text-dark);
    border: 1px solid rgba(0, 0, 0, 0.1);
}

.base-button--secondary:hover:not(.base-button--disabled) {
    background-color: var(--surface-soft);
    transform: translateY(-1px);
}

/* Outline */
.base-button--outline {
    background-color: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.base-button--outline:hover:not(.base-button--disabled) {
    background-color: var(--primary);
    color: var(--background);
    transform: translateY(-2px);
}

/* Danger */
.base-button--danger {
    background-color: #ef4444;
    color: white;
}

.base-button--danger:hover:not(.base-button--disabled) {
    background-color: #dc2626;
    transform: translateY(-2px);
}

/* Success */
.base-button--success {
    background-color: #10b981;
    color: white;
}

.base-button--success:hover:not(.base-button--disabled) {
    background-color: #059669;
    transform: translateY(-2px);
}

/* ============================================
   MODIFIERS
   ============================================ */

/* Light text mode */
.base-button--light-text {
    color: white;
}

.base-button--outline.base-button--light-text {
    color: var(--primary-light);
    border-color: var(--primary-light);
}

.base-button--outline.base-button--light-text:hover {
    background-color: var(--primary-light);
    color: var(--background);
}

/* Full width */
.base-button--full-width {
    width: 100%;
}

/* Disabled state */
.base-button--disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

/* Icon positions */
.base-button--icon-left :deep(svg),
.base-button--icon-left svg {
    margin-right: 0.375rem;
}

.base-button--icon-right :deep(svg),
.base-button--icon-right svg {
    margin-left: 0.375rem;
}

/* ============================================
   LOADING SPINNER
   ============================================ */

.base-button__spinner {
    width: 1rem;
    height: 1rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: base-button-spin 0.6s linear infinite;
    margin-right: 0.5rem;
}

@keyframes base-button-spin {
    to {
        transform: rotate(360deg);
    }
}

/* ============================================
   RIPPLE EFFECT
   ============================================ */

.base-button::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.base-button:active::after {
    width: 300%;
    height: 300%;
}

/* ============================================
   RESPONSIVE
   ============================================ */

@media (max-width: 640px) {
    .base-button--sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.7rem;
    }

    .base-button--md {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }

    .base-button--lg {
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
    }
}
</style>
