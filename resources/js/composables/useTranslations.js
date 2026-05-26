import { ref, computed } from 'vue'
import homeNL from '@/../../resources/lang/nl/home.json'
import homeEN from '@/../../resources/lang/en/home.json'
import agendaNL from '@/../../resources/lang/nl/agenda.json'
import agendaEN from '@/../../resources/lang/en/agenda.json'
import footerNL from '@/../../resources/lang/nl/footer.json'
import footerEN from '@/../../resources/lang/en/footer.json'
import navigationNL from '@/../../resources/lang/nl/navigation.json'
import navigationEN from '@/../../resources/lang/en/navigation.json'
import opleidingsOrkestNL from '@/../../resources/lang/nl/opleidingsOrkest.json'
import opleidingsOrkestEN from '@/../../resources/lang/en/opleidingsOrkest.json'
import harmonieLentekransNL from '@/../../resources/lang/nl/harmonieLentekrans.json'
import harmonieLentekransEN from '@/../../resources/lang/en/harmonieLentekrans.json'
import contactNL from '@/../../resources/lang/nl/contact.json'
import contactEN from '@/../../resources/lang/en/contact.json'

// Shared locale ref
const currentLocale = ref(typeof window !== 'undefined' ? localStorage.getItem('locale') || 'nl' : 'nl')

const translations = {
    nl: {
        ...homeNL,
        footer: footerNL,
        navigation: navigationNL,
        harmonieLentekrans: harmonieLentekransNL,
        opleidingsOrkest: opleidingsOrkestNL,
        contact: contactNL,
        agenda: agendaNL

    },
    en: {
        ...homeEN,
        footer: footerEN,
        navigation: navigationEN,
        harmonieLentekrans: harmonieLentekransEN,
        opleidingsOrkest: opleidingsOrkestEN,
        contact: contactEN,
        agenda: agendaEN

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
