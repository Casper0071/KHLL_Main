<script setup>
import { Link, usePage } from '@inertiajs/vue3'

// huidige url (voor active state)
const page = usePage()

// 🔥 Hier beheer je AL je navigatie op één plek
const links = [
    { name: 'Home', href: '/home' },
    { name: 'Dashboard', href: '/' },
    { name: 'Componenten', href: '/components' },
]
</script>

<template>
    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <div class="text-xl font-bold">
            KHLL
        </div>

        <!-- Links -->
        <div class="flex gap-4">
            <Link
                v-for="link in links"
                :key="link.href"
                :href="link.href"
                class="px-4 py-2 rounded transition"
                :class="{
                    'bg-primary text-white': page.url === link.href,
                    'text-gray-700 hover:bg-gray-100': page.url !== link.href
                }"
            >
                {{ link.name }}
            </Link>
        </div>
    </nav>
</template>
