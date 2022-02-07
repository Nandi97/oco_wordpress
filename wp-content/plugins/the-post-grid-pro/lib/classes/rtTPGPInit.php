<?php

if (!class_exists('rtTPGPInit')):
    class rtTPGPInit {

        private $version;

        function __construct() {
            $this->version = defined('WP_DEBUG') && WP_DEBUG ? time() : RT_TPG_PRO_VERSION;
            add_action('plugins_loaded', array($this, 'the_post_grid_load_text_domain'));
            add_action('admin_menu', [$this, 'tpg_admin_menu']);
            add_action('init', array($this, 'init'), 15);
            register_activation_hook(RT_THE_POST_GRID_PRO_PLUGIN_ACTIVE_FILE_NAME, array($this, 'activate'));
            register_deactivation_hook(RT_THE_POST_GRID_PRO_PLUGIN_ACTIVE_FILE_NAME, array($this, 'deactivate'));
        }

        public function the_post_grid_load_text_domain() {
            load_plugin_textdomain('the-post-grid-pro', false, RT_THE_POST_GRID_PRO_LANGUAGE_PATH);
        }

        function activate() {

        }

        function deactivate() {

        }

        public function init() {
            wp_deregister_script('rt-tpg');
            wp_dequeue_script('rt-tpg');

            $scripts = array();
            $styles = array();

            $styles['rt-scrollbar'] = rtTPGP()->assetsUrl . 'vendor/scrollbar/jquery.mCustomScrollbar.min.css';
            $styles['rt-magnific-popup'] = rtTPGP()->assetsUrl . 'vendor/Magnific-Popup/magnific-popup.css';
            $styles['rt-owl-carousel'] = rtTPGP()->assetsUrl . 'vendor/owl-carousel/owl.carousel.min.css';
            $styles['rt-owl-carousel-theme'] = rtTPGP()->assetsUrl . 'vendor/owl-carousel/owl.theme.default.min.css';
            $styles['rt-tpg-pro'] = rtTPGP()->assetsUrl . 'css/thepostgrid.css';

            $scripts[] = array(
                'handle' => 'rt-jzoom',
                'src'    => rtTPGP()->assetsUrl . "js/jzoom.min.js",
                'deps'   => array('jquery'),
                'footer' => true
            );
            $scripts[] = array(
                'handle'  => 'jquery-mousewheel',
                'src'     => rtTPGP()->assetsUrl . "vendor/jquery.mousewheel.min.js",
                'deps'    => array('jquery'),
                'footer'  => true,
                'version' => '3.1.13'
            );
            $scripts[] = array(
                'handle'  => 'rt-scrollbar',
                'src'     => rtTPGP()->assetsUrl . "vendor/scrollbar/jquery.mCustomScrollbar.min.js",
                'deps'    => array('jquery', 'jquery-mousewheel'),
                'footer'  => true,
                'version' => '3.1.5'
            );
            $scripts[] = array(
                'handle' => 'rt-magnific-popup',
                'src'    => rtTPGP()->assetsUrl . "vendor/Magnific-Popup/jquery.magnific-popup.min.js",
                'deps'   => array('jquery'),
                'footer' => true
            );
            $scripts[] = array(
                'handle' => 'rt-owl-carousel',
                'src'    => rtTPGP()->assetsUrl . "vendor/owl-carousel/owl.carousel.min.js",
                'deps'   => array('jquery'),
                'footer' => true
            );
            $scripts[] = array(
                'handle' => 'rt-pagination',
                'src'    => rtTPGP()->assetsUrl . "js/pagination.min.js",
                'deps'   => array('jquery'),
                'footer' => true
            );
            $scripts[] = array(
                'handle' => 'rt-tpg-pro',
                'src'    => rtTPGP()->assetsUrl . "js/rttpg.js",
                'deps'   => array('jquery'),
                'footer' => true
            );

            if (is_admin()) {
                $scripts[] = array(
                    'handle' => 'tpg-admin-taxonomy',
                    'src'    => rtTPGP()->assetsUrl . "js/admin-taxonomy.js",
                    'deps'   => array('jquery'),
                    'footer' => true
                );
                $styles['rt-tpg-pro-admin-preview'] = rtTPGP()->assetsUrl . 'css/admin-preview.css';
            }

            foreach ($scripts as $script) {
                wp_register_script($script['handle'], $script['src'], $script['deps'], isset($script['version']) ? $script['version'] : $this->version, $script['footer']);
            }

            foreach ($styles as $k => $v) {
                wp_register_style($k, $v, false, isset($styles['version']) ? $styles['version'] : $this->version);
            }

        }

        public function tpg_admin_menu() {
            add_submenu_page('edit.php?post_type=' . rtTPG()->post_type, __('Taxonomy Order', "the-post-grid-pro"),
                __('Taxonomy Order', "the-post-grid-pro"), 'administrator', 'tgp_taxonomy_order',
                array($this, 'tpg_menu_page_taxonomy_order'));
        }

        function tpg_menu_page_taxonomy_order() {
            rtTPGP()->render_view('taxonomy-order');
        }

    }
endif;