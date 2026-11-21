<script setup lang="ts">
import { Info } from '@lucide/vue';
import { computed, nextTick, onMounted, ref } from 'vue';
import AddOnTable from '@/components/site/AddOnTable.vue';
import CtaBand from '@/components/site/CtaBand.vue';
import PackageCard from '@/components/site/PackageCard.vue';
import PageHero from '@/components/site/PageHero.vue';
import PremiumPackage from '@/components/site/PremiumPackage.vue';
import SectionHeading from '@/components/site/SectionHeading.vue';
import SiteSeo from '@/components/site/SiteSeo.vue';
import { useSite } from '@/composables/useSite';
import type { AddOn, Package } from '@/types/site';

type Category = 'arabian' | 'block';
type Finish = 'white' | 'clear';

const props = defineProps<{
    packages: Package[];
    addOns: AddOn[];
}>();

const { t, rm } = useSite();

const categories: Category[] = ['arabian', 'block'];
const finishes: Finish[] = ['white', 'clear'];

const category = ref<Category>('arabian');
const finish = ref<Finish | 'all'>('all');

function select(next: Category) {
    category.value = next;
    history.replaceState(history.state, '', `#${next}`);
}

onMounted(() => {
    const hash = window.location.hash.slice(1);

    if (hash === 'block' || hash === 'arabian') {
        category.value = hash;
        // The section was hidden when the browser looked for the anchor.
        void nextTick(() =>
            document.getElementById(hash)?.scrollIntoView({ block: 'start' }),
        );
    }
});

function packagesFor(cat: Category, fin: Finish, tier: Package['tier']) {
    return props.packages.filter(
        (p) => p.category === cat && p.finish === fin && p.tier === tier,
    );
}

function fromPrice(cat: Category) {
    return Math.min(
        ...props.packages
            .filter((p) => p.category === cat)
            .map((p) => p.price ?? Infinity),
    );
}

const visibleFinishes = computed(() =>
    finish.value === 'all' ? finishes : [finish.value],
);

const notes = [1, 2, 3, 4];
</script>

<template>
    <SiteSeo
        :title="t('tents_page.seo.title')"
        :description="t('tents_page.seo.description')"
    />

    <PageHero
        :eyebrow="t('tents_page.hero.eyebrow')"
        :title="t('tents_page.hero.title')"
        :lead="t('tents_page.hero.lead')"
        image="/media/hero/arabian-clear-deco.webp"
    />

    <!-- Category + finish switcher -->
    <div
        class="sticky top-16 z-30 border-b border-ink-950/8 bg-white/90 backdrop-blur-xl"
    >
        <div
            class="mx-auto flex max-w-7xl flex-col gap-3 px-5 py-3 sm:flex-row sm:items-center sm:justify-between sm:px-8"
        >
            <div
                class="grid grid-cols-2 rounded-full bg-ink-100 p-1"
                role="tablist"
                :aria-label="t('tents_page.choose_tent')"
            >
                <button
                    v-for="cat in categories"
                    :id="`tab-${cat}`"
                    :key="cat"
                    type="button"
                    role="tab"
                    :aria-selected="category === cat"
                    :aria-controls="cat"
                    :class="[
                        'rounded-full px-4 py-2.5 text-sm font-semibold whitespace-nowrap transition-all duration-300 sm:px-6',
                        category === cat
                            ? 'bg-ink-950 text-white shadow'
                            : 'text-ink-600 hover:text-ink-950',
                    ]"
                    @click="select(cat)"
                >
                    {{ t(`category.${cat}`) }}
                    <span
                        class="ml-1 hidden font-normal opacity-60 sm:inline"
                        >{{
                            cat === 'arabian' ? "20' × 20'" : "20' × 40'"
                        }}</span
                    >
                </button>
            </div>

            <div
                class="flex gap-2"
                role="group"
                :aria-label="t('tents_page.choose_finish')"
            >
                <button
                    v-for="option in ['all', ...finishes] as const"
                    :key="option"
                    type="button"
                    :aria-pressed="finish === option"
                    :class="[
                        'rounded-full px-4 py-2 text-sm font-medium ring-1 transition-colors duration-300',
                        finish === option
                            ? 'bg-brand-500 text-white ring-brand-500'
                            : 'text-ink-700 ring-ink-950/10 hover:ring-ink-950/30',
                    ]"
                    @click="finish = option"
                >
                    {{ t(`finish.${option}`) }}
                </button>
            </div>
        </div>
    </div>

    <section
        v-for="cat in categories"
        v-show="category === cat"
        :id="cat"
        :key="cat"
        role="tabpanel"
        :aria-labelledby="`tab-${cat}`"
        class="scroll-mt-40 bg-white pt-16 pb-24 sm:pt-20 sm:pb-32"
    >
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div class="grid gap-8 lg:grid-cols-12 lg:items-end">
                <SectionHeading
                    class="lg:col-span-8"
                    :eyebrow="t(`tents_page.${cat}.eyebrow`)"
                    :title="t(`category.${cat}`)"
                    :lead="t(`tents_page.${cat}.lead`)"
                />
                <p v-reveal class="text-ink-500 lg:col-span-4 lg:text-right">
                    {{ t('package.from') }}
                    <span class="font-display text-4xl font-bold text-ink-950"
                        >RM{{ rm(fromPrice(cat)) }}</span
                    >
                </p>
            </div>

            <div
                v-for="fin in visibleFinishes"
                :key="fin"
                class="mt-16 sm:mt-20"
            >
                <div
                    class="flex items-center gap-4 border-b border-ink-950/10 pb-5"
                >
                    <span
                        :class="[
                            'size-4 rounded-full ring-4',
                            fin === 'white'
                                ? 'bg-white ring-ink-200'
                                : 'bg-sky-100/60 ring-sky-200',
                        ]"
                        aria-hidden="true"
                    />
                    <h3 class="font-display text-2xl font-semibold sm:text-3xl">
                        {{ t(`tents_page.finish_title.${fin}`) }}
                    </h3>
                </div>

                <template
                    v-for="tier in ['basic', 'deco'] as const"
                    :key="tier"
                >
                    <div
                        v-if="packagesFor(cat, fin, tier).length"
                        class="mt-10"
                    >
                        <p
                            class="mb-6 text-xs font-semibold tracking-[0.24em] text-brand-600 uppercase"
                        >
                            {{ t(`tier.${tier}`) }} ·
                            <span
                                class="tracking-normal text-ink-500 normal-case"
                                >{{ t(`tier.${tier}.hint`) }}</span
                            >
                        </p>
                        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                            <PackageCard
                                v-for="(pkg, i) in packagesFor(cat, fin, tier)"
                                :key="pkg.slug"
                                :pkg="pkg"
                                :delay="i * 80"
                            />
                        </div>
                    </div>
                </template>

                <div class="mt-10 space-y-6">
                    <PremiumPackage
                        v-for="pkg in packagesFor(cat, fin, 'premium')"
                        :key="pkg.slug"
                        :pkg="pkg"
                        :flip="fin === 'clear'"
                    />
                </div>
            </div>
        </div>
    </section>

    <!-- Add-ons -->
    <section id="add-ons" class="scroll-mt-24 bg-cream py-24 sm:py-32">
        <div class="mx-auto grid max-w-7xl gap-12 px-5 sm:px-8 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <SectionHeading
                    :eyebrow="t('addons.eyebrow')"
                    :title="t('addons.title')"
                    :lead="t('addons.lead')"
                />

                <div
                    v-reveal
                    class="mt-10 rounded-3xl bg-white p-7 ring-1 ring-ink-950/5"
                >
                    <h3
                        class="flex items-center gap-2 font-display text-lg font-semibold"
                    >
                        <Info class="size-5 text-brand-500" />
                        {{ t('notes.title') }}
                    </h3>
                    <ul class="mt-4 space-y-3 text-[0.95rem] text-ink-600">
                        <li v-for="n in notes" :key="n" class="flex gap-3">
                            <span
                                class="mt-2 size-1.5 shrink-0 rounded-full bg-brand-500"
                            />
                            {{ t(`notes.${n}`) }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="lg:col-span-7">
                <AddOnTable :rows="addOns" />
            </div>
        </div>
    </section>

    <CtaBand image="/media/hero/block-clear-fairy.webp" />
</template>
