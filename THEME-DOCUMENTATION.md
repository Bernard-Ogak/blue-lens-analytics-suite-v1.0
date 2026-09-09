# B.O-Safari-theme Documentation

**B.O-Safari-theme** is a production-ready, ultra-luxury WordPress theme engineered specifically for premium African Tours & Safaris operators in Kenya, Tanzania, Rwanda, Uganda, and southern Africa.

Developed by **Bernard Ogak**.

---

## 1. Architectural Principles & Separation of Concerns

The theme follows strict WordPress architecture standards:

* **Presentation Layer (B.O-Safari-theme)**:
  - Owns visual hierarchy, layout, typography, responsive breakpoints, design system tokens, CSS animations, global components, accessibility, and conversion-focused UI.
* **Business & Tourism Layer (B.O-Safari-Plugin)**:
  - Owns CPT registration (`safari`, `destination`, `experience`, `accommodation`), pricing logic, real-time availability, bookings, enquiry records, reviews database, and tourism data relationships.

### Plugin Integration & Graceful Degradation Matrix
The theme includes `inc/plugin-integration.php`.
* **When `B.O-Safari-Plugin` is active**: Full dynamic tourism data, live availability, custom search filtering, and enquiry routing are enabled.
* **When `B.O-Safari-Plugin` is inactive**: The theme activates and functions standalone without any PHP fatal errors. Static pages, editorial blog, customizer settings, navigation, custom safari builder, and contact forms degrade gracefully with built-in mock fallback models.

---

## 2. Directory & Modular Structure

```text
bo-safari-theme/
├── style.css                      # Official WordPress theme header
├── functions.php                  # Bootstrap & include definitions
├── index.php                      # Core post index fallback
├── front-page.php                 # Modular cinematic homepage (14 sections)
├── home.php                       # Blog / Journal index
├── header.php                     # Header wrapper & accessibility skip links
├── footer.php                     # Footer wrapper & global modals
├── page.php                       # Standard page template
├── single.php                     # Standard single post template
├── archive.php                    # Standard post archive
├── search.php                     # Search results & empty state handler
├── 404.php                        # Branded 404 error page
│
├── single-safari.php              # Luxury editorial safari detail template
├── archive-safari.php             # Filterable safari discovery archive
├── single-destination.php         # Destination detail template
├── archive-destination.php        # Destination directory archive
├── single-experience.php         # Signature experience detail template
├── archive-experience.php        # Experience directory archive
├── single-accommodation.php      # Safari lodge/camp detail template
├── archive-accommodation.php     # Accommodation directory archive
│
├── page-about.php                 # About Us brand story & sustainability
├── page-contact.php               # Contact page with instant WhatsApp & form
├── page-reviews.php               # Multi-platform guest reviews hub
├── page-build-your-safari.php     # Interactive 10-step custom safari builder
├── page-travel-guide.php          # Field journal & travel guide index
│
├── inc/
│   ├── setup.php                  # Theme supports, image sizes, nav menus
│   ├── enqueue.php                # Styles, Google fonts, JS scripts
│   ├── plugin-integration.php     # Safe abstraction layer & AJAX endpoints
│   ├── navigation.php             # Custom Walker for nav & mega menus
│   ├── template-functions.php     # Price display, star ratings, WhatsApp buttons
│   ├── theme-options.php          # WP Customizer controls
│   ├── accessibility.php          # ARIA & WCAG AA enhancements
│   ├── performance.php            # Script deferral & head cleanup
│   ├── seo.php                    # Schema.org JSON-LD structured data
│   └── helpers.php                # Breadcrumbs, reading time, social share
│
├── template-parts/
│   ├── header/                    # site-header.php & mobile drawer
│   ├── footer/                    # site-footer.php
│   ├── hero/                      # hero-home.php with search filter bar
│   ├── safari/                    # featured-safaris.php
│   ├── destination/               # popular-destinations.php
│   ├── experience/                # signature-experiences.php
│   ├── accommodation/             # luxury-accommodation.php
│   ├── reviews/                   # traveller-reviews-home.php, external-platforms.php
│   ├── blog/                      # content-card.php, content-none.php, travel-inspiration.php
│   └── components/                # safari-card, destination-card, experience-card, accommodation-card, review-card, trust-bar, why-travel-with-us, custom-builder-banner, cta-section, newsletter-section, enquiry-modal, mobile-sticky-bar
│
├── assets/
│   ├── css/                       # main.css (Centralized design tokens)
│   └── js/                        # main.js (Header, drawer, accordions, modals), safari-builder.js (10-step form)
├── languages/                     # bo-safari-theme.pot
└── screenshot.png                 # Theme preview image
```

---

## 3. Design Tokens & Styling System

The theme uses centralized CSS Custom Properties in `assets/css/main.css`:

* **Deep Safari Green**: `#1b3b2b` (Primary brand color)
* **Forest Green**: `#2d5a40`
* **Champagne Gold**: `#c5a059` (Accent & CTA highlights)
* **Sand**: `#e6dfd3`
* **Warm Ivory**: `#fdfbf7` (Background color)
* **Charcoal**: `#222222` (Body typography)
* **Primary Font**: `Poppins` (Clean UI & sans-serif body)
* **Serif Display Font**: `Playfair Display` (Luxury headings & titles)

---

## 4. Key Features & Page Templates

### 10-Step Interactive Custom Safari Builder (`page-build-your-safari.php`)
Allows travellers to customize their safari step by step:
1. Destination Selection
2. Travel Dates & Duration
3. Group Size (Adults / Children)
4. Preferred Travel Style
5. Accommodation Comfort Level
6. Signature Experiences
7. Wildlife Interests
8. Budget Range
9. Special Notes / Preferences
10. Contact Details & AJAX Submission

### Editorial Safari Detail Page (`single-safari.php`)
Includes:
- Full-width hero banner with starting price & quick facts
- Expandable day-by-day itinerary accordion
- Included vs Excluded service comparison grid
- Guest review ratings & FAQ section
- Sticky desktop booking sidebar & mobile bottom action bar

### WhatsApp Concierge Integration
Configurable in **Appearance → Customize → B.O-Safari-theme Options**. Renders direct WhatsApp CTA buttons on header, single safari pages, contact page, and mobile sticky bottom bar.

---

## 5. SEO & Schema.org Structured Data

Includes automated JSON-LD Schema generation in `inc/seo.php`:
- `TravelAgency` & `Organization` on homepage
- `TouristTrip` with price and offer availability on single safari templates
- `BreadcrumbList` on all interior pages

---

## 6. Pre-Commit Verification & Syntax Checks

All PHP files have been validated with `php -l` and meet WordPress Coding Standards.
