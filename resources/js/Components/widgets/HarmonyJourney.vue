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
                    :title="effectiveTitle"
                    :info-text="effectiveDescription"
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
                    v-for="(step, index) in effectiveSteps"
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

                    <!-- Horizontale Connector Line (rechts) - voor desktop en tablet -->
                    <div
                        v-if="
                            (effectiveSteps.length === 4 && (index === 0 || index === 1 || index === 2)) ||
                            (effectiveSteps.length === 2 && index === 0) ||
                            (effectiveSteps.length === 3 && index !== effectiveSteps.length - 1)
                        "
                        class="connector-line-horizontal"
                        :class="{ 'light-mode': light }"
                    ></div>

                    <!-- Verticale Connector Line (onder) - alleen voor mobiel -->
                    <div
                        v-if="index < effectiveSteps.length - 1"
                        class="connector-line-vertical"
                        :class="{ 'light-mode': light }"
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

const { t } = useTranslations()

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

// Use translations for title, description and steps if not provided
const effectiveTitle = computed(() => props.title || t.harmonyJourneyTitle)
const effectiveDescription = computed(() => props.description || t.harmonyJourneyDescription)
const effectiveSteps = computed(() => props.steps || t.steps || [])
</script>

<style scoped>
/* ============================================
   Container - Base Layout
   ============================================ */

.journey-container {
    width: 100%;
    padding: 1.5rem 0.75rem;
}

@media (min-width: 640px) {
    .journey-container {
        padding: 2rem 1rem;
    }
}

@media (min-width: 768px) {
    .journey-container {
        padding: 2rem 1.5rem;
    }
}

@media (min-width: 1024px) {
    .journey-container {
        padding: 3rem 2rem;
    }
}

/* ============================================
   Top Section - Grid with Image & Text
   ============================================ */

.content-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
    align-items: center;
}

@media (min-width: 640px) {
    .content-grid {
        gap: 2rem;
        margin-bottom: 2.5rem;
    }
}

@media (min-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
    }
}

.image-section {
    display: flex;
    justify-content: center;
}

@media (max-width: 1024px) {
    .image-section {
        display: none;
    }
}

.journey-image {
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

.divider-line {
    height: 0.25rem;
    background-color: var(--primary);
    margin-bottom: 2rem;
    border-radius: 9999px;
    opacity: 0.5;
}

.divider-line.light-mode {
    opacity: 0.3;
}

@media (min-width: 640px) {
    .divider-line {
        margin-bottom: 2.5rem;
    }
}

@media (min-width: 1024px) {
    .divider-line {
        margin-bottom: 3rem;
    }
}

/* ============================================
   Steps Section - Cards Grid
   ============================================ */

.steps-section {
    width: 100%;
}

.steps-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    position: relative;
}

@media (min-width: 640px) {
    .steps-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
}

@media (min-width: 1024px) {
    .steps-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }
}

/* ============================================
   STEP CARD - Meer contrast en diepte
   ============================================ */

.step-card {
    position: relative;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 1rem;
    padding: 1.5rem 1rem;
    text-align: center;
    transition: all 0.3s ease;
    animation: fadeInUp 600ms ease-out forwards;
    opacity: 0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

/* Donkere modus */
.step-card.light-mode {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.step-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border-color: var(--primary);
}

.step-card.light-mode:hover {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
}

@media (min-width: 640px) {
    .step-card {
        padding: 1.5rem;
    }
}

@media (min-width: 1024px) {
    .step-card {
        padding: 2rem 1.5rem;
    }
}

/* ============================================
   Step Card - Number Circle (groter en opvallender)
   ============================================ */

.step-circle {
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

.step-card:hover .step-circle {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(234, 183, 81, 0.4);
}

@media (min-width: 640px) {
    .step-circle {
        width: 3.5rem;
        height: 3.5rem;
        font-size: 1.5rem;
        margin-bottom: 1.25rem;
    }
}

/* ============================================
   Step Card - Title (duidelijker)
   ============================================ */

.step-title {
    font-weight: 700;
    margin-bottom: 0.75rem;
    font-size: 1.125rem;
    color: #1a1a2e;
    letter-spacing: -0.01em;
}

@media (min-width: 640px) {
    .step-title {
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }
}

.step-title.light-text {
    color: var(--text-light);
}

/* ============================================
   Step Card - Description (beter leesbaar)
   ============================================ */

.step-description {
    font-size: 0.875rem;
    line-height: 1.6;
    color: #4a5568;
}

@media (min-width: 640px) {
    .step-description {
        font-size: 0.9375rem;
    }
}

.step-description.light-text {
    color: rgba(255, 255, 255, 0.8);
}

/* ============================================
   HORIZONTALE CONNECTOR LINE (rechts)
   ============================================ */

.connector-line-horizontal {
    display: none;
    position: absolute;
    top: 50%;
    right: -1.5rem;
    width: 1.5rem;
    height: 0.125rem;
    background-color: var(--primary);
    transform: translateY(-50%);
    opacity: 0.6;
}

.connector-line-horizontal.light-mode {
    opacity: 0.4;
    background-color: var(--primary-light);
}

/* Tablet en Desktop: toon horizontale connector */
@media (min-width: 640px) {
    .steps-grid:has(> :nth-child(2)) .step-card:nth-child(odd):not(:last-child) .connector-line-horizontal,
    .steps-grid:has(> :nth-child(4)) .step-card:nth-child(odd):not(:last-child) .connector-line-horizontal {
        display: block;
    }
}

/* Desktop (4 kolommen) */
@media (min-width: 1024px) {
    .step-card:not(:last-child) .connector-line-horizontal {
        display: block;
    }
}

/* ============================================
   VERTICALE CONNECTOR LINE (onder) - Mobiel
   ============================================ */

.connector-line-vertical {
    display: none;
    position: absolute;
    bottom: -1.3rem;
    left: 50%;
    width: 0.125rem;
    height: 0.75rem;
    background-color: var(--primary);
    transform: translateX(-50%);
    opacity: 0.6;
}

.connector-line-vertical.light-mode {
    opacity: 0.4;
    background-color: var(--primary-light);
}

/* Alleen op mobiel de verticale connectors tonen */
@media (max-width: 639px) {
    .step-card:not(:last-child) .connector-line-vertical {
        display: block;
    }
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
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* ============================================
   Responsive Design - Extra Adjustments
   ============================================ */

/* Tablet: 641px to 1024px */
@media (min-width: 641px) and (max-width: 1024px) {
    .steps-grid {
        margin-bottom: 1rem;
    }
}

/* Mobile: 640px and down */
@media (max-width: 640px) {
    .steps-grid {
        gap: 1.5rem;
    }
}
</style>
