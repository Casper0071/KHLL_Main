export default {
    mounted(el, binding) {
        // Options met defaults
        const options = {
            threshold: binding.modifiers?.early ? 0.1 : 0.2,
            rootMargin: binding.modifiers?.late ? '0px 0px 100px 0px' : '0px 0px -50px 0px',
            once: !binding.modifiers?.always
        }

        // Als immediate modifier is gebruikt, voeg direct de class toe
        if (binding.modifiers?.immediate) {
            if (binding.value === 'animate') {
                el.classList.add('is-visible')
            } else if (typeof binding.value === 'function') {
                const rect = el.getBoundingClientRect()
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0
                if (isVisible) {
                    binding.value({ isIntersecting: true, target: el })
                }
            }
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (binding.value === 'animate') {
                        el.classList.add('is-visible')
                    } else if (typeof binding.value === 'function') {
                        binding.value(entry)
                    } else {
                        el.classList.add('is-visible')
                    }

                    if (options.once) {
                        observer.unobserve(el)
                    }
                } else if (!options.once) {
                    if (binding.value === 'animate') {
                        el.classList.remove('is-visible')
                    }
                }
            })
        }, {
            threshold: options.threshold,
            rootMargin: options.rootMargin
        })

        observer.observe(el)
        el._observer = observer
    },

    unmounted(el) {
        if (el._observer) {
            el._observer.disconnect()
            delete el._observer
        }
    }
}
