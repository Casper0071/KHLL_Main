<template>
    <div class="contact-section" :class="{ 'light-mode': light }">
        <div class="contact-container">
            <!-- Left: Contact Form -->
            <div class="form-section">
                <div class="form-header">
                    <h2 class="section-title" :class="{ 'light-text': light }">{{ title1 }}</h2>
                </div>

                <form @submit.prevent="handleSubmit" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" :class="{ 'light-text': light }">
                                {{ name }}
                                <span class="required-star">*</span>
                            </label>
                            <input
                                v-model="formData.name"
                                type="text"
                                required
                                :placeholder="namePlaceholder"
                                class="form-input"
                                :class="{ 'light-mode': light, 'has-value': formData.name }"
                            />
                        </div>

                        <div class="form-group">
                            <label class="form-label" :class="{ 'light-text': light }">
                                {{ emailLabel }}
                                <span class="required-star">*</span>
                            </label>
                            <input
                                v-model="formData.email"
                                type="email"
                                required
                                :placeholder="emailPlaceholder"
                                class="form-input"
                                :class="{ 'light-mode': light, 'has-value': formData.email }"
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" :class="{ 'light-text': light }">
                            {{ subjectLabel }}
                            <span class="required-star">*</span>
                        </label>
                        <input
                            v-model="formData.subject"
                            type="text"
                            required
                            :placeholder="subjectPlaceholder"
                            class="form-input"
                            :class="{ 'light-mode': light, 'has-value': formData.subject }"
                        />
                    </div>

                    <div class="form-group">
                        <label class="form-label" :class="{ 'light-text': light }">
                            {{ messageLabel }}
                            <span class="required-star">*</span>
                        </label>
                        <textarea
                            v-model="formData.message"
                            required
                            :placeholder="messagePlaceholder"
                            class="form-textarea"
                            :class="{ 'light-mode': light, 'has-value': formData.message }"
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
                    />
                </form>
            </div>

            <!-- Right: Contact Information -->
            <div class="info-section">
                <div class="info-header">
                    <h2 class="section-title" :class="{ 'light-text': light }">{{ title2 }}</h2>
                </div>

                <div class="info-card" :class="{ 'light-mode': light }">
                    <!-- Email -->
                    <div class="info-item">
                        <div class="info-icon email-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <p class="info-label">{{ emailLabel }}</p>
                            <a :href="`mailto:${contactInfo.email}`" class="info-value email-link">
                                {{ contactInfo.email }}
                            </a>
                        </div>
                    </div>

                    <!-- Bestuur Sectie (vervangt Phone) -->
                    <div class="board-section" v-if="contactInfo.board && contactInfo.board.length">
                        <div class="board-header">
                            <div class="info-icon board-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <p class="info-label board-label">{{ boardTitle }}</p>
                        </div>
                        <div class="board-members">
                            <div v-for="(member, index) in contactInfo.board" :key="index" class="board-member">
                                <p class="member-name">{{ member.name }}</p>
                                <p class="member-title">{{ member.title }}</p>
                                <a :href="`mailto:${member.email}`" class="member-email">
                                    {{ member.email }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="info-item" v-if="contactInfo.address">
                        <div class="info-icon address-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <p class="info-label">{{ addressLabel }}</p>
                            <p class="info-value">{{ contactInfo.address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="socials-section" v-if="contactInfo.facebook">
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
import BaseButton from '@/Components/Base/BaseButton.vue'
import { useTranslations } from '@/composables/useTranslations.js'

const { t } = useTranslations()

// Form labels
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

// Info labels
const title2 = computed(() => t.value?.contact?.contactInfo?.title || 'Contact Information')
const boardTitle = computed(() => t.value?.contact?.contactInfo?.boardTitle || 'Bestuur')
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
.contact-section {
    width: 100%;
    padding: 4rem 2rem;
}

.contact-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
}

/* ============================================
   FORM SECTION
   ============================================ */
.form-section {
    border-radius: 0;
    padding: 0;
}

.form-header {
    margin-bottom: 2rem;
}
.form-header h2 {
    margin-top: 2rem;
}

.section-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
}

.section-title.light-text {
    color: var(--text-light);
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.form-group textarea{
    min-height: 450px;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label.light-text {
    color: var(--text-light);
}

.required-star {
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    color: #1a1a2e;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(234, 183, 81, 0.1);
}

.form-input.light-mode,
.form-textarea.light-mode {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.2);
    color: var(--text-light);
}

.form-input.light-mode:focus,
.form-textarea.light-mode:focus {
    border-color: var(--primary);
    background: rgba(255, 255, 255, 0.12);
}

.form-input.light-mode::placeholder,
.form-textarea.light-mode::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.form-input.has-value,
.form-textarea.has-value {
    border-color: var(--primary);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

/* ============================================
   INFO SECTION
   ============================================ */
.info-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-header {
    margin-bottom: 0.5rem;
}

.info-card {
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.1) 0%, rgba(234, 183, 81, 0.05) 100%);
    border-radius: 1.5rem;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    border: 1px solid rgba(234, 183, 81, 0.2);
}

.info-card.light-mode {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.1);
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 0.75rem;
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: rgba(234, 183, 81, 0.1);
    transform: translateX(4px);
}

.info-icon {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 1rem;
    flex-shrink: 0;
}

.info-icon svg {
    width: 1.25rem;
    height: 1.25rem;
}

.email-icon {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.address-icon {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.board-icon {
    background: rgba(139, 92, 246, 0.1);
    color: #8b5cf6;
}

.info-content {
    flex: 1;
}

.info-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #888;
    margin-bottom: 0.25rem;
}

.info-value {
    font-size: 1rem;
    font-weight: 500;
    color: #1a1a2e;
    word-break: break-word;
}

.info-card.light-mode .info-value {
    color: var(--text-light);
}

.email-link {
    text-decoration: none;
    transition: color 0.2s;
    color: #3b82f6;
}

.email-link:hover {
    color: #2563eb;
}

.info-card.light-mode .email-link {
    color: #60a5fa;
}

/* ============================================
   BESTUUR SECTIE
   ============================================ */
.board-section {
    padding: 0.75rem;
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.board-section:hover {
    background: rgba(234, 183, 81, 0.1);
    transform: translateX(4px);
}

.board-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.board-label {
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #888;
    margin: 0;
}

.board-members {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-left: 3.5rem;
}

.board-member {
    padding-bottom: 0.75rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.board-member:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.member-name {
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 0.25rem;
}

.member-title {
    font-size: 0.75rem;
    color: #888;
    margin-bottom: 0.25rem;
}

.member-email {
    font-size: 0.875rem;
    color: #3b82f6;
    text-decoration: none;
    transition: color 0.2s;
    word-break: break-all;
}

.member-email:hover {
    color: #2563eb;
    text-decoration: underline;
}

.info-card.light-mode .member-name {
    color: var(--text-light);
}

.info-card.light-mode .member-title {
    color: var(--text-muted);
}

.info-card.light-mode .member-email {
    color: #60a5fa;
}

.info-card.light-mode .member-email:hover {
    color: #93c5fd;
}

/* ============================================
   SOCIAL LINKS
   ============================================ */
.socials-section {
    background: linear-gradient(135deg, rgba(234, 183, 81, 0.1) 0%, rgba(234, 183, 81, 0.05) 100%);
    border-radius: 1.5rem;
    padding: 1.5rem;
    border: 1px solid rgba(234, 183, 81, 0.2);
}

.socials-section.light-mode {
    background: rgba(255, 255, 255, 0.05);
}

.socials-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #666;
    margin-bottom: 1rem;
    text-align: center;
}

.socials-title.light-text {
    color: var(--text-muted);
}

.socials-grid {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.social-link {
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

.social-link svg {
    width: 1rem;
    height: 1rem;
}

.social-link:hover {
    background: rgba(234, 183, 81, 0.25);
    transform: translateY(-2px);
}

.social-link.light-mode {
    background: rgba(234, 183, 81, 0.2);
    color: #fbbf24;
}

.social-link.light-mode:hover {
    background: rgba(234, 183, 81, 0.3);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 1024px) {
    .contact-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .info-section {
        order: 1;
    }

    .form-section {
        order: 2;
    }
    .form-group textarea{
        min-height: 250px;
    }
}

@media (max-width: 768px) {
    .contact-section {
        padding: 2rem 1rem;
    }

    .info-card,
    .socials-section {
        padding: 1.5rem;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .section-title {
        font-size: 1.5rem;
    }

    .info-item:hover,
    .board-section:hover {
        transform: translateX(0);
    }

    .board-members {
        margin-left: 0;
    }
}

@media (max-width: 480px) {
    .info-card,
    .socials-section {
        padding: 1rem;
    }

    .form-input,
    .form-textarea {
        padding: 0.75rem;
        font-size: 0.875rem;
    }

    .board-member {
        word-break: break-word;
    }
}
</style>
