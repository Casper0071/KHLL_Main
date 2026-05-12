<template>
    <div class="bg-background homePage">
       <div class="backgroundMusicNotes">
           <svg width="1440" height="3584" viewBox="0 0 1440 3584" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M381.466 0.17041C462.133 222.67 766.066 673.67 1336.47 697.67C2049.47 727.67 768.966 1630.67 466.966 1768.67C164.966 1906.67 -1358.03 2634.17 1160.97 3238.67C3176.17 3722.27 2197.3 3592.17 1455.97 3466.67" stroke="white"/>
           </svg>
       </div>

        <HeaderHero
            v-if="windowWidth > 1030"
            :title="t.title"
            :light="true"
            buttonText="Ontdek meer"
            buttonVariant="primary"
            :light-btn="true"
            imageSrc="/img/test.jpg"
        />
        <HeaderHeroBgImage
            v-else
            :title="t.title"
            buttonText="Ontdek meer"
            buttonVariant="primary"
            :light-btn="true"
            imageSrc="/img/test.jpg"
            :overlay-opacity="0.5"
            minHeight="400px"
        />
        <div class="blob">
            <div class="OverOnsBlob ">
                <svg v-if="windowWidth <= 370" width="1442" height="1894" viewBox="0 0 1442 1894" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M657.5 121C311.9 128.2 70.5 63.6667 0 0V1893.5C63 1849.5 222.061 1795.42 350.5 1746C567.5 1662.5 1214 1764 1441.5 1696V135C1319.5 103.667 1003.1 113.8 657.5 121Z" fill="#F4F7FB"/>
                </svg>
                <svg v-else-if="windowWidth <= 430" width="1442" height="1556" viewBox="0 0 1442 1556" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M657.5 121C311.9 128.2 70.5 63.6667 0 0V1555.5C63 1511.5 222.061 1457.42 350.5 1408C567.5 1324.5 1214 1524.5 1441.5 1456.5V135C1319.5 103.667 1003.1 113.8 657.5 121Z" fill="#F4F7FB"/>
                </svg>

                <svg v-else-if="windowWidth <= 500" width="1442" height="1256" viewBox="0 0 1442 1256" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M657.5 121C311.9 128.2 70.5 63.6667 0 0V1255.5C63 1211.5 222.061 1157.42 350.5 1108C567.5 1024.5 1214 1224.5 1441.5 1156.5V135C1319.5 103.667 1003.1 113.8 657.5 121Z" fill="#F4F7FB"/>
                </svg>
                <svg v-else-if="windowWidth <= 600" width="1443" height="1109" viewBox="0 0 1443 1109" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M658 122.125C312.4 129.325 71 64.7922 0.5 1.12549V1107.63C63.5 1063.63 222.561 1009.55 351 960.125C568 876.625 1214.5 1076.63 1442 1008.63V136.125C1320 104.792 1003.6 114.925 658 122.125Z" fill="#F4F7FB"/>
                </svg>


                <svg v-else viewBox="0 0 1358 602" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" >
                    <path  d="M913 102.5C700.807 110.131 275.333 40.5 3.05176e-05 0L0 602C379.5 505 478 570 626 459.5C774 349 1244.83 500.917 1323.5 378C1387.5 278 1413.5 84.5 913 102.5Z" fill="#F4F7FB"/>
                </svg>
            </div>
            <div class="content content1">
                <BaseTitle
                    :title="t.about_heading"
                    :infoText="t.about_text"
                    :enableText="true"
                    align="left"
                />
            </div>
        </div>

        <div class="agenda">
            <AgendaHome
                :light="true"
                image="/img/test.jpg"
                :title="t.agenda"
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
                        :title="t.who_are_we_heading"
                        :description="t.who_are_we_text"
                        :steps="t.steps"
                    />
                </div>

            </div>
        </div>
        <div class="my-20"></div>

        <div class="ontdekDePassie">
            <TitleImageGallery
                :light="true"
                :title="t.passion_heading"
                :description="t.passion_text"
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
import { ref, onMounted, onUnmounted, computed } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { useTranslations } from '@/composables/useTranslations'

import HeaderHero from "@/Components/headers/HeaderHero.vue"
import HeaderHeroBgImage from "@/Components/headers/HeaderHero_bg_image.vue"
import BaseTitle from "@/Components/BaseTitle.vue";
import AgendaHome from "@/Components/widgets/AgendaHome.vue";
import HarmonyJourney from "@/Components/widgets/HarmonyJourney.vue";
import TitleImageGallery from "@/Components/widgets/TitleImageGallery.vue";

defineOptions({
    layout: MainLayout
})

// Use translations composable
const { t } = useTranslations()

// Create computed reference to translations for reactivity

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
.homePage {
    position: relative;
    isolation: isolate;
    overflow: hidden;
}

.backgroundMusicNotes {
    position: absolute;
    width: 100vw;
    overflow: hidden;
}
.backgroundMusicNotes svg{
 scale: 1.11;
}

.agenda {
    @apply w-screen flex justify-center;
}

.agenda div {
    @apply w-[90vw];
}

.ontdekDePassie {
    @apply w-screen flex justify-center;
}

.ontdekDePassie div {
    @apply w-[90vw];
}

/* ============================================
   Blob Layout - Base Styles
   ============================================ */

.blob {
    @apply w-screen relative flex items-center;
    filter:
        drop-shadow(0px 18px 42px rgba(0, 0, 0, 0.55))
        drop-shadow(0px 8px 18px rgba(0, 0, 0, 0.35))
        drop-shadow(0px 0px 1px rgba(255, 255, 255, 0.10));
}

.content {
    @apply relative w-[90vw] ml-[5vw] mr-[5vw] flex items-center z-10;
}
.content1{
    width: 85vw;
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
        @apply w-[90vw] ml-[5vw] mr-[5vw];
    }
}

/* Mobile: 600px and down - centered content */
@media (max-width: 600px) {
    .content {
        @apply text-center;
        width: 90vw;
    }


    .agenda div {
        @apply text-center;
    }

    .ontdekDePassie div {
        @apply text-center;
    }
}
</style>
