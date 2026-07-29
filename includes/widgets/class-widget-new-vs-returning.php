<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_New_Vs_Returning extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'new_vs_returning'; }
    public function label() { return __('New vs. Returning Visitors', 'blue-lens-analytics-suite'); }
    public function category() { return __('Audience', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-update'; }
    public function series_kind() { return 'breakdown'; }
    public function supported_chart_types() { return ['doughnut', 'pie', 'table']; }
    public function default_chart_type() { return 'doughnut'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT is_returning, COUNT(DISTINCT visitor_hash) AS c FROM {$table}
             WHERE event_type = 'pageview' AND created_at BETWEEN %s AND %s AND visitor_hash != ''
             GROUP BY is_returning",
            $r['start'], $r['end']
        ));
        $counts = [0 => 0, 1 => 0];
        foreach ($rows as $row) {
            $counts[(int) $row->is_returning] = (int) $row->c;
        }
        $total = $counts[0] + $counts[1];
        $returning_pct = $total > 0 ? round(($counts[1] / $total) * 100, 1) : 0;

        return [
            'labels'      => [__('New', 'blue-lens-analytics-suite'), __('Returning', 'blue-lens-analytics-suite')],
            'series'      => [$counts[0], $counts[1]],
            'series_kind' => 'breakdown',
            'columns'     => [
                ['key' => 'name', 'label' => __('Type', 'blue-lens-analytics-suite')],
                ['key' => 'count', 'label' => __('Visitors', 'blue-lens-analytics-suite')],
            ],
            'rows'        => [
                ['name' => __('New', 'blue-lens-analytics-suite'), 'count' => $counts[0]],
                ['name' => __('Returning', 'blue-lens-analytics-suite'), 'count' => $counts[1]],
            ],
            'value'       => $returning_pct . '%',
            'value_label' => __('Returning Visitor Rate', 'blue-lens-analytics-suite'),
        ];
    }
}
