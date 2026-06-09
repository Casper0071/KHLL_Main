<template>
    <div v-intersect="'animate'" class="three-blobs">
        <div class="three-blobs__container">
            <div
                v-for="(item, index) in items"
                :key="index"
                class="three-blobs__item"
            >
                <!-- SVG Blob Container -->
                <div class="three-blobs__blob-wrapper">
                    <svg
                        v-if="index === 0"
                        width="332"
                        height="414"
                        viewBox="0 0 332 414"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="three-blobs__svg"
                    >
                        <path d="M245.456 26.6412C210.21 -0.313287 112.28 -10.3795 29.1695 13.3306C-29.4082 44.5277 20.1576 146.439 9.64362 190.531C-0.870319 234.623 -7.93206 269.055 20.5271 296.998C48.0636 324.036 119.158 354.817 184.244 340.258C258.427 323.665 295.488 283.45 323.93 217.133C354.971 144.755 289.515 60.3342 245.456 26.6412Z" fill="var(--surface)"/>
                    </svg>

                    <svg
                        v-else-if="index === 1"
                        width="323"
                        height="444"
                        viewBox="0 0 323 444"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="three-blobs__svg"
                    >
                        <path d="M146.309 327.8C30.7302 339.504 25.3817 265.827 8.3919 228.344C-18.3463 169.356 23.8826 30.9185 63.8586 6.05426C103.835 -18.8099 183.287 41.3092 263.738 35.7421C344.227 30.1724 328.002 133.376 294.22 189.379C266.237 235.767 316.207 272.877 285.226 298.854C254.244 324.831 201.276 322.234 146.309 327.8Z" fill="var(--surface)"/>
                    </svg>

                    <svg
                        v-else
                        width="351"
                        height="406"
                        viewBox="0 0 351 406"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="three-blobs__svg"
                    >
                        <path d="M108.226 0.508845C43.3859 -5.0817 29.2799 36.497 26.278 71.0501C23.2762 105.603 46.6882 104.167 4.1619 234.613C-39.5885 368.814 274.681 304.294 333.868 259.848C380.397 224.907 315.356 178.708 333.868 132.896C367.834 48.8378 322.861 27.2968 251.816 28.8498C171.766 30.5996 189.277 7.49703 108.226 0.508845Z" fill="var(--surface)"/>
                    </svg>

                    <!-- Content Overlay -->
                    <div class="three-blobs__overlay">
                        <div class="three-blobs__content">
                            <!-- Title -->
                            <h3 class="three-blobs__title">
                                {{ item.title }}
                            </h3>

                            <!-- Yellow Divider Line -->
                            <div class="three-blobs__divider" />

                            <!-- Description Text -->
                            <p class="three-blobs__text">
                                {{ item.text }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// ============================================
// Props (volledig intact gelaten)
// ============================================

defineProps({
    items: {
        type: Array,
        required: true,
        validator(value) {
            return (
                Array.isArray(value) &&
                value.length === 3 &&
                value.every((item) => item.title && item.text)
            )
        },
    },
})
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.three-blobs {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.three-blobs.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* Staggered animation for blob items */
.is-visible .three-blobs__item {
    animation: three-blobs-item-fade-in 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    opacity: 0;
}

.is-visible .three-blobs__item:nth-child(1) {
    animation-delay: 0s;
}

.is-visible .three-blobs__item:nth-child(2) {
    animation-delay: 0.1s;
}

.is-visible .three-blobs__item:nth-child(3) {
    animation-delay: 0.2s;
}

@keyframes three-blobs-item-fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ============================================
   THREE BLOBS CONTAINER
   ============================================ */

.three-blobs {
    width: 100%;
    padding: 3rem 1rem;
}

.three-blobs__container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

/* ============================================
   BLOB ITEM
   ============================================ */

.three-blobs__item {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    opacity: 0;
}

/* ============================================
   BLOB WRAPPER & SVG
   ============================================ */

.three-blobs__blob-wrapper {
    position: relative;
    width: 100%;
    height: auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

.three-blobs__svg {
    width: 150%;
    height: auto;
    max-width: 300px;
    transition: transform 0.3s ease;
}

.three-blobs__item:hover .three-blobs__svg {
    transform: scale(1.02);
}

/* ============================================
   CONTENT OVERLAY
   ============================================ */

.three-blobs__overlay {
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 0 1.5rem;
}

.three-blobs__content {
    text-align: center;
    max-width: 240px;
}

/* ============================================
   TITLE STYLES
   ============================================ */

.three-blobs__title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

/* ============================================
   DIVIDER LINE
   ============================================ */

.three-blobs__divider {
    width: 3rem;
    height: 0.25rem;
    background-color: var(--primary-light);
    margin: 0 auto 0.75rem;
    transition: width 0.3s ease;
}

.three-blobs__item:hover .three-blobs__divider {
    width: 4rem;
}

/* ============================================
   TEXT STYLES
   ============================================ */

.three-blobs__text {
    font-size: 0.875rem;
    color: var(--text-dark);
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

/* Tablet (640px - 768px) */
@media (min-width: 640px) {
    .three-blobs {
        padding: 3rem 1.5rem;
    }

    .three-blobs__overlay {
        padding: 1.5rem 0.5rem;
    }

    .three-blobs__text {
        font-size: 1rem;
    }
}

/* Tablet groot (768px - 1024px) - 2 kolommen */
@media (min-width: 768px) {
    .three-blobs__container {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Desktop (1024px+) - 3 kolommen */
@media (min-width: 1024px) {
    .three-blobs {
        padding: 3rem 2rem;
    }

    .three-blobs__container {
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
}

/* Desktop groot (1280px+) */
@media (min-width: 1280px) {
    .three-blobs__container {
        gap: 2.5rem;
    }
}

/* Hover effect alleen op desktop voor betere mobile UX */
@media (hover: hover) {
    .three-blobs__item:hover .three-blobs__svg {
        transform: scale(1.02);
    }
}
</style>
