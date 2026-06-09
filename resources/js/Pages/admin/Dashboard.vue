<template>
    <div class="dashboard">
        <div class="dashboard-container">
            <!-- SEO: H1 titel -->
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Welkom terug bij het beheerpanel</p>

            <!-- Stats Grid - Responsive grid -->
            <div class="stats-grid">
                <!-- Tijd Card -->
                <div class="stat-card">
                    <div class="stat-card__header">
                        <div class="stat-icon stat-icon--time">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="stat-card__title">Huidige tijd</h2>
                    </div>
                    <div class="stat-card__value stat-card__value--time">{{ currentTime }}</div>
                    <div class="stat-card__date">{{ currentDate }}</div>
                </div>

                <!-- Eerstvolgende Evenement Card -->
                <div class="stat-card">
                    <div class="stat-card__header">
                        <div class="stat-icon stat-icon--event">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h2 class="stat-card__title">Eerstvolgende evenement</h2>
                    </div>
                    <div v-if="nextEvent" class="event-info">
                        <div class="event-info__title">{{ nextEvent.title }}</div>
                        <div class="event-info__date">{{ formatEventDate(nextEvent.start_date) }}</div>
                        <div v-if="nextEvent.location" class="event-info__location">
                            <svg class="event-info__location-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ nextEvent.location }}</span>
                        </div>
                    </div>
                    <div v-else class="event-empty">
                        <p>Geen toekomstige evenementen</p>
                        <Link href="/admin/agenda" class="event-empty__link">
                            Maak een nieuw evenement aan
                        </Link>
                    </div>
                </div>

                <!-- Agenda Statistieken Card -->
                <div class="stat-card">
                    <div class="stat-card__header">
                        <div class="stat-icon stat-icon--stats">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h2 class="stat-card__title">Agenda statistieken</h2>
                    </div>
                    <div class="stats-list">
                        <div class="stats-list__item">
                            <span class="stats-list__label">Totaal items</span>
                            <span class="stats-list__number">{{ totalItems }}</span>
                        </div>
                        <div class="stats-list__item">
                            <span class="stats-list__label">Gepubliceerd</span>
                            <span class="stats-list__number stats-list__number--published">{{ publishedItems }}</span>
                        </div>
                        <div class="stats-list__item">
                            <span class="stats-list__label">Concepten</span>
                            <span class="stats-list__number stats-list__number--concept">{{ conceptItems }}</span>
                        </div>
                        <div class="stats-list__item">
                            <span class="stats-list__label">Geannuleerd</span>
                            <span class="stats-list__number stats-list__number--cancelled">{{ cancelledItems }}</span>
                        </div>
                    </div>
                </div>

                <!-- Snelle Acties Card -->
                <div class="stat-card">
                    <div class="stat-card__header">
                        <div class="stat-icon stat-icon--actions">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h2 class="stat-card__title">Snelle acties</h2>
                    </div>
                    <div class="actions-list">
                        <Link href="/admin/agenda" class="action-btn action-btn--primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Nieuw agenda item</span>
                        </Link>
                        <Link href="/admin/agenda" class="action-btn action-btn--secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <span>Agenda beheren</span>
                        </Link>
                        <Link v-if="isAdmin" href="/admin/users" class="action-btn action-btn--tertiary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Gebruikers beheren</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AdminLayout from "@/Layouts/AdminLayout.vue"
import axios from 'axios'

defineOptions({
    layout: AdminLayout
})

// ============================================
// Reactive State
// ============================================

/** Huidige ingelogde gebruiker */
const currentUser = ref(null)

/** Of de gebruiker admin rechten heeft */
const isAdmin = ref(false)

/** Huidige tijd (HH:MM:SS) */
const currentTime = ref('')

/** Huidige datum */
const currentDate = ref('')

/** Interval ID voor de klok */
let timeInterval = null

/** Alle agenda items uit de database */
const agendaItems = ref([])

/** Loading state voor agenda items */
const isLoading = ref(false)

// ============================================
// Computed Properties
// ============================================

/** Totaal aantal agenda items */
const totalItems = computed(() => agendaItems.value.length)

/** Aantal gepubliceerde items */
const publishedItems = computed(() => agendaItems.value.filter(item => item.status === 'published').length)

/** Aantal concept items */
const conceptItems = computed(() => agendaItems.value.filter(item => item.status === 'concept').length)

/** Aantal geannuleerde items */
const cancelledItems = computed(() => agendaItems.value.filter(item => item.status === 'cancelled').length)

/** Eerstvolgende toekomstige evenement */
const nextEvent = computed(() => {
    const now = new Date()
    const futureEvents = agendaItems.value
        .filter(item => item.status === 'published')
        .filter(item => new Date(item.start_date) >= now)
        .sort((a, b) => new Date(a.start_date) - new Date(b.start_date))

    return futureEvents[0] || null
})

// ============================================
// Methods
// ============================================

/** Haal huidige gebruiker op uit localStorage */
const fetchCurrentUser = () => {
    const storedUser = localStorage.getItem('user')
    if (storedUser) {
        currentUser.value = JSON.parse(storedUser)
        isAdmin.value = currentUser.value?.role === 'admin'
    }
}

/** Update de klok met huidige tijd en datum */
const updateClock = () => {
    const now = new Date()
    currentTime.value = now.toLocaleTimeString('nl-NL', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    })
    currentDate.value = now.toLocaleDateString('nl-NL', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

/** Formatteer datum voor weergave in evenement card */
const formatEventDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('nl-NL', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

/** Haal alle agenda items op via de API */
const fetchAgendaItems = async () => {
    isLoading.value = true
    try {
        const response = await axios.get('/api/agenda')
        agendaItems.value = response.data.data || []
    } catch (error) {
        console.error('Fout bij laden agenda items:', error)
    } finally {
        isLoading.value = false
    }
}

// ============================================
// Lifecycle Hooks
// ============================================

onMounted(() => {
    fetchCurrentUser()
    updateClock()
    timeInterval = setInterval(updateClock, 1000)
    fetchAgendaItems()
})

onUnmounted(() => {
    if (timeInterval) clearInterval(timeInterval)
})
</script>

<style scoped>
/* ============================================
   Dashboard Container
   ============================================ */
.dashboard {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--background) 0%, rgba(234, 183, 81, 0.05) 100%);
}

.dashboard-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 1.5rem;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.dashboard-subtitle {
    color: var(--text-muted);
    margin-bottom: 2rem;
    font-size: 0.875rem;
}

/* ============================================
   Stats Grid
   ============================================ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

/* ============================================
   Stat Card Base
   ============================================ */
.stat-card {
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.05) 0%, rgba(234, 183, 81, 0.02) 100%);
    border: 1px solid rgba(234, 183, 81, 0.15);
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    border-color: rgba(234, 183, 81, 0.3);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.stat-card__header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}

.stat-card__title {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-card__value {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 0.25rem;
}

.stat-card__value--time {
    font-family: monospace;
}

.stat-card__date {
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* ============================================
   Stat Icons
   ============================================ */
.stat-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon svg {
    width: 1.25rem;
    height: 1.25rem;
}

.stat-icon--time {
    background: rgba(59, 130, 246, 0.2);
    color: #3b82f6;
}

.stat-icon--event {
    background: rgba(234, 183, 81, 0.2);
    color: #eab308;
}

.stat-icon--stats {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.stat-icon--actions {
    background: rgba(139, 92, 246, 0.2);
    color: #8b5cf6;
}

/* ============================================
   Event Card
   ============================================ */
.event-info__title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.event-info__date {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-bottom: 0.5rem;
}

.event-info__location {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.event-info__location-icon {
    width: 0.875rem;
    height: 0.875rem;
}

.event-empty {
    text-align: center;
    padding: 1.5rem 0;
}

.event-empty p {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: 0.75rem;
}

.event-empty__link {
    color: var(--primary);
    font-size: 0.875rem;
    text-decoration: none;
    transition: color 0.2s;
}

.event-empty__link:hover {
    color: var(--primary-hover);
    text-decoration: underline;
}

/* ============================================
   Statistics List
   ============================================ */
.stats-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.stats-list__item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(234, 183, 81, 0.1);
}

.stats-list__item:last-child {
    border-bottom: none;
}

.stats-list__label {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.stats-list__number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-light);
}

.stats-list__number--published {
    color: #10b981;
}

.stats-list__number--concept {
    color: #eab308;
}

.stats-list__number--cancelled {
    color: #ef4444;
}

/* ============================================
   Actions List
   ============================================ */
.actions-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.action-btn svg {
    width: 1.125rem;
    height: 1.125rem;
}

.action-btn--primary {
    background: var(--primary);
    color: var(--background);
}

.action-btn--primary:hover {
    background: var(--primary-hover);
    transform: translateX(4px);
}

.action-btn--secondary {
    background: rgba(234, 183, 81, 0.1);
    color: var(--primary);
    border: 1px solid rgba(234, 183, 81, 0.2);
}

.action-btn--secondary:hover {
    background: rgba(234, 183, 81, 0.15);
    transform: translateX(4px);
}

.action-btn--tertiary {
    background: rgba(139, 92, 246, 0.1);
    color: #8b5cf6;
    border: 1px solid rgba(139, 92, 246, 0.2);
}

.action-btn--tertiary:hover {
    background: rgba(139, 92, 246, 0.15);
    transform: translateX(4px);
}

/* ============================================
   Responsive Design
   ============================================ */

/* Tablet (768px - 1024px) */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }

    .dashboard-title {
        font-size: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .stat-card {
        padding: 1rem;
    }

    .stat-card__value {
        font-size: 2rem;
    }

    .stats-list__number {
        font-size: 1.25rem;
    }
}

/* Mobile (320px - 768px) */
@media (max-width: 640px) {
    .stat-card__header {
        margin-bottom: 1rem;
    }

    .event-info__title {
        font-size: 1rem;
    }

    .action-btn {
        padding: 0.625rem 0.875rem;
        font-size: 0.75rem;
    }
}
</style>
