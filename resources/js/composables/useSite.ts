import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { Locale, Package, PageKey, SiteShared } from '@/types/site';

const rmFormatter = new Intl.NumberFormat('en-MY', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
});

/**
 * Locale, UI strings and business details shared by every public page.
 */
export function useSite() {
    const page = usePage();

    const locale = computed(() => page.props.locale as Locale);
    const site = computed(() => page.props.site as SiteShared);
    const business = computed(() => site.value.business);

    /** Translate a UI string from lang/{locale}.json, replacing :placeholders. */
    function t(key: string, replace: Record<string, string | number> = {}) {
        let value =
            (page.props.translations as Record<string, string>)[key] ?? key;

        for (const [name, replacement] of Object.entries(replace)) {
            value = value.replaceAll(`:${name}`, String(replacement));
        }

        return value;
    }

    function href(key: PageKey) {
        return site.value.nav.find((item) => item.key === key)?.href ?? '/';
    }

    function whatsappUrl(message?: string) {
        const text = encodeURIComponent(message ?? t('whatsapp.message'));

        return `https://wa.me/${business.value.whatsapp}?text=${text}`;
    }

    /** Pre-filled WhatsApp enquiry for one package. */
    function packageWhatsappUrl(pkg: Package) {
        const label = [
            pkg.code ? t('package.code', { code: pkg.code }) : null,
            pkg.name,
            pkg.size,
        ]
            .filter(Boolean)
            .join(' · ');

        return whatsappUrl(
            t('package.whatsapp_message', {
                category: t(`category.${pkg.category}`),
                package: label,
                price: pkg.price ? `RM${rm(pkg.price)}` : t('package.quote'),
            }),
        );
    }

    const telUrl = computed(() => `tel:${business.value.phone}`);
    const mailUrl = computed(() => `mailto:${business.value.email}`);

    /** 3500 -> "3,500", 2.5 -> "2.50" */
    function rm(amount: number) {
        return Number.isInteger(amount)
            ? rmFormatter.format(amount)
            : amount.toFixed(2);
    }

    return {
        locale,
        site,
        business,
        t,
        href,
        whatsappUrl,
        packageWhatsappUrl,
        telUrl,
        mailUrl,
        rm,
    };
}
