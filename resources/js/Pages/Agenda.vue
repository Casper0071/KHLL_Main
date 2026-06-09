<template>
    <div class="agenda-page">
        <!-- Header Hero voor agenda pagina -->
        <HeaderHeroBgImage
            :title="t.agenda?.title"
            buttonText="Bekijk agenda"
            buttonVariant="primary"
            imageSrc="img/agenda/header.jpg"
            :overlay-opacity="0.5"
            minHeight="400px"
        />

        <!-- Filter sectie -->
        <div class="filter-section">
            <div class="filter-container">
                <div class="filter-group">
                    <label class="filter-label">{{ t.agenda.categorie }}</label>
                    <div class="category-filters">
                        <button
                            v-for="category in categories"
                            :key="category.value"
                            @click="selectedCategory = category.value"
                            class="category-btn"
                            :class="{
                                'active-lol': selectedCategory === category.value && category.value === 'lol',
                                'active-khll': selectedCategory === category.value && category.value === 'khll',
                                'active-activiteiten': selectedCategory === category.value && category.value === 'activiteiten',
                                'active-all': selectedCategory === category.value && category.value === 'all'
                            }"
                        >
                            <span :class="category.class">{{ category.label }}</span>
                        </button>
                    </div>
                </div>

                <div class="filter-group">
                    <label class="filter-label">{{ t.agenda.sorteer }}</label>
                    <select v-model="sortOrder" class="filter-select">
                        <option value="asc">{{ t.agenda.Eerstvolgende }}</option>
                        <option value="desc">{{ t.agenda.Laatste }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Agenda Items Grid -->
        <div class="agenda-grid-container">
            <div v-if="isLoading" class="loading-state">
                <div class="loading-spinner"></div>
                <p>{{ t.agenda.agendaGrid.itemsLaden }}</p>
            </div>

            <div v-else-if="filteredAndSortedItems.length === 0" class="empty-state">
                <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p>{{ t.agenda.agendaGrid.geenitemsGevonden }}</p>
                <p class="empty-subtitle">{{ t.agenda.agendaGrid.komLaterTerug }}</p>
            </div>

            <div v-else class="agenda-grid">
                <div
                    v-for="item in filteredAndSortedItems"
                    :key="item.id"
                    class="agenda-card"
                    :class="{
                        'card-lol': item.categoryKey === 'lol',
                        'card-khll': item.categoryKey === 'khll',
                        'card-activiteiten': item.categoryKey === 'activiteiten'
                    }"
                >
                    <div class="card-header" :style="{ backgroundColor: getCategoryColor(item.categoryKey) }">
                        <div class="card-date">
                            <span class="date-day">{{ formatDay(item.start_date) }}</span>
                            <span class="date-month">{{ formatMonth(item.start_date) }}</span>
                        </div>
                        <div class="card-category" :class="getCategoryBadgeClass(item.categoryKey)">
                            {{ getCategoryLabel(item.categoryKey) }}
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
                            {{ t.agenda.agendaGrid.meerInfo }}
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
                {{ t.agenda.agendaGrid.terugNaarHome }}
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

// Categorieën met categoryKey waarden
const categories = computed(() => [
    { value: 'all', label: t.value?.agenda?.categorieen?.alles ?? 'Alles', class: 'category-all' },
    { value: 'lol', label: t.value?.agenda?.categorieen?.LOL ?? 'LOL', class: 'category-lol' },
    { value: 'khll', label: t.value?.agenda?.categorieen?.KHLL ?? 'Koninklijke Harmonie', class: 'category-khll' },
    { value: 'activiteiten', label: t.value?.agenda?.categorieen?.Activiteiten ?? 'Activiteiten', class: 'category-activiteiten' }
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

// Categorie kleuren op basis van categoryKey
const getCategoryColor = (categoryKey) => {
    const colors = {
        'lol': '#3b82f6',
        'khll': '#f59e0b',
        'activiteiten': '#10b981'
    }
    return colors[categoryKey] || '#888888'
}

const getCategoryLabel = (categoryKey) => {
    const labels = {
        'lol': t.value?.agenda?.categorieen?.LOL ?? 'LOL',
        'khll': t.value?.agenda?.categorieen?.KHLL ?? 'Koninklijke Harmonie',
        'activiteiten': t.value?.agenda?.categorieen?.Activiteiten ?? 'Activiteit'
    }
    return labels[categoryKey] || 'Activiteit'
}

const getCategoryBadgeClass = (categoryKey) => {
    const classes = {
        'lol': 'badge-lol',
        'khll': 'badge-khll',
        'activiteiten': 'badge-activiteiten'
    }
    return classes[categoryKey] || 'badge-activiteiten'
}

// Check of een item nog actief is (einddatum is nog niet verstreken)
const isItemActive = (item) => {
    const now = new Date()
    const endDate = item.end_date ? new Date(item.end_date) : new Date(item.start_date)
    return endDate >= now
}

// Filter en sorteer items - ALLEEN toekomstige/actieve items
const filterAndSortItems = () => {
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

        // Check of het item nog niet verlopen is (end_date of start_date in de toekomst)
        const endDate = item.end_date ? new Date(item.end_date) : new Date(item.start_date)
        if (endDate < now) return false

        return true
    })

    // Filter op categorie (gebruik categoryKey)
    if (selectedCategory.value && selectedCategory.value !== 'all') {
        items = items.filter(item => item.categoryKey === selectedCategory.value)
    }

    // Sorteer
    if (sortOrder.value === 'asc') {
        items.sort((a, b) => new Date(a.start_date) - new Date(b.start_date))
    } else {
        items.sort((a, b) => new Date(b.start_date) - new Date(a.start_date))
    }

    return items
}

const filteredAndSortedItems = computed(() => filterAndSortItems())

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
/* ============================================
   PAGE CONTAINER
   ============================================ */
.agenda-page {
    position: relative;
    isolation: isolate;
    overflow-x: hidden;
    background: var(--background);
}

/* ============================================
   FILTER SECTION
   ============================================ */
.filter-section {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 3rem 1rem;
    position: relative;
    z-index: 2;
}

.filter-container {
    max-width: 1280px;
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-label {
    color: var(--text-muted);
    font-size: 0.875rem;
    font-weight: 500;
}

.category-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.category-btn {
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
    border: 1px solid rgba(234, 183, 81, 0.3);
    cursor: pointer;
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

.active-activiteiten {
    background: #10b981;
    color: white;
    border-color: #10b981;
}

.filter-select {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.1);
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

/* ============================================
   AGENDA GRID CONTAINER
   ============================================ */
.agenda-grid-container {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 2rem 1rem;
    position: relative;
    z-index: 2;
}

.agenda-grid {
    max-width: 1280px;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 768px) {
    .agenda-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .agenda-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* ============================================
   AGENDA CARD
   ============================================ */
.agenda-card {
    border-radius: 0.75rem;
    overflow: hidden;
    transition: all 0.3s ease;
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

.card-activiteiten:hover {
    border-color: #10b981;
}

/* Card Header */
.card-header {
    position: relative;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-height: 100px;
}

.card-date {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(4px);
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    text-align: center;
}

.date-day {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
}

.date-month {
    display: block;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
}

.card-category {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-lol {
    background: #3b82f6;
    color: white;
}

.badge-khll {
    background: #f59e0b;
    color: white;
}

.badge-activiteiten {
    background: #10b981;
    color: white;
}

/* Card Body */
.card-body {
    padding: 1.25rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 0.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-description {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: 1rem;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-details {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.detail-icon {
    width: 0.75rem;
    height: 0.75rem;
}

/* Read More Button */
.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.3s ease;
    color: var(--primary);
    text-decoration: none;
}

.read-more-btn:hover {
    gap: 0.5rem;
    color: var(--primary-hover);
}

.btn-icon {
    width: 1rem;
    height: 1rem;
}

/* ============================================
   LOADING STATE
   ============================================ */
.loading-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 5rem 0;
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

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ============================================
   EMPTY STATE
   ============================================ */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 5rem 0;
    text-align: center;
}

.empty-icon {
    width: 5rem;
    height: 5rem;
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

/* ============================================
   BACK HOME SECTION
   ============================================ */
.back-home-section {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 3rem 1rem;
    position: relative;
    z-index: 2;
}

.back-home-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.1) 0%, rgba(234, 183, 81, 0.05) 100%);
    border: 1px solid rgba(234, 183, 81, 0.3);
    color: var(--text-light);
    text-decoration: none;
}

.back-home-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateX(-4px);
}

.back-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .filter-container {
        flex-direction: column;
        align-items: stretch;
    }

    .category-filters {
        justify-content: center;
    }

    .agenda-grid {
        gap: 1rem;
    }

    .card-header {
        padding: 0.75rem;
        min-height: 80px;
    }

    .card-body {
        padding: 1rem;
    }

    .card-title {
        font-size: 1.125rem;
    }
}

@media (max-width: 640px) {
    .filter-section {
        padding: 1.5rem 0.75rem;
    }

    .category-btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }
}
</style>
