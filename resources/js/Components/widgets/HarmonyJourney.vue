<template>
    <div v-intersect="'animate'" class="harmony-journey" :class="{ 'harmony-journey--light': light }">
        <!-- Top Section: Image + Title/Description -->
        <div class="harmony-journey__grid">
            <!-- Left: Image Section -->
            <div class="harmony-journey__image-wrapper">
                <img :src="imageSrc" :alt="effectiveTitle" class="harmony-journey__image" />
            </div>

            <!-- Right: Title and Description -->
            <div class="harmony-journey__text">
                <BaseTitle
                    :title="effectiveTitle"
                    :info-text="effectiveDescription"
                    :enable-text="true"
                    :light="light"
                    align="right"
                />
            </div>
        </div>

        <!-- Divider -->
        <div class="harmony-journey__divider" :class="{ 'harmony-journey__divider--light': light }"></div>

        <!-- Stappen Section -->
        <div class="harmony-journey__steps">
            <div class="harmony-journey__steps-grid">
                <div
                    v-for="(step, index) in effectiveSteps"
                    :key="index"
                    class="step-card"
                    :class="{ 'step-card--light': light }"
                >
                    <!-- Step Number Circle -->
                    <div class="step-card__circle">
                        {{ index + 1 }}
                    </div>

                    <!-- Step Title -->
                    <h3 class="step-card__title" :class="{ 'step-card__title--light': light }">
                        {{ step.title }}
                    </h3>

                    <!-- Step Description -->
                    <p class="step-card__description" :class="{ 'step-card__description--light': light }">
                        {{ step.description }}
                    </p>

                    <!-- Horizontale Connector Line (rechts) - voor desktop en tablet -->
                    <div
                        v-if="
                            (effectiveSteps.length === 4 && (index === 0 || index === 1 || index === 2)) ||
                            (effectiveSteps.length === 2 && index === 0) ||
                            (effectiveSteps.length === 3 && index !== effectiveSteps.length - 1)
                        "
                        class="step-card__connector step-card__connector--horizontal"
                        :class="{ 'step-card__connector--light': light }"
                    ></div>

                    <!-- Verticale Connector Line (onder) - alleen voor mobiel -->
                    <div
                        v-if="index < effectiveSteps.length - 1"
                        class="step-card__connector step-card__connector--vertical"
                        :class="{ 'step-card__connector--light': light }"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed } from 'vue'
import { useTranslations } from '@/composables/useTranslations'
import BaseTitle from '@/Components/Base/BaseTitle.vue'

// ============================================
// Props
// ============================================

const props = defineProps({
    title: {
        type: String,
        default: null
    },
    description: {
        type: String,
        default: null
    },
    imageSrc: {
        type: String,
        default: 'https://via.placeholder.com/500x400'
    },
    steps: {
        type: Array,
        default: null
    },
    light: {
        type: Boolean,
        default: true
    }
})

// ============================================
// Composables
// ============================================

const { t } = useTranslations()

// ============================================
// Computed Properties
// ============================================

const effectiveTitle = computed(() => props.title || t.harmonyJourneyTitle)
const effectiveDescription = computed(() => props.description || t.harmonyJourneyDescription)
const effectiveSteps = computed(() => props.steps || t.steps || [])
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.harmony-journey {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.harmony-journey.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* Staggered animation for step cards when container is visible */
.is-visible .step-card {
    animation: stepCardFadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    opacity: 0;
}

.is-visible .step-card:nth-child(1) { animation-delay: 0s; }
.is-visible .step-card:nth-child(2) { animation-delay: 0.1s; }
.is-visible .step-card:nth-child(3) { animation-delay: 0.2s; }
.is-visible .step-card:nth-child(4) { animation-delay: 0.3s; }

@keyframes stepCardFadeInUp {
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
   Container - Base Layout
   ============================================ */

.harmony-journey {
    width: 100%;
    padding: 1.5rem 0.75rem;
}

.harmony-journey--light {
    /* Light mode variant specific styles if needed */
}

/* ============================================
   Top Section - Grid with Image & Text
   ============================================ */

.harmony-journey__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
    align-items: center;
}

.harmony-journey__image-wrapper {
    display: flex;
    justify-content: center;
}

.harmony-journey__image {
    width: 100%;
    height: auto;
    border-radius: 0.5rem;
    object-fit: cover;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    max-width: 500px;
}

/* ============================================
   Divider Line - Visual Separator
   ============================================ */

.harmony-journey__divider {
    height: 0.25rem;
    background-color: var(--primary);
    margin-bottom: 2rem;
    border-radius: 9999px;
    opacity: 0.5;
}

.harmony-journey__divider--light {
    opacity: 0.3;
}

/* ============================================
   Steps Section - Cards Grid
   ============================================ */

.harmony-journey__steps {
    width: 100%;
}

.harmony-journey__steps-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    position: relative;
}

/* ============================================
   STEP CARD - Basis styling
   ============================================ */

.step-card {
    position: relative;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 1rem;
    padding: 1.5rem 1rem;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
    opacity: 0;
}

/* Donkere modus */
.step-card--light {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.step-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
    border-color: var(--primary);
}

.step-card--light:hover {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
}

/* ============================================
   Step Card - Number Circle
   ============================================ */

.step-card__circle {
    width: 3rem;
    height: 3rem;
    border-radius: 9999px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
    color: white;
    font-weight: 700;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
    box-shadow: 0 4px 6px -1px rgba(234, 183, 81, 0.3);
}

.step-card:hover .step-card__circle {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(234, 183, 81, 0.4);
}

/* ============================================
   Step Card - Title
   ============================================ */

.step-card__title {
    font-weight: 700;
    margin-bottom: 0.75rem;
    font-size: 1.125rem;
    color: #1a1a2e;
    letter-spacing: -0.01em;
}

.step-card__title--light {
    color: var(--text-light);
}

/* ============================================
   Step Card - Description
   ============================================ */

.step-card__description {
    font-size: 0.875rem;
    line-height: 1.6;
    color: #4a5568;
}

.step-card__description--light {
    color: rgba(255, 255, 255, 0.8);
}

/* ============================================
   CONNECTOR LINES - Horizontal (Desktop/Tablet)
   ============================================ */

.step-card__connector {
    display: none;
    position: absolute;
    background-color: var(--primary);
    opacity: 0.6;
}

.step-card__connector--horizontal {
    top: 50%;
    right: -1.5rem;
    width: 1.5rem;
    height: 0.125rem;
    transform: translateY(-50%);
}

.step-card__connector--light {
    opacity: 0.4;
    background-color: var(--primary-light);
}

/* Tablet en Desktop: toon horizontale connector */
@media (min-width: 640px) {
    .harmony-journey__steps-grid:has(> :nth-child(2)) .step-card:nth-child(odd):not(:last-child) .step-card__connector--horizontal,
    .harmony-journey__steps-grid:has(> :nth-child(4)) .step-card:nth-child(odd):not(:last-child) .step-card__connector--horizontal {
        display: block;
    }
}

/* Desktop (4 kolommen) */
@media (min-width: 1024px) {
    .step-card:not(:last-child) .step-card__connector--horizontal {
        display: block;
    }
}

/* ============================================
   CONNECTOR LINES - Vertical (Mobile)
   ============================================ */

.step-card__connector--vertical {
    bottom: -1.3rem;
    left: 50%;
    width: 0.125rem;
    height: 0.75rem;
    transform: translateX(-50%);
}

/* Alleen op mobiel de verticale connectors tonen */
@media (max-width: 639px) {
    .step-card:not(:last-child) .step-card__connector--vertical {
        display: block;
    }
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Tablet (640px - 768px) */
@media (min-width: 640px) {
    .harmony-journey {
        padding: 2rem 1rem;
    }

    .harmony-journey__grid {
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    .harmony-journey__divider {
        margin-bottom: 2.5rem;
    }

    .harmony-journey__steps-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .step-card {
        padding: 1.5rem;
    }

    .step-card__circle {
        width: 3.5rem;
        height: 3.5rem;
        font-size: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .step-card__title {
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .step-card__description {
        font-size: 0.9375rem;
    }
}

/* Tablet groot (768px - 1024px) */
@media (min-width: 768px) {
    .harmony-journey {
        padding: 2rem 1.5rem;
    }
}

/* Desktop (1024px+) */
@media (min-width: 1024px) {
    .harmony-journey {
        padding: 3rem 2rem;
    }

    .harmony-journey__grid {
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
    }

    .harmony-journey__image-wrapper {
        display: flex;
        justify-content: center;
    }

    .harmony-journey__divider {
        margin-bottom: 3rem;
    }

    .harmony-journey__steps-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    .step-card {
        padding: 2rem 1.5rem;
    }
}

/* Image visibility on desktop only */
@media (max-width: 1024px) {
    .harmony-journey__image-wrapper {
        display: none;
    }
}

/* Mobile (max 640px) */
@media (max-width: 640px) {
    .harmony-journey__steps-grid {
        gap: 1.5rem;
    }
}
</style>
