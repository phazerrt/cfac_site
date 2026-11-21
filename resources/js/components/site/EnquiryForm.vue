<script setup lang="ts">
import { Mail, Send } from '@lucide/vue';
import { computed, reactive } from 'vue';
import { useSite } from '@/composables/useSite';
import type { PackageCategory } from '@/types/site';

type PackageOption = {
    slug: string;
    category: PackageCategory;
    label: string;
    price: number | null;
};

const props = defineProps<{
    events: { slug: string; title: string }[];
    packages: PackageOption[];
    initialPackage?: string | null;
}>();

const { t, rm, business, whatsappUrl } = useSite();

const form = reactive({
    name: '',
    event: '',
    date: '',
    venue: '',
    guests: '',
    package: props.packages.some((p) => p.slug === props.initialPackage)
        ? (props.initialPackage as string)
        : '',
    message: '',
});

const groups = computed(() =>
    (['arabian', 'block', 'av'] as PackageCategory[]).map((category) => ({
        category,
        options: props.packages.filter((p) => p.category === category),
    })),
);

function optionLabel(option: PackageOption) {
    return option.price
        ? `${option.label} · RM${rm(option.price)}`
        : option.label;
}

/** The enquiry as plain text, one line per filled-in field. */
const message = computed(() => {
    const chosen = props.packages.find((p) => p.slug === form.package);
    const event = props.events.find((e) => e.slug === form.event);

    const details = [
        form.name && `${t('enquiry.name')}: ${form.name}`,
        event && `${t('enquiry.event')}: ${event.title}`,
        form.event === 'other' &&
            `${t('enquiry.event')}: ${t('enquiry.other')}`,
        form.date && `${t('enquiry.date')}: ${form.date}`,
        form.venue && `${t('enquiry.venue')}: ${form.venue}`,
        form.guests && `${t('enquiry.guests')}: ${form.guests}`,
        chosen &&
            `${t('enquiry.package')}: ${t(`category.${chosen.category}`)} – ${optionLabel(chosen)}`,
    ].filter((line): line is string => Boolean(line));

    const message = form.message.trim();

    return [
        t('enquiry.intro'),
        ...(details.length ? ['', ...details] : []),
        ...(message ? ['', message] : []),
    ].join('\n');
});

const mailHref = computed(
    () =>
        `mailto:${business.value.email}?subject=${encodeURIComponent(t('enquiry.subject'))}&body=${encodeURIComponent(message.value)}`,
);

function send() {
    window.open(whatsappUrl(message.value), '_blank', 'noopener');
}

const field =
    'mt-2 block w-full rounded-xl border-0 bg-white px-4 py-3 text-ink-950 ring-1 ring-ink-950/10 transition-shadow placeholder:text-ink-400 focus:ring-2 focus:ring-brand-500 focus:outline-none';
const label = 'text-sm font-semibold text-ink-800';
</script>

<template>
    <form
        class="grid gap-5 rounded-[2rem] bg-cream p-6 ring-1 ring-ink-950/5 sm:grid-cols-2 sm:p-10"
        @submit.prevent="send"
    >
        <label class="sm:col-span-2">
            <span :class="label">{{ t('enquiry.name') }}</span>
            <input
                v-model="form.name"
                type="text"
                autocomplete="name"
                :class="field"
                :placeholder="t('enquiry.name_placeholder')"
            />
        </label>

        <label>
            <span :class="label">{{ t('enquiry.event') }}</span>
            <select v-model="form.event" :class="field">
                <option value="">{{ t('enquiry.choose') }}</option>
                <option v-for="e in events" :key="e.slug" :value="e.slug">
                    {{ e.title }}
                </option>
                <option value="other">{{ t('enquiry.other') }}</option>
            </select>
        </label>

        <label>
            <span :class="label">{{ t('enquiry.date') }}</span>
            <input v-model="form.date" type="date" :class="field" />
        </label>

        <label>
            <span :class="label">{{ t('enquiry.venue') }}</span>
            <input
                v-model="form.venue"
                type="text"
                :class="field"
                :placeholder="t('enquiry.venue_placeholder')"
            />
        </label>

        <label>
            <span :class="label">{{ t('enquiry.guests') }}</span>
            <input
                v-model="form.guests"
                type="number"
                min="1"
                inputmode="numeric"
                :class="field"
                placeholder="80"
            />
        </label>

        <label class="sm:col-span-2">
            <span :class="label">{{ t('enquiry.package') }}</span>
            <select v-model="form.package" :class="field">
                <option value="">{{ t('enquiry.not_sure') }}</option>
                <optgroup
                    v-for="group in groups"
                    :key="group.category"
                    :label="t(`category.${group.category}`)"
                >
                    <option
                        v-for="option in group.options"
                        :key="option.slug"
                        :value="option.slug"
                    >
                        {{ optionLabel(option) }}
                    </option>
                </optgroup>
            </select>
        </label>

        <label class="sm:col-span-2">
            <span :class="label">{{ t('enquiry.message') }}</span>
            <textarea
                v-model="form.message"
                rows="4"
                :class="field"
                :placeholder="t('enquiry.message_placeholder')"
            />
        </label>

        <div
            class="flex flex-col gap-3 sm:col-span-2 sm:flex-row sm:items-center"
        >
            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2.5 rounded-full bg-brand-500 px-7 py-4 font-semibold text-white shadow-[0_12px_32px_-10px_rgb(250_102_52/0.8)] transition-all duration-300 hover:-translate-y-0.5 hover:bg-brand-600"
            >
                <Send class="size-4" />
                {{ t('enquiry.send_whatsapp') }}
            </button>
            <a
                :href="mailHref"
                class="inline-flex items-center justify-center gap-2.5 rounded-full px-6 py-4 font-semibold text-ink-800 ring-1 ring-ink-950/15 transition-colors hover:bg-white"
            >
                <Mail class="size-4" />
                {{ t('enquiry.send_email') }}
            </a>
        </div>
        <p class="text-sm text-ink-500 sm:col-span-2">
            {{ t('enquiry.hint') }}
        </p>
    </form>
</template>
