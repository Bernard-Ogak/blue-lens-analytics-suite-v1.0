<?php
/**
 * Cross-cutting concerns for the customizable dashboard: per-admin
 * layout storage and the AJAX endpoints the front end calls. The
 * catalog and the actual per-metric queries live in one class per
 * widget (includes/widgets/), reached through
 * BlueLens_Analytics_Widget_Registry — this class never queries the
 * events table itself.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_Widgets {

    const LAYOUT_META_KEY = 'bluelens_analytics_dashboard_layout';
    const MAX_WIDGETS = 24;

    public static function init() {
        add_action('wp_ajax_bluelens_analytics_widget_data', [__CLASS__, 'ajax_widget_data']);
        add_action('wp_ajax_bluelens_analytics_save_layout', [__CLASS__, 'ajax_save_layout']);
        add_action('wp_ajax_bluelens_analytics_reset_layout', [__CLASS__, 'ajax_reset_layout']);
    }

    /** The full catalog of metrics an admin can add to their dashboard, built from the widget registry. */
    public static function available_widgets() {
        $catalog = [];
        foreach (BlueLens_Analytics_Widget_Registry::all() as $key => $widget) {
            $catalog[$key] = $widget->to_catalog_entry();
        }
        return $catalog;
    }

    public static function get_metric_data($metric, $range) {
        $widget = BlueLens_Analytics_Widget_Registry::get($metric);
        if (!$widget) {
            return ['error' => 'Unknown metric'];
        }
        return $widget->data($range);
    }

    /* ---------------------------------------------------------------
     * Layout storage (per-admin, like core WP Dashboard widgets)
     * ------------------------------------------------------------- */

    public static function default_layout() {
        return [
            ['id' => 'w1', 'metric' => 'pageviews_timeseries', 'chart_type' => 'line'],
            ['id' => 'w2', 'metric' => 'new_vs_returning', 'chart_type' => 'doughnut'],
            ['id' => 'w3', 'metric' => 'device_breakdown', 'chart_type' => 'doughnut'],
            ['id' => 'w4', 'metric' => 'browser_breakdown', 'chart_type' => 'pie'],
            ['id' => 'w5', 'metric' => 'top_pages', 'chart_type' => 'table'],
            ['id' => 'w6', 'metric' => 'top_posts', 'chart_type' => 'table'],
            ['id' => 'w7', 'metric' => 'top_images', 'chart_type' => 'list'],
            ['id' => 'w8', 'metric' => 'country_breakdown', 'chart_type' => 'bar'],
            ['id' => 'w9', 'metric' => 'avg_duration', 'chart_type' => 'kpi'],
            ['id' => 'w10', 'metric' => 'scroll_depth', 'chart_type' => 'bar'],
            ['id' => 'w11', 'metric' => 'subscribers', 'chart_type' => 'kpi'],
        ];
    }

    public static function get_user_layout($user_id = 0) {
        $user_id = $user_id ?: get_current_user_id();
        $saved = get_user_meta($user_id, self::LAYOUT_META_KEY, true);
        if (!is_array($saved) || empty($saved)) {
            return self::default_layout();
        }
        return self::sanitize_layout($saved);
    }

    public static function save_user_layout($layout, $user_id = 0) {
        $user_id = $user_id ?: get_current_user_id();
        update_user_meta($user_id, self::LAYOUT_META_KEY, self::sanitize_layout($layout));
    }

    /**
     * Whitelists every entry against available_widgets(): unknown
     * metrics are dropped, and a chart type that metric doesn't
     * support falls back to that metric's default.
     */
    private static function sanitize_layout($layout) {
        $catalog = self::available_widgets();
        $clean = [];
        foreach ((array) $layout as $item) {
            if (count($clean) >= self::MAX_WIDGETS) {
                break;
            }
            $metric = isset($item['metric']) ? sanitize_key($item['metric']) : '';
            if (!isset($catalog[$metric])) {
                continue;
            }
            $chart_type = isset($item['chart_type']) ? sanitize_key($item['chart_type']) : '';
            if (!in_array($chart_type, $catalog[$metric]['supports'], true)) {
                $chart_type = $catalog[$metric]['default'];
            }
            $id = isset($item['id']) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', (string) $item['id']) : '';
            if ('' === $id) {
                $id = 'w' . wp_generate_password(8, false);
            }
            $clean[] = ['id' => $id, 'metric' => $metric, 'chart_type' => $chart_type];
        }
        return $clean;
    }

    /* ---------------------------------------------------------------
     * AJAX endpoints
     * ------------------------------------------------------------- */

    public static function ajax_widget_data() {
        check_ajax_referer('bluelens_analytics_dashboard', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Forbidden'], 403);
        }

        $catalog = self::available_widgets();
        $metric = isset($_POST['metric']) ? sanitize_key(wp_unslash($_POST['metric'])) : '';
        if (!isset($catalog[$metric])) {
            wp_send_json_error(['message' => 'Unknown metric'], 400);
        }

        $range = isset($_POST['range']) ? sanitize_key(wp_unslash($_POST['range'])) : '7d';
        if (!in_array($range, ['today', '7d', '30d', '90d'], true)) {
            $range = '7d';
        }

        wp_send_json_success(self::get_metric_data($metric, $range));
    }

    public static function ajax_save_layout() {
        check_ajax_referer('bluelens_analytics_dashboard', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Forbidden'], 403);
        }

        $raw = isset($_POST['layout']) ? wp_unslash($_POST['layout']) : '[]';
        $layout = json_decode((string) $raw, true, 4);
        if (!is_array($layout)) {
            wp_send_json_error(['message' => 'Invalid layout'], 400);
        }

        self::save_user_layout($layout);
        wp_send_json_success();
    }

    public static function ajax_reset_layout() {
        check_ajax_referer('bluelens_analytics_dashboard', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Forbidden'], 403);
        }

        delete_user_meta(get_current_user_id(), self::LAYOUT_META_KEY);
        wp_send_json_success(['layout' => self::default_layout()]);
    }
}
