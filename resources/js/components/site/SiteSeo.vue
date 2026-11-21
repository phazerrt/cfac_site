<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useSite } from '@/composables/useSite';

const props = defineProps<{
    title: string;
    description: string;
}>();

const { site, business } = useSite();
</script>

<template>
    <Head :title="props.title">
        <meta
            head-key="description"
            name="description"
            :content="description"
        />
        <link
            v-if="site.canonical"
            head-key="canonical"
            rel="canonical"
            :href="site.canonical"
        />
        <link
            v-for="(alt, code) in site.alternates"
            :key="code"
            :head-key="`alternate-${code}`"
            rel="alternate"
            :hreflang="alt.hreflang"
            :href="alt.href"
        />
        <link
            head-key="alternate-default"
            rel="alternate"
            hreflang="x-default"
            :href="site.alternates.en.href"
        />
        <meta head-key="og:type" property="og:type" content="website" />
        <meta
            head-key="og:site_name"
            property="og:site_name"
            :content="business.name"
        />
        <meta
            head-key="og:title"
            property="og:title"
            :content="`${title} · ${business.name}`"
        />
        <meta
            head-key="og:description"
            property="og:description"
            :content="description"
        />
        <meta
            v-if="site.canonical"
            head-key="og:url"
            property="og:url"
            :content="site.canonical"
        />
        <meta head-key="og:image" property="og:image" :content="site.ogImage" />
        <meta
            head-key="og:locale"
            property="og:locale"
            :content="site.ogLocale"
        />
        <meta
            head-key="twitter:card"
            name="twitter:card"
            content="summary_large_image"
        />
    </Head>
</template>
