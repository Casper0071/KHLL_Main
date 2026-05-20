<template>
    <div class="contact-section" :class="{ 'light-mode': light }">
        <div class="contact-container">
            <!-- Left: Contact Form -->
            <div class="form-section">
                <h2 class="section-title" :class="{ 'light-text': light }">{{title1}}</h2>

                <form @submit.prevent="handleSubmit" class="contact-form">
                    <div class="form-group">
                        <label for="name" class="form-label" :class="{ 'light-text': light }">{{name}}</label>
                        <input
                            id="name"
                            v-model="formData.name"
                            type="text"
                            required
                            :placeholder="namePlaceholder"
                            class="form-input"
                            :class="{ 'light-mode': light }"
                        />
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label" :class="{ 'light-text': light }">{{email}}</label>
                        <input
                            id="email"
                            v-model="formData.email"
                            type="email"
                            required
                            :placeholder="emailPlaceholder"
                            class="form-input"
                            :class="{ 'light-mode': light }"
                        />
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label" :class="{ 'light-text': light }">{{phone}}</label>
                        <input
                            id="phone"
                            v-model="formData.phone"
                            type="tel"
                            :placeholder="phonePlaceholder"
                            class="form-input"
                            :class="{ 'light-mode': light }"
                        />
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label" :class="{ 'light-text': light }">{{subject}}</label>
                        <input
                            id="subject"
                            v-model="formData.subject"
                            type="text"
                            required
                            :placeholder="subjectPlaceholder"
                            class="form-input"
                            :class="{ 'light-mode': light }"
                        />
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label" :class="{ 'light-text': light }">{{message}}</label>
                        <textarea
                            id="message"
                            v-model="formData.message"
                            required
                            :placeholder="messagePlaceholder"
                            class="form-textarea"
                            :class="{ 'light-mode': light }"
                            rows="5"
                        />
                    </div>

                    <BaseButton type="submit" :light-btn="light" :disabled="true" :text="submitButton">
                    </BaseButton>
                </form>
            </div>

            <!-- Right: Contact Information -->
            <div class="info-section">
                <h2 class="section-title" :class="{ 'light-text': light }">{{title2}}</h2>

                <!-- Contact Details -->
                <div class="info-card" :class="{ 'light-mode': light }">
                    <!-- Email -->
                    <div class="info-item">
                        <div class="info-icon"></div>
                        <div>
                            <p class="info-label">{{email}}</p>
                            <a :href="`mailto:${contactInfo.email}`" class="info-value email-link">
                                {{ contactInfo.email }}
                            </a>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="info-item" v-if="contactInfo.phone">
                        <div class="info-icon"></div>
                        <div>
                            <p class="info-label">{{phone2}}</p>
                            <a :href="`tel:${contactInfo.phone}`" class="info-value phone-link">
                                {{ contactInfo.phone }}
                            </a>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="info-item" v-if="contactInfo.address">
                        <div class="info-icon"></div>
                        <div>
                            <p class="info-label">{{address}}</p>
                            <p class="info-value">{{ contactInfo.address }}</p>
                        </div>
                    </div>

                </div>

                <!-- Social Links -->
                <div class="socials-section" v-if="contactInfo.socials && contactInfo.socials.length">
                    <p class="socials-title" :class="{ 'light-text': light }">{{followUs}}</p>
                    <div class="socials-grid">
                        <a
                            v-for="social in contactInfo.socials"
                            :key="social.name"
                            :href="social.url"
                            :title="social.name"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="social-link"
                            :class="{ 'light-mode': light }"
                        >
                            {{ social.name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed, defineProps, ref} from 'vue'
import BaseButton from '../Base/BaseButton.vue'
import { useTranslations } from '@/composables/useTranslations.js'
const { t } = useTranslations()

const title1 = computed(() => t.value?.contact?.form?.title)
const name = computed(() => t.value?.contact?.form?.name)
const namePlaceholder = computed(() => t.value?.contact?.form.namePlaceholder)
const email = computed(() => t.value?.contact?.form?.email)
const emailPlaceholder = computed(() => t.value?.contact?.form?.emailPlaceholder)
const phone = computed(() => t.value?.contact?.form?.phone)
const phonePlaceholder = computed(() => t.value?.contact?.form?.phonePlaceholder)
const subject = computed(() => t.value?.contact?.form?.subject)
const subjectPlaceholder = computed(() => t.value?.contact?.form?.subjectPlaceholder)
const message = computed(() => t.value?.contact?.form?.message)
const messagePlaceholder = computed(() => t.value?.contact?.form?.messagePlaceholder)
const submitButton = computed(() => t.value?.contact?.form?.submitButton)

const title2 = computed(() => t.value?.contact?.contactInfo?.title)
const phone2 = computed(() => t.value?.contact?.contactInfo?.phone)
const address = computed(() => t.value?.contact?.contactInfo?.address)
const followUs = computed(() => t.value?.contact?.contactInfo?.followUs)



const props = defineProps({
    light: {
        type: Boolean,
        default: false
    },
    contactInfo: {
        type: Object,
        default: () => ({
            email: 'info@khll.nl',
            phone: '06 12345678',
            address: 'Voorstraat 123, 1234 AB Amsterdam',
            socials: [
                { name: 'Facebook', url: 'https://facebook.com' },
                { name: 'Instagram', url: 'https://instagram.com' },
            ]
        })
    },
    submitLabel: {
        type: String,
        default: 'Bericht Verzenden'
    }
})


const emit = defineEmits(['submit'])

const formData = ref({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: ''
})

const handleSubmit = () => {
    // Emit form data to parent component
    emit('submit', {
        ...formData.value,
        timestamp: new Date().toISOString()
    })

    // Reset form
    formData.value = {
        name: '',
        email: '',
        phone: '',
        subject: '',
        message: ''
    }
}
</script>

<style scoped>
.contact-section {
    @apply w-full px-4 md:px-8 lg:px-12 py-12;
}

.contact-section.light-mode {
    @apply bg-text-dark;
}

.contact-container {
    @apply grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 max-w-6xl mx-auto;
}

/* Form Section */
.form-section {
    @apply flex flex-col;
}

.section-title {
    @apply text-3xl font-bold text-text-dark mb-6;
}

.section-title.light-text {
    @apply text-text-light;
}

.contact-form {
    @apply flex flex-col gap-4;
}

.form-group {
    @apply flex flex-col gap-2;
}

.form-label {
    @apply font-semibold text-sm text-text-dark;
}

.form-label.light-text {
    @apply text-text-light;
}

.form-input,
.form-textarea {
    @apply px-4 py-2 border border-surface rounded-lg;
    @apply transition-all duration-200;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(234, 183, 81, 0.1);
}

.form-input.light-mode,
.form-textarea.light-mode {
    @apply bg-text-dark border-text-dark/30 text-text-light placeholder-text-muted;
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

/* Info Section */
.info-section {
    @apply flex flex-col;
}

.info-card {
    @apply rounded-lg p-6 space-y-6;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.12) 0%, rgba(234, 183, 81, 0.04) 100%);
    border: 1px solid rgba(234, 183, 81, 0.25);}

.info-card.light-mode {
    @apply bg-text-dark/50 border border-text-dark/30;
}

.info-item {
    @apply flex gap-4;
}

.info-icon {
    @apply text-3xl;
}

.info-label {
    @apply text-sm font-semibold text-text-muted;
}

.info-card.light-mode .info-label {
    @apply text-accent-soft;
}

.info-value {
    @apply text-text-dark font-medium;
}

.info-card.light-mode .info-value {
    @apply text-text-light;
}

.email-link,
.phone-link {
    @apply text-primary hover:text-primary-hover transition-colors;
    text-decoration: none;
}

.info-card.light-mode .email-link,
.info-card.light-mode .phone-link {
    @apply text-yellow-300 hover:text-yellow-200;
}

/* Socials Section */
.socials-section {
    @apply mt-8 pt-6 border-t border-surface;
}

.info-card.light-mode .socials-section {
    border-top-color: rgba(255, 255, 255, 0.1);
}

.socials-title {
    @apply text-sm font-semibold text-text-muted mb-4;
}

.socials-title.light-text {
    @apply text-accent-soft;
}

.socials-grid {
    @apply grid grid-cols-3 gap-3;
}

.social-link {
    @apply px-4 py-2 bg-primary/10 text-primary rounded-lg text-center text-sm font-semibold;
    @apply hover:bg-primary/20 transition-colors;
    text-decoration: none;
}

.social-link.light-mode {
    @apply bg-primary/20 text-yellow-300 hover:bg-primary/30;
}

/* Responsive */
@media (max-width: 1023px) {
    .info-section{
        @apply mt-20;
    }
}
@media (max-width: 768px) {
    .contact-section {
        @apply px-4 py-8;
    }

    .contact-container {
        @apply gap-6;
    }

    .socials-grid {
        @apply grid-cols-2;
    }
}

</style>
