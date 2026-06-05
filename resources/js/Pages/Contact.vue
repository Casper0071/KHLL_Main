<template>
    <div class="bg-background contact-page">
        <div class="blob-section">
            <div class="blob-container">
                <svg v-if="windowWidth <= 1024" class="blob-svg" width="1442" height="1979" viewBox="0 0 1442 1979" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1441.5 1822.01V0H0V1780.51C92.5 1900.5 218 1979 403 1979C645.658 1979 1359.67 1885.01 1441.5 1822.01Z" fill="#F4F7FB"/>
                </svg>

                <svg v-else class="blob-svg" width="1306" height="1197" viewBox="0 0 1306 1197" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1132.59 1107.91C831.594 1153.41 802.594 1215.05 513.594 1179.41C386.094 1163.68 159.594 1263.41 55.594 1107.91C-48.406 952.406 5.09328 207.407 120.593 82.4066C229.164 -35.0938 443.094 25.9065 630.094 25.9063C803.594 25.9061 1059.59 -44.7981 1219.59 47.4063C1308.09 98.4068 1276.09 531.406 1304.09 807.406C1319.92 963.406 1216.59 1095.21 1132.59 1107.91Z" fill="var(--surface)"/>
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
    board: t.value?.contact?.contactInfo?.board
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
    padding: 60px 0 150px 0;
}

.blob-container {
    position: relative;
    width: 90vw;
    aspect-ratio: 1307 / 899;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 100px;
}

.blob-svg {
    position: absolute;
    width: 100%;
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
