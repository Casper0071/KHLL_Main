<template>
    <div class="journey-container" :class="{ 'light-mode': light }">
        <!-- Top Section: Image + Title/Description -->
        <div class="content-grid">
            <!-- Left: Image Section -->
            <div class="image-section">
                <img :src="imageSrc" :alt="title" class="journey-image" />
            </div>

            <!-- Right: Title and Description -->
            <div class="text-section">
                <BaseTitle
                    :title="title"
                    :info-text="description"
                    :enable-text="true"
                    :light="light"
                    align="right"
                />
            </div>
        </div>

        <!-- Divider -->
        <div class="divider-line" :class="{ 'light-mode': light }"></div>

        <!-- Stappen Section -->
        <div class="steps-section">
            <div class="steps-grid">
                <div
                    v-for="(step, index) in steps"
                    :key="index"
                    class="step-card"
                    :class="{ 'light-mode': light }"
                >
                    <!-- Step Number Circle -->
                    <div class="step-circle">
                        {{ index + 1 }}
                    </div>

                    <!-- Step Title -->
                    <h3 class="step-title" :class="{ 'light-text': light }">
                        {{ step.title }}
                    </h3>

                    <!-- Step Description -->
                    <p class="step-description" :class="{ 'light-text': light }">
                        {{ step.description }}
                    </p>

                    <!-- Connector Line (not visible on last item) -->
                    <div v-if="index < steps.length - 1" class="connector-line" :class="{ 'light-mode': light }"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue'
import BaseTitle from '@/Components/BaseTitle.vue'

defineProps({
    title: {
        type: String,
        default: 'Jouw Muzikale Reis'
    },
    description: {
        type: String,
        default: 'De harmonie biedt een unieke reis waar iedere muzikant op zijn of haar niveau deel kan nemen. Van eerste kennismaking tot lid van het grote orkest.'
    },
    imageSrc: {
        type: String,
        default: 'https://via.placeholder.com/500x400'
    },
    steps: {
        type: Array,
        default: () => [
            {
                title: 'Blokfluiters',
                description: 'Als allereerste begin - de eerste kennismaking met muziek'
            },
            {
                title: 'Speelgroepje',
                description: 'Om te leren "samen muziek" te maken'
            },
            {
                title: 'LOL Orkest',
                description: 'Lentekrans Opleidingsorkest Linne - voor iedereen op zijn/haar niveau'
            },
            {
                title: 'Groot Orkest',
                description: 'Het grote orkest als uiteindelijk doel'
            }
        ]
    },
    light: {
        type: Boolean,
        default: true
    }
})
</script>

<style scoped>
/* ============================================
   Container - Base Layout
   ============================================ */

.journey-container {
    @apply w-full px-3 sm:px-4 md:px-8 lg:px-12 py-6 sm:py-8 md:py-12;
}

/* ============================================
   Top Section - Grid with Image & Text
   ============================================ */

.content-grid {
    @apply grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 mb-8 sm:mb-10 lg:mb-12 items-center;
}

.image-section {
    @apply flex justify-center;
}

.journey-image {
    @apply w-full h-auto rounded-lg object-cover shadow-lg max-w-[500px];
}

/* ============================================
   Divider Line - Visual Separator
   ============================================ */

.divider-line {
    @apply h-1 bg-primary mb-8 sm:mb-10 lg:mb-12 rounded;
    opacity: 0.5;
}

.divider-line.light-mode {
    opacity: 0.3;
}

/* ============================================
   Steps Section - Cards Grid
   ============================================ */

.steps-section {
    @apply w-full;
}

.steps-grid {
    @apply grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 md:gap-4;
}

.step-card {
    @apply relative bg-surface-soft rounded-lg p-4 sm:p-5 md:p-6 text-center transition-all duration-300 hover:shadow-lg;
    animation: fadeInUp 600ms ease-out forwards;
    opacity: 0;
}

.step-card.light-mode {
    @apply bg-surface;
}

.step-card:hover {
    @apply transform -translate-y-1;
}

/* ============================================
   Step Card - Number Circle
   ============================================ */

.step-circle {
    @apply w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-text-dark font-poppins font-bold text-base sm:text-lg flex items-center justify-center mx-auto mb-3 sm:mb-4;
}

.step-card:hover .step-circle {
    @apply shadow-lg;
    box-shadow: 0 8px 16px rgba(234, 183, 81, 0.3);
}

/* ============================================
   Step Card - Title & Description
   ============================================ */

.step-title {
    @apply font-poppins font-semibold mb-2 sm:mb-3 text-base sm:text-lg text-[#0B122A];
}

.step-description {
    @apply text-xs sm:text-sm font-opensans leading-relaxed text-[#0B122A];
}

/* ============================================
   Connector Lines - Visual Flow
   ============================================ */

.connector-line {
    @apply hidden sm:block absolute top-16 -right-2.5 w-5 h-0.5 bg-primary;
}

.connector-line.light-mode {
    opacity: 0.3;
}

/* ============================================
   Animation - Staggered Entrance
   ============================================ */

.step-card:nth-child(1) {
    animation-delay: 0ms;
}

.step-card:nth-child(2) {
    animation-delay: 100ms;
}

.step-card:nth-child(3) {
    animation-delay: 200ms;
}

.step-card:nth-child(4) {
    animation-delay: 300ms;
}

@keyframes fadeInUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* ============================================
   Responsive Design - Mobile & Tablet
   ============================================ */

/* Tablet: 641px to 1024px */
@media (min-width: 641px) and (max-width: 1024px) {
    .connector-line {
        @apply hidden;
    }

    .step-card:nth-child(odd):not(:last-child)::after {
        content: '';
        @apply absolute -bottom-5 left-1/2 w-0.5 h-5 bg-primary;
        transform: translateX(-50%);
        opacity: 0.3;
    }
}

/* Mobile: 640px and down */
@media (max-width: 640px) {
    .connector-line {
        @apply hidden;
    }

    .step-card::after {
        content: '';
        @apply absolute -bottom-5 left-1/2 w-0.5 h-5 bg-primary;
        transform: translateX(-50%);
        opacity: 0.3;
    }

    .step-card:last-child::after {
        @apply hidden;
    }
}

/* Hide image on smaller screens */
@media (max-width: 1024px) {
    .content-grid {
        @apply grid-cols-1;
    }

    .image-section {
        @apply hidden;
    }
}
</style>
