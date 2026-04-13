<template>
<div class="bg-background">
    <HeaderHero
        title="Koninklijke Harmonie Lentekranse Linne"
        :light="true"
        buttonText="Ontdek meer"
        buttonVariant="primary"
        :light-btn="true"
        imageSrc="/img/test.jpg"
    />
</div>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import HeaderHero from "@/Components/headers/HeaderHero.vue";

defineOptions({
    layout: MainLayout
})

</script>

<style>

</style>
