<?php

if (!class_exists('rtTPGPShortCode')):

    class rtTPGPShortCode {

        function __construct() {
            add_action('wp_footer', array($this, 'register_sc_scripts'), 15);
            add_action('tpg_after_script', [$this, 'load_sc_style'], 12);
        }

        function register_sc_scripts() {

            $script = array();

            array_push($script, 'jquery');
            $ajaxurl = '';
            if (in_array('sitepress-multilingual-cms/sitepress.php', get_option('active_plugins'))) {
                $ajaxurl .= admin_url('admin-ajax.php?lang=' . ICL_LANGUAGE_CODE);
            } else {
                $ajaxurl .= admin_url('admin-ajax.php');
            }
            $variables = array(
                'nonceID' => rtTPG()->nonceId(),
                'nonce'   => wp_create_nonce(rtTPG()->nonceText()),
                'ajaxurl' => $ajaxurl
            );
            array_push($script, 'rt-pagination');
            array_push($script, 'rt-owl-carousel');
            array_push($script, 'rt-scrollbar');
            array_push($script, 'rt-magnific-popup');
            if (class_exists('WooCommerce')) {
                array_push($script, 'rt-jzoom');
            }
            array_push($script, 'rt-tpg-pro');

            wp_enqueue_script($script);
            wp_localize_script('rt-tpg-pro', 'rttpg', $variables);

        }

        function load_sc_style() {
            $settings = get_option(rtTPG()->options['settings']);

            $style = array();

            if (isset($settings['tpg_load_script'])) {
                array_push($style, 'rt-tpg-pro');
            }
            array_push($style, 'rt-owl-carousel');
            array_push($style, 'rt-owl-carousel-theme');
            array_push($style, 'rt-scrollbar');
            array_push($style, 'rt-fontawsome');
            array_push($style, 'rt-magnific-popup');
            if (is_rtl()) {
                array_push($style, 'rt-tpg-rtl');
            }
            wp_enqueue_style($style);
        }
    }
endif;