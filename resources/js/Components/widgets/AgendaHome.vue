<script setup>
import { defineProps, ref, onMounted, computed } from 'vue'
import BaseTitle from '@/Components/Base/BaseTitle.vue'
import BaseButton from '@/Components/Base/BaseButton.vue'

const isLoading = ref(false)
const activitiesData = ref(null)

const props = defineProps({
    title: {
        type: String,
        default: 'Eerstvolgende Activiteiten'
    },
    image: {
        type: String,
        default: 'https://via.placeholder.com/400x300'
    },
    activities: {
        type: Array,
        default: () => []
    },
    fetchUrl: {
        type: String,
        default: '/api/agenda'
    },
    light: {
        type: Boolean,
        default: true
    },
    limit: {
        type: Number,
        default: 5
    }
})

// Formatteer datum naar Nederlands formaat
const formatDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('nl-NL', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

// Formatteer tijd
const formatTime = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleTimeString('nl-NL', {
        hour: '2-digit',
        minute: '2-digit'
    })
}

// Bepaal categorie label en kleur
const getCategoryInfo = (color) => {
    const categories = {
        '#3b82f6': { label: 'LOL', class: 'category-lol' },
        '#f59e0b': { label: 'Koninklijke Harmonie', class: 'category-khll' },
        '#10b981': { label: 'Activiteit', class: 'category-activiteit' }
    }
    return categories[color] || { label: 'Activiteit', class: 'category-activiteit' }
}

// Filter alleen gepubliceerde items (gepubliceerd en publicatiedatum is verstreken)
const getPublishedItems = (items) => {
    if (!items) return []

    const now = new Date()

    return items.filter(item => {
        // Status moet published zijn
        if (item.status !== 'published') return false

        // Check publicatiedatum
        if (item.published_at) {
            const publishDate = new Date(item.published_at)
            // Alleen tonen als de publicatiedatum in het verleden of gelijk aan nu is
            if (publishDate > now) return false
        }

        return true
    })
}

// Haal de eerstvolgende items op (gesorteerd op start_datum)
const getUpcomingItems = (items) => {
    const published = getPublishedItems(items)
    const now = new Date()

    // Filter alleen toekomstige items (start_datum >= nu)
    const upcoming = published.filter(item => {
        const startDate = new Date(item.start_date)
        return startDate >= now
    })

    // Sorteer op start_datum
    upcoming.sort((a, b) => new Date(a.start_date) - new Date(b.start_date))

    // Beperk tot het aantal gewenste items
    return upcoming.slice(0, props.limit)
}

// Toon items (van API of fallback)
const displayActivities = computed(() => {
    if (activitiesData.value && activitiesData.value.data) {
        const upcoming = getUpcomingItems(activitiesData.value.data)

        return upcoming.map(item => ({
            id: item.id,
            date: formatDate(item.start_date),
            time: formatTime(item.start_date),
            title: item.title,
            description: item.description || 'Geen beschrijving beschikbaar',
            link: `/agenda/${item.id}`,
            color: item.color,
            location: item.location,
            category: getCategoryInfo(item.color)
        }))
    }

    // Fallback naar props activities (voor statische data)
    return props.activities
})

onMounted(async () => {
    if (props.fetchUrl) {
        isLoading.value = true
        try {
            const response = await fetch(props.fetchUrl)
            if (response.ok) {
                const data = await response.json()
                activitiesData.value = data
            }
        } catch (error) {
            console.error('Fout bij het laden van activiteiten:', error)
        } finally {
            isLoading.value = false
        }
    }
})
</script>

<template>
    <div class="activities-container" :class="{ 'light-mode': props.light }">
        <!-- Title -->
        <div class="title-section">
            <BaseTitle :title="props.title" :light="props.light" align="center" />
        </div>

        <!-- Main Content -->
        <div class="content-grid">
            <!-- Image Section -->
            <div class="image-section">
                <img :src="props.image" :alt="props.title" class="activity-image" />
            </div>

            <!-- Activities List Section -->
            <div class="activities-section">
                <div class="activities-list">
                    <div v-if="isLoading" class="loading-state">
                        <div class="loading-spinner"></div>
                        <p>Activiteiten laden...</p>
                    </div>

                    <div v-else-if="displayActivities.length === 0" class="empty-state">
                        <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p>Er zijn momenteel geen geplande activiteiten</p>
                        <p class="empty-subtitle">Kom binnenkort terug voor nieuwe activiteiten</p>
                    </div>

                    <div v-else v-for="(activity, index) in displayActivities" :key="activity.id" class="activity-item" :style="{ 'animation-delay': `${index * 50}ms` }">
                        <div class="activity-header">
                            <div class="activity-date-wrapper">
                                <span class="activity-date">{{ activity.date }}</span>
                                <span class="activity-time">{{ activity.time }}</span>
                                <span class="activity-category" :class="activity.category.class">
                                    {{ activity.category.label }}
                                </span>
                            </div>
                            <h3 class="activity-title">{{ activity.title }}</h3>
                        </div>

                        <p class="activity-description">{{ activity.description }}</p>

                        <div v-if="activity.location" class="activity-location">
                            <svg class="location-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ activity.location }}</span>
                        </div>

                        <a :href="activity.link" class="read-more-link">Meer informatie →</a>
                    </div>
                </div>

                <!-- All Activities BaseButton -->
                <div class="button-section">
                    <a href="/agenda" class="inline-block px-6 py-3 rounded-lg font-medium transition-all duration-300 bg-primary text-background hover:bg-primary-hover hover:shadow-lg transform hover:scale-105">
                        Bekijk Alle Activiteiten
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.activities-container {
    @apply w-full px-4 md:px-8 lg:px-12 py-12;
}

.title-section {
    @apply mb-12 text-center;
}

.content-grid {
    @apply grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12;
}

.image-section {
    @apply flex items-center justify-center;
}

.activity-image {
    @apply w-full h-auto rounded-lg shadow-2xl;
    aspect-ratio: 16 / 10;
    object-fit: cover;
    transition: transform 0.5s ease-in-out;
}

.image-section:hover .activity-image {
    transform: scale(1.02);
}

.activities-section {
    @apply flex flex-col gap-6;
}

.activities-list {
    @apply space-y-4 pr-2;
    max-height: 800px;
    overflow-y: auto;
    padding-right: 12px;
}

/* Loading State */
.loading-state {
    @apply flex flex-col items-center justify-center p-8 text-center;
}

.loading-spinner {
    @apply w-10 h-10 border-4 border-primary border-t-transparent rounded-full mb-4;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Empty State */
.empty-state {
    @apply flex flex-col items-center justify-center p-12 text-center;
}

.empty-icon {
    @apply w-16 h-16 text-text-muted mb-4;
}

.empty-state p {
    @apply text-text-muted text-lg mb-2;
}

.empty-subtitle {
    @apply text-sm text-text-muted;
}

/* Scrollbar Styling */
.activities-list::-webkit-scrollbar {
    width: 6px;
}

.activities-list::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.activities-list::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 10px;
}

.activities-list::-webkit-scrollbar-thumb:hover {
    background: var(--primary-hover);
}

/* Activity Item */
.activity-item {
    @apply p-5 rounded-lg transition-all duration-300 ease-out;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.08) 0%, rgba(234, 183, 81, 0.02) 100%);
    border: 1px solid rgba(234, 183, 81, 0.15);
    animation: slideInUp 0.4s ease-out forwards;
    opacity: 0;
}

.activity-item:hover {
    border-color: rgba(234, 183, 81, 0.4);
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.15) 0%, rgba(234, 183, 81, 0.05) 100%);
    box-shadow: 0 8px 16px rgba(234, 183, 81, 0.1);
    transform: translateX(4px);
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Activity Header */
.activity-header {
    @apply mb-3;
}

.activity-date-wrapper {
    @apply flex flex-wrap items-center gap-2 mb-2;
}

.activity-date {
    @apply text-xs font-poppins font-semibold tracking-wide;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.activity-time {
    @apply text-xs text-text-muted font-poppins;
}

.activity-category {
    @apply text-xs px-2 py-0.5 rounded-full font-semibold;
}

.category-lol {
    @apply bg-blue-500 text-white;
}

.category-khll {
    @apply bg-amber-500 text-white;
}

.category-activiteit {
    @apply bg-green-500 text-white;
}

.activity-title {
    @apply text-xl font-poppins font-semibold text-text-dark mt-1;
    margin: 0;
    line-height: 1.3;
}

.light-mode .activity-title {
    @apply text-text-light;
}

.activity-description {
    @apply text-sm text-text-muted mb-3;
    line-height: 1.5;
    margin: 0;
}

.light-mode .activity-description {
    @apply text-accent-soft;
}

/* Location */
.activity-location {
    @apply flex items-center gap-1 mb-3 text-xs text-text-muted;
}

.location-icon {
    @apply w-3 h-3;
}

/* Read More Link */
.read-more-link {
    @apply text-sm font-poppins font-semibold transition-all duration-200;
    color: var(--primary);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.read-more-link:hover {
    color: var(--primary-hover);
    transform: translateX(2px);
}

.light-mode .read-more-link {
    color: var(--primary-light);
}

.light-mode .read-more-link:hover {
    color: var(--primary-light);
}

/* Button Section */
.button-section {
    @apply flex justify-center pt-4;
    border-top: 1px solid rgba(234, 183, 81, 0.2);
}

.light-mode .button-section {
    border-top-color: rgba(234, 183, 81, 0.3);
}

/* Light Mode Specific */
.light-mode .activity-item {
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.12) 0%, rgba(234, 183, 81, 0.04) 100%);
    border: 1px solid rgba(234, 183, 81, 0.25);
}

.light-mode .activity-item:hover {
    border-color: rgba(234, 183, 81, 0.5);
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.18) 0%, rgba(234, 183, 81, 0.08) 100%);
    box-shadow: 0 8px 16px rgba(234, 183, 81, 0.15);
}

.light-mode .activity-date {
    color: var(--primary-light);
}

.light-mode .activities-list::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
}

.light-mode .activities-list::-webkit-scrollbar-thumb {
    background: var(--primary-light);
}

.light-mode .activities-list::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}
/* In de style sectie, pas de category badges aan */
.category-lol {
    @apply bg-blue-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold;
}

.category-khll {
    @apply bg-amber-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold;
    /* Voor langere tekst, eventueel iets meer padding */
}

.category-activiteit {
    @apply bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold;
}

/* Responsive */
@media (max-width: 768px) {
    .activities-container {
        @apply px-4 py-8;
    }

    .content-grid {
        @apply grid-cols-1 gap-6;
    }

    .activity-item {
        @apply p-4;
    }

    .activity-title {
        @apply text-lg;
    }

    .activity-description {
        @apply text-xs;
    }

    .activity-date-wrapper {
        @apply gap-1;
    }
}
</style>
