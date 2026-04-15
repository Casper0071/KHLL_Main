<template>
    <div class="bg-background temp">
        <HeaderHero
            :title="homeTranslations.title"
            :light="true"
            buttonText="Ontdek meer"
            buttonVariant="primary"
            :light-btn="true"
            imageSrc="/img/test.jpg"
        />
        <div class="overOns">


            <div class="blob-svg">
                <svg viewBox="0 0 1358 602" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M913 102.5C700.807 110.131 275.333 40.5 3.05176e-05 0L0 602C379.5 505 478 570 626 459.5C774 349 1244.83 500.917 1323.5 378C1387.5 278 1413.5 84.5 913 102.5Z" fill="#F4F7FB"/>
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
    </div>
</template>

<script setup>
import { ref } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import homeNL from '@/../../resources/lang/nl/home.json'
import HeaderHero from "@/Components/headers/HeaderHero.vue"
import BaseTitle from "@/Components/BaseTitle.vue";


defineOptions({
    layout: MainLayout
})

// For now using Dutch locale, can be extended with locale switching
const homeTranslations = ref(homeNL)

</script>

<style scoped>
.temp{
    min-height: 2000px;
}
.overOns{
    width: 100vw;
    position: relative;
    min-height: 600px;
    display: flex;
    align-items: center;
}

.blob-svg {
    position: absolute;
    width: 90%;
    min-height: 400px;
    overflow: hidden;
    left: 0;
    top: 55%;
    transform: translateY(-50%);
}

.blob-svg svg {
    position: absolute;
    width: 100%;
    height: 100%;
}

.content {
    position: relative;
    width: 80vw;
    z-index: 1;
    margin-left: 10vw;
    margin-right: 10vw;
    display: flex;
    align-items: center;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .blob-svg {
        width: 95%;
        min-height: 430px;
    }
}

@media (max-width: 768px) {
    .overOns {
        min-height: 500px;
    }

    .blob-svg {
        width: 100%;
        min-height: 500px;
    }

    .content {
        width: 80vw;
        margin-left: 10vw;
        margin-right: 10vw;
    }
}

@media (max-width: 530px) {
    .overOns {
        min-height: 400px;
    }

    .blob-svg {
        width: 100%;
        min-height: 650px;
    }

    .content {
        width: 80vw;
        margin-left: 10vw;
        margin-right: 10vw;
    }
}
</style>
