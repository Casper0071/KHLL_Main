<template>
    <div class="section-container">
        <!-- Top Section: Title + Image -->
        <div class="content-grid">
            <!-- Left: Title and Description -->
            <div class="left-content">
                <BaseTitle 
                    :title="title" 
                    :info-text="description" 
                    :enable-text="true" 
                    :light="light"
                    align="left"
                />
            </div>
            
            <!-- Right: Image -->
            <div class="right-image">
                <BaseImage 
                    :image-src="imageSrc" 
                    ratio="16/9"
                    max-width="500px"
                />
            </div>
        </div>

        <!-- Divider Line -->
        <div class="divider-line" :class="{ 'light-mode': light }"></div>

        <!-- Gallery Section: 3 Landscape Images -->
        <div class="gallery-grid">
            <div v-for="(image, index) in images" :key="index" class="gallery-item">
                <BaseImage 
                    :image-src="image.src" 
                    :image-alt="image.alt"
                    ratio="16/9"
                    max-width="100%"
                />
                <p v-if="image.caption" class="gallery-caption" :class="{ 'light-text': light }">
                    {{ image.caption }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue'
import BaseTitle from '@/Components/BaseTitle.vue'
import BaseImage from '@/Components/BaseImage.vue'

defineProps({
    title: {
        type: String,
        default: 'Onze Collectie'
    },
    description: {
        type: String,
        default: 'Ontdek onze selectie van premium producten en diensten die speciaal voor u zijn samensteld.'
    },
    imageSrc: {
        type: String,
        default: 'https://via.placeholder.com/500x300'
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
.section-container {
    @apply w-full px-4 md:px-8 lg:px-12 py-12;
}

/* Top Section: Grid Layout */
.content-grid {
    @apply grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-10 items-center;
}

.left-content {
    @apply flex flex-col justify-center;
}

.right-image {
    @apply flex items-center justify-center;
}

/* Divider Line */
.divider-line {
    @apply h-px bg-gradient-to-r from-transparent via-primary to-transparent my-8;
    opacity: 0.5;
}

.divider-line.light-mode {
    background: linear-gradient(to right, transparent, var(--primary-light), transparent);
    opacity: 0.4;
}

/* Gallery Section: 3 Landscape Images */
.gallery-grid {
    @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12;
}

.gallery-item {
    @apply overflow-hidden rounded-lg;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.gallery-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.gallery-caption {
    @apply mt-3 text-center text-sm font-semibold text-text-dark;
}

.gallery-caption.light-text {
    @apply text-text-light;
}

/* Responsive Design */
@media (max-width: 768px) {
    .section-container {
        @apply px-4 py-8;
    }

    .content-grid {
        @apply gap-6;
    }

    .gallery-grid {
        @apply grid-cols-1;
    }
}
</style>
