<?php
if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Top_Images extends BlueLens_Analytics_Widget_Base {
    public function key() { return 'top_images'; }
    public function label() { return __('Most Viewed Images', 'blue-lens-analytics-suite'); }
    public function category() { return __('Content', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-format-image'; }
    public function series_kind() { return 'kpi-only'; }
    public function supported_chart_types() { return ['table', 'list']; }
    public function default_chart_type() { return 'list'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT event_label AS image, COUNT(*) AS c FROM {$table}
             WHERE event_type = 'image_view' AND event_label != '' AND created_at BETWEEN %s AND %s
             GROUP BY event_label ORDER BY c DESC LIMIT 10",
            $r['start'], $r['end']
        ));

        $data_rows = [];
        foreach ($rows as $row) {
            $data_rows[] = ['name' => $row->image, 'count' => (int) $row->c];
        }

        return [
            'columns'     => [
                ['key' => 'name', 'label' => __('Image', 'blue-lens-analytics-suite')],
                ['key' => 'count', 'label' => __('Views', 'blue-lens-analytics-suite')],
            ],
            'rows'        => $data_rows,
            'value'       => number_format_i18n(array_sum(wp_list_pluck($data_rows, 'count'))),
            'value_label' => __('Total Image Views', 'blue-lens-analytics-suite'),
        ];
    }
}
