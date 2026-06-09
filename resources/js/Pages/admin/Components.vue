<template>
    <div class="components-page">
        <div class="components-page__container">
            <!-- SEO: H1 titel -->
            <h1 class="components-page__title">Componenten Overzicht</h1>
            <p class="components-page__subtitle">Bekijk alle beschikbare componenten en hun varianten</p>

            <!-- Components Grid - Responsive grid -->
            <div class="components-grid">
                <div
                    v-for="component in components"
                    :key="component.name"
                    class="component-card"
                    :class="[
                        component.bg === 'dark' ? 'component-card--dark' : '',
                        component.colSpan === 3 ? 'component-card--full' : ''
                    ]"
                >
                    <div class="component-card__preview">
                        <component
                            :is="component.component"
                            v-bind="{
                                ...(component.props || {}),
                                lightBtn: component.bg === 'dark' ? true : false
                            }"
                        />
                    </div>
                    <div class="component-card__footer" :class="component.bg === 'dark' ? 'component-card__footer--dark' : ''">
                        <p class="component-card__name">{{ component.name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({
    layout: AdminLayout
})

// ============================================
// Imports
// ============================================

// Base Components
import BaseButton from '@/Components/Base/BaseButton.vue'
import BaseTitle from '@/Components/Base/BaseTitle.vue'
import BaseImage from '@/Components/Base/BaseImage.vue'
import BaseHeaderTitle from '@/Components/Base/BaseHeaderTitle.vue'

// Widget Components
import AgendaHome from '@/Components/widgets/AgendaHome.vue'
import TitleImageGallery from '@/Components/widgets/TitleImageGallery.vue'
import TitleImageSplit from '@/Components/widgets/TitleImageSplit.vue'
import Carousel from '@/Components/widgets/Carousel.vue'
import ContactForm from '@/Components/widgets/ContactForm.vue'
import HarmonyJourney from '@/Components/widgets/HarmonyJourney.vue'
import ThreeBlobsSection from '@/Components/widgets/ThreeBlobsSection.vue'

// Header Components
import HeaderHero from '@/Components/headers/HeaderHero.vue'
import HeaderHeroBgImage from '@/Components/headers/HeaderHero_bg_image.vue'

// ============================================
// Component Definitions
// ============================================

/**
 * Component configuratie voor het overzicht
 * Elk object bevat de component en zijn weergave-instellingen
 */
const components = computed(() => [
    // ==========================================
    // BaseButton Componenten
    // ==========================================
    {
        name: 'BaseButton primary',
        component: BaseButton,
        props: { variant: 'primary' }
    },
    {
        name: 'BaseButton secondary',
        component: BaseButton,
        props: { variant: 'secondary' },
        bg: 'dark'
    },
    {
        name: 'BaseButton outline',
        component: BaseButton,
        props: { variant: 'outline' }
    },

    // ==========================================
    // BaseTitle Componenten - Links
    // ==========================================
    {
        name: 'Title Left (title only)',
        component: BaseTitle,
        props: { title: 'Left Title', align: 'left' }
    },
    {
        name: 'Title Left (with text)',
        component: BaseTitle,
        props: { title: 'Left Title', enableText: true, align: 'left' }
    },
    {
        name: 'Title Left (light + text)',
        component: BaseTitle,
        props: { title: 'Light Title', enableText: true, light: true, align: 'left' },
        bg: 'dark'
    },

    // ==========================================
    // BaseTitle Componenten - Center
    // ==========================================
    {
        name: 'Title Center (title only)',
        component: BaseTitle,
        props: { title: 'Center Title', align: 'center' }
    },
    {
        name: 'Title Center (with text)',
        component: BaseTitle,
        props: { title: 'Center Title', enableText: true, align: 'center' }
    },
    {
        name: 'Title Center (light + text)',
        component: BaseTitle,
        props: { title: 'Center Light', enableText: true, light: true, align: 'center' },
        bg: 'dark'
    },

    // ==========================================
    // BaseTitle Componenten - Rechts
    // ==========================================
    {
        name: 'Title Right (title only)',
        component: BaseTitle,
        props: { title: 'Right Title', align: 'right' }
    },
    {
        name: 'Title Right (with text)',
        component: BaseTitle,
        props: { title: 'Right Title', enableText: true, align: 'right' }
    },
    {
        name: 'Title Right (light + text)',
        component: BaseTitle,
        props: { title: 'Right Light', enableText: true, light: true, align: 'right' },
        bg: 'dark'
    },

    // ==========================================
    // BaseHeaderTitle Componenten
    // ==========================================
    {
        name: 'Header Title Left',
        component: BaseHeaderTitle,
        props: { title: 'Header Left', align: 'left', buttonDisabled: false }
    },
    {
        name: 'Header Title Left (light)',
        component: BaseHeaderTitle,
        props: {
            title: 'Header Light',
            align: 'left',
            light: true,
            buttonDisabled: false,
            buttonVariant: 'secondary'
        },
        bg: 'dark'
    },
    {
        name: 'Header Title Center',
        component: BaseHeaderTitle,
        props: { title: 'Header Center', align: 'center', buttonDisabled: true, buttonVariant: 'outline' }
    },

    // ==========================================
    // BaseImage Componenten - Verschillende ratios
    // ==========================================
    {
        name: 'Image Landscape (16:9)',
        component: BaseImage,
        props: {
            imageSrc: 'https://placehold.co/800x400/e5e7eb/6b7280?text=16:9',
            ratio: '16/9'
        }
    },
    {
        name: 'Image Portrait (9:16)',
        component: BaseImage,
        props: {
            imageSrc: 'https://placehold.co/400x800/e5e7eb/6b7280?text=9:16',
            ratio: '9/16'
        }
    },
    {
        name: 'Image Square (1:1)',
        component: BaseImage,
        props: {
            imageSrc: 'https://placehold.co/500x500/e5e7eb/6b7280?text=1:1',
            ratio: '1/1'
        }
    },
    {
        name: 'Image 4:3',
        component: BaseImage,
        props: {
            imageSrc: 'https://placehold.co/800x600/e5e7eb/6b7280?text=4:3',
            ratio: '4/3'
        }
    },
    {
        name: 'Image 3:2',
        component: BaseImage,
        props: {
            imageSrc: 'https://placehold.co/800x533/e5e7eb/6b7280?text=3:2',
            ratio: '3/2'
        }
    },

    // ==========================================
    // AgendaHome Componenten
    // ==========================================
    {
        name: 'Agenda (default)',
        component: AgendaHome,
        props: {},
        colSpan: 3
    },
    {
        name: 'Agenda (light mode)',
        component: AgendaHome,
        props: { light: true },
        colSpan: 3,
        bg: 'dark'
    },

    // ==========================================
    // TitleImageGallery Componenten
    // ==========================================
    {
        name: 'Title Image Gallery',
        component: TitleImageGallery,
        props: {
            title: 'Showcase Section',
            description: 'Hier zie je hoe de component werkt met title, afbeelding en galerij.'
        },
        colSpan: 3
    },
    {
        name: 'Title Image Gallery (light mode)',
        component: TitleImageGallery,
        props: {
            title: 'Showcase Op Donker',
            description: 'Deze variant werkt perfect op donkere achtergronden met lichte tekst.',
            light: true
        },
        colSpan: 3,
        bg: 'dark'
    },

    // ==========================================
    // TitleImageSplit Componenten
    // ==========================================
    {
        name: 'Title Image Split (left)',
        component: TitleImageSplit,
        props: {
            title: 'Titel Links',
            infoText: 'Links staat de tekst met titel, rechts staat de afbeelding.',
            enableText: true,
            imageSrc: '/image/test.jpg',
            imageAlt: 'Voorbeeld afbeelding',
            ratio: '16/9',
            orientation: 'left'
        },
        colSpan: 3
    },
    {
        name: 'Title Image Split (right)',
        component: TitleImageSplit,
        props: {
            title: 'Titel Rechts',
            infoText: 'Links staat de afbeelding, rechts staat de tekst met titel.',
            enableText: true,
            imageSrc: 'https://placehold.co/800x450/e5e7eb/6b7280?text=Title+Image',
            imageAlt: 'Voorbeeld afbeelding',
            ratio: '16/9',
            orientation: 'right'
        },
        colSpan: 3
    },

    // ==========================================
    // Carousel Componenten
    // ==========================================
    {
        name: 'Carousel',
        component: Carousel,
        props: {
            title: 'Fotogalerij',
            images: [
                { src: 'https://placehold.co/800x500/e5e7eb/6b7280?text=Carousel+1', alt: 'Carousel 1', caption: 'Afbeelding 1' },
                { src: 'https://placehold.co/800x500/e5e7eb/6b7280?text=Carousel+2', alt: 'Carousel 2', caption: 'Afbeelding 2' },
                { src: 'https://placehold.co/800x500/e5e7eb/6b7280?text=Carousel+3', alt: 'Carousel 3', caption: 'Afbeelding 3' },
                { src: 'https://placehold.co/800x500/e5e7eb/6b7280?text=Carousel+4', alt: 'Carousel 4', caption: 'Afbeelding 4' }
            ]
        },
        colSpan: 3
    },
    {
        name: 'Carousel (light mode)',
        component: Carousel,
        props: {
            title: 'Fotogalerij Op Donker',
            light: true,
            images: [
                { src: 'https://placehold.co/800x500/f3f4f6/111827?text=Light+1', alt: 'Carousel Light 1', caption: 'Afbeelding 1' },
                { src: 'https://placehold.co/800x500/f3f4f6/111827?text=Light+2', alt: 'Carousel Light 2', caption: 'Afbeelding 2' },
                { src: 'https://placehold.co/800x500/f3f4f6/111827?text=Light+3', alt: 'Carousel Light 3', caption: 'Afbeelding 3' },
                { src: 'https://placehold.co/800x500/f3f4f6/111827?text=Light+4', alt: 'Carousel Light 4', caption: 'Afbeelding 4' }
            ]
        },
        colSpan: 3,
        bg: 'dark'
    },

    // ==========================================
    // ContactForm Componenten
    // ==========================================
    {
        name: 'Contact Form',
        component: ContactForm,
        props: {
            contactInfo: {
                email: 'info@khll.nl',
                phone: '06 12345678',
                address: 'Voorstraat 123, 1234 AB Amsterdam',
                hours: 'Maandag t/m Vrijdag: 09:00 - 17:00',
                socials: [
                    { name: 'Facebook', url: 'https://facebook.com' },
                    { name: 'Instagram', url: 'https://instagram.com' },
                    { name: 'LinkedIn', url: 'https://linkedin.com' }
                ]
            }
        },
        colSpan: 3
    },
    {
        name: 'Contact Form (light mode)',
        component: ContactForm,
        props: {
            light: true,
            contactInfo: {
                email: 'info@khll.nl',
                phone: '06 12345678',
                address: 'Voorstraat 123, 1234 AB Amsterdam',
                hours: 'Maandag t/m Vrijdag: 09:00 - 17:00',
                socials: [
                    { name: 'Facebook', url: 'https://facebook.com' },
                    { name: 'Instagram', url: 'https://instagram.com' },
                    { name: 'LinkedIn', url: 'https://linkedin.com' }
                ]
            }
        },
        colSpan: 3,
        bg: 'dark'
    },

    // ==========================================
    // HeaderHero Componenten
    // ==========================================
    {
        name: 'Hero Header',
        component: HeaderHero,
        props: {
            title: 'Koninklijke Harmonie Lentekrans Linne',
            buttonText: 'Bekijk meer',
            buttonVariant: 'primary',
            imageSrc: 'img/test.jpg',
            light: true,
            lightBtn: false
        },
        colSpan: 3,
        bg: 'dark'
    },

    // ==========================================
    // HeaderHeroBgImage Componenten
    // ==========================================
    {
        name: 'Hero Header BG Image (opacity 0.3)',
        component: HeaderHeroBgImage,
        props: {
            title: 'Lichte Overlay',
            buttonText: 'Bekijk meer',
            buttonVariant: 'primary',
            imageSrc: 'img/test.jpg',
            overlayOpacity: 0.3,
            lightBtn: false,
            minHeight: '500px'
        },
        colSpan: 3
    },
    {
        name: 'Hero Header BG Image (opacity 0.5)',
        component: HeaderHeroBgImage,
        props: {
            title: 'Gemiddelde Overlay',
            buttonText: 'Bekijk meer',
            buttonVariant: 'primary',
            imageSrc: 'img/test.jpg',
            overlayOpacity: 0.5,
            lightBtn: false,
            minHeight: '500px'
        },
        colSpan: 3
    },
    {
        name: 'Hero Header BG Image (opacity 0.7)',
        component: HeaderHeroBgImage,
        props: {
            title: 'Donkere Overlay',
            buttonText: 'Bekijk meer',
            buttonVariant: 'secondary',
            imageSrc: 'img/test.jpg',
            overlayOpacity: 0.7,
            lightBtn: false,
            minHeight: '500px'
        },
        colSpan: 3
    },

    // ==========================================
    // HarmonyJourney Componenten
    // ==========================================
    {
        name: 'Harmony Journey',
        component: HarmonyJourney,
        props: {
            title: 'Jouw Muzikale Reis',
            description: 'De harmonie biedt een unieke reis waar iedere muzikant op zijn of haar niveau deel kan nemen. Van eerste kennismaking tot lid van het grote orkest.',
            imageSrc: 'https://placehold.co/500x400/e5e7eb/6b7280?text=Journey',
            light: false
        },
        colSpan: 3
    },
    {
        name: 'Harmony Journey (light mode)',
        component: HarmonyJourney,
        props: {
            title: 'Jouw Muzikale Reis',
            description: 'De harmonie biedt een unieke reis waar iedere muzikant op zijn of haar niveau deel kan nemen. Van eerste kennismaking tot lid van het grote orkest.',
            imageSrc: 'https://via.placeholder.com/500x400',
            light: true
        },
        colSpan: 3,
        bg: 'dark'
    },

    // ==========================================
    // ThreeBlobsSection Component
    // ==========================================
    {
        name: 'Three Blobs Section',
        component: ThreeBlobsSection,
        props: {
            title: 'Onze Drie Kernwaarden',
            description: 'Ontdek de drie kernwaarden die onze harmonie kenmerken en ons verbinden als muzikanten en gemeenschap.',
            items: [
                { id: 1, title: 'Passie', text: 'Onze passie voor muziek drijft ons om elke dag beter te worden en samen prachtige muziek te maken.' },
                { id: 2, title: 'Samenwerking', text: 'Samenwerking staat centraal in onze harmonie. We werken als één team om onze doelen te bereiken.' },
                { id: 3, title: 'Gemeenschap', text: 'We zijn meer dan een harmonie; we zijn een gemeenschap van vrienden die samen genieten van muziek.' }
            ],
            light: true
        },
        colSpan: 3,
        bg: 'dark'
    }
])
</script>

<style scoped>
/* ============================================
   Components Page Container
   ============================================ */
.components-page {
    min-height: 100vh;
    background-color: var(--surface);
}

.components-page__container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1.5rem;
}

.components-page__title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.components-page__subtitle {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
}

/* ============================================
   Components Grid
   ============================================ */
.components-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

/* Tablet: 2 kolommen */
@media (min-width: 640px) {
    .components-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Desktop: 3 kolommen */
@media (min-width: 1024px) {
    .components-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* ============================================
   Component Card
   ============================================ */
.component-card {
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(234, 183, 81, 0.15);
    border-radius: 0.75rem;
    overflow: hidden;
    background-color: var(--surface);
    transition: all 0.3s ease;
}

.component-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    border-color: rgba(234, 183, 81, 0.3);
}

/* Dark variant */
.component-card--dark {
    background-color: var(--background-dark);
}

/* Full width variant (voor grote componenten) */
.component-card--full {
    grid-column: 1 / -1;
}

.component-card__preview {
    padding: 1.5rem;
    flex: 1;
}

.component-card__footer {
    padding: 0.75rem 1rem;
    background-color: rgba(0, 0, 0, 0.03);
    border-top: 1px solid rgba(234, 183, 81, 0.1);
}

.component-card__footer--dark {
    background-color: rgba(255, 255, 255, 0.05);
}

.component-card__name {
    font-size: 0.875rem;
    font-weight: 500;
    text-align: center;
    color: var(--text-dark);
}

.component-card--dark .component-card__name {
    color: var(--text-light);
}

/* ============================================
   Responsive Design
   ============================================ */

/* Tablet */
@media (max-width: 768px) {
    .components-page__container {
        padding: 1rem;
    }

    .components-page__title {
        font-size: 1.5rem;
    }

    .components-grid {
        gap: 1rem;
    }

    .component-card__preview {
        padding: 1rem;
    }
}

/* Mobile */
@media (max-width: 640px) {
    .components-page__title {
        font-size: 1.25rem;
    }

    .component-card__name {
        font-size: 0.75rem;
    }
}
</style>
