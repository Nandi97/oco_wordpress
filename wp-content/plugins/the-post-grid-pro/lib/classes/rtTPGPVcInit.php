<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists('rtTPGPVcInit') ):

	class rtTPGPVcInit {

		function __construct() {
			if ( ! defined( 'WPB_VC_VERSION' ) ) {
				return;
			}
			add_action( 'vc_before_init', array( $this, 'postGridIntegration' ) );
		}

		function scListA(){
			$sc = array();
			$scQ = get_posts( array('post_type' => 'rttpg', 'order_by' => 'title', 'order' => 'DESC', 'post_status' => 'publish', 'posts_per_page' => -1) );
			$sc['Default'] = '';
			if ( count($scQ) ) {
				foreach($scQ as $post){
					$sc[$post->post_title] = $post->ID;
				}
			}
			return $sc;
		}


		function postGridIntegration() {

			vc_map( array(
					"name" => __("The Post Grid", 'the-post-grid'),
					"base" => 'the-post-grid',
					"class" => "",
					"icon"      => RT_THE_POST_GRID_PLUGIN_URL . '/assets/images/icon-32x32.png',
					"controls" => "full",
					"category" => 'Content',
					'admin_enqueue_js' => '',
					'admin_enqueue_css' => '',
					"params" => array(
						array(
							"type" => "dropdown",
							"heading" => __("Short Code", 'the-post-grid'),
							"param_name" => "id",
							"value" => $this->scListA(),
							"admin_label" => true,
							"description" => __("Short Code list", 'the-post-grid')
						)
					)
				)

			);
		}
	}

endif;