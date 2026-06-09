<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useTranslations } from '@/composables/useTranslations.js'
import { useNavigation } from '@/composables/useNavigation.js'

// ============================================
// Composables
// ============================================

const { t } = useTranslations()
const { getMainLinks, getLegalLinks } = useNavigation()

// ============================================
// Computed Properties
// ============================================

// Gebruik centraal beheerde links (met vertaling via navigation.json)
const navLinks = computed(() => getMainLinks(t))

// Legal links with fallback values
const legalLinks = computed(() => getLegalLinks(t))

// Footer copy with fallback
const footerCopy = computed(() => `© 2024 KHLL`)

// Contact info computed properties
const title = computed(() => t.value?.navigation?.title)
const contactAddress = computed(() => t.value?.footer?.address)
const contactEmail = computed(() => t.value?.footer?.email)
const contactLabel = computed(() => t.value?.footer?.contact)
const legalLabel = computed(() => t.value?.footer?.legal_section)
const pagesLabel = computed(() => t.value?.footer?.pages_section)
const makerLabel = computed(() => t.value?.footer?.made_by)
const versionLabel = computed(() => t.value?.footer?.version)
</script>

<template>
    <footer class="site-footer">
        <div class="site-footer__container">
            <!-- Main Footer Content -->
            <div class="site-footer__grid">
                <!-- Logo Section -->
                <div class="site-footer__logo-section">
                    <Link href="/public" class="site-footer__logo-link">
                        <img
                            src="/img/logos/logoKroonWit.png"
                            alt="KHLL Logo"
                            class="site-footer__logo"
                        />
                        <span class="site-footer__logo-text">{{ title }}</span>
                    </Link>
                    <p class="site-footer__maker-text">
                        {{ makerLabel }}: Casper Vocking
                    </p>
                </div>

                <!-- Pages Section -->
                <div class="site-footer__pages-section">
                    <h3 class="site-footer__section-title">{{ pagesLabel }}</h3>
                    <ul class="site-footer__links-list">
                        <li v-for="link in navLinks" :key="link.href">
                            <Link
                                :href="link.href"
                                class="site-footer__link"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Legal Section -->
                <div class="site-footer__legal-section">
                    <h3 class="site-footer__section-title">{{ legalLabel }}</h3>
                    <ul class="site-footer__links-list">
                        <li v-for="link in legalLinks" :key="link.href">
                            <Link
                                :href="link.href"
                                class="site-footer__link"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="site-footer__contact-section">
                    <h3 class="site-footer__section-title">{{ contactLabel }}</h3>
                    <div class="site-footer__contact-content">
                        <div>
                            <p class="site-footer__contact-text">
                                {{ contactAddress }}
                            </p>
                        </div>
                        <div>
                            <a
                                :href="`mailto:${contactEmail}`"
                                class="site-footer__contact-link"
                            >
                                {{ contactEmail }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="site-footer__divider"></div>

            <!-- Bottom Footer -->
            <div class="site-footer__bottom">
                <div class="site-footer__copyright">
                    {{ footerCopy }}
                </div>
                <div class="site-footer__version">
                    {{ versionLabel }}: 1.0.0
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
/* ============================================
   FOOTER CONTAINER
   ============================================ */

.site-footer {
    background-color: var(--background-dark);
    border-top: 1px solid rgba(234, 183, 81, 0.3);
    z-index: 10;
}

.site-footer__container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 3rem 1rem;
}

/* ============================================
   MAIN GRID
   ============================================ */

.site-footer__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

/* ============================================
   LOGO SECTION
   ============================================ */

.site-footer__logo-section {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.site-footer__logo-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    transition: opacity 0.2s ease;
}

.site-footer__logo-link:hover {
    opacity: 0.8;
}

.site-footer__logo {
    height: 3rem;
    width: 3rem;
    border-radius: 9999px;
    object-fit: cover;
}

.site-footer__logo-text {
    color: var(--primary);
    font-weight: 700;
    font-size: 1.125rem;
}

.site-footer__maker-text {
    color: var(--text-muted);
    font-size: 0.875rem;
}

/* ============================================
   SECTION TITLES
   ============================================ */

.site-footer__section-title {
    color: var(--primary);
    font-weight: 700;
    margin-bottom: 1rem;
}

/* ============================================
   LINKS LISTS
   ============================================ */

.site-footer__links-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.site-footer__link {
    color: var(--text-light);
    text-decoration: none;
    transition: color 0.2s ease;
}

.site-footer__link:hover {
    color: var(--primary);
}

/* ============================================
   CONTACT SECTION
   ============================================ */

.site-footer__contact-content {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.site-footer__contact-text {
    color: var(--text-light);
    font-size: 0.875rem;
    line-height: 1.5;
}

.site-footer__contact-link {
    color: var(--text-light);
    text-decoration: none;
    transition: color 0.2s ease;
}

.site-footer__contact-link:hover {
    color: var(--primary);
}

/* ============================================
   DIVIDER
   ============================================ */

.site-footer__divider {
    height: 1px;
    background-color: rgba(234, 183, 81, 0.3);
    margin: 2rem 0;
}

/* ============================================
   BOTTOM FOOTER
   ============================================ */

.site-footer__bottom {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.site-footer__copyright {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.site-footer__version {
    color: var(--text-muted);
    font-size: 0.875rem;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Tablet (640px - 768px) */
@media (min-width: 640px) {
    .site-footer__container {
        padding: 3rem 1.5rem;
    }

    .site-footer__bottom {
        flex-direction: row;
    }
}

/* Tablet groot (768px - 1024px) - 2 kolommen */
@media (min-width: 768px) {
    .site-footer__grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
}

/* Desktop (1024px+) - 4 kolommen */
@media (min-width: 1024px) {
    .site-footer__container {
        padding: 3rem 2rem;
    }

    .site-footer__grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .site-footer__divider {
        margin: 2rem 0;
    }
}

/* Desktop groot (1280px+) */
@media (min-width: 1280px) {
    .site-footer__container {
        padding: 3rem 2rem;
    }

    .site-footer__grid {
        gap: 2.5rem;
    }
}

/* Mobile (max 640px) */
@media (max-width: 640px) {
    .site-footer__container {
        padding: 2rem 1rem;
    }

    .site-footer__grid {
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .site-footer__logo-section {
        align-items: center;
        text-align: center;
    }

    .site-footer__logo-link {
        flex-direction: column;
        text-align: center;
    }

    .site-footer__pages-section,
    .site-footer__legal-section,
    .site-footer__contact-section {
        text-align: center;
    }

    .site-footer__links-list {
        align-items: center;
    }

    .site-footer__section-title {
        text-align: center;
    }
}
</style>
