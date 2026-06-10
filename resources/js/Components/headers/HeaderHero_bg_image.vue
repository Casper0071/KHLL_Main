
<template>
    <div v-intersect="'animate'" class="header-hero-bg" :style="containerStyle">
        <!-- Black overlay for darkening effect -->
        <div class="header-hero-bg__overlay" :style="overlayStyle"></div>

        <!-- Centered content -->
        <div class="header-hero-bg__content">
            <BaseHeaderTitle
                :title="title"
                :align="'center'"
                :light="true"
                :buttonText="buttonText"
                :buttonVariant="buttonVariant"
                :buttonDisabled="buttonDisabled"
                :enableButton="enableButton"
                :lightBtn="lightBtn"
            />
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import BaseHeaderTitle from '@/Components/Base/BaseHeaderTitle.vue'

// ============================================
// Props
// ============================================

const props = defineProps({
    imageSrc: {
        type: String,
        required: true,
        default: 'https://placehold.co/1200x600/e5e7eb/6b7280?text=Hero'
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
    enableButton: {
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

// ============================================
// Computed Properties
// ============================================

const containerStyle = computed(() => ({
    minHeight: props.minHeight,
    backgroundImage: `url('${props.imageSrc}')`
}))

const overlayStyle = computed(() => ({
    backgroundColor: `rgba(0, 0, 0, ${props.overlayOpacity})`
}))
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.header-hero-bg {
    opacity: 0;
    transform: scale(0.98);
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.header-hero-bg.is-visible {
    opacity: 1;
    transform: scale(1);
}

/* ============================================
   HERO BACKGROUND CONTAINER
   ============================================ */

.header-hero-bg {
    position: relative;
    width: 100%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    box-shadow: 0px 18px 42px rgba(0, 0, 0, 0.55);
}

/* ============================================
   OVERLAY - DARKENING EFFECT
   ============================================ */

.header-hero-bg__overlay {
    position: absolute;
    inset: 0;
    z-index: 0;
    transition: background-color 0.3s ease;
}

/* ============================================
   CONTENT - CENTERED TEXT & CTA
   ============================================ */

.header-hero-bg__content {
    position: relative;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    padding: 2rem;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Mobile (max 640px) */
@media (max-width: 640px) {
    .header-hero-bg__content {
        padding: 1.5rem;
    }

    .header-hero-bg {
        box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.4);
    }
}

/* Tablet (641px - 1024px) */
@media (min-width: 641px) and (max-width: 1024px) {
    .header-hero-bg__content {
        padding: 2rem;
    }
}

/* Extra kleine schermen (max 480px) */
@media (max-width: 480px) {
    .header-hero-bg__content {
        padding: 1rem;
    }
}
</style>
