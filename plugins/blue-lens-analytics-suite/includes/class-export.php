<?php
/**
 * CSV export of raw events for the selected date range — the one
 * export format that needs no external service or library.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_Export {

    public static function init() {
        add_action('admin_post_bluelens_analytics_export_csv', [__CLASS__, 'export_csv']);
    }

    public static function export_csv() {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have permission to do this.', 'blue-lens-analytics-suite'));
        }
        check_admin_referer('bluelens_analytics_export');

        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $r = BlueLens_Analytics_DB::date_range();

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT event_type, event_label, url, post_id, device_type, browser, os, country, is_returning, value, referrer, utm_source, utm_medium, utm_campaign, created_at
             FROM {$table} WHERE created_at BETWEEN %s AND %s ORDER BY created_at DESC",
            $r['start'], $r['end']
        ));

        nocache_headers();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=blue-lens-analytics-' . $r['range'] . '-' . $r['end_date'] . '.csv');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['Event Type', 'Label', 'URL', 'Post ID', 'Device', 'Browser', 'OS', 'Country', 'Returning Visitor', 'Value', 'Referrer', 'UTM Source', 'UTM Medium', 'UTM Campaign', 'Date/Time']);
        foreach ($rows as $row) {
            fputcsv($out, [
                $row->event_type, $row->event_label, $row->url, $row->post_id,
                $row->device_type, $row->browser, $row->os, $row->country, $row->is_returning, $row->value,
                $row->referrer, $row->utm_source, $row->utm_medium, $row->utm_campaign, $row->created_at,
            ]);
        }
        fclose($out);
        exit;
    }
}
