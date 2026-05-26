<!-- Pages/admin/Dashboard.vue -->
<template>
    <div class="dashboard">
        <div class="dashboard-container">
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Welkom terug bij het beheerpanel</p>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <!-- Tijd Card -->
                <div class="stat-card time-card">
                    <div class="stat-card-header">
                        <div class="stat-icon time-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="stat-title">Huidige tijd</h3>
                    </div>
                    <div class="stat-value time-value">{{ currentTime }}</div>
                    <div class="stat-date">{{ currentDate }}</div>
                </div>

                <!-- Eerstvolgende Evenement Card -->
                <div class="stat-card event-card">
                    <div class="stat-card-header">
                        <div class="stat-icon event-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="stat-title">Eerstvolgende evenement</h3>
                    </div>
                    <div v-if="nextEvent" class="event-info">
                        <div class="event-title">{{ nextEvent.title }}</div>
                        <div class="event-date">{{ formatEventDate(nextEvent.start_date) }}</div>
                        <div v-if="nextEvent.location" class="event-location">
                            <svg class="location-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ nextEvent.location }}
                        </div>
                    </div>
                    <div v-else class="no-event">
                        <p>Geen toekomstige evenementen</p>
                        <router-link to="/admin/agenda" class="create-event-link">
                            Maak een nieuw evenement aan
                        </router-link>
                    </div>
                </div>

                <!-- Agenda Statistieken Card -->
                <div class="stat-card stats-card">
                    <div class="stat-card-header">
                        <div class="stat-icon stats-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="stat-title">Agenda statistieken</h3>
                    </div>
                    <div class="stats-list">
                        <div class="stat-item">
                            <span class="stat-label">Totaal items</span>
                            <span class="stat-number">{{ totalItems }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Gepubliceerd</span>
                            <span class="stat-number published">{{ publishedItems }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Concepten</span>
                            <span class="stat-number concept">{{ conceptItems }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Geannuleerd</span>
                            <span class="stat-number cancelled">{{ cancelledItems }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import {usePage, router, Link} from '@inertiajs/vue3'
import AdminLayout from "@/Layouts/AdminLayout.vue"
import axios from 'axios'

defineOptions({
    layout: AdminLayout
})

// Gebruikers data
const page = usePage()
const user = computed(() => page.props.auth?.user || JSON.parse(localStorage.getItem('user') || '{}'))
const isAdmin = computed(() => user.value?.role === 'admin')

// Tijd data
const currentTime = ref('')
const currentDate = ref('')
let timeInterval = null

// Agenda data
const agendaItems = ref([])
const loading = ref(false)

// Berekende statistieken
const totalItems = computed(() => agendaItems.value.length)
const publishedItems = computed(() => agendaItems.value.filter(item => item.status === 'published').length)
const conceptItems = computed(() => agendaItems.value.filter(item => item.status === 'concept').length)
const cancelledItems = computed(() => agendaItems.value.filter(item => item.status === 'cancelled').length)

// Eerstvolgende evenement
const nextEvent = computed(() => {
    const now = new Date()
    const futureEvents = agendaItems.value
        .filter(item => item.status === 'published')
        .filter(item => new Date(item.start_date) >= now)
        .sort((a, b) => new Date(a.start_date) - new Date(b.start_date))

    return futureEvents[0] || null
})

// Update tijd
const updateTime = () => {
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

// Formatteer datum voor evenement
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

// Haal agenda items op
const fetchAgendaItems = async () => {
    loading.value = true
    try {
        const response = await axios.get('/api/agenda')
        agendaItems.value = response.data.data || []
    } catch (error) {
        console.error('Error fetching agenda items:', error)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    updateTime()
    timeInterval = setInterval(updateTime, 1000)
    fetchAgendaItems()
})

onUnmounted(() => {
    if (timeInterval) clearInterval(timeInterval)
})
</script>

<style scoped>
.dashboard {
    min-height: 100vh;
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

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

/* Stat Card Base */
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

.stat-card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}

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

.time-icon {
    background: rgba(59, 130, 246, 0.2);
    color: #3b82f6;
}

.event-icon {
    background: rgba(234, 183, 81, 0.2);
    color: #eab308;
}

.stats-icon {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.actions-icon {
    background: rgba(139, 92, 246, 0.2);
    color: #8b5cf6;
}

.stat-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Tijd Card */
.time-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-light);
    font-family: monospace;
    margin-bottom: 0.25rem;
}

.stat-date {
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Evenement Card */
.event-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.event-date {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-bottom: 0.5rem;
}

.event-location {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.location-icon {
    width: 0.875rem;
    height: 0.875rem;
}

.no-event {
    text-align: center;
    padding: 1.5rem 0;
}

.no-event p {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: 0.75rem;
}

.create-event-link {
    color: var(--primary);
    font-size: 0.875rem;
    text-decoration: none;
    transition: color 0.2s;
}

.create-event-link:hover {
    color: var(--primary-hover);
    text-decoration: underline;
}

/* Statistieken Card */
.stats-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(234, 183, 81, 0.1);
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-light);
}

.stat-number.published {
    color: #10b981;
}

.stat-number.concept {
    color: #eab308;
}

.stat-number.cancelled {
    color: #ef4444;
}



/* Responsive */
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

    .time-value {
        font-size: 2rem;
    }

    .stat-number {
        font-size: 1.25rem;
    }
}

@media (max-width: 480px) {
    .stat-card-header {
        margin-bottom: 1rem;
    }

    .event-title {
        font-size: 1rem;
    }

}
</style>
