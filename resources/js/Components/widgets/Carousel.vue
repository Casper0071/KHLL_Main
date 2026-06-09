<template>
    <div v-intersect="'animate'" class="carousel-widget" :class="{ 'carousel-widget--light': light }">
        <div class="carousel-widget__header">
            <h3 class="carousel-widget__title" :class="{ 'carousel-widget__title--light': light }">{{ title }}</h3>
        </div>

        <!-- Main Carousel -->
        <div class="carousel-widget__wrapper">
            <div class="carousel-widget__main">
                <img
                    :src="currentImage.src"
                    :alt="currentImage.alt"
                    class="carousel-widget__image"
                />
                <p v-if="currentImage.caption" class="carousel-widget__caption" :class="{ 'carousel-widget__caption--light': light }">
                    {{ currentImage.caption }}
                </p>
            </div>

            <!-- Navigation Buttons -->
            <button
                @click="previousImage"
                class="carousel-widget__nav carousel-widget__nav--prev"
                :class="{ 'carousel-widget__nav--light': light }"
                aria-label="Previous image"
            >
                ‹
            </button>
            <button
                @click="nextImage"
                class="carousel-widget__nav carousel-widget__nav--next"
                :class="{ 'carousel-widget__nav--light': light }"
                aria-label="Next image"
            >
                ›
            </button>
        </div>

        <!-- Indicators Dots -->
        <div class="carousel-widget__indicators" :class="{ 'carousel-widget__indicators--light': light }">
            <button
                v-for="(image, index) in images"
                :key="index"
                @click="currentIndex = index"
                :class="['carousel-widget__dot', { 'carousel-widget__dot--active': currentIndex === index }]"
                :aria-label="`Go to image ${index + 1}`"
            />
        </div>

        <!-- Counter -->
        <div class="carousel-widget__counter" :class="{ 'carousel-widget__counter--light': light }">
            {{ currentIndex + 1 }} / {{ images.length }}
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, computed } from 'vue'

// ============================================
// Props (volledig intact gelaten)
// ============================================

const props = defineProps({
    title: {
        type: String,
        default: 'Fotogalerij'
    },
    images: {
        type: Array,
        default: () => [
            {
                src: 'https://via.placeholder.com/800x500',
                alt: 'Image 1',
                caption: 'Afbeelding 1'
            },
            {
                src: 'https://via.placeholder.com/800x500',
                alt: 'Image 2',
                caption: 'Afbeelding 2'
            },
            {
                src: 'https://via.placeholder.com/800x500',
                alt: 'Image 3',
                caption: 'Afbeelding 3'
            },
            {
                src: 'https://via.placeholder.com/800x500',
                alt: 'Image 4',
                caption: 'Afbeelding 4'
            }
        ]
    },
    light: {
        type: Boolean,
        default: false
    }
})

// ============================================
// Reactive State
// ============================================

const currentIndex = ref(0)

// ============================================
// Computed Properties
// ============================================

const currentImage = computed(() => {
    return props.images[currentIndex.value] || props.images[0]
})

// ============================================
// Methods
// ============================================

const nextImage = () => {
    currentIndex.value = (currentIndex.value + 1) % props.images.length
}

const previousImage = () => {
    currentIndex.value = (currentIndex.value - 1 + props.images.length) % props.images.length
}
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.carousel-widget {
    opacity: 0;
    transform: translateY(25px);
    transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.carousel-widget.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   CAROUSEL WIDGET CONTAINER
   ============================================ */

.carousel-widget {
    width: 100%;
}

.carousel-widget--light {
    /* Light mode variant container styles */
}

/* ============================================
   HEADER SECTION
   ============================================ */

.carousel-widget__header {
    margin-bottom: 1rem;
}

.carousel-widget__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
}

.carousel-widget__title--light {
    color: var(--text-light);
}

/* ============================================
   MAIN CAROUSEL WRAPPER
   ============================================ */

.carousel-widget__wrapper {
    position: relative;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    background: var(--surface);
}

.carousel-widget__main {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.carousel-widget__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.5s ease-in-out;
}

.carousel-widget__caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
    padding: 1rem 1.5rem;
    color: white;
    text-align: center;
    font-weight: 600;
}

.carousel-widget__caption--light {
    color: var(--text-light);
    background: linear-gradient(to top, rgba(11, 18, 42, 0.7), transparent);
}

/* ============================================
   NAVIGATION ARROWS
   ============================================ */

.carousel-widget__nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    font-size: 4rem;
    font-weight: 700;
    color: var(--primary);
    opacity: 0.7;
    transition: all 0.2s ease;
    background: transparent;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    width: 100px;
    height: 100%;
    line-height: 1;
}

.carousel-widget__nav:hover {
    opacity: 1;
    transform: translateY(-50%) scale(1.25);
}

.carousel-widget__nav--light {
    color: #fbbf24;
    opacity: 0.6;
}

.carousel-widget__nav--light:hover {
    opacity: 1;
}

.carousel-widget__nav--prev {
    left: 0;
}

.carousel-widget__nav--next {
    right: 0;
}

/* ============================================
   INDICATORS DOTS
   ============================================ */

.carousel-widget__indicators {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
    padding-bottom: 0.5rem;
}

.carousel-widget__indicators--light {
    padding: 12px 0;
    margin: 8px 0;
    border-radius: 8px;
}

.carousel-widget__dot {
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 9999px;
    background-color: var(--text-muted);
    transition: all 0.3s ease;
    cursor: pointer;
}

.carousel-widget__dot:hover {
    background-color: rgba(234, 183, 81, 0.6);
}

.carousel-widget__dot--active {
    background-color: var(--primary);
    width: 2rem;
}

/* ============================================
   COUNTER
   ============================================ */

.carousel-widget__counter {
    text-align: center;
    font-size: 0.875rem;
    color: var(--text-muted);
    font-weight: 600;
    margin-top: 0.75rem;
}

.carousel-widget__counter--light {
    color: var(--accent-soft);
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

@media (max-width: 768px) {
    .carousel-widget__nav {
        font-size: 2rem;
        width: 50px;
    }

    .carousel-widget__nav--prev {
        left: 0;
    }

    .carousel-widget__nav--next {
        right: 0;
    }
}

@media (max-width: 480px) {
    .carousel-widget__caption {
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
    }

    .carousel-widget__counter {
        font-size: 0.75rem;
    }
}
</style>
