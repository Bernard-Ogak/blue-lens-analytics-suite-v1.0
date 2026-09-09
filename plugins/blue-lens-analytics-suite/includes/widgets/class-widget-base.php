<?php
/**
 * Contract every dashboard widget implements, plus the query helpers
 * shared by most of them (a zero-filled daily timeseries, and a
 * "group by column, top 7 + Other" breakdown) so each concrete widget
 * only has to supply its own WHERE clause, not re-derive the shape.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

abstract class BlueLens_Analytics_Widget_Base {

    /** Unique catalog key, e.g. 'pageviews_timeseries'. */
    abstract public function key();

    /** Human-readable title shown on the widget card and in the Add Widget modal. */
    abstract public function label();

    /** Grouping shown in the Add Widget modal (Traffic, Audience, Content, Engagement, Conversions). */
    abstract public function category();

    /** Dashicon class for the Add Widget modal entry. */
    abstract public function icon();

    /**
     * Tells the front end how to color a chart:
     *  - timeseries: one entity over time -> single sequential hue
     *  - breakdown:  several entities at once -> the categorical palette
     *  - ordinal:    ordered buckets of one entity -> stepped sequential hue
     *  - kpi-only:   a single headline number/table, no chart-color concept
     */
    abstract public function series_kind();

    /** Chart types this widget's data shape can render (line/bar/pie/doughnut/table/list/kpi). */
    abstract public function supported_chart_types();

    /** Which of supported_chart_types() is selected for a brand-new widget instance. */
    abstract public function default_chart_type();

    /** The normalized payload the front end renders — see class-widget-registry.php for the shape. */
    abstract public function data($range);

    /**
     * This widget's own configurable options. Currently every widget's
     * only per-instance setting is its chart type, but this lives on
     * the widget itself (not assumed by the registry) so a future
     * widget can declare additional settings without changing the
     * contract for the rest.
     */
    public function settings() {
        return [
            'chart_type' => [
                'options' => $this->supported_chart_types(),
                'default' => $this->default_chart_type(),
            ],
        ];
    }

    /** The shape includes/class-admin-menu.php localizes as this widget's catalog entry. */
    public function to_catalog_entry() {
        return [
            'label'       => $this->label(),
            'category'    => $this->category(),
            'icon'        => $this->icon(),
            'series_kind' => $this->series_kind(),
            'supports'    => $this->supported_chart_types(),
            'default'     => $this->default_chart_type(),
        ];
    }

    /* ---------------------------------------------------------------
     * Shared query helpers
     * ------------------------------------------------------------- */

    /** Zero-filled daily series between $r['start_date'] and $r['end_date']. */
    protected function timeseries($where, $r, $label, $distinct_visitor = false) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $select = $distinct_visitor ? 'COUNT(DISTINCT visitor_hash)' : 'COUNT(*)';
        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT DATE(created_at) AS d, {$select} AS c FROM {$table}
             WHERE {$where} AND created_at BETWEEN %s AND %s
             GROUP BY DATE(created_at) ORDER BY d ASC",
            $r['start'], $r['end']
        ));
        $map = [];
        foreach ($rows as $row) {
            $map[$row->d] = (int) $row->c;
        }

        $labels = [];
        $series = [];
        $cursor = strtotime($r['start_date']);
        $end_ts = strtotime($r['end_date']);
        while ($cursor <= $end_ts) {
            $d = gmdate('Y-m-d', $cursor);
            $labels[] = gmdate('M j', $cursor);
            $series[] = $map[$d] ?? 0;
            $cursor = strtotime('+1 day', $cursor);
        }

        return [
            'labels'      => $labels,
            'series'      => $series,
            'series_kind' => 'timeseries',
            'value'       => number_format_i18n(array_sum($series)),
            'value_label' => $label,
        ];
    }

    /** Group-by-one-column breakdown, capped at the palette's 8 slots (see the dataviz skill). */
    protected function breakdown($column, $where, $r, $label_cb = null) {
        global $wpdb;
        $table = BlueLens_Analytics_DB::table();
        $column = preg_replace('/[^a-z_]/', '', $column);
        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT {$column} AS name, COUNT(*) AS c FROM {$table}
             WHERE {$where} AND created_at BETWEEN %s AND %s
             GROUP BY {$column} ORDER BY c DESC",
            $r['start'], $r['end']
        ));

        return $this->shape_breakdown($rows, $label_cb);
    }

    /**
     * Shapes any {name, c} row list into the breakdown payload: top 7 +
     * Other for the chart, full list for the table/list view.
     */
    protected function shape_breakdown($rows, $label_cb = null) {
        $all_rows = [];
        $total = 0;
        foreach ($rows as $row) {
            $name = $label_cb ? call_user_func($label_cb, $row->name) : $row->name;
            $all_rows[] = ['name' => $name, 'count' => (int) $row->c];
            $total += (int) $row->c;
        }

        $chart_rows = $all_rows;
        if (count($chart_rows) > 8) {
            $top = array_slice($chart_rows, 0, 7);
            $other_count = 0;
            foreach (array_slice($chart_rows, 7) as $rest) {
                $other_count += $rest['count'];
            }
            $top[] = ['name' => __('Other', 'blue-lens-analytics-suite'), 'count' => $other_count];
            $chart_rows = $top;
        }

        return [
            'labels'      => wp_list_pluck($chart_rows, 'name'),
            'series'      => wp_list_pluck($chart_rows, 'count'),
            'series_kind' => 'breakdown',
            'columns'     => [
                ['key' => 'name', 'label' => __('Name', 'blue-lens-analytics-suite')],
                ['key' => 'count', 'label' => __('Count', 'blue-lens-analytics-suite')],
            ],
            'rows'        => $all_rows,
            'value'       => number_format_i18n($total),
            'value_label' => __('Total', 'blue-lens-analytics-suite'),
        ];
    }

    protected function format_duration($seconds) {
        $seconds = (int) round($seconds);
        if ($seconds < 60) {
            /* translators: %d: seconds */
            return sprintf(__('%ds', 'blue-lens-analytics-suite'), $seconds);
        }
        $m = (int) floor($seconds / 60);
        $s = $seconds % 60;
        /* translators: 1: minutes, 2: seconds */
        return sprintf(__('%1$dm %2$ds', 'blue-lens-analytics-suite'), $m, $s);
    }

    public static function label_ucfirst($value) {
        return ucfirst($value);
    }
}
