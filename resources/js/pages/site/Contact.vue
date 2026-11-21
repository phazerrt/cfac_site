<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ChevronDown, Mail, MapPin, Phone } from '@lucide/vue';
import { computed } from 'vue';
import EnquiryForm from '@/components/site/EnquiryForm.vue';
import PageHero from '@/components/site/PageHero.vue';
import SectionHeading from '@/components/site/SectionHeading.vue';
import SiteSeo from '@/components/site/SiteSeo.vue';
import SocialIcon from '@/components/site/SocialIcon.vue';
import WhatsAppIcon from '@/components/site/WhatsAppIcon.vue';
import { useSite } from '@/composables/useSite';
import type { PackageCategory, SocialKey } from '@/types/site';

defineProps<{
    events: { slug: string; title: string }[];
    packages: {
        slug: string;
        category: PackageCategory;
        label: string;
        price: number | null;
    }[];
}>();

const { business, t, whatsappUrl, telUrl, mailUrl } = useSite();

// ?package=slug pre-selects a package in the enquiry form.
const page = usePage();
const initialPackage = computed(() =>
    new URL(page.url, 'http://x').searchParams.get('package'),
);

const socials: SocialKey[] = ['instagram', 'facebook', 'tiktok'];
const faqs = [1, 2, 3, 4, 5];
</script>

<template>
    <SiteSeo
        :title="t('contact.seo.title')"
        :description="
            t('contact.seo.description', {
                phone: business.whatsappDisplay,
                email: business.email,
            })
        "
    />

    <PageHero
        :eyebrow="t('contact.hero.eyebrow')"
        :title="t('contact.hero.title')"
        :lead="t('contact.hero.lead')"
        image="/media/gallery/garden-fairy.webp"
    />

    <!-- Ways to reach us -->
    <section class="relative z-10 -mt-10 px-5 sm:px-8">
        <div class="mx-auto grid max-w-7xl gap-4 md:grid-cols-3">
            <a
                v-reveal
                :href="whatsappUrl()"
                target="_blank"
                rel="noopener"
                class="group rounded-3xl bg-brand-500 p-7 text-white shadow-[0_24px_48px_-20px_rgb(250_102_52/0.7)] transition-transform duration-300 hover:-translate-y-1"
            >
                <WhatsAppIcon class="size-8" />
                <p class="mt-6 text-sm font-semibold text-white/80">
                    {{ t('contact.whatsapp') }} ·
                    {{ t('contact.whatsapp_hint') }}
                </p>
                <p class="mt-1 font-display text-2xl font-bold">
                    {{ business.whatsappDisplay }}
                </p>
            </a>
            <a
                v-reveal="80"
                :href="telUrl"
                class="group rounded-3xl bg-ink-950 p-7 text-white transition-transform duration-300 hover:-translate-y-1"
            >
                <Phone class="size-8 text-brand-400" />
                <p class="mt-6 text-sm font-semibold text-white/60">
                    {{ t('contact.phone') }} · {{ t('contact.phone_hint') }}
                </p>
                <p class="mt-1 font-display text-2xl font-bold">
                    {{ business.phoneDisplay }}
                </p>
            </a>
            <a
                v-reveal="160"
                :href="mailUrl"
                class="group rounded-3xl bg-white p-7 ring-1 ring-ink-950/8 transition-transform duration-300 hover:-translate-y-1"
            >
                <Mail class="size-8 text-brand-500" />
                <p class="mt-6 text-sm font-semibold text-ink-500">
                    {{ t('contact.email') }} · {{ t('contact.email_hint') }}
                </p>
                <p
                    class="mt-1 font-display text-lg font-bold break-all text-ink-950 sm:text-xl"
                >
                    {{ business.email }}
                </p>
            </a>
        </div>
    </section>

    <!-- Enquiry form -->
    <section class="bg-white py-24 sm:py-28">
        <div
            class="mx-auto grid max-w-7xl gap-12 px-5 sm:px-8 lg:grid-cols-12 lg:gap-16"
        >
            <div class="lg:col-span-5">
                <SectionHeading
                    :eyebrow="t('enquiry.eyebrow')"
                    :title="t('enquiry.title')"
                    :lead="t('enquiry.lead')"
                />

                <div v-reveal class="mt-10 space-y-6">
                    <p class="flex items-center gap-3 text-ink-700">
                        <MapPin class="size-5 text-brand-500" />
                        {{ t('contact.area', { area: business.area }) }}
                    </p>
                    <div>
                        <p
                            class="text-xs font-semibold tracking-[0.24em] text-ink-400 uppercase"
                        >
                            {{ t('contact.follow') }}
                        </p>
                        <ul class="mt-4 space-y-3">
                            <li v-for="key in socials" :key="key">
                                <a
                                    :href="business.social[key].url"
                                    target="_blank"
                                    rel="noopener"
                                    class="group inline-flex items-center gap-3 font-medium text-ink-800 transition-colors hover:text-brand-600"
                                >
                                    <span
                                        class="grid size-10 place-items-center rounded-full bg-ink-950 text-white transition-colors group-hover:bg-brand-500"
                                    >
                                        <SocialIcon
                                            :name="key"
                                            class="size-4"
                                        />
                                    </span>
                                    {{ business.social[key].handle }}
                                    <span class="text-sm text-ink-400">{{
                                        t(`social.${key}`)
                                    }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div v-reveal="120" class="lg:col-span-7">
                <EnquiryForm
                    :events="events"
                    :packages="packages"
                    :initial-package="initialPackage"
                />
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="bg-cream py-24 sm:py-28">
        <div class="mx-auto max-w-3xl px-5 sm:px-8">
            <SectionHeading
                :eyebrow="t('faq.eyebrow')"
                :title="t('faq.title')"
                align="center"
            />
            <div class="mt-12 space-y-3">
                <details
                    v-for="n in faqs"
                    :key="n"
                    v-reveal="n * 50"
                    class="group rounded-2xl bg-white ring-1 ring-ink-950/5 open:shadow-sm"
                >
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-6 p-6 font-display text-lg font-semibold [&::-webkit-details-marker]:hidden"
                    >
                        {{ t(`faq.${n}.q`) }}
                        <ChevronDown
                            class="size-5 shrink-0 text-brand-500 transition-transform duration-300 group-open:rotate-180"
                        />
                    </summary>
                    <p class="px-6 pb-6 leading-relaxed text-ink-600">
                        {{ t(`faq.${n}.a`) }}
                    </p>
                </details>
            </div>
        </div>
    </section>
</template>
