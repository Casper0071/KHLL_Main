<template>
    <div class="bg-background contact-page">
        <div class="blob-section">
            <div class="blob-container">
                <svg v-if="windowWidth < 1024" class="blob-svg" width="1020" height="1500" viewBox="0 0 1020 1500" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1020 1384.66V0.00021652L-4 0V1355.58C146.954 1508.67 318.706 1499.91 500.363 1499.91C663.749 1499.91 899.947 1419.32 1020 1384.66Z" fill="#F4F7FB"/>
                </svg>

                <svg v-else width="1307" height="899" viewBox="0 0 1307 899" fill="none" xmlns="http://www.w3.org/2000/svg" class="blob-svg">
                    <path d="M1131.52 813.907C830.517 859.407 801.517 921.054 512.517 885.407C385.017 869.68 158.517 969.407 54.5168 813.907C-49.4831 658.407 7.5163 207.407 123.016 82.4066C231.587 -35.0938 445.517 25.9065 632.517 25.9063C806.017 25.9061 1062.02 -44.7981 1222.02 47.4063C1310.52 98.4068 1275.02 237.406 1303.02 513.406C1318.84 669.407 1215.52 801.209 1131.52 813.907Z" fill="var(--surface)"/>
                </svg>

                <div class="blob-content">
                    <ContactForm :light="false" :contactInfo="contactInfo" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { useTranslations } from '@/composables/useTranslations'
import ContactForm from "@/Components/widgets/ContactForm.vue"

defineOptions({
    layout: MainLayout
})

const { t } = useTranslations()

const windowWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1024)

// Bouw contactInfo object uit de vertalingen
const contactInfo = computed(() => ({
    email: t.value?.contact?.contactInfo?.email ,
    phone: t.value?.contact?.contactInfo?.phone,
    address: t.value?.contact?.contactInfo?.address ,
    facebook: t.value?.contact?.contactInfo?.facebook ,
}))

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
.contact-page {
    position: relative;
    width: 100%;
}

.blob-section {
    @apply w-screen flex justify-center items-center;
    padding: 60px 0 100px 0;
}

.blob-container {
    position: relative;
    width: 90vw;
    aspect-ratio: 1307 / 899;
    display: flex;
    align-items: center;
    justify-content: center;
}

.blob-svg {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
}

.blob-content {
    position: relative;
    z-index: 10;
    width: 80%;
}

@media (max-width: 1350px) {
    .blob-section {
        min-height: 600px;
        padding-top: 40px;
    }
    .blob-container {
        width: 90vw;
    }
    .blob-content {
        width: 80%;
    }
}

@media (max-width: 1150px) {
    .blob-section {
        min-height: 600px;
        padding: 40px 0;
    }
    .blob-container {
        width: 100vw;
    }
    .blob-content {
        width: 75%;
    }
}

@media (max-width: 1024px) {
    .blob-section {
        padding: 20px 0 250px 0;
    }
    .blob-svg {
        width: auto;
        height: auto;
        margin-top: -20px;
    }
    .blob-content {
        width: 95%;
    }
}

@media (max-width: 600px) {
    .blob-section {
        min-height: 400px;
    }
    .blob-content {
        width: 95%;
    }
}
</style>
