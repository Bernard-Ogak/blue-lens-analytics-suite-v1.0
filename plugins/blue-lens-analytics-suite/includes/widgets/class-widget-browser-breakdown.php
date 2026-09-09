<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Browser_Breakdown extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'browser_breakdown'; }
    public function label() { return __('Browsers', 'blue-lens-analytics-suite'); }
    public function category() { return __('Audience', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-admin-site-alt3'; }
    public function series_kind() { return 'breakdown'; }
    public function supported_chart_types() { return ['pie', 'doughnut', 'bar', 'table']; }
    public function default_chart_type() { return 'pie'; }

    public function data($range) {
        $r = BlueLens_Analytics_DB::date_range($range);
        return $this->breakdown('browser', "event_type = 'pageview' AND browser != ''", $r);
    }
}
