<template>
    <div class="bg-background">
        <HeaderHeroBgImage
            :title="t.opleidingsOrkest.title"
            imageSrc="/img/LOL/header.jpg"
            :enableButton="false"
            :overlay-opacity="0.5"
            minHeight="400px"
        />
        <div class="spacer1"></div>

            <div class="blob">
                <div class="blob1 ">
                    <svg v-if="windowWidth <= 400" width="1442" height="2634" viewBox="0 0 1442 2634" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M493.5 22.528C266.5 53.5268 135.667 -14.6389 0 53.5277V2553.03C0 2581.69 40.9 2630.13 204.5 2594.53C409 2550.03 597 2546.53 896.5 2594.53C1136.1 2632.93 1359.67 2657.53 1441.5 2594.53V53.5281C1441.5 53.5281 1284 93.5253 1106 53.5281C883.128 3.44792 811.772 -20.9347 493.5 22.528Z" fill="var(--surface)"/>
                    </svg>

                    <svg v-else-if="windowWidth <= 500" width="1442" height="1999" viewBox="0 0 1442 1999" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M493.5 22.528C266.5 53.5268 135.667 -14.6389 0 53.5277V1918.03C0 1946.69 40.9 1995.13 204.5 1959.53C409 1915.03 597 1911.53 896.5 1959.53C1136.1 1997.93 1359.67 2022.53 1441.5 1959.53V53.5281C1441.5 53.5281 1284 93.5253 1106 53.5281C883.128 3.44792 811.772 -20.9347 493.5 22.528Z" fill="var(--surface)"/>
                    </svg>

                    <svg v-else-if="windowWidth <= 700" width="1442" height="1500" viewBox="0 0 1442 1500" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M493.5 22.528C266.5 53.5268 135.667 -14.6389 0 53.5277V1419.03C0 1447.69 40.9 1496.13 204.5 1460.53C409 1416.03 597 1412.53 896.5 1460.53C1136.1 1498.93 1359.67 1523.53 1441.5 1460.53V53.5281C1441.5 53.5281 1284 93.5253 1106 53.5281C883.128 3.44792 811.772 -20.9347 493.5 22.528Z" fill="var(--surface)"/>
                    </svg>

                    <svg v-else-if="windowWidth <= 850" width="1442" height="1285" viewBox="0 0 1442 1285" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M487 37.8838C270.61 98.0109 135.667 22.217 0 90.3836V1204.38C0 1233.05 40.9 1281.48 204.5 1245.88C409 1201.38 597 1197.88 896.5 1245.88C1136.1 1284.28 1359.67 1308.88 1441.5 1245.88V82.3837C1436.5 82.8837 1274 122.381 1096 82.3837C873.128 32.3036 796.5 -48.1153 487 37.8838Z" fill="var(--surface)"/>
                    </svg>

                    <svg v-else-if="windowWidth <= 1000" width="1274" height="785" viewBox="0 0 1274 785" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M530 22.0063C323.2 52.0063 92.5 56.0063 -0.5 84.5063V757.506C207.135 851.473 444.5 664.039 776 686.006C1041.5 703.6 1309.5 419.006 1270 185.006C1233.85 -29.1472 788.5 -15.4937 530 22.0063Z" fill="var(--surface)"/>
                    </svg>
                    <svg v-else width="1274" height="594" viewBox="0 0 1274 594" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M530 22.0063C323.2 52.0063 92.5 56.0063 -0.5 84.5063V560.507C207.135 654.473 453.5 514.04 785 536.007C1050.5 553.6 1309.5 419.006 1270 185.006C1233.85 -29.1472 788.5 -15.4937 530 22.0063Z" fill="var(--surface)"/>
                    </svg>
                </div>
                <div class="content content1">
                    <TitleImageSplit
                        :title="t.opleidingsOrkest.heading1"
                        imageSrc="/img/LOL/img1.jpg"
                        image-alt=""
                        :infoText="t.opleidingsOrkest.text1"
                    />
                </div>
            </div>
        <div class="center">
            <div class="content2">
                <BaseTitle
                    :title="t.opleidingsOrkest.heading2"
                    :infoText="t.opleidingsOrkest.text2"
                    :enableText="true"
                    :light="true"
                    align="right"
                />
            </div>

        </div>

            <div class="center">
                <ThreeBlobsSection
                    :items="[
                    { id: 1, title: t.opleidingsOrkest.blob1_title, text: t.opleidingsOrkest.blob1_text },
                    { id: 2, title: t.opleidingsOrkest.blob2_title, text: t.opleidingsOrkest.blob2_text },
                    { id: 3, title: t.opleidingsOrkest.blob3_title, text: t.opleidingsOrkest.blob3_text }
                ]"
                />
            </div>

            <div class="blob">
                <div class="blob2">
                    <svg v-if="windowWidth <= 360" width="1437" height="2884" viewBox="0 0 1437 2884" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M701 1.39167C875 -10.2083 1264.17 53.5583 1437 86.8917V2883.78C1237.5 2814.28 1176 2669.79 966 2513.79C513.099 2177.34 365.5 2381.79 0 2110.79V48.3916C161.167 37.5583 527 12.9917 701 1.39167Z" fill="var(--surface)"/>
                    </svg>

                    <svg v-else-if="windowWidth <= 425" width="1437" height="2584" viewBox="0 0 1437 2584" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M701 1.3916C875 -10.2084 1264.17 53.5583 1437 86.8916V2583.78C1237.5 2514.28 1176 2369.79 966 2213.79C513.099 1877.35 365.5 2081.79 0 1810.79V48.3915C161.167 37.5582 527 12.9916 701 1.3916Z" fill="var(--surface)"/>
                    </svg>

                    <svg v-else-if="windowWidth <= 475" width="1437" height="2247" viewBox="0 0 1437 2247" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M701 1.39167C875 -10.2083 1264.17 53.5583 1437 86.8917V2246.78C1237.5 2177.28 1176 2032.79 966 1876.79C513.099 1540.35 365.5 1744.78 0 1473.78V48.3916C161.167 37.5583 527 12.9917 701 1.39167Z" fill="var(--surface)"/>
                    </svg>

                    <svg v-else-if="windowWidth <= 530" width="1437" height="1840" viewBox="0 0 1437 1840" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M701 1.39167C875 -10.2083 1264.17 53.5583 1437 86.8917V1839.89C1237.5 1770.39 1176 1625.89 966 1469.89C513.099 1133.45 365.5 1337.89 0 1066.89V48.3916C161.167 37.5583 527 12.9917 701 1.39167Z" fill="var(--surface)"/>
                    </svg>

                    <svg v-else-if="windowWidth <= 600" width="1437" height="1667" viewBox="0 0 1437 1667" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M701 1.39167C875 -10.2083 1264.17 53.5583 1437 86.8917V1666.89C1237.5 1597.39 1176 1452.89 966 1296.89C513.099 960.451 365.5 1164.89 0 893.888V48.3916C161.167 37.5583 527 12.9917 701 1.39167Z" fill="var(--surface)"/>
                    </svg>
                    <svg  v-else-if="windowWidth <= 850" width="1437" height="1433" viewBox="0 0 1437 1433" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M701 1.39167C875 -10.2083 1264.17 53.5583 1437 86.8917V1432.39C1237.5 1362.89 1176 1218.39 966 1062.39C513.099 725.951 365.5 930.389 0 659.389V48.3916C161.167 37.5583 527 12.9917 701 1.39167Z" fill="var(--surface)"/>
                    </svg>

                    <svg v-else width="1379" height="1141" viewBox="0 0 1379 1141" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1043.09 86.4999C1248.79 104.824 1331.09 185 1379.09 213V1140C1258.59 1130.5 532.592 665 276.592 647.5C20.5923 630 -74.2825 271.878 64.0924 143C217.092 0.500528 349.592 0.50027 488.091 0.5H488.093C596.093 0.49979 875.592 71.5783 1043.09 86.4999Z" fill="var(--surface)" stroke="black"/>
                    </svg>

                </div>

                <div class="content content3">
                    <BaseTitle
                        :title="t.opleidingsOrkest.heading3"
                        :infoText="t.opleidingsOrkest.text3"
                        :enableText="true"
                        align="right"
                    />
                    <Carousel
                        title=""
                        :images="[
                            { id: 1, src: '/img/LOL/carousel1.jpg', alt: 'Carousel Image 1' },
                            { id: 2, src: '/img/LOL/carousel2.jpeg', alt: 'Carousel Image 2' },
                            { id: 3, src: '/img/LOL/carousel3.jpeg', alt: 'Carousel Image 3' },
                            { id: 4, src: '/img/LOL/carousel4.jpeg', alt: 'Carousel Image 3' },
                            { id: 5, src: '/img/LOL/carousel5.jpg', alt: 'Carousel Image 3' }
                        ]"
                    />
                </div>

            </div>


        </div>



</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { useTranslations } from '@/composables/useTranslations'
import HeaderHeroBgImage from "@/Components/headers/HeaderHero_bg_image.vue";
import BaseTitle from "@/Components/Base/BaseTitle.vue";
import TitleImageSplit from "@/Components/widgets/TitleImageSplit.vue";
import Carousel from "@/Components/widgets/Carousel.vue";
import ThreeBlobsSection from "@/Components/widgets/ThreeBlobsSection.vue";

defineOptions({
    layout: MainLayout
})

const { t } = useTranslations()

const windowWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1024)

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


.blob {
  width: 100%;
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: 1fr;

  padding: clamp(3rem, 8vw, 6rem) clamp(1rem, 3vw, 2rem) clamp(3rem, 8vw, 6rem) 0;
  min-height: clamp(400px, 60vh, 700px);

  position: relative;
  filter:
    drop-shadow(0px 18px 42px rgba(0, 0, 0, 0.55))
    drop-shadow(0px 8px 18px rgba(0, 0, 0, 0.35))
    drop-shadow(0px 0px 1px rgba(255, 255, 255, 0.10));
}

.blob1 {
  grid-column: 1;
  grid-row: 1;

  width: 110%;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  margin-left: -10vw;
  overflow: visible;
}
.blob2 {
    grid-column: 1;
    grid-row: 1;
    scale: 1.1;

    width: 110%;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    overflow: visible;
}
.blob1 svg {
  /* Responsive SVG sizing with viewBox preservation */
  width: 100%;
  height: auto;

  /* Maintain aspect ratio from viewBox */
  aspect-ratio: 1274 / 594;

  /* Prevent distortion */

  /* Fluid scaling between min and max */
  max-width: 100%;

  /* Position to left */
  position: relative;
  left: 0;
  top: 0;
  transform: none;
}
.blob2 svg {
    /* Responsive SVG sizing with viewBox preservation */
    height: auto;

    /* Maintain aspect ratio from viewBox */

    /* Prevent distortion */

    /* Fluid scaling between min and max */
    max-width: 100%;

    /* Position to right */
    position: relative;
    right: 0;
    top: 0;
    transform: none;
}

/* ============================================================
   CONTENT - Overlay on blob with proper z-index
   ============================================================ */
.content {
  /* Grid positioning for layering above blob */
  grid-column: 1;
  grid-row: 1;

  /* Flexbox for content alignment */
  display: flex;
  align-items: center;
  justify-content: center;

  /* Responsive padding */

  /* Ensure content is above blob */
  z-index: 10;

  /* Responsive width */
  width: clamp(300px, 100vw, 100%);

  /* Position context */
  position: relative;
  margin: 0 auto;
}

.content1 {
  /* Slightly constrained width for better readability */
  width: clamp(300px, 100vw, 80%);
}
.content3{
    width: clamp(300px, 100vw, 80%);
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.center{
    display: flex;
    justify-content: center;
}
.content2{
    width: clamp(300px, 100vw, 80%);
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

/* ============================================================
   RESPONSIVE ADJUSTMENTS - Tablet and up
   ============================================================ */


  .blob1 {
    scale: clamp(0.9, 100vw / 1274, 1.1);
  }

  .blob1 svg {
    max-width: 90vw;
  }


/* ============================================================
   RESPONSIVE ADJUSTMENTS - Desktop
   ============================================================ */


  .blob1 svg {
    max-width: 1274px;
  }


    @media (max-width: 1200px) {
        .content1 {
            width: 90%;
        }
    }
    @media (max-width: 1100px) {
        .content1 {
            width: 95%;
        }
        .content2{
            width: 90%;
        }
        .content3{
            width: 90%;
        }
    }
    @media (max-width: 1000px) {
        .blob1 {
            scale: 1.3;
        }
        .blob2{
            scale: 1.2;
        }
    }
    @media (max-width: 850px) {
        .blob1 {
            scale: 2.1;
        }
        .content1 {
            width: 90%;
            margin-top: 50px;
        }

    }
@media (max-width: 700px) {
    .blob1 {
        scale: 2.4;
    }
    .content1 {
        width: 90%;
        margin-top: 100px;
    }
}
@media (max-width: 500px) {
    .blob1 {
        scale: 3.2;
    }
    .content1 {
        margin-top: 100px;
    }
}
@media (max-width: 400px) {
    .blob1 {
        scale: 4.3;
    }
    .content1 {
        width: 90%;
        margin-top: 140px;
    }
}


</style>
