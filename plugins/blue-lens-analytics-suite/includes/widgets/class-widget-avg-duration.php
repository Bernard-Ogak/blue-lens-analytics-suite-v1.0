<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Avg_Duration extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'avg_duration'; }
    public function label() { return __('Avg. Time on Page', 'blue-lens-analytics-suite'); }
    public function category() { return __('Engagement', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-clock'; }
    public function series_kind() { return 'kpi-only'; }
    public function supported_chart_types() { return ['kpi']; }
    public function default_chart_type() { return 'kpi'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $row = $wpdb->get_row($wpdb->prepare(
            "SELECT AVG(value) AS avg_val, COUNT(*) AS n FROM {$table}
             WHERE event_type = 'time_on_page' AND value IS NOT NULL AND created_at BETWEEN %s AND %s",
            $r['start'], $r['end']
        ));

        $avg = $row ? (float) $row->avg_val : 0;
        $n = $row ? (int) $row->n : 0;

        return [
            'value'       => $this->format_duration($avg),
            'value_label' => __('Avg. Time on Page', 'blue-lens-analytics-suite'),
            /* translators: %s: number of recorded sessions */
            'value_sub'   => sprintf(__('from %s recorded sessions', 'blue-lens-analytics-suite'), number_format_i18n($n)),
        ];
    }
}
