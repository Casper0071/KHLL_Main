<!-- Components/layouts/AdminSidebar.vue -->
<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useTranslations } from '@/composables/useTranslations.js'
import { useNavigation } from '@/composables/useNavigation.js'

const props = defineProps({
    isCollapsed: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['toggle'])

const page = usePage()
const { t, currentLocale, setLocale } = useTranslations()
const { getSidebarLinks } = useNavigation()

// Gebruik de sidebar links voor de verticale navbar
const links = computed(() => getSidebarLinks(t))
const navigation = computed(() => t.value?.navigation ?? {})

// Taal wisselen
const switchLanguage = (locale) => {
    setLocale(locale)
}

const toggleSidebar = () => {
    emit('toggle')
}

// Helper functie voor iconen op basis van het icon type
const getIconPath = (icon) => {
    const icons = {
        dashboard: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        calendar: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        information: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    }
    return icons[icon] || icons.dashboard
}
</script>

<template>
    <aside
        class="fixed left-0 top-0 h-screen bg-background-dark border-r border-primary border-opacity-30 flex flex-col transition-all duration-300 z-40"
        :class="isCollapsed ? 'w-20' : 'w-64'"
    >
        <!-- Toggle Button -->
        <button
            @click="toggleSidebar"
            class="absolute -right-3 top-20 bg-primary text-background rounded-full p-1.5 hover:bg-primary-hover transition-all duration-300 shadow-lg z-10"
            :class="{ 'rotate-180': isCollapsed }"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Logo Section -->
        <div class="flex-shrink-0 p-4 border-b border-primary border-opacity-30">
            <Link href="/" class="flex items-center justify-center gap-3 hover:opacity-80 transition">
                <img
                    src="/img/test.jpg"
                    alt="Koninklijke Harmonie Lentekrans Logo"
                    class="h-12 w-12 rounded-full object-cover flex-shrink-0"
                />
                <span
                    v-show="!isCollapsed"
                    class="text-primary font-bold text-sm sm:text-base md:text-lg transition-opacity duration-300"
                >
                    Admin Panel
                </span>
            </Link>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 py-6 overflow-y-auto">
            <div class="space-y-1 px-3">
                <Link
                    v-for="link in links"
                    :key="link.href"
                    :href="link.href"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-300 group relative"
                    :class="{
                        'bg-primary text-background': page.url === link.href,
                        'text-text-light hover:text-primary hover:bg-background-light': page.url !== link.href
                    }"
                >
                    <!-- Icon -->
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getIconPath(link.icon)"/>
                    </svg>

                    <span v-show="!isCollapsed" class="transition-opacity duration-300">
                        {{ link.label }}
                    </span>

                    <!-- Tooltip voor collapsed mode -->
                    <div
                        v-if="isCollapsed"
                        class="absolute left-full ml-2 px-2 py-1 bg-background-light text-text-light text-sm rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 whitespace-nowrap z-20"
                    >
                        {{ link.label }}
                    </div>
                </Link>
            </div>
        </nav>
    </aside>
</template>

<style scoped>
/* Scrollbar styling */
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(249, 115, 22, 0.5);
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(249, 115, 22, 0.8);
}
</style>
