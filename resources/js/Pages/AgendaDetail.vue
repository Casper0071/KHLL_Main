<template>
    <div class="agenda-detail-page bg-background">
        <!-- Loading State -->
        <div v-if="isLoading" class="detail-loading" role="status" aria-live="polite">
            <div class="loading-spinner"></div>
            <p>{{ t.agenda?.detail?.loading || 'Bezig met laden...' }}</p>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="detail-error" role="alert">
            <svg class="error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p>{{ error }}</p>
            <a href="/Agenda" class="error-back-link">{{ t.agenda?.detail?.backToAgenda || 'Terug naar agenda' }}</a>
        </div>

        <!-- Detail Content -->
        <div v-else-if="agendaItem" class="detail-container">
            <!-- Header - Gebruik categoryKey voor kleur -->
            <div class="detail-header" :style="{ backgroundColor: getCategoryColor(agendaItem.categoryKey) }">
                <div class="header-content">
                    <div class="category-badge" :class="getCategoryBadgeClass(agendaItem.categoryKey)">
                        {{ getCategoryLabel(agendaItem.categoryKey) }}
                    </div>
                    <h1 class="detail-title">{{ agendaItem.title }}</h1>
                </div>
            </div>

            <!-- Main Content -->
            <div class="detail-content">
                <div class="content-wrapper">
                    <!-- Image & Info Grid -->
                    <div class="image-info-grid" :class="{ 'no-image': !agendaItem.image_url }">
                        <!-- Image Section -->
                        <div v-if="agendaItem.image_url" class="image-section">
                            <img
                                :src="agendaItem.image_url"
                                :alt="agendaItem.title"
                                class="detail-image"
                                loading="lazy"
                            />
                        </div>

                        <!-- Info Section -->
                        <div class="info-wrapper" :class="{ 'full-width': !agendaItem.image_url }">
                            <!-- Date & Time -->
                            <div class="info-section">
                                <h2 class="section-title">
                                    <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ t.agenda?.detail?.dateTime || 'Datum & Tijd' }}
                                </h2>
                                <div class="info-grid">
                                    <div class="info-card">
                                        <div class="info-label">{{ t.agenda?.detail?.start || 'Start' }}</div>
                                        <div class="info-value">{{ formatFullDate(agendaItem.start_date) }}</div>
                                        <div class="info-time">{{ formatTime(agendaItem.start_date) }}</div>
                                    </div>
                                    <div v-if="agendaItem.end_date" class="info-card">
                                        <div class="info-label">{{ t.agenda?.detail?.end || 'Einde' }}</div>
                                        <div class="info-value">{{ formatFullDate(agendaItem.end_date) }}</div>
                                        <div class="info-time">{{ formatTime(agendaItem.end_date) }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location -->
                            <div v-if="agendaItem.location" class="info-section">
                                <h2 class="section-title">
                                    <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ t.agenda?.detail?.location || 'Locatie' }}
                                </h2>
                                <div class="location-card">
                                    <div class="location-name">{{ agendaItem.location }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="info-section">
                        <h2 class="section-title">
                            <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ t.agenda?.detail?.description || 'Beschrijving' }}
                        </h2>
                        <div class="description-card">
                            <p class="description-text">
                                {{ agendaItem.description || t.agenda?.detail?.noDescription || 'Geen beschrijving beschikbaar' }}
                            </p>
                        </div>
                    </div>

                    <!-- Google Maps Link -->
                    <div v-if="agendaItem.location" class="info-section">
                        <a
                            :href="`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(agendaItem.location)}`"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="map-button"
                            aria-label="Bekijk in Google Maps"
                        >
                            <svg class="map-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            {{ t.agenda?.detail?.viewInMaps || 'Bekijk route in Google Maps' }}
                        </a>
                    </div>

                    <!-- Back Button -->
                    <div class="back-section">
                        <a href="/Agenda" class="back-button">
                            <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ t.agenda?.detail?.backToOverview || 'Terug naar agenda overzicht' }}
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

// Options
defineOptions({
    layout: MainLayout
})

// Composables
const { t, currentLocale } = useTranslations()

// Reactive State
const isLoading = ref(true)
const error = ref(null)
const agendaItem = ref(null)

// Helper Methods
const getItemId = () => {
    const urlParts = window.location.pathname.split('/')
    return urlParts[urlParts.length - 1]
}

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

const formatTime = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    const locale = currentLocale.value === 'en' ? 'en-US' : 'nl-NL'
    return date.toLocaleTimeString(locale, {
        hour: '2-digit',
        minute: '2-digit'
    })
}

// Categorie helper functies op basis van categoryKey
const getCategoryColor = (categoryKey) => {
    const colors = {
        'lol': '#3b82f6',
        'khll': '#f59e0b',
        'activiteiten': '#10b981',
        'activiteit': '#10b981'
    }
    return colors[categoryKey] || '#3b82f6'
}

const getCategoryLabel = (categoryKey) => {
    const labels = {
        'lol': 'LOL',
        'khll': 'Koninklijke Harmonie',
        'activiteiten': 'Activiteiten',
        'activiteit': 'Activiteiten'
    }
    return labels[categoryKey] || 'Activiteit'
}

const getCategoryBadgeClass = (categoryKey) => {
    const classes = {
        'lol': 'badge-lol',
        'khll': 'badge-khll',
        'activiteiten': 'badge-activiteit',
        'activiteit': 'badge-activiteit'
    }
    return classes[categoryKey] || 'badge-activiteit'
}

// Fetch agenda item
const fetchAgendaItem = async (id) => {
    isLoading.value = true
    error.value = null

    try {
        const response = await fetch(`/api/agenda/${id}`)

        if (response.ok) {
            const data = await response.json()
            const item = data.data

            // Check if item is published
            if (item.status !== 'published') {
                error.value = t.value?.agenda?.detail?.notAvailable || 'Dit agenda item is niet beschikbaar'
            } else if (item.published_at) {
                const publishDate = new Date(item.published_at)
                publishDate.setTime(publishDate.getTime() - 2 * 60 * 60 * 1000)
                const now = new Date()

                if (publishDate > now) {
                    error.value = t.value?.agenda?.detail?.notPublishedYet || 'Dit agenda item is nog niet gepubliceerd'
                } else {
                    agendaItem.value = item
                }
            } else {
                agendaItem.value = item
            }
        } else if (response.status === 404) {
            error.value = t.value?.agenda?.detail?.notFound || 'Agenda item niet gevonden'
        } else {
            error.value = t.value?.agenda?.detail?.loadError || 'Er is een fout opgetreden bij het laden'
        }
    } catch (err) {
        console.error('Error fetching agenda item:', err)
        error.value = t.value?.agenda?.detail?.serverError || 'Kon geen verbinding maken met de server'
    } finally {
        isLoading.value = false
    }
}

// Lifecycle
onMounted(() => {
    const id = getItemId()
    if (id && !isNaN(id)) {
        fetchAgendaItem(id)
    } else {
        error.value = t.value?.agenda?.detail?.invalidId || 'Geen geldig agenda item ID opgegeven'
        isLoading.value = false
    }
})
</script>

<style scoped>
/* ============================================
   Page Container
   ============================================ */
.agenda-detail-page {
    position: relative;
    width: 100%;
    min-height: 100vh;
}

/* ============================================
   Loading State
   ============================================ */
.detail-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    position: relative;
    z-index: 2;
}

.loading-spinner {
    width: 3rem;
    height: 3rem;
    border: 4px solid var(--primary);
    border-top-color: transparent;
    border-radius: 50%;
    margin-bottom: 1rem;
    animation: spin 1s linear infinite;
}

.detail-loading p {
    margin-top: 1rem;
    color: var(--text-light);
}

/* ============================================
   Error State
   ============================================ */
.detail-error {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    text-align: center;
    position: relative;
    z-index: 2;
}

.error-icon {
    width: 5rem;
    height: 5rem;
    color: #ef4444;
    margin-bottom: 1rem;
}

.detail-error p {
    color: var(--text-light);
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

.error-back-link {
    color: var(--primary);
    transition: color 0.2s ease;
    text-decoration: none;
}

.error-back-link:hover {
    color: var(--primary-hover);
}

/* ============================================
   Detail Container & Header
   ============================================ */
.detail-container {
    position: relative;
    z-index: 2;
}

.detail-header {
    position: relative;
    padding: 4rem 1rem;
    text-align: center;
}

.header-content {
    max-width: 1280px;
    margin: 0 auto;
}

/* Category Badges - Directe kleuren */
.category-badge {
    display: inline-block;
    padding: 0.25rem 1rem;
    border-radius: 9999px;
    color: white;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
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
    font-size: 1.875rem;
    font-weight: 700;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

@media (min-width: 768px) {
    .detail-title {
        font-size: 2.25rem;
    }
}

@media (min-width: 1024px) {
    .detail-title {
        font-size: 3rem;
    }
}

/* ============================================
   Detail Content
   ============================================ */
.detail-content {
    padding: 3rem 1rem;
}

.content-wrapper {
    max-width: 1280px;
    margin: 0 auto;
}

/* ============================================
   Info Sections
   ============================================ */
.info-section {
    margin-bottom: 3rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-icon {
    width: 1.5rem;
    height: 1.5rem;
    color: var(--primary);
    flex-shrink: 0;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

.info-card {
    border-radius: 0.75rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.08) 0%, rgba(234, 183, 81, 0.02) 100%);
    border: 1px solid rgba(234, 183, 81, 0.15);
}

.info-label {
    color: var(--text-muted);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}

.info-value {
    color: var(--text-light);
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.info-time {
    color: var(--text-muted);
    font-size: 0.875rem;
}

/* Location Card */
.location-card {
    border-radius: 0.75rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.08) 0%, rgba(234, 183, 81, 0.02) 100%);
    border: 1px solid rgba(234, 183, 81, 0.15);
}

.location-name {
    color: var(--text-light);
    font-size: 1.125rem;
    font-weight: 600;
}

/* Description Card */
.description-card {
    border-radius: 0.75rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.08) 0%, rgba(234, 183, 81, 0.02) 100%);
    border: 1px solid rgba(234, 183, 81, 0.15);
}

.description-text {
    color: var(--text-light);
    line-height: 1.6;
}

/* ============================================
   Image & Info Grid
   ============================================ */
.image-info-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
}

@media (min-width: 1024px) {
    .image-info-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.image-info-grid.no-image {
    grid-template-columns: 1fr;
}

.image-section {
    display: flex;
    align-items: flex-start;
    justify-content: center;
}

.detail-image {
    width: 100%;
    border-radius: 0.75rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    max-height: 500px;
    object-fit: cover;
}

.info-wrapper {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.info-wrapper.full-width {
    grid-column: span 1;
}

/* ============================================
   Map Button
   ============================================ */
.map-button {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.1) 0%, rgba(234, 183, 81, 0.05) 100%);
    border: 1px solid rgba(234, 183, 81, 0.3);
    color: var(--text-light);
    text-decoration: none;
}

.map-button:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateX(4px);
}

.map-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* ============================================
   Back Section
   ============================================ */
.back-section {
    margin-top: 3rem;
    padding-top: 2rem;
    text-align: center;
    border-top: 1px solid rgba(234, 183, 81, 0.2);
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    transition: color 0.2s ease;
    text-decoration: none;
}

.back-button:hover {
    color: var(--primary);
}

.back-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* ============================================
   Animations
   ============================================ */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* ============================================
   Responsive
   ============================================ */
@media (max-width: 768px) {
    .detail-header {
        padding: 3rem 1rem;
    }

    .detail-title {
        font-size: 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
    }

    .info-card {
        padding: 1rem;
    }

    .detail-image {
        max-height: 300px;
    }
}

@media (max-width: 640px) {
    .detail-title {
        font-size: 1.25rem;
    }

    .section-title {
        font-size: 1.125rem;
    }

    .map-button {
        width: 100%;
        justify-content: center;
    }
}
</style>
