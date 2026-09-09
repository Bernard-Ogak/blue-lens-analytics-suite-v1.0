<?php
/**
 * Discovers and instantiates every concrete widget class (one class
 * per metric — see includes/widgets/), keyed by each widget's own
 * key(). class-widgets.php is the only caller: it uses this for the
 * catalog and to dispatch a data request to the right widget instance,
 * while everything cross-cutting (layout storage, AJAX, sanitization)
 * stays there rather than being duplicated per widget.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_Widget_Registry {

    const WIDGET_CLASSES = [
        'BlueLens_Widget_Pageviews_Timeseries',
        'BlueLens_Widget_Unique_Visitors_Timeseries',
        'BlueLens_Widget_Device_Breakdown',
        'BlueLens_Widget_Browser_Breakdown',
        'BlueLens_Widget_Os_Breakdown',
        'BlueLens_Widget_Country_Breakdown',
        'BlueLens_Widget_New_Vs_Returning',
        'BlueLens_Widget_Top_Pages',
        'BlueLens_Widget_Top_Posts',
        'BlueLens_Widget_Top_Images',
        'BlueLens_Widget_Event_Breakdown',
        'BlueLens_Widget_Avg_Duration',
        'BlueLens_Widget_Duration_Distribution',
        'BlueLens_Widget_Scroll_Depth',
        'BlueLens_Widget_Subscribers',
    ];

    /** @var BlueLens_Analytics_Widget_Base[]|null */
    private static $instances = null;

    /** @return BlueLens_Analytics_Widget_Base[] keyed by widget key() */
    public static function all() {
        if (null === self::$instances) {
            self::$instances = [];
            foreach (self::WIDGET_CLASSES as $class) {
                $widget = new $class();
                self::$instances[$widget->key()] = $widget;
            }
        }
        return self::$instances;
    }

    public static function get($key) {
        $all = self::all();
        return $all[$key] ?? null;
    }
}
