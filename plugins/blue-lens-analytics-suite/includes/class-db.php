<?php
/**
 * Database layer — one events table, indexed for the queries the
 * dashboard actually runs (by type, by date range, by post).
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_DB {

    public static function table() {
        global $wpdb;
        return $wpdb->prefix . BLUELENS_ANALYTICS_TABLE_EVENTS;
    }

    public static function install() {
        global $wpdb;
        $table = self::table();
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$table} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            event_type VARCHAR(40) NOT NULL,
            event_label VARCHAR(255) NULL,
            url VARCHAR(500) NULL,
            post_id BIGINT UNSIGNED NULL,
            session_id VARCHAR(64) NULL,
            visitor_hash VARCHAR(64) NULL,
            device_type VARCHAR(20) NULL,
            browser VARCHAR(30) NULL,
            os VARCHAR(30) NULL,
            country CHAR(2) NULL,
            is_returning TINYINT(1) NOT NULL DEFAULT 0,
            value BIGINT NULL,
            referrer VARCHAR(500) NULL,
            utm_source VARCHAR(100) NULL,
            utm_medium VARCHAR(100) NULL,
            utm_campaign VARCHAR(100) NULL,
            created_at DATETIME NOT NULL,
            PRIMARY KEY  (id),
            KEY event_type (event_type),
            KEY created_at (created_at),
            KEY session_id (session_id),
            KEY post_id (post_id),
            KEY country (country),
            KEY browser (browser)
        ) {$charset_collate};";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        update_option('bluelens_analytics_db_version', BLUELENS_ANALYTICS_VERSION);
    }

    /**
     * Insert one event. Called both from the front-end beacon endpoint
     * and directly from server-side hooks (inquiry submitted, PDF
     * downloaded, etc).
     *
     * @param array $data
     * @return int|false Inserted row ID, or false if this event type is
     *                    disabled in Settings.
     */
    public static function insert($data) {
        if (!BlueLens_Analytics_Settings::is_event_enabled($data['event_type'] ?? '')) {
            return false;
        }

        global $wpdb;
        $defaults = [
            'event_type'   => '',
            'event_label'  => '',
            'url'          => '',
            'post_id'      => null,
            'session_id'   => '',
            'visitor_hash' => '',
            'device_type'  => '',
            'browser'      => '',
            'os'           => '',
            'country'      => '',
            'is_returning' => 0,
            'value'        => null,
            'referrer'     => '',
            'utm_source'   => '',
            'utm_medium'   => '',
            'utm_campaign' => '',
            'created_at'   => current_time('mysql'),
        ];
        $row = wp_parse_args($data, $defaults);

        $wpdb->insert(self::table(), $row, [
            '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s',
        ]);

        return $wpdb->insert_id;
    }

    /**
     * Pseudonymous, privacy-friendly visitor identifier: a one-way hash
     * of IP + user agent + a salt that rotates daily, so the same
     * device produces a stable hash within a day (for unique-visitor
     * counting) but it cannot be reversed to an IP and does not persist
     * long-term the way a tracking cookie would.
     */
    public static function visitor_hash() {
        $ip  = self::client_ip();
        $ua  = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';
        $salt = wp_hash(gmdate('Y-m-d') . 'blue-lens-analytics');
        return hash('sha256', $ip . '|' . $ua . '|' . $salt);
    }

    private static function client_ip() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        return is_string($ip) ? $ip : '';
    }

    public static function device_type() {
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower(sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT']))) : '';
        if (preg_match('/tablet|ipad/', $ua)) {
            return 'tablet';
        }
        if (preg_match('/mobile|android|iphone/', $ua)) {
            return 'mobile';
        }
        return 'desktop';
    }

    /**
     * Two-letter visitor country, read from whichever reverse-proxy geo
     * header the host already sets (Cloudflare, CloudFront, or a
     * generic X-Country-Code some hosts add). No outbound network call
     * is made — if none of these headers are present (no such proxy in
     * front of the site) this returns '' and the visit is simply not
     * counted toward any country, keeping the plugin's no-third-party
     *-calls posture intact.
     */
    public static function country() {
        $headers = ['HTTP_CF_IPCOUNTRY', 'HTTP_X_COUNTRY_CODE', 'HTTP_CLOUDFRONT_VIEWER_COUNTRY'];
        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $code = strtoupper(sanitize_text_field(wp_unslash($_SERVER[$header])));
                if (preg_match('/^[A-Z]{2}$/', $code) && 'XX' !== $code) {
                    return $code;
                }
            }
        }
        return '';
    }

    /**
     * Shared date-range parsing used by both the dashboard and the
     * widget metrics layer, so a range like "30d" always resolves to
     * the same start/end boundaries everywhere in the plugin.
     */
    public static function date_range($range = null) {
        $range = $range ?? (isset($_GET['range']) ? sanitize_key(wp_unslash($_GET['range'])) : '7d');
        $today = current_time('Y-m-d');

        switch ($range) {
            case 'today':
                $start = $today;
                break;
            case '30d':
                $start = gmdate('Y-m-d', strtotime($today . ' -29 days'));
                break;
            case '90d':
                $start = gmdate('Y-m-d', strtotime($today . ' -89 days'));
                break;
            case '7d':
            default:
                $range = '7d';
                $start = gmdate('Y-m-d', strtotime($today . ' -6 days'));
                break;
        }

        return ['range' => $range, 'start' => $start . ' 00:00:00', 'end' => $today . ' 23:59:59', 'start_date' => $start, 'end_date' => $today];
    }
}
