<script setup lang="ts">
defineProps<{
    eyebrow: string;
    title: string;
    lead?: string;
    image?: string;
}>();
</script>

<template>
    <section
        class="grain relative isolate overflow-hidden bg-ink-950 text-white"
    >
        <img
            v-if="image"
            :src="image"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 -z-20 size-full animate-fade object-cover opacity-40"
            fetchpriority="high"
        />
        <div
            class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950 via-ink-950/75 to-ink-950/35"
        />
        <div
            class="absolute -top-40 -right-24 -z-10 size-[34rem] rounded-full bg-brand-500/20 blur-[130px]"
        />

        <div
            class="mx-auto flex min-h-[56svh] max-w-7xl flex-col justify-end px-5 pt-36 pb-14 sm:px-8 lg:min-h-[60svh] lg:pb-20"
        >
            <p
                class="mb-5 inline-flex animate-rise items-center gap-3 text-xs font-semibold tracking-[0.24em] text-brand-400 uppercase"
            >
                <span class="h-px w-8 bg-brand-400/60" />
                {{ eyebrow }}
            </p>
            <h1
                class="max-w-4xl animate-rise font-display-tight text-[2.6rem] text-balance [animation-delay:100ms] sm:text-6xl lg:text-7xl"
            >
                {{ title }}
            </h1>
            <p
                v-if="lead"
                class="mt-6 max-w-2xl animate-rise text-lg leading-relaxed text-pretty text-white/70 [animation-delay:200ms]"
            >
                {{ lead }}
            </p>
            <slot />
        </div>
    </section>
</template>
