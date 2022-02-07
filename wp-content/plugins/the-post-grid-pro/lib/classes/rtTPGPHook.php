<?php
if (!class_exists('rtTPGPHook')):
    class rtTPGPHook {

        function __construct() {
            add_action('tpg_settings_tab_title', [$this, 'settings_tab_title']);
            add_action('tpg_settings_tab_content', [$this, 'settings_tab_content']);

            add_filter('rt_tpg_advanced_filters', [$this, 'rtTPAdvanceFilters'] );
            add_filter('rt_tpg_layout_options', [$this, 'rtTPGLayoutSettingFields'] );
            add_filter('rt_tpg_style_fields', [$this, 'rtTPGStyleFields'] );
            add_filter('tpg_layouts', [$this, 'rtTPGLayouts']);
            add_filter('tpg_image_sizes', [$this, 'custom_image_size']);
            add_filter('tpg_field_selection_items', [$this, 'field_selection_items']);
            add_filter('tpg_get_post_type', [$this, 'rtPostTypes']);
            add_filter('rt_tpg_post_orderby', [$this, 'rtPostOrderBy'], 10, 3);
        }

        public function settings_tab_title($last_tab) {
            printf('<li%s><a href="#plugin-license">%s</a></li>', $last_tab == "plugin-license" ? ' class="active"' : '',
                __( 'Plugin License', 'the-post-grid' ));
        }

        public function settings_tab_content($last_tab) {
            $html = sprintf( '<div id="plugin-license" class="rt-tab-content"%s>', $last_tab == "plugin-license" ? ' style="display:block"' : '' );
            $html .= rtTPG()->rtFieldGenerator( rtTPG()->rtTPGLicenceField() );
            $html .= '</div>';

            echo $html;
        }

        public function rtTPAdvanceFilters($fields) {
            return array_merge($fields, [
               'date_range' => __('Date Range', 'the-post-grid-pro'),
            ]);
        }

        public function rtPostTypes($args) {
            unset($args['_builtin']);
            $args['public'] = true;

            return $args;
        }

        public function rtPostOrderBy($orderBy, $isWoCom, $metaOrder) {

            $orderBy['rand'] = __("Random", 'the-post-grid-pro');
            $orderBy['comment_count'] = __("Number of comments", 'the-post-grid-pro');

            $wooOrder = array(
                "price"  => __("Price", 'the-post-grid-pro'),
                "rating" => __("AVG Rating", 'the-post-grid-pro')
            );

            $orderBy = $isWoCom ? array_merge($orderBy, $wooOrder) : $orderBy;
            $orderBy = $metaOrder ? array_merge($orderBy, rtTPG()->rtMetaKeyType()) : $orderBy;

            return $orderBy;
        }

        public function rtTPGLayouts($layouts) {
            unset($layouts['isotope1']);
            $layouts['layout4'] = __("Layout 4", "the-post-grid-pro");
            $layouts['layout5'] = __("Layout 5", "the-post-grid-pro");
            $layouts['layout6'] = __("Layout 6", "the-post-grid-pro");
            $layouts['layout7'] = __("Layout 7", "the-post-grid-pro");
            $layouts['layout8'] = __("Layout 8", "the-post-grid-pro");
            $layouts['layout9'] = __("Layout 9", "the-post-grid-pro");
            $layouts['layout10'] = __("Layout 10", "the-post-grid-pro");
            $layouts['layout11'] = __("Layout 11", "the-post-grid-pro");
            $layouts['layout12'] = __("Layout 12", "the-post-grid-pro");
            $layouts['layout13'] = __("Layout 13", "the-post-grid-pro");
            $layouts['layout14'] = __("Layout 14", "the-post-grid-pro");
            $layouts['layout15'] = __("Layout 15", "the-post-grid-pro");
            $layouts['layout16'] = __("Layout 16", "the-post-grid-pro");
            $layouts['layout17'] = __("Layout 17 Gallery layout", "the-post-grid-pro");
            $layouts['offset01'] = __("Offset 01", "the-post-grid-pro");
            $layouts['offset02'] = __("Offset 02", "the-post-grid-pro");
            $layouts['offset03'] = __("Offset 03", "the-post-grid-pro");
            $layouts['offset04'] = __("Offset 04", "the-post-grid-pro");
            $layouts['isotope1'] = __("Isotope Layout 1", "the-post-grid-pro");
            $layouts['isotope2'] = __("Isotope Layout 2", "the-post-grid-pro");
            $layouts['isotope3'] = __("Isotope Layout 3", "the-post-grid-pro");
            $layouts['isotope4'] = __("Isotope Layout 4", "the-post-grid-pro");
            $layouts['isotope5'] = __("Isotope Layout 5", "the-post-grid-pro");
            $layouts['isotope6'] = __("Isotope Layout 6", "the-post-grid-pro");
            $layouts['isotope7'] = __("Isotope Layout 7", "the-post-grid-pro");
            $layouts['isotope8'] = __("Isotope Layout 8", "the-post-grid-pro");
            $layouts['isotope9'] = __("Isotope Layout 9", "the-post-grid-pro");
            $layouts['isotope10'] = __("Isotope Layout 10", "the-post-grid-pro");
            $layouts['isotope11'] = __("Isotope Layout 11", "the-post-grid-pro");
            $layouts['isotope12'] = __("Isotope Layout 12", "the-post-grid-pro");
            $layouts['carousel1'] = __("Carousel Layout 1", "the-post-grid-pro");
            $layouts['carousel2'] = __("Carousel Layout 2", "the-post-grid-pro");
            $layouts['carousel3'] = __("Carousel Layout 3", "the-post-grid-pro");
            $layouts['carousel4'] = __("Carousel Layout 4", "the-post-grid-pro");
            $layouts['carousel5'] = __("Carousel Layout 5", "the-post-grid-pro");
            $layouts['carousel6'] = __("Carousel Layout 6", "the-post-grid-pro");
            $layouts['carousel7'] = __("Carousel Layout 7", "the-post-grid-pro");
            $layouts['carousel8'] = __("Carousel Layout 8", "the-post-grid-pro");
            $layouts['carousel9'] = __("Carousel Layout 9", "the-post-grid-pro");
            $layouts['carousel10'] = __("Carousel Layout 10", "the-post-grid-pro");
            $layouts['carousel11'] = __("Carousel Layout 11", "the-post-grid-pro");
            $layouts['carousel12'] = __("Carousel Layout 12", "the-post-grid-pro");
            if (class_exists('Easy_Digital_Downloads')) {
                $layouts['edd1'] = __("EDD Layout 1", "the-post-grid-pro");
                $layouts['edd2'] = __("EDD Layout 2", "the-post-grid-pro");
                $layouts['edd3'] = __("EDD Layout 3", "the-post-grid-pro");
                $layouts['edd-carousel1'] = __("EDD Carousel Layout 1", "the-post-grid-pro");
                $layouts['edd-carousel2'] = __("EDD Carousel Layout 2", "the-post-grid-pro");
                $layouts['edd-isotope1'] = __("EDD Isotope Layout 1", "the-post-grid-pro");
                $layouts['edd-isotope2'] = __("EDD Isotope Layout 2", "the-post-grid-pro");
            }
            if (class_exists('WooCommerce')) {
                $layouts['wc1'] = __("WooCommerce Layout 1", "the-post-grid-pro");
                $layouts['wc2'] = __("WooCommerce Layout 2", "the-post-grid-pro");
                $layouts['wc3'] = __("WooCommerce Layout 3", "the-post-grid-pro");
                $layouts['wc4'] = __("WooCommerce Layout 4", "the-post-grid-pro");
                $layouts['wc-carousel1'] = __("WooCommerce Carousel Layout 1", "the-post-grid-pro");
                $layouts['wc-carousel2'] = __("WooCommerce Carousel Layout 2", "the-post-grid-pro");
                $layouts['wc-isotope1'] = __("WooCommerce Isotope Layout 1", "the-post-grid-pro");
                $layouts['wc-isotope2'] = __("WooCommerce Isotope Layout 2", "the-post-grid-pro");
            }

            return $layouts;
        }

        public function rtTPGLayoutSettingFields($options) {
            $position = array_search('tgp_read_more_text', array_keys($options));

            if ($position > -1) {
                $layoutFields = [
                    'tgp_not_found_text' => array(
                        "type"    => "text",
                        "default" => __("No post found", 'the-post-grid-pro'),
                        "label"   => "Not found text"
                    ),
                    'margin_option' => array(
                        "type"        => "radio",
                        "label"       => "Margin",
                        "alignment"   => "vertical",
                        "description" => "Select the margin for layout",
                        "default"     => "default",
                        "options"     => rtTPG()->scMarginOpt()
                    ),
                    'grid_style' => array(
                        "type"        => "radio",
                        "label"       => "Grid style",
                        "alignment"   => "vertical",
                        "description" => "Select grid style for layout",
                        "default"     => "even",
                        "options"     => rtTPG()->scGridOpt()
                    )
                ];
                rtTPGPHelper::array_insert($options, $position, $layoutFields);
            }

            $options = array_merge($options, [
                'restriction_user_role'            => array(
                    "type"        => "select",
                    "label"       => "Content will be visible for",
                    "class"       => "rt-select2",
                    "multiple"    => true,
                    "blank"       => "Allowed for all",
                    "description" => "Leave it blank for all",
                    "options"     => rtTPGP()->getAllUserRoles()
                ),
                'default_preview_image'            => array(
                    "type"        => "image",
                    "label"       => "Default preview image",
                    "description" => "Add an image for default preview"
                )
            ]);

            return $options;
        }

        public function rtTPGStyleFields($fields) {
            $position = array_search('tpg_read_more_button_alignment', array_keys($fields));

            if ($position > -1) {
                $styleFields = [
                    'tgp_gutter'                         => array(
                        'type'        => 'number',
                        'label'       => __('Gutter / Padding', 'the-post-grid-pro'),
                        'description' => __("Unit will be pixel, No need to give any unit. Only integer value will be valid.<br> Leave it blank for default",
                            'the-post-grid-pro')
                    ),
                    'overlay_color'                      => array(
                        "type"  => "text",
                        "label" => "Overlay color",
                        "class" => "rt-color",
                    ),
                    'overlay_opacity'                    => array(
                        "type"        => "select",
                        "label"       => "Overlay opacity",
                        "class"       => "rt-select2",
                        "default"     => .8,
                        "options"     => rtTPG()->overflowOpacity(),
                        "description" => __("Overlay opacity use only positive integer value", 'the-post-grid-pro')
                    ),
                    'overlay_padding'                    => array(
                        "type"        => "number",
                        "label"       => "Overlay top padding",
                        "class"       => "small-text",
                        "description" => __("Overlay top padding use only positive integer value, e.g : 20 (with out postfix like px, em, % etc). it will displayed by %",
                            'the-post-grid-pro')
                    )
                ];
                rtTPGPHelper::array_insert($fields, $position, $styleFields);
            }

            $position = array_search('button_active_bg_color', array_keys($fields));

            if ($position > -1) {
                $styleFields = [
                    'button_border_color'                => array(
                        "type"  => "text",
                        "label" => "Border",
                        "holderClass"   => "rt-3-column",
                        "class" => "rt-color"
                    ),
                ];
                rtTPGPHelper::array_insert($fields, $position, $styleFields);
            }

            return $fields;
        }

        public function custom_image_size($sizes) {
            $sizes['rt_custom'] = __('Custom Image Size', 'the-post-grid-pro');

            return $sizes;
        }

        public function field_selection_items($items) {
            $items['social_share'] = __('Social share', 'the-post-grid-pro');

            if (class_exists('WooCommerce')) {
                $items['rating'] = __("Rating (WooCommerce)", "the-post-grid-pro");
            }

            if ($cf = rtTPG()->checkWhichCustomMetaPluginIsInstalled()) {
                $items['cf'] = "Custom Fields";
            }

            return $items;
        }

    }

endif;