<?php

if ( ! class_exists('rtTPGPMeta') ):

	class rtTPGPMeta {
		function __construct() {
			// actions
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		}

		function admin_enqueue_scripts() {
			global $pagenow, $typenow;

			// validate page
			if ( ! in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) ) {
				return;
			}
			if ( $typenow != rtTPG()->post_type ) {
				return;
			}

			// scripts
			wp_enqueue_script( array(
                'rt-pagination',
                'rt-jzoom',
                'rt-scrollbar',
                'rt-owl-carousel',
                'rt-magnific-popup',
			) );

			// styles
			wp_enqueue_style( array(
                'rt-scrollbar',
                'rt-owl-carousel',
                'rt-magnific-popup',
                'rt-owl-carousel-theme',
                'rt-tpg-pro-admin-preview',
			) );

		}

	}

endif;