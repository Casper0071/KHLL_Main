<template>
    <div v-intersect="'animate'" :class="containerClass">
        <h1 :class="titleClasses">{{ title }}</h1>
        <div v-if="enableButton" class="base-header__button-wrapper">
            <BaseButton
                :text="buttonText"
                :variant="buttonVariant"
                :disabled="buttonDisabled"
                :light-btn="lightBtn"
                :link="link"
                :rounded="rounded"
            />
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import BaseButton from '@/Components/Base/BaseButton.vue'

// ============================================
// Props
// ============================================

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
    },
    link: {
        type: String,
        default: '#'
    },
    rounded: {
        type: String,
        default: 'full'
    }
})

// ============================================
// Computed Properties
// ============================================

const containerClass = computed(() => {
    const classes = ['base-header']

    if (props.align === 'center') {
        classes.push('base-header--center')
    }

    return classes
})

const titleClasses = computed(() => {
    const classes = ['base-header__title']

    if (props.light) {
        classes.push('base-header__title--light')
    } else {
        classes.push('base-header__title--dark')
    }

    return classes
})
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.base-header {
    opacity: 0;
    transform: translateY(-20px);
    transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.base-header.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   BASE HEADER CONTAINER
   ============================================ */

.base-header {
    width: 100%;
}

.base-header--center {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

/* ============================================
   TITLE STYLES
   ============================================ */

.base-header__title {
    position: relative;
    display: inline-block;
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.2;
    margin: 0;
}

.base-header__title--dark {
    color: var(--text-dark);
}

.base-header__title--light {
    color: var(--text-light);
}

/* Underline styling */
.base-header__title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -0.5rem;
    height: 3px;
    width: calc(100% + 2.5rem);
    background-color: var(--primary);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.base-header--center .base-header__title::after {
    left: 50%;
    transform: translateX(-50%);
}

/* ============================================
   BUTTON WRAPPER
   ============================================ */

.base-header__button-wrapper {
    margin-top: 1.5rem;
}

.base-header--center .base-header__button-wrapper {
    display: flex;
    justify-content: center;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Mobile (max 640px) */
@media (max-width: 640px) {
    .base-header__title {
        font-size: 2rem;
    }

    .base-header__title::after {
        width: calc(100% + 1.5rem);
        bottom: -0.375rem;
    }

    .base-header__button-wrapper {
        margin-top: 1rem;
    }
}

/* Extra kleine schermen (max 400px) */
@media (max-width: 400px) {
    .base-header__title {
        font-size: 1.75rem;
    }

    .base-header__title::after {
        width: calc(100% + 1rem);
        bottom: -0.25rem;
    }
}

/* Tablet (641px - 1024px) */
@media (min-width: 641px) and (max-width: 1024px) {
    .base-header__title {
        font-size: 2.5rem;
    }

    .base-header__title::after {
        width: calc(100% + 2rem);
    }
}

/* Desktop (min 1025px) */
@media (min-width: 1025px) {
    .base-header__title {
        font-size: 3rem;
    }

    .base-header__title::after {
        width: calc(100% + 2.5rem);
    }
}
@media (min-width: 1440px) {
    .base-header__title {
        font-size: 3.5rem !important;
    }

    .base-header__title::after {
        width: calc(100% + 2.5rem);
    }
}
</style>
