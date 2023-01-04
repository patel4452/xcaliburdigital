<?php
/**
* Wgl Elementor Extenstion
*
*
* @class        Wgl_Addons_Elementor
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/
define('WGL_ELEMENTOR_ADDONS_URL', plugins_url('/', __FILE__));
define('WGL_ELEMENTOR_ADDONS_PATH', plugin_dir_path(__FILE__));
define('WGL_ELEMENTOR_ADDONS_FILE', __FILE__);

if( ! class_exists('Wgl_Addons_Elementor') ) {

    class Wgl_Addons_Elementor {

        /**
         * Wgl Addons elementor dir path
         *
         * @since 1.0.0
         *
         * @var string The defualt path to elementor dir on this plugin.
         */
        private $dir_path;

        /**
         * 1st typography scheme.
         */
        public static $typography_1 = '1';

        /**
         * 2nd typography scheme.
         */
        public static $typography_2 = '2';

        /**
         * 3rd typography scheme.
         */
        public static $typography_3 = '3';

        /**
         * 4th typography scheme.
         */
        public static $typography_4 = '4';

        private static $instance = null;

        public function __construct() {

            $this->dir_path = plugin_dir_path(__FILE__);

            add_action( 'plugins_loaded', array( $this, 'elementor_setup' ) );


            add_action( 'elementor/init', array( $this, 'elementor_init' ) );

            add_action( 'elementor/init', array( $this, 'save_custom_schemes' ));

            add_action( 'elementor/init', array( $this, '_v_3_0_0_compatible' ));
        }


        /**
         * Installs default variables and checks if Elementor is installed
         *
         * @since 1.0.0
         * @access public
         *
         * @return void
         */
        public function elementor_setup() {

            // Check if Elementor installed and activated
            // https://developers.elementor.com/creating-an-extension-for-elementor/

            if ( ! did_action( 'elementor/loaded' ) ) {
                return;
            }

            // Include Modules files
            $this->includes();

            $this->init_addons();
        }

        /**
         * Include Files
         *
         * Load required core files.
         *
         * @since 1.0.0
         *
         * @access public
         */
        public function includes() {
            $this->init_helper_files();
        }

        /**
         * Require initial necessary files
         *
         * @since 1.0.0
         * @access public
         *
         * @return void
         */
        public function init_helper_files() {

            require_once ( $this->dir_path . 'includes/loop_settings.php' );
            require_once ( $this->dir_path . 'includes/icons_settings.php' );
            require_once ( $this->dir_path . 'includes/carousel_settings.php' );
            require_once ( $this->dir_path . 'includes/plugin_helper.php' );

            foreach ( glob( $this->dir_path . 'templates/' . '*.php' ) as $file ) {
                require_once ( $file );
            }
        }

        /**
         * Require initial necessary files
         *
         * @since 1.0.0
         * @access public
         *
         * @return void
         */
        public function init_modules_files() {
             foreach ( glob( $this->dir_path . 'modules/' . '*.php' ) as $file ) {

                $slug = basename( $file, '.php' );
                $this->register_modules_addon( $file );
            }

        }

        /**
         *
         * Register addon by file name.
         *
         * @since 1.0.0
         * @access public
         *
         * @param  string $file            File name.
         * @param  object $controls_manager Controls manager instance.
         *
         * @return void
         */
        public function register_modules_addon( $file ) {

            $base  = basename( str_replace( '.php', '', $file ) );
            $class = ucwords( str_replace( '-', ' ', $base ) );
            $class = str_replace( ' ', '_', $class );
            $class = sprintf( 'WglAddons\Modules\%s', $class );

            //Class File
            require_once ( $file );

            if ( class_exists( $class ) ) {
                new $class();
            }
        }



        /**
         * Load required file for addons integration
         *
         * @since 1.0.0
         * @access public
         *
         * @return void
         */
        public function init_addons() {

            add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_area' ) );
            add_action( 'elementor/controls/controls_registered', array( $this, 'controls_area'   ) );

            // Register Frontend Widget Scripts
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );

            // Register Backend Widget Scripts
            add_action( 'elementor/editor/before_enqueue_scripts'  , array( $this, 'extensions_scripts' ) );

            $this->init_modules_files();
        }

        /**
         * Load controls require function
         *
         * @since 1.0.0
         * @access public
         *
         */
        public function controls_area() {
            $this->controls_register();
        }

        /**
         * Requires controls files
         *
         * @since 1.0.0
         * @access private
         */
        private function controls_register() {

            foreach ( glob( $this->dir_path . 'controls/' . '*.php' ) as $file ) {

                $slug = basename( $file, '.php' );
                $this->register_controls_addon( $file );
            }
        }

        /**
         *
         * Register addon by file name.
         *
         * @since 1.0.0
         * @access public
         *
         * @param  string $file            File name.
         * @param  object $controls_manager Controls manager instance.
         *
         * @return void
         */
        public function register_controls_addon( $file ) {

            $controls_manager = \Elementor\Plugin::$instance->controls_manager;

            $base  = basename( str_replace( '.php', '', $file ) );
            $class = ucwords( str_replace( '-', ' ', $base ) );
            $class = str_replace( ' ', '_', $class );
            $class = sprintf( 'WglAddons\Controls\%s', $class );

            //Class File
            require_once ( $file );

            if ( class_exists( $class ) ) {
                $name_class = new $class();
                $controls_manager->register_control($name_class->get_type(), new $class );
            }
        }


        /**
         * Load widgets require function
         *
         * @since 1.0.0
         * @access public
         *
         */
        public function widgets_area() {
            $this->widgets_register();
        }

        /**
         * Requires widgets files
         *
         * @since 1.0.0
         * @access private
         */
        private function widgets_register() {

            foreach ( glob( $this->dir_path . 'widgets/' . '*.php' ) as $file ) {

                $slug = basename( $file, '.php' );
                $this->register_widgets_addon( $file );
            }

        }

        /**
         *
         * Register addon by file name.
         *
         * @since 1.0.0
         * @access public
         *
         * @param  string $file            File name.
         * @param  object $widgets_manager Widgets manager instance.
         *
         * @return void
         */
        public function register_widgets_addon( $file ) {

            $widget_manager = \Elementor\Plugin::instance()->widgets_manager;

            $base  = basename( str_replace( '.php', '', $file ) );
            $class = ucwords( str_replace( '-', ' ', $base ) );
            $class = str_replace( ' ', '_', $class );
            $class = sprintf( 'WglAddons\Widgets\%s', $class );

            //Class File
            require_once ( $file );

            if ( class_exists( $class ) ) {
                $widget_manager->register_widget_type( new $class );
            }
        }

        /**
         * Enqueue scripts.
         *
         * Enqueue all the widgets scripts.
         *
         * @since 1.0.0
         *
         * @access public
         */
        public function widget_scripts() {

            wp_register_script(
                'wgl-elementor-extensions-widgets',
                WGL_ELEMENTOR_ADDONS_URL . '/assets/js/wgl_elementor_widgets.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_register_script(
                'isotope',
                WGL_ELEMENTOR_ADDONS_URL . 'assets/js/isotope.pkgd.min.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_register_script(
                'appear',
                get_template_directory_uri() . '/js/jquery.appear.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_register_script(
                'slick',
                get_template_directory_uri() . '/js/slick.min.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_register_script(
                'jarallax',
                get_template_directory_uri() . '/js/jarallax.min.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_register_script(
                'jarallax-video',
                get_template_directory_uri() . '/js/jarallax-video.min.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_register_script(
                'coundown',
                get_template_directory_uri() . '/js/jquery.countdown.min.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_register_script(
                'cocoen',
                get_template_directory_uri() . '/js/cocoen.min.js',
                array('jquery'),
                '1.0.0',
                true
            );

        }

        /**
         * Elementor Init
         *
         * @since 1.0.0
         * @access public
         *
         * @return void
         */
        public function elementor_init() {

            \Elementor\Plugin::instance()->elements_manager->add_category(
                'wgl-extensions',
                array(
                    'title' => esc_html__('Wgl Extensions', 'inpulse-core')
                ),
            1);

        }

        public function extensions_scripts(){

            wp_enqueue_style( 'flaticon', get_template_directory_uri().'/fonts/flaticon/flaticon.css' );
        }

        public function save_custom_schemes(){

            if(!class_exists('\InPulse_Theme_Helper')){
                return;
            }

            $schemes_manager = new Elementor\Schemes_Manager();

            $header_font = \InPulse_Theme_Helper::get_option('header-font');
            $main_font   = \InPulse_Theme_Helper::get_option('main-font');

            $page_colors_switch = \InPulse_Theme_Helper::options_compare('page_colors_switch','mb_page_colors_switch','custom');
            $use_gradient_switch = \InPulse_Theme_Helper::options_compare('use-gradient','mb_page_colors_switch','custom');
            if ($page_colors_switch == 'custom') {
                $theme_color = \InPulse_Theme_Helper::options_compare('page_theme_color','mb_page_colors_switch','custom');
            } else {
                $theme_color = \InPulse_Theme_Helper::get_option('theme-custom-color');
            }

            $theme_fonts = array(
                '1' => [
                    'font_family' => esc_attr($header_font['font-family']),
                    'font_weight' => esc_attr($header_font['font-weight']),
                ],
                '2' => [
                    'font_family' => esc_attr($header_font['font-family']),
                    'font_weight' => esc_attr($header_font['font-weight']),
                ],
                '3' => [
                    'font_family' => esc_attr($main_font['font-family']),
                    'font_weight' => esc_attr($main_font['font-weight']),
                ],
                '4' => [
                    'font_family' => esc_attr($main_font['font-family']),
                    'font_weight' => esc_attr($main_font['font-weight']),
                ],
            );

            $scheme_obj_typo = $schemes_manager->get_scheme('typography');

            self::$typography_1 = $theme_fonts[1];
            self::$typography_2 = $theme_fonts[2];
            self::$typography_3 = $theme_fonts[3];
            self::$typography_4 = $theme_fonts[4];

            $theme_color = array(
                '1' => esc_attr($theme_color),
                '2' => esc_attr($header_font['color']),
                '3' => esc_attr($main_font['color']),
                '4' => esc_attr($theme_color),
            );

            $scheme_obj_color = $schemes_manager->get_scheme('color');

            //Save Options
            $scheme_obj_typo->save_scheme($theme_fonts);
            $scheme_obj_color->save_scheme($theme_color);

        }

        /**
         * Move WGL Theme Option settings to the Elementor global settings
         *
         * @since 1.0.0
         * @access public
         *
         * @return void
         */
        public function _v_3_0_0_compatible(){

            if(defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0', '>=' )){
                if(!$wgl_option = get_option('wgl_system_status')){
                    $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
                    $kit_id = (new \Elementor\Core\Kits\Manager())->get_active_id();

                    $meta_key = \Elementor\Core\Settings\Page\Manager::META_KEY;
                    $kit_settings = get_post_meta( $kit_id, $meta_key, true );

                    $wgl_settings = [];
                    $wgl_settings['container_width'] = [ 'unit' => 'px', 'size' => '1170' ];

                    $items_color = $this->_get_elementor_settings( 'system_colors' );
                    $items_fonts = $this->_get_elementor_settings( 'system_typography' );

                    $reduxArgs 		= new Redux;
                    $reduxArgs = $reduxArgs::$args;
                    $keys = array_keys($reduxArgs);
                    $opt_name = $keys[0];
                    $wgl_theme_option = get_option( $opt_name );

                    if(empty($wgl_theme_option)){
                        return;
                    }

                    $header_font = $wgl_theme_option['header-font'] ?? '';
                    $main_font   = $wgl_theme_option['main-font'] ?? '';
                    $theme_color = $wgl_theme_option['theme-custom-color'] ?? '';

                    $items_color[0]['color'] = esc_attr($theme_color);
                    $items_color[1]['color'] = esc_attr($header_font['color']);
                    $items_color[2]['color'] = esc_attr($main_font['color']);
                    $items_color[3]['color'] = esc_attr($theme_color);
                    $wgl_settings['system_colors'] = $items_color;

                    $items_fonts[0]['typography_font_family'] = esc_attr($header_font['font-family']);
                    $items_fonts[0]['typography_font_weight'] = esc_attr($header_font['font-weight']);
                    $items_fonts[1]['typography_font_family'] = esc_attr($header_font['font-family']);
                    $items_fonts[1]['typography_font_weight'] = esc_attr($header_font['font-weight']);
                    $items_fonts[2]['typography_font_family'] = esc_attr($main_font['font-family']);
                    $items_fonts[2]['typography_font_weight'] = esc_attr($main_font['font-weight']);
                    $items_fonts[3]['typography_font_family'] = esc_attr($main_font['font-family']);
                    $items_fonts[3]['typography_font_weight'] = esc_attr($main_font['font-weight']);

                    $wgl_settings['system_typography'] = $items_fonts;
                    update_option('elementor_element_wrappers_legacy_mode', '1');
                    update_option( 'elementor_disable_typography_schemes', 'yes' );
                    update_option( 'disable_typography_schemes', 'yes' );
                    update_option('wgl_system_status', 'yes');

                    if ( ! $kit_settings ) {
                        update_metadata( 'post', $kit_id, $meta_key, $wgl_settings );
                    }else{
                        $kit_settings = array_merge( $kit_settings, $wgl_settings );
                        $page_settings_manager->save_settings( $kit_settings, $kit_id );
                    }

                    \Elementor\Plugin::$instance->files_manager->clear_cache();
                }
            }else{
                if(!$wgl_option = get_option('wgl_system_status_old_e')){
                    update_option( 'elementor_disable_typography_schemes', 'yes' );
                    update_option( 'disable_typography_schemes', 'yes' );
                    update_option('wgl_system_status_old_e', 'yes');
                    \Elementor\Plugin::$instance->files_manager->clear_cache();
                }
            }
        }

        public function _get_elementor_settings( $value = 'system_colors' ){

            $kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();

            $system_items = $kit->get_settings_for_display( $value );

            if ( ! $system_items ) {
                $system_items = [];
            }

            return $system_items;
        }

        /**
         * Creates and returns an instance of the class
         *
         * @since 1.0.0
         * @access public
         *
         * @return object
         */
        public static function get_instance() {
            if( self::$instance == null ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

    }
}

if ( ! function_exists( 'wgl_addons_elementor' ) ) {

    function wgl_addons_elementor() {
        return Wgl_Addons_Elementor::get_instance();
    }
}

wgl_addons_elementor();
?>