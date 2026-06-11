// composables/useNavigation.js
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

    // Sidebar navigatie links met rechten
    const sidebarLinks = [
        { href: '/admin', key: 'dashboard', icon: 'dashboard', requiredRole: null },
        { href: '/admin/agenda', key: 'agenda', icon: 'calendar', requiredRole: null },
        { href: '/admin/information', key: 'information', icon: 'information', requiredRole: null },
        { href: '/admin/users', key: 'users', icon: 'users', requiredRole: 'admin' },
        { href: '/admin/components', key: 'components', icon: 'components', requiredRole: 'admin' },
    ]

    const getMainLinks = (t) => {
        return mainLinks.map((link) => ({
            ...link,
            label: t.value?.navigation?.[link.key] ?? t.value?.[link.key] ?? link.key,
        }))
    }

    const getSidebarLinks = (t, userRole = null) => {
        // Filter links op basis van user role
        const filteredLinks = sidebarLinks.filter(link => {
            if (link.requiredRole && userRole !== link.requiredRole) {
                return false
            }
            return true
        })

        return filteredLinks.map((link) => ({
            ...link,
            label: t.value?.navigation?.admin?.[link.key]
                ?? t.value?.navigation?.[link.key]
                ?? t.value?.admin?.[link.key]
                ?? link.key,
        }))
    }

    // Juridische links (footer)
    const getLegalLinks = (t) => {
        return [
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
