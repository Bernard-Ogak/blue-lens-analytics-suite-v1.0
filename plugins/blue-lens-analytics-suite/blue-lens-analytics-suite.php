<?php
/**
 * Plugin Name: Blue-Lens Analytics Suite
 * Description: First-party analytics, KPI dashboard, and reporting for your WordPress site. Tracks pageviews, WhatsApp/phone/email clicks, form submissions, and custom conversion events entirely in the WordPress database — no external accounts required. Google Analytics 4, Search Console, Google/Meta Ads, Clarity, HubSpot, and Google Sheets/Power BI/Tableau exports are a documented Phase 2 (see Settings → Integrations) pending API credentials.
 * Version: 1.0.0
 * Author: Bernard Ogak
 * Text Domain: blue-lens-analytics-suite
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

define('BLUELENS_ANALYTICS_VERSION', '1.0.0');
define('BLUELENS_ANALYTICS_DIR', plugin_dir_path(__FILE__));
define('BLUELENS_ANALYTICS_URI', plugin_dir_url(__FILE__));
define('BLUELENS_ANALYTICS_TABLE_EVENTS', 'bluelens_analytics_events');

require_once BLUELENS_ANALYTICS_DIR . 'includes/class-db.php';
require_once BLUELENS_ANALYTICS_DIR . 'includes/class-user-agent.php';
require_once BLUELENS_ANALYTICS_DIR . 'includes/class-tracker.php';
require_once BLUELENS_ANALYTICS_DIR . 'includes/class-settings.php';

// One class per dashboard widget (includes/widgets/), discovered by
// BlueLens_Analytics_Widget_Registry — load the abstract base first,
// then every concrete widget, then the registry and the orchestrator
// that uses it.
require_once BLUELENS_ANALYTICS_DIR . 'includes/widgets/class-widget-base.php';
foreach (glob(BLUELENS_ANALYTICS_DIR . 'includes/widgets/class-widget-*.php') as $bluelens_widget_file) {
    if ('class-widget-base.php' !== basename($bluelens_widget_file)) {
        require_once $bluelens_widget_file;
    }
}
unset($bluelens_widget_file);
require_once BLUELENS_ANALYTICS_DIR . 'includes/class-widget-registry.php';
require_once BLUELENS_ANALYTICS_DIR . 'includes/class-widgets.php';
require_once BLUELENS_ANALYTICS_DIR . 'includes/class-admin-menu.php';
require_once BLUELENS_ANALYTICS_DIR . 'includes/class-dashboard.php';
require_once BLUELENS_ANALYTICS_DIR . 'includes/class-export.php';
require_once BLUELENS_ANALYTICS_DIR . 'includes/class-integrations.php';

register_activation_hook(__FILE__, ['BlueLens_Analytics_DB', 'install']);

add_action('plugins_loaded', function () {
    BlueLens_Analytics_Settings::init();
    BlueLens_Analytics_Tracker::init();
    BlueLens_Analytics_Widgets::init();
    BlueLens_Analytics_Admin_Menu::init();
    BlueLens_Analytics_Integrations::init();
    BlueLens_Analytics_Export::init();
});
