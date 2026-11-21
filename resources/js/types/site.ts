export type Locale = 'en' | 'ms';

export type PageKey = 'home' | 'tents' | 'equipment' | 'gallery' | 'contact';

export type SocialKey = 'instagram' | 'tiktok' | 'facebook';

export type SiteShared = {
    key: PageKey | null;
    canonical: string | null;
    alternates: Record<
        Locale,
        { href: string; label: string; name: string; hreflang: string }
    >;
    ogLocale: string;
    ogImage: string;
    indexable: boolean;
    nav: { key: PageKey; href: string }[];
    business: {
        name: string;
        tagline: string;
        motto: string;
        phone: string;
        phoneDisplay: string;
        whatsapp: string;
        whatsappDisplay: string;
        email: string;
        area: string;
        social: Record<SocialKey, { handle: string; url: string }>;
    };
};

export type PackageCategory = 'arabian' | 'block' | 'av';

export type Package = {
    slug: string;
    category: PackageCategory;
    finish: 'white' | 'clear' | null;
    tier: 'basic' | 'deco' | 'premium';
    code: string | null;
    name: string;
    size: string | null;
    features: string[];
    price: number | null;
    note: string | null;
    image: string | null;
    gallery: string[];
    featured: boolean;
};

export type AddOn = {
    slug: string;
    name: string;
    arabian: number;
    block: number | null;
};

export type Service = {
    slug: string;
    icon: string;
    image: string | null;
    gallery: string[];
    title: string;
    summary: string;
};

export type GalleryTag = 'tents' | 'dinners' | 'stage' | 'events';

export type GalleryItem = {
    src: string;
    w: number;
    h: number;
    tag: GalleryTag;
    alt: string;
};
