<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Componenten Overzicht</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
            <div
                class="border p-4 rounded-lg flex flex-col items-center justify-center"
                v-for="component in components"
                :key="component.name"
                :class="[getItemBg(component), getColSpan(component)]"
            >
                <component :is="component.component" v-bind="{ ...(component.props || {}), lightbt: component.bg === 'dark' }" />
                <p :class="['mt-2 text-center font-medium', component.bg === 'dark' ? 'text-white' : '']">{{ component.name }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import Button from '@/Components/Button.vue'
import BaseTitle from "@/Components/BaseTitle.vue";
import BaseImage from "@/Components/BaseImage.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import AgendaHome from "@/Components/widgets/AgendaHome.vue";
import TitleImageGallery from "@/Components/widgets/TitleImageGallery.vue";
import Carousel from "@/Components/widgets/Carousel.vue";

// map friendly bg keys to actual utility classes
const bgMap = {
    // per request: when bg: 'dark' -> use bg-background for the card and make text light
    dark: 'bg-background text-white',
}

function getItemBg(component) {
    // 1) explicit component.bg (friendly key or raw class)
    if (component.bg) return bgMap[component.bg] || component.bg
    // 2) per-component props.bgClass (legacy support)
    if (component.props && component.props.bgClass) return component.props.bgClass
    // 3) no global selection: return empty string
    return ''
}

function getColSpan(component) {
    if (component.colSpan === 3) return 'lg:col-span-3'
    return ''
}

const components = [
    { name: 'Button primary', component: Button, props: { variant: 'primary' }},
    { name: 'Button secondary', component: Button, props: { variant: 'secondary' }, bg: 'dark' },
    { name: 'Button outline', component: Button, props: { variant: 'outline' } },

    { name: 'Title Left (title only)', component: BaseTitle, props: { title: 'Left Title', align: 'left' } },
    { name: 'Title Left (with text)', component: BaseTitle, props: { title: 'Left Title', enableText: true, align: 'left' } },
    { name: 'Title Left (light + text)', component: BaseTitle, props: { title: 'Light Title', enableText: true, light: true, align: 'left' }, bg: 'dark' },

    { name: 'Title Center (title only)', component: BaseTitle, props: { title: 'Center Title', align: 'center' } },
    { name: 'Title Center (with text)', component: BaseTitle, props: { title: 'Center Title', enableText: true, align: 'center' } },
    { name: 'Title Center (light + text)', component: BaseTitle, props: { title: 'Center Light', enableText: true, light: true, align: 'center' }, bg: 'dark' },

    { name: 'Title Right (title only)', component: BaseTitle, props: { title: 'Right Title', align: 'right' } },
    { name: 'Title Right (with text)', component: BaseTitle, props: { title: 'Right Title', enableText: true, align: 'right' } },
    { name: 'Title Right (light + text)', component: BaseTitle, props: { title: 'Right Light', enableText: true, light: true, align: 'right' }, bg: 'dark' },

    { name: 'Header Title Left', component: HeaderTitle, props: { title: 'Header Left', align: 'left', buttonDisabled: false } },
    { name: 'Header Title Left (light)', component: HeaderTitle, props: { title: 'Header Light', align: 'left', light: true, buttonDisabled: false, buttonVariant: 'secondary' }, bg: 'dark' },
    { name: 'Header Title Center', component: HeaderTitle, props: { title: 'Header Center', align: 'center', buttonDisabled: true, buttonVariant: 'outline' } },

    { name: 'Image Landscape (16:9)', component: BaseImage, props: { imageSrc: 'https://via.placeholder.com/800x400', ratio: '16/9' } },
    { name: 'Image Portrait (9:16)', component: BaseImage, props: { imageSrc: 'https://via.placeholder.com/400x800', ratio: '9/16' } },
    { name: 'Image Square (1:1)', component: BaseImage, props: { imageSrc: 'https://via.placeholder.com/500x500', ratio: '1/1' } },

    { name: 'Image 4:3', component: BaseImage, props: { imageSrc: 'https://via.placeholder.com/800x600', ratio: '4/3' } },
    { name: 'Image 3:2', component: BaseImage, props: { imageSrc: 'https://via.placeholder.com/800x533', ratio: '3/2' } },

    { name: 'Agenda (default)', component: AgendaHome, props: {}, colSpan: 3 },
    { name: 'Agenda (light mode)', component: AgendaHome, props: { light: true }, colSpan: 3, bg: 'dark' },

    { name: 'Title Image Gallery', component: TitleImageGallery, props: {
        title: 'Showcase Section',
        description: 'Hier zie je hoe de component werkt met title, afbeelding en galerij.'
    }, colSpan: 3 },

    { name: 'Title Image Gallery (light mode)', component: TitleImageGallery, props: {
        title: 'Showcase Op Donker',
        description: 'Deze variant werkt perfect op donkere achtergronden met lichte tekst.',
        light: true
    }, colSpan: 3, bg: 'dark' },

    { name: 'Carousel', component: Carousel, props: {
        title: 'Fotogalerij',
        images: [
            { src: 'https://via.placeholder.com/800x500', alt: 'Carousel 1', caption: 'Afbeelding 1' },
            { src: 'https://via.placeholder.com/800x500', alt: 'Carousel 2', caption: 'Afbeelding 2' },
            { src: 'https://via.placeholder.com/800x500', alt: 'Carousel 3', caption: 'Afbeelding 3' },
            { src: 'https://via.placeholder.com/800x500', alt: 'Carousel 4', caption: 'Afbeelding 4' }
        ]
    }, colSpan: 3 },

    { name: 'Carousel (light mode)', component: Carousel, props: {
        title: 'Fotogalerij Op Donker',
        light: true,
        images: [
            { src: 'https://via.placeholder.com/800x500', alt: 'Carousel Light 1', caption: 'Afbeelding 1' },
            { src: 'https://via.placeholder.com/800x500', alt: 'Carousel Light 2', caption: 'Afbeelding 2' },
            { src: 'https://via.placeholder.com/800x500', alt: 'Carousel Light 3', caption: 'Afbeelding 3' },
            { src: 'https://via.placeholder.com/800x500', alt: 'Carousel Light 4', caption: 'Afbeelding 4' }
        ]
    }, colSpan: 3, bg: 'dark' },
]
</script>
