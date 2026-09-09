# Blue-Lens Analytics Suite

First-party WordPress analytics with a customizable, drag-and-drop widget dashboard — no external accounts, no cookies, no third-party network calls. Works on any WordPress site regardless of industry.

Developed by **Bernard Ogak**.

## Why first-party

Everything this plugin collects is written straight into your own WordPress database (`wp_bluelens_analytics_events`) and never leaves your server. There's no Google Analytics-style dependency to configure, no consent-banner-triggering third-party script, and no external API key required to see real numbers from day one.

## Features

- **Customizable widget dashboard** — add, remove, and drag-reorder widgets; pick the chart type per widget (line, bar, pie, donut, table, or list) from a dropdown, and it re-renders instantly from already-fetched data. Layouts are saved per admin user, like core WordPress Dashboard widgets.
- **Dark / light theme** — a toggle in the header, persisted per browser, with no flash of the wrong theme on load.
- **Interactive, colorful charts** — self-hosted Chart.js (MIT licensed, bundled — no CDN), styled with a colorblind-safe, WCAG-checked categorical palette.
- **15 built-in widgets** across five categories:

  | Category | Widgets |
  |---|---|
  | Traffic | Page Views Over Time, Unique Visitors Over Time |
  | Audience | Device Types, Browsers, Operating Systems, Top Countries, New vs. Returning Visitors |
  | Content | Most Visited Pages, Most Read Blog Posts, Most Viewed Images |
  | Engagement | Event Breakdown, Avg. Time on Page, Time on Page Distribution, Scroll Depth |
  | Conversions | Newsletter Subscribers |

- **Deep visitor reporting** — browser, OS, device type, and country (via your host/CDN's geo header, e.g. Cloudflare's `CF-IPCountry` — no IP ever leaves your server for lookup).
- **Engagement tracking** — active time on page (paused while the tab is hidden), scroll-depth milestones (25/50/75/100%), and image-view tracking for galleries and blog content.
- **Returning visitor detection** — a privacy-disclosed `localStorage` flag (not a cross-site cookie), toggleable in Settings.
- **CSV export** and a **CSV/SQL-ready schema** for anyone who wants to plug the raw events table into Power BI, Tableau, or a spreadsheet.
- **Per-event toggles** — every tracked event type can be switched off independently; logged-in editors/admins are never tracked, so your own back-office browsing never pollutes the numbers.

## Installation

1. Download `blue-lens-analytics-suite-v1.0.zip` (or clone this repo into `wp-content/plugins/blue-lens-analytics-suite`).
2. In wp-admin: **Plugins → Add New → Upload Plugin**, select the zip, and click **Install Now**.
3. Activate. The events table is created automatically on activation.
4. Go to **Blue-Lens Analytics → Dashboard** — a sensible default set of widgets is already populated; click **+ Add Widget** to add more, or drag cards to reorder.

### Requirements

- WordPress 5.9+ (uses `wp_enqueue_script`'s array-args signature)
- PHP 7.4+
- MySQL/MariaDB (standard WordPress database)

## What gets collected

| Data | How |
|---|---|
| Pageviews, clicks (WhatsApp/phone/email/CTA), form-adjacent events | `navigator.sendBeacon` from `assets/js/tracker.js`, or a server-side `do_action('bluelens_analytics_track', ...)` hook other plugins/themes can fire |
| Browser & OS | Parsed from the User-Agent string server-side at insert time |
| Device type | Parsed from the User-Agent (mobile / tablet / desktop) |
| Country | Reverse-proxy/CDN header only (`CF-IPCountry`, `X-Country-Code`, or `CloudFront-Viewer-Country`) — blank if your host doesn't set one; no external lookup service is called |
| Visitor identity | A one-way SHA-256 hash of IP + User-Agent + a **daily-rotating salt** — stable enough to count unique visitors within a day, not reversible to an IP, and not a long-lived tracking identifier |
| Returning visitor | A `localStorage` timestamp flag, disclosed and toggleable in Settings |
| Time on page | Active time only (paused via the Page Visibility API), flushed on `pagehide` |
| Scroll depth | 25/50/75/100% milestones, at most once each per page load |

Nothing here requires a cookie consent banner to function (no cross-site cookies are set), but you should still reflect what's described above in your site's privacy policy.

## Settings

**Blue-Lens Analytics → Settings** — every event type has its own on/off switch (all on by default), plus a "Behavior & Privacy" section for the returning-visitor `localStorage` toggle.

## Architecture (for developers)

- `blue-lens-analytics-suite.php` — bootstrap, constants, activation hook.
- `includes/class-db.php` — schema (`install()`), the events table's static helpers (`visitor_hash()`, `device_type()`, `country()`, `date_range()`).
- `includes/class-user-agent.php` — browser/OS parsing.
- `includes/class-tracker.php` — the `/wp-json/blue-lens-analytics/v1/track` REST endpoint + `tracker.js` enqueue.
- `includes/class-settings.php` — per-event and per-behavior toggles.
- `includes/widgets/class-widget-base.php` — the abstract contract every widget implements (`key()`, `label()`, `data()`, shared query helpers for timeseries/breakdown shapes).
- `includes/widgets/class-widget-*.php` — one concrete class per metric (15 total). Chart type is a per-instance *setting*, not the widget's identity — any breakdown metric can render as pie, donut, bar, or table from the same widget.
- `includes/class-widget-registry.php` — discovers and instantiates the widget classes above.
- `includes/class-widgets.php` — cross-cutting concerns only: per-admin layout storage (`usermeta`) and the three AJAX endpoints (`widget_data`, `save_layout`, `reset_layout`). Delegates all data queries to the registry.
- `includes/class-admin-menu.php` — wp-admin menu, asset enqueueing, the shared `brand_header()` (logo + dark-mode toggle) used on every screen.
- `includes/class-dashboard.php` / `class-export.php` / `class-integrations.php` — the three admin screens.
- `assets/js/tracker.js` — front-end beacon (pageviews, clicks, image views, time-on-page, scroll-depth, returning-visitor flag).
- `assets/js/dashboard.js` — the widget grid: fetch, render (Chart.js/table/list/KPI), add/remove/reorder (native HTML5 drag-and-drop), chart-type switching, dark-mode-aware re-rendering.
- `assets/js/theme-toggle.js` — the dark/light switch, shared across all three admin screens.

Adding a new widget means adding one class in `includes/widgets/` and one line in `BlueLens_Analytics_Widget_Registry::WIDGET_CLASSES` — nothing else needs to change.

## Roadmap

**Settings → Integrations** documents what's planned but not yet connected (GA4, Search Console, Google/Meta Ads, Microsoft Clarity, HubSpot, Google Sheets, Power BI/Tableau) and exactly what credentials each would need — all opt-in, none required for this plugin to be useful today.

## License

Plugin code: GPL-2.0-or-later (standard WordPress plugin license).
Bundles [Chart.js](https://www.chartjs.org/) (MIT License) — see `assets/js/vendor/LICENSE.chart.js`.
