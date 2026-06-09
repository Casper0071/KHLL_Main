<!-- Components/Base/BaseImage.vue -->
<template>
    <div v-intersect="'animate'" :class="containerClass" :style="containerStyle">
        <img
            :src="imageSrc"
            :alt="imageAlt"
            class="base-image__img"
            loading="lazy"
        />
    </div>
</template>

<script setup>
import { computed } from 'vue'

// ============================================
// Props (volledig intact gelaten)
// ============================================

const props = defineProps({
    imageSrc: {
        type: String,
        required: true,
        default: 'https://placehold.co/600x400/e5e7eb/6b7280?text=Image'
    },
    imageAlt: {
        type: String,
        default: 'Image'
    },
    ratio: {
        type: String,
        default: '16/9',
        validator: (value) => ['1/1', '4/3', '16/9', '9/16', '3/2'].includes(value)
    },
    maxWidth: {
        type: String,
        default: '600px'
    }
})

// ============================================
// Computed Properties
// ============================================

const containerStyle = computed(() => ({
    maxWidth: props.maxWidth,
    aspectRatio: props.ratio
}))

const containerClass = computed(() => {
    const ratioMap = {
        '1/1': 'base-image--square',
        '4/3': 'base-image--landscape-4x3',
        '16/9': 'base-image--landscape-16x9',
        '9/16': 'base-image--portrait-9x16',
        '3/2': 'base-image--landscape-3x2'
    }

    const classes = ['base-image']
    if (ratioMap[props.ratio]) {
        classes.push(ratioMap[props.ratio])
    }

    return classes
})
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.base-image {
    opacity: 0;
    transform: scale(0.95);
    transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.base-image.is-visible {
    opacity: 1;
    transform: scale(1);
}

/* ============================================
   BASE IMAGE CONTAINER
   ============================================ */

.base-image {
    width: 100%;
    position: relative;
    overflow: hidden;
    border-radius: 0.75rem;
    background-color: #e5e7eb;
}

/* ============================================
   IMAGE STYLES
   ============================================ */

.base-image__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
}

.base-image:hover .base-image__img {
    transform: scale(1.05);
}

/* ============================================
   RATIO VARIANTS (via aspect-ratio from style)
   ============================================ */

/* Square (1:1) */
.base-image--square {
    border-radius: 0.75rem;
}

/* Landscape 4:3 */
.base-image--landscape-4x3 {
    border-radius: 0.75rem;
}

/* Landscape 16:9 */
.base-image--landscape-16x9 {
    border-radius: 0.75rem;
}

/* Portrait 9:16 */
.base-image--portrait-9x16 {
    border-radius: 0.75rem;
}

/* Landscape 3:2 */
.base-image--landscape-3x2 {
    border-radius: 0.75rem;
}

/* ============================================
   SKELETON LOADING STATE (optional)
   ============================================ */

.base-image--loading {
    background: linear-gradient(
        90deg,
        #e5e7eb 0%,
        #f3f4f6 50%,
        #e5e7eb 100%
    );
    background-size: 200% 100%;
    animation: base-image-skeleton 1.5s infinite;
}

@keyframes base-image-skeleton {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Mobile (max 640px) */
@media (max-width: 640px) {
    .base-image {
        border-radius: 0.5rem;
    }

    .base-image--square,
    .base-image--landscape-4x3,
    .base-image--landscape-16x9,
    .base-image--portrait-9x16,
    .base-image--landscape-3x2 {
        border-radius: 0.5rem;
    }
}

/* Tablet (641px - 1024px) */
@media (min-width: 641px) and (max-width: 1024px) {
    .base-image {
        border-radius: 0.625rem;
    }

    .base-image--square,
    .base-image--landscape-4x3,
    .base-image--landscape-16x9,
    .base-image--portrait-9x16,
    .base-image--landscape-3x2 {
        border-radius: 0.625rem;
    }
}

/* Desktop (min 1025px) */
@media (min-width: 1025px) {
    .base-image {
        border-radius: 0.75rem;
    }
}
</style>
