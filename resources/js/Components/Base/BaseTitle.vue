<template>
    <div v-intersect="'animate'" :class="containerClass">
        <h1 :class="titleClasses">{{ title }}</h1>
        <template v-if="enableText">
            <p v-if="typeof infoText === 'string'" :class="textClasses">{{ infoText }}</p>
            <template v-else>
                <p v-for="(paragraph, index) in infoText" :key="index" :class="[textClasses, 'base-title__paragraph']">
                    {{ paragraph }}
                </p>
            </template>
        </template>
    </div>
</template>

<script setup>
import { computed } from 'vue'

// ============================================
// Props
// ============================================

const props = defineProps({
    title: {
        type: String,
        required: true,
        default: 'Title'
    },
    infoText: {
        type: [String, Array],
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

// ============================================
// Computed Properties
// ============================================

const containerClass = computed(() => {
    const classes = ['base-title']

    if (props.align === 'center') {
        classes.push('base-title--center')
    } else if (props.align === 'right') {
        classes.push('base-title--right')
    }

    return classes
})

const titleClasses = computed(() => {
    const classes = ['base-title__heading']

    if (props.light) {
        classes.push('base-title__heading--light')
    } else {
        classes.push('base-title__heading--dark')
    }

    return classes
})

const textClasses = computed(() => {
    const classes = ['base-title__text']

    if (props.light) {
        classes.push('base-title__text--light')
    } else {
        classes.push('base-title__text--dark')
    }

    // Animation based on alignment
    if (props.align === 'left') {
        classes.push('base-title__text--slide-left')
    } else if (props.align === 'right') {
        classes.push('base-title__text--slide-right')
    } else {
        classes.push('base-title__text--fade')
    }

    return classes
})
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.base-title {
    opacity: 0;
    transform: translateY(25px);
    transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.base-title.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   BASE TITLE CONTAINER
   ============================================ */

.base-title {
    --underline-color: var(--primary);
    --underline-height: 3px;
    --underline-offset: 30px;
    padding: 3rem 2rem;
}

.base-title--center {
    text-align: center;
}

.base-title--right {
    direction: rtl;
    text-align: right;
}

/* ============================================
   HEADING STYLES
   ============================================ */

.base-title__heading {
    position: relative;
    display: inline-block;
    font-size: inherit;
    margin: 0;
}

.base-title__heading::after {
    content: '';
    position: absolute;
    bottom: calc(-4px - var(--underline-height));
    height: var(--underline-height);
    background-color: var(--underline-color);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.base-title--center .base-title__heading::after {
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% + 40px);
}

.base-title:not(.base-title--center):not(.base-title--right) .base-title__heading::after {
    left: 0;
    width: calc(100% + var(--underline-offset));
}

.base-title--right .base-title__heading::after {
    left: auto;
    right: 0;
    width: calc(100% + var(--underline-offset));
}

/* Heading color variants */
.base-title__heading--light {
    color: var(--text-light);
}

.base-title__heading--dark {
    color: var(--text-dark);
}

/* ============================================
   TEXT STYLES
   ============================================ */

.base-title__text {
    margin-top: 1rem;
    line-height: 1.6;
}

.base-title__paragraph {
    margin-bottom: 1rem;
}

.base-title__paragraph:last-child {
    margin-bottom: 0;
}

/* Text color variants */
.base-title__text--light {
    color: var(--text-light);
}

.base-title__text--dark {
    color: var(--text-dark);
}

/* ============================================
   INTERNAL ANIMATIONS (blijven behouden)
   ============================================ */

/* Fade animation (center alignment) */
.base-title__text--fade {
    animation: base-title-fade 0.4s ease-out forwards;
}

@keyframes base-title-fade {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Slide left animation (left alignment) */
.base-title__text--slide-left {
    animation: base-title-slide-left 0.4s ease-out forwards;
}

@keyframes base-title-slide-left {
    from {
        transform: translateX(-20px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Slide right animation (right alignment) */
.base-title__text--slide-right {
    animation: base-title-slide-right 0.4s ease-out forwards;
}

@keyframes base-title-slide-right {
    from {
        transform: translateX(20px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Mobile (max 640px) */
@media (max-width: 640px) {
    .base-title {
        padding: 2rem 1rem;
    }

    .base-title__heading {
        font-size: 1.5rem;
    }

    .base-title__text {
        font-size: 0.875rem;
        margin-top: 0.75rem;
    }
}

/* Extra kleine schermen (max 400px) */
@media (max-width: 400px) {
    .base-title {
        padding: 1.5rem 0.75rem;
    }

    .base-title__heading {
        font-size: 1.25rem;
    }

    .base-title__heading::after {
        --underline-offset: 20px;
    }

    .base-title--center .base-title__heading::after {
        width: calc(100% + 20px);
    }
}

/* Tablet (641px - 1024px) */
@media (min-width: 641px) and (max-width: 1024px) {
    .base-title {
        padding: 2.5rem 1.5rem;
    }

    .base-title__heading {
        font-size: 1.75rem;
    }
}

/* Desktop (min 1025px) */
@media (min-width: 1025px) {
    .base-title {
        padding: 3rem 2rem;
    }

    .base-title__heading {
        font-size: 2rem;
    }
}
</style>
