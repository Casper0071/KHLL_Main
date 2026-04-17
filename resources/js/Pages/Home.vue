<template>
    <div class="bg-background temp">
        <HeaderHero
            v-if="windowWidth > 1030"
            :title="homeTranslations.title"
            :light="true"
            buttonText="Ontdek meer"
            buttonVariant="primary"
            :light-btn="true"
            imageSrc="/img/test.jpg"
        />
        <HeaderHeroBgImage
            v-else
            :title="homeTranslations.title"
            buttonText="Ontdek meer"
            buttonVariant="primary"
            :light-btn="true"
            imageSrc="/img/test.jpg"
            :overlay-opacity="0.5"
            minHeight="400px"
        />
        <div class="blob">
            <div class="OverOnsBlob ">
                <svg viewBox="0 0 1358 602" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" >
                    <path  d="M913 102.5C700.807 110.131 275.333 40.5 3.05176e-05 0L0 602C379.5 505 478 570 626 459.5C774 349 1244.83 500.917 1323.5 378C1387.5 278 1413.5 84.5 913 102.5Z" fill="#F4F7FB"/>
                </svg>
            </div>
            <div class="content">
                <BaseTitle
                    :title="homeTranslations.OverOns"
                    :infoText="homeTranslations.OverOnsText"
                    :enableText="true"
                    align="left"
                />
            </div>
        </div>

        <div class="agenda">
            <AgendaHome
                :light="true"
                image="/img/test.jpg"
                :title="homeTranslations.Agenda"
            />
        </div>

        <div class="my-10"></div>
        <div class="blob">
            <div class="WieZijnWijBlob">
                <svg width="1395" height="893" viewBox="0 0 1395 893" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M775.481 0C1008.48 0.000201226 1261.98 52 1394.48 112V614C1394.48 614 1385.25 641.5 1281.48 768C1107.98 979.5 382.815 864.79 242.981 834.5C-64.0194 768 -3.51932 530 23.4806 417C84.136 163.146 516.32 -0.000223818 775.481 0Z" fill="#F4F7FB"/>
                </svg>
            </div>
            <div class="blobMobileWieZijnWij"></div>

            <div class="content">
                <div>
                    <HarmonyJourney
                        :light="false"
                        image-src="/img/test.jpg"
                        :title="homeTranslations.WieZijnWij"
                        :description="homeTranslations.WieZijnWijText"
                    />
                </div>

            </div>
        </div>
        <div class="my-20"></div>

        <div class="ontdekDePassie">
            <TitleImageGallery
                :light="true"
                :title="homeTranslations.PassieVoorMuziek"
                :description="homeTranslations.PassieVoorMuziekText"
                imageSrc="/img/test.jpg"
                :images="[
                    { id: 1, src: '/img/test.jpg', alt: 'Afbeelding 1' },
                    { id: 2, src: '/img/test.jpg', alt: 'Afbeelding 2' },
                    { id: 3, src: '/img/test.jpg', alt: 'Afbeelding 3' },
                ]"

            />

        </div>


    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import homeNL from '@/../../resources/lang/nl/home.json'
import HeaderHero from "@/Components/headers/HeaderHero.vue"
import HeaderHeroBgImage from "@/Components/headers/HeaderHero_bg_image.vue"
import BaseTitle from "@/Components/BaseTitle.vue";
import AgendaHome from "@/Components/widgets/AgendaHome.vue";
import HarmonyJourney from "@/Components/widgets/HarmonyJourney.vue";
import TitleImageGallery from "@/Components/widgets/TitleImageGallery.vue";


defineOptions({
    layout: MainLayout
})

// For now using Dutch locale, can be extended with locale switching
const homeTranslations = ref(homeNL)
const windowWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1024)

// Handle window resize
const handleResize = () => {
    windowWidth.value = window.innerWidth
}

onMounted(() => {
    window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
})

</script>

<style scoped>
/* ============================================
   Layout Components - Sections
   ============================================ */

.agenda {
    @apply w-screen flex justify-center;
}

.agenda div {
    @apply w-[80vw];
}

.ontdekDePassie {
    @apply w-screen flex justify-center;
}

.ontdekDePassie div {
    @apply w-[80vw];
}

/* ============================================
   Blob Layout - Base Styles
   ============================================ */

.blob {
    @apply w-screen relative flex items-center;
}

.content {
    @apply relative w-[80vw] ml-[10vw] mr-[10vw] flex items-center z-10;
}

/* ============================================
   Blob SVG Containers
   ============================================ */

.OverOnsBlob {
    @apply absolute overflow-hidden left-0;
    width: 90%;
    min-height: 400px;
    top: 55%;
    transform: translateY(-50%);
}

.OverOnsBlob svg {
    @apply absolute w-full h-full;
}

.WieZijnWijBlob {
    @apply absolute overflow-hidden right-0;
    width: 90%;
}

.blobMobileWieZijnWij {
    @apply absolute hidden w-screen h-full;
    background: #F4F7FB;
    margin-bottom: -40px;
    clip-path: shape(from 0 25px, curve to 30% 19px with 20% 12px, curve to 50% 18px with 40% 26px, curve to 70% 12px with 60% 10px, curve to 100% 25px with 80% 14px, vline to calc(100% - 25px), curve to 70% calc(100% - 22px) with 80% calc(100% - 3px), curve to 50% calc(100% - 39.5px) with 60% calc(100% - 41px), curve to 30% calc(100% - 27.5px) with 40% calc(100% - 38px), curve to 0 calc(100% - 25px) with 20% calc(100% - 17px), vline to 0);
}

/* ============================================
   Responsive Design
   ============================================ */

/* Tablet: 1025px and down */
@media (max-width: 1024px) {
    .OverOnsBlob {
        @apply w-[95%];
        min-height: 430px;
    }

    .WieZijnWijBlob {
        @apply w-[115%];
    }
}

/* Tablet: 769px to 1024px */
@media (max-width: 768px) {
    .OverOnsBlob {
        @apply w-full;
        min-height: 500px;
    }

    .WieZijnWijBlob {
        @apply w-[150%];
    }

    .content {
        @apply w-[80vw] ml-[10vw] mr-[10vw];
    }
}

/* Mobile: 640px to 768px */
@media (max-width: 640px) {
    .WieZijnWijBlob {
        @apply hidden;
    }

    .blobMobileWieZijnWij {
        @apply block;
    }
}

/* Small Mobile: 530px and down */
@media (max-width: 530px) {
    .OverOnsBlob {
        min-height: 550px;
    }

    .content {
        @apply w-[80vw] ml-[10vw] mr-[10vw];
    }
}
</style>
