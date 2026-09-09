<?php
/**
 * Per-metric on/off toggles, stored as a single option so the
 * dashboard and the tracker both read one source of truth.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_Settings {

    const OPTION_KEY = 'bluelens_analytics_settings';

    public static function init() {
        add_action('admin_init', [__CLASS__, 'register']);
    }

    public static function register() {
        register_setting('bluelens_analytics_settings_group', self::OPTION_KEY, [
            'sanitize_callback' => [__CLASS__, 'sanitize'],
        ]);
    }

    public static function sanitize($value) {
        $clean = [];
        foreach (self::all_keys() as $key => $label) {
            $clean[$key] = !empty($value[$key]);
        }
        return $clean;
    }

    /**
     * Every trackable event, with the human-readable label shown next
     * to its toggle on the Settings page.
     */
    public static function event_labels() {
        return [
            'pageview'           => __('Page Views', 'blue-lens-analytics-suite'),
            'whatsapp_click'     => __('WhatsApp Clicks', 'blue-lens-analytics-suite'),
            'phone_click'        => __('Phone Call Clicks', 'blue-lens-analytics-suite'),
            'email_click'        => __('Email Clicks', 'blue-lens-analytics-suite'),
            'cta_click'          => __('CTA Button Clicks (Book Now, Get Started, etc.)', 'blue-lens-analytics-suite'),
            'inquiry'            => __('Contact Form Submissions', 'blue-lens-analytics-suite'),
            'newsletter_signup'  => __('Newsletter Signups', 'blue-lens-analytics-suite'),
            'planner_complete'   => __('Planner/Wizard Completions', 'blue-lens-analytics-suite'),
            'estimator_complete' => __('Cost Estimator Usage', 'blue-lens-analytics-suite'),
            'pdf_download'       => __('PDF/Resource Downloads', 'blue-lens-analytics-suite'),
            'review_submit'      => __('Review Submissions', 'blue-lens-analytics-suite'),
            'gallery_view'       => __('Gallery Item Views', 'blue-lens-analytics-suite'),
            'image_view'         => __('Image Views (blog & gallery images scrolled into view)', 'blue-lens-analytics-suite'),
            'time_on_page'       => __('Time on Page / Interaction Duration', 'blue-lens-analytics-suite'),
            'scroll_depth'       => __('Scroll Depth (25% / 50% / 75% / 100% milestones)', 'blue-lens-analytics-suite'),
        ];
    }

    /**
     * Toggles that shape tracking behavior rather than gating a single
     * event type — shown in their own "Behavior & Privacy" section on
     * the Settings page since they work differently (e.g. localStorage
     * use) from the plain on/off event toggles above.
     */
    public static function behavior_labels() {
        return [
            'returning_visitor_detection' => __('Returning Visitor Detection (uses a small localStorage flag on the visitor\'s device — not a cross-site cookie — purely to tell new visits from returning ones)', 'blue-lens-analytics-suite'),
        ];
    }

    private static function all_keys() {
        return array_merge(self::event_labels(), self::behavior_labels());
    }

    public static function get_all() {
        $saved = get_option(self::OPTION_KEY, []);
        $all = [];
        foreach (self::all_keys() as $key => $label) {
            // Default every metric ON — matches the "individually
            // configurable, all enabled out of the box" behavior asked for.
            $all[$key] = array_key_exists($key, $saved) ? (bool) $saved[$key] : true;
        }
        return $all;
    }

    public static function is_event_enabled($event_type) {
        if (empty($event_type)) {
            return false;
        }
        $all = self::get_all();
        return array_key_exists($event_type, $all) ? $all[$event_type] : true;
    }

    public static function is_behavior_enabled($key) {
        return self::is_event_enabled($key);
    }
}
