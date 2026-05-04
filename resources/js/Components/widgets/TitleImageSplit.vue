<template>
    <section class="title-image-split">
        <div class="content-grid" :class="gridClass">
            <div class="text-content">
                <BaseTitle
                    :title="title"
                    :info-text="infoText"
                    :enable-text="enableText"
                    :align="titleAlign"
                    :light="light"
                />
            </div>

            <div class="image-content">
                <BaseImage
                    :image-src="imageSrc"
                    :image-alt="imageAlt"
                    :ratio="ratio"
                    max-width="100%"
                />
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, defineProps } from 'vue'
import BaseTitle from '@/Components/BaseTitle.vue'
import BaseImage from '@/Components/BaseImage.vue'

const props = defineProps({
    imageSrc: {
        type: String,
        required: true
    },
    imageAlt: {
        type: String,
        default: 'Image'
    },
    ratio: {
        type: String,
        default: '16/9',
        validator: (value) => ['1/1', '4/3', '16/9', '9/16', '3/2'].includes(value)
    },
    title: {
        type: String,
        required: true
    },
    infoText: {
        type: String,
        default: ''
    },
    enableText: {
        type: Boolean,
        default: true
    },
    orientation: {
        type: String,
        default: 'left',
        validator: (value) => ['left', 'right'].includes(String(value).toLowerCase())
    },
    light: {
        type: Boolean,
        default: false
    }
})

const normalizedOrientation = computed(() => String(props.orientation).toLowerCase())
const titleAlign = computed(() => normalizedOrientation.value === 'right' ? 'right' : 'left')
const gridClass = computed(() => normalizedOrientation.value === 'right' ? 'orientation-right' : 'orientation-left')
</script>

<style scoped>
.title-image-split {
    @apply w-full;
}

.content-grid {
    @apply grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 items-center;
}

.text-content {
    @apply w-full;
}

.image-content {
    @apply w-full;
}

.orientation-left .text-content {
    @apply md:order-1;
}

.orientation-left .image-content {
    @apply md:order-2;
}

.orientation-right .image-content {
    @apply md:order-1;
}

.orientation-right .text-content {
    @apply md:order-2;
}
</style>
