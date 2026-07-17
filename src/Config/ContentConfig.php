<?php

namespace NovaTheme\Config;

/**
 * Single source of truth for every piece of copy, link and image used by the
 * NovaTheme header, mega menu, homepage sections and footer.
 *
 * WHY a plain PHP class instead of the PlentyONE plugin config UI:
 * the backend plugin configuration screen only supports flat string/number/
 * boolean/select fields - it has no support for repeatable groups or nested
 * arrays (mega menu groups, hero slides, footer columns, ...). Modelling
 * that kind of structured, repeatable content is only possible in code or in
 * CMS/category data. This class is therefore the supported middle ground:
 * every value below is safe to edit without touching any Twig/JS/SCSS, and
 * every link accepts either a real PlentyONE category id ("categoryId") or a
 * static fallback URL ("url"). See Header/Partials/Macros for how the
 * category id is resolved to a language- and shop-aware URL at render time.
 */
class ContentConfig
{
    /**
     * Primary desktop/mobile navigation. "type" is one of:
     *  - "megamenu" -> renders the wide Products panel from megaMenu()
     *  - "dropdown" -> renders a simple multi-item dropdown from "children"
     *  - "link"     -> plain link, no flyout
     */
    public static function navigation(): array
    {
        return [
            [
                'key' => 'about',
                'label' => 'About Us',
                'type' => 'dropdown',
                'url' => '#',
                'children' => [
                    ['label' => 'Overview', 'url' => '#'],
                    ['label' => 'History', 'url' => '#'],
                    ['label' => 'Factory Tour', 'url' => '#'],
                    ['label' => 'Quality Control', 'url' => '#'],
                    ['label' => 'Company Culture', 'url' => '#'],
                ],
            ],
            [
                'key' => 'products',
                'label' => 'Products',
                'type' => 'megamenu',
                'url' => '#',
            ],
            [
                'key' => 'support',
                'label' => 'Support',
                'type' => 'dropdown',
                'url' => '#',
                'children' => [
                    ['label' => 'Catalogs', 'url' => '#'],
                    ['label' => 'Brochures', 'url' => '#'],
                    ['label' => 'Certifications', 'url' => '#'],
                    ['label' => 'Video Guides', 'url' => '#'],
                    ['label' => "Buyer's Guide", 'url' => '#'],
                    ['label' => 'Marketing Support', 'url' => '#'],
                ],
            ],
            [
                'key' => 'rnd',
                'label' => 'R&D',
                'type' => 'link',
                'url' => '#',
            ],
            [
                'key' => 'news',
                'label' => 'News',
                'type' => 'link',
                'url' => '#',
            ],
            [
                'key' => 'contact',
                'label' => 'Contact Us',
                'type' => 'link',
                'url' => '#',
            ],
        ];
    }

    /**
     * Wide "Products" mega menu. Each group is one column family; each
     * category heading may list an optional "categoryId" per link to point
     * at a real PlentyONE category instead of the placeholder "#".
     */
    public static function megaMenu(): array
    {
        return [
            'groups' => [
                [
                    'key' => 'office',
                    'title' => 'Office Solutions',
                    'subtitle' => 'Ergonomic mounting for the modern workspace',
                    'image' => 'megamenu/group-office-solutions.svg',
                    'imageAlt' => 'Placeholder image for office solutions product family',
                    'highlightLink' => ['label' => 'Shop Office Solutions', 'url' => '#', 'categoryId' => null],
                    'categories' => [
                        [
                            'heading' => 'Monitor Arms',
                            'links' => [
                                ['label' => 'Single Monitor Arms', 'url' => '#', 'categoryId' => null],
                                ['label' => 'Dual Monitor Arms', 'url' => '#', 'categoryId' => null],
                                ['label' => 'Gas Spring Arms', 'url' => '#', 'categoryId' => null, 'isNew' => true],
                            ],
                        ],
                        [
                            'heading' => 'Desks & Drawers',
                            'links' => [
                                ['label' => 'Under-Desk Drawers', 'url' => '#', 'categoryId' => null],
                                ['label' => 'Sit-Stand Desks', 'url' => '#', 'categoryId' => null],
                                ['label' => 'Cable Management', 'url' => '#', 'categoryId' => null],
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'home',
                    'title' => 'Home Solutions',
                    'subtitle' => 'TV and display mounting for living spaces',
                    'image' => 'megamenu/group-home-solutions.svg',
                    'imageAlt' => 'Placeholder image for home solutions product family',
                    'highlightLink' => ['label' => 'Shop Home Solutions', 'url' => '#', 'categoryId' => null],
                    'categories' => [
                        [
                            'heading' => 'TV Mounts',
                            'links' => [
                                ['label' => 'Fixed TV Mounts', 'url' => '#', 'categoryId' => null],
                                ['label' => 'Full-Motion TV Mounts', 'url' => '#', 'categoryId' => null],
                                ['label' => 'TV Carts & Stands', 'url' => '#', 'categoryId' => null],
                            ],
                        ],
                        [
                            'heading' => 'Speaker & Media',
                            'links' => [
                                ['label' => 'Speaker Mounts', 'url' => '#', 'categoryId' => null],
                                ['label' => 'Media Shelving', 'url' => '#', 'categoryId' => null],
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'professional',
                    'title' => 'Professional Solutions',
                    'subtitle' => 'A/V and medical carts for demanding environments',
                    'image' => 'megamenu/group-professional-solutions.svg',
                    'imageAlt' => 'Placeholder image for professional solutions product family',
                    'highlightLink' => ['label' => 'Shop Professional Solutions', 'url' => '#', 'categoryId' => null],
                    'categories' => [
                        [
                            'heading' => 'Medical Carts',
                            'links' => [
                                ['label' => 'Height-Adjustable Carts', 'url' => '#', 'categoryId' => null, 'isNew' => true],
                                ['label' => 'Cart Accessories', 'url' => '#', 'categoryId' => null],
                            ],
                        ],
                        [
                            'heading' => 'A/V Mounting',
                            'links' => [
                                ['label' => 'Projector Mounts', 'url' => '#', 'categoryId' => null],
                                ['label' => 'Video Wall Mounts', 'url' => '#', 'categoryId' => null],
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'gaming',
                    'title' => 'Gaming Solutions',
                    'subtitle' => 'Cockpits and rigs built for long sessions',
                    'image' => 'megamenu/group-gaming-solutions.svg',
                    'imageAlt' => 'Placeholder image for gaming solutions product family',
                    'highlightLink' => ['label' => 'Shop Gaming Solutions', 'url' => '#', 'categoryId' => null],
                    'categories' => [
                        [
                            'heading' => 'Cockpits & Rigs',
                            'links' => [
                                ['label' => 'Flight Sim Cockpits', 'url' => '#', 'categoryId' => null],
                                ['label' => 'Racing Rigs', 'url' => '#', 'categoryId' => null],
                            ],
                        ],
                        [
                            'heading' => 'Gaming Desks',
                            'links' => [
                                ['label' => 'Gaming Desks', 'url' => '#', 'categoryId' => null],
                                ['label' => 'Gaming Chairs', 'url' => '#', 'categoryId' => null],
                            ],
                        ],
                    ],
                ],
                [
                    'key' => 'new',
                    'title' => 'New Categories',
                    'subtitle' => 'Recently added to the range',
                    'image' => 'megamenu/group-new-categories.svg',
                    'imageAlt' => 'Placeholder image for newly added product categories',
                    'highlightLink' => null,
                    'categories' => [
                        [
                            'heading' => 'Trending',
                            'links' => [
                                ['label' => 'New Arrivals', 'url' => '#', 'categoryId' => null, 'isNew' => true],
                                ['label' => 'Best Sellers', 'url' => '#', 'categoryId' => null],
                            ],
                        ],
                    ],
                ],
            ],
            'quickLinks' => [
                ['label' => 'Compare Products', 'url' => '#'],
                ['label' => 'Marketing Support', 'url' => '#'],
                ['label' => 'Find a Distributor', 'url' => '#'],
            ],
        ];
    }

    /**
     * Full-width hero slider. First slide's imageDesktop is expected to be
     * an eager-loaded, LCP-optimised asset (see sections/Hero.twig).
     */
    public static function heroSlides(): array
    {
        return [
            [
                'heading' => 'Modern Stylish Under-Desk Drawers',
                'subheading' => 'Placeholder copy: introduce the DA-Series drawer system here.',
                'imageDesktop' => 'hero/hero-monitor-arms-desktop.svg',
                'imageMobile' => 'hero/hero-monitor-arms-mobile.svg',
                'imageAlt' => 'Placeholder hero image for under-desk drawer series',
                'primaryLinkLabel' => 'Explore the Series',
                'primaryLinkUrl' => '#',
                'categoryId' => null,
                'slideIsLink' => true,
            ],
            [
                'heading' => 'Refined Space-Efficient Monitor Arms',
                'subheading' => 'Placeholder copy: highlight the gas-spring monitor arm range here.',
                'imageDesktop' => 'hero/hero-gas-spring-arms-desktop.svg',
                'imageMobile' => 'hero/hero-gas-spring-arms-mobile.svg',
                'imageAlt' => 'Placeholder hero image for gas spring monitor arm series',
                'primaryLinkLabel' => 'View Monitor Arms',
                'primaryLinkUrl' => '#',
                'categoryId' => null,
                'slideIsLink' => true,
            ],
            [
                'heading' => 'Premium Minimalist TV Carts',
                'subheading' => 'Placeholder copy: describe the flagship TV cart collection here.',
                'imageDesktop' => 'hero/hero-tv-carts-desktop.svg',
                'imageMobile' => 'hero/hero-tv-carts-mobile.svg',
                'imageAlt' => 'Placeholder hero image for TV cart series',
                'primaryLinkLabel' => 'Discover TV Carts',
                'primaryLinkUrl' => '#',
                'categoryId' => null,
                'slideIsLink' => true,
            ],
            [
                'heading' => 'Electric Height-Adjustable Medical Carts',
                'subheading' => 'Placeholder copy: outline the medical cart line and certifications here.',
                'imageDesktop' => 'hero/hero-medical-carts-desktop.svg',
                'imageMobile' => 'hero/hero-medical-carts-mobile.svg',
                'imageAlt' => 'Placeholder hero image for medical cart series',
                'primaryLinkLabel' => 'See Medical Carts',
                'primaryLinkUrl' => '#',
                'categoryId' => null,
                'slideIsLink' => true,
            ],
        ];
    }

    /** Two large promotional tiles under the hero. */
    public static function promoCards(): array
    {
        return [
            [
                'label' => 'What\'s New',
                'heading' => 'New Arrivals',
                'imageDesktop' => 'promo/promo-new-arrivals-desktop.svg',
                'imageMobile' => 'promo/promo-new-arrivals-mobile.svg',
                'imageAlt' => 'Placeholder image showcasing new arrival products',
                'url' => '#',
                'categoryId' => null,
                'align' => 'left',
            ],
            [
                'label' => 'For Partners',
                'heading' => 'Marketing Support',
                'imageDesktop' => 'promo/promo-marketing-support-desktop.svg',
                'imageMobile' => 'promo/promo-marketing-support-mobile.svg',
                'imageAlt' => 'Placeholder image representing marketing support resources',
                'url' => '#',
                'categoryId' => null,
                'align' => 'left',
            ],
        ];
    }

    /** Full-width image-led company introduction section. */
    public static function companyIntro(): array
    {
        return [
            'heading' => 'One-Stop Mounting Solutions',
            'description' => 'Placeholder copy: summarise the company\'s office, home and professional A/V mounting offering, manufacturing capability and design philosophy here.',
            'image' => 'intro/company-introduction.svg',
            'imageAlt' => 'Placeholder image representing the company introduction section',
            'buttonLabel' => 'Learn More',
            'buttonUrl' => '#',
            'categoryId' => null,
        ];
    }

    /**
     * "Insights & Guides" article cards. plentyMarkets/Ceres has no built-in
     * blog module, so each entry either points at a real Content-type
     * category (set "categoryId") or stays a static placeholder link.
     */
    public static function insights(): array
    {
        return [
            [
                'image' => 'insights/article-office-chair-guide.svg',
                'imageAlt' => 'Placeholder thumbnail for the office chair buying guide article',
                'category' => 'Buyer\'s Guide',
                'title' => 'How to Choose the Right Office Chair',
                'date' => '2026-06-02',
                'url' => '#',
                'categoryId' => null,
            ],
            [
                'image' => 'insights/article-bike-rack.svg',
                'imageAlt' => 'Placeholder thumbnail for the indoor bike rack article',
                'category' => 'Home Solutions',
                'title' => 'Space-Saving Indoor Bike Racks',
                'date' => '2026-05-18',
                'url' => '#',
                'categoryId' => null,
            ],
            [
                'image' => 'insights/article-gaming-cockpit.svg',
                'imageAlt' => 'Placeholder thumbnail for the gaming cockpit setup article',
                'category' => 'Gaming Solutions',
                'title' => 'Building the Ultimate Flight Sim Cockpit',
                'date' => '2026-04-27',
                'url' => '#',
                'categoryId' => null,
            ],
            [
                'image' => 'insights/article-trade-show.svg',
                'imageAlt' => 'Placeholder thumbnail for the trade show recap article',
                'category' => 'News',
                'title' => 'Highlights From This Year\'s Trade Show',
                'date' => '2026-03-11',
                'url' => '#',
                'categoryId' => null,
            ],
        ];
    }

    /** Dark / image-backed contact and trust section. */
    public static function contact(): array
    {
        return [
            'heading' => 'Let\'s Build Something Together',
            'subheading' => 'Placeholder copy: company/value proposition heading goes here.',
            'description' => 'Placeholder copy: describe ODM/OEM capabilities, manufacturing scale and marketing support (packaging, video, e-commerce assets) here.',
            'backgroundImage' => 'contact/contact-background.svg',
            'backgroundImageAlt' => 'Placeholder background image for the contact section',
            'primaryButtonLabel' => 'Contact Us',
            'secondaryLinkLabel' => 'View All Locations',
            'secondaryLinkUrl' => '#',
            'formActionUrl' => '#',
            'social' => self::socialLinks(),
        ];
    }

    /** Shared social link list (used in contact section + footer). */
    public static function socialLinks(): array
    {
        return [
            ['label' => 'Facebook', 'icon' => 'facebook', 'url' => '#'],
            ['label' => 'Twitter / X', 'icon' => 'twitter', 'url' => '#'],
            ['label' => 'LinkedIn', 'icon' => 'linkedin', 'url' => '#'],
            ['label' => 'YouTube', 'icon' => 'youtube', 'url' => '#'],
            ['label' => 'Instagram', 'icon' => 'instagram', 'url' => '#'],
        ];
    }

    /** Footer columns, group branding row and legal row. */
    public static function footer(): array
    {
        return [
            'groupLabel' => 'Part of the Placeholder Group',
            'groupLogos' => [
                ['name' => 'Group Brand One', 'image' => 'footer/group-logo-1.svg', 'url' => '#'],
                ['name' => 'Group Brand Two', 'image' => 'footer/group-logo-2.svg', 'url' => '#'],
                ['name' => 'Group Brand Three', 'image' => 'footer/group-logo-3.svg', 'url' => '#'],
                ['name' => 'Group Brand Four', 'image' => 'footer/group-logo-4.svg', 'url' => '#'],
            ],
            'columns' => [
                [
                    'title' => 'About Us',
                    'links' => [
                        ['label' => 'Overview', 'url' => '#'],
                        ['label' => 'Factory Tour', 'url' => '#'],
                        ['label' => 'Quality Control', 'url' => '#'],
                        ['label' => 'Company Culture', 'url' => '#'],
                    ],
                ],
                [
                    'title' => 'Products',
                    'links' => [
                        ['label' => 'Office Solutions', 'url' => '#', 'categoryId' => null],
                        ['label' => 'Home Solutions', 'url' => '#', 'categoryId' => null],
                        ['label' => 'Professional Solutions', 'url' => '#', 'categoryId' => null],
                        ['label' => 'Gaming Solutions', 'url' => '#', 'categoryId' => null],
                        ['label' => 'New Categories', 'url' => '#', 'categoryId' => null],
                    ],
                ],
                [
                    'title' => 'Support',
                    'links' => [
                        ['label' => 'Catalogs', 'url' => '#'],
                        ['label' => 'Certifications', 'url' => '#'],
                        ['label' => "Buyer's Guide", 'url' => '#'],
                        ['label' => 'Marketing Support', 'url' => '#'],
                    ],
                ],
                [
                    'title' => 'News',
                    'links' => [
                        ['label' => 'Company Blog', 'url' => '#'],
                        ['label' => 'Trade Show Calendar', 'url' => '#'],
                    ],
                ],
            ],
            'social' => self::socialLinks(),
            'contactUrl' => '#',
            'sitemapUrl' => '#',
        ];
    }

    /** Fixed vertical floating action bar. */
    public static function floatingActions(): array
    {
        return [
            [
                'key' => 'inquiry',
                'icon' => 'clipboard-list',
                'label' => 'Inquiry',
                'tooltip' => 'View your inquiry list',
                'action' => 'inquiry',
                'url' => '#',
                'showCount' => true,
                'mobileVisible' => true,
            ],
            [
                'key' => 'compare',
                'icon' => 'compare',
                'label' => 'Compare',
                'tooltip' => 'Compare selected products',
                'action' => 'compare',
                'url' => '#',
                'showCount' => true,
                'mobileVisible' => false,
            ],
            [
                'key' => 'contact',
                'icon' => 'message',
                'label' => 'Contact Us',
                'tooltip' => 'Open the contact form',
                'action' => 'modal',
                'url' => '#contact-modal',
                'showCount' => false,
                'mobileVisible' => true,
            ],
        ];
    }

    /** Contact modal field definitions (rendered in partials/ContactModal.twig). */
    public static function contactModalFields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'autocomplete' => 'name'],
            ['name' => 'region', 'label' => 'Country / Region', 'type' => 'text', 'required' => true, 'autocomplete' => 'country-name'],
            ['name' => 'company', 'label' => 'Company', 'type' => 'text', 'required' => false, 'autocomplete' => 'organization'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true, 'autocomplete' => 'email'],
            ['name' => 'product', 'label' => 'Product Name', 'type' => 'text', 'required' => false, 'autocomplete' => 'off'],
            ['name' => 'message', 'label' => 'Question or Comment', 'type' => 'textarea', 'required' => true, 'autocomplete' => 'off'],
        ];
    }
}
