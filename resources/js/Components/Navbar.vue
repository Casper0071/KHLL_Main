<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import { useTranslations } from '@/composables/useTranslations'

const page = usePage()
const isMobileMenuOpen = ref(false)
const { t, currentLocale, setLocale } = useTranslations()

// Navigatie links
const links = [
    { href: '/home', key: 'home' },
    { href: '/', key: 'dashboard' },
    { href: '/components', key: 'components' },
]

// Taal wisselen
const switchLanguage = (locale) => {
    setLocale(locale)
}

// Sluit het menu wanneer je een link klikt
const closeMenu = () => {
    isMobileMenuOpen.value = false
}
</script>

<template>
    <nav class="bg-background sticky top-0 z-50 border-b border-primary border-opacity-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo Links -->
                <div class="flex-shrink-0">
                    <Link href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                        <img 
                            src="/img/test.jpg" 
                            alt="KHLL Logo" 
                            class="h-14 w-14 rounded-full object-cover"
                        />
                        <span class="text-primary font-bold text-xl hidden sm:block">KHLL</span>
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-8">
                    <!-- Links -->
                    <div class="flex gap-1">
                        <Link
                            v-for="link in links"
                            :key="link.href"
                            :href="link.href"
                            class="px-4 py-2 rounded-lg font-medium transition-all duration-300"
                            :class="{
                                'bg-primary text-background': page.url === link.href,
                                'text-text-light hover:text-primary hover:bg-background-light': page.url !== link.href
                            }"
                        >
                            {{ t[link.key] }}
                        </Link>
                    </div>

                    <!-- Language Switcher -->
                    <div class="flex gap-2 ml-4 pl-4 border-l border-primary border-opacity-30">
                        <button
                            @click="switchLanguage('nl')"
                            class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300"
                            :class="{
                                'bg-primary text-background': currentLocale === 'nl',
                                'text-text-light hover:text-primary': currentLocale !== 'nl'
                            }"
                        >
                            NL
                        </button>
                        <button
                            @click="switchLanguage('en')"
                            class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300"
                            :class="{
                                'bg-primary text-background': currentLocale === 'en',
                                'text-text-light hover:text-primary': currentLocale !== 'en'
                            }"
                        >
                            EN
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="md:hidden text-primary hover:text-primary-hover transition"
                >
                    <svg
                        class="w-6 h-6"
                        :class="{ 'hidden': isMobileMenuOpen }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg
                        class="w-6 h-6"
                        :class="{ 'hidden': !isMobileMenuOpen }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div
                v-show="isMobileMenuOpen"
                class="md:hidden bg-background-light border-t border-primary border-opacity-30"
            >
                <div class="px-2 pt-2 pb-3 space-y-2">
                    <!-- Mobile Links -->
                    <Link
                        v-for="link in links"
                        :key="link.href"
                        :href="link.href"
                        @click="closeMenu"
                        class="block px-4 py-2 rounded-lg text-text-light font-medium transition-all duration-300"
                        :class="{
                            'bg-primary text-background': page.url === link.href,
                            'hover:bg-background hover:text-primary': page.url !== link.href
                        }"
                    >
                        {{ t[link.key] }}
                    </Link>

                    <!-- Mobile Language Switcher -->
                    <div class="px-4 py-2 border-t border-primary border-opacity-30 mt-4 pt-4">
                        <p class="text-text-muted text-sm mb-2">{{ t.language }}</p>
                        <div class="flex gap-2">
                            <button
                                @click="switchLanguage('nl')"
                                class="flex-1 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300"
                                :class="{
                                    'bg-primary text-background': currentLocale === 'nl',
                                    'bg-background text-text-light hover:text-primary': currentLocale !== 'nl'
                                }"
                            >
                                {{ t.dutch }}
                            </button>
                            <button
                                @click="switchLanguage('en')"
                                class="flex-1 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300"
                                :class="{
                                    'bg-primary text-background': currentLocale === 'en',
                                    'bg-background text-text-light hover:text-primary': currentLocale !== 'en'
                                }"
                            >
                                {{ t.english }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
