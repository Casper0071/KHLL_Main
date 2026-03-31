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
import TitleLH1 from "@/Components/texten/TitleL_h1.vue";
import TitleRH1 from "@/Components/texten/TitleR_h1.vue";
import TitleCH1 from "@/Components/texten/TitleC_h1.vue";
import HeaderTitleL from "@/Components/texten/Header_TitleL.vue";
import HeaderTitleCenter from "@/Components/texten/Header_Title_center.vue";
import ImageLandscape from "@/Components/image/Image_Landscape.vue";
import ImagePortrait from "@/Components/image/Image_Portrait.vue";
import ImageSquare from "@/Components/image/Image_Square.vue";
import AgendaHome from "@/Components/widgets/agenda_home.vue";

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
    { name: 'Button primary', component: Button, props: { variant: 'primary' } },
    { name: 'Button secondary', component: Button, props: { variant: 'secondary' }, bg: 'dark' },
    { name: 'Button outline', component: Button, props: { variant: 'outline' } },

    { name: 'TitleL_h1 (title only)', component: TitleLH1 },
    { name: 'TitleL_h1 (show info)', component: TitleLH1, props: {enableText: true } },
    { name: 'TitleL_h1 (light + info)', component: TitleLH1, props: { title: 'Light Title', enableText: true, light: true },bg: 'dark' },

    { name: 'TitleR_h1 (title only)', component: TitleRH1 },
    { name: 'TitleR_h1 (show info)', component: TitleRH1, props: { title: 'Right Title', enableText: true } },
    { name: 'TitleR_h1 (light + info)', component: TitleRH1, props: { title: 'Right Light', enableText: true, light: true },bg: 'dark' },

    { name: 'TitleC_h1 (title only)', component: TitleCH1 },
    { name: 'TitleC_h1 (show info)', component: TitleCH1, props: { title: 'Center Title', enableText: true } },
    { name: 'TitleC_h1 (light + info)', component: TitleCH1, props: { title: 'Center Light', enableText: true, light: true },bg: 'dark' },

    { name: 'Header_TitleL (default)', component: HeaderTitleL, props: { buttonDisabled: false } },
    { name: 'Header_TitleL (light header)', component: HeaderTitleL, props: { title: 'Header Light', light: true, buttonDisabled: false, buttonVariant: 'secondary' }, bg: 'dark' },
    { name: 'Header_TitleL (light header + light button)', component: HeaderTitleL, props: { title: 'Header Light', light: true, buttonText: 'Click', buttonVariant: 'outline', buttonDisabled: false, lightBtn: true }, bg: 'dark' },

    { name: 'Header_Title_center (default)', component: HeaderTitleCenter, props: { buttonDisabled: false } },
    { name: 'Header_Title_center (light header)', component: HeaderTitleCenter, props: { title: 'Center Light', light: true, buttonDisabled: true, buttonVariant: 'secondary' }, bg: 'dark' },
    { name: 'Header_Title_center (light header + light button)', component: HeaderTitleCenter, props: { title: 'Center Light', light: true, buttonText: 'Click', buttonVariant: 'outline', buttonDisabled: true, lightBtn: true }, bg: 'dark' },

    { name: 'Image_Landscape', component: ImageLandscape, props: { imageSrc: 'https://via.placeholder.com/800x400' } },
    { name: 'Image_Portrait', component: ImagePortrait, props: { imageSrc: 'https://via.placeholder.com/400x800' } },
    { name: 'Image_Square', component: ImageSquare, props: { imageSrc: 'https://via.placeholder.com/500x500' } },

    { name: 'Agenda_Home (default)', component: AgendaHome, props: {}, colSpan: 3 },
    { name: 'Agenda_Home (light + dark bg)', component: AgendaHome, props: { light: true }, colSpan: 3, bg: 'dark' },
]
</script>
