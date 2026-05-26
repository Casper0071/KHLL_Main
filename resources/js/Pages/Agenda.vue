<!-- Pages/Agenda.vue -->
<template>
    <div class="bg-background agendaPage">


        <!-- Header Hero voor agenda pagina -->
        <HeaderHeroBgImage
            :title="t.agenda?.title"
            buttonText="Bekijk agenda"
            buttonVariant="primary"
            imageSrc="img/test.jpg"
            :overlay-opacity="0.5"
            minHeight="400px"
        />

        <!-- Filter sectie -->
        <div class="filter-section">
            <div class="filter-container">
                <div class="filter-group">
                    <label class="filter-label">{{t.agenda.categorie}}</label>
                    <div class="category-filters">
                        <button
                            v-for="category in categories"
                            :key="category.value"
                            @click="selectedCategory = category.value"
                            class="category-btn"
                            :class="{
                                'active-lol': selectedCategory === category.value && category.value === '#3b82f6',
                                'active-khll': selectedCategory === category.value && category.value === '#f59e0b',
                                'active-activiteit': selectedCategory === category.value && category.value === '#10b981',
                                'active-all': selectedCategory === category.value && category.value === 'all'
                            }"
                        >
                            <span :class="category.class">{{ category.label }}</span>
                        </button>
                    </div>
                </div>

                <div class="filter-group">
                    <label class="filter-label ">{{t.agenda.sorteer}}</label>
                    <select v-model="sortOrder" class="filter-select">
                        <option value="asc">{{t.agenda.Eerstvolgende}}</option>
                        <option value="desc">{{t.agenda.Laatste}}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Agenda Items Grid -->
        <div class="agenda-grid-container">
            <div v-if="isLoading" class="loading-state">
                <div class="loading-spinner"></div>
                <p>{{t.agenda.agendaGrid.itemsLaden}}</p>
            </div>

            <div v-else-if="filteredAndSortedItems.length === 0" class="empty-state">
                <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p>{{t.agenda.agendaGrid.geenitemsGevonden}}</p>
                <p class="empty-subtitle">{{t.agenda.agendaGrid.komLaterTerug}}</p>
            </div>

            <div v-else class="agenda-grid">
                <div
                    v-for="item in filteredAndSortedItems"
                    :key="item.id"
                    class="agenda-card"
                    :class="{
                        'card-lol': item.color === '#3b82f6',
                        'card-khll': item.color === '#f59e0b',
                        'card-activiteit': item.color === '#10b981'
                    }"
                >
                    <div class="card-header" :style="{ backgroundColor: item.color }">
                        <div class="card-date">
                            <span class="date-day">{{ formatDay(item.start_date) }}</span>
                            <span class="date-month">{{ formatMonth(item.start_date) }}</span>
                        </div>
                        <div class="card-category" :class="getCategoryClass(item.color)">
                            {{ getCategoryLabel(item.color) }}
                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="card-title">{{ item.title }}</h3>
                        <p class="card-description">{{ item.description || 'Geen beschrijving beschikbaar' }}</p>

                        <div class="card-details">
                            <div class="detail-item">
                                <svg class="detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ formatTime(item.start_date) }}</span>
                            </div>
                            <div v-if="item.location" class="detail-item">
                                <svg class="detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ item.location }}</span>
                            </div>
                        </div>

                        <a :href="`/agenda/${item.id}`" class="read-more-btn">
                            {{t.agenda.agendaGrid.meerInfo}}
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terug naar home button -->
        <div class="back-home-section">
            <a href="/" class="back-home-btn">
                <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{t.agenda.agendaGrid.terugNaarHome}}
            </a>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import HeaderHeroBgImage from "@/Components/headers/HeaderHero_bg_image.vue"
import { useTranslations } from '@/composables/useTranslations'

defineOptions({
    layout: MainLayout
})

const { t } = useTranslations()
const isLoading = ref(false)
const agendaItems = ref([])
const selectedCategory = ref('all')
const sortOrder = ref('asc')

const categories = computed(() => [
    { value: 'all', label: t.value?.agenda?.categorieen?.alles ?? 'Alles', class: 'category-all' },
    { value: '#3b82f6', label: t.value?.agenda?.categorieen?.LOL ?? 'LOL', class: 'category-lol' },
    { value: '#f59e0b', label: t.value?.agenda?.categorieen?.KHLL ?? 'Koninklijke Harmonie', class: 'category-khll' },
    { value: '#10b981', label: t.value?.agenda?.categorieen?.Activiteiten ?? 'Activiteiten', class: 'category-activiteit' }
])

// Helper functies
const formatDay = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.getDate()
}

const formatMonth = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('nl-NL', { month: 'short' }).replace('.', '')
}

const formatTime = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleTimeString('nl-NL', { hour: '2-digit', minute: '2-digit' })
}

const getCategoryLabel = (color) => {
    const labels = {
        '#3b82f6': t.value?.agenda?.categorieen?.LOL ?? 'LOL',
        '#f59e0b': t.value?.agenda?.categorieen?.KHLL ?? 'Koninklijke Harmonie',
        '#10b981': t.value?.agenda?.categorieen?.Activiteiten ?? 'Activiteit'
    }
    return labels[color] || 'Activiteit'
}

const getCategoryClass = (color) => {
    const classes = {
        '#3b82f6': 'badge-lol',
        '#f59e0b': 'badge-khll',
        '#10b981': 'badge-activiteit'
    }
    return classes[color] || 'badge-activiteit'
}

// Filter alleen gepubliceerde items
const getPublishedItems = (items) => {
    if (!items) return []
    return items.filter(item => {
        if (item.status !== 'published') return false
        if (item.published_at && new Date(item.published_at) > new Date()) return false
        return true
    })
}

// Filter op categorie
const filterByCategory = (items) => {
    if (selectedCategory.value === 'all') return items
    return items.filter(item => item.color === selectedCategory.value)
}

// Sorteer items
const sortByDate = (items) => {
    return [...items].sort((a, b) => {
        const dateA = new Date(a.start_date)
        const dateB = new Date(b.start_date)
        if (sortOrder.value === 'asc') {
            return dateA - dateB
        } else {
            return dateB - dateA
        }
    })
}

// Gecombineerde filtered en gesorteerde items
const filteredAndSortedItems = computed(() => {
    if (!agendaItems.value) return []

    const now = new Date()

    let items = agendaItems.value.filter(item => {
        // Status moet published zijn
        if (item.status !== 'published') return false

        // Check publicatiedatum
        if (item.published_at) {
            const publishDate = new Date(item.published_at)
            if (publishDate > now) return false
        }

        return true
    })

    // Filter op categorie
    if (selectedCategory.value && selectedCategory.value !== 'all') {
        items = items.filter(item => item.color === selectedCategory.value)
    }

    // Sorteer
    if (sortOrder.value === 'asc') {
        items.sort((a, b) => new Date(a.start_date) - new Date(b.start_date))
    } else {
        items.sort((a, b) => new Date(b.start_date) - new Date(a.start_date))
    }

    return items
})

// Fetch agenda items
const fetchAgendaItems = async () => {
    isLoading.value = true
    try {
        const response = await fetch('/api/agenda')
        if (response.ok) {
            const data = await response.json()
            agendaItems.value = data.data || []
        }
    } catch (error) {
        console.error('Fout bij laden agenda:', error)
    } finally {
        isLoading.value = false
    }
}

onMounted(() => {
    fetchAgendaItems()
})
</script>

<style scoped>
.agendaPage {
    position: relative;
    isolation: isolate;
    overflow-x: hidden;
}

.backgroundMusicNotes {
    position: absolute;
    width: 100%;
    overflow: hidden;
    z-index: 0;
    pointer-events: none;
}

/* Filter Section */
.filter-section {
    @apply w-full flex justify-center py-12 px-4;
    position: relative;
    z-index: 2;
}

.filter-container {
    @apply max-w-7xl w-full flex flex-wrap justify-between items-center gap-6;
}

.filter-group {
    @apply flex flex-col gap-2;
}

.filter-label {
    @apply text-text-muted text-sm font-medium;
}

.category-filters {
    @apply flex flex-wrap gap-3;
}

.category-btn {
    @apply px-4 py-2 rounded-full text-sm font-medium transition-all duration-300;
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
    border: 1px solid rgba(234, 183, 81, 0.3);
}

.category-btn:hover {
    transform: translateY(-2px);
    border-color: var(--primary);
}

.active-all {
    background: var(--primary);
    color: var(--background);
    border-color: var(--primary);
}

.active-lol {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.active-khll {
    background: #f59e0b;
    color: white;
    border-color: #f59e0b;
}

.active-activiteit {
    background: #10b981;
    color: white;
    border-color: #10b981;
}

.filter-select {
    @apply px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300;
    background: rgba(255, 255, 255, 0.1 ) ;
    color: var(--text-light);
    border: 1px solid rgba(234, 183, 81, 0.3);
    cursor: pointer;
}
.filter-select option {
    color: var(--text-dark);

}

.filter-select:hover {
    border-color: var(--primary);
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary);
}

/* Agenda Grid Container */
.agenda-grid-container {
    @apply w-full flex justify-center px-4 py-8;
    position: relative;
    z-index: 2;
}

.agenda-grid {
    @apply max-w-7xl w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8;
}

/* Agenda Card */
.agenda-card {
    @apply rounded-xl overflow-hidden transition-all duration-300;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.08) 0%, rgba(234, 183, 81, 0.02) 100%);
    border: 1px solid rgba(234, 183, 81, 0.15);
    backdrop-filter: blur(10px);
}

.agenda-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(234, 183, 81, 0.4);
}

.card-lol:hover {
    border-color: #3b82f6;
}

.card-khll:hover {
    border-color: #f59e0b;
}

.card-activiteit:hover {
    border-color: #10b981;
}

/* Card Header */
.card-header {
    @apply relative p-4 flex justify-between items-center;
    min-height: 100px;
}

.card-date {
    @apply bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2 text-center;
}

.date-day {
    @apply block text-2xl font-bold text-white;
}

.date-month {
    @apply block text-xs text-white/80 uppercase;
}

.card-category {
    @apply px-3 py-1 rounded-full text-xs font-semibold;
}

.badge-lol {
    background: #3b82f6;
    color: white;
}

.badge-khll {
    background: #f59e0b;
    color: white;
}

.badge-activiteit {
    background: #10b981;
    color: white;
}

/* Card Body */
.card-body {
    @apply p-5;
}

.card-title {
    @apply text-xl font-bold text-text-light mb-2 line-clamp-2;
}

.card-description {
    @apply text-text-muted text-sm mb-4 line-clamp-3;
}

.card-details {
    @apply flex flex-wrap gap-3 mb-4;
}

.detail-item {
    @apply flex items-center gap-1 text-xs text-text-muted;
}

.detail-icon {
    @apply w-3 h-3;
}

/* Read More Button */
.read-more-btn {
    @apply inline-flex items-center gap-2 text-sm font-semibold transition-all duration-300;
    color: var(--primary);
}

.read-more-btn:hover {
    gap: 4px;
    color: var(--primary-hover);
}

.btn-icon {
    @apply w-4 h-4;
}

/* Loading State */
.loading-state {
    @apply flex flex-col items-center justify-center py-20;
}

.loading-spinner {
    @apply w-12 h-12 border-4 border-primary border-t-transparent rounded-full mb-4;
    animation: spin 1s linear infinite;
}

/* Empty State */
.empty-state {
    @apply flex flex-col items-center justify-center py-20 text-center;
}

.empty-icon {
    @apply w-20 h-20 text-text-muted mb-4;
}

.empty-state p {
    @apply text-text-muted text-lg mb-2;
}

.empty-subtitle {
    @apply text-sm text-text-muted;
}

/* Back Home Section */
.back-home-section {
    @apply w-full flex justify-center py-12;
    position: relative;
    z-index: 2;
}

.back-home-btn {
    @apply inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-all duration-300;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.1) 0%, rgba(234, 183, 81, 0.05) 100%);
    border: 1px solid rgba(234, 183, 81, 0.3);
    color: var(--text-light);
}

.back-home-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateX(-4px);
}

.back-icon {
    @apply w-5 h-5;
}

/* Animations */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Line Clamp */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-container {
        @apply flex-col items-stretch;
    }

    .category-filters {
        @apply justify-center;
    }

    .agenda-grid {
        @apply gap-4;
    }

    .card-header {
        @apply p-3;
        min-height: 80px;
    }

    .card-body {
        @apply p-4;
    }

    .card-title {
        @apply text-lg;
    }
}

@media (max-width: 640px) {
    .filter-section {
        @apply py-6;
    }

    .category-btn {
        @apply px-3 py-1.5 text-xs;
    }
}
</style>
