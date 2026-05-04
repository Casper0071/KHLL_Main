<template>
    <div class="bg-background">
        <HeaderHeroBgImage
            :title="t.harmonieLentekrans.title"
            imageSrc="/img/test.jpg"
            :enableButton="false"
            :overlay-opacity="0.5"
            minHeight="400px"
        />
        <div class="content">
            <BaseTitle
                :title="t.harmonieLentekrans.history_heading"
                :infoText="t.harmonieLentekrans.history_text"
                :enableText="true"
                align="left"
            />
            <TitleImageSplit
                :title="t.harmonieLentekrans.community_heading"
                imageSrc="/img/test.jpg"
                image-alt=""
                :infoText="t.harmonieLentekrans.community_text"
            />

            <BaseTitle
                :title="t.harmonieLentekrans.future_vision_heading"
                :infoText="t.harmonieLentekrans.future_vision_text"
                :enableText="true"
                light="true"
                align="right"
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
