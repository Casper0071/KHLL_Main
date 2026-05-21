<!-- Pages/admin/Users.vue -->
<template>
    <div class="p-4 sm:p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-text-light">Gebruikers Beheer</h1>
                <p class="text-text-muted text-sm mt-1">Beheer gebruikers en rollen</p>
            </div>
            <button
                @click="openCreateModal"
                class="bg-primary text-background px-3 py-2 sm:px-4 sm:py-2 rounded-lg hover:bg-primary-hover transition flex items-center gap-2 text-sm sm:text-base w-full sm:w-auto justify-center"
            >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nieuwe Gebruiker
            </button>
        </div>

        <!-- Loading -->
        <div v-if="loading" class="flex justify-center py-12">
            <div class="animate-spin rounded-full h-10 w-10 sm:h-12 sm:w-12 border-b-2 border-primary"></div>
        </div>

        <!-- Content when not loading -->
        <template v-else>
            <!-- Users Table - Desktop versie -->
            <div class="hidden md:block bg-background-light rounded-xl overflow-x-auto border border-primary border-opacity-20">
                <table class="min-w-full">
                    <thead class="bg-background-dark">
                    <tr>
                        <th class="px-3 py-3 sm:px-6 text-left text-xs font-medium text-text-muted uppercase">ID</th>
                        <th class="px-3 py-3 sm:px-6 text-left text-xs font-medium text-text-muted uppercase">Naam</th>
                        <th class="px-3 py-3 sm:px-6 text-left text-xs font-medium text-text-muted uppercase">Email</th>
                        <th class="px-3 py-3 sm:px-6 text-left text-xs font-medium text-text-muted uppercase">Rol</th>
                        <th class="px-3 py-3 sm:px-6 text-left text-xs font-medium text-text-muted uppercase">Aangemaakt</th>
                        <th class="px-3 py-3 sm:px-6 text-right text-xs font-medium text-text-muted uppercase">Acties</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-primary divide-opacity-10">
                    <tr v-for="user in users" :key="user.id" class="hover:bg-background-dark/30 transition">
                        <td class="px-3 py-3 sm:px-6 text-sm text-text-light">{{ user.id }}</td>
                        <td class="px-3 py-3 sm:px-6 text-sm text-text-light">{{ user.name }}</td>
                        <td class="px-3 py-3 sm:px-6 text-sm text-text-light break-all">{{ user.email }}</td>
                        <td class="px-3 py-3 sm:px-6">
                                <span :class="user.role === 'admin' ? 'bg-green-500' : 'bg-blue-500'" class="px-2 py-1 rounded-full text-xs text-white whitespace-nowrap">
                                    {{ user.role === 'admin' ? 'Admin' : 'Gebruiker' }}
                                </span>
                        </td>
                        <td class="px-3 py-3 sm:px-6 text-sm text-text-muted whitespace-nowrap">{{ formatDate(user.created_at) }}</td>
                        <td class="px-3 py-3 sm:px-6 text-right">
                            <div class="flex justify-end gap-1 sm:gap-2">
                                <button @click="openEditModal(user)" class="text-primary hover:text-primary-hover transition p-1" title="Bewerken">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button @click="handleDelete(user.id)" v-if="user.id !== currentUserId" class="text-red-500 hover:text-red-700 transition p-1" title="Verwijderen">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Users Cards - Mobiele versie (onder 768px) -->
            <div class="block md:hidden space-y-3">
                <div v-if="users.length === 0" class="text-center py-12">
                    <svg class="w-16 h-16 sm:w-24 sm:h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <p class="text-text-muted text-base sm:text-lg mb-2">Geen gebruikers gevonden</p>
                    <button @click="openCreateModal" class="text-primary hover:text-primary-hover transition font-medium text-sm sm:text-base">
                        + Maak je eerste gebruiker aan
                    </button>
                </div>
                <div v-else v-for="user in users" :key="user.id" class="bg-background-light rounded-xl border border-primary border-opacity-20 p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                                <span class="text-primary font-bold text-lg">{{ getUserInitial(user.name) }}</span>
                            </div>
                            <div>
                                <h3 class="text-text-light font-semibold">{{ user.name }}</h3>
                                <p class="text-text-muted text-xs break-all">{{ user.email }}</p>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <button @click="openEditModal(user)" class="text-primary hover:text-primary-hover transition p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button @click="handleDelete(user.id)" v-if="user.id !== currentUserId" class="text-red-500 hover:text-red-700 transition p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-text-muted">ID:</span>
                            <span class="text-text-light">#{{ user.id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-muted">Rol:</span>
                            <span :class="user.role === 'admin' ? 'bg-green-500' : 'bg-blue-500'" class="px-2 py-0.5 rounded-full text-xs text-white">
                                {{ user.role === 'admin' ? 'Admin' : 'Gebruiker' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-muted">Aangemaakt:</span>
                            <span class="text-text-light text-right">{{ formatDate(user.created_at) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State - Alleen tonen als er geen users zijn EN niet loading -->
            <div v-if="users.length === 0" class="text-center py-12">
                <svg class="w-16 h-16 sm:w-24 sm:h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <p class="text-text-muted text-base sm:text-lg mb-2">Geen gebruikers gevonden</p>
                <button @click="openCreateModal" class="text-primary hover:text-primary-hover transition font-medium text-sm sm:text-base">
                    + Maak je eerste gebruiker aan
                </button>
            </div>
        </template>

        <!-- User Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-2 sm:p-4">
            <div class="bg-background-light rounded-2xl w-full max-w-md max-h-[95vh] overflow-y-auto mx-2 sm:mx-0">
                <div class="px-4 py-3 sm:px-6 sm:py-4 border-b border-primary border-opacity-20">
                    <h2 class="text-lg sm:text-xl font-bold text-text-light">{{ isEditing ? 'Bewerk Gebruiker' : 'Nieuwe Gebruiker' }}</h2>
                </div>

                <form @submit.prevent="saveUser" class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                    <!-- Naam veld -->
                    <div>
                        <label class="block text-sm font-medium text-text-light mb-1">Naam *</label>
                        <input
                            v-model="userForm.name"
                            type="text"
                            required
                            class="w-full px-3 py-2 rounded-lg bg-background-dark border text-text-light focus:outline-none focus:border-primary text-sm"
                            :class="errors.name ? 'border-red-500' : 'border-primary border-opacity-30'"
                        />
                        <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</p>
                    </div>

                    <!-- Email veld -->
                    <div>
                        <label class="block text-sm font-medium text-text-light mb-1">Email *</label>
                        <input
                            v-model="userForm.email"
                            type="email"
                            required
                            class="w-full px-3 py-2 rounded-lg bg-background-dark border text-text-light focus:outline-none focus:border-primary text-sm"
                            :class="errors.email ? 'border-red-500' : 'border-primary border-opacity-30'"
                        />
                        <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</p>
                    </div>

                    <!-- Wachtwoord veld -->
                    <div>
                        <label class="block text-sm font-medium text-text-light mb-1">
                            Wachtwoord {{ isEditing ? '(laat leeg om niet te wijzigen)' : '*' }}
                        </label>
                        <input
                            v-model="userForm.password"
                            type="password"
                            :required="!isEditing"
                            class="w-full px-3 py-2 rounded-lg bg-background-dark border text-text-light focus:outline-none focus:border-primary text-sm"
                            :class="errors.password ? 'border-red-500' : 'border-primary border-opacity-30'"
                        />
                        <p v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</p>
                        <p v-else class="text-text-muted text-xs mt-1">Minimaal 6 tekens</p>
                    </div>

                    <!-- Rol veld -->
                    <div>
                        <label class="block text-sm font-medium text-text-light mb-1">Rol *</label>
                        <select
                            v-model="userForm.role"
                            class="w-full px-3 py-2 rounded-lg bg-background-dark border border-primary border-opacity-30 text-text-light focus:outline-none focus:border-primary text-sm"
                        >
                            <option value="user">Gebruiker</option>
                            <option value="admin">Admin</option>
                        </select>
                        <p v-if="errors.role" class="text-red-500 text-xs mt-1">{{ errors.role[0] }}</p>
                    </div>

                    <!-- Algemene error message -->
                    <div v-if="generalError" class="bg-red-500/20 border border-red-500 text-red-500 p-2 sm:p-3 rounded-lg text-xs sm:text-sm">
                        {{ generalError }}
                    </div>

                    <div class="flex justify-end gap-2 sm:gap-3 pt-2 sm:pt-4">
                        <button type="button" @click="closeModal" class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg bg-gray-600 hover:bg-gray-700 transition text-sm sm:text-base">
                            Annuleren
                        </button>
                        <button type="submit" :disabled="saving" class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg bg-primary hover:bg-primary-hover transition disabled:opacity-50 text-sm sm:text-base">
                            {{ saving ? 'Bezig...' : (isEditing ? 'Bijwerken' : 'Aanmaken') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AdminLayout from "@/Layouts/AdminLayout.vue";

defineOptions({
    layout: AdminLayout
})

const users = ref([])
const loading = ref(false)
const saving = ref(false)
const showModal = ref(false)
const isEditing = ref(false)
const selectedUser = ref(null)
const currentUserId = ref(null)
const generalError = ref('')
const errors = ref({
    name: null,
    email: null,
    password: null,
    role: null
})

const userForm = ref({
    name: '',
    email: '',
    password: '',
    role: 'user'
})

// Format date for display
const formatDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('nl-NL', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

// Get user initial for avatar
const getUserInitial = (name) => {
    if (!name) return '?'
    return name.charAt(0).toUpperCase()
}

const fetchUsers = async () => {
    loading.value = true
    try {
        const response = await axios.get('/api/users')
        users.value = response.data.data
    } catch (error) {
        console.error('Error fetching users:', error)
        generalError.value = 'Fout bij laden gebruikers'
    } finally {
        loading.value = false
    }
}

const saveUser = async () => {
    saving.value = true
    generalError.value = ''
    errors.value = { name: null, email: null, password: null, role: null }

    try {
        let data = {
            name: userForm.value.name,
            email: userForm.value.email,
            role: userForm.value.role
        }

        if (userForm.value.password && userForm.value.password.trim() !== '') {
            data.password = userForm.value.password
        }

        if (!isEditing.value && (!data.password || data.password.trim() === '')) {
            errors.value.password = ['Wachtwoord is verplicht voor nieuwe gebruikers']
            saving.value = false
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
        console.error('Error saving user:', error)

        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors
        } else if (error.response?.data?.message) {
            generalError.value = error.response.data.message
        } else {
            generalError.value = 'Fout bij opslaan gebruiker'
        }
    } finally {
        saving.value = false
    }
}

const handleDelete = async (id) => {
    if (confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')) {
        try {
            await axios.delete(`/api/users/${id}`)
            fetchUsers()
        } catch (error) {
            console.error('Error deleting user:', error)
            alert('Fout bij verwijderen: ' + (error.response?.data?.message || 'Onbekende fout'))
        }
    }
}

const openCreateModal = () => {
    resetForm()
    isEditing.value = false
    selectedUser.value = null
    errors.value = { name: null, email: null, password: null, role: null }
    generalError.value = ''
    showModal.value = true
}

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

const closeModal = () => {
    showModal.value = false
    resetForm()
}

const resetForm = () => {
    userForm.value = {
        name: '',
        email: '',
        password: '',
        role: 'user'
    }
}

const getCurrentUser = () => {
    const user = localStorage.getItem('user')
    if (user) {
        currentUserId.value = JSON.parse(user).id
    }
}

onMounted(() => {
    getCurrentUser()
    fetchUsers()
})
</script>

<style scoped>
/* Extra kleine schermen (max 320px) */
@media (max-width: 320px) {
    .p-4 {
        padding: 0.75rem;
    }

    .text-2xl {
        font-size: 1.25rem;
    }

    .text-3xl {
        font-size: 1.5rem;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    button .w-5, .w-5 {
        width: 1rem;
        height: 1rem;
    }
}

/* Animatie voor modals */
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

.bg-background-light {
    animation: fadeIn 0.2s ease-out;
}
</style>
