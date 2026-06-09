<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { useTranslations } from '@/composables/useTranslations.js'
import { useNavigation } from '@/composables/useNavigation.js'

// ============================================
// Props (volledig intact gelaten)
// ============================================

const props = defineProps({
    isCollapsed: {
        type: Boolean,
        default: false
    }
})

// ============================================
// Emits
// ============================================

const emit = defineEmits(['toggle'])

// ============================================
// Composables
// ============================================

const page = usePage()
const { t } = useTranslations()
const { getSidebarLinks } = useNavigation()

// ============================================
// Reactive State
// ============================================

// Responsive state
const isMobile = ref(false)
const isTablet = ref(false)
const mobileMenuOpen = ref(false)

// ============================================
// Computed Properties
// ============================================

// Haal de huidige gebruiker op
const currentUser = computed(() => {
    if (page.props.auth?.user) {
        return page.props.auth.user
    }
    const storedUser = localStorage.getItem('user')
    if (storedUser) {
        return JSON.parse(storedUser)
    }
    return null
})

// Gebruik de sidebar links met role filtering
const links = computed(() => {
    const userRole = currentUser.value?.role || null
    return getSidebarLinks(t, userRole)
})

// ============================================
// Methods
// ============================================

// Check screen size
const checkScreenSize = () => {
    const width = window.innerWidth
    isMobile.value = width < 768
    isTablet.value = width >= 768 && width < 1024

    // Op mobiel altijd ingeklapt, op tablet optioneel
    if (isMobile.value && !props.isCollapsed) {
        emit('toggle')
    }
}

const toggleSidebar = () => {
    if (!isMobile.value) {
        emit('toggle')
    } else {
        mobileMenuOpen.value = !mobileMenuOpen.value
    }
}

const closeMobileMenu = () => {
    if (isMobile.value) {
        mobileMenuOpen.value = false
    }
}

// Helper functie voor iconen
const getIconPath = (icon) => {
    const icons = {
        dashboard: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        calendar: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        information: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        users: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'
    }
    return icons[icon] || icons.dashboard
}

// ============================================
// Lifecycle Hooks
// ============================================

onMounted(() => {
    checkScreenSize()
    window.addEventListener('resize', checkScreenSize)
})

onUnmounted(() => {
    window.removeEventListener('resize', checkScreenSize)
})
</script>

<template>
    <!-- Mobiele overlay -->
    <div
        v-if="isMobile && mobileMenuOpen"
        class="admin-sidebar__overlay"
        @click="closeMobileMenu"
    ></div>

    <!-- Sidebar -->
    <aside
        :class="[
            'admin-sidebar',
            isMobile ? (mobileMenuOpen ? 'admin-sidebar--mobile-open' : 'admin-sidebar--mobile-closed') : (isCollapsed ? 'admin-sidebar--collapsed' : 'admin-sidebar--expanded')
        ]"
    >
        <!-- Toggle Button - Alleen zichtbaar op desktop en tablet -->
        <button
            v-if="!isMobile"
            @click="toggleSidebar"
            class="admin-sidebar__toggle-btn"
            :class="{ 'admin-sidebar__toggle-btn--rotated': isCollapsed }"
        >
            <svg class="admin-sidebar__toggle-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Mobiele close button -->
        <button
            v-if="isMobile && mobileMenuOpen"
            @click="closeMobileMenu"
            class="admin-sidebar__close-btn"
        >
            <svg class="admin-sidebar__close-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Logo Section -->
        <div class="admin-sidebar__logo-section">
            <Link href="/" class="admin-sidebar__logo-link" @click="closeMobileMenu">
                <img
                    src="/img/logos/logoKroonWit.png"
                    alt="Koninklijke Harmonie Lentekrans Logo"
                    class="admin-sidebar__logo-image"
                />
                <span
                    v-show="!isCollapsed || isMobile"
                    class="admin-sidebar__logo-text"
                >
                    Admin Panel
                </span>
            </Link>
        </div>

        <!-- Navigation Links -->
        <nav class="admin-sidebar__nav">
            <div class="admin-sidebar__nav-inner">
                <Link
                    v-for="link in links"
                    :key="link.href"
                    :href="link.href"
                    @click="closeMobileMenu"
                    class="admin-sidebar__nav-link"
                    :class="[
                        page.url === link.href ? 'admin-sidebar__nav-link--active' : 'admin-sidebar__nav-link--inactive',
                        (isCollapsed && !isMobile) ? 'admin-sidebar__nav-link--centered' : ''
                    ]"
                >
                    <!-- Icon -->
                    <svg class="admin-sidebar__nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getIconPath(link.icon)"/>
                    </svg>

                    <span v-show="!isCollapsed || isMobile" class="admin-sidebar__nav-label">
                        {{ link.label }}
                    </span>

                    <!-- Tooltip voor collapsed mode (alleen desktop) -->
                    <div
                        v-if="!isMobile && isCollapsed"
                        class="admin-sidebar__tooltip"
                    >
                        {{ link.label }}
                    </div>
                </Link>
            </div>
        </nav>

        <!-- Footer met gebruiker info -->
        <div class="admin-sidebar__footer">
            <!-- Uitgebreide footer (normaal/mobiel) -->
            <div v-show="!isCollapsed || isMobile" class="admin-sidebar__footer-expanded">
                <!-- Gebruiker info -->
                <div class="admin-sidebar__user-info">
                    <div class="admin-sidebar__user-avatar">
                        <span class="admin-sidebar__user-initial">
                            {{ currentUser?.name?.charAt(0) || 'A' }}
                        </span>
                    </div>
                    <div class="admin-sidebar__user-details">
                        <p class="admin-sidebar__user-name">{{ currentUser?.name || 'Admin' }}</p>
                        <p class="admin-sidebar__user-role">{{ currentUser?.role === 'admin' ? 'Administrator' : 'Gebruiker' }}</p>
                    </div>
                </div>
            </div>

            <!-- Compacte footer voor collapsed mode (alleen desktop) -->
            <div v-show="!isMobile && isCollapsed" class="admin-sidebar__footer-collapsed">
                <div class="admin-sidebar__user-avatar--compact">
                    <span class="admin-sidebar__user-initial--compact">
                        {{ currentUser?.name?.charAt(0) || 'A' }}
                    </span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobiele hamburger button -->
    <button
        v-if="isMobile && !mobileMenuOpen"
        @click="toggleSidebar"
        class="admin-sidebar__hamburger"
    >
        <svg class="admin-sidebar__hamburger-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</template>

<style scoped>
/* ============================================
   OVERLAY
   ============================================ */

.admin-sidebar__overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 40;
    transition: opacity 0.3s ease;
}

/* ============================================
   SIDEBAR BASE
   ============================================ */

.admin-sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    background-color: var(--background-dark);
    border-right: 1px solid rgba(234, 183, 81, 0.3);
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    z-index: 50;
}

/* Sidebar widths */
.admin-sidebar--expanded {
    width: 16rem;
}

.admin-sidebar--collapsed {
    width: 5rem;
}

.admin-sidebar--mobile-open {
    width: 16rem;
    transform: translateX(0);
}

.admin-sidebar--mobile-closed {
    width: 16rem;
    transform: translateX(-100%);
}

/* ============================================
   TOGGLE BUTTON (Desktop/Tablet)
   ============================================ */

.admin-sidebar__toggle-btn {
    position: absolute;
    right: -0.75rem;
    top: 5rem;
    background-color: var(--primary);
    color: var(--background);
    border-radius: 9999px;
    padding: 0.375rem;
    transition: all 0.3s ease;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    z-index: 10;
    border: none;
    cursor: pointer;
}

.admin-sidebar__toggle-btn:hover {
    background-color: var(--primary-hover);
}

.admin-sidebar__toggle-btn--rotated {
    transform: rotate(180deg);
}

.admin-sidebar__toggle-icon {
    width: 1rem;
    height: 1rem;
}

/* ============================================
   CLOSE BUTTON (Mobile)
   ============================================ */

.admin-sidebar__close-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    color: var(--text-muted);
    transition: color 0.3s ease;
    background: transparent;
    border: none;
    cursor: pointer;
    z-index: 20;
}

.admin-sidebar__close-btn:hover {
    color: var(--primary);
}

.admin-sidebar__close-icon {
    width: 1.5rem;
    height: 1.5rem;
}

/* ============================================
   LOGO SECTION
   ============================================ */

.admin-sidebar__logo-section {
    flex-shrink: 0;
    padding: 1rem;
    border-bottom: 1px solid rgba(234, 183, 81, 0.3);
}

.admin-sidebar__logo-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    transition: opacity 0.2s ease;
    text-decoration: none;
}

.admin-sidebar__logo-link:hover {
    opacity: 0.8;
}

.admin-sidebar__logo-image {
    height: 2.5rem;
    width: 2.5rem;
    border-radius: 9999px;
    object-fit: cover;
    flex-shrink: 0;
}

.admin-sidebar__logo-text {
    color: var(--primary);
    font-weight: 700;
    font-size: 0.875rem;
    transition: opacity 0.3s ease;
}

/* ============================================
   NAVIGATION
   ============================================ */

.admin-sidebar__nav {
    flex: 1;
    padding: 1rem 0;
    overflow-y: auto;
}

.admin-sidebar__nav-inner {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    padding: 0 0.5rem;
}

.admin-sidebar__nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.625rem 0.75rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    text-decoration: none;
}

.admin-sidebar__nav-link--active {
    background-color: var(--primary);
    color: var(--background);
}

.admin-sidebar__nav-link--inactive {
    color: var(--text-light);
}

.admin-sidebar__nav-link--inactive:hover {
    color: var(--primary);
    background-color: var(--background-light);
}

.admin-sidebar__nav-link--centered {
    justify-content: center;
}

.admin-sidebar__nav-icon {
    width: 1.25rem;
    height: 1.25rem;
    flex-shrink: 0;
}

.admin-sidebar__nav-label {
    transition: opacity 0.3s ease;
}

/* ============================================
   TOOLTIP (Collapsed mode)
   ============================================ */

.admin-sidebar__tooltip {
    position: absolute;
    left: 100%;
    margin-left: 0.5rem;
    padding: 0.25rem 0.5rem;
    background-color: var(--background-light);
    color: var(--text-light);
    font-size: 0.875rem;
    border-radius: 0.25rem;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
    white-space: nowrap;
    z-index: 20;
}

.admin-sidebar__nav-link:hover .admin-sidebar__tooltip {
    opacity: 1;
}

/* ============================================
   FOOTER SECTION
   ============================================ */

.admin-sidebar__footer {
    flex-shrink: 0;
    border-top: 1px solid rgba(234, 183, 81, 0.3);
    padding: 0.75rem 1rem;
}

.admin-sidebar__footer-expanded {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.admin-sidebar__user-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem;
    border-radius: 0.5rem;
    background-color: rgba(0, 0, 0, 0.2);
}

.admin-sidebar__user-avatar {
    width: 2rem;
    height: 2rem;
    border-radius: 9999px;
    background-color: rgba(234, 183, 81, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.admin-sidebar__user-initial {
    color: var(--primary);
    font-size: 0.875rem;
    font-weight: 700;
}

.admin-sidebar__user-details {
    flex: 1;
    min-width: 0;
}

.admin-sidebar__user-name {
    color: var(--text-light);
    font-size: 0.875rem;
    font-weight: 500;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.admin-sidebar__user-role {
    color: var(--text-muted);
    font-size: 0.75rem;
}

/* Compact footer for collapsed mode */
.admin-sidebar__footer-collapsed {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.admin-sidebar__user-avatar--compact {
    width: 2rem;
    height: 2rem;
    border-radius: 9999px;
    background-color: rgba(234, 183, 81, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.admin-sidebar__user-initial--compact {
    color: var(--primary);
    font-size: 0.875rem;
    font-weight: 700;
}

/* ============================================
   HAMBURGER BUTTON (Mobile)
   ============================================ */

.admin-sidebar__hamburger {
    position: fixed;
    bottom: 1rem;
    right: 1rem;
    z-index: 50;
    background-color: var(--primary);
    color: var(--background);
    padding: 0.75rem;
    border-radius: 9999px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
    border: none;
    cursor: pointer;
}

.admin-sidebar__hamburger:hover {
    background-color: var(--primary-hover);
}

.admin-sidebar__hamburger-icon {
    width: 1.5rem;
    height: 1.5rem;
}

/* ============================================
   SCROLLBAR STYLING
   ============================================ */

.admin-sidebar__nav::-webkit-scrollbar {
    width: 4px;
}

.admin-sidebar__nav::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

.admin-sidebar__nav::-webkit-scrollbar-thumb {
    background: rgba(249, 115, 22, 0.5);
    border-radius: 4px;
}

.admin-sidebar__nav::-webkit-scrollbar-thumb:hover {
    background: rgba(249, 115, 22, 0.8);
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Tablet (768px - 1023px) */
@media (min-width: 768px) and (max-width: 1023px) {
    .admin-sidebar--expanded {
        width: 16rem;
    }

    .admin-sidebar--collapsed {
        width: 5rem;
    }
}

/* Mobile (max 767px) */
@media (max-width: 767px) {
    .admin-sidebar--mobile-open {
        transform: translateX(0);
    }

    .admin-sidebar--mobile-closed {
        transform: translateX(-100%);
    }
}

/* Responsive logo text */
@media (min-width: 640px) {
    .admin-sidebar__logo-image {
        height: 3rem;
        width: 3rem;
    }

    .admin-sidebar__logo-text {
        font-size: 1rem;
    }
}

@media (min-width: 1024px) {
    .admin-sidebar__logo-text {
        font-size: 1.125rem;
    }
}
</style>
