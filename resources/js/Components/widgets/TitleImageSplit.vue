<template>
    <section v-intersect="'animate'" class="title-image-split" :class="{ 'title-image-split--light': light }">
        <div class="title-image-split__grid" :class="gridClass">
            <div class="title-image-split__content">
                <BaseTitle
                    :title="title"
                    :info-text="infoText"
                    :enable-text="enableText"
                    :align="titleAlign"
                    :light="light"
                />
            </div>

            <div class="title-image-split__image">
                <BaseImage
                    :image-src="imageSrc"
                    :image-alt="imageAlt"
                    :ratio="ratio"
                    max-width="100%"
                />
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, defineProps } from 'vue'
import BaseTitle from '@/Components/Base/BaseTitle.vue'
import BaseImage from '@/Components/Base/BaseImage.vue'

// ============================================
// Props
// ============================================

const props = defineProps({
    imageSrc: {
        type: String,
        required: true
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
    title: {
        type: String,
        required: true
    },
    infoText: {
        type: String,
        default: ''
    },
    enableText: {
        type: Boolean,
        default: true
    },
    orientation: {
        type: String,
        default: 'left',
        validator: (value) => ['left', 'right'].includes(String(value).toLowerCase())
    },
    light: {
        type: Boolean,
        default: false
    }
})

// ============================================
// Computed Properties
// ============================================

const normalizedOrientation = computed(() => String(props.orientation).toLowerCase())
const titleAlign = computed(() => normalizedOrientation.value === 'right' ? 'right' : 'left')
const gridClass = computed(() => normalizedOrientation.value === 'right' ? 'title-image-split__grid--right' : 'title-image-split__grid--left')
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.title-image-split {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.title-image-split.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   TITLE IMAGE SPLIT SECTION
   ============================================ */

.title-image-split {
    width: 100%;
}

.title-image-split--light {
    /* Light mode variant container styles */
}

/* ============================================
   GRID LAYOUT
   ============================================ */

.title-image-split__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    align-items: center;
}

/* ============================================
   CONTENT & IMAGE SECTIONS
   ============================================ */

.title-image-split__content {
    width: 100%;
}

.title-image-split__image {
    width: 100%;
}

/* ============================================
   ORIENTATION VARIANTS
   ============================================ */

/* Left orientation (image on right) */
.title-image-split__grid--left .title-image-split__image {
    order: 2;
}

.title-image-split__grid--left .title-image-split__content {
    order: 1;
}

/* Right orientation (image on left) */
.title-image-split__grid--right .title-image-split__image {
    order: 1;
}

.title-image-split__grid--right .title-image-split__content {
    order: 2;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Tablet (640px - 1024px) */
@media (min-width: 640px) {
    .title-image-split__grid {
        gap: 2rem;
    }
}

/* Desktop (1024px+) - 2 kolommen layout */
@media (min-width: 1024px) {
    .title-image-split__grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2.5rem;
    }

    /* Reset order for desktop */
    .title-image-split__grid--left .title-image-split__image {
        order: 2;
    }

    .title-image-split__grid--left .title-image-split__content {
        order: 1;
    }

    .title-image-split__grid--right .title-image-split__image {
        order: 1;
    }

    .title-image-split__grid--right .title-image-split__content {
        order: 2;
    }
}

/* Desktop groot (1280px+) */
@media (min-width: 1280px) {
    .title-image-split__grid {
        gap: 3rem;
    }
}

/* Mobile (max 640px) - 1 kolom, image boven/onder afhankelijk van orientation */
@media (max-width: 639px) {
    .title-image-split__grid {
        gap: 1.5rem;
    }

}
</style>
