import { ref, computed } from 'vue'
import homeNL from '@/../../resources/lang/nl/home.json'
import homeEN from '@/../../resources/lang/en/home.json'

// Shared locale ref
const currentLocale = ref(typeof window !== 'undefined' ? localStorage.getItem('locale') || 'nl' : 'nl')

const translations = {
    nl: homeNL,
    en: homeEN
}

export function useTranslations() {
    const t = computed(() => translations[currentLocale.value])
    
    const setLocale = (locale) => {
        currentLocale.value = locale
        if (typeof window !== 'undefined') {
            localStorage.setItem('locale', locale)
        }
    }
    
    const getLocale = () => currentLocale.value
    
    return {
        t,
        setLocale,
        getLocale,
        currentLocale
    }
}
