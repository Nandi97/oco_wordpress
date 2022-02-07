<?php

if ( ! class_exists( 'rtTPGP' ) ) {

	class rtTPGP {
		public $options;
		public $post_type;
		public $assetsUrl;
		public $defaultSettings;

		protected static $_instance;

		function __construct() {
            if ($this->isRtTPGActive()) {
                $this->options = array(
                    'version' => RT_TPG_PRO_VERSION,
                    'installed_version' => 'rt_the_post_grid_current_version',
                    'slug' => RT_THE_POST_GRID_PRO_PLUGIN_SLUG
                );

                $this->libPath = dirname(__FILE__);
                $this->modelsPath = $this->libPath . '/models/';
                $this->classesPath = $this->libPath . '/classes/';
                $this->viewsPath = $this->libPath . '/views/';
                $this->templatePath = $this->libPath . '/templates/';
                $this->assetsUrl = RT_THE_POST_PRO_GRID_PLUGIN_URL . '/assets/';

                $this->rtLoadModel($this->modelsPath);
                $this->rtLoadClass($this->classesPath);

                add_filter('tlp_tpg_template_path', [$this, 'plugin_template_path']);
            } else {
                add_action('admin_notices', [ $this, 'requirement_notice' ]);
            }

		}

        /**
         * Get the plugin path.
         *
         * @return string
         */
        public function plugin_path() {
            return untrailingslashit(plugin_dir_path(__FILE__));
        }

        public function plugin_template_path() {
            return $this->plugin_path() . '/templates/';
        }

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

        function isRtTPGActive() {
            if(in_array('the-post-grid/the-post-grid.php', apply_filters('active_plugins', get_option('active_plugins')))){
                return true;
            }
            return false;
        }

        public function requirement_notice() {

            $class = 'notice notice-error';

            $text = esc_html__('The Post Grid', 'the-post-grid-pro');
            $link = esc_url(
                add_query_arg(
                    array(
                        'tab' => 'plugin-information',
                        'plugin' => 'the-post-grid',
                        'TB_iframe' => 'true',
                        'width' => '640',
                        'height' => '500',
                    ), admin_url('plugin-install.php')
                )
            );

            printf('<div class="%1$s"><p>The Post Grid Pro is not working because you need to install and activate <a class="thickbox open-plugin-details-modal" href="%2$s"><strong>%3$s</strong></a> plugin to get pro features.</p></div>', $class, $link, $text);

        }

		function rtLoadModel( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}
			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
				}
			}
		}

		function rtLoadClass( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}
			$classes = array();
			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
					$className = str_replace( ".php", "", $item );
					$classes[] = new $className;
				}
			}
			if ( $classes ) {
				foreach ( $classes as $class ) {
					$this->objects[] = $class;
				}
			}
		}

		/**
		 * @param       $viewName
		 * @param array $args
		 * @param bool  $return
		 *
		 * @return string|void
		 */
		function render_view( $viewName, $args = array(), $return = false ) {
			$path     = str_replace( ".", "/", $viewName );
			$viewPath = $this->viewsPath . $path . '.php';
			if ( ! file_exists( $viewPath ) ) {
				return;
			}
			if ( $args ) {
				extract( $args );
			}
			if ( $return ) {
				ob_start();
				include $viewPath;

				return ob_get_clean();
			}
			include $viewPath;
		}

		/**
		 * @param       $viewName
		 * @param array $args
		 * @param bool  $return
		 *
		 * @return string|void
		 */
		function render( $viewName, $args = array(), $return = false ) {

			$path = str_replace( ".", "/", $viewName );
			if ( $args ) {
				extract( $args );
			}
			$template = array(
				"the-post-grid-pro/{$path}.php"
			);

			if ( ! $template_file = locate_template( $template ) ) {
				$template_file = $this->templatePath . $path . '.php';
			}
			if ( ! file_exists( $template_file ) ) {
				return;
			}
			if ( $return ) {

				ob_start();
				include $template_file;

				return ob_get_clean();
			} else {

				include $template_file;
			}
		}


		/**
		 * Dynamically call any  method from models class
		 * by pluginFramework instance
		 */
		function __call( $name, $args ) {
			if ( ! is_array( $this->objects ) ) {
				return;
			}
			foreach ( $this->objects as $object ) {
				if ( method_exists( $object, $name ) ) {
					$count = count( $args );
					if ( $count == 0 ) {
						return $object->$name();
					} elseif ( $count == 1 ) {
						return $object->$name( $args[0] );
					} elseif ( $count == 2 ) {
						return $object->$name( $args[0], $args[1] );
					} elseif ( $count == 3 ) {
						return $object->$name( $args[0], $args[1], $args[2] );
					} elseif ( $count == 4 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3] );
					} elseif ( $count == 5 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4] );
					} elseif ( $count == 6 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4], $args[5] );
					}
				}
			}
		}

		/**
		 * @return bool
		 */
		public function is_valid_acf_version() {
			if(class_exists('acf_pro') && ACF_PRO){
				return version_compare(ACF_VERSION, '5.6.8', '>');
			}else{
				return version_compare(ACF_VERSION, '5.7.5', '>');
			}
		}
	}

	function rtTPGP() {
		return rtTPGP::instance();
	}

    rtTPGP();

}
