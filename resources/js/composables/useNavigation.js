/**
 * Navigation Links Composable
 * Centrale plaats om alle navigatie links te beheren
 * Gebruikt door Navbar, Footer en Sidebar
 */

export function useNavigation() {
    // Hoofd navigatie links (voor de horizontale navbar)
    const mainLinks = [
        { href: '/', key: 'home' },
        { href: '/HarmonieLentekrans', key: 'Harmonielentekrans' },
        { href: '/OpleidingsOrkest', key: 'Opleidingsorkest' },
        { href: '/Contact', key: 'contact' },
    ]

    // Sidebar navigatie links (voor de verticale sidebar/admin gedeelte)
    const sidebarLinks = [
        { href: '/admin/dashboard', key: 'dashboard', icon: 'dashboard' },
        { href: '/admin/agenda', key: 'agenda', icon: 'calendar' },
        { href: '/admin/information', key: 'information', icon: 'information' },
    ]

    const getMainLinks = (t) => {
        return mainLinks.map((link) => ({
            ...link,
            label: t.value?.navigation?.[link.key] ?? t.value?.[link.key] ?? link.key,
        }))
    }

    const getSidebarLinks = (t) => {
        return sidebarLinks.map((link) => ({
            ...link,
            label: t.value?.navigation?.[link.key] ?? t.value?.admin?.[link.key] ?? link.key,
        }))
    }

    // Juridische links (footer)
    const getLegalLinks = (t) => {
        return [
            { label: t.value?.footer?.cookies || 'Cookies', href: '/cookies' },
            { label: t.value?.footer?.privacy || 'Privacy', href: '/privacy' },
            { label: t.value?.footer?.disclaimer || 'Disclaimer', href: '/disclaimer' },
        ]
    }

    return {
        mainLinks,
        sidebarLinks,
        getMainLinks,
        getSidebarLinks,
        getLegalLinks,
    }
}
