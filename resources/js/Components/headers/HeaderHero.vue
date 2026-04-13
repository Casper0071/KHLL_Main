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
    background-color: #ffffff; /* tijdelijk wit */
    border-radius: 70% 45% 35% 60% / 60% 40% 60% 60%;
    overflow: hidden;
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
