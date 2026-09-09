<?php
/**
 * Front-end beacon endpoint + the tracker script that calls it, plus
 * static helpers server-side code can call directly (no HTTP round
 * trip needed) when an event happens inside a PHP request, e.g. an
 * inquiry being saved.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_Tracker {

    public static function init() {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue']);

        // Generic extensibility hook any theme/plugin can fire (inquiry
        // submitted, newsletter signup, PDF downloaded) — works whether
        // or not a caller exists, since the caller doesn't need to know
        // this plugin exists.
        add_action('bluelens_analytics_track', [__CLASS__, 'track_server_event'], 10, 3);
    }

    public static function register_routes() {
        register_rest_route('blue-lens-analytics/v1', '/track', [
            'methods'             => 'POST',
            'callback'            => [__CLASS__, 'handle_track_request'],
            'permission_callback' => '__return_true',
            'args'                => [
                'event_type' => ['required' => true, 'type' => 'string'],
            ],
        ]);
    }

    public static function handle_track_request(WP_REST_Request $request) {
        $event_type = sanitize_key($request->get_param('event_type'));
        $valid_types = array_keys(BlueLens_Analytics_Settings::event_labels());
        if (!in_array($event_type, $valid_types, true)) {
            return new WP_REST_Response(['success' => false, 'message' => 'Unknown event type'], 400);
        }

        $post_id = absint($request->get_param('post_id'));
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';

        $id = BlueLens_Analytics_DB::insert([
            'event_type'   => $event_type,
            'event_label'  => sanitize_text_field((string) $request->get_param('event_label')),
            'url'          => esc_url_raw((string) $request->get_param('url')),
            'post_id'      => $post_id ?: null,
            'session_id'   => sanitize_text_field((string) $request->get_param('session_id')),
            'visitor_hash' => BlueLens_Analytics_DB::visitor_hash(),
            'device_type'  => BlueLens_Analytics_DB::device_type(),
            'browser'      => BlueLens_Analytics_User_Agent::browser($ua),
            'os'           => BlueLens_Analytics_User_Agent::os($ua),
            'country'      => BlueLens_Analytics_DB::country(),
            'is_returning' => $request->get_param('is_returning') ? 1 : 0,
            'value'        => self::sanitize_value($request->get_param('value')),
            'referrer'     => esc_url_raw((string) $request->get_param('referrer')),
            'utm_source'   => sanitize_text_field((string) $request->get_param('utm_source')),
            'utm_medium'   => sanitize_text_field((string) $request->get_param('utm_medium')),
            'utm_campaign' => sanitize_text_field((string) $request->get_param('utm_campaign')),
        ]);

        return new WP_REST_Response(['success' => (bool) $id], $id ? 201 : 200);
    }

    /**
     * The generic numeric `value` column currently only carries
     * time-on-page seconds, but is validated as a plain bounded integer
     * rather than something event-specific — reject anything absurd
     * (a spoofed multi-day "duration") rather than trusting client input.
     */
    private static function sanitize_value($value) {
        if (null === $value || '' === $value) {
            return null;
        }
        return min(86400, absint($value));
    }

    public static function enqueue() {
        // Never track logged-in editors/admins browsing their own site —
        // keeps the numbers representing real visitors only.
        if (current_user_can('edit_posts')) {
            return;
        }
        $client_events = ['pageview', 'whatsapp_click', 'phone_click', 'email_click', 'cta_click', 'image_view', 'time_on_page', 'scroll_depth'];
        $any_enabled = false;
        foreach ($client_events as $event) {
            if (BlueLens_Analytics_Settings::is_event_enabled($event)) {
                $any_enabled = true;
                break;
            }
        }
        if (!$any_enabled) {
            return;
        }

        wp_enqueue_script(
            'blue-lens-analytics-tracker',
            BLUELENS_ANALYTICS_URI . 'assets/js/tracker.js',
            [],
            BLUELENS_ANALYTICS_VERSION,
            ['strategy' => 'defer', 'in_footer' => true]
        );

        $settings = [];
        foreach ($client_events as $event) {
            $settings[$event] = BlueLens_Analytics_Settings::is_event_enabled($event);
        }
        $settings['returning_visitor_detection'] = BlueLens_Analytics_Settings::is_behavior_enabled('returning_visitor_detection');

        wp_localize_script('blue-lens-analytics-tracker', 'blueLensAnalytics', [
            'restUrl'  => esc_url_raw(rest_url('blue-lens-analytics/v1/track')),
            'nonce'    => wp_create_nonce('wp_rest'),
            'postId'   => get_queried_object_id() ?: 0,
            'settings' => $settings,
        ]);
    }

    /**
     * Server-side event recording for actions that happen in a PHP
     * request rather than a page load (an inquiry saved, a PDF
     * generated) — no HTTP round trip needed since we're already
     * inside the request that caused the event.
     */
    public static function track_server_event($event_type, $label = '', $post_id = null) {
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';

        BlueLens_Analytics_DB::insert([
            'event_type'   => $event_type,
            'event_label'  => $label,
            'url'          => isset($_SERVER['HTTP_REFERER']) ? esc_url_raw(wp_unslash($_SERVER['HTTP_REFERER'])) : '',
            'post_id'      => $post_id,
            'session_id'   => isset($_POST['bluelens_session_id']) ? sanitize_text_field(wp_unslash($_POST['bluelens_session_id'])) : '',
            'visitor_hash' => BlueLens_Analytics_DB::visitor_hash(),
            'device_type'  => BlueLens_Analytics_DB::device_type(),
            'browser'      => BlueLens_Analytics_User_Agent::browser($ua),
            'os'           => BlueLens_Analytics_User_Agent::os($ua),
            'country'      => BlueLens_Analytics_DB::country(),
        ]);
    }
}
