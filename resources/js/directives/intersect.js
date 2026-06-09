export default {
    mounted(el, binding) {
        // Opties voor de observer
        const options = {
            threshold: binding.modifiers?.early ? 0.1 : 0.2,
            rootMargin: binding.modifiers?.late ? '0px 0px 100px 0px' : '0px 0px -50px 0px',
            once: !binding.modifiers?.always
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Voeg class toe wanneer zichtbaar
                    if (binding.value === 'animate') {
                        el.classList.add('is-visible')
                    } else if (typeof binding.value === 'function') {
                        binding.value(entry)
                    } else {
                        el.classList.add('is-visible')
                    }

                    // Stop observeren na eerste keer (tenzij always modifier)
                    if (options.once) {
                        observer.unobserve(el)
                    }
                } else if (!options.once) {
                    // Verwijder class wanneer niet zichtbaar (als always)
                    el.classList.remove('is-visible')
                }
            })
        }, {
            threshold: options.threshold,
            rootMargin: options.rootMargin
        })

        observer.observe(el)

        // Sla observer op voor cleanup
        el._observer = observer
    },

    unmounted(el) {
        if (el._observer) {
            el._observer.disconnect()
            delete el._observer
        }
    }
}
