import { ref, computed } from 'vue'
import homeNL from '@/../../resources/lang/nl/home.json'
import homeEN from '@/../../resources/lang/en/home.json'
import footerNL from '@/../../resources/lang/nl/footer.json'
import footerEN from '@/../../resources/lang/en/footer.json'
import navigationNL from '@/../../resources/lang/nl/navigation.json'
import navigationEN from '@/../../resources/lang/en/navigation.json'

// Shared locale ref
const currentLocale = ref(typeof window !== 'undefined' ? localStorage.getItem('locale') || 'nl' : 'nl')

const translations = {
    nl: {
        ...homeNL,
        footer: footerNL,
        navigation: navigationNL
    },
    en: {
        ...homeEN,
        footer: footerEN,
        navigation: navigationEN
    }
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
