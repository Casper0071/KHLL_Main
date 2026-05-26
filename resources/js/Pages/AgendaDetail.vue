<!-- Pages/AgendaDetail.vue -->
<template>
    <div class="bg-background agendaDetailPage">

        <div v-if="isLoading" class="loading-state">
            <div class="loading-spinner"></div>
            <p>{{ t.agenda?.detail?.loading }}</p>
        </div>

        <div v-else-if="error" class="error-state">
            <svg class="error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p>{{ error }}</p>
            <a href="/agenda" class="back-link">{{ t.agenda?.detail?.backToAgenda }}</a>
        </div>

        <div v-else-if="agendaItem" class="detail-container">
            <!-- Header met categorie kleur -->
            <div class="detail-header" :style="{ backgroundColor: agendaItem.color }">
                <div class="header-content">
                    <div class="category-badge" :class="getCategoryClass(agendaItem.color)">
                        {{ getCategoryLabel(agendaItem.color) }}
                    </div>
                    <h1 class="detail-title">{{ agendaItem.title }}</h1>
                </div>
            </div>

            <!-- Main Content -->
            <div class="detail-content">
                <div class="content-wrapper">
                    <!-- Image & Info Grid - Alleen tonen als er een afbeelding is -->
                    <div class="image-info-grid" :class="{ 'no-image': !agendaItem.image_url }">
                        <!-- Afbeelding sectie (alleen tonen als er een afbeelding is) -->
                        <div v-if="agendaItem.image_url" class="image-section">
                            <img :src="agendaItem.image_url" :alt="agendaItem.title" class="detail-image" />
                        </div>

                        <!-- Informatie sectie -->
                        <div class="info-wrapper" :class="{ 'full-width': !agendaItem.image_url }">
                            <!-- Datum & Tijd Sectie -->
                            <div class="info-section">
                                <h2 class="section-title">
                                    <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ t.agenda?.detail?.dateTime }}
                                </h2>
                                <div class="info-grid">
                                    <div class="info-card">
                                        <div class="info-label">{{ t.agenda?.detail?.start }}</div>
                                        <div class="info-value">{{ formatFullDate(agendaItem.start_date) }}</div>
                                        <div class="info-time">{{ formatTime(agendaItem.start_date) }}</div>
                                    </div>
                                    <div v-if="agendaItem.end_date" class="info-card">
                                        <div class="info-label">{{ t.agenda?.detail?.end }}</div>
                                        <div class="info-value">{{ formatFullDate(agendaItem.end_date) }}</div>
                                        <div class="info-time">{{ formatTime(agendaItem.end_date) }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Locatie Sectie -->
                            <div v-if="agendaItem.location" class="info-section">
                                <h2 class="section-title">
                                    <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ t.agenda?.detail?.location }}
                                </h2>
                                <div class="location-card">
                                    <div class="location-name">{{ agendaItem.location }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Beschrijving Sectie -->
                    <div class="info-section">
                        <h2 class="section-title">
                            <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ t.agenda?.detail?.description }}
                        </h2>
                        <div class="description-card">
                            <p class="description-text">{{ agendaItem.description || t.agenda?.detail?.noDescription }}</p>
                        </div>
                    </div>

                    <!-- Google Maps Button (als er locatie is) -->
                    <div v-if="agendaItem.location" class="info-section">
                        <a
                            :href="`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(agendaItem.location)}`"
                            target="_blank"
                            class="map-button"
                        >
                            <svg class="map-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            {{ t.agenda?.detail?.viewInMaps }}
                        </a>
                    </div>

                    <!-- Terug naar agenda knop -->
                    <div class="back-section">
                        <a href="/agenda" class="back-button">
                            <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ t.agenda?.detail?.backToOverview }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { useTranslations } from '@/composables/useTranslations'

defineOptions({
    layout: MainLayout
})

const { t, currentLocale } = useTranslations()
const isLoading = ref(true)
const error = ref(null)
const agendaItem = ref(null)

// Haal het ID uit de URL
const getItemId = () => {
    const urlParts = window.location.pathname.split('/')
    return urlParts[urlParts.length - 1]
}

// Formatteer volledige datum
const formatFullDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    const locale = currentLocale.value === 'en' ? 'en-US' : 'nl-NL'
    return date.toLocaleDateString(locale, {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

// Formatteer tijd
const formatTime = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    const locale = currentLocale.value === 'en' ? 'en-US' : 'nl-NL'
    return date.toLocaleTimeString(locale, {
        hour: '2-digit',
        minute: '2-digit'
    })
}

// Bepaal categorie label
const getCategoryLabel = (color) => {
    const labels = {
        '#3b82f6': t.value?.agenda?.categorieen?.LOL ?? 'LOL',
        '#f59e0b': t.value?.agenda?.categorieen?.KHLL ?? 'Koninklijke Harmonie',
        '#10b981': t.value?.agenda?.categorieen?.Activiteiten ?? 'Activiteit'
    }
    return labels[color] || 'Activiteit'
}

// Bepaal categorie class
const getCategoryClass = (color) => {
    const classes = {
        '#3b82f6': 'badge-lol',
        '#f59e0b': 'badge-khll',
        '#10b981': 'badge-activiteit'
    }
    return classes[color] || 'badge-activiteit'
}

// Fetch agenda item van API
const fetchAgendaItem = async (id) => {
    isLoading.value = true
    error.value = null

    try {
        const response = await fetch(`/api/agenda/${id}`)

        if (response.ok) {
            const data = await response.json()

            // Check of item gepubliceerd is
            if (data.data.status !== 'published') {
                error.value = t.value?.agenda?.detail?.notAvailable
            } else if (data.data.published_at) {
                const date = new Date(data.data.published_at)

                const publishDate = date.toISOString().slice(0, 16);
                const now = new Date()
                if (publishDate > now) {
                    error.value = t.value?.agenda?.detail?.notPublishedYet
                } else {
                    agendaItem.value = data.data
                }
            } else {
                agendaItem.value = data.data
            }
        } else if (response.status === 404) {
            error.value = t.value?.agenda?.detail?.notFound
        } else {
            error.value = t.value?.agenda?.detail?.loadError
        }
    } catch (err) {
        console.error('Error fetching agenda item:', err)
        error.value = t.value?.agenda?.detail?.serverError
    } finally {
        isLoading.value = false
    }
}

onMounted(() => {
    const id = getItemId()
    if (id) {
        fetchAgendaItem(id)
    } else {
        error.value = t.value?.agenda?.detail?.invalidId
        isLoading.value = false
    }
})
</script>

<style scoped>
.agendaDetailPage {
    position: relative;
    isolation: isolate;
    min-height: 100vh;
}

.backgroundMusicNotes {
    position: absolute;
    width: 100%;
    overflow: hidden;
    z-index: 0;
    pointer-events: none;
}

/* Loading State */
.loading-state {
    @apply flex flex-col items-center justify-center min-h-screen text-text-light;
    position: relative;
    z-index: 2;
}
.loading-state p{
    @apply mt-4 text-text-light;
}

.loading-spinner {
    @apply w-12 h-12 border-4 border-primary border-t-transparent rounded-full mb-4;
    animation: spin 1s linear infinite;
}

/* Error State */
.error-state {
    @apply flex flex-col items-center justify-center min-h-screen text-center;
    position: relative;
    z-index: 2;
}

.error-icon {
    @apply w-20 h-20 text-red-500 mb-4;
}

.error-state p {
    @apply text-text-light text-xl mb-4;
}

.back-link {
    @apply text-primary hover:text-primary-hover transition font-medium;
}

/* Detail Container */
.detail-container {
    position: relative;
    z-index: 2;
}

/* Detail Header */
.detail-header {
    @apply relative py-16 px-4 text-center;
    background-size: cover;
    background-position: center;
}

.header-content {
    @apply max-w-4xl mx-auto;
}

.category-badge {
    @apply inline-block px-4 py-1 rounded-full text-white text-sm font-semibold mb-4;
}

.badge-lol {
    background-color: #3b82f6;
}

.badge-khll {
    background-color: #f59e0b;
}

.badge-activiteit {
    background-color: #10b981;
}

.detail-title {
    @apply text-3xl md:text-4xl lg:text-5xl font-bold text-white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

/* Detail Content */
.detail-content {
    @apply py-12 px-4;
}

.content-wrapper {
    @apply max-w-4xl mx-auto;
}

/* Info Sections */
.info-section {
    @apply mb-12;
}

.section-title {
    @apply text-2xl font-bold text-text-light mb-6 flex items-center gap-3;
}

.section-icon {
    @apply w-6 h-6 text-primary;
}

/* Info Grid */
.info-grid {
    @apply grid grid-cols-1 md:grid-cols-2 gap-6;
}

.info-card {
    @apply rounded-xl p-6;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.08) 0%, rgba(234, 183, 81, 0.02) 100%);
    border: 1px solid rgba(234, 183, 81, 0.15);
}

.info-label {
    @apply text-text-muted text-sm uppercase tracking-wide mb-2;
}

.info-value {
    @apply text-text-light text-xl font-semibold mb-1;
}

.info-time {
    @apply text-text-muted text-sm;
}

/* Location Card */
.location-card {
    @apply rounded-xl p-6;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.08) 0%, rgba(234, 183, 81, 0.02) 100%);
    border: 1px solid rgba(234, 183, 81, 0.15);
}

.location-name {
    @apply text-text-light text-lg font-semibold mb-1;
}

.location-address {
    @apply text-text-muted text-sm;
}

/* Description Card */
.description-card {
    @apply rounded-xl p-6;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.08) 0%, rgba(234, 183, 81, 0.02) 100%);
    border: 1px solid rgba(234, 183, 81, 0.15);
}

.description-text {
    @apply text-text-light leading-relaxed;
}

/* Map Button */
.map-button {
    @apply inline-flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all duration-300;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.1) 0%, rgba(234, 183, 81, 0.05) 100%);
    border: 1px solid rgba(234, 183, 81, 0.3);
    color: var(--text-light);
}

.map-button:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateX(4px);
}

.map-icon {
    @apply w-5 h-5;
}

/* Back Section */
.back-section {
    @apply mt-12 pt-8 text-center border-t border-primary border-opacity-20;
}

.back-button {
    @apply inline-flex items-center gap-2 text-text-muted hover:text-primary transition font-medium;
}

.back-icon {
    @apply w-5 h-5;
}

/* Image & Info Grid */
.image-info-grid {
    @apply grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12;
}

.image-info-grid.no-image {
    @apply grid-cols-1;
}

.image-section {
    @apply flex items-start justify-center;
}

.detail-image {
    @apply w-full rounded-xl shadow-2xl;
    max-height: 500px;
    object-fit: cover;
}

.info-wrapper {
    @apply space-y-8;
}

.info-wrapper.full-width {
    @apply col-span-full;
}

/* Responsive */
@media (max-width: 768px) {
    .image-info-grid {
        @apply gap-6;
    }

    .detail-image {
        max-height: 300px;
    }
}

/* Animations */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .detail-header {
        @apply py-12;
    }

    .detail-title {
        @apply text-2xl;
    }

    .section-title {
        @apply text-xl;
    }

    .info-grid {
        @apply grid-cols-1;
    }

    .info-card {
        @apply p-4;
    }

    .description-card {
        @apply p-4;
    }
}
</style>
