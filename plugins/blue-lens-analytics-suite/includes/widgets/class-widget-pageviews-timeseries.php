<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Pageviews_Timeseries extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'pageviews_timeseries'; }
    public function label() { return __('Page Views Over Time', 'blue-lens-analytics-suite'); }
    public function category() { return __('Traffic', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-chart-line'; }
    public function series_kind() { return 'timeseries'; }
    public function supported_chart_types() { return ['line', 'bar']; }
    public function default_chart_type() { return 'line'; }

    public function data($range) {
        $r = BlueLens_Analytics_DB::date_range($range);
        return $this->timeseries("event_type = 'pageview'", $r, __('Page Views', 'blue-lens-analytics-suite'));
    }
}
