<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Subscribers extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'subscribers'; }
    public function label() { return __('Newsletter Subscribers', 'blue-lens-analytics-suite'); }
    public function category() { return __('Conversions', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-megaphone'; }
    public function series_kind() { return 'timeseries'; }
    public function supported_chart_types() { return ['kpi', 'line', 'bar']; }
    public function default_chart_type() { return 'kpi'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $total = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table} WHERE event_type = 'newsletter_signup'");

        $since = gmdate('Y-m-01', strtotime('-5 months', strtotime($r['end_date'])));
        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT DATE_FORMAT(created_at, '%%Y-%%m') AS m, COUNT(*) AS c FROM {$table}
             WHERE event_type = 'newsletter_signup' AND created_at >= %s
             GROUP BY m ORDER BY m ASC",
            $since . ' 00:00:00'
        ));
        $map = [];
        foreach ($rows as $row) {
            $map[$row->m] = (int) $row->c;
        }

        $labels = [];
        $series = [];
        $cursor = strtotime($since);
        for ($i = 0; $i < 6; $i++) {
            $key = gmdate('Y-m', $cursor);
            $labels[] = gmdate('M', $cursor);
            $series[] = $map[$key] ?? 0;
            $cursor = strtotime('+1 month', $cursor);
        }

        return [
            'labels'      => $labels,
            'series'      => $series,
            'series_kind' => 'timeseries',
            'value'       => number_format_i18n($total),
            'value_label' => __('Total Subscribers (all time)', 'blue-lens-analytics-suite'),
        ];
    }
}
