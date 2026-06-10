<template>
    <div v-intersect="'animate'" class="contact-widget" :class="{ 'contact-widget--light': light }">
        <div class="contact-widget__container">
            <!-- Left: Contact Form -->
            <div class="contact-widget__form">
                <div class="contact-widget__form-header">
                    <h2 class="contact-widget__title" :class="{ 'contact-widget__title--light': light }">{{ title1 }}</h2>
                </div>

                <form @submit.prevent="handleSubmit" class="contact-widget__form-element">
                    <div class="contact-widget__form-row">
                        <div class="contact-widget__form-group">
                            <label class="contact-widget__form-label" :class="{ 'contact-widget__form-label--light': light }">
                                {{ name }}
                                <span class="contact-widget__required-star">*</span>
                            </label>
                            <input
                                v-model="formData.name"
                                type="text"
                                required
                                :placeholder="namePlaceholder"
                                class="contact-widget__form-input"
                                :class="{
                                    'contact-widget__form-input--light': light,
                                    'contact-widget__form-input--has-value': formData.name
                                }"
                            />
                        </div>

                        <div class="contact-widget__form-group">
                            <label class="contact-widget__form-label" :class="{ 'contact-widget__form-label--light': light }">
                                {{ emailLabel }}
                                <span class="contact-widget__required-star">*</span>
                            </label>
                            <input
                                v-model="formData.email"
                                type="email"
                                required
                                :placeholder="emailPlaceholder"
                                class="contact-widget__form-input"
                                :class="{
                                    'contact-widget__form-input--light': light,
                                    'contact-widget__form-input--has-value': formData.email
                                }"
                            />
                        </div>
                    </div>

                    <div class="contact-widget__form-group">
                        <label class="contact-widget__form-label" :class="{ 'contact-widget__form-label--light': light }">
                            {{ subjectLabel }}
                            <span class="contact-widget__required-star">*</span>
                        </label>
                        <input
                            v-model="formData.subject"
                            type="text"
                            required
                            :placeholder="subjectPlaceholder"
                            class="contact-widget__form-input"
                            :class="{
                                'contact-widget__form-input--light': light,
                                'contact-widget__form-input--has-value': formData.subject
                            }"
                        />
                    </div>

                    <div class="contact-widget__form-group">
                        <label class="contact-widget__form-label" :class="{ 'contact-widget__form-label--light': light }">
                            {{ messageLabel }}
                            <span class="contact-widget__required-star">*</span>
                        </label>
                        <textarea
                            v-model="formData.message"
                            required
                            :placeholder="messagePlaceholder"
                            class="contact-widget__form-textarea"
                            :class="{
                                'contact-widget__form-textarea--light': light,
                                'contact-widget__form-textarea--has-value': formData.message
                            }"
                            rows="5"
                        />
                    </div>

                    <BaseButton
                        type="submit"
                        :text="submitButton"
                        variant="primary"
                        size="lg"
                        rounded="lg"
                        icon="right"
                        :fullWidth="true"
                        :lightBtn="light"
                        :disabled="true"
                    />
                </form>
            </div>

            <!-- Right: Contact Information -->
            <div class="contact-widget__info">
                <div class="contact-widget__info-header">
                    <h2 class="contact-widget__title" :class="{ 'contact-widget__title--light': light }">{{ title2 }}</h2>
                </div>

                <div class="contact-widget__info-card" :class="{ 'contact-widget__info-card--light': light }">
                    <!-- Email -->
                    <div class="contact-widget__info-item">
                        <div class="contact-widget__info-icon contact-widget__info-icon--email">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="contact-widget__info-content">
                            <p class="contact-widget__info-label">{{ emailLabel }}</p>
                            <a :href="`mailto:${contactInfo.email}`" class="contact-widget__info-value contact-widget__info-value--link">
                                {{ contactInfo.email }}
                            </a>
                        </div>
                    </div>

                    <!-- Bestuur Sectie -->
                    <div class="contact-widget__board" v-if="contactInfo.board && contactInfo.board.length">
                        <div class="contact-widget__board-header">
                            <div class="contact-widget__info-icon contact-widget__info-icon--board">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <p class="contact-widget__board-label">{{ boardTitle }}</p>
                        </div>
                        <div class="contact-widget__board-members">
                            <div v-for="(member, index) in contactInfo.board" :key="index" class="contact-widget__board-member">
                                <p class="contact-widget__board-member-name">{{ member.name }}</p>
                                <p class="contact-widget__board-member-title">{{ member.title }}</p>
                                <a :href="`mailto:${member.email}`" class="contact-widget__board-member-email">
                                    {{ member.email }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="contact-widget__info-item" v-if="contactInfo.address">
                        <div class="contact-widget__info-icon contact-widget__info-icon--address">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="contact-widget__info-content">
                            <p class="contact-widget__info-label">{{ addressLabel }}</p>
                            <p class="contact-widget__info-value">{{ contactInfo.address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="contact-widget__socials" v-if="contactInfo.facebook">
                    <p class="contact-widget__socials-title" :class="{ 'contact-widget__socials-title--light': light }">{{ followUs }}</p>
                    <div class="contact-widget__socials-grid">
                        <a
                            v-if="contactInfo.facebook"
                            :href="contactInfo.facebook"
                            title="Facebook"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="contact-widget__social-link"
                            :class="{ 'contact-widget__social-link--light': light }"
                        >
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                            </svg>
                            Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, defineProps, ref } from 'vue'
import axios from 'axios'
import BaseButton from '@/Components/Base/BaseButton.vue'
import { useTranslations } from '@/composables/useTranslations.js'

// ============================================
// Composables
// ============================================

const { t } = useTranslations()

// ============================================
// Computed Properties - Form Labels
// ============================================

const title1 = computed(() => t.value?.contact?.form?.title || 'Send us a Message')
const name = computed(() => t.value?.contact?.form?.name || 'Name')
const namePlaceholder = computed(() => t.value?.contact?.form?.namePlaceholder || 'Your full name')
const emailLabel = computed(() => t.value?.contact?.form?.email || 'Email')
const emailPlaceholder = computed(() => t.value?.contact?.form?.emailPlaceholder || 'your.email@example.com')
const subjectLabel = computed(() => t.value?.contact?.form?.subject || 'Subject')
const subjectPlaceholder = computed(() => t.value?.contact?.form?.subjectPlaceholder || 'What is your question?')
const messageLabel = computed(() => t.value?.contact?.form?.message || 'Message')
const messagePlaceholder = computed(() => t.value?.contact?.form?.messagePlaceholder || 'Tell us more...')
const submitButton = computed(() => t.value?.contact?.form?.submitButton || 'Send Message')

// ============================================
// Computed Properties - Info Labels
// ============================================

const title2 = computed(() => t.value?.contact?.contactInfo?.title || 'Contact Information')
const boardTitle = computed(() => t.value?.contact?.contactInfo?.boardTitle || 'Bestuur')
const addressLabel = computed(() => t.value?.contact?.form?.addressLable || 'Address')
const followUs = computed(() => t.value?.contact?.contactInfo?.followUs || 'Follow Us')

// ============================================
// Props
// ============================================

const props = defineProps({
    light: {
        type: Boolean,
        default: false
    },
    contactInfo: {
        type: Object,
        default: () => ({
            email: 'info@khll.nl',
            address: 'Grotestraat 9, 6067 BP Linne',
            board: [
                {
                    name: 'Casper Vocking',
                    title: 'Voorzitter',
                    email: 'casper.vocking@gmail.com'
                },
                {
                    name: 'Jan Jansen',
                    title: 'Secretaris',
                    email: 'secretaris@khll.nl'
                },
                {
                    name: 'Piet Peters',
                    title: 'Penningmeester',
                    email: 'penningmeester@khll.nl'
                }
            ],
            facebook: 'https://facebook.com'
        })
    },
    submitLabel: {
        type: String,
        default: 'Bericht Verzenden'
    }
})

// ============================================
// Emits
// ============================================

const emit = defineEmits(['submit'])

// ============================================
// Reactive State
// ============================================

const formData = ref({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: ''
})

// ============================================
// Methods
// ============================================

const handleSubmit = async () => {
    try {
        console.log('📤 Contact form data wordt verstuurd:', formData.value)

        const response = await axios.post('/api/contact/send', {
            name: formData.value.name,
            email: formData.value.email,
            subject: formData.value.subject,
            message: formData.value.message,
        })

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

    } catch (error) {
        console.error('❌ Error:', error.response?.data || error.message)
        alert('Er is een fout opgetreden. Probeer het later opnieuw.')
    }
}
</script>

<style scoped>
/* ============================================
   SCROLL ANIMATION - WORDT GETRIGGERD DOOR DIRECTIVE
   ============================================ */

.contact-widget {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.contact-widget.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   CONTACT WIDGET CONTAINER
   ============================================ */

.contact-widget {
    width: 100%;
    padding: 4rem 2rem;
}

.contact-widget--light {
    /* Light mode variant container styles */
}

.contact-widget__container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
}

/* ============================================
   FORM SECTION
   ============================================ */

.contact-widget__form {
    border-radius: 0;
    padding: 0;
}

.contact-widget__form-header {
    margin-bottom: 2rem;
}

.contact-widget__form-header h2 {
    margin-top: 2rem;
}

.contact-widget__title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
}

.contact-widget__title--light {
    color: var(--text-light);
}

.contact-widget__form-element {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contact-widget__form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.contact-widget__form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.contact-widget__form-group textarea {
    min-height: 450px;
}

.contact-widget__form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.contact-widget__form-label--light {
    color: var(--text-light);
}

.contact-widget__required-star {
    color: #ef4444;
    margin-left: 0.25rem;
}

.contact-widget__form-input,
.contact-widget__form-textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    color: #1a1a2e;
}

.contact-widget__form-input:focus,
.contact-widget__form-textarea:focus {
    outline: none;
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(234, 183, 81, 0.1);
}

.contact-widget__form-input--light,
.contact-widget__form-textarea--light {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.2);
    color: var(--text-light);
}

.contact-widget__form-input--light:focus,
.contact-widget__form-textarea--light:focus {
    border-color: var(--primary);
    background: rgba(255, 255, 255, 0.12);
}

.contact-widget__form-input--light::placeholder,
.contact-widget__form-textarea--light::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.contact-widget__form-input--has-value,
.contact-widget__form-textarea--has-value {
    border-color: var(--primary);
}

.contact-widget__form-textarea {
    resize: vertical;
    min-height: 120px;
}

/* ============================================
   INFO SECTION
   ============================================ */

.contact-widget__info {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contact-widget__info-header {
    margin-bottom: 0.5rem;
}

.contact-widget__info-card {
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.1) 0%, rgba(234, 183, 81, 0.05) 100%);
    border-radius: 1.5rem;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    border: 1px solid rgba(234, 183, 81, 0.2);
}

.contact-widget__info-card--light {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.1);
}

.contact-widget__info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 0.75rem;
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.contact-widget__info-item:hover {
    background: rgba(234, 183, 81, 0.1);
    transform: translateX(4px);
}

.contact-widget__info-icon {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 1rem;
    flex-shrink: 0;
}

.contact-widget__info-icon svg {
    width: 1.25rem;
    height: 1.25rem;
}

.contact-widget__info-icon--email {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.contact-widget__info-icon--address {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.contact-widget__info-icon--board {
    background: rgba(139, 92, 246, 0.1);
    color: #8b5cf6;
}

.contact-widget__info-content {
    flex: 1;
}

.contact-widget__info-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #888;
    margin-bottom: 0.25rem;
}

.contact-widget__info-value {
    font-size: 1rem;
    font-weight: 500;
    color: #1a1a2e;
    word-break: break-word;
}

.contact-widget__info-card--light .contact-widget__info-value {
    color: var(--text-light);
}

.contact-widget__info-value--link {
    text-decoration: none;
    transition: color 0.2s;
    color: #3b82f6;
}

.contact-widget__info-value--link:hover {
    color: #2563eb;
}

.contact-widget__info-card--light .contact-widget__info-value--link {
    color: #60a5fa;
}

/* ============================================
   BOARD SECTION
   ============================================ */

.contact-widget__board {
    padding: 0.75rem;
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.contact-widget__board:hover {
    background: rgba(234, 183, 81, 0.1);
    transform: translateX(4px);
}

.contact-widget__board-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.contact-widget__board-label {
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #888;
    margin: 0;
}

.contact-widget__board-members {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-left: 3.5rem;
}

.contact-widget__board-member {
    padding-bottom: 0.75rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.contact-widget__board-member:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.contact-widget__board-member-name {
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 0.25rem;
}

.contact-widget__board-member-title {
    font-size: 0.75rem;
    color: #888;
    margin-bottom: 0.25rem;
}

.contact-widget__board-member-email {
    font-size: 0.875rem;
    color: #3b82f6;
    text-decoration: none;
    transition: color 0.2s;
    word-break: break-all;
}

.contact-widget__board-member-email:hover {
    color: #2563eb;
    text-decoration: underline;
}

.contact-widget__info-card--light .contact-widget__board-member-name {
    color: var(--text-light);
}

.contact-widget__info-card--light .contact-widget__board-member-title {
    color: var(--text-muted);
}

.contact-widget__info-card--light .contact-widget__board-member-email {
    color: #60a5fa;
}

.contact-widget__info-card--light .contact-widget__board-member-email:hover {
    color: #93c5fd;
}

/* ============================================
   SOCIAL LINKS SECTION
   ============================================ */

.contact-widget__socials {
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.1) 0%, rgba(234, 183, 81, 0.05) 100%);
    border-radius: 1.5rem;
    padding: 1.5rem;
    border: 1px solid rgba(234, 183, 81, 0.2);
}

.contact-widget__socials--light {
    background: rgba(255, 255, 255, 0.05);
}

.contact-widget__socials-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #666;
    margin-bottom: 1rem;
    text-align: center;
}

.contact-widget__socials-title--light {
    color: var(--text-muted);
}

.contact-widget__socials-grid {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.contact-widget__social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: rgba(234, 183, 81, 0.15);
    color: #f59e0b;
}

.contact-widget__social-link svg {
    width: 1rem;
    height: 1rem;
}

.contact-widget__social-link:hover {
    background: rgba(234, 183, 81, 0.25);
    transform: translateY(-2px);
}

.contact-widget__social-link--light {
    background: rgba(234, 183, 81, 0.2);
    color: #fbbf24;
}

.contact-widget__social-link--light:hover {
    background: rgba(234, 183, 81, 0.3);
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

@media (max-width: 1024px) {
    .contact-widget__container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .contact-widget__info {
        order: 1;
    }

    .contact-widget__form {
        order: 2;
    }

    .contact-widget__form-group textarea {
        min-height: 250px;
    }
}

@media (max-width: 768px) {
    .contact-widget {
        padding: 2rem 1rem;
    }

    .contact-widget__info-card,
    .contact-widget__socials {
        padding: 1.5rem;
    }

    .contact-widget__form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .contact-widget__title {
        font-size: 1.5rem;
    }

    .contact-widget__info-item:hover,
    .contact-widget__board:hover {
        transform: translateX(0);
    }

    .contact-widget__board-members {
        margin-left: 0;
    }
}

@media (max-width: 480px) {
    .contact-widget__info-card,
    .contact-widget__socials {
        padding: 1rem;
    }

    .contact-widget__form-input,
    .contact-widget__form-textarea {
        padding: 0.75rem;
        font-size: 0.875rem;
    }

    .contact-widget__board-member {
        word-break: break-word;
    }
}
</style>
