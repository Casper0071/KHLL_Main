<!-- Components/headers/HeaderHero.vue -->
<template>
    <section v-intersect="'animate'" class="header-hero">
        <div class="header-hero__container">
            <!-- LEFT: BaseHeaderTitle -->
            <div class="header-hero__content">
                <BaseHeaderTitle
                    :title="title"
                    :light="light"
                    :align="'left'"
                    :button-text="buttonText"
                    :button-variant="buttonVariant"
                    :button-disabled="buttonDisabled"
                    :light-btn="lightBtn"
                    :link="link"
                    rounded="lg"
                />
            </div>

            <!-- RIGHT: Blob + Image -->
            <div class="header-hero__media">
                <div class="header-hero__blob-wrapper">
                    <div class="header-hero__blob">
                        <img
                            class="header-hero__image"
                            :src="imageSrc"
                            :alt="title"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import BaseHeaderTitle from "@/Components/Base/BaseHeaderTitle.vue"

// ============================================
// Props (volledig intact gelaten)
// ============================================

const props = defineProps({
    title: {
        type: String,
        default: 'Header'
    },
    light: {
        type: Boolean,
        default: false
    },
    buttonText: {
        type: String,
        default: 'Klik mij'
    },
    buttonVariant: {
        type: String,
        default: 'primary'
    },
    buttonDisabled: {
        type: Boolean,
        default: false
    },
    lightBtn: {
        type: Boolean,
        default: false
    },
    imageSrc: {
        type: String,
        default: ''
    },
    link: {
        type: String,
        default: '#'
    },
    rounded: {
        type: String,
        default: 'md'
    }
})
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.header-hero {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.header-hero.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   HEADER HERO SECTION
   ============================================ */

.header-hero {
    width: 100%;
    padding: 4rem 0;
}

.header-hero__container {
    max-width: 1280px;
    margin: 0 auto;
    width: 80%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3rem;
    min-height: 400px;
}

/* ============================================
   CONTENT SECTION (Left)
   ============================================ */

.header-hero__content {
    width: 100%;
}

/* ============================================
   MEDIA SECTION (Right - Blob + Image)
   ============================================ */

.header-hero__media {
    width: 100%;
    display: flex;
    justify-content: center;
    position: relative;
}

/* Shadow wrapper */
.header-hero__blob-wrapper {
    filter: drop-shadow(0px 18px 42px rgba(0, 0, 0, 0.55))
    drop-shadow(0px 8px 18px rgba(0, 0, 0, 0.35))
    drop-shadow(0px 0px 1px rgba(255, 255, 255, 0.1));
}

/* Blob shape */
.header-hero__blob {
    position: relative;
    width: 450px;
    height: 450px;
    overflow: hidden;
    aspect-ratio: 1;
    z-index: 1;
    animation: header-hero-blob-morph 20s ease-in-out infinite;
    will-change: clip-path;
}

/* Image inside blob */
.header-hero__image {
    position: relative;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 2;
}

/* ============================================
   BLOB MORPH ANIMATION
   ============================================ */

@keyframes header-hero-blob-morph {
    0%,
    100% {
        clip-path: shape(from 86.82% 59.81%,curve to 79.96% 78.78% with 84.29% 68.85%,curve to 65.23% 93.05% with 75.63% 88.71%,curve to 45.08% 91.96% with 54.83% 97.38%,curve to 25.82% 82.63% with 35.33% 86.54%,curve to 11.62% 69.22% with 16.30% 78.71%,curve to 5.16% 48.64% with 6.93% 59.74%,curve to 10.48% 28.84% with 3.38% 37.55%,curve to 25.52% 11.92% with 17.58% 20.14%,curve to 44.48% 7.37% with 33.46% 3.70%,curve to 66.41% 11.52% with 55.50% 11.04%,curve to 83.22% 21.21% with 77.33% 12.00%,curve to 89.23% 40.59% with 89.12% 30.43%,curve to 86.82% 59.81% with 89.35% 50.76%);
    }
    33% {
        clip-path: shape(from 90.25% 60.66%,curve to 80.94% 78.84% with 87.26% 70.48%,curve to 64.54% 90.44% with 74.63% 87.20%,curve to 44.13% 92.01% with 54.45% 93.69%,curve to 27.42% 82.50% with 33.81% 90.32%,curve to 13.27% 67.37% with 21.02% 74.69%,curve to 5.35% 49.04% with 5.51% 60.06%,curve to 10.57% 28.34% with 5.19% 38.03%,curve to 25.90% 14.52% with 15.96% 18.64%,curve to 46.17% 7.21% with 35.85% 10.40%,curve to 67.73% 6.87% with 56.49% 4.01%,curve to 84.31% 19.94% with 78.97% 9.72%,curve to 91.45% 40.50% with 89.65% 30.16%,curve to 90.25% 60.66% with 93.25% 50.84%);
    }
    66% {
        clip-path: shape(from 92.70% 60.87%,curve to 80.67% 78.13% with 87.88% 70.83%,curve to 63.87% 88.79% with 73.46% 85.43%,curve to 45.20% 88.38% with 54.29% 92.16%,curve to 26.68% 81.25% with 36.10% 84.61%,curve to 10.54% 69.17% with 17.25% 77.90%,curve to 7.52% 50.04% with 3.82% 60.44%,curve to 12.80% 28.42% with 11.23% 39.64%,curve to 24.04% 10.77% with 14.38% 17.20%,curve to 45.32% 2.51% with 33.69% 4.35%,curve to 65.00% 9.31% with 56.96% 0.67%,curve to 81.72% 23.87% with 73.05% 17.95%,curve to 93.95% 40.35% with 90.39% 29.79%,curve to 92.70% 60.87% with 97.51% 50.92%);
    }
}

/* Reduced motion preference */
@media (prefers-reduced-motion: reduce) {
    .header-hero__blob {
        animation: none;
    }
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Tablet (641px - 1024px) */
@media (min-width: 641px) and (max-width: 1024px) {
    .header-hero__blob {
        width: 350px;
        height: 350px;
    }
}

/* Desktop (min 1025px) - 2 kolommen layout */
@media (min-width: 1025px) {
    .header-hero__container {
        flex-direction: row;
        gap: 3rem;
    }

    .header-hero__content {
        width: 50%;
    }

    .header-hero__media {
        width: 50%;
    }

    .header-hero__blob {
        width: 450px;
        height: 450px;
    }
}

/* Mobile (max 640px) */
@media (max-width: 640px) {
    .header-hero {
        padding: 2rem 0;
    }

    .header-hero__container {
        width: 90%;
        gap: 2rem;
        min-height: auto;
    }

    .header-hero__blob {
        width: 280px;
        height: 280px;
    }
}

/* Extra kleine schermen (max 480px) */
@media (max-width: 480px) {
    .header-hero {
        padding: 1.5rem 0;
    }

    .header-hero__container {
        width: 95%;
        gap: 1.5rem;
    }

    .header-hero__blob {
        width: 240px;
        height: 240px;
    }
}
</style>
