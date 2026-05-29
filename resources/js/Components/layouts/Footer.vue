<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useTranslations } from '@/composables/useTranslations.js'
import { useNavigation } from '@/composables/useNavigation.js'

const { t } = useTranslations()
const { getMainLinks, getLegalLinks } = useNavigation()

// Gebruik centraal beheerde links (met vertaling via navigation.json)
const navLinks = computed(() => getMainLinks(t))

// Legal links with fallback values
const legalLinks = computed(() => getLegalLinks(t))

// Footer copy with fallback
const footerCopy = computed(() => {
    return `© 2024 KHLL`
})

// Contact info computed properties
const title = computed(() => t.value?.navigation?.title)
const contactAddress = computed(() => t.value?.footer?.address)
const contactEmail = computed(() => t.value?.footer?.email)
const contactLabel = computed(() => t.value?.footer?.contact)
const legalLabel = computed(() => t.value?.footer?.legal_section )
const pagesLabel = computed(() => t.value?.footer?.pages_section)
const makerLabel = computed(() => t.value?.footer?.made_by)
const versionLabel = computed(() => t.value?.footer?.version)
</script>

<template>
    <footer class="bg-background-dark border-t border-primary border-opacity-30 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Logo Section -->
                <div class="flex flex-col items-start">
                    <Link href="/public" class="flex items-center gap-3 mb-4 hover:opacity-80 transition">
                        <img
                            src="/img/logos/logoKroonWit.png"
                            alt="KHLL Logo"
                            class="h-12 w-12 rounded-full object-cover"
                        />
                        <span class="text-primary font-bold text-lg">{{title}}</span>
                    </Link>
                    <p class="text-text-muted text-sm">
                        {{ makerLabel }}: Casper Vocking
                    </p>
                </div>

                <!-- Pages Section -->
                <div>
                    <h3 class="text-primary font-bold mb-4">{{ pagesLabel }}</h3>
                    <ul class="space-y-2">
                        <li v-for="link in navLinks" :key="link.href">
                            <Link
                                :href="link.href"
                                class="text-text-light hover:text-primary transition"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Legal Section -->
                <div>
                    <h3 class="text-primary font-bold mb-4">{{ legalLabel }}</h3>
                    <ul class="space-y-2">
                        <li v-for="link in legalLinks" :key="link.href">
                            <Link
                                :href="link.href"
                                class="text-text-light hover:text-primary transition"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div>
                    <h3 class="text-primary font-bold mb-4">{{ contactLabel }}</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-text-light text-sm leading-relaxed">
                                {{ contactAddress }}
                            </p>
                        </div>
                        <div>
                            <a
                                :href="`mailto:${contactEmail}`"
                                class="text-text-light hover:text-primary transition"
                            >
                                {{ contactEmail }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="h-px bg-primary bg-opacity-30 my-8"></div>

            <!-- Bottom Footer -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-text-muted text-sm">
                    {{ footerCopy }}
                </div>
                <div class="text-text-muted text-sm">
                    {{ versionLabel }}: 1.0.0
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
/* Footer styling already uses Tailwind classes */
</style>
