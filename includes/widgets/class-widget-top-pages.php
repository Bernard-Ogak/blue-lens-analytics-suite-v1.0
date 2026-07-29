<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Top_Pages extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'top_pages'; }
    public function label() { return __('Most Visited Pages', 'blue-lens-analytics-suite'); }
    public function category() { return __('Content', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-admin-page'; }
    public function series_kind() { return 'kpi-only'; }
    public function supported_chart_types() { return ['table', 'list']; }
    public function default_chart_type() { return 'table'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT url, COUNT(*) AS c FROM {$table}
             WHERE event_type = 'pageview' AND created_at BETWEEN %s AND %s AND url != ''
             GROUP BY url ORDER BY c DESC LIMIT 10",
            $r['start'], $r['end']
        ));

        $data_rows = [];
        foreach ($rows as $row) {
            $path = wp_parse_url($row->url, PHP_URL_PATH) ?: $row->url;
            $data_rows[] = ['name' => $path, 'count' => (int) $row->c, 'url' => $row->url];
        }

        return [
            'columns'     => [
                ['key' => 'name', 'label' => __('Page', 'blue-lens-analytics-suite')],
                ['key' => 'count', 'label' => __('Views', 'blue-lens-analytics-suite')],
            ],
            'rows'        => $data_rows,
            'value'       => number_format_i18n(array_sum(wp_list_pluck($data_rows, 'count'))),
            'value_label' => __('Total Views', 'blue-lens-analytics-suite'),
        ];
    }
}
