<template>
    <div class="contact-section" :class="{ 'light-mode': light }">
        <div class="contact-container">
            <!-- Left: Contact Form -->
            <div class="form-section">
                <h2 class="section-title" :class="{ 'light-text': light }">{{ title1 }}</h2>

                <form @submit.prevent="handleSubmit" class="contact-form">
                    <div class="form-group">
                        <label for="name" class="form-label" :class="{ 'light-text': light }">{{ name }}</label>
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
                        <label for="email" class="form-label" :class="{ 'light-text': light }">{{ emailLabel }}</label>
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
                        <label for="phone" class="form-label" :class="{ 'light-text': light }">{{ phoneLabel }}</label>
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
                        <label for="subject" class="form-label" :class="{ 'light-text': light }">{{ subjectLabel }}</label>
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
                        <label for="message" class="form-label" :class="{ 'light-text': light }">{{ messageLabel }}</label>
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

                    <BaseButton type="submit" :light-btn="light" :text="submitButton">
                    </BaseButton>
                </form>
            </div>

            <!-- Right: Contact Information -->
            <div class="info-section">
                <h2 class="section-title" :class="{ 'light-text': light }">{{ title2 }}</h2>

                <div class="info-card" :class="{ 'light-mode': light }">
                    <!-- Email -->
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="info-label">{{ emailLabel }}</p>
                            <a :href="`mailto:${contactInfo.email}`" class="info-value email-link">
                                {{ contactInfo.email }}
                            </a>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="info-item" v-if="contactInfo.phone">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="info-label">{{ phoneLabel2 }}</p>
                            <a :href="`tel:${contactInfo.phone}`" class="info-value phone-link">
                                {{ contactInfo.phone }}
                            </a>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="info-item" v-if="contactInfo.address">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="info-label">{{ addressLabel }}</p>
                            <p class="info-value">{{ contactInfo.address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="socials-section" v-if="contactInfo.facebook || contactInfo.instagram">
                    <p class="socials-title" :class="{ 'light-text': light }">{{ followUs }}</p>
                    <div class="socials-grid">
                        <a
                            v-if="contactInfo.facebook"
                            :href="contactInfo.facebook"
                            title="Facebook"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="social-link"
                            :class="{ 'light-mode': light }"
                        >
                            Facebook
                        </a>
                        <a
                            v-if="contactInfo.instagram"
                            :href="contactInfo.instagram"
                            title="Instagram"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="social-link"
                            :class="{ 'light-mode': light }"
                        >
                            Instagram
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, defineProps, ref } from 'vue'
import BaseButton from '../Base/BaseButton.vue'
import { useTranslations } from '@/composables/useTranslations.js'

const { t } = useTranslations()

// Form labels
const title1 = computed(() => t.value?.contact?.form?.title || 'Send us a Message')
const name = computed(() => t.value?.contact?.form?.name || 'Name')
const namePlaceholder = computed(() => t.value?.contact?.form?.namePlaceholder || 'Your full name')
const emailLabel = computed(() => t.value?.contact?.form?.email || 'Email')
const emailPlaceholder = computed(() => t.value?.contact?.form?.emailPlaceholder || 'your.email@example.com')
const phoneLabel = computed(() => t.value?.contact?.form?.phone || 'Phone number (optional)')
const phonePlaceholder = computed(() => t.value?.contact?.form?.phonePlaceholder || '+1 234 567 8900')
const subjectLabel = computed(() => t.value?.contact?.form?.subject || 'Subject')
const subjectPlaceholder = computed(() => t.value?.contact?.form?.subjectPlaceholder || 'What is your question?')
const messageLabel = computed(() => t.value?.contact?.form?.message || 'Message')
const messagePlaceholder = computed(() => t.value?.contact?.form?.messagePlaceholder || 'Tell us more...')
const submitButton = computed(() => t.value?.contact?.form?.submitButton || 'Send Message')

// Info labels
const title2 = computed(() => t.value?.contact?.contactInfo?.title || 'Contact Information')
const phoneLabel2 = computed(() => t.value?.contact?.contactInfo?.phone || 'Phone')
const addressLabel = computed(() => t.value?.contact?.form?.addressLable || 'Address')
const followUs = computed(() => t.value?.contact?.contactInfo?.followUs || 'Follow Us')

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
            facebook: 'https://facebook.com',
            instagram: 'https://instagram.com'
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
    emit('submit', {
        ...formData.value,
        timestamp: new Date().toISOString()
    })

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
/* Je bestaande styles blijven hetzelfde */
.contact-section {
    @apply w-full px-4 md:px-8 lg:px-12 py-12;
}

.contact-section.light-mode {
    @apply bg-text-dark;
}

.contact-container {
    @apply grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 max-w-6xl mx-auto;
}

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
    @apply px-4 py-2 border border-surface rounded-lg transition-all duration-200 bg-white text-text-dark;
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

.info-section {
    @apply flex flex-col;
}

.info-card {
    @apply rounded-lg p-6 space-y-6;
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.12) 0%, rgba(234, 183, 81, 0.04) 100%);
    border: 1px solid rgba(234, 183, 81, 0.25);
}

.info-card.light-mode {
    @apply bg-text-dark/50 border border-text-dark/30;
}

.info-item {
    @apply flex gap-4;
}

.info-icon {
    @apply text-text-dark flex-shrink-0;
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
    @apply grid grid-cols-2 gap-3;
}

.social-link {
    @apply px-4 py-2 bg-primary/10 text-primary rounded-lg text-center text-sm font-semibold transition-colors;
    text-decoration: none;
}

.social-link:hover {
    @apply bg-primary/20;
}

.social-link.light-mode {
    @apply bg-primary/20 text-yellow-300;
}

.social-link.light-mode:hover {
    @apply bg-primary/30;
}

@media (max-width: 1023px) {
    .info-section {
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
