<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Top_Posts extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'top_posts'; }
    public function label() { return __('Most Read Blog Posts', 'blue-lens-analytics-suite'); }
    public function category() { return __('Content', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-media-text'; }
    public function series_kind() { return 'kpi-only'; }
    public function supported_chart_types() { return ['table', 'list']; }
    public function default_chart_type() { return 'table'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT e.post_id, COUNT(*) AS c FROM {$table} e
             INNER JOIN {$wpdb->posts} p ON p.ID = e.post_id
             WHERE e.event_type = 'pageview' AND p.post_type = 'post' AND p.post_status = 'publish'
             AND e.created_at BETWEEN %s AND %s
             GROUP BY e.post_id ORDER BY c DESC LIMIT 10",
            $r['start'], $r['end']
        ));

        $data_rows = [];
        foreach ($rows as $row) {
            $data_rows[] = [
                'name'  => get_the_title($row->post_id) ?: __('(untitled)', 'blue-lens-analytics-suite'),
                'count' => (int) $row->c,
                'url'   => get_permalink($row->post_id) ?: '',
            ];
        }

        return [
            'columns'     => [
                ['key' => 'name', 'label' => __('Post', 'blue-lens-analytics-suite')],
                ['key' => 'count', 'label' => __('Views', 'blue-lens-analytics-suite')],
            ],
            'rows'        => $data_rows,
            'value'       => number_format_i18n(array_sum(wp_list_pluck($data_rows, 'count'))),
            'value_label' => __('Total Reads', 'blue-lens-analytics-suite'),
        ];
    }
}
