<script setup>
import { defineProps, ref, onMounted } from 'vue'
import TitleCH1 from '@/Components/texten/TitleC_h1.vue'
import Button from '@/Components/Button.vue'

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
        default: () => [
            {
                id: 1,
                date: '15 April 2025',
                title: 'Yoga Sessie',
                description: 'Een ontspannende yoga sessie voor beginners en gevorderden.',
                link: '#'
            },
            {
                id: 2,
                date: '18 April 2025',
                title: 'Meditation Workshop',
                description: 'Leer de fundamenten van meditatie en mindfulness.',
                link: '#'
            },
            {
                id: 3,
                date: '22 April 2025',
                title: 'Nature Walk',
                description: 'Wandeling door de natuur met gids en informatie.',
                link: '#'
            },
        ]
    },
    fetchUrl: {
        type: String,
        default: null
    },
    light: {
        type: Boolean,
        default: false
    }
})

// Lifecycle hook voor database integratie
onMounted(async () => {
    // Als een fetchUrl is opgegeven, fetch data van de database/API
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

// Gebruik de gefetchte data als beschikbaar, anders de default props
const displayActivities = () => {
    return activitiesData.value || props.activities
}
</script>

<template>
    <div class="activities-container" :class="{ 'light-mode': props.light }">
        <!-- Title -->
        <div class="title-section">
            <TitleCH1 :title="title" :light="props.light" />
        </div>

        <!-- Main Content -->
        <div class="content-grid">
            <!-- Image Section -->
            <div class="image-section">
                <img :src="image" :alt="title" class="activity-image" />
            </div>

            <!-- Activities List Section -->
            <div class="activities-section">
                <div class="activities-list">
                    <div v-if="isLoading" class="loading-state">
                        <p>Activiteiten laden...</p>
                    </div>
                    <div v-else v-for="(activity, index) in displayActivities()" :key="activity.id" class="activity-item" :style="{ 'animation-delay': `${index * 50}ms` }">
                        <div class="activity-date">
                            {{ activity.date }}
                        </div>
                        <div class="activity-header">
                            <h3 class="activity-title">{{ activity.title }}</h3>
                        </div>
                        <p class="activity-description">{{ activity.description }}</p>
                        <a :href="activity.link" class="read-more-link">Meer lezen →</a>
                    </div>
                </div>

                <!-- All Activities Button -->
                <div class="button-section">
                    <Button text="Bekijk Alle Activiteiten" variant="primary" />
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

/* IMAGE SECTION */
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

/* ACTIVITIES SECTION */
.activities-section {
    @apply flex flex-col gap-6;
}

.activities-list {
    @apply space-y-4 pr-2;
    max-height: 800px;
    overflow-y: auto;
    padding-right: 12px;
}

.loading-state {
    @apply p-4 text-center text-text-muted;
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Custom scrollbar styling */
.activities-list::-webkit-scrollbar {
    width: 6px;
}

.activities-list::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.activities-list::-webkit-scrollbar-thumb {
    background: #EAB751;
    border-radius: 10px;
}

.activities-list::-webkit-scrollbar-thumb:hover {
    background: #D9A94A;
}

/* ACTIVITY ITEM */
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

/* LIGHT MODE - Dark background */
.light-mode .activity-item {
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.12) 0%, rgba(234, 183, 81, 0.04) 100%);
    border: 1px solid rgba(234, 183, 81, 0.25);
}

.light-mode .activity-item:hover {
    border-color: rgba(234, 183, 81, 0.5);
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.18) 0%, rgba(234, 183, 81, 0.08) 100%);
    box-shadow: 0 8px 16px rgba(234, 183, 81, 0.15);
}

.light-mode .activities-list::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.08);
}

.light-mode .activities-list::-webkit-scrollbar-thumb {
    background: #F5D58A;
}

.light-mode .activities-list::-webkit-scrollbar-thumb:hover {
    background: #EAB751;
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

.activity-date {
    @apply text-xs font-poppins font-semibold tracking-wide;
    color: #EAB751;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 6px;
}

.light-mode .activity-date {
    color: #F5D58A;
}

.activity-header {
    @apply mb-2;
}

.activity-title {
    @apply text-lg font-poppins font-semibold text-text-dark;
    margin: 0;
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

.read-more-link {
    @apply text-sm font-poppins font-semibold transition-all duration-200;
    color: #EAB751;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.read-more-link:hover {
    color: #D9A94A;
    transform: translateX(2px);
}

.light-mode .read-more-link {
    color: #F5D58A;
}

.light-mode .read-more-link:hover {
    color: #FFE4A6;
}

/* BUTTON SECTION */
.button-section {
    @apply flex justify-center pt-4;
    border-top: 1px solid rgba(234, 183, 81, 0.2);
}

.light-mode .button-section {
    border-top-color: rgba(234, 183, 81, 0.3);
}

.light-mode .loading-state {
    @apply text-accent-soft;
}

/* Responsive Design */
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
        @apply text-base;
    }

    .activity-description {
        @apply text-xs;
    }
}

/* Dark mode friendly - if the page has a dark background */
@supports (background: color-mix(in srgb, transparent 10%, white)) {
    .activities-item {
        background: color-mix(in srgb, #EAB751 8%, transparent);
    }
}
</style>
