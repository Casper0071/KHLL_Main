<!-- layouts/AppLayout.vue -->
<script setup>
import { ref } from 'vue'
import VerticalNavbar from "@/Components/layouts/AdminSidebar.vue";

const isSidebarCollapsed = ref(false)

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value
}
</script>

<template>
    <div class="min-h-screen bg-background">
        <div class="flex">
            <!-- Verticale sidebar -->
            <VerticalNavbar
                :isCollapsed="isSidebarCollapsed"
                @toggle="toggleSidebar"
            />

            <!-- Main content -->
            <main
                class="flex-1  transition-all duration-300 "
                :class="isSidebarCollapsed ? 'ml-20' : 'ml-64'"
            >
                <slot />
            </main>
        </div>
    </div>
</template>
