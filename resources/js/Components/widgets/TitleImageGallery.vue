<template>
    <div v-intersect="'animate'" class="title-image-gallery" :class="{ 'title-image-gallery--light': light }">
        <!-- Top Section: Title + Image -->
        <div class="title-image-gallery__grid">
            <!-- Left: Title and Description -->
            <div class="title-image-gallery__content">
                <BaseTitle
                    :title="title"
                    :info-text="description"
                    :enable-text="true"
                    :light="light"
                    align="left"
                />
            </div>

            <!-- Right: Image -->
            <div class="title-image-gallery__image-wrapper">
                <BaseImage
                    :imageAlt="afbAlt"
                    :image-src="imageSrc"
                    ratio="16/9"
                    max-width="500px"
                />
            </div>
        </div>

        <!-- Divider Line -->
        <div class="title-image-gallery__divider" :class="{ 'title-image-gallery__divider--light': light }"></div>

        <!-- Gallery Section: 3 Landscape Images -->
        <div class="title-image-gallery__gallery">
            <div v-for="(image, index) in images" :key="index" class="title-image-gallery__gallery-item">
                <BaseImage
                    :image-src="image.src"
                    :image-alt="image.alt"
                    ratio="16/9"
                    max-width="100%"
                />
                <p v-if="image.caption" class="title-image-gallery__caption" :class="{ 'title-image-gallery__caption--light': light }">
                    {{ image.caption }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue'
import BaseTitle from '@/Components/Base/BaseTitle.vue'
import BaseImage from '@/Components/Base/BaseImage.vue'

// ============================================
// Props
// ============================================

defineProps({
    title: {
        type: String,
        default: 'Onze Collectie'
    },
    description: {
        type: String,
        default: 'Ontdek onze selectie van premium producten en diensten die speciaal voor u zijn samengesteld.'
    },
    imageSrc: {
        type: String,
        default: 'https://via.placeholder.com/500x300'
    },
    afbAlt: {
        type: String,
        default: ''
    },
    images: {
        type: Array,
        default: () => [
            {
                src: 'https://via.placeholder.com/400x225',
                alt: 'Gallery Image 1',
                caption: 'Afbeelding 1'
            },
            {
                src: 'https://via.placeholder.com/400x225',
                alt: 'Gallery Image 2',
                caption: 'Afbeelding 2'
            },
            {
                src: 'https://via.placeholder.com/400x225',
                alt: 'Gallery Image 3',
                caption: 'Afbeelding 3'
            }
        ]
    },
    light: {
        type: Boolean,
        default: false
    }
})
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.title-image-gallery {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.title-image-gallery.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* Staggered animation for gallery items */
.is-visible .title-image-gallery__gallery-item {
    animation: title-image-gallery-item-fade-in 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    opacity: 0;
}

.is-visible .title-image-gallery__gallery-item:nth-child(1) {
    animation-delay: 0s;
}

.is-visible .title-image-gallery__gallery-item:nth-child(2) {
    animation-delay: 0.1s;
}

.is-visible .title-image-gallery__gallery-item:nth-child(3) {
    animation-delay: 0.2s;
}

@keyframes title-image-gallery-item-fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ============================================
   SECTION CONTAINER
   ============================================ */

.title-image-gallery {
    width: 100%;
    padding: 3rem 1rem;
}

/* ============================================
   TOP SECTION - GRID LAYOUT
   ============================================ */

.title-image-gallery__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-bottom: 2.5rem;
    align-items: center;
}

.title-image-gallery__content {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.title-image-gallery__image-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ============================================
   DIVIDER LINE
   ============================================ */

.title-image-gallery__divider {
    height: 1px;
    background: linear-gradient(to right, transparent, var(--primary), transparent);
    margin: 2rem 0;
    opacity: 0.5;
}

.title-image-gallery__divider--light {
    background: linear-gradient(to right, transparent, var(--primary-light), transparent);
    opacity: 0.4;
}

/* ============================================
   GALLERY SECTION
   ============================================ */

.title-image-gallery__gallery {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-top: 3rem;
}

.title-image-gallery__gallery-item {
    overflow: hidden;
    border-radius: 0.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    opacity: 0;
}

.title-image-gallery__gallery-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

/* ============================================
   CAPTION STYLES
   ============================================ */

.title-image-gallery__caption {
    margin-top: 0.75rem;
    text-align: center;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
}

.title-image-gallery__caption--light {
    color: var(--text-light);
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Tablet (640px - 768px) */
@media (min-width: 640px) {
    .title-image-gallery {
        padding: 3rem 1.5rem;
    }

    .title-image-gallery__grid {
        gap: 2rem;
        margin-bottom: 2.5rem;
    }
}

/* Tablet groot (768px - 1024px) - 2 kolommen gallery */
@media (min-width: 768px) {
    .title-image-gallery__gallery {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
}

/* Desktop (1024px+) - 2 kolommen top section, 3 kolommen gallery */
@media (min-width: 1024px) {
    .title-image-gallery {
        padding: 4rem 2rem;
    }

    .title-image-gallery__grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 3rem;
        margin-bottom: 3rem;
    }

    .title-image-gallery__gallery {
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 4rem;
    }
}

/* Desktop groot (1280px+) */
@media (min-width: 1280px) {
    .title-image-gallery {
        padding: 4rem 3rem;
    }

    .title-image-gallery__gallery {
        gap: 2.5rem;
    }
}

/* Mobile (max 640px) */
@media (max-width: 640px) {
    .title-image-gallery {
        padding: 2rem 0.75rem;
    }

    .title-image-gallery__grid {
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .title-image-gallery__gallery {
        margin-top: 2rem;
        gap: 1.25rem;
    }

    .title-image-gallery__caption {
        font-size: 0.75rem;
        margin-top: 0.5rem;
    }
}

/* Hover effect alleen op desktop voor betere mobile UX */
@media (hover: hover) {
    .title-image-gallery__gallery-item:hover {
        transform: translateY(-8px);
    }
}
</style>
