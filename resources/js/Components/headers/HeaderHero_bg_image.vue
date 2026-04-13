<script setup>
import { defineProps } from 'vue'
import HeaderTitle from '@/Components/HeaderTitle.vue'

defineProps({
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
</script>

<template>
    <div class="hero-container" :style="{ minHeight: minHeight, backgroundImage: `url('${imageSrc}')` }">
        <!-- Black overlay for darkening effect -->
        <div class="overlay" :style="{ backgroundColor: `rgba(0, 0, 0, ${overlayOpacity})` }"></div>
        
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
.hero-container {
    position: relative;
    width: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    transition: background-color 0.3s ease;
}

.content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    padding: 2rem;
}
</style>
