<?php
/**
 * wp-admin menu registration.
 *
 * @package BlueLens_Analytics_Suite
 */

if (!defined('ABSPATH')) {
    exit;
}

class BlueLens_Analytics_Admin_Menu {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'register']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue']);
    }

    public static function register() {
        $cap = 'manage_options';

        add_menu_page(
            __('Blue-Lens Analytics', 'blue-lens-analytics-suite'),
            __('Blue-Lens Analytics', 'blue-lens-analytics-suite'),
            $cap,
            'blue-lens-analytics',
            ['BlueLens_Analytics_Dashboard', 'render'],
            BLUELENS_ANALYTICS_URI . 'assets/images/icon.png',
            26
        );

        add_submenu_page('blue-lens-analytics', __('Dashboard', 'blue-lens-analytics-suite'), __('Dashboard', 'blue-lens-analytics-suite'), $cap, 'blue-lens-analytics', ['BlueLens_Analytics_Dashboard', 'render']);
        add_submenu_page('blue-lens-analytics', __('Settings', 'blue-lens-analytics-suite'), __('Settings', 'blue-lens-analytics-suite'), $cap, 'blue-lens-analytics-settings', [__CLASS__, 'render_settings']);
        add_submenu_page('blue-lens-analytics', __('Integrations', 'blue-lens-analytics-suite'), __('Integrations', 'blue-lens-analytics-suite'), $cap, 'blue-lens-analytics-integrations', ['BlueLens_Analytics_Integrations', 'render_page']);
    }

    public static function enqueue($hook) {
        if (strpos($hook, 'blue-lens-analytics') === false) {
            return;
        }
        wp_enqueue_style('blue-lens-analytics-admin', BLUELENS_ANALYTICS_URI . 'assets/css/admin.css', [], BLUELENS_ANALYTICS_VERSION);

        // The dark/light toggle lives in the brand header, which is on
        // every screen this plugin renders — not just the Dashboard.
        wp_enqueue_script('blue-lens-analytics-theme-toggle', BLUELENS_ANALYTICS_URI . 'assets/js/theme-toggle.js', [], BLUELENS_ANALYTICS_VERSION, true);

        // The widget grid (Chart.js + dashboard.js) is only needed on
        // the Dashboard screen itself — Settings/Integrations stay light.
        if ('toplevel_page_blue-lens-analytics' !== $hook) {
            return;
        }

        wp_enqueue_script('blue-lens-analytics-chartjs', BLUELENS_ANALYTICS_URI . 'assets/js/vendor/chart.umd.min.js', [], '4.5.1', true);
        // Depends on theme-toggle.js too (not just chartjs): dashboard.js
        // registers its own document click listener for the toggle and
        // relies on theme-toggle.js's listener having already flipped
        // the .bla-theme-dark class — same-element listeners fire in
        // registration order, which this dependency guarantees.
        wp_enqueue_script('blue-lens-analytics-dashboard', BLUELENS_ANALYTICS_URI . 'assets/js/dashboard.js', ['blue-lens-analytics-chartjs', 'blue-lens-analytics-theme-toggle'], BLUELENS_ANALYTICS_VERSION, true);

        $catalog = [];
        foreach (BlueLens_Analytics_Widgets::available_widgets() as $key => $def) {
            $catalog[$key] = [
                'label'    => $def['label'],
                'category' => $def['category'],
                'icon'     => $def['icon'],
                'supports' => $def['supports'],
                'default'  => $def['default'],
            ];
        }

        wp_localize_script('blue-lens-analytics-dashboard', 'blueLensAnalyticsDashboard', [
            'ajaxUrl'         => admin_url('admin-ajax.php'),
            'nonce'           => wp_create_nonce('bluelens_analytics_dashboard'),
            'range'           => BlueLens_Analytics_DB::date_range()['range'],
            'catalog'         => $catalog,
            'chartTypeLabels' => [
                'line'     => __('Line', 'blue-lens-analytics-suite'),
                'bar'      => __('Bar', 'blue-lens-analytics-suite'),
                'pie'      => __('Pie', 'blue-lens-analytics-suite'),
                'doughnut' => __('Donut', 'blue-lens-analytics-suite'),
                'table'    => __('Table', 'blue-lens-analytics-suite'),
                'list'     => __('List', 'blue-lens-analytics-suite'),
                'kpi'      => __('Number', 'blue-lens-analytics-suite'),
            ],
            'palette' => [
                'categorical'   => ['#2a78d6', '#eb6834', '#1baf7a', '#eda100', '#e87ba4', '#008300', '#4a3aa7', '#e34948'],
                'sequential'    => ['#cde2fb', '#9ec5f4', '#6da7ec', '#3987e5', '#2a78d6', '#1c5cab', '#104281'],
                'surface'       => '#fcfcfb',
                'gridline'      => '#e1e0d9',
                'textPrimary'   => '#0b0b0b',
                'textSecondary' => '#52514e',
                'textMuted'     => '#898781',
            ],
            // Same validated categorical/sequential hues in both themes —
            // only the chrome (surface/gridline/text) flips for dark mode,
            // since Chart.js draws to canvas and won't pick up the CSS
            // theme class on its own (dashboard.js re-renders on toggle).
            'paletteDark' => [
                'categorical'   => ['#2a78d6', '#eb6834', '#1baf7a', '#eda100', '#e87ba4', '#008300', '#4a3aa7', '#e34948'],
                'sequential'    => ['#cde2fb', '#9ec5f4', '#6da7ec', '#3987e5', '#2a78d6', '#1c5cab', '#104281'],
                'surface'       => '#1b1e29',
                'gridline'      => '#343850',
                'textPrimary'   => '#f3f4f7',
                'textSecondary' => '#c7c9d6',
                'textMuted'     => '#9093a8',
            ],
        ]);
    }

    /**
     * Shared logo + title banner used at the top of every screen this
     * plugin renders, so the brand is immediately recognizable and
     * distinguishable from other admin pages/plugins at a glance.
     */
    public static function brand_header($subtitle) {
        ?>
        <script>(function(){try{var t=localStorage.getItem('blueLensAnalyticsTheme');if(!t){t=(window.matchMedia&&window.matchMedia('(prefers-color-scheme: dark)').matches)?'dark':'light';}if('dark'===t){document.currentScript.closest('.wrap').classList.add('bla-theme-dark');}}catch(e){}})();</script>
        <div class="bla-brand-header">
            <img src="<?php echo esc_url(BLUELENS_ANALYTICS_URI . 'assets/images/logo-full.png'); ?>" alt="<?php esc_attr_e('Blue-Lens Analytics', 'blue-lens-analytics-suite'); ?>" class="bla-brand-header__logo">
            <div>
                <h1><?php echo esc_html($subtitle); ?></h1>
                <p class="bla-brand-header__credit"><?php echo esc_html(sprintf(
                    /* translators: %s: plugin version number */
                    __('Blue-Lens Analytics Suite v%s — developed by Bernard Ogak', 'blue-lens-analytics-suite'),
                    BLUELENS_ANALYTICS_VERSION
                )); ?></p>
            </div>
            <button type="button" class="bla-theme-toggle" role="switch" aria-checked="false" aria-label="<?php esc_attr_e('Toggle dark mode', 'blue-lens-analytics-suite'); ?>" title="<?php esc_attr_e('Toggle dark/light mode', 'blue-lens-analytics-suite'); ?>">
                <span class="bla-theme-toggle__thumb" aria-hidden="true"></span>
            </button>
        </div>
        <?php
    }

    public static function render_settings() {
        if (!current_user_can('manage_options')) {
            return;
        }
        $labels = BlueLens_Analytics_Settings::event_labels();
        $current = BlueLens_Analytics_Settings::get_all();
        ?>
        <div class="wrap blue-lens-analytics-wrap">
            <?php self::brand_header(__('Settings', 'blue-lens-analytics-suite')); ?>
            <p class="description"><?php esc_html_e('Turn individual metrics on or off. Disabled metrics are never written to the database. Logged-in editors/admins are never tracked.', 'blue-lens-analytics-suite'); ?></p>
            <form method="post" action="options.php">
                <?php settings_fields('bluelens_analytics_settings_group'); ?>
                <table class="form-table" role="presentation">
                    <?php foreach ($labels as $key => $label) : ?>
                    <tr>
                        <th scope="row"><?php echo esc_html($label); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="bluelens_analytics_settings[<?php echo esc_attr($key); ?>]" value="1" <?php checked($current[$key]); ?>>
                                <?php esc_html_e('Enabled', 'blue-lens-analytics-suite'); ?>
                            </label>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <h2><?php esc_html_e('Behavior & Privacy', 'blue-lens-analytics-suite'); ?></h2>
                <p class="description"><?php esc_html_e('These shape how tracking behaves rather than gating one event type.', 'blue-lens-analytics-suite'); ?></p>
                <table class="form-table" role="presentation">
                    <?php foreach (BlueLens_Analytics_Settings::behavior_labels() as $key => $label) : ?>
                    <tr>
                        <th scope="row"><?php esc_html_e('Returning Visitor Detection', 'blue-lens-analytics-suite'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="bluelens_analytics_settings[<?php echo esc_attr($key); ?>]" value="1" <?php checked($current[$key]); ?>>
                                <?php esc_html_e('Enabled', 'blue-lens-analytics-suite'); ?>
                            </label>
                            <p class="description"><?php echo esc_html($label); ?></p>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
