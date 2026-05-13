<template>
    <div class="bg-background">
        <HeaderHeroBgImage
            :title="t.harmonieLentekrans.title"
            imageSrc="/img/test.jpg"
            :enableButton="false"
            :overlay-opacity="0.5"
            minHeight="400px"
        />
        <div class="blob1Mobile"></div>
            <div class="blob">
                <div class="blob1 ">
                    <svg v-if="windowWidth <=1000 " width="1302" height="1209" viewBox="0 0 1302 1209" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M869.5 18.3689C626.427 -1.69807 138 -33.131 0.5 106.369V1104.87C85.5 1245.87 800.5 1266.37 841 1016.37C911.51 581.121 1283 535.869 1300.5 272.869C1309.87 132.092 1190.5 44.8691 869.5 18.3689Z" fill="#F4F7FB" stroke="black"/>
                    </svg>
                    <svg v-else-if="windowWidth <= 1150" width="1322" height="972" viewBox="0 0 1322 972" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M867.5 28.7862C625.916 -4.74479 138 -35.2137 0.5 104.286V865.286C85.5 1006.29 744.85 1029.03 811 794.286C867.5 593.786 1321 486.286 1321 228.286C1321 87.1976 1166.5 70.2864 867.5 28.7862Z" fill="#F4F7FB" stroke="black"/>
                    </svg>
                    <svg v-else width="1322" height="783" viewBox="0 0 1322 783" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M867.5 28.7862C625.916 -4.74479 138 -35.2137 0.5 104.286V651.786C85.5 792.786 620 849.286 779.5 664.786C1026.15 379.477 1326 369.286 1321 228.286C1316 87.2862 1166.5 70.2864 867.5 28.7862Z" fill="#F4F7FB" stroke="black"/>
                    </svg>
                </div>


                <div class="content1 content">
                    <BaseTitle
                        :title="t.harmonieLentekrans.heading1"
                        :infoText="t.harmonieLentekrans.text1"
                        :enableText="true"
                        align="left"
                    />
                    <TitleImageSplit
                        :title="t.harmonieLentekrans.heading2"
                        imageSrc="/img/test.jpg"
                        image-alt=""
                        :infoText="t.harmonieLentekrans.text2"
                    />
                </div>
            </div>
        <div class="spacer1"></div>


        <div class="contentpage contentpage2">
            <div class="content2">
                <BaseTitle
                    :title="t.harmonieLentekrans.heading3"
                    :infoText="t.harmonieLentekrans.text3"
                    :enableText="true"
                    :light="true"
                    align="right"
                />
                <div class="itemsContent2"><div><p>{{t.harmonieLentekrans.text3_item1}}</p> <div class="itemsLine"></div></div> <div><p>{{t.harmonieLentekrans.text3_item2}}</p><div class="itemsLine"></div></div></div>


            </div>


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


.contentpage {
    width: 80vw;
    margin-left: 10vw;
}

.content1 {
    top: 100px;

}
.contentpage2{
    display: flex;
    justify-content: flex-end;
}

.content2{
    margin-top: 300px;
    padding-bottom: 100px;
    width: 85%;
    display: flex;
    flex-direction: column;
}

.itemsContent2 {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
    margin-right: 2rem;
}
.itemsContent2 p {
    color: var(--text-light);
}
.itemsContent2 div {
    display: flex;
    align-items: center;
}
.itemsLine{
    width: 20px;
    height: 3px;
    border-radius: 5px;
    margin-left: 10px;
    background-color: var(--primary);
}
.blob {
    @apply w-screen relative flex items-center;
    filter:
        drop-shadow(0px 18px 42px rgba(0, 0, 0, 0.55))
        drop-shadow(0px 8px 18px rgba(0, 0, 0, 0.35))
        drop-shadow(0px 0px 1px rgba(255, 255, 255, 0.10));
}

.content {
    @apply relative w-[80vw] ml-[10vw] mr-[10vw]  z-10;
}


.blob1 {
    @apply absolute  left-0;
    margin-top: 100px;
    width: 100vw;
    top: 55%;
    transform: translateY(-50%);
    overflow: hidden;

}
.blob1 svg{
    width: 90vw;
}

.blob1Mobile {
    @apply absolute hidden  w-screen h-full;
    background: var(--surface);
    clip-path: shape(from 0 25px, curve to 30% 19px with 20% 12px, curve to 50% 18px with 40% 26px, curve to 70% 12px with 60% 10px, curve to 100% 25px with 80% 14px, vline to calc(100% - 25px), curve to 70% calc(100% - 22px) with 80% calc(100% - 3px), curve to 50% calc(100% - 39.5px) with 60% calc(100% - 41px), curve to 30% calc(100% - 27.5px) with 40% calc(100% - 38px), curve to 0 calc(100% - 25px) with 20% calc(100% - 17px), vline to 0);
}

@media (max-width: 1350px) {
    .blob1 svg{
        width: 100vw;
    }
}
@media (max-width: 1200px) {
    .blob1{
        margin-top: 50px;
    }
    .spacer1{
        height: 200px;
    }
    .content2{
        margin-top: 0px;
    }
}
@media (max-width: 1150px) {
    .blob1{
        margin-top: 100px;
    }
}
@media (max-width: 1100px) {
    .blob1{
        margin-top: 50px;
    }
    .content2{
        width: 90%;
    }
}
@media (max-width: 1000px) {

    .blob1{
        margin-top: 100px;
    }
}

@media (max-width: 950px) {

    .blob1{
        margin-top: 50px;
    }
}
@media (max-width: 850px) {

    .blob1{
        visibility: hidden;

    }
    .blob1Mobile{
        @apply block;
        height: 1000px;
    }
    .content2{
        width: 100%;
    }
}
@media (max-width: 550px) {

    .blob1Mobile{
        height: 1200px;
    }
}

@media (max-width: 600px) {
    .content {
        @apply w-[100vw] ml-[5vw] mr-[5vw] text-center;
    }
    .contentpage {
        width: 90vw;
    }
}
@media (max-width: 430px) {

    .blob1Mobile{
        height: 1300px;
    }
}


</style>
