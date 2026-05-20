/**
 * Navigation Links Composable
 * Centrale plaats om alle navigatie links te beheren
 * Gebruikt door Navbar en Footer
 */

export function useNavigation() {
    // Hoofd navigatie links
    const mainLinks = [
        { href: '/', key: 'home' },
        { href: '/harmonieLentekrans', key: 'Harmonielentekrans' },
        { href: '/opleidingsOrkest', key: 'Opleidingsorkest' },
        { href: '/contact', key: 'contact' },
    ]

    // Hoofd navigatie links mét vertaling vanuit navigation.json
    // (met fallback naar root keys / key zelf)
    const getMainLinks = (t) => {
        return mainLinks.map((link) => ({
            ...link,
            label: t.value?.navigation?.[link.key] ?? t.value?.[link.key] ?? link.key,
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
        getMainLinks,
        getLegalLinks,
    }
}
