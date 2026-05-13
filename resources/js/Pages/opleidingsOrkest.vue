<template>
    <div class="bg-background">
        <HeaderHeroBgImage
            :title="t.opleidingsOrkest.title"
            imageSrc="/img/test.jpg"
            :enableButton="false"
            :overlay-opacity="0.5"
            minHeight="400px"
        />
        <div class="content">

            <TitleImageSplit
                :title="t.opleidingsOrkest.heading1"
                imageSrc="/img/test.jpg"
                image-alt=""
                :infoText="t.opleidingsOrkest.text1"
            />
            <BaseTitle
                :title="t.opleidingsOrkest.heading2"
                :infoText="t.opleidingsOrkest.text2"
                :enableText="true"
                :light="true"
                align="right"
            />
            <ThreeBlobsSection
                :items="[
                    { id: 1, title: t.opleidingsOrkest.blob1_title, text: t.opleidingsOrkest.blob1_text },
                    { id: 2, title: t.opleidingsOrkest.blob2_title, text: t.opleidingsOrkest.blob2_text },
                    { id: 3, title: t.opleidingsOrkest.blob3_title, text: t.opleidingsOrkest.blob3_text }
                ]"
            />

            <BaseTitle
                :title="t.opleidingsOrkest.heading3"
                :infoText="t.opleidingsOrkest.text3"
                :enableText="true"
                align="right"
            />
            <Carousel
                title=""
            />

        </div>

    </div>


</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { useTranslations } from '@/composables/useTranslations'
import HeaderHeroBgImage from "@/Components/headers/HeaderHero_bg_image.vue";
import BaseTitle from "@/Components/BaseTitle.vue";
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

.content {
    width: 80vw;
    margin-left: 10vw;
}
</style>
