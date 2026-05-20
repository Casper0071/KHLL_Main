// resources/js/composables/useAgenda.js
import { ref } from 'vue'
import { useApi } from './useApi'

export function useAgenda() {
    const { get, post, put, delete: deleteRequest, loading, error } = useApi()
    const agendaItems = ref([])
    const currentItem = ref(null)
    const filters = ref({
        status: '',
        search: '',
        start_date: '',
        end_date: ''
    })

    // Alle agenda items ophalen
    const fetchAgendaItems = async () => {
        const queryParams = new URLSearchParams()
        if (filters.value.status) queryParams.append('status', filters.value.status)
        if (filters.value.search) queryParams.append('search', filters.value.search)
        if (filters.value.start_date) queryParams.append('start_date', filters.value.start_date)
        if (filters.value.end_date) queryParams.append('end_date', filters.value.end_date)

        const url = `/agenda${queryParams.toString() ? '?' + queryParams.toString() : ''}`
        const result = await get(url)

        if (result.success) {
            // De items zitten in result.data.data (vanwege de API response structuur)
            agendaItems.value = result.data.data || result.data
            console.log('Agenda items geladen:', agendaItems.value.length, 'items')
        } else {
            console.error('Error loading agenda items:', result.error)
        }
        return result
    }

    // Enkel agenda item ophalen
    const fetchAgendaItem = async (id) => {
        const result = await get(`/agenda/${id}`)
        if (result.success) {
            currentItem.value = result.data.data || result.data
        }
        return result
    }

    // Agenda item aanmaken
    const createAgendaItem = async (itemData) => {
        const isFormData = itemData instanceof FormData
        const headers = isFormData ? { 'Content-Type': 'multipart/form-data' } : {}
        const result = await post('/agenda', itemData, headers)
        if (result.success) {
            await fetchAgendaItems()
        }
        return result
    }

    const updateAgendaItem = async (id, itemData) => {
        const isFormData = itemData instanceof FormData
        const headers = isFormData ? { 'Content-Type': 'multipart/form-data' } : {}
        const result = await post(`/agenda/${id}`, itemData, headers)
        if (result.success) {
            await fetchAgendaItems()
        }
        return result
    }

    // Agenda item verwijderen
    const deleteAgendaItem = async (id) => {
        const result = await deleteRequest(`/agenda/${id}`)
        if (result.success) {
            await fetchAgendaItems()
        }
        return result
    }

    // Filters bijwerken
    const updateFilters = (newFilters) => {
        filters.value = { ...filters.value, ...newFilters }
        fetchAgendaItems()
    }

    return {
        agendaItems,
        currentItem,
        loading,
        error,
        filters,
        fetchAgendaItems,
        fetchAgendaItem,
        createAgendaItem,
        updateAgendaItem,
        deleteAgendaItem,
        updateFilters
    }
}
