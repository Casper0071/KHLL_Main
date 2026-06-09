<template>
    <div class="disclaimer-page">
        <div class="disclaimer-page__container">
            <div class="disclaimer-page__content">
                <h1 class="disclaimer-page__title">Disclaimer</h1>

                <div class="disclaimer-page__body">
                    <div class="disclaimer-page__intro">
                        <p>
                            Op deze pagina vindt u de disclaimer van
                            <a href="https://lentekrans.nl/" class="disclaimer-page__link">https://lentekrans.nl/</a>,
                            zoals deze beschikbaar is gesteld door Koninklijke Harmonie Lentekrans Linne.
                            In deze disclaimer geven wij aan onder welk voorbehoud wij de informatie op onze website aan u aanbieden.
                        </p>
                    </div>

                    <div class="disclaimer-page__section">
                        <h2 class="disclaimer-page__section-title">Intellectueel eigendom</h2>
                        <div class="disclaimer-page__section-content">
                            <p>
                                Het gebruik van de informatie op deze website is gratis zolang u deze informatie niet kopieert,
                                verspreidt of op een andere manier gebruikt of misbruikt. U mag de informatie op deze website
                                alleen hergebruiken volgens de regelingen van het dwingend recht.
                            </p>
                            <p>
                                Zonder uitdrukkelijke schriftelijke toestemming van Koninklijke Harmonie Lentekrans Linne is
                                het niet toegestaan tekst, fotomateriaal of andere materialen op deze website her te gebruiken.
                                Het intellectueel eigendom berust bij Koninklijke Harmonie Lentekrans Linne.
                            </p>
                        </div>
                    </div>

                    <div class="disclaimer-page__section">
                        <h2 class="disclaimer-page__section-title">Geen garantie op juistheid</h2>
                        <div class="disclaimer-page__section-content">
                            <p>
                                Voor de prijzen die op onze website staan, geldt dat wij streven naar een zo zorgvuldig mogelijke
                                weergave van de realiteit en de bedoelde prijzen. Fouten die daarbij ontstaan en herkenbaar zijn
                                als programmeer dan wel typefouten, vormen nooit een aanleiding om een contract dan wel overeenkomst
                                met Koninklijke Harmonie Lentekrans Linne te mogen claimen of te veronderstellen.
                            </p>
                            <p>
                                Koninklijke Harmonie Lentekrans Linne streeft naar een zo actueel mogelijke website. Mocht ondanks
                                deze inspanningen de informatie van of de inhoud op deze website onvolledig en of onjuist zijn,
                                dan kunnen wij daarvoor geen aansprakelijkheid aanvaarden.
                            </p>
                            <p>
                                De informatie en/of producten op deze website worden aangeboden zonder enige vorm van garantie
                                en of aanspraak op juistheid. Wij behouden ons het recht voor om deze materialen te wijzigen,
                                te verwijderen of opnieuw te plaatsen zonder enige voorafgaande medeling. Koninklijke Harmonie
                                Lentekrans Linne aanvaardt geen aansprakelijkheid voor enige informatie staat waarnaar wij via
                                hyperlinks verwijzen.
                            </p>
                        </div>
                    </div>

                    <div class="disclaimer-page__section">
                        <h2 class="disclaimer-page__section-title">Wijzigingen</h2>
                        <div class="disclaimer-page__section-content">
                            <p>
                                Mocht deze disclaimer wijzigen, dan vindt u de meest recente versie van de disclaimer van
                                <a href="https://lentekrans.nl/" class="disclaimer-page__link">https://lentekrans.nl/</a> op deze pagina.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'

defineOptions({
    layout: MainLayout
})
</script>

<style scoped>
/* ============================================
   Disclaimer Page Container
   ============================================ */
.disclaimer-page {
    min-height: 100vh;
    background-color: var(--background);
    padding: 2rem 1rem;
}

.disclaimer-page__container {
    max-width: 900px;
    margin: 0 auto;
}

.disclaimer-page__content {
    background-color: white;
    border-radius: 1rem;
    box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}

/* ============================================
   Title
   ============================================ */
.disclaimer-page__title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 3px solid var(--primary);
    display: inline-block;
}

/* ============================================
   Body Content
   ============================================ */
.disclaimer-page__body {
    margin-top: 1rem;
}

/* ============================================
   Intro Section
   ============================================ */
.disclaimer-page__intro {
    background-color: #f8fafc;
    padding: 1.25rem;
    border-radius: 0.75rem;
    border-left: 4px solid var(--primary);
    margin-bottom: 1.5rem;
}

.disclaimer-page__intro p {
    font-size: 1rem;
    line-height: 1.6;
    color: #2d3748;
    font-weight: 500;
    margin: 0;
}

/* ============================================
   Section Styles
   ============================================ */
.disclaimer-page__section {
    margin-bottom: 1.5rem;
}

.disclaimer-page__section:last-child {
    margin-bottom: 0;
}

.disclaimer-page__section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin: 1.25rem 0 0.75rem 0;
    padding-top: 0.25rem;
}

.disclaimer-page__section-title:first-of-type {
    margin-top: 0;
}

.disclaimer-page__section-content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.disclaimer-page__section-content p {
    font-size: 0.875rem;
    line-height: 1.6;
    color: #4a5568;
    margin: 0;
}

/* ============================================
   Links
   ============================================ */
.disclaimer-page__link {
    color: var(--primary);
    text-decoration: none;
    border-bottom: 1px solid transparent;
    transition: all 0.2s ease;
}

.disclaimer-page__link:hover {
    color: var(--primary-hover);
    border-bottom-color: var(--primary);
}

/* ============================================
   Responsive Design
   ============================================ */

/* Tablet (640px - 768px) */
@media (min-width: 640px) {
    .disclaimer-page {
        padding: 2rem 1.5rem;
    }

    .disclaimer-page__content {
        padding: 2rem;
    }

    .disclaimer-page__title {
        font-size: 2rem;
        margin-bottom: 1.75rem;
        padding-bottom: 1rem;
    }

    .disclaimer-page__intro {
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .disclaimer-page__intro p {
        font-size: 1.0625rem;
    }

    .disclaimer-page__section-title {
        font-size: 1.375rem;
        margin: 1.5rem 0 1rem 0;
    }

    .disclaimer-page__section-content p {
        font-size: 0.9375rem;
    }
}

/* Desktop (1024px+) */
@media (min-width: 1024px) {
    .disclaimer-page {
        padding: 3rem 2rem;
    }

    .disclaimer-page__content {
        padding: 3rem;
    }

    .disclaimer-page__title {
        font-size: 2.25rem;
        margin-bottom: 2rem;
    }

    .disclaimer-page__intro {
        padding: 1.75rem;
        margin-bottom: 2.5rem;
    }

    .disclaimer-page__intro p {
        font-size: 1.125rem;
    }

    .disclaimer-page__section-title {
        font-size: 1.5rem;
        margin: 2rem 0 1rem 0;
    }

    .disclaimer-page__section-content p {
        font-size: 1rem;
    }
}

/* Mobile (max 640px) */
@media (max-width: 640px) {
    .disclaimer-page {
        padding: 1.5rem 0.75rem;
    }

    .disclaimer-page__content {
        padding: 1rem;
        border-radius: 0.75rem;
    }

    .disclaimer-page__title {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
    }

    .disclaimer-page__intro {
        padding: 1rem;
        margin-bottom: 1.25rem;
    }

    .disclaimer-page__intro p {
        font-size: 0.875rem;
    }

    .disclaimer-page__section-title {
        font-size: 1.125rem;
        margin: 1rem 0 0.5rem 0;
    }

    .disclaimer-page__section-content p {
        font-size: 0.8125rem;
    }
}

/* Extra kleine schermen (max 375px) */
@media (max-width: 375px) {
    .disclaimer-page {
        padding: 1rem 0.5rem;
    }

    .disclaimer-page__content {
        padding: 0.75rem;
    }

    .disclaimer-page__title {
        font-size: 1.25rem;
    }

    .disclaimer-page__intro {
        padding: 0.75rem;
    }

    .disclaimer-page__section-title {
        font-size: 1rem;
    }

    .disclaimer-page__section-content p {
        font-size: 0.75rem;
    }
}
</style>
