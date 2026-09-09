<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Event_Breakdown extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'event_breakdown'; }
    public function label() { return __('Event Breakdown', 'blue-lens-analytics-suite'); }
    public function category() { return __('Engagement', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-chart-pie'; }
    public function series_kind() { return 'breakdown'; }
    public function supported_chart_types() { return ['bar', 'pie', 'doughnut', 'table']; }
    public function default_chart_type() { return 'bar'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT event_type, COUNT(*) AS c FROM {$table}
             WHERE created_at BETWEEN %s AND %s
             GROUP BY event_type ORDER BY c DESC",
            $r['start'], $r['end']
        ));
        $labels = BlueLens_Analytics_Settings::event_labels();

        $named = [];
        foreach ($rows as $row) {
            $obj = new stdClass();
            $obj->name = $labels[$row->event_type] ?? $row->event_type;
            $obj->c = $row->c;
            $named[] = $obj;
        }
        return $this->shape_breakdown($named);
    }
}
