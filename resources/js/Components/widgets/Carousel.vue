<template>
    <div class="carousel-container">
        <div class="carousel-header">
            <h3 class="carousel-title" :class="{ 'light-text': light }">{{ title }}</h3>
        </div>

        <!-- Main Carousel -->
        <div class="carousel-wrapper">
            <div class="carousel-main">
                <img
                    :src="currentImage.src"
                    :alt="currentImage.alt"
                    class="carousel-image"
                />
                <p v-if="currentImage.caption" class="carousel-caption" :class="{ 'light-text': light }">
                    {{ currentImage.caption }}
                </p>
            </div>

            <!-- Navigation Buttons -->
            <button
                @click="previousImage"
                class="nav-arrow nav-prev"
                :class="{ 'light-mode': light }"
                aria-label="Previous image"
            >
                ‹
            </button>
            <button
                @click="nextImage"
                class="nav-arrow nav-next"
                :class="{ 'light-mode': light }"
                aria-label="Next image"
            >
                ›
            </button>
        </div>

        <!-- Indicators Dots -->
        <div class="carousel-indicators" :class="{ 'light-mode': light }">
            <button
                v-for="(image, index) in images"
                :key="index"
                @click="currentIndex = index"
                :class="['dot', { active: currentIndex === index }]"
                :aria-label="`Go to image ${index + 1}`"
            />
        </div>

        <!-- Counter -->
        <div class="carousel-counter" :class="{ 'light-text': light }">
            {{ currentIndex + 1 }} / {{ images.length }}
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, computed } from 'vue'

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

const currentIndex = ref(0)

const currentImage = computed(() => {
    return props.images[currentIndex.value] || props.images[0]
})

const nextImage = () => {
    currentIndex.value = (currentIndex.value + 1) % props.images.length
}

const previousImage = () => {
    currentIndex.value = (currentIndex.value - 1 + props.images.length) % props.images.length
}
</script>

<style scoped>
.carousel-container {
    @apply w-full;
}

.carousel-header {
    @apply mb-4;
}

.carousel-title {
    @apply text-2xl font-bold text-text-dark;
}

.carousel-title.light-text {
    @apply text-text-light;
}

/* Main Carousel */
.carousel-wrapper {
    @apply relative rounded-lg overflow-hidden shadow-lg;
    background: #f0f0f0;
}

.carousel-main {
    @apply relative w-full;
    aspect-ratio: 16/9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.carousel-image {
    @apply w-full h-full object-cover;
    transition: opacity 0.5s ease-in-out;
}

.carousel-caption {
    @apply absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent px-6 py-4 text-white text-center font-semibold;
}

.carousel-caption.light-text {
    @apply text-text-light;
    background: linear-gradient(to top, rgba(11, 18, 42, 0.7), transparent);
}

/* Navigation Arrows */
.nav-arrow {
    @apply absolute top-1/2 transform -translate-y-1/2 z-10;
    @apply text-7xl font-bold text-primary opacity-70;
    @apply hover:opacity-100 transition-all duration-200;
    @apply bg-transparent border-none cursor-pointer;
    @apply flex items-center justify-center;
    padding: 0;
    width: 100px;
    height: 100%;
    line-height: 1;
}

.nav-arrow:hover {
    @apply scale-125;
}

.nav-arrow.light-mode {
    @apply text-yellow-300 opacity-60 hover:opacity-100;
}

.nav-prev {
    @apply left-0;
}

.nav-next {
    @apply right-0;
}

/* Indicators Dots */
.carousel-indicators {
    @apply flex justify-center gap-2 mt-4 pb-2;
}

.carousel-indicators.light-mode {
    padding: 12px 0;
    margin: 8px 0;
    border-radius: 8px;
}

.dot {
    @apply w-3 h-3 rounded-full bg-text-muted;
    @apply transition-all duration-300 cursor-pointer hover:bg-primary/60;
}

.dot.active {
    @apply bg-primary w-8;
}

/* Counter */
.carousel-counter {
    @apply text-center text-sm text-text-muted font-semibold mt-3;
}

.carousel-counter.light-text {
    @apply text-accent-soft;
}

/* Responsive */
@media (max-width: 768px) {
    .nav-button {
        @apply w-10 h-10 text-lg;
    }

    .nav-prev {
        @apply left-2;
    }

    .nav-next {
        @apply right-2;
    }
}
</style>
