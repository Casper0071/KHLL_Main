<template>
    <div class="contact-page bg-background">
        <section class="contact-blob-section" aria-label="Contact section">
            <div class="contact-blob-container">
                <!-- Mobile SVG -->
                <svg
                    v-if="windowWidth <= 1024"
                    class="contact-blob-svg"
                    width="1442"
                    height="1979"
                    viewBox="0 0 1442 1979"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path d="M1441.5 1822.01V0H0V1780.51C92.5 1900.5 218 1979 403 1979C645.658 1979 1359.67 1885.01 1441.5 1822.01Z" fill="var(--surface)"/>
                </svg>

                <!-- Desktop SVG -->
                <svg
                    v-else
                    class="contact-blob-svg"
                    width="1306"
                    height="1197"
                    viewBox="0 0 1306 1197"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path d="M1132.59 1107.91C831.594 1153.41 802.594 1215.05 513.594 1179.41C386.094 1163.68 159.594 1263.41 55.594 1107.91C-48.406 952.406 5.09328 207.407 120.593 82.4066C229.164 -35.0938 443.094 25.9065 630.094 25.9063C803.594 25.9061 1059.59 -44.7981 1219.59 47.4063C1308.09 98.4068 1276.09 531.406 1304.09 807.406C1319.92 963.406 1216.59 1095.21 1132.59 1107.91Z" fill="var(--surface)"/>
                </svg>

                <div class="contact-blob-content">
                    <ContactForm
                        :light="false"
                        :contactInfo="contactInfo"
                    />
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { useTranslations } from '@/composables/useTranslations'
import ContactForm from '@/Components/widgets/ContactForm.vue'

// ============================================
// Options
// ============================================
defineOptions({
    layout: MainLayout
})

// ============================================
// Composables
// ============================================
const { t } = useTranslations()

// ============================================
// Reactive State
// ============================================
const windowWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1024)

// ============================================
// Computed Properties
// ============================================
const contactInfo = computed(() => ({
    email: t.value?.contact?.contactInfo?.email,
    phone: t.value?.contact?.contactInfo?.phone,
    address: t.value?.contact?.contactInfo?.address,
    facebook: t.value?.contact?.contactInfo?.facebook,
    board: t.value?.contact?.contactInfo?.board
}))

// ============================================
// Methods
// ============================================
const handleResize = () => {
    windowWidth.value = window.innerWidth
}

// ============================================
// Lifecycle Hooks
// ============================================
onMounted(() => {
    window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
})
</script>

<style scoped>
/* ============================================
   PAGE CONTAINER
   ============================================ */
.contact-page {
    @apply relative w-full;
}

/* ============================================
   BLOB SECTION
   ============================================ */
.contact-blob-section {
    @apply w-screen flex justify-center items-center;
    padding: 60px 0 150px 0;
}

.contact-blob-container {
    @apply relative;
    width: 90vw;
    max-width: 1307px;
    aspect-ratio: 1307 / 899;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 100px;
}

.contact-blob-svg {
    @apply absolute left-0 top-0 w-full;
}

.contact-blob-content {
    @apply relative z-10 w-4/5;
}

/* ============================================
   RESPONSIVE DESIGN - LARGE SCREENS
   ============================================ */
@media (min-width: 1024px) {
    .contact-blob-section {
        min-height: auto;
        padding-top: 60px;
        padding-bottom: 150px;
    }

    .contact-blob-container {
        width: 90vw;
    }

    .contact-blob-content {
        width: 80%;
    }
}

/* ============================================
   RESPONSIVE DESIGN - TABLET (1350px and down)
   ============================================ */
@media (max-width: 1350px) {
    .contact-blob-section {
        @apply min-h-[600px] py-10;
    }

    .contact-blob-container {
        width: 90vw;
    }

    .contact-blob-content {
        width: 80%;
    }
}

/* ============================================
   RESPONSIVE DESIGN - TABLET (1150px and down)
   ============================================ */
@media (max-width: 1150px) {
    .contact-blob-section {
        @apply min-h-[600px] py-10;
    }

    .contact-blob-container {
        width: 100vw;
    }

    .contact-blob-content {
        width: 75%;
    }
}

/* ============================================
   RESPONSIVE DESIGN - MOBILE (1024px and down)
   ============================================ */
@media (max-width: 1024px) {
    .contact-blob-section {
        @apply py-5 pb-64;
    }

    .contact-blob-svg {
        @apply w-auto h-auto -mt-5;
    }

    .contact-blob-content {
        width: 95%;
    }
}

/* ============================================
   RESPONSIVE DESIGN - SMALL MOBILE (600px and down)
   ============================================ */
@media (max-width: 600px) {
    .contact-blob-section {
        @apply min-h-[400px];
    }

    .contact-blob-content {
        width: 95%;
    }
}
</style>
