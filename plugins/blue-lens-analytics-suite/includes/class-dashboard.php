<?php
/**
 * Executive dashboard: a top KPI strip plus a fully customizable
 * widget grid (assets/js/dashboard.js + includes/class-widgets.php).
 * Each widget card is server-rendered as an empty shell — the header,
 * chart/table, add/remove/reorder, and layout persistence all happen
 * client-side against the BlueLens_Analytics_Widgets AJAX endpoints.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_Dashboard {

    private static function count_where($r, $where_extra = '') {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $sql = "SELECT COUNT(*) FROM {$table} WHERE created_at BETWEEN %s AND %s {$where_extra}";
        return (int) $wpdb->get_var($wpdb->prepare($sql, $r['start'], $r['end']));
    }

    public static function render() {
        if (!current_user_can('manage_options')) {
            return;
        }
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range();

        $pageviews  = self::count_where($r, "AND event_type = 'pageview'");
        $unique_visitors = (int) $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(DISTINCT visitor_hash) FROM {$table} WHERE created_at BETWEEN %s AND %s AND visitor_hash != ''",
            $r['start'], $r['end']
        ));
        $whatsapp   = self::count_where($r, "AND event_type = 'whatsapp_click'");
        $phone      = self::count_where($r, "AND event_type = 'phone_click'");
        $inquiries  = self::count_where($r, "AND event_type = 'inquiry'");
        $planner    = self::count_where($r, "AND event_type = 'planner_complete'");
        $estimator  = self::count_where($r, "AND event_type = 'estimator_complete'");

        $conversion_events = $inquiries + $planner + $estimator;
        $conversion_rate = $pageviews > 0 ? round(($conversion_events / $pageviews) * 100, 1) : 0;

        $returning = BlueLens_Analytics_Widgets::get_metric_data('new_vs_returning', $r['range']);
        $duration  = BlueLens_Analytics_Widgets::get_metric_data('avg_duration', $r['range']);
        $subs      = BlueLens_Analytics_Widgets::get_metric_data('subscribers', $r['range']);

        $ranges = ['today' => __('Today', 'blue-lens-analytics-suite'), '7d' => __('Last 7 Days', 'blue-lens-analytics-suite'), '30d' => __('Last 30 Days', 'blue-lens-analytics-suite'), '90d' => __('Last 90 Days', 'blue-lens-analytics-suite')];
        $layout = BlueLens_Analytics_Widgets::get_user_layout();
        ?>
        <div class="wrap blue-lens-analytics-wrap">
            <?php BlueLens_Analytics_Admin_Menu::brand_header(__('Executive Dashboard', 'blue-lens-analytics-suite')); ?>

            <div class="pa-toolbar">
                <div class="pa-range-switch">
                    <?php foreach ($ranges as $key => $label) : ?>
                    <a href="<?php echo esc_url(add_query_arg(['page' => 'blue-lens-analytics', 'range' => $key], admin_url('admin.php'))); ?>"
                       class="pa-range-switch__btn<?php echo $r['range'] === $key ? ' is-active' : ''; ?>"><?php echo esc_html($label); ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="pa-toolbar__actions">
                    <button type="button" id="pa-add-widget-btn" class="button button-primary">
                        <span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span> <?php esc_html_e('Add Widget', 'blue-lens-analytics-suite'); ?>
                    </button>
                    <button type="button" id="pa-reset-layout-btn" class="button"><?php esc_html_e('Reset Layout', 'blue-lens-analytics-suite'); ?></button>
                    <a class="button" href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=bluelens_analytics_export_csv&range=' . $r['range']), 'bluelens_analytics_export')); ?>">
                        <?php esc_html_e('Export CSV', 'blue-lens-analytics-suite'); ?>
                    </a>
                </div>
            </div>

            <div class="pa-kpi-grid">
                <?php
                $cards = [
                    ['label' => __('Page Views', 'blue-lens-analytics-suite'), 'value' => $pageviews, 'icon' => 'dashicons-visibility', 'accent' => 1],
                    ['label' => __('Unique Visitors', 'blue-lens-analytics-suite'), 'value' => $unique_visitors, 'icon' => 'dashicons-groups', 'accent' => 2],
                    ['label' => __('Conversion Rate', 'blue-lens-analytics-suite'), 'value' => $conversion_rate . '%', 'icon' => 'dashicons-chart-line', 'note' => __('inquiries + planner + estimator ÷ pageviews', 'blue-lens-analytics-suite'), 'accent' => 3],
                    ['label' => __('Returning Visitors', 'blue-lens-analytics-suite'), 'value' => $returning['value'], 'icon' => 'dashicons-update', 'accent' => 4],
                    ['label' => __('Avg. Time on Page', 'blue-lens-analytics-suite'), 'value' => $duration['value'], 'icon' => 'dashicons-clock', 'accent' => 5],
                    ['label' => __('Subscribers (all time)', 'blue-lens-analytics-suite'), 'value' => $subs['value'], 'icon' => 'dashicons-megaphone', 'accent' => 6],
                    ['label' => __('WhatsApp Clicks', 'blue-lens-analytics-suite'), 'value' => $whatsapp, 'icon' => 'dashicons-whatsapp', 'accent' => 7],
                    ['label' => __('Phone Clicks', 'blue-lens-analytics-suite'), 'value' => $phone, 'icon' => 'dashicons-phone', 'accent' => 8],
                ];
                foreach ($cards as $card) : ?>
                <div class="pa-kpi-card pa-kpi-card--accent-<?php echo esc_attr($card['accent']); ?>">
                    <span class="pa-kpi-card__icon-chip dashicons <?php echo esc_attr($card['icon']); ?>" aria-hidden="true"></span>
                    <div>
                        <p class="pa-kpi-card__value"><?php echo esc_html($card['value']); ?></p>
                        <p class="pa-kpi-card__label"><?php echo esc_html($card['label']); ?></p>
                        <?php if (!empty($card['note'])) : ?>
                        <p class="pa-kpi-card__note"><?php echo esc_html($card['note']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div id="pa-widget-grid" class="pa-widget-grid">
                <?php foreach ($layout as $widget) : ?>
                <div class="pa-widget-card" data-id="<?php echo esc_attr($widget['id']); ?>" data-metric="<?php echo esc_attr($widget['metric']); ?>" data-chart-type="<?php echo esc_attr($widget['chart_type']); ?>">
                    <div class="pa-widget-card__body"><div class="pa-widget-loading" aria-hidden="true"></div></div>
                </div>
                <?php endforeach; ?>
            </div>

            <div id="pa-widget-modal" class="pa-modal">
                <div class="pa-modal__backdrop"></div>
                <div class="pa-modal__dialog" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Add Widget', 'blue-lens-analytics-suite'); ?>">
                    <div class="pa-modal__header">
                        <h2><?php esc_html_e('Add a Widget', 'blue-lens-analytics-suite'); ?></h2>
                        <button type="button" class="pa-modal__close" aria-label="<?php esc_attr_e('Close', 'blue-lens-analytics-suite'); ?>">&times;</button>
                    </div>
                    <div class="pa-modal__list"></div>
                </div>
            </div>

            <p class="pa-footnote">
                <?php esc_html_e('This dashboard reflects first-party data collected directly by this plugin. Google Analytics 4, Search Console, Google/Meta Ads, Clarity, and HubSpot data are not shown here yet — see the Integrations tab.', 'blue-lens-analytics-suite'); ?>
            </p>
        </div>
        <?php
    }
}
