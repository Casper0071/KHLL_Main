<!-- Components/widgets/AgendaHome.vue -->
<script setup>
import { defineProps, ref, onMounted, computed } from 'vue'
import BaseTitle from '@/Components/Base/BaseTitle.vue'
import BaseButton from '@/Components/Base/BaseButton.vue'
import { useTranslations } from '@/composables/useTranslations'

const isLoading = ref(false)
const activitiesData = ref(null)
const { t } = useTranslations()

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
    },
    buttonText: {
        type: String,
        default: 'Bekijk alle activiteiten'
    },
    buttonLink: {
        type: String,
        default: '/agenda'
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
        '#3b82f6': { label: t.value?.agenda?.categorieen?.LOL ?? 'LOL', class: 'category-lol' },
        '#f59e0b': { label: t.value?.agenda?.categorieen?.KHLL ?? 'Koninklijke Harmonie', class: 'category-khll' },
        '#10b981': { label: t.value?.agenda?.categorieen?.Activiteiten ?? 'Activiteit', class: 'category-activiteit' }
    }
    return categories[color] || { label: t.value?.agenda?.categorieen?.Activiteiten ?? 'Activiteit', class: 'category-activiteit' }
}

// Filter alleen gepubliceerde items
const getPublishedItems = (items) => {
    if (!items) return []

    const now = new Date()

    return items.filter(item => {
        if (item.status !== 'published') return false
        if (item.published_at) {
            const publishDate = new Date(item.published_at)
            if (publishDate > now) return false
        }
        return true
    })
}

// Haal de eerstvolgende items op
const getUpcomingItems = (items) => {
    const published = getPublishedItems(items)
    const now = new Date()

    const upcoming = published.filter(item => {
        const startDate = new Date(item.start_date)
        return startDate >= now
    })

    upcoming.sort((a, b) => new Date(a.start_date) - new Date(b.start_date))
    return upcoming.slice(0, props.limit)
}

// Toon items
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

                        <a :href="activity.link" class="read-more-link">{{ t.value?.agenda?.agendaGrid?.meerInfo || 'Meer informatie' }} →</a>
                    </div>
                </div>

                <!-- All Activities Button - Gebruikt nu de BaseButton component -->
                <div class="button-section">
                    <BaseButton
                        :text="props.buttonText"
                        :link="props.buttonLink"
                        variant="outline"
                        size="lg"
                        rounded="lg"
                        :lightBtn="props.light"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.activities-container {
    width: 100%;
    padding: 3rem 2rem;
}

.light-mode .activities-list {
    background: transparent;
}

.title-section {
    margin-bottom: 3rem;
    text-align: center;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.image-section {
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}

.activity-image {
    width: 100%;
    height: auto;
    border-radius: 0.5rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    aspect-ratio: 16 / 10;
    object-fit: cover;
    transition: transform 0.5s ease-in-out;
}

.image-section:hover .activity-image {
    transform: scale(1.02);
}

.activities-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.activities-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-height: 800px;
    overflow-y: auto;
    padding-right: 0.75rem;
}

/* Loading State */
.loading-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    text-align: center;
}

.loading-state p {
    color: var(--text-light);
    margin-top: 1rem;
}

.loading-spinner {
    width: 2.5rem;
    height: 2.5rem;
    border: 4px solid var(--primary);
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Empty State */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    text-align: center;
}

.empty-icon {
    width: 4rem;
    height: 4rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.empty-state p {
    color: var(--text-muted);
    font-size: 1.125rem;
    margin-bottom: 0.5rem;
}

.empty-subtitle {
    font-size: 0.875rem;
}

/* Scrollbar Styling */
.activities-list::-webkit-scrollbar {
    width: 6px;
}

.activities-list::-webkit-scrollbar-track {
    background: rgba(234, 183, 81, 0.1);
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
    padding: 1.25rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease-out;
    animation: slideInUp 0.4s ease-out forwards;
    opacity: 0;
    background: rgba(18, 18, 24, 0.95);
    border: 1px solid rgba(234, 183, 81, 0.2);
}

.activity-item {
    background: #1a1a24;
}

.light-mode .activity-item {
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(234, 183, 81, 0.3);
}

.activity-item:hover {
    border-color: var(--primary);
    background: #1f1f2a;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transform: translateX(4px);
}

.light-mode .activity-item:hover {
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 8px 16px rgba(234, 183, 81, 0.15);
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
    margin-bottom: 0.75rem;
}

.activity-date-wrapper {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.activity-date {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    color: var(--primary);
    text-transform: uppercase;
}

.activity-time {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.activity-category {
    font-size: 0.75rem;
    padding: 0.125rem 0.5rem;
    border-radius: 9999px;
    font-weight: 600;
}

.category-lol {
    background-color: #3b82f6;
    color: white;
}

.category-khll {
    background-color: #f59e0b;
    color: white;
}

.category-activiteit {
    background-color: #10b981;
    color: white;
}

.activity-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 0.25rem;
    margin-bottom: 0;
    line-height: 1.3;
    color: var(--text-light);
}

.light-mode .activity-title {
    color: var(--text-dark);
}

.activity-description {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

/* Location */
.activity-location {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-bottom: 0.75rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.location-icon {
    width: 0.75rem;
    height: 0.75rem;
}

/* Read More Link */
.read-more-link {
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.2s;
    color: var(--primary);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.read-more-link:hover {
    color: var(--primary-hover);
    transform: translateX(2px);
}

.light-mode .read-more-link {
    color: var(--primary);
}

/* Button Section */
.button-section {
    display: flex;
    justify-content: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(234, 183, 81, 0.2);
    z-index: 100;
}

/* Responsive */
@media (max-width: 768px) {
    .activities-container {
        padding: 2rem 1rem;
    }

    .content-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .activity-item {
        padding: 1rem;
    }

    .activity-title {
        font-size: 1.125rem;
    }

    .activity-description {
        font-size: 0.75rem;
    }

    .activity-date-wrapper {
        gap: 0.25rem;
    }
}

@media (max-width: 480px) {
    .activities-container {
        padding: 1.5rem 0.75rem;
    }

    .activity-item {
        padding: 0.875rem;
    }
}
</style>s
