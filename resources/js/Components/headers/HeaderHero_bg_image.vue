<script setup>
import { computed, defineProps } from 'vue'
import HeaderTitle from '@/Components/HeaderTitle.vue'

const props = defineProps({
    imageSrc: {
        type: String,
        required: true,
        default: 'https://via.placeholder.com/1200x600'
    },
    title: {
        type: String,
        default: 'Header Title'
    },
    buttonText: {
        type: String,
        default: 'Lees meer'
    },
    buttonVariant: {
        type: String,
        default: 'primary'
    },
    buttonDisabled: {
        type: Boolean,
        default: false
    },
    overlayOpacity: {
        type: Number,
        default: 0.5,
        validator: (value) => value >= 0 && value <= 1
    },
    light: {
        type: Boolean,
        default: false
    },
    lightBtn: {
        type: Boolean,
        default: false
    },
    minHeight: {
        type: String,
        default: '500px'
    }
})

// Compute styles safely without inline eval
const containerStyle = computed(() => ({
    minHeight: props.minHeight,
    backgroundImage: `url('${props.imageSrc}')`
}))

const overlayStyle = computed(() => ({
    backgroundColor: `rgba(0, 0, 0, ${props.overlayOpacity})`
}))
</script>

<template>
    <div class="hero-container" :style="containerStyle">
        <!-- Black overlay for darkening effect -->
        <div class="overlay" :style="overlayStyle"></div>

        <!-- Centered content -->
        <div class="content">
            <HeaderTitle
                :title="title"
                :align="'center'"
                :light="true"
                :buttonText="buttonText"
                :buttonVariant="buttonVariant"
                :buttonDisabled="buttonDisabled"
                :lightBtn="lightBtn"
            />
        </div>
    </div>
</template>

<style scoped>
/* ============================================
   Hero Container - Base Layout
   ============================================ */

.hero-container {
    @apply relative w-full overflow-hidden flex items-center justify-center;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    box-shadow: 0px 18px 42px rgba(0, 0, 0, 0.55);
}

/* ============================================
   Overlay - Darkening Effect
   ============================================ */

.overlay {
    @apply absolute inset-0 z-0 transition-colors duration-300;
}

/* ============================================
   Content - Centered Text & CTA
   ============================================ */

.content {
    @apply relative z-10 flex items-center justify-center w-full h-full p-8;
}
</style>
