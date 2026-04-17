<template>
    <section class="w-full py-16">
        <div class="mx-auto w-[80%] flex flex-col lg:flex-row items-center gap-12 min-h-[400px]">

            <!-- LEFT: HeaderTitle -->
            <div class="w-full lg:w-1/2">
                <HeaderTitle
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
                <div class="blob"><img
                    class="hero-img"
                    :src="imageSrc"
                    alt="Hero image"
                ></div>

                <!-- Image -->

            </div>

        </div>
    </section>
</template>

<script setup>
import { defineProps } from 'vue'
import HeaderTitle from "@/Components/HeaderTitle.vue";

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

/* Blob shape */
.blob {
    position: relative;
    width: 450px;
    height:450px;
    overflow: hidden;
    aspect-ratio: 1;
    clip-path: shape(from 82.77% 84.50%,curve to 66.87% 92.10% with 76.26% 91.38%,curve to 48.54% 94.68% with 57.47% 92.82%,curve to 30.64% 93.42% with 39.60% 96.54%,curve to 17.71% 81.66% with 21.68% 90.30%,curve to 10.01% 65.32% with 13.74% 73.01%,curve to 4.86% 48.61% with 6.28% 57.63%,curve to 7.07% 30.98% with 3.45% 39.59%,curve to 18.78% 17.96% with 10.70% 22.38%,curve to 34.76% 10.73% with 26.86% 13.54%,curve to 51.68% 5.03% with 42.65% 7.91%,curve to 69.60% 5.80% with 60.70% 2.15%,curve to 85.05% 16.52% with 78.51% 9.44%,curve to 91.81% 33.13% with 91.60% 23.60%,curve to 94.65% 51.61% with 92.03% 42.66%,curve to 93.27% 69.09% with 97.26% 60.56%,curve to 82.77% 84.50% with 89.28% 77.61%);
    z-index: 1;
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
