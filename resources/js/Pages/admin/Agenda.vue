<template>
    <div class="agenda-page">
        <div class="agenda-page__container">
            <!-- Header -->
            <div class="agenda-page__header">
                <div>
                    <h1 class="agenda-page__title">Agenda Beheer</h1>
                    <p class="agenda-page__subtitle">Beheer alle agenda items, repetities en concerten</p>
                </div>
                <button
                    @click="openCreateModal"
                    class="agenda-page__create-btn"
                >
                    <svg class="agenda-page__create-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Nieuw Agenda Item</span>
                </button>
            </div>

            <!-- Filters -->
            <div class="filters-section">
                <div class="filters-section__container">
                    <div class="filters-section__group">
                        <label class="filters-section__label">Status filter</label>
                        <select
                            v-model="selectedStatus"
                            @change="applyFilters"
                            class="filters-section__select"
                        >
                            <option value="">Alle statussen</option>
                            <option value="concept">Concept</option>
                            <option value="published">Gepubliceerd</option>
                            <option value="cancelled">Geannuleerd</option>
                        </select>
                    </div>

                    <div class="filters-section__group">
                        <label class="filters-section__label">Categorie filter</label>
                        <select
                            v-model="selectedCategory"
                            @change="applyCategoryFilter"
                            class="filters-section__select"
                        >
                            <option value="">Alle categorieën</option>
                            <option value="lol">LOL</option>
                            <option value="khll">KHLL</option>
                            <option value="activiteiten">Activiteiten</option>
                        </select>
                    </div>

                    <button
                        @click="resetFilters"
                        class="filters-section__reset-btn"
                    >
                        Reset filters
                    </button>

                    <div class="filters-section__count">
                        <span class="filters-section__count-number">{{ filteredItems.length }}</span> items gevonden
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div v-if="isLoading" class="agenda-page__loading">
                <div class="agenda-page__loading-spinner"></div>
                <p>Agenda items laden...</p>
            </div>

            <!-- Error State -->
            <div v-if="errorMessage" class="agenda-page__error">
                <svg class="agenda-page__error-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ errorMessage }}</span>
            </div>

            <!-- Agenda Items Grid -->
            <div v-if="!isLoading" class="agenda-grid">
                <div
                    v-for="item in filteredItems"
                    :key="item.id"
                    class="agenda-card"
                    :class="getBorderClass(item.categoryKey)"
                >
                    <div class="agenda-card__color-bar" :class="getCategoryClass(item.categoryKey)"></div>

                    <div v-if="item.image_url" class="agenda-card__image">
                        <img
                            :src="item.image_url"
                            :alt="item.title"
                            class="agenda-card__image-img"
                        />
                    </div>

                    <div class="agenda-card__content">
                        <div class="agenda-card__header">
                            <div class="agenda-card__badges">
                                <span class="agenda-card__badge" :class="getStatusClass(item.status)">
                                    {{ getStatusLabel(item.status) }}
                                </span>
                                <span
                                    v-if="item.status === 'published' && item.published_at"
                                    class="agenda-card__badge"
                                    :class="isItemVisible(item) ? 'agenda-card__badge--visible' : 'agenda-card__badge--scheduled'"
                                >
                                    <span v-if="isItemVisible(item)">Zichtbaar</span>
                                    <span v-else>Publiceert op {{ formatDateShort(item.published_at) }}</span>
                                </span>
                            </div>
                            <div class="agenda-card__actions">
                                <button @click="openEditModal(item)" class="agenda-card__action agenda-card__action--edit" title="Bewerken">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button @click="handleDelete(item.id)" class="agenda-card__action agenda-card__action--delete" title="Verwijderen">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="agenda-card__body">
                            <h3 class="agenda-card__title">{{ item.title }}</h3>
                            <p class="agenda-card__description">{{ item.description || 'Geen beschrijving' }}</p>
                        </div>

                        <div class="agenda-card__details">
                            <div class="agenda-card__detail">
                                <svg class="agenda-card__detail-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ formatDateShort(item.start_date) }}</span>
                            </div>
                            <div v-if="item.location" class="agenda-card__detail">
                                <svg class="agenda-card__detail-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="agenda-card__location">{{ item.location }}</span>
                            </div>
                        </div>

                        <div class="agenda-card__footer">
                            <div class="agenda-card__category">
                                <div class="agenda-card__category-dot" :class="getCategoryClass(item.categoryKey)"></div>
                                <span class="agenda-card__category-label">{{ getCategoryLabel(item.categoryKey) }}</span>
                            </div>
                            <div class="agenda-card__date">
                                {{ formatDateShort(item.created_at) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="!isLoading && filteredItems.length === 0" class="agenda-page__empty">
                <svg class="agenda-page__empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="agenda-page__empty-title">Geen agenda items gevonden</p>
                <button @click="openCreateModal" class="agenda-page__empty-btn">
                    + Maak je eerste agenda item aan
                </button>
            </div>

            <!-- Modal voor Create/Edit -->
            <div v-if="showModal" class="modal-overlay">
                <div class="modal-container">
                    <div class="modal-header">
                        <div>
                            <h2 class="modal-header__title">
                                {{ isEditing ? 'Agenda Item Bewerken' : 'Nieuw Agenda Item' }}
                            </h2>
                            <p class="modal-header__subtitle">
                                {{ isEditing ? 'Pas de gegevens van het agenda item aan' : 'Voeg een nieuw evenement toe aan de agenda' }}
                            </p>
                        </div>
                        <button @click="showModal = false" class="modal-header__close">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form @submit.prevent="saveItem" class="modal-form">
                        <!-- Titel -->
                        <div class="form-group">
                            <label class="form-group__label">Titel <span class="form-group__required">*</span></label>
                            <input v-model="form.title" type="text" required placeholder="Bijv. Voorjaarsconcert 2026" class="form-group__input" />
                        </div>

                        <!-- Beschrijving -->
                        <div class="form-group">
                            <label class="form-group__label">Beschrijving</label>
                            <textarea v-model="form.description" rows="4" placeholder="Beschrijf het evenement..." class="form-group__textarea"></textarea>
                        </div>

                        <!-- Afbeelding -->
                        <div class="form-group">
                            <label class="form-group__label">Afbeelding (Poster)</label>
                            <input type="file" @change="handleImageUpload" accept="image/jpeg,image/png,image/jpg,image/gif" class="form-group__file" />
                            <p class="form-group__hint">Toegestane formaten: JPG, PNG, GIF. Maximaal 2MB.</p>
                            <div v-if="imagePreview" class="form-group__preview">
                                <p class="form-group__preview-label">Huidige afbeelding:</p>
                                <div class="form-group__preview-image">
                                    <img :src="imagePreview" class="form-group__preview-img" />
                                    <button type="button" @click="removeImage" class="form-group__preview-remove">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Datum & Locatie -->
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-group__label">Start Datum <span class="form-group__required">*</span></label>
                                <input v-model="form.start_date" type="datetime-local" required class="form-group__input" />
                            </div>
                            <div class="form-group">
                                <label class="form-group__label">Eind Datum <span class="form-group__required">*</span></label>
                                <input v-model="form.end_date" type="datetime-local" required class="form-group__input" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-group__label">Locatie</label>
                            <input v-model="form.location" type="text" placeholder="Bijv. Cultuurcentrum, Muziekschool, etc." class="form-group__input" />
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label class="form-group__label">Status</label>
                            <div class="status-buttons">
                                <button
                                    v-for="status in statusOptions"
                                    :key="status.value"
                                    type="button"
                                    @click="form.status = status.value"
                                    class="status-btn"
                                    :class="getStatusButtonClass(status.value)"
                                >
                                    <span class="status-btn__icon">{{ status.icon }}</span>
                                    <span class="status-btn__label">{{ status.label }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Publicatiedatum -->
                        <div v-if="form.status === 'published'" class="form-group">
                            <label class="form-group__label">Publicatiedatum</label>
                            <input v-model="form.published_at" type="datetime-local" class="form-group__input" />
                            <p class="form-group__hint">Laat leeg voor direct publiceren.</p>
                        </div>

                        <!-- Categorie -->
                        <div class="form-group">
                            <label class="form-group__label">Categorie</label>
                            <div class="category-buttons">
                                <button
                                    v-for="category in categoryOptions"
                                    :key="category.value"
                                    type="button"
                                    @click="form.categoryKey = category.value"
                                    class="category-btn"
                                    :class="getCategoryButtonClass(category.value)"
                                >
                                    <div class="category-btn__content" :class="getCategoryGradient(category.value)">
                                        <div class="category-btn__label">{{ category.label }}</div>
                                        <div class="category-btn__description">{{ category.description }}</div>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="button" @click="showModal = false" class="form-actions__cancel">
                                Annuleren
                            </button>
                            <button type="submit" :disabled="isSaving" class="form-actions__submit">
                                <div class="form-actions__submit-content">
                                    <div v-if="isSaving" class="form-actions__spinner"></div>
                                    <span>{{ isEditing ? 'Bijwerken' : 'Opslaan' }}</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useAgenda } from '@/composables/useAgenda'
import AdminLayout from "@/Layouts/AdminLayout.vue"
import axios from 'axios'

defineOptions({
    layout: AdminLayout
})

// ============================================
// Composables
// ============================================

const {
    agendaItems,
    loading,
    error,
    fetchAgendaItems,
    deleteAgendaItem,
    updateFilters
} = useAgenda()

// ============================================
// Reactive State
// ============================================

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
    categoryKey: 'lol',
    image: null
})

// Error state
const errorMessage = computed(() => error.value)

// Loading state
const isLoading = computed(() => loading.value)

// ============================================
// Constants
// ============================================

const statusOptions = [
    { value: 'concept', label: 'Concept', icon: '✏️' },
    { value: 'published', label: 'Gepubliceerd', icon: '✓' },
    { value: 'cancelled', label: 'Geannuleerd', icon: '✗' }
]

const categoryOptions = [
    {
        value: 'lol',
        label: 'LOL',
        description: 'Lentekrans opleidings orkest'
    },
    {
        value: 'khll',
        label: 'KHLL',
        description: 'Koninklijke harmonie lentekrans'
    },
    {
        value: 'activiteiten',
        label: 'Activiteiten',
        description: 'Overige activiteiten'
    }
]

// ============================================
// Computed Properties
// ============================================

const filteredItems = computed(() => {
    let items = agendaItems.value || []
    if (selectedStatus.value && selectedStatus.value !== '') {
        items = items.filter(item => item.status === selectedStatus.value)
    }
    if (selectedCategory.value && selectedCategory.value !== '') {
        items = items.filter(item => item.categoryKey === selectedCategory.value)
    }
    return items
})

// ============================================
// Helper Functions
// ============================================

const isItemVisible = (item) => {
    if (item.status !== 'published') return false
    if (!item.published_at) return true
    const now = new Date()
    const publishDate = new Date(item.published_at)
    return publishDate <= now
}

const getCategoryClass = (categoryKey) => {
    const classes = {
        'lol': 'category-bg--lol',
        'khll': 'category-bg--khll',
        'activiteiten': 'category-bg--activiteiten'
    }
    return classes[categoryKey] || 'category-bg--default'
}

const getBorderClass = (categoryKey) => {
    const classes = {
        'lol': 'agenda-card--lol',
        'khll': 'agenda-card--khll',
        'activiteiten': 'agenda-card--activiteiten'
    }
    return classes[categoryKey] || 'agenda-card--default'
}

const getCategoryLabel = (categoryKey) => {
    const labels = {
        'lol': 'LOL',
        'khll': 'KHLL',
        'activiteiten': 'Activiteiten'
    }
    return labels[categoryKey] || 'Activiteiten'
}

const getStatusClass = (status) => {
    const classes = {
        concept: 'badge--concept',
        published: 'badge--published',
        cancelled: 'badge--cancelled'
    }
    return classes[status] || 'badge--default'
}

const getStatusLabel = (status) => {
    const labels = {
        concept: 'Concept',
        published: 'Gepubliceerd',
        cancelled: 'Geannuleerd'
    }
    return labels[status] || status
}

const getStatusButtonClass = (status) => {
    if (form.value.status === status) {
        return `status-btn--active status-btn--${status}`
    }
    return `status-btn--inactive`
}

const getCategoryButtonClass = (categoryValue) => {
    if (form.value.categoryKey === categoryValue) {
        return 'category-btn--active'
    }
    return 'category-btn--inactive'
}

const getCategoryGradient = (categoryValue) => {
    const gradients = {
        'lol': 'gradient--lol',
        'khll': 'gradient--khll',
        'activiteiten': 'gradient--activiteiten'
    }
    return gradients[categoryValue] || 'gradient--default'
}

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

// ============================================
// Methods
// ============================================

const resetForm = () => {
    form.value = {
        title: '',
        description: '',
        start_date: '',
        end_date: '',
        location: '',
        status: 'concept',
        published_at: '',
        categoryKey: 'lol',
        image: null
    }
    imageFile.value = null
    imagePreview.value = ''
    isEditing.value = false
    selectedItem.value = null
}

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

const openCreateModal = () => {
    resetForm()
    showModal.value = true
}

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
        categoryKey: item.categoryKey || 'lol',
        image: item.image
    }
    if (item.image_url) {
        imagePreview.value = item.image_url
    }
    showModal.value = true
}

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
        formData.append('categoryKey', form.value.categoryKey)
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

const handleDelete = async (id) => {
    if (confirm('Weet je zeker dat je dit agenda item wilt verwijderen? De afbeelding wordt ook permanent verwijderd.')) {
        const result = await deleteAgendaItem(id)
        if (!result.success) {
            alert('Error: ' + (result.error || 'Failed to delete agenda item'))
        }
    }
}

const applyFilters = () => {
    updateFilters({ status: selectedStatus.value })
}

const applyCategoryFilter = () => {
    updateFilters({ categoryKey: selectedCategory.value })
}

const resetFilters = () => {
    selectedStatus.value = ''
    selectedCategory.value = ''
    updateFilters({ status: '', categoryKey: '' })
}

// ============================================
// Lifecycle Hooks
// ============================================

onMounted(() => {
    fetchAgendaItems()
})
</script>

<style scoped>
/* ============================================
   Variables (imported from :root)
   ============================================ */

/* Colors use CSS variables from :root */
/* primary, background, text-light, text-muted, etc. */

/* ============================================
   Agenda Page Container
   ============================================ */
.agenda-page {
    min-height: 100vh;
    background-color: var(--background);
}

.agenda-page__container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 1.5rem;
}

/* ============================================
   Header
   ============================================ */
.agenda-page__header {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.agenda-page__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-light);
}

.agenda-page__subtitle {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
}

.agenda-page__create-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background-color: var(--primary);
    color: var(--background);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s;
    width: 100%;
}

.agenda-page__create-btn:hover {
    background-color: var(--primary-hover);
    transform: scale(1.02);
}

.agenda-page__create-icon {
    width: 1rem;
    height: 1rem;
}

/* ============================================
   Filters Section
   ============================================ */
.filters-section {
    background-color: var(--background-light);
    border-radius: 0.5rem;
    padding: 0.75rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(234, 183, 81, 0.2);
}

.filters-section__container {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.filters-section__group {
    flex: 1;
    min-width: 150px;
}

.filters-section__label {
    display: block;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}

.filters-section__select {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    background-color: var(--background-dark);
    border: 1px solid rgba(234, 183, 81, 0.3);
    color: var(--text-light);
    font-size: 0.875rem;
}

.filters-section__select:focus {
    outline: none;
    border-color: var(--primary);
}

.filters-section__reset-btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    background-color: var(--background-dark);
    border: 1px solid rgba(234, 183, 81, 0.3);
    color: var(--text-light);
    font-size: 0.875rem;
    transition: color 0.3s;
}

.filters-section__reset-btn:hover {
    color: var(--primary);
}

.filters-section__count {
    font-size: 0.75rem;
    color: var(--text-muted);
    align-self: flex-end;
}

.filters-section__count-number {
    font-weight: 600;
}

/* ============================================
   Loading State
   ============================================ */
.agenda-page__loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 0;
}

.agenda-page__loading-spinner {
    width: 2.5rem;
    height: 2.5rem;
    border: 3px solid var(--primary);
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.agenda-page__loading p {
    margin-top: 1rem;
    color: var(--text-muted);
}

/* ============================================
   Error State
   ============================================ */
.agenda-page__error {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background-color: #ef4444;
    color: white;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.agenda-page__error-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* ============================================
   Agenda Grid
   ============================================ */
.agenda-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
}

/* ============================================
   Agenda Card
   ============================================ */
.agenda-card {
    background-color: var(--background-light);
    border-radius: 0.75rem;
    border: 2px solid rgba(234, 183, 81, 0.2);
    overflow: hidden;
    transition: all 0.3s;
}

.agenda-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.agenda-card--lol {
    border-color: rgba(59, 130, 246, 0.5);
}

.agenda-card--khll {
    border-color: rgba(245, 158, 11, 0.5);
}

.agenda-card--activiteiten {
    border-color: rgba(16, 185, 129, 0.5);
}

.agenda-card__color-bar {
    height: 0.25rem;
    transition: height 0.3s;
}

.agenda-card:hover .agenda-card__color-bar {
    height: 0.5rem;
}

.agenda-card__image {
    position: relative;
    height: 8rem;
    overflow: hidden;
}

.agenda-card__image-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.agenda-card:hover .agenda-card__image-img {
    transform: scale(1.05);
}

.agenda-card__content {
    padding: 0.75rem;
}

/* ============================================
   Card Header (Badges & Actions)
   ============================================ */
.agenda-card__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.5rem;
}

.agenda-card__badges {
    display: flex;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.agenda-card__badge {
    font-size: 0.625rem;
    padding: 0.125rem 0.375rem;
    border-radius: 9999px;
    font-weight: 500;
    color: white;
}

.agenda-card__badge--visible {
    background-color: #10b981;
}

.agenda-card__badge--scheduled {
    background-color: #f97316;
}

.agenda-card__actions {
    display: flex;
    gap: 0.25rem;
    opacity: 0;
    transition: opacity 0.3s;
}

.agenda-card:hover .agenda-card__actions {
    opacity: 1;
}

.agenda-card__action {
    padding: 0.25rem;
    border-radius: 0.5rem;
    transition: all 0.3s;
}

.agenda-card__action svg {
    width: 0.875rem;
    height: 0.875rem;
}

.agenda-card__action--edit {
    color: var(--primary);
}

.agenda-card__action--edit:hover {
    background-color: var(--primary);
    color: var(--background);
}

.agenda-card__action--delete {
    color: #ef4444;
}

.agenda-card__action--delete:hover {
    background-color: #ef4444;
    color: white;
}

/* ============================================
   Card Body
   ============================================ */
.agenda-card__title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 0.25rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.agenda-card__description {
    font-size: 0.75rem;
    color: var(--text-muted);
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

/* ============================================
   Card Details
   ============================================ */
.agenda-card__details {
    margin: 0.5rem 0;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.agenda-card__detail {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.agenda-card__detail-icon {
    width: 0.875rem;
    height: 0.875rem;
}

.agenda-card__location {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.agenda-card__detail--small {
    font-size: 0.625rem;
}

/* ============================================
   Card Footer
   ============================================ */
.agenda-card__footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 0.5rem;
    border-top: 1px solid rgba(234, 183, 81, 0.2);
}

.agenda-card__category {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.agenda-card__category-dot {
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 9999px;
}

.agenda-card__category-label {
    font-size: 0.625rem;
    font-weight: 500;
    color: var(--text-light);
}

.agenda-card__date {
    font-size: 0.625rem;
    color: var(--text-muted);
}

/* ============================================
   Empty State
   ============================================ */
.agenda-page__empty {
    text-align: center;
    padding: 2rem 0;
}

.agenda-page__empty-icon {
    width: 4rem;
    height: 4rem;
    margin: 0 auto 1rem;
    color: var(--text-muted);
}

.agenda-page__empty-title {
    color: var(--text-muted);
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.agenda-page__empty-btn {
    color: var(--primary);
    font-size: 0.875rem;
    font-weight: 500;
    transition: color 0.3s;
}

.agenda-page__empty-btn:hover {
    color: var(--primary-hover);
}

/* ============================================
   Category Background Classes
   ============================================ */
.category-bg--lol {
    background-color: #3b82f6;
}

.category-bg--khll {
    background-color: #f59e0b;
}

.category-bg--activiteiten {
    background-color: #10b981;
}

/* ============================================
   Badge Classes
   ============================================ */
.badge--concept {
    background-color: #eab308;
}

.badge--published {
    background-color: #10b981;
}

.badge--cancelled {
    background-color: #ef4444;
}

/* ============================================
   Modal Overlay
   ============================================ */
.modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
    padding: 0.5rem;
}

.modal-container {
    background-color: var(--background-light);
    border-radius: 1rem;
    width: 100%;
    max-width: 56rem;
    max-height: 90vh;
    overflow-y: auto;
}

/* Modal Header */
.modal-header {
    position: sticky;
    top: 0;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.3) 0%, rgba(234, 183, 81, 0.05) 100%);
    border-bottom: 1px solid rgba(234, 183, 81, 0.2);
    padding: 0.75rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header__title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-light);
}

.modal-header__subtitle {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
}

.modal-header__close {
    color: var(--text-muted);
    transition: color 0.3s;
}

.modal-header__close svg {
    width: 1.25rem;
    height: 1.25rem;
}

.modal-header__close:hover {
    color: var(--primary);
}

/* Modal Form */
.modal-form {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Form Groups */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group__label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-light);
}

.form-group__required {
    color: #ef4444;
}

.form-group__input,
.form-group__textarea,
.form-group__file {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border-radius: 0.75rem;
    background-color: var(--background-dark);
    border: 2px solid rgba(234, 183, 81, 0.2);
    color: var(--text-light);
    font-size: 0.875rem;
}

.form-group__input:focus,
.form-group__textarea:focus {
    outline: none;
    border-color: var(--primary);
}

.form-group__textarea {
    resize: vertical;
    min-height: 100px;
}

.form-group__hint {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.form-group__preview {
    margin-top: 0.5rem;
}

.form-group__preview-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.form-group__preview-image {
    position: relative;
    display: inline-block;
}

.form-group__preview-img {
    width: 6rem;
    height: 6rem;
    object-fit: cover;
    border-radius: 0.5rem;
}

.form-group__preview-remove {
    position: absolute;
    top: -0.5rem;
    right: -0.5rem;
    background-color: #ef4444;
    color: white;
    border-radius: 9999px;
    padding: 0.25rem;
    transition: background-color 0.3s;
}

.form-group__preview-remove svg {
    width: 0.75rem;
    height: 0.75rem;
}

.form-group__preview-remove:hover {
    background-color: #dc2626;
}

/* Form Row */
.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.75rem;
}

/* Status Buttons */
.status-buttons {
    display: flex;
    gap: 0.25rem;
}

.status-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.75rem;
    border: 2px solid rgba(234, 183, 81, 0.2);
    font-weight: 500;
    transition: all 0.3s;
    font-size: 0.75rem;
}

.status-btn__icon {
    font-size: 0.875rem;
}

.status-btn__label {
    display: none;
}

.status-btn--active.status-btn--concept {
    background-color: #eab308;
    border-color: #eab308;
    color: white;
}

.status-btn--active.status-btn--published {
    background-color: #10b981;
    border-color: #10b981;
    color: white;
}

.status-btn--active.status-btn--cancelled {
    background-color: #ef4444;
    border-color: #ef4444;
    color: white;
}

.status-btn--inactive {
    background-color: var(--background-dark);
    border-color: rgba(234, 183, 81, 0.2);
    color: var(--text-light);
}

.status-btn--inactive:hover {
    background-color: rgba(234, 183, 81, 0.1);
    border-color: var(--primary);
}

/* Category Buttons */
.category-buttons {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.5rem;
}

.category-btn {
    border-radius: 0.75rem;
    transition: all 0.3s;
}

.category-btn:hover {
    transform: scale(1.02);
}

.category-btn--active {
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.3);
}

.category-btn__content {
    padding: 0.5rem;
    text-align: center;
    border-radius: 0.75rem;
    color: white;
}

.category-btn__label {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0.125rem;
}

.category-btn__description {
    font-size: 0.625rem;
    opacity: 0.9;
    display: none;
}

.gradient--lol {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
}

.gradient--khll {
    background: linear-gradient(135deg, #d97706, #f59e0b);
}

.gradient--activiteiten {
    background: linear-gradient(135deg, #059669, #10b981);
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(234, 183, 81, 0.2);
}

.form-actions__cancel {
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    background-color: var(--background-dark);
    border: 2px solid rgba(234, 183, 81, 0.2);
    color: var(--text-light);
    font-size: 0.875rem;
    font-weight: 500;
    transition: border-color 0.3s;
}

.form-actions__cancel:hover {
    border-color: var(--primary);
}

.form-actions__submit {
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: var(--background);
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s;
}

.form-actions__submit:hover:not(:disabled) {
    transform: scale(1.02);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.form-actions__submit:disabled {
    opacity: 0.5;
}

.form-actions__submit-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-actions__spinner {
    width: 1rem;
    height: 1rem;
    border: 2px solid var(--background);
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* ============================================
   Animations
   ============================================ */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* ============================================
   Responsive Design
   ============================================ */

/* Tablet (640px - 768px) */
@media (min-width: 640px) {
    .agenda-page__container {
        padding: 1.5rem;
    }

    .agenda-page__header {
        flex-direction: row;
        align-items: center;
    }

    .agenda-page__create-btn {
        width: auto;
    }

    .agenda-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-row {
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .category-buttons {
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .category-btn__description {
        display: block;
    }

    .status-btn__label {
        display: inline;
    }

    .modal-form {
        padding: 1.5rem;
    }

    .modal-header {
        padding: 1rem 1.5rem;
    }
}

/* Desktop (1024px+) */
@media (min-width: 1024px) {
    .agenda-page__title {
        font-size: 1.875rem;
    }

    .agenda-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .filters-section__container {
        flex-direction: row;
        align-items: flex-end;
    }

    .filters-section__count {
        align-self: auto;
    }

    .agenda-card__image {
        height: 10rem;
    }

    .agenda-card__content {
        padding: 1.25rem;
    }

    .agenda-card__title {
        font-size: 1.125rem;
    }

    .modal-header__title {
        font-size: 1.5rem;
    }

    .category-btn__label {
        font-size: 1.25rem;
    }
}
</style>
