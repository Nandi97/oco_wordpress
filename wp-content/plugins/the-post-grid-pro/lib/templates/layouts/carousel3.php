<?php

$html = $metaData = $metaHtml = null;

$html .= sprintf('<div class="%s" data-id="%d">', esc_attr(implode(" ", [$grid, $class])), $pID);
    $html .= '<div class="rt-holder">';
        $html .= '<div class="overlay">';
                if(in_array('title', $items)){
                    $html .= sprintf('<%1$s class="entry-title"><a data-id="%2$s" class="%3$s" href="%4$s"%5$s>%6$s</a></%1$s>', $title_tag,$pID,$anchorClass,$pLink,$link_target,$title);
                    $html .= "<div class='line'></div>";
                }
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

                if(!empty($metaHtml)){
                    $html .= "<div class='post-meta-user'><p><span class='meta-data'>{$metaHtml}</span></p></div>";
                }
                if(in_array('excerpt', $items)){
                    $html .= "<div class='tpg-excerpt'>{$excerpt}</div>";
                }
                $postMetaBottom = null;
                if(in_array('social_share', $items)){
                    $postMetaBottom .= rtTPGP()->rtShare($pID);
                }
                if(in_array('read_more', $items)){
                    $postMetaBottom .= "<span class='read-more'><a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$read_more_text}</a></span>";
                }
                if(!empty($postMetaBottom)){
                    $html .= "<div class='post-meta {$btn_alignment_class}'>$postMetaBottom</div>";
                }

        $html .= '</div>';
		if($imgSrc) {
			$html .= "<a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$imgSrc}</a>";
		}
    $html .= '</div>';
$html .='</div>';

echo $html;
