<template>
    <div class="page page-dashboard">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold mb-2 text-text-dark px-6 pt-6">Dashboard</h1>

            <!-- TitleImageGallery Component -->
            <TitleImageGallery
                title="Welkom bij KHLL"
                description="Ontdek onze innovatieve collectie van producten en diensten. We bieden het beste van kwaliteit, design en functionaliteit."
                imageSrc="https://via.placeholder.com/500x300"
                :images="[
                    {
                        src: 'https://via.placeholder.com/400x225',
                        alt: 'Premium Collectie',
                        caption: 'Premium Selectie'
                    },
                    {
                        src: 'https://via.placeholder.com/400x225',
                        alt: 'Design Excellence',
                        caption: 'Design Excellence'
                    },
                    {
                        src: 'https://via.placeholder.com/400x225',
                        alt: 'Kwaliteit Gegarandeerd',
                        caption: 'Kwaliteit Gegarandeerd'
                    }
                ]"
            />

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-6 pb-6">
                <!-- Quick Links Card -->
                <div class="card">
                    <h3 class="card-title">Quick Links</h3>
                    <nav class="space-y-2">
                        <Link href="/components" class="card-link">
                            Alle Componenten
                        </Link>
                    </nav>
                </div>

                <!-- Stats Card -->
                <div class="card">
                    <h3 class="card-title">Statistieken</h3>
                    <div class="stat">
                        <span class="label">Totaal requests:</span>
                        <span class="value">—</span>
                    </div>
                    <div class="stat">
                        <span class="label">Status:</span>
                        <span class="value status-ok">Actief</span>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card">
                    <h3 class="card-title">Over Dit Project</h3>
                    <p class="text-sm text-text-muted">
                        Laravel + Vue.js met Inertia.js voor moderne fullstack development.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Link } from '@inertiajs/vue3'
import TitleImageGallery from '@/Components/widgets/TitleImageGallery.vue'

defineOptions({
    layout: MainLayout
})
</script>

<style scoped>
.page {
    min-height: 100vh;
    background: #f5f5f5;
}

.container {
    max-width: 1200px;
}

.card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.card-title {
    @apply text-lg font-bold text-text-dark mb-4;
}

.card-link {
    @apply block px-4 py-2 rounded text-primary hover:bg-primary/10 transition-colors;
    text-decoration: none;
}

.stat {
    @apply py-2 flex justify-between items-center;
    border-bottom: 1px solid #eee;
}

.stat:last-child {
    border-bottom: none;
}

.label {
    @apply text-sm text-text-muted;
}

.value {
    @apply font-semibold text-text-dark;
}

.status-ok {
    @apply text-green-600;
}
</style>

