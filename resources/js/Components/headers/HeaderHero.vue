<template>
    <section class="w-full py-16">
        <div class="mx-auto w-[80%] flex flex-col lg:flex-row items-center gap-12 min-h-[400px]">

            <!-- LEFT: BaseHeaderTitle -->
            <div class="w-full lg:w-1/2">
                <BaseHeaderTitle
                    :title="title"
                    :light="light"
                    :align="'left'"
                    :button-text="buttonText"
                    :button-variant="buttonVariant"
                    :button-disabled="buttonDisabled"
                    :light-btn="lightBtn"
                />
            </div>

            <!-- RIGHT: Blob + Image -->
            <div class="w-full lg:w-1/2 flex justify-center relative">

                <!-- Blob -->
                <div class="blob-shadow">
                    <div class="blob">
                        <img
                            class="hero-img"
                            :src="imageSrc"
                            alt="Hero image"
                        >
                    </div>
                </div>

                <!-- Image -->

            </div>

        </div>
    </section>
</template>

<script setup>
import { defineProps } from 'vue'
import BaseHeaderTitle from "@/Components/Base/BaseHeaderTitle.vue";

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
    }
})
</script>

<style scoped>

/* Shadow wrapper (works with clip-path) */
.blob-shadow {
    filter:
        drop-shadow(0px 18px 42px rgba(0, 0, 0, 0.55))
        drop-shadow(0px 8px 18px rgba(0, 0, 0, 0.35))
        drop-shadow(0px 0px 1px rgba(255, 255, 255, 0.10));
}

/* Blob shape */
.blob {
    position: relative;
    width: 450px;
    height:450px;
    overflow: hidden;
    aspect-ratio: 1;
    z-index: 1;
    animation: blob-morph 20s ease-in-out infinite;
    will-change: clip-path;
}

@keyframes blob-morph {
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

@media (prefers-reduced-motion: reduce) {
    .blob {
        animation: none;
    }
}

/* Image boven blob */
.hero-img {
    position: relative;
    width: 450px;
    height: 450px;
    object-fit: cover;
    z-index: 2;
}

</style>
