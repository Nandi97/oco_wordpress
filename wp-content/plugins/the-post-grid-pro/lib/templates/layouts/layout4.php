<?php

$html = $imgHtml = $contentHtml = null;
$html .= sprintf('<div class="%s" data-id="%d">', esc_attr(implode(" ", array_filter([$grid, $class, "padding0 layout4item"]))), $pID);
    $html .= '<div class="rt-holder">';
			if($imgSrc) {
            $imgHtml .= "<div class='{$image_area} padding0 layoutInner  layoutInner-img'>";
                $imgHtml .= '<div class="rt-img-holder">';
                    $imgHtml .= "<a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$imgSrc}</a>";
                $imgHtml .= '</div>';
            $imgHtml .= '</div>';
			}else{
				$content_area = "rt-col-xs-12";
			}
            $contentHtml .= "<div class='{$content_area} padding0  layoutInner  layoutInner-content'>";
                    $contentHtml .= '<div class="rt-detail">';
                        if(in_array('title', $items)){
                            $contentHtml .= sprintf('<%1$s class="entry-title"><a data-id="%2$s" class="%3$s" href="%4$s"%5$s>%6$s</a></%1$s>', $title_tag,$pID,$anchorClass,$pLink,$link_target,$title);
                        }
                        $metaHtml = null;
                        if(in_array('post_date', $items) && $date){
                            $metaHtml .= "<span class='date-meta'><i class='far fa-calendar-alt'></i> {$date}</span>";
                        }
                        if(in_array('author', $items)){
                            $metaHtml .= "<span class='author'><i class='fa fa-user'></i>{$author}</span>";
                        }
                        if(in_array('categories', $items) && $categories){
                            $metaHtml .= "<span class='categories-links'><i class='fas fa-folder-open'></i>{$categories}</span>";
                        }
                        if(in_array('tags', $items) && $tags){
                            $metaHtml .= "<span class='post-tags-links'><i class='fa fa-tags'></i>{$tags}</span>";
                        }
                        if(in_array('comment_count', $items)){
                            $metaHtml .= '<span class="comment-count"><i class="fas fa-comments"></i> '. $comment.'</span>';
                        }
                        if(!empty($metaHtml)){
                            $contentHtml .="<div class='post-meta-user'>{$metaHtml}</div>";
                        }
                        if(in_array('excerpt', $items)){
                            $contentHtml .= "<div class='post-content'>{$excerpt}</div>";
                        }
                        if(in_array('social_share', $items)){
                            $contentHtml .= rtTPGP()->rtShare($pID);
                        }
                        if(in_array('read_more', $items)){
                            $contentHtml .= "<span class='read-more {$btn_alignment_class}'><a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$read_more_text}</a></span>";
                        }
                    $contentHtml .= '</div>';
            $contentHtml .= '</div>';

            if($toggle){
                $html .= $contentHtml . $imgHtml;
            }else{
                $html .= $imgHtml . $contentHtml;
            }

        $html .= '</div>';
$html .='</div>';

echo $html;