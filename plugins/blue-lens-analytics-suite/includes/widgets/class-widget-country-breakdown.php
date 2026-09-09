<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Country_Breakdown extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'country_breakdown'; }
    public function label() { return __('Top Countries', 'blue-lens-analytics-suite'); }
    public function category() { return __('Audience', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-location-alt'; }
    public function series_kind() { return 'breakdown'; }
    public function supported_chart_types() { return ['bar', 'table']; }
    public function default_chart_type() { return 'bar'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT country, COUNT(*) AS c FROM {$table}
             WHERE event_type = 'pageview' AND created_at BETWEEN %s AND %s
             GROUP BY country ORDER BY c DESC",
            $r['start'], $r['end']
        ));

        $named = [];
        foreach ($rows as $row) {
            $obj = new stdClass();
            $obj->name = $row->country ? $row->country : __('Unknown', 'blue-lens-analytics-suite');
            $obj->c = $row->c;
            $named[] = $obj;
        }

        $data = $this->shape_breakdown($named);
        if (empty($rows) || (1 === count($rows) && '' === $rows[0]->country)) {
            $data['note'] = __('Country detection relies on a header set by your host/CDN (e.g. Cloudflare). None was found for these visits, so country isn\'t available on this hosting setup.', 'blue-lens-analytics-suite');
        }
        return $data;
    }
}
