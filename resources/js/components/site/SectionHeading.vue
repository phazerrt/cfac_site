<script setup lang="ts">
withDefaults(
    defineProps<{
        eyebrow?: string;
        title: string;
        lead?: string;
        align?: 'left' | 'center';
        dark?: boolean;
        as?: 'h1' | 'h2';
    }>(),
    { align: 'left', dark: false, as: 'h2' },
);
</script>

<template>
    <div
        :class="['max-w-3xl', align === 'center' ? 'mx-auto text-center' : '']"
    >
        <p
            v-if="eyebrow"
            v-reveal
            :class="[
                'mb-5 inline-flex items-center gap-3 text-xs font-semibold tracking-[0.24em] uppercase',
                dark ? 'text-brand-400' : 'text-brand-600',
            ]"
        >
            <span
                :class="[
                    'h-px w-8',
                    dark ? 'bg-brand-400/60' : 'bg-brand-600/50',
                ]"
            />
            {{ eyebrow }}
        </p>
        <component
            :is="as"
            v-reveal="80"
            :class="[
                'font-display-tight text-[2.2rem] text-balance sm:text-5xl lg:text-6xl',
                dark ? 'text-white' : 'text-ink-950',
            ]"
        >
            {{ title }}
        </component>
        <p
            v-if="lead"
            v-reveal="160"
            :class="[
                'mt-6 text-lg leading-relaxed text-pretty',
                dark ? 'text-white/65' : 'text-ink-600',
                align === 'center' ? 'mx-auto max-w-2xl' : 'max-w-2xl',
            ]"
        >
            {{ lead }}
        </p>
        <slot />
    </div>
</template>
