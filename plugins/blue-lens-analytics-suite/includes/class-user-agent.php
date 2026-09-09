<?php
/**
 * Lightweight User-Agent parsing — just enough to bucket visits into
 * the browser/OS families the dashboard reports on. Parsed once at
 * insert time (see BlueLens_Analytics_Tracker) so reporting queries never
 * re-parse raw UA strings.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_User_Agent {

    /**
     * @param string $ua Raw User-Agent header value.
     * @return string One of: Bot, Edge, Opera, Samsung Internet, Chrome,
     *                 Firefox, Safari, Internet Explorer, Other.
     */
    public static function browser($ua) {
        $ua = (string) $ua;

        if ('' === $ua) {
            return 'Other';
        }
        if (preg_match('/bot|crawl|spider|slurp|bingpreview|facebookexternalhit|whatsapp|googlebot/i', $ua)) {
            return 'Bot';
        }

        // Order matters: several browsers embed "Chrome" or "Safari" in
        // their own UA string, so the more specific tokens are checked
        // first.
        $map = [
            'Edge'              => '/Edg\/|EdgA\/|EdgiOS\//',
            'Opera'             => '/OPR\/|Opera\//',
            'Samsung Internet'  => '/SamsungBrowser\//',
            'Firefox'           => '/Firefox\/|FxiOS\//',
            'Internet Explorer' => '/MSIE |Trident\//',
            'Chrome'            => '/Chrome\/|CriOS\//',
            'Safari'            => '/Safari\//',
        ];

        foreach ($map as $name => $pattern) {
            if (preg_match($pattern, $ua)) {
                return $name;
            }
        }

        return 'Other';
    }

    /**
     * @param string $ua Raw User-Agent header value.
     * @return string One of: Windows, macOS, iOS, Android, Linux,
     *                 Chrome OS, Other.
     */
    public static function os($ua) {
        $ua = (string) $ua;

        if ('' === $ua) {
            return 'Other';
        }

        $map = [
            'iOS'      => '/iPhone|iPad|iPod/',
            'Android'  => '/Android/',
            'Chrome OS' => '/CrOS/',
            'Windows'  => '/Windows NT/',
            'macOS'    => '/Macintosh|Mac OS X/',
            'Linux'    => '/Linux/',
        ];

        foreach ($map as $name => $pattern) {
            if (preg_match($pattern, $ua)) {
                return $name;
            }
        }

        return 'Other';
    }
}
