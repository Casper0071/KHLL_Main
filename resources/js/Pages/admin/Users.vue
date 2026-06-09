<template>
    <div class="users-page">
        <div class="users-page__container">
            <!-- Header -->
            <div class="users-page__header">
                <div>
                    <h1 class="users-page__title">Gebruikers Beheer</h1>
                    <p class="users-page__subtitle">Beheer gebruikers en rollen</p>
                </div>
                <button
                    @click="openCreateModal"
                    class="users-page__create-btn"
                >
                    <svg class="users-page__create-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Nieuwe Gebruiker</span>
                </button>
            </div>

            <!-- Loading State -->
            <div v-if="isLoading" class="users-page__loading">
                <div class="users-page__loading-spinner"></div>
                <p>Gebruikers laden...</p>
            </div>

            <!-- Users Table - Desktop versie -->
            <div v-else class="users-table-container">
                <div class="users-table__wrapper">
                    <table class="users-table">
                        <thead class="users-table__header">
                        <tr>
                            <th class="users-table__th">ID</th>
                            <th class="users-table__th">Naam</th>
                            <th class="users-table__th">Email</th>
                            <th class="users-table__th">Rol</th>
                            <th class="users-table__th">Aangemaakt</th>
                            <th class="users-table__th users-table__th--actions">Acties</th>
                        </tr>
                        </thead>
                        <tbody class="users-table__body">
                        <tr v-for="user in users" :key="user.id" class="users-table__row">
                            <td class="users-table__td">{{ user.id }}</td>
                            <td class="users-table__td">{{ user.name }}</td>
                            <td class="users-table__td users-table__td--email">{{ user.email }}</td>
                            <td class="users-table__td">
                                    <span class="role-badge" :class="getRoleBadgeClass(user.role)">
                                        {{ getRoleLabel(user.role) }}
                                    </span>
                            </td>
                            <td class="users-table__td users-table__td--date">{{ formatDate(user.created_at) }}</td>
                            <td class="users-table__td users-table__td--actions">
                                <div class="users-table__actions">
                                    <button @click="openEditModal(user)" class="action-btn action-btn--edit" title="Bewerken">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button v-if="user.id !== currentUserId" @click="handleDelete(user.id)" class="action-btn action-btn--delete" title="Verwijderen">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Users Cards - Mobiele versie -->
                <div class="users-cards">
                    <div v-if="users.length === 0" class="users-empty">
                        <svg class="users-empty__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <p class="users-empty__title">Geen gebruikers gevonden</p>
                        <button @click="openCreateModal" class="users-empty__btn">
                            + Maak je eerste gebruiker aan
                        </button>
                    </div>
                    <div v-else v-for="user in users" :key="user.id" class="user-card">
                        <div class="user-card__header">
                            <div class="user-card__avatar">
                                <span class="user-card__avatar-initial">{{ getUserInitial(user.name) }}</span>
                            </div>
                            <div class="user-card__info">
                                <h3 class="user-card__name">{{ user.name }}</h3>
                                <p class="user-card__email">{{ user.email }}</p>
                            </div>
                            <div class="user-card__actions">
                                <button @click="openEditModal(user)" class="action-btn action-btn--edit" title="Bewerken">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button v-if="user.id !== currentUserId" @click="handleDelete(user.id)" class="action-btn action-btn--delete" title="Verwijderen">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="user-card__details">
                            <div class="user-card__detail">
                                <span class="user-card__detail-label">ID:</span>
                                <span class="user-card__detail-value">#{{ user.id }}</span>
                            </div>
                            <div class="user-card__detail">
                                <span class="user-card__detail-label">Rol:</span>
                                <span class="user-card__detail-badge" :class="getRoleBadgeClass(user.role)">
                                    {{ getRoleLabel(user.role) }}
                                </span>
                            </div>
                            <div class="user-card__detail">
                                <span class="user-card__detail-label">Aangemaakt:</span>
                                <span class="user-card__detail-value">{{ formatDate(user.created_at) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Modal -->
            <div v-if="showModal" class="modal-overlay">
                <div class="modal-container modal-container--user">
                    <div class="modal-header">
                        <div>
                            <h2 class="modal-header__title">
                                {{ isEditing ? 'Bewerk Gebruiker' : 'Nieuwe Gebruiker' }}
                            </h2>
                        </div>
                        <button @click="closeModal" class="modal-header__close">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form @submit.prevent="saveUser" class="modal-form">
                        <!-- Naam veld -->
                        <div class="form-group">
                            <label class="form-group__label">Naam <span class="form-group__required">*</span></label>
                            <input
                                v-model="userForm.name"
                                type="text"
                                required
                                class="form-group__input"
                                :class="{ 'form-group__input--error': errors.name }"
                            />
                            <p v-if="errors.name" class="form-group__error">{{ errors.name[0] }}</p>
                        </div>

                        <!-- Email veld -->
                        <div class="form-group">
                            <label class="form-group__label">Email <span class="form-group__required">*</span></label>
                            <input
                                v-model="userForm.email"
                                type="email"
                                required
                                class="form-group__input"
                                :class="{ 'form-group__input--error': errors.email }"
                            />
                            <p v-if="errors.email" class="form-group__error">{{ errors.email[0] }}</p>
                        </div>

                        <!-- Wachtwoord veld -->
                        <div class="form-group">
                            <label class="form-group__label">
                                Wachtwoord {{ isEditing ? '(laat leeg om niet te wijzigen)' : '*' }}
                            </label>
                            <input
                                v-model="userForm.password"
                                type="password"
                                :required="!isEditing"
                                class="form-group__input"
                                :class="{ 'form-group__input--error': errors.password }"
                            />
                            <p v-if="errors.password" class="form-group__error">{{ errors.password[0] }}</p>
                            <p v-else class="form-group__hint">Minimaal 6 tekens</p>
                        </div>

                        <!-- Rol veld -->
                        <div class="form-group">
                            <label class="form-group__label">Rol <span class="form-group__required">*</span></label>
                            <select
                                v-model="userForm.role"
                                class="form-group__select"
                            >
                                <option value="user">Gebruiker</option>
                                <option value="admin">Admin</option>
                            </select>
                            <p v-if="errors.role" class="form-group__error">{{ errors.role[0] }}</p>
                        </div>

                        <!-- Algemene error message -->
                        <div v-if="generalError" class="form-group__general-error">
                            {{ generalError }}
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="button" @click="closeModal" class="form-actions__cancel">
                                Annuleren
                            </button>
                            <button type="submit" :disabled="isSaving" class="form-actions__submit">
                                <div class="form-actions__submit-content">
                                    <div v-if="isSaving" class="form-actions__spinner"></div>
                                    <span>{{ isEditing ? 'Bijwerken' : 'Aanmaken' }}</span>
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
import axios from 'axios'
import AdminLayout from "@/Layouts/AdminLayout.vue"

defineOptions({
    layout: AdminLayout
})

// ============================================
// Reactive State
// ============================================

/** Lijst van alle gebruikers */
const users = ref([])

/** Loading state voor het ophalen van gebruikers */
const isLoading = ref(false)

/** Loading state voor het opslaan van een gebruiker */
const isSaving = ref(false)

/** Toon modal */
const showModal = ref(false)

/** Of we een gebruiker bewerken of toevoegen */
const isEditing = ref(false)

/** De geselecteerde gebruiker voor bewerken */
const selectedUser = ref(null)

/** ID van de huidige ingelogde gebruiker */
const currentUserId = ref(null)

/** Algemene error message */
const generalError = ref('')

/** Veld-specifieke errors */
const errors = ref({
    name: null,
    email: null,
    password: null,
    role: null
})

/** Formulier data voor gebruiker */
const userForm = ref({
    name: '',
    email: '',
    password: '',
    role: 'user'
})

// ============================================
// Constants
// ============================================

const roleLabels = {
    admin: 'Admin',
    user: 'Gebruiker'
}

const roleClasses = {
    admin: 'role-badge--admin',
    user: 'role-badge--user'
}

// ============================================
// Methods
// ============================================

/** Formatteer datum voor weergave */
const formatDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('nl-NL', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

/** Haal de eerste letter van een naam voor de avatar */
const getUserInitial = (name) => {
    if (!name) return '?'
    return name.charAt(0).toUpperCase()
}

/** Haal het label voor een rol */
const getRoleLabel = (role) => {
    return roleLabels[role] || 'Gebruiker'
}

/** Haal de CSS class voor een rol badge */
const getRoleBadgeClass = (role) => {
    return roleClasses[role] || 'role-badge--user'
}

/** Reset het formulier */
const resetForm = () => {
    userForm.value = {
        name: '',
        email: '',
        password: '',
        role: 'user'
    }
    errors.value = { name: null, email: null, password: null, role: null }
    generalError.value = ''
}

/** Sluit de modal en reset het formulier */
const closeModal = () => {
    showModal.value = false
    resetForm()
    isEditing.value = false
    selectedUser.value = null
}

/** Open modal voor nieuwe gebruiker */
const openCreateModal = () => {
    resetForm()
    isEditing.value = false
    selectedUser.value = null
    showModal.value = true
}

/** Open modal voor bewerken van een gebruiker */
const openEditModal = (user) => {
    isEditing.value = true
    selectedUser.value = user
    userForm.value = {
        name: user.name,
        email: user.email,
        password: '',
        role: user.role
    }
    errors.value = { name: null, email: null, password: null, role: null }
    generalError.value = ''
    showModal.value = true
}

/** Haal alle gebruikers op via de API */
const fetchUsers = async () => {
    isLoading.value = true
    try {
        const response = await axios.get('/api/users')
        users.value = response.data.data || []
    } catch (error) {
        console.error('Fout bij laden gebruikers:', error)
        generalError.value = 'Fout bij laden gebruikers'
    } finally {
        isLoading.value = false
    }
}

/** Sla een gebruiker op (nieuw of bijwerken) */
const saveUser = async () => {
    isSaving.value = true
    generalError.value = ''
    errors.value = { name: null, email: null, password: null, role: null }

    try {
        const data = {
            name: userForm.value.name,
            email: userForm.value.email,
            role: userForm.value.role
        }

        // Alleen wachtwoord toevoegen als het is ingevuld
        if (userForm.value.password && userForm.value.password.trim() !== '') {
            data.password = userForm.value.password
        }

        // Voor nieuwe gebruiker is wachtwoord verplicht
        if (!isEditing.value && (!data.password || data.password.trim() === '')) {
            errors.value.password = ['Wachtwoord is verplicht voor nieuwe gebruikers']
            isSaving.value = false
            return
        }

        let response
        if (isEditing.value && selectedUser.value) {
            response = await axios.put(`/api/users/${selectedUser.value.id}`, data)
        } else {
            response = await axios.post('/api/users', data)
        }

        if (response.data.success) {
            closeModal()
            fetchUsers()
        }
    } catch (error) {
        console.error('Fout bij opslaan gebruiker:', error)

        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors
        } else if (error.response?.data?.message) {
            generalError.value = error.response.data.message
        } else {
            generalError.value = 'Fout bij opslaan gebruiker'
        }
    } finally {
        isSaving.value = false
    }
}

/** Verwijder een gebruiker */
const handleDelete = async (id) => {
    if (confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')) {
        try {
            await axios.delete(`/api/users/${id}`)
            fetchUsers()
        } catch (error) {
            console.error('Fout bij verwijderen gebruiker:', error)
            alert('Fout bij verwijderen: ' + (error.response?.data?.message || 'Onbekende fout'))
        }
    }
}

/** Haal de huidige ingelogde gebruiker op */
const getCurrentUser = () => {
    const storedUser = localStorage.getItem('user')
    if (storedUser) {
        const user = JSON.parse(storedUser)
        currentUserId.value = user.id
    }
}

// ============================================
// Lifecycle Hooks
// ============================================

onMounted(() => {
    getCurrentUser()
    fetchUsers()
})
</script>

<style scoped>
/* ============================================
   Users Page Container
   ============================================ */
.users-page {
    min-height: 100vh;
    background-color: var(--background);
}

.users-page__container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 1rem;
}

/* ============================================
   Header
   ============================================ */
.users-page__header {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.users-page__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-light);
}

.users-page__subtitle {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
}

.users-page__create-btn {
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

.users-page__create-btn:hover {
    background-color: var(--primary-hover);
    transform: scale(1.02);
}

.users-page__create-icon {
    width: 1rem;
    height: 1rem;
}

/* ============================================
   Loading State
   ============================================ */
.users-page__loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 0;
}

.users-page__loading-spinner {
    width: 2.5rem;
    height: 2.5rem;
    border: 3px solid var(--primary);
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.users-page__loading p {
    margin-top: 1rem;
    color: var(--text-muted);
}

/* ============================================
   Users Table (Desktop)
   ============================================ */
.users-table-container {
    background-color: var(--background-light);
    border-radius: 0.75rem;
    border: 1px solid rgba(234, 183, 81, 0.2);
    overflow: hidden;
}

.users-table__wrapper {
    overflow-x: auto;
}

.users-table {
    width: 100%;
    min-width: 640px;
    border-collapse: collapse;
}

.users-table__header {
    background-color: var(--background-dark);
}

.users-table__th {
    padding: 0.75rem 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    color: var(--text-muted);
}

.users-table__th--actions {
    text-align: right;
}

.users-table__body {
    border-top: 1px solid rgba(234, 183, 81, 0.1);
}

.users-table__row {
    transition: background-color 0.3s;
}

.users-table__row:hover {
    background-color: rgba(234, 183, 81, 0.05);
}

.users-table__td {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    color: var(--text-light);
}

.users-table__td--email {
    word-break: break-all;
}

.users-table__td--date {
    white-space: nowrap;
}

.users-table__td--actions {
    text-align: right;
}

.users-table__actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

/* ============================================
   Users Cards (Mobile)
   ============================================ */
.users-cards {
    display: none;
}

.user-card {
    background-color: var(--background-light);
    border-radius: 0.75rem;
    border: 1px solid rgba(234, 183, 81, 0.2);
    padding: 1rem;
    margin-bottom: 0.75rem;
}

.user-card__header {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.user-card__avatar {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 9999px;
    background-color: rgba(234, 183, 81, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.user-card__avatar-initial {
    color: var(--primary);
    font-size: 1rem;
    font-weight: 700;
}

.user-card__info {
    flex: 1;
    min-width: 0;
}

.user-card__name {
    font-weight: 600;
    color: var(--text-light);
    font-size: 0.875rem;
}

.user-card__email {
    font-size: 0.75rem;
    color: var(--text-muted);
    word-break: break-all;
}

.user-card__actions {
    display: flex;
    gap: 0.25rem;
}

.user-card__details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.user-card__detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-card__detail-label {
    color: var(--text-muted);
}

.user-card__detail-value {
    color: var(--text-light);
}

.user-card__detail-badge {
    padding: 0.125rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    color: white;
}

/* ============================================
   Empty State
   ============================================ */
.users-empty {
    text-align: center;
    padding: 3rem 0;
}

.users-empty__icon {
    width: 4rem;
    height: 4rem;
    margin: 0 auto 1rem;
    color: var(--text-muted);
}

.users-empty__title {
    color: var(--text-muted);
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.users-empty__btn {
    color: var(--primary);
    font-size: 0.875rem;
    font-weight: 500;
    transition: color 0.3s;
}

.users-empty__btn:hover {
    color: var(--primary-hover);
}

/* ============================================
   Role Badges
   ============================================ */
.role-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    color: white;
    white-space: nowrap;
}

.role-badge--admin {
    background-color: #10b981;
}

.role-badge--user {
    background-color: #3b82f6;
}

/* ============================================
   Action Buttons
   ============================================ */
.action-btn {
    padding: 0.25rem;
    border-radius: 0.5rem;
    transition: all 0.3s;
}

.action-btn svg {
    width: 1rem;
    height: 1rem;
}

.action-btn--edit {
    color: var(--primary);
}

.action-btn--edit:hover {
    background-color: var(--primary);
    color: var(--background);
}

.action-btn--delete {
    color: #ef4444;
}

.action-btn--delete:hover {
    background-color: #ef4444;
    color: white;
}

/* ============================================
   Modal
   ============================================ */
.modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.6);
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
    max-width: 28rem;
    max-height: 95vh;
    overflow-y: auto;
    animation: fadeIn 0.2s ease-out;
}

.modal-header {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid rgba(234, 183, 81, 0.2);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header__title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-light);
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

.modal-form {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* ============================================
   Form Groups
   ============================================ */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
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
.form-group__select {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    background-color: var(--background-dark);
    border: 1px solid rgba(234, 183, 81, 0.3);
    color: var(--text-light);
    font-size: 0.875rem;
}

.form-group__input:focus,
.form-group__select:focus {
    outline: none;
    border-color: var(--primary);
}

.form-group__input--error {
    border-color: #ef4444;
}

.form-group__error {
    color: #ef4444;
    font-size: 0.75rem;
}

.form-group__hint {
    color: var(--text-muted);
    font-size: 0.75rem;
}

.form-group__general-error {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid #ef4444;
    color: #ef4444;
    padding: 0.5rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
}

/* ============================================
   Form Actions
   ============================================ */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding-top: 0.5rem;
}

.form-actions__cancel {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    background-color: #4b5563;
    color: white;
    font-size: 0.875rem;
    font-weight: 500;
    transition: background-color 0.3s;
}

.form-actions__cancel:hover {
    background-color: #374151;
}

.form-actions__submit {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    background-color: var(--primary);
    color: var(--background);
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s;
}

.form-actions__submit:hover:not(:disabled) {
    background-color: var(--primary-hover);
    transform: scale(1.02);
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

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* ============================================
   Responsive Design
   ============================================ */

/* Tablet (640px - 768px) */
@media (min-width: 640px) {
    .users-page__container {
        padding: 1.5rem;
    }

    .users-page__header {
        flex-direction: row;
        align-items: center;
    }

    .users-page__create-btn {
        width: auto;
    }

    .users-table__th,
    .users-table__td {
        padding: 0.75rem 1.5rem;
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
    .users-page__title {
        font-size: 1.875rem;
    }

    .users-table__th,
    .users-table__td {
        padding: 0.75rem 1.5rem;
    }
}

/* Mobile (max 768px) - Toon cards, verberg tabel */
@media (max-width: 768px) {
    .users-table-container {
        border: none;
        background: transparent;
    }

    .users-table__wrapper {
        display: none;
    }

    .users-cards {
        display: block;
    }
}

/* Extra kleine schermen (max 480px) */
@media (max-width: 480px) {
    .users-page__container {
        padding: 0.75rem;
    }

    .users-page__title {
        font-size: 1.25rem;
    }

    .user-card {
        padding: 0.75rem;
    }

    .user-card__avatar {
        width: 2rem;
        height: 2rem;
    }

    .user-card__avatar-initial {
        font-size: 0.875rem;
    }

    .action-btn svg {
        width: 0.875rem;
        height: 0.875rem;
    }
}
</style>
