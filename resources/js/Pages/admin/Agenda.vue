<!-- Pages/Admin/Agenda.vue - Updated version -->
<script setup>
import { ref, onMounted, computed } from 'vue'
import { useAgenda } from '@/composables/useAgenda'
import AdminLayout from "@/Layouts/AdminLayout.vue";

defineOptions({
    layout: AdminLayout
})

const {
    agendaItems,
    loading,
    error,
    fetchAgendaItems,
    createAgendaItem,
    updateAgendaItem,
    deleteAgendaItem,
    filters,
    updateFilters
} = useAgenda()

const showModal = ref(false)
const isEditing = ref(false)
const selectedItem = ref(null)
const selectedStatus = ref('')
const selectedCategory = ref('')

// Form state
const form = ref({
    title: '',
    description: '',
    start_date: '',
    end_date: '',
    location: '',
    status: 'concept',
    published_at: '',  // Nieuw veld
    color: '#3b82f6'
})

// Status opties met styling
const statusOptions = [
    { value: '', label: 'Alle statussen', color: 'gray', bgColor: 'bg-gray-500' },
    { value: 'concept', label: 'Concept', color: 'yellow', bgColor: 'bg-yellow-500' },
    { value: 'published', label: 'Gepubliceerd', color: 'green', bgColor: 'bg-green-500' },
    { value: 'cancelled', label: 'Geannuleerd', color: 'red', bgColor: 'bg-red-500' }
]

// Kleur opties voor agenda items met labels
const colorOptions = [
    {
        value: '#3b82f6',
        label: 'LOL',
        description: 'Leuke Ontspanning Activiteiten',
        bgColor: 'bg-blue-500',
        textColor: 'text-blue-500'
    },
    {
        value: '#f59e0b',
        label: 'KHLL',
        description: 'Koninklijke Harmonie Lentekrans',
        bgColor: 'bg-amber-500',
        textColor: 'text-amber-500'
    },
    {
        value: '#10b981',
        label: 'Activiteiten',
        description: 'Overige activiteiten',
        bgColor: 'bg-green-500',
        textColor: 'text-green-500'
    }
]

// Filteren
const filteredItems = computed(() => {
    let items = agendaItems.value

    if (selectedStatus.value && selectedStatus.value !== '') {
        items = items.filter(item => item.status === selectedStatus.value)
    }

    if (selectedCategory.value && selectedCategory.value !== '') {
        items = items.filter(item => item.color === selectedCategory.value)
    }

    return items
})

// Reset form
const resetForm = () => {
    form.value = {
        title: '',
        description: '',
        start_date: '',
        end_date: '',
        location: '',
        status: 'concept',
        published_at: '',
        color: '#3b82f6'
    }
    isEditing.value = false
    selectedItem.value = null
}

// Open modal voor nieuw item
const openCreateModal = () => {
    resetForm()
    showModal.value = true
}

// Open modal voor bewerken
const openEditModal = (item) => {
    isEditing.value = true
    selectedItem.value = item
    form.value = {
        title: item.title,
        description: item.description || '',
        start_date: item.start_date?.slice(0, 16) || '',
        end_date: item.end_date?.slice(0, 16) || '',
        location: item.location || '',
        status: item.status,
        published_at: item.published_at?.slice(0, 16) || '',
        color: item.color
    }
    showModal.value = true
}

// Save item
const saveItem = async () => {
    let result

    if (isEditing.value && selectedItem.value) {
        result = await updateAgendaItem(selectedItem.value.id, form.value)
    } else {
        result = await createAgendaItem(form.value)
    }

    if (result.success) {
        showModal.value = false
        resetForm()
    } else {
        alert('Error: ' + (result.error || 'Failed to save agenda item'))
    }
}

// Delete item
const handleDelete = async (id) => {
    if (confirm('Weet je zeker dat je dit agenda item wilt verwijderen?')) {
        const result = await deleteAgendaItem(id)
        if (!result.success) {
            alert('Error: ' + (result.error || 'Failed to delete agenda item'))
        }
    }
}

// Formatter datum
const formatDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('nl-NL', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const formatDateShort = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('nl-NL', {
        day: 'numeric',
        month: 'short',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const getStatusClass = (status) => {
    const classes = {
        concept: 'bg-yellow-500',
        published: 'bg-green-500',
        cancelled: 'bg-red-500'
    }
    return classes[status] || 'bg-gray-500'
}

const getStatusLabel = (status) => {
    const labels = {
        concept: 'Concept',
        published: 'Gepubliceerd',
        cancelled: 'Geannuleerd'
    }
    return labels[status] || status
}

// Check of item gepubliceerd is op basis van published_at
const isItemPublished = (item) => {
    if (item.status !== 'published') return false
    if (!item.published_at) return true
    return new Date(item.published_at) <= new Date()
}

const applyFilters = () => {
    updateFilters({ status: selectedStatus.value })
}

const applyCategoryFilter = () => {
    updateFilters({ color: selectedCategory.value })
}

const resetFilters = () => {
    selectedStatus.value = ''
    selectedCategory.value = ''
    updateFilters({ status: '', color: '' })
}

onMounted(() => {
    fetchAgendaItems()
})
</script>

<template>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-text-light">Agenda Beheer</h1>
                <p class="text-text-muted mt-1">Beheer alle agenda items, repetities en concerten</p>
            </div>
            <button
                @click="openCreateModal"
                class="bg-primary text-background px-4 py-2 rounded-lg hover:bg-primary-hover transition flex items-center gap-2 shadow-lg"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nieuw Agenda Item
            </button>
        </div>

        <!-- Filters (zelfde als eerder) -->
        <div class="bg-background-light rounded-lg p-4 mb-6 border border-primary border-opacity-20">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-text-muted mb-1">Status filter</label>
                    <select
                        v-model="selectedStatus"
                        @change="applyFilters"
                        class="w-full px-3 py-2 rounded bg-background-dark border border-primary border-opacity-30 text-text-light focus:outline-none focus:border-primary"
                    >
                        <option value="">Alle statussen</option>
                        <option value="concept">Concept</option>
                        <option value="published">Gepubliceerd</option>
                        <option value="cancelled">Geannuleerd</option>
                    </select>
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-text-muted mb-1">Categorie filter</label>
                    <select
                        v-model="selectedCategory"
                        @change="applyCategoryFilter"
                        class="w-full px-3 py-2 rounded bg-background-dark border border-primary border-opacity-30 text-text-light focus:outline-none focus:border-primary"
                    >
                        <option value="">Alle categorieën</option>
                        <option value="#3b82f6">LOL</option>
                        <option value="#f59e0b">KHLL</option>
                        <option value="#10b981">Activiteiten</option>
                    </select>
                </div>

                <button
                    @click="resetFilters"
                    class="px-4 py-2 rounded bg-background-dark border border-primary border-opacity-30 text-text-light hover:text-primary transition"
                >
                    Reset filters
                </button>

                <div class="text-sm text-text-muted">
                    <span class="font-semibold">{{ filteredItems.length }}</span> items gevonden
                </div>
            </div>
        </div>

        <!-- Loading & Error states -->
        <div v-if="loading" class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
        </div>

        <div v-if="error" class="bg-red-500 text-white p-4 rounded-lg mb-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ error }}</span>
            </div>
        </div>

        <!-- Agenda Items Grid -->
        <div v-if="!loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="item in filteredItems"
                :key="item.id"
                class="group bg-background-light rounded-xl border-2 transition-all duration-300 overflow-hidden hover:shadow-xl hover:-translate-y-1"
                :class="{
                    'border-blue-500/50': item.color === '#3b82f6',
                    'border-amber-500/50': item.color === '#f59e0b',
                    'border-green-500/50': item.color === '#10b981'
                }"
            >
                <div
                    class="h-2 transition-all duration-300 group-hover:h-3"
                    :style="{ backgroundColor: item.color }"
                ></div>

                <div class="p-5">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex gap-2">
                            <span
                                class="text-xs px-2 py-1 rounded-full text-white font-medium"
                                :class="getStatusClass(item.status)"
                            >
                                {{ getStatusLabel(item.status) }}
                            </span>
                            <span
                                v-if="item.status === 'published' && item.published_at && !isItemPublished(item)"
                                class="text-xs px-2 py-1 rounded-full bg-orange-500 text-white font-medium"
                            >
                                Gepland
                            </span>
                        </div>
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button
                                @click="openEditModal(item)"
                                class="p-1.5 rounded-lg text-primary hover:bg-primary hover:text-background transition"
                                title="Bewerken"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button
                                @click="handleDelete(item.id)"
                                class="p-1.5 rounded-lg text-red-500 hover:bg-red-500 hover:text-white transition"
                                title="Verwijderen"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-text-light mb-2 line-clamp-2">
                            {{ item.title }}
                        </h3>
                        <p class="text-text-muted text-sm line-clamp-3">
                            {{ item.description || 'Geen beschrijving' }}
                        </p>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center gap-2 text-text-muted text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div class="flex flex-col">
                                <span>{{ formatDateShort(item.start_date) }}</span>
                                <span v-if="item.end_date" class="text-xs">
                                    tot {{ formatDateShort(item.end_date) }}
                                </span>
                            </div>
                        </div>

                        <div v-if="item.location" class="flex items-center gap-2 text-text-muted text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="truncate">{{ item.location }}</span>
                        </div>

                        <div v-if="item.status === 'published' && item.published_at" class="flex items-center gap-2 text-text-muted text-xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Publiceert op: {{ formatDate(item.published_at) }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-primary border-opacity-20">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-3 h-3 rounded-full"
                                :style="{ backgroundColor: item.color }"
                            ></div>
                            <span class="text-xs font-medium" :class="{
                                'text-blue-400': item.color === '#3b82f6',
                                'text-amber-400': item.color === '#f59e0b',
                                'text-green-400': item.color === '#10b981'
                            }">
                                {{ item.color === '#3b82f6' ? 'LOL' : item.color === '#f59e0b' ? 'KHLL' : 'Activiteiten' }}
                            </span>
                        </div>
                        <div class="text-xs text-text-muted">
                            {{ new Date(item.created_at).toLocaleDateString('nl-NL') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-if="!loading && filteredItems.length === 0" class="text-center py-12">
            <svg class="w-24 h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-text-muted text-lg mb-2">Geen agenda items gevonden</p>
            <p class="text-text-muted text-sm mb-4">Pas de filters aan of voeg een nieuw agenda item toe</p>
            <button
                @click="openCreateModal"
                class="text-primary hover:text-primary-hover transition font-medium"
            >
                + Maak je eerste agenda item aan
            </button>
        </div>

        <!-- Modal voor Create/Edit -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition-all duration-300">
            <div class="bg-background-light rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
                <div class="sticky top-0 bg-gradient-to-r from-primary/50 to-primary/5 border-b border-primary border-opacity-20 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-text-light">
                                {{ isEditing ? 'Agenda Item Bewerken' : 'Nieuw Agenda Item' }}
                            </h2>

                        </div>
                        <button
                            @click="showModal = false"
                            class="text-text-muted hover:text-primary transition p-2 rounded-lg hover:bg-background-dark"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <form @submit.prevent="saveItem" class="p-6 space-y-6">
                    <!-- Titel & Beschrijving sectie -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-text-light flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Basis Informatie
                        </h3>

                        <div class="bg-background-dark/50 rounded-xl p-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-text-light mb-2">
                                    Titel <span class="text-primary">*</span>
                                </label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    required
                                    placeholder="Bijv. Voorjaarsconcert 2026"
                                    class="w-full px-4 py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light placeholder-text-muted/50 focus:outline-none focus:border-primary transition"
                                />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-light mb-2">
                                    Beschrijving
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="4"
                                    placeholder="Beschrijf het evenement..."
                                    class="w-full px-4 py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light placeholder-text-muted/50 focus:outline-none focus:border-primary transition resize-none"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Datum & Locatie sectie -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-text-light flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Datum & Locatie
                        </h3>

                        <div class="bg-background-dark/50 rounded-xl p-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-text-light mb-2">
                                        Start Datum <span class="text-primary">*</span>
                                    </label>
                                    <input
                                        v-model="form.start_date"
                                        type="datetime-local"
                                        required
                                        class="w-full px-4 py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light focus:outline-none focus:border-primary transition"
                                    />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-text-light mb-2">
                                        Eind Datum
                                    </label>
                                    <input
                                        v-model="form.end_date"
                                        type="datetime-local"
                                        class="w-full px-4 py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light focus:outline-none focus:border-primary transition"
                                    />
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-light mb-2">
                                    Locatie
                                </label>
                                <input
                                    v-model="form.location"
                                    type="text"
                                    placeholder="Bijv. Cultuurcentrum, Muziekschool, etc."
                                    class="w-full px-4 py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light placeholder-text-muted/50 focus:outline-none focus:border-primary transition"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Status, Publicatiedatum & Categorie sectie -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-text-light flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                            </svg>
                            Status & Publicatie
                        </h3>

                        <div class="bg-background-dark/50 rounded-xl p-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-text-light mb-2">
                                    Status
                                </label>
                                <div class="flex gap-2">
                                    <button
                                        v-for="status in [
                                            { value: 'concept', label: 'Concept', icon: '✏️' },
                                            { value: 'published', label: 'Gepubliceerd', icon: '✓' },
                                            { value: 'cancelled', label: 'Geannuleerd', icon: '✗' }
                                        ]"
                                        :key="status.value"
                                        type="button"
                                        @click="form.status = status.value"
                                        class="flex-1 px-4 py-2 rounded-xl transition-all duration-200 border-2 font-medium"
                                        :class="{
                                            'bg-yellow-500 border-yellow-500 text-white shadow-lg': form.status === 'concept' && status.value === 'concept',
                                            'bg-green-500 border-green-500 text-white shadow-lg': form.status === 'published' && status.value === 'published',
                                            'bg-red-500 border-red-500 text-white shadow-lg': form.status === 'cancelled' && status.value === 'cancelled',
                                            'bg-background-dark border-primary border-opacity-20 text-text-light hover:bg-primary/10 hover:border-primary': form.status !== status.value,
                                        }"
                                    >
                                        <span class="text-lg mr-2">{{ status.icon }}</span>
                                        <span>{{ status.label }}</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Publicatiedatum - alleen tonen als status 'published' is -->
                            <div v-if="form.status === 'published'">
                                <label class="block text-sm font-medium text-text-light mb-2">
                                    Publicatiedatum
                                </label>
                                <input
                                    v-model="form.published_at"
                                    type="datetime-local"
                                    class="w-full px-4 py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light focus:outline-none focus:border-primary transition"
                                />
                                <p class="text-xs text-text-muted mt-1">
                                    Laat leeg voor direct publiceren. Kies een datum/tijd voor geplande publicatie.
                                </p>
                            </div>

                            <!-- Categorie -->
                            <div>
                                <label class="block text-sm font-medium text-text-light mb-3">
                                    Categorie
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <button
                                        v-for="color in colorOptions"
                                        :key="color.value"
                                        type="button"
                                        @click="form.color = color.value"
                                        class="group relative overflow-hidden rounded-xl transition-all duration-300 transform hover:scale-105"
                                    >
                                        <div
                                            class="p-4 text-center transition-all duration-300"
                                            :class="{
                                                'bg-gradient-to-br from-blue-600 to-blue-400': color.value === '#3b82f6',
                                                'bg-gradient-to-br from-amber-600 to-amber-400': color.value === '#f59e0b',
                                                'bg-gradient-to-br from-green-600 to-green-400': color.value === '#10b981',
                                                'opacity-75 hover:opacity-100': form.color !== color.value,
                                                'ring-4 ring-offset-2 ring-offset-background-dark ring-white shadow-xl': form.color === color.value
                                            }"
                                        >
                                            <div class="text-white">
                                                <div class="text-2xl font-bold mb-1">
                                                    {{ color.label }}
                                                </div>
                                                <div class="text-xs opacity-90">
                                                    {{ color.description }}
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview sectie -->
                    <div class="space-y-4" v-if="form.title">
                        <h3 class="text-lg font-semibold text-text-light flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Preview
                        </h3>

                        <div class="bg-background-dark/50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-xs px-2 py-1 rounded-full font-medium text-white" :class="{
                                    'bg-yellow-500': form.status === 'concept',
                                    'bg-green-500': form.status === 'published',
                                    'bg-red-500': form.status === 'cancelled'
                                }">
                                    {{ form.status === 'concept' ? 'Concept' : form.status === 'published' ? 'Gepubliceerd' : 'Geannuleerd' }}
                                </span>
                                <span class="text-xs px-2 py-1 rounded-full font-medium text-white" :class="{
                                    'bg-blue-500': form.color === '#3b82f6',
                                    'bg-amber-500': form.color === '#f59e0b',
                                    'bg-green-500': form.color === '#10b981'
                                }">
                                    {{ form.color === '#3b82f6' ? 'LOL' : form.color === '#f59e0b' ? 'KHLL' : 'Activiteiten' }}
                                </span>
                                <span v-if="form.status === 'published' && form.published_at" class="text-xs px-2 py-1 rounded-full bg-orange-500 text-white font-medium">
                                    Gepland
                                </span>
                            </div>

                            <h4 class="text-lg font-bold text-text-light mb-1">{{ form.title || 'Titel wordt hier weergegeven' }}</h4>
                            <p class="text-text-muted text-sm mb-2">{{ form.description || 'Beschrijving wordt hier weergegeven...' }}</p>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-text-muted">
                                <span>📅 {{ form.start_date ? new Date(form.start_date).toLocaleDateString('nl-NL') : 'Datum nog niet gekozen' }}</span>
                                <span v-if="form.location">📍 {{ form.location }}</span>
                                <span v-if="form.status === 'published' && form.published_at">⏰ Publiceert op: {{ new Date(form.published_at).toLocaleDateString('nl-NL') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form buttons -->
                    <div class="sticky bottom-0 bg-background-light pt-4 pb-2 flex justify-end gap-3 border-t border-primary border-opacity-20">
                        <button
                            type="button"
                            @click="showModal = false"
                            class="px-6 py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light hover:bg-background-dark hover:border-primary transition font-medium"
                        >
                            Annuleren
                        </button>
                        <button
                            type="submit"
                            class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-primary to-primary-hover text-background font-medium hover:shadow-lg transition transform hover:scale-105"
                        >
                            <div class="flex items-center gap-2">
                                <svg v-if="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <div v-else class="animate-spin rounded-full h-5 w-5 border-b-2 border-background"></div>
                                <span>{{ isEditing ? 'Bijwerken' : 'Opslaan' }}</span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}

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

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(249, 115, 22, 0.5);
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(249, 115, 22, 0.8);
}
</style>
