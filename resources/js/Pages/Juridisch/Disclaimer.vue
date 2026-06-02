<!-- Pages/Disclaimer.vue -->
<template>
    <div class="disclaimer-page">
        <div class="disclaimer-container">
            <h1 class="disclaimer-title">Disclaimer</h1>

            <div class="disclaimer-content">
                <p class="intro-text">
                    Op deze pagina vindt u de disclaimer van <a href="https://lentekrans.nl/" class="disclaimer-link">https://lentekrans.nl/</a>, zoals deze beschikbaar is gesteld door Koninklijke Harmonie Lentekrans Linne. In deze disclaimer geven wij aan onder welk voorbehoud wij de informatie op onze website aan u aanbieden.
                </p>

                <h2 class="section-title">Intellectueel eigendom</h2>
                <p class="section-text">
                    Het gebruik van de informatie op deze website is gratis zolang u deze informatie niet kopieert, verspreidt of op een andere manier gebruikt of misbruikt. U mag de informatie op deze website alleen hergebruiken volgens de regelingen van het dwingend recht.
                </p>
                <p class="section-text">
                    Zonder uitdrukkelijke schriftelijke toestemming van Koninklijke Harmonie Lentekrans Linne is het niet toegestaan tekst, fotomateriaal of andere materialen op deze website her te gebruiken. Het intellectueel eigendom berust bij Koninklijke Harmonie Lentekrans Linne.

                </p>

                <h2 class="section-title">Geen garantie op juistheid</h2>
                <p class="section-text">
                    Voor de prijzen die op onze website staan, geldt dat wij streven naar een zo zorgvuldig mogelijke weergave van de realiteit en de bedoelde prijzen. Fouten die daarbij ontstaan en herkenbaar zijn als programmeer dan wel typefouten, vormen nooit een aanleiding om een contract dan wel overeenkomst met Koninklijke Harmonie Lentekrans Linne te mogen claimen of te veronderstellen.
                </p>
                <p class="section-text">
                    Koninklijke Harmonie Lentekrans Linne streeft naar een zo actueel mogelijke website. Mocht ondanks deze inspanningen de informatie van of de inhoud op deze website onvolledig en of onjuist zijn, dan kunnen wij daarvoor geen aansprakelijkheid aanvaarden.
                </p>
                <p class="section-text">
                    De informatie en/of producten op deze website worden aangeboden zonder enige vorm van garantie en of aanspraak op juistheid. Wij behouden ons het recht voor om deze materialen te wijzigen, te verwijderen of opnieuw te plaatsen zonder enige voorafgaande medeling. Koninklijke Harmonie Lentekrans Linne aanvaardt geen aansprakelijkheid voor enige informatie staat waarnaar wij via hyperlinks verwijzen.
                </p>

                <h2 class="section-title">Wijzigingen</h2>
                <p class="section-text">
                    Mocht deze disclaimer wijzigen, dan vindt u de meest recente versie van de disclaimer van <a href="https://lentekrans.nl/" class="disclaimer-link">https://lentekrans.nl/</a> op deze pagina.
                </p>
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
.disclaimer-page {
    min-height: 100vh;
    background: var(--background);
    padding: 4rem 2rem;
}

.disclaimer-container {
    max-width: 900px;
    margin: 0 auto;
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
    padding: 3rem;
}

.disclaimer-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 3px solid var(--primary);
    display: inline-block;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin: 1.5rem 0 1rem 0;
    padding-top: 0.5rem;
}

.section-title:first-of-type {
    margin-top: 0;
}

.section-text {
    font-size: 1rem;
    line-height: 1.6;
    color: #4a5568;
    margin-bottom: 1rem;
}

.intro-text {
    font-size: 1.125rem;
    line-height: 1.7;
    color: #2d3748;
    font-weight: 500;
    margin-bottom: 1.5rem;
    background: #f7fafc;
    padding: 1.5rem;
    border-radius: 0.75rem;
    border-left: 4px solid var(--primary);
}

.disclaimer-link {
    color: var(--primary);
    text-decoration: none;
    border-bottom: 1px solid transparent;
    transition: all 0.2s ease;
}

.disclaimer-link:hover {
    color: var(--primary-hover);
    border-bottom-color: var(--primary);
}

.footer-note {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
    text-align: center;
}

.footer-note p {
    font-size: 0.875rem;
    color: #a0aec0;
    font-style: italic;
}

/* Responsive */
@media (max-width: 768px) {
    .disclaimer-page {
        padding: 2rem 1rem;
    }

    .disclaimer-container {
        padding: 1.5rem;
    }

    .disclaimer-title {
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        margin: 1.25rem 0 0.75rem 0;
    }

    .intro-text {
        font-size: 1rem;
        padding: 1rem;
    }

    .section-text {
        font-size: 0.875rem;
    }
}

@media (max-width: 480px) {
    .disclaimer-container {
        padding: 1rem;
    }

    .disclaimer-title {
        font-size: 1.5rem;
    }

    .section-title {
        font-size: 1.125rem;
    }
}
</style>
