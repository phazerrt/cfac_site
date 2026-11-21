import type { Directive } from 'vue';

/**
 * v-reveal: fades and lifts an element in the first time it scrolls into
 * view. Optional value = delay in ms, for staggering siblings.
 *
 * The hidden state lives in CSS under `.js [data-reveal]`, so server-rendered
 * HTML stays visible without JS and for reduced-motion users.
 */
let observer: IntersectionObserver | null = null;

function getObserver(): IntersectionObserver {
    observer ??= new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer?.unobserve(entry.target);
                }
            }
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.12 },
    );

    return observer;
}

export const vReveal: Directive<HTMLElement, number | undefined> = {
    getSSRProps(binding) {
        return {
            'data-reveal': '',
            ...(binding.value
                ? { style: { '--reveal-delay': `${binding.value}ms` } }
                : {}),
        };
    },
    mounted(el, binding) {
        el.setAttribute('data-reveal', '');

        if (binding.value) {
            el.style.setProperty('--reveal-delay', `${binding.value}ms`);
        }

        if (!('IntersectionObserver' in window)) {
            el.classList.add('is-revealed');

            return;
        }

        getObserver().observe(el);
    },
    unmounted(el) {
        observer?.unobserve(el);
    },
};
