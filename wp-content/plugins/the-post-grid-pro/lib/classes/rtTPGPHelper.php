<?php

if (!class_exists('rtTPGPHelper')):

    class rtTPGPHelper {

        function getAllTpgTaxonomyObject($pt = 'post') {
            $taxonomy_objects = get_object_taxonomies($pt, 'objects');
            $taxonomy_list = array();
            if (!empty($taxonomy_objects)) {
                foreach ($taxonomy_objects as $taxonomy) {
                    if (!in_array($taxonomy->name, array('language', 'post_translations'))) {
                        $taxonomy_list[] = $taxonomy;
                    }
                }
            }

            return $taxonomy_list;
        }

        function get_cf_formatted_fields($groups, $format = array(), $post_id = null) {
            $html = null;
            if (!empty($groups)) {
                foreach ($groups as $group_id) {
                    $plugin = rtTPG()->checkWhichCustomMetaPluginIsInstalled();
                    $fields = array();
                    switch ($plugin) {
                        case 'acf':
                            $fields = acf_get_fields($group_id);
                            break;
                    }
                    if (!empty($fields)) {
                        $titleHtml = $returnHtml = null;
                        if (empty($format['hide_group_title'])) {
                            $title = get_the_title($group_id);
                            $titleHtml = "<h4 class='tpg-cf-group-title'>{$title}</h4>";
                        }
                        foreach ($fields as $field) {
                            $item = $htmlValue = $htmlLabel = null;
                            $value = get_field($field['name'], $post_id);
                            if ($value) {
                                switch ($field['type']) {
                                    case 'image':
                                        $value = "<img src='{$value['sizes']['thumbnail']}' />";
                                        break;
                                    case 'select':
                                        if (!empty($field['choices'])) {
                                            if (is_array($value)) {
                                                $nValue = array();
                                                foreach ($value as $v) {
                                                    $nValue[] = $field['choices'][$v];
                                                }
                                                $value = implode(', ', $nValue);
                                            } else {
                                                $value = $field['choices'][$value];
                                            }
                                        }
                                        break;
                                    case 'checkbox':
                                        if (!empty($field['choices'])) {
                                            if (is_array($value)) {
                                                $nValue = array();
                                                foreach ($value as $v) {
                                                    $nValue[] = $field['choices'][$v];
                                                }
                                                $value = implode(', ', $nValue);
                                            } else {
                                                $value = $field['choices'][$value];
                                            }
                                        }
                                        break;
                                    case 'radio':
                                        if (!empty($field['choices'])) {
                                            $value = $field['choices'][$value];
                                        }
                                        break;
                                    case 'true_false':
                                        $value = $value ? 1 : 0;
                                        break;
                                    case 'date_picker':
                                        $date = new DateTime($value);
                                        $date_format = get_option('date_format');
                                        $date_format = $date_format ? $date_format : 'j M Y';
                                        $value = $date->format($date_format);
                                        break;
                                    case 'color_picker':
                                        $value = "<div class='tpg-cf-color' style='height:25px;width:25px;background:{$value};'></div>";
                                        break;
                                    case 'file':
                                        $value = "<a href='{$value['url']}'>" . __("Download",
                                                'the-post-grid-pro') . " {$field['label']}</a>";
                                        break;
                                    default:
                                        break;
                                }
                            }

                            $htmlLabel = "<span class='tgp-cf-field-label'>{$field['label']}</span>";
                            $htmlValue = "<div class='tgp-cf-field-value'>{$value}</div>";
                            $item .= "<div class='tpg-cf-fields tgp-cf-{$plugin}-{$field['type']}'>";
                            if (!empty($format['show_value'])) {
                                $item .= $htmlValue;
                            } else {
                                $item .= $htmlLabel;
                                $item .= $htmlValue;
                            }
                            $item .= "</div>";
                            if (!empty($format['hide_empty'])) {
                                if ($value) {
                                    $returnHtml .= $item;
                                }
                            } else {
                                $returnHtml .= $item;
                            }
                        }

                        $html .= "<div class='tpg-cf-wrap'>{$titleHtml}{$returnHtml}</div>";

                    }
                }

            }

            return $html;
        }

        function rtShare($pid) {
            if (!$pid) {
                return;
            }
            $settings = get_option(rtTPG()->options['settings']);
            $ssList = !empty($settings['social_share_items']) ? $settings['social_share_items'] : array();
            $permalink = get_the_permalink($pid);
            $html = null;

            if (in_array('facebook', $ssList)) {
                $html .= "<a class='facebook' title='" . __("Share on facebook",
                        "the-post-grid-pro") . "' target='_blank' href='https://www.facebook.com/sharer/sharer.php?u={$permalink}'><i class='fab fa-facebook-f' aria-hidden='true'></i></a>";
            }
            if (in_array('twitter', $ssList)) {
                $html .= "<a class='twitter' title='" . __("Share on twitter",
                        "the-post-grid-pro") . "' target='_blank' href='http://www.twitter.com/intent/tweet?url={$permalink}'><i class='fab fa-twitter' aria-hidden='true'></i></a>";
            }
            if (in_array('linkedin', $ssList)) {
                $html .= "<a class='linkedin' title='" . __("Share on linkedin",
                        "the-post-grid-pro") . "' target='_blank' href='https://www.linkedin.com/shareArticle?mini=true&url={$permalink}'><i class='fab fa-linkedin-in' aria-hidden='true'></i></a>";
            }
            if (in_array('pinterest', $ssList)) {
                $html .= "<a class='pinterest' title='" . __("Share on pinterest",
                        "the-post-grid-pro") . "' target='_blank' href='https://pinterest.com/pin/create/button/?url={$permalink}'><i class='fab fa-pinterest' aria-hidden='true'></i></a>";
            }
            if (in_array('reddit', $ssList)) {
                $title = strip_tags(get_the_title($pid));
                $html .= "<a class='reddit' title='" . __("Share on reddit",
                        "the-post-grid-pro") . "' target='_blank' href='http://reddit.com/submit?url={$permalink}&amp;title={$title}'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>";
            }

            if (in_array('email', $ssList)) {
                $title = strip_tags(get_the_title($pid));
                $excerpt = strip_tags(get_the_excerpt($pid));
                $excerpt = $excerpt . "\r - " . $permalink;
                $html .= sprintf('<a class="email" title="%s" href="mailto:?subject=%s&body=%s"><i class="fa fa-envelope"></i></a>',
                    __("Share on Email", "the-post-grid-pro"),
                    $title,
                    $excerpt
                );
            }

            if ($html) {
                $html = "<div class='rt-tpg-social-share'>{$html}</div>";
            }

            return $html;
        }

        function rtProductGalleryImages() {
            $gallery = null;
            global $post, $product;
            $thumb_id = get_post_thumbnail_id($post->ID);
            $attachment_ids = $product->get_gallery_image_ids();
            if ($thumb_id) {
                array_unshift($attachment_ids, $thumb_id);
            }

            if (!empty($attachment_ids)) {
                foreach ($attachment_ids as $attachment_id) {
                    $full_size_image = wp_get_attachment_image_src($attachment_id, 'full');
                    $thumbnail = wp_get_attachment_image_src($attachment_id, 'shop_thumbnail');
                    $thumbnail_post = get_post($attachment_id);
                    $image_title = $thumbnail_post->post_content;

                    $attributes = array(
                        'title'                   => $image_title,
                        'data-src'                => $full_size_image[0],
                        'data-large_image'        => $full_size_image[0],
                        'data-large_image_width'  => $full_size_image[1],
                        'data-large_image_height' => $full_size_image[2],
                    );

                    $html = '<div data-thumb="' . esc_url($thumbnail[0]) . '" class="rt-product-img"><a href="' . esc_url($full_size_image[0]) . '">';
                    $html .= wp_get_attachment_image($attachment_id, 'shop_single', false, $attributes);
                    $html .= '</a></div>';

                    $gallery .= apply_filters('woocommerce_single_product_image_thumbnail_html', $html,
                        $attachment_id);
                }
            }
            $galleryClass = 'hasImg';
            if (!$gallery) {
                $galleryClass = "haNoImg";
                $gallery = '<div class="rt-product-img-placeholder">';
                $gallery .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />',
                    esc_url(wc_placeholder_img_src()), esc_html__('Awaiting product image', 'woocommerce'));
                $gallery .= '</div>';
            }
            //$a = explode(',', $attachment_ids);
            $gallery = "<div id='rt-product-gallery' class='{$galleryClass}'>{$gallery}</div>";

            return $gallery;
        }

        function woocommerce_get_product_schema() {

            global $product;

            $schema = "Product";

            // Downloadable product schema handling
            if ( $product->is_downloadable() ) {
                switch ( $product->download_type ) {
                    case 'application' :
                        $schema = "SoftwareApplication";
                        break;
                    case 'music' :
                        $schema = "MusicAlbum";
                        break;
                    default :
                        $schema = "Product";
                        break;
                }
            }

            return 'http://schema.org/' . $schema;
        }

        function getAllUserRoles() {
            global $wp_roles;
            $roles = array();
            if (!empty($wp_roles->roles)) {
                foreach ($wp_roles->roles as $roleID => $role) {
                    $roles[$roleID] = $role['name'];
                }
            }

            return $roles;
        }

        public static function array_insert(&$array, $position, $insert_array) {
            $first_array = array_splice($array, 0, $position + 1);
            $array = array_merge($first_array, $insert_array, $array);
        }

    }

endif;
