<?php
/**
 * Integrations roadmap — honest status page. None of these are wired
 * up yet: each needs an API key/OAuth app that only the site owner can
 * create (a Google Cloud project for GA4/GSC/Ads/Sheets, a Meta
 * developer app, a Clarity project, a HubSpot private app token). This
 * page exists so the admin can see exactly what's available today
 * (first-party tracking, live) versus what's planned and what it needs
 * from them to turn on — not to pretend any of it is connected.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_Integrations {

    public static function init() {
        // Reserved for future use once a real integration is wired up
        // (e.g. registering the GA4 Measurement Protocol client once
        // credentials exist). Nothing to hook yet.
    }

    private static function roadmap() {
        return [
            [
                'name'        => __('Google Analytics 4', 'blue-lens-analytics-suite'),
                'requires'    => __('A GA4 property + Measurement ID, and a Measurement Protocol API secret.', 'blue-lens-analytics-suite'),
                'adds'        => __('Cross-device sessions, demographics, and Google\'s own attribution modeling alongside this plugin\'s first-party events.', 'blue-lens-analytics-suite'),
            ],
            [
                'name'        => __('Google Search Console', 'blue-lens-analytics-suite'),
                'requires'    => __('A verified GSC property and a Google Cloud OAuth client (Search Console API enabled).', 'blue-lens-analytics-suite'),
                'adds'        => __('Impressions, clicks, average position, and indexed-page counts inside this dashboard.', 'blue-lens-analytics-suite'),
            ],
            [
                'name'        => __('Google Ads', 'blue-lens-analytics-suite'),
                'requires'    => __('A Google Ads account, developer token, and OAuth client.', 'blue-lens-analytics-suite'),
                'adds'        => __('Campaign spend, CPC, CPA, and ROAS next to on-site conversion events.', 'blue-lens-analytics-suite'),
            ],
            [
                'name'        => __('Meta Ads', 'blue-lens-analytics-suite'),
                'requires'    => __('A Meta developer app with Marketing API access and a long-lived access token.', 'blue-lens-analytics-suite'),
                'adds'        => __('Reach, impressions, spend, and lead/purchase events from Facebook & Instagram campaigns.', 'blue-lens-analytics-suite'),
            ],
            [
                'name'        => __('Microsoft Clarity', 'blue-lens-analytics-suite'),
                'requires'    => __('A Clarity project ID (free) added to the site, plus API access once Clarity\'s export API is available for your account.', 'blue-lens-analytics-suite'),
                'adds'        => __('Heatmaps, scroll maps, and session recordings — Clarity\'s own dashboard already provides these today even before this integration exists.', 'blue-lens-analytics-suite'),
            ],
            [
                'name'        => __('HubSpot CRM', 'blue-lens-analytics-suite'),
                'requires'    => __('A HubSpot private app access token with CRM read scopes.', 'blue-lens-analytics-suite'),
                'adds'        => __('Lead lifecycle stage and deal value alongside the inquiries this plugin already records.', 'blue-lens-analytics-suite'),
            ],
            [
                'name'        => __('Google Sheets Export', 'blue-lens-analytics-suite'),
                'requires'    => __('A Google Cloud service account with Sheets API access.', 'blue-lens-analytics-suite'),
                'adds'        => __('Hourly sync of this plugin\'s own KPI tables into a shared spreadsheet — CSV export (Dashboard → Export CSV) already covers ad-hoc needs today.', 'blue-lens-analytics-suite'),
            ],
            [
                'name'        => __('Power BI / Tableau', 'blue-lens-analytics-suite'),
                'requires'    => __('A Power BI or Tableau account capable of connecting to a REST feed or the exported CSV/Sheets data.', 'blue-lens-analytics-suite'),
                'adds'        => __('This plugin\'s events already flow into standard SQL — Power BI/Tableau can connect directly to the wp_bluelens_analytics_events table, or to the CSV/Sheets export once that exists.', 'blue-lens-analytics-suite'),
            ],
        ];
    }

    public static function render_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap blue-lens-analytics-wrap">
            <?php BlueLens_Analytics_Admin_Menu::brand_header(__('Integrations', 'blue-lens-analytics-suite')); ?>
            <p class="description">
                <?php esc_html_e('What\'s live today: first-party tracking of pageviews, WhatsApp/phone/email clicks, CTA clicks, inquiries, newsletter signups, custom conversion-tool completions, and file downloads — all in this site\'s own database (Dashboard tab). Everything below is planned but not connected: each needs credentials only the site owner can create. This table is the honest status of each, not a working "Connect" button.', 'blue-lens-analytics-suite'); ?>
            </p>

            <table class="widefat striped pa-integrations-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Integration', 'blue-lens-analytics-suite'); ?></th>
                        <th><?php esc_html_e('Status', 'blue-lens-analytics-suite'); ?></th>
                        <th><?php esc_html_e('What It Needs', 'blue-lens-analytics-suite'); ?></th>
                        <th><?php esc_html_e('What It Adds', 'blue-lens-analytics-suite'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (self::roadmap() as $row) : ?>
                    <tr>
                        <td><strong><?php echo esc_html($row['name']); ?></strong></td>
                        <td><span class="pa-status pa-status--pending"><?php esc_html_e('Not Connected', 'blue-lens-analytics-suite'); ?></span></td>
                        <td><?php echo esc_html($row['requires']); ?></td>
                        <td><?php echo esc_html($row['adds']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
