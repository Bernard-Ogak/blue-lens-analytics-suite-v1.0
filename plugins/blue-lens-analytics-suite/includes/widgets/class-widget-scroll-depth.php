<?php
/**
 * How far into the page visitors actually scroll. tracker.js fires one
 * 'scroll_depth' event per milestone (25/50/75/100%) reached, at most
 * once per page load, with the milestone number in the `value` column
 * — so this is naturally a funnel: the 100% count is always <= the 75%
 * count, which is always <= the 50% count, and so on.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Widget_Scroll_Depth extends BlueLens_Analytics_Widget_Base {
    const MILESTONES = [25, 50, 75, 100];

    public function key() { return 'scroll_depth'; }
    public function label() { return __('Scroll Depth', 'blue-lens-analytics-suite'); }
    public function category() { return __('Engagement', 'blue-lens-analytics-suite'); }
    public function icon() { return 'dashicons-arrow-down-alt2'; }
    public function series_kind() { return 'ordinal'; }
    public function supported_chart_types() { return ['bar']; }
    public function default_chart_type() { return 'bar'; }

    public function data($range) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range($range);

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT value, COUNT(DISTINCT session_id) AS c FROM {$table}
             WHERE event_type = 'scroll_depth' AND created_at BETWEEN %s AND %s
             GROUP BY value",
            $r['start'], $r['end']
        ));
        $counts = [];
        foreach ($rows as $row) {
            $counts[(int) $row->value] = (int) $row->c;
        }

        $labels = [];
        $series = [];
        foreach (self::MILESTONES as $m) {
            $labels[] = $m . '%';
            $series[] = $counts[$m] ?? 0;
        }

        return [
            'labels'      => $labels,
            'series'      => $series,
            'series_kind' => 'ordinal',
            'value'       => number_format_i18n(end($series) ?: 0),
            'value_label' => __('Sessions Reaching 100%', 'blue-lens-analytics-suite'),
        ];
    }
}
