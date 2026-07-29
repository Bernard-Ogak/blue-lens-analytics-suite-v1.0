<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Os_Breakdown extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'os_breakdown'; }
    public function label() { return __('Operating Systems', 'blue-lens-analytics-suite'); }
    public function category() { return __('Audience', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-desktop'; }
    public function series_kind() { return 'breakdown'; }
    public function supported_chart_types() { return ['pie', 'doughnut', 'bar', 'table']; }
    public function default_chart_type() { return 'doughnut'; }

    public function data($range) {
        $r = BlueLens_Analytics_DB::date_range($range);
        return $this->breakdown('os', "event_type = 'pageview' AND os != ''", $r);
    }
}
