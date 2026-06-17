<template>
    <div v-intersect="'animate'" class="agenda-widget" :class="{ 'agenda-widget--light': props.light }">
        <!-- Title Section -->
        <div class="agenda-widget__header">
            <BaseTitle :title="props.title" :light="props.light" align="center" />
        </div>

        <!-- Main Content -->
        <div class="agenda-widget__grid">
            <!-- Image Section -->
            <div class="agenda-widget__image-wrapper">
                <img :src="props.image" :alt="imageAlt" class="agenda-widget__image" />
            </div>

            <!-- Activities List Section -->
            <div class="agenda-widget__content">
                <div class="agenda-widget__list">
                    <!-- Loading State -->
                    <div v-if="isLoading" class="agenda-widget__loading">
                        <div class="agenda-widget__spinner"></div>
                        <p>Activiteiten laden...</p>
                    </div>

                    <!-- Empty State -->
                    <div v-else-if="displayActivities.length === 0" class="agenda-widget__empty">
                        <svg class="agenda-widget__empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p>Er zijn momenteel geen geplande activiteiten</p>
                        <p class="agenda-widget__empty-subtitle">Kom binnenkort terug voor nieuwe activiteiten</p>
                    </div>

                    <!-- Activities Items -->
                    <div v-else v-for="(activity, index) in displayActivities" :key="activity.id" class="agenda-widget__item" :style="{ animationDelay: `${index * 0.05}s` }">
                        <div class="agenda-widget__item-header">
                            <div class="agenda-widget__item-date-wrapper">
                                <span class="agenda-widget__item-date">{{ activity.date }}</span>
                                <span class="agenda-widget__item-time">{{ activity.time }}</span>
                                <span class="agenda-widget__item-category" :class="activity.category.class">
                                    {{ activity.category.label }}
                                </span>
                            </div>
                            <h3 class="agenda-widget__item-title">{{ activity.title }}</h3>
                        </div>

                        <p class="agenda-widget__item-description">{{ activity.description }}</p>

                        <div v-if="activity.location" class="agenda-widget__item-location">
                            <svg class="agenda-widget__item-location-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ activity.location }}</span>
                        </div>

                        <a :href="activity.link" class="agenda-widget__read-more">
                            {{ t.value?.agenda?.agendaGrid?.meerInfo || 'Meer informatie' }} →
                        </a>
                    </div>
                </div>

                <!-- All Activities Button -->
                <div class="agenda-widget__button-wrapper">
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

<script setup>
import {computed, defineProps, onMounted, ref} from 'vue'
import BaseTitle from '@/Components/Base/BaseTitle.vue'
import BaseButton from '@/Components/Base/BaseButton.vue'
import {useTranslations} from '@/composables/useTranslations'

// ============================================
// Props
// ============================================

const props = defineProps({
    title: {
        type: String,
        default: 'Eerstvolgende Activiteiten'
    },
    image: {
        type: String,
        default: 'https://via.placeholder.com/400x300'
    },
    imageAlt: {
        type: String,
        default: ''
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
        default: '/Agenda'
    }
})

// ============================================
// Composables
// ============================================

const isLoading = ref(false)
const activitiesData = ref(null)
const { t } = useTranslations()

// ============================================
// Helper Functions
// ============================================

const formatDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('nl-NL', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const formatTime = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleTimeString('nl-NL', {
        hour: '2-digit',
        minute: '2-digit'
    })
}

const getCategoryInfo = (categoryKey) => {
    const categories = {
        'lol': { label: t.value?.agenda?.categorieen?.LOL ?? 'LOL', class: 'category-lol' },
        'khll': { label: t.value?.agenda?.categorieen?.KHLL ?? 'Koninklijke Harmonie', class: 'category-khll' },
        'activiteiten': { label: t.value?.agenda?.categorieen?.Activiteiten ?? 'Activiteit', class: 'category-activiteit' }
    }
    return categories[categoryKey] || { label: t.value?.agenda?.categorieen?.Activiteiten ?? 'Activiteit', class: 'category-activiteit' }
}

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

// ============================================
// Computed Properties
// ============================================

const displayActivities = computed(() => {
    if (activitiesData.value && activitiesData.value.data) {
        const upcoming = getUpcomingItems(activitiesData.value.data)

        return upcoming.map(item => ({
            id: item.id,
            date: formatDate(item.start_date),
            time: formatTime(item.start_date),
            title: item.title,
            description: item.description || 'Geen beschrijving beschikbaar',
            link: `/Agenda/${item.id}`,
            categoryKey: item.categoryKey,
            location: item.location,
            category: getCategoryInfo(item.categoryKey)
        }))
    }
    return props.activities
})

// ============================================
// Lifecycle Hooks
// ============================================

onMounted(async () => {
    if (props.fetchUrl) {
        isLoading.value = true
        try {
            const response = await fetch(props.fetchUrl)
            if (response.ok) {
                activitiesData.value = await response.json()
            }
        } catch (error) {
            console.error('Fout bij het laden van activiteiten:', error)
        } finally {
            isLoading.value = false
        }
    }
})
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.agenda-widget {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.agenda-widget.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   AGENDA WIDGET CONTAINER
   ============================================ */

.agenda-widget {
    width: 100%;
    padding: 3rem 2rem;
}

.agenda-widget--light .agenda-widget__list {
    background: transparent;
}

/* ============================================
   HEADER SECTION
   ============================================ */

.agenda-widget__header {
    margin-bottom: 3rem;
    text-align: center;
}

/* ============================================
   MAIN GRID
   ============================================ */

.agenda-widget__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

/* ============================================
   IMAGE SECTION
   ============================================ */

.agenda-widget__image-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}

.agenda-widget__image {
    width: 100%;
    height: auto;
    border-radius: 0.5rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    aspect-ratio: 16 / 10;
    object-fit: cover;
    transition: transform 0.5s ease-in-out;
}

.agenda-widget__image-wrapper:hover .agenda-widget__image {
    transform: scale(1.02);
}

/* ============================================
   CONTENT SECTION
   ============================================ */

.agenda-widget__content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.agenda-widget__list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-height: 800px;
    overflow-y: auto;
    padding-right: 0.75rem;
}

/* ============================================
   LOADING STATE
   ============================================ */

.agenda-widget__loading {
    z-index: 10;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    text-align: center;
}

.agenda-widget__loading p {
    color: var(--text-light);
    margin-top: 1rem;
}

.agenda-widget__spinner {
    width: 2.5rem;
    height: 2.5rem;
    border: 4px solid var(--primary);
    border-top-color: transparent;
    border-radius: 50%;
    animation: agenda-widget-spin 1s linear infinite;
}

@keyframes agenda-widget-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* ============================================
   EMPTY STATE
   ============================================ */

.agenda-widget__empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    text-align: center;
}

.agenda-widget__empty-icon {
    width: 4rem;
    height: 4rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.agenda-widget__empty p {
    color: var(--text-muted);
    font-size: 1.125rem;
    margin-bottom: 0.5rem;
}

.agenda-widget__empty-subtitle {
    font-size: 0.875rem;
}

/* ============================================
   SCROLLBAR STYLING
   ============================================ */

.agenda-widget__list::-webkit-scrollbar {
    width: 6px;
}

.agenda-widget__list::-webkit-scrollbar-track {
    background: rgba(234, 183, 81, 0.1);
    border-radius: 10px;
}

.agenda-widget__list::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 10px;
}

.agenda-widget__list::-webkit-scrollbar-thumb:hover {
    background: var(--primary-hover);
}

/* ============================================
   ACTIVITY ITEM
   ============================================ */

.agenda-widget__item {
    padding: 1.25rem;
    border-radius: 0.75rem;
    transition: all 0.3s ease-out;
    opacity: 0;
    background: rgba(18, 18, 24, 0.95);
    border: 1px solid rgba(234, 183, 81, 0.2);
    animation: agenda-widget-item-slide-up 0.4s ease-out forwards;
}

.agenda-widget__item {
    background: #1a1a24;
}

.agenda-widget--light .agenda-widget__item {
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(234, 183, 81, 0.3);
}

.agenda-widget__item:hover {
    border-color: var(--primary);
    background: #1f1f2a;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transform: translateX(4px);
}

.agenda-widget--light .agenda-widget__item:hover {
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 8px 16px rgba(234, 183, 81, 0.15);
}

@keyframes agenda-widget-item-slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ============================================
   ACTIVITY ITEM HEADER
   ============================================ */

.agenda-widget__item-header {
    margin-bottom: 0.75rem;
}

.agenda-widget__item-date-wrapper {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.agenda-widget__item-date {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    color: var(--primary);
    text-transform: uppercase;
}

.agenda-widget__item-time {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.agenda-widget__item-category {
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

.agenda-widget__item-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 0.25rem;
    margin-bottom: 0;
    line-height: 1.3;
    color: var(--text-light);
}

.agenda-widget--light .agenda-widget__item-title {
    color: var(--text-dark);
}

.agenda-widget__item-description {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

/* ============================================
   LOCATION
   ============================================ */

.agenda-widget__item-location {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-bottom: 0.75rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.agenda-widget__item-location-icon {
    width: 0.75rem;
    height: 0.75rem;
}

/* ============================================
   READ MORE LINK
   ============================================ */

.agenda-widget__read-more {
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.2s;
    color: var(--primary);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.agenda-widget__read-more:hover {
    color: var(--primary-hover);
    transform: translateX(2px);
}

.agenda-widget--light .agenda-widget__read-more {
    color: var(--primary);
}

/* ============================================
   BUTTON SECTION
   ============================================ */

.agenda-widget__button-wrapper {
    display: flex;
    justify-content: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(234, 183, 81, 0.2);
    z-index: 100;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

@media (max-width: 768px) {
    .agenda-widget {
        padding: 2rem 1rem;
    }

    .agenda-widget__grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .agenda-widget__item {
        padding: 1rem;
    }

    .agenda-widget__item-title {
        font-size: 1.125rem;
    }

    .agenda-widget__item-description {
        font-size: 0.75rem;
    }

    .agenda-widget__item-date-wrapper {
        gap: 0.25rem;
    }
}

@media (max-width: 480px) {
    .agenda-widget {
        padding: 1.5rem 0.75rem;
    }

    .agenda-widget__item {
        padding: 0.875rem;
    }
}
</style>
