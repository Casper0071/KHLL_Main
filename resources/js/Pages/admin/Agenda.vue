<!-- Pages/Admin/Agenda.vue -->
<script setup>
import { ref, onMounted, computed } from 'vue'
import { useAgenda } from '@/composables/useAgenda'
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from 'axios'

defineOptions({
    layout: AdminLayout
})

const {
    agendaItems,
    loading,
    error,
    fetchAgendaItems,
    deleteAgendaItem,
    updateFilters
} = useAgenda()

const showModal = ref(false)
const isEditing = ref(false)
const selectedItem = ref(null)
const selectedStatus = ref('')
const selectedCategory = ref('')
const imageFile = ref(null)
const imagePreview = ref('')
const isSaving = ref(false)

// Form state
const form = ref({
    title: '',
    description: '',
    start_date: '',
    end_date: '',
    location: '',
    status: 'concept',
    published_at: '',
    color: '#3b82f6',
    image: null
})

// Check of item zichtbaar is op de website
const isItemVisible = (item) => {
    if (item.status !== 'published') return false
    if (!item.published_at) return true
    const now = new Date()
    const publishDate = new Date(item.published_at)
    return publishDate <= now
}

// Kleur opties voor agenda items met labels
const colorOptions = [
    {
        value: '#3b82f6',
        label: 'LOL',
        description: 'Lentekrans opleidings orkest',
        bgColor: 'bg-blue-500',
        textColor: 'text-blue-500'
    },
    {
        value: '#f59e0b',
        label: 'KHLL',
        description: 'Koninklijke harmonie lentekrans',
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
    let items = agendaItems.value || []
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
        color: '#3b82f6',
        image: null
    }
    imageFile.value = null
    imagePreview.value = ''
    isEditing.value = false
    selectedItem.value = null
}

// Image handling
const handleImageUpload = (event) => {
    const file = event.target.files[0]
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('Afbeelding is te groot. Maximaal 2MB.')
            return
        }
        imageFile.value = file
        const reader = new FileReader()
        reader.onload = (e) => {
            imagePreview.value = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

const removeImage = () => {
    imageFile.value = null
    imagePreview.value = ''
    form.value.image = null
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
        title: item.title || '',
        description: item.description || '',
        start_date: item.start_date?.slice(0, 16) || '',
        end_date: item.end_date?.slice(0, 16) || '',
        location: item.location || '',
        status: item.status || 'concept',
        published_at: item.published_at?.slice(0, 16) || '',
        color: item.color || '#3b82f6',
        image: item.image
    }
    if (item.image_url) {
        imagePreview.value = item.image_url
    }
    showModal.value = true
}

// Formatteer datum
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

// Save item
const saveItem = async () => {
    isSaving.value = true
    try {
        let formData = new FormData()
        formData.append('title', form.value.title || '')
        formData.append('description', form.value.description || '')
        formData.append('start_date', form.value.start_date || '')
        formData.append('end_date', form.value.end_date || '')
        formData.append('location', form.value.location || '')
        formData.append('status', form.value.status)
        formData.append('published_at', form.value.published_at || '')
        formData.append('color', form.value.color)
        if (imageFile.value) {
            formData.append('image', imageFile.value)
        }
        let response
        if (isEditing.value && selectedItem.value) {
            formData.append('_method', 'PUT')
            response = await axios.post(`/api/agenda/${selectedItem.value.id}`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
        } else {
            response = await axios.post('/api/agenda', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
        }
        if (response.data.success) {
            showModal.value = false
            resetForm()
            fetchAgendaItems()
        } else {
            alert('Error: ' + (response.data.message || 'Failed to save'))
        }
    } catch (error) {
        console.error('Save error:', error)
        if (error.response?.data?.errors) {
            const errorMessages = Object.values(error.response.data.errors).flat().join('\n')
            alert('Validatie fouten:\n' + errorMessages)
        } else {
            alert('Error: ' + (error.response?.data?.message || error.message || 'Failed to save agenda item'))
        }
    } finally {
        isSaving.value = false
    }
}

// Delete item
const handleDelete = async (id) => {
    if (confirm('Weet je zeker dat je dit agenda item wilt verwijderen? De afbeelding wordt ook permanent verwijderd.')) {
        const result = await deleteAgendaItem(id)
        if (!result.success) {
            alert('Error: ' + (result.error || 'Failed to delete agenda item'))
        }
    }
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
    <div class="p-3 sm:p-4 md:p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-text-light">Agenda Beheer</h1>
                <p class="text-text-muted text-xs sm:text-sm mt-1">Beheer alle agenda items, repetities en concerten</p>
            </div>
            <button
                @click="openCreateModal"
                class="bg-primary text-background px-3 py-2 sm:px-4 sm:py-2 rounded-lg hover:bg-primary-hover transition flex items-center gap-2 shadow-lg text-sm sm:text-base w-full sm:w-auto justify-center"
            >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nieuw Agenda Item
            </button>
        </div>

        <!-- Filters -->
        <div class="bg-background-light rounded-lg p-3 sm:p-4 mb-6 border border-primary border-opacity-20">
            <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 items-stretch sm:items-end">
                <div class="flex-1 min-w-[150px] sm:min-w-[200px]">
                    <label class="block text-xs sm:text-sm font-medium text-text-muted mb-1">Status filter</label>
                    <select
                        v-model="selectedStatus"
                        @change="applyFilters"
                        class="w-full px-2 py-1.5 sm:px-3 sm:py-2 rounded bg-background-dark border border-primary border-opacity-30 text-text-light text-sm focus:outline-none focus:border-primary"
                    >
                        <option value="">Alle statussen</option>
                        <option value="concept">Concept</option>
                        <option value="published">Gepubliceerd</option>
                        <option value="cancelled">Geannuleerd</option>
                    </select>
                </div>

                <div class="flex-1 min-w-[150px] sm:min-w-[200px]">
                    <label class="block text-xs sm:text-sm font-medium text-text-muted mb-1">Categorie filter</label>
                    <select
                        v-model="selectedCategory"
                        @change="applyCategoryFilter"
                        class="w-full px-2 py-1.5 sm:px-3 sm:py-2 rounded bg-background-dark border border-primary border-opacity-30 text-text-light text-sm focus:outline-none focus:border-primary"
                    >
                        <option value="">Alle categorieën</option>
                        <option value="#3b82f6">LOL</option>
                        <option value="#f59e0b">KHLL</option>
                        <option value="#10b981">Activiteiten</option>
                    </select>
                </div>

                <button
                    @click="resetFilters"
                    class="px-3 py-1.5 sm:px-4 sm:py-2 rounded bg-background-dark border border-primary border-opacity-30 text-text-light hover:text-primary transition text-sm"
                >
                    Reset filters
                </button>

                <div class="text-xs sm:text-sm text-text-muted self-end sm:self-auto">
                    <span class="font-semibold">{{ filteredItems.length }}</span> items gevonden
                </div>
            </div>
        </div>

        <!-- Loading -->
        <div v-if="loading" class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-10 w-10 sm:h-12 sm:w-12 border-b-2 border-primary"></div>
        </div>

        <!-- Error -->
        <div v-if="error" class="bg-red-500 text-white p-3 sm:p-4 rounded-lg mb-4 text-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ error }}</span>
            </div>
        </div>

        <!-- Agenda Items Grid - Responsive -->
        <div v-if="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
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
                    class="h-1 sm:h-2 transition-all duration-300 group-hover:h-1.5 sm:group-hover:h-3"
                    :style="{ backgroundColor: item.color }"
                ></div>

                <div v-if="item.image_url" class="relative h-32 sm:h-40 overflow-hidden">
                    <img
                        :src="item.image_url"
                        :alt="item.title"
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    />
                </div>

                <div class="p-3 sm:p-5">
                    <div class="flex justify-between items-start mb-2 sm:mb-3">
                        <div class="flex gap-1 sm:gap-2 flex-wrap">
                            <span
                                class="text-xs px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full text-white font-medium"
                                :class="getStatusClass(item.status)"
                            >
                                {{ getStatusLabel(item.status) }}
                            </span>
                            <span
                                v-if="item.status === 'published' && item.published_at"
                                class="text-xs px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full text-white font-medium"
                                :class="isItemVisible(item) ? 'bg-green-500' : 'bg-orange-500'"
                            >
                                <span v-if="isItemVisible(item)">Zichtbaar</span>
                                <span v-else>Publiceert op</span>
                            </span>
                        </div>
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="openEditModal(item)" class="p-1 sm:p-1.5 rounded-lg text-primary hover:bg-primary hover:text-background transition" title="Bewerken">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button @click="handleDelete(item.id)" class="p-1 sm:p-1.5 rounded-lg text-red-500 hover:bg-red-500 hover:text-white transition" title="Verwijderen">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-2 sm:mb-4">
                        <h3 class="text-base sm:text-xl font-bold text-text-light mb-1 sm:mb-2 line-clamp-2">
                            {{ item.title }}
                        </h3>
                        <p class="text-text-muted text-xs sm:text-sm line-clamp-3">
                            {{ item.description || 'Geen beschrijving' }}
                        </p>
                    </div>

                    <div class="space-y-1 sm:space-y-2 mb-2 sm:mb-4">
                        <div class="flex items-center gap-1.5 sm:gap-2 text-text-muted text-xs sm:text-sm">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ formatDateShort(item.start_date) }}</span>
                        </div>
                        <div v-if="item.location" class="flex items-center gap-1.5 sm:gap-2 text-text-muted text-xs sm:text-sm">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="truncate">{{ item.location }}</span>
                        </div>
                        <div v-if="item.status === 'published' && item.published_at && !isItemVisible(item)" class="text-text-muted text-xs">
                            <span>Publiceert: {{ formatDateShort(item.published_at) }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2 sm:pt-3 border-t border-primary border-opacity-20">
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full" :style="{ backgroundColor: item.color }"></div>
                            <span class="text-xs font-medium text-text-light">{{ item.color === '#3b82f6' ? 'LOL' : item.color === '#f59e0b' ? 'KHLL' : 'Activiteiten' }}</span>
                        </div>
                        <div class="text-xs text-text-muted">
                            {{ new Date(item.created_at).toLocaleDateString('nl-NL') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-if="!loading && filteredItems.length === 0" class="text-center py-8 sm:py-12">
            <svg class="w-16 h-16 sm:w-24 sm:h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-text-muted text-base sm:text-lg mb-2">Geen agenda items gevonden</p>
            <button @click="openCreateModal" class="text-primary hover:text-primary-hover transition font-medium text-sm sm:text-base">
                + Maak je eerste agenda item aan
            </button>
        </div>

        <!-- Modal voor Create/Edit - Responsive -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 p-2 sm:p-4">
            <div class="bg-background-light rounded-2xl w-full max-w-3xl max-h-[95vh] sm:max-h-[90vh] overflow-y-auto mx-2 sm:mx-0">
                <!-- Header -->
                <div class="sticky top-0 bg-gradient-to-r from-primary/10 to-primary/5 border-b border-primary border-opacity-20 px-4 py-3 sm:px-6 sm:py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg sm:text-2xl font-bold text-text-light">
                                {{ isEditing ? 'Agenda Item Bewerken' : 'Nieuw Agenda Item' }}
                            </h2>
                            <p class="text-text-muted text-xs sm:text-sm mt-1">
                                {{ isEditing ? 'Pas de gegevens van het agenda item aan' : 'Voeg een nieuw evenement toe aan de agenda' }}
                            </p>
                        </div>
                        <button @click="showModal = false" class="text-text-muted hover:text-primary transition p-1 sm:p-2 rounded-lg hover:bg-background-dark">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Form -->
                <form @submit.prevent="saveItem" class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                    <!-- Titel -->
                    <div>
                        <label class="block text-sm font-medium text-text-light mb-1 sm:mb-2">Titel *</label>
                        <input v-model="form.title" type="text" required placeholder="Bijv. Voorjaarsconcert 2026" class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light text-sm sm:text-base focus:outline-none focus:border-primary" />
                    </div>

                    <!-- Beschrijving -->
                    <div>
                        <label class="block text-sm font-medium text-text-light mb-1 sm:mb-2">Beschrijving</label>
                        <textarea v-model="form.description" rows="4" placeholder="Beschrijf het evenement..." class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light text-sm sm:text-base focus:outline-none focus:border-primary resize-none"></textarea>
                    </div>

                    <!-- Afbeelding -->
                    <div>
                        <label class="block text-sm font-medium text-text-light mb-1 sm:mb-2">Afbeelding (Poster)</label>
                        <input type="file" @change="handleImageUpload" accept="image/jpeg,image/png,image/jpg,image/gif" class="w-full px-3 py-1.5 sm:px-4 sm:py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light text-sm file:mr-4 file:py-1 file:px-2 sm:file:py-2 sm:file:px-4 file:rounded-full file:border-0 file:text-xs sm:file:text-sm file:font-semibold file:bg-primary file:text-background hover:file:bg-primary-hover cursor-pointer" />
                        <p class="text-xs text-text-muted mt-1">Toegestane formaten: JPG, PNG, GIF. Maximaal 2MB.</p>
                        <div v-if="imagePreview" class="mt-2">
                            <p class="text-sm font-medium text-text-light mb-2">Huidige afbeelding:</p>
                            <div class="relative inline-block">
                                <img :src="imagePreview" class="w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-lg" />
                                <button type="button" @click="removeImage" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Datum & Locatie -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-sm font-medium text-text-light mb-1 sm:mb-2">Start Datum *</label>
                            <input v-model="form.start_date" type="datetime-local" required class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light text-sm focus:outline-none focus:border-primary" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-light mb-1 sm:mb-2">Eind Datum</label>
                            <input v-model="form.end_date" type="datetime-local" class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light text-sm focus:outline-none focus:border-primary" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-light mb-1 sm:mb-2">Locatie</label>
                        <input v-model="form.location" type="text" placeholder="Bijv. Cultuurcentrum, Muziekschool, etc." class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light text-sm focus:outline-none focus:border-primary" />
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-text-light mb-1 sm:mb-2">Status</label>
                        <div class="flex gap-1 sm:gap-2">
                            <button v-for="status in [{ value: 'concept', label: 'Concept', icon: '✏️' }, { value: 'published', label: 'Gepubliceerd', icon: '✓' }, { value: 'cancelled', label: 'Geannuleerd', icon: '✗' }]" :key="status.value" type="button" @click="form.status = status.value" class="flex-1 px-2 py-1.5 sm:px-4 sm:py-2 rounded-xl border-2 font-medium transition text-xs sm:text-sm" :class="{ 'bg-yellow-500 border-yellow-500 text-white': form.status === 'concept' && status.value === 'concept', 'bg-green-500 border-green-500 text-white': form.status === 'published' && status.value === 'published', 'bg-red-500 border-red-500 text-white': form.status === 'cancelled' && status.value === 'cancelled', 'bg-background-dark border-primary border-opacity-20 text-text-light': form.status !== status.value, }">
                                <span class="text-sm sm:text-lg mr-1 sm:mr-2">{{ status.icon }}</span>
                                <span class="hidden sm:inline">{{ status.label }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Publicatiedatum -->
                    <div v-if="form.status === 'published'">
                        <label class="block text-sm font-medium text-text-light mb-1 sm:mb-2">Publicatiedatum</label>
                        <input v-model="form.published_at" type="datetime-local" class="w-full px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light text-sm focus:outline-none focus:border-primary" />
                        <p class="text-xs text-text-muted mt-1">Laat leeg voor direct publiceren.</p>
                    </div>

                    <!-- Categorie -->
                    <div>
                        <label class="block text-sm font-medium text-text-light mb-2 sm:mb-3">Categorie</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3">
                            <button v-for="color in colorOptions" :key="color.value" type="button" @click="form.color = color.value" class="rounded-xl transition-all duration-300 hover:scale-105" :class="{ 'ring-4 ring-offset-2 ring-offset-background-dark ring-white shadow-xl': form.color === color.value, 'opacity-75 hover:opacity-100': form.color !== color.value }">
                                <div class="p-2 sm:p-4 text-center rounded-xl text-xs sm:text-sm" :class="{ 'bg-gradient-to-br from-blue-600 to-blue-400': color.value === '#3b82f6', 'bg-gradient-to-br from-amber-600 to-amber-400': color.value === '#f59e0b', 'bg-gradient-to-br from-green-600 to-green-400': color.value === '#10b981' }">
                                    <div class="text-white">
                                        <div class="text-base sm:text-2xl font-bold mb-0.5 sm:mb-1">{{ color.label }}</div>
                                        <div class="text-[10px] sm:text-xs opacity-90 hidden sm:block">{{ color.description }}</div>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-2 sm:gap-3 pt-4 border-t border-primary border-opacity-20">
                        <button type="button" @click="showModal = false" class="px-3 py-1.5 sm:px-6 sm:py-2.5 rounded-xl bg-background-dark border-2 border-primary border-opacity-20 text-text-light hover:border-primary transition font-medium text-sm">Annuleren</button>
                        <button type="submit" :disabled="isSaving" class="px-3 py-1.5 sm:px-6 sm:py-2.5 rounded-xl bg-gradient-to-r from-primary to-primary-hover text-background font-medium hover:shadow-lg transition hover:scale-105 disabled:opacity-50 text-sm">
                            <div class="flex items-center gap-2">
                                <div v-if="isSaving" class="animate-spin rounded-full h-4 w-4 sm:h-5 sm:w-5 border-b-2 border-background"></div>
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

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
