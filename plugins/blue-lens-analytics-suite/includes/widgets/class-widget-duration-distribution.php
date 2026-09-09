<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Duration_Distribution extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'duration_distribution'; }
    public function label() { return __('Time on Page Distribution', 'blue-lens-analytics-suite'); }
    public function category() { return __('Engagement', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-chart-bar'; }
    public function series_kind() { return 'ordinal'; }
    public function supported_chart_types() { return ['bar']; }
    public function default_chart_type() { return 'bar'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT
                CASE
                    WHEN value < 15 THEN '0'
                    WHEN value < 30 THEN '1'
                    WHEN value < 60 THEN '2'
                    WHEN value < 180 THEN '3'
                    WHEN value < 600 THEN '4'
                    ELSE '5'
                END AS bucket,
                COUNT(*) AS c
             FROM {$table}
             WHERE event_type = 'time_on_page' AND value IS NOT NULL AND created_at BETWEEN %s AND %s
             GROUP BY bucket",
            $r['start'], $r['end']
        ));

        $bucket_labels = ['0-15s', '15-30s', '30-60s', '1-3m', '3-10m', '10m+'];
        $counts = array_fill(0, 6, 0);
        foreach ($rows as $row) {
            $counts[(int) $row->bucket] = (int) $row->c;
        }

        return [
            'labels'      => $bucket_labels,
            'series'      => $counts,
            'series_kind' => 'ordinal',
            'value'       => number_format_i18n(array_sum($counts)),
            'value_label' => __('Sessions Measured', 'blue-lens-analytics-suite'),
        ];
    }
}
