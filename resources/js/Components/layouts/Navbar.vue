<template>
    <nav class="main-navbar">
        <div class="main-navbar__container">
            <div class="main-navbar__header">
                <!-- Logo Links -->
                <div class="main-navbar__logo">
                    <Link href="/" class="main-navbar__logo-link">
                        <img
                            src="/img/logos/logoKroonWit.png"
                            alt="Koninklijke Harmonie Lentekrans Logo"
                            class="main-navbar__logo-image"
                        />
                        <span class="main-navbar__logo-text">{{ t.navigation.title }}</span>
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="main-navbar__desktop-nav">
                    <!-- Links -->
                    <div class="main-navbar__desktop-links">
                        <Link
                            v-for="link in links"
                            :key="link.href"
                            :href="link.href"
                            class="main-navbar__desktop-link"
                            :class="{ 'main-navbar__desktop-link--active': page.url === link.href }"
                        >
                            {{ link.label }}
                        </Link>
                    </div>

                    <!-- Language Switcher -->
                    <div class="main-navbar__language-switcher">
                        <button
                            @click="switchLanguage('nl')"
                            class="main-navbar__lang-btn"
                            :class="{ 'main-navbar__lang-btn--active': currentLocale === 'nl' }"
                        >
                            NL
                        </button>
                        <button
                            @click="switchLanguage('en')"
                            class="main-navbar__lang-btn"
                            :class="{ 'main-navbar__lang-btn--active': currentLocale === 'en' }"
                        >
                            EN
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="main-navbar__mobile-btn"
                >
                    <svg
                        class="main-navbar__mobile-icon"
                        :class="{ 'main-navbar__mobile-icon--hidden': isMobileMenuOpen }"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg
                        class="main-navbar__mobile-icon main-navbar__mobile-icon--close"
                        :class="{ 'main-navbar__mobile-icon--visible': isMobileMenuOpen }"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div
                v-show="isMobileMenuOpen"
                class="main-navbar__mobile-menu"
            >
                <div class="main-navbar__mobile-menu-inner">
                    <!-- Mobile Links -->
                    <Link
                        v-for="link in links"
                        :key="link.href"
                        :href="link.href"
                        @click="closeMenu"
                        class="main-navbar__mobile-link"
                        :class="{ 'main-navbar__mobile-link--active': page.url === link.href }"
                    >
                        {{ link.label }}
                    </Link>

                    <!-- Mobile Language Switcher -->
                    <div class="main-navbar__mobile-language">
                        <p class="main-navbar__mobile-language-label">{{ navigation.language }}</p>
                        <div class="main-navbar__mobile-language-buttons">
                            <button
                                @click="switchLanguage('nl')"
                                class="main-navbar__mobile-lang-btn"
                                :class="{ 'main-navbar__mobile-lang-btn--active': currentLocale === 'nl' }"
                            >
                                {{ navigation.dutch }}
                            </button>
                            <button
                                @click="switchLanguage('en')"
                                class="main-navbar__mobile-lang-btn"
                                :class="{ 'main-navbar__mobile-lang-btn--active': currentLocale === 'en' }"
                            >
                                {{ navigation.english }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { useTranslations } from '@/composables/useTranslations.js'
import { useNavigation } from '@/composables/useNavigation.js'

// ============================================
// Composables
// ============================================

const page = usePage()
const { t, currentLocale, setLocale } = useTranslations()
const { getMainLinks } = useNavigation()

// ============================================
// Reactive State
// ============================================

const isMobileMenuOpen = ref(false)

// ============================================
// Computed Properties
// ============================================

// Gebruik centraal beheerde links (met vertaling via navigation.json)
const links = computed(() => getMainLinks(t))
const navigation = computed(() => t.value?.navigation ?? {})

// ============================================
// Methods
// ============================================

// Taal wisselen
const switchLanguage = (locale) => {
    setLocale(locale)
}

// Sluit het menu wanneer je een link klikt
const closeMenu = () => {
    isMobileMenuOpen.value = false
}
</script>

<style scoped>
/* ============================================
   MAIN NAVBAR CONTAINER
   ============================================ */

.main-navbar {
    background-color: var(--background-dark);
    position: sticky;
    top: 0;
    z-index: 50;
    border-bottom: 1px solid rgba(234, 183, 81, 0.3);
}

.main-navbar__container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* ============================================
   HEADER SECTION
   ============================================ */

.main-navbar__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 5rem;
}

/* ============================================
   LOGO SECTION
   ============================================ */

.main-navbar__logo {
    flex-shrink: 0;
}

.main-navbar__logo-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: opacity 0.2s ease;
}

.main-navbar__logo-link:hover {
    opacity: 0.8;
}

.main-navbar__logo-image {
    height: 3.5rem;
    width: 3.5rem;
    border-radius: 9999px;
    object-fit: cover;
}

.main-navbar__logo-text {
    color: var(--primary);
    font-weight: 700;
    font-size: 0.875rem;
}

/* ============================================
   DESKTOP NAVIGATION
   ============================================ */

.main-navbar__desktop-nav {
    display: none;
    align-items: center;
    gap: 2rem;
}

.main-navbar__desktop-links {
    display: flex;
    gap: 0.25rem;
}

.main-navbar__desktop-link {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    color: var(--text-light);
    text-decoration: none;
}

.main-navbar__desktop-link:hover {
    color: var(--primary);
    background-color: var(--background-light);
}

.main-navbar__desktop-link--active {
    background-color: var(--primary);
    color: var(--background);
}

/* ============================================
   LANGUAGE SWITCHER (DESKTOP)
   ============================================ */

.main-navbar__language-switcher {
    display: flex;
    gap: 0.5rem;
    margin-left: 1rem;
    padding-left: 1rem;
    border-left: 1px solid rgba(234, 183, 81, 0.3);
}

.main-navbar__lang-btn {
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--text-light);
}

.main-navbar__lang-btn:hover {
    color: var(--primary);
}

.main-navbar__lang-btn--active {
    background-color: var(--primary);
    color: var(--background);
}

/* ============================================
   MOBILE MENU BUTTON
   ============================================ */

.main-navbar__mobile-btn {
    display: block;
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--primary);
    transition: color 0.2s ease;
}

.main-navbar__mobile-btn:hover {
    color: var(--primary-hover);
}

.main-navbar__mobile-icon {
    width: 1.5rem;
    height: 1.5rem;
}

.main-navbar__mobile-icon--hidden {
    display: none;
}

.main-navbar__mobile-icon--close {
    display: none;
}

.main-navbar__mobile-icon--visible {
    display: block;
}

/* ============================================
   MOBILE MENU
   ============================================ */

.main-navbar__mobile-menu {
    display: block;
    background-color: var(--background-light);
    border-top: 1px solid rgba(234, 183, 81, 0.3);
}

.main-navbar__mobile-menu-inner {
    padding: 0.5rem 0.75rem 0.75rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.main-navbar__mobile-link {
    display: block;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    color: var(--text-light);
    text-decoration: none;
}

.main-navbar__mobile-link:hover {
    background-color: var(--background);
    color: var(--primary);
}

.main-navbar__mobile-link--active {
    background-color: var(--primary);
    color: var(--background);
}

/* ============================================
   MOBILE LANGUAGE SWITCHER
   ============================================ */

.main-navbar__mobile-language {
    padding: 1rem 1rem 0.5rem;
    margin-top: 1rem;
    border-top: 1px solid rgba(234, 183, 81, 0.3);
}

.main-navbar__mobile-language-label {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.main-navbar__mobile-language-buttons {
    display: flex;
    gap: 0.5rem;
}

.main-navbar__mobile-lang-btn {
    flex: 1;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: var(--background);
    border: none;
    cursor: pointer;
    color: var(--text-light);
}

.main-navbar__mobile-lang-btn:hover {
    color: var(--primary);
}

.main-navbar__mobile-lang-btn--active {
    background-color: var(--primary);
    color: var(--background);
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Tablet (640px - 1024px) */
@media (min-width: 640px) {
    .main-navbar__container {
        padding: 0 1.5rem;
    }
}

/* Desktop (min 1025px) */
@media (min-width: 1025px) {
    .main-navbar__container {
        padding: 0 2rem;
    }

    .main-navbar__desktop-nav {
        display: flex;
    }

    .main-navbar__mobile-btn {
        display: none;
    }

    .main-navbar__mobile-menu {
        display: none;
    }
}

/* Desktop groot (min 1200px) */
@media (min-width: 1200px) {
    .main-navbar__logo-text {
        font-size: 1rem;
    }
}

/* Desktop extra groot (min 1280px) */
@media (min-width: 1280px) {
    .main-navbar__logo-text {
        font-size: 1.125rem;
    }
}

/* Verberg title op medium/tablet schermen (1025px tot 1200px) */
@media (min-width: 1025px) and (max-width: 1200px) {
    .main-navbar__logo-text {
        display: none;
    }
}
</style>
