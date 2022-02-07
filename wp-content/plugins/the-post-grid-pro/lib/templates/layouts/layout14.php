<?php
$html = $htmlDetail = $postMetaBottom2 = $iTitle = null;
if(in_array('title', $items)){
    $iTitle = sprintf('<%1$s class="entry-title"><a data-id="%2$s" class="%3$s" href="%4$s"%5$s>%6$s</a></%1$s>', $title_tag,$pID,$anchorClass,$pLink,$link_target,$title);
}
if(in_array('social_share', $items)){
    $postMetaBottom2 .= rtTPGP()->rtShare($pID);
}
if(in_array('read_more', $items)){
    $postMetaBottom2 .= "<span class='read-more'><a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$read_more_text}</a></span>";
}

$html .= sprintf('<div class="%s" data-id="%d">', esc_attr(implode(" ", [$grid, $class])), $pID);
    $html .= '<div class="rt-holder">';
            if($tpg_title_position == 'above'){
                $html .= sprintf('<div class="rt-detail rt-with-title">%s</div>', $iTitle);
            }
			if($imgSrc) {
				$html .= '<div class="rt-img-holder">';
				$html .= "<a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$imgSrc}</a>";
				$html .= '</div> ';
			}
			$postMetaTop = null;
            if(in_array('categories', $items) && $categories){
                $postMetaTop .= "<span class='categories-links'><i class='fas fa-folder-open'></i>{$categories}</span>";
            }
            if(in_array('tags', $items) && $tags){
                $postMetaTop .= "<span class='post-tags-links'><i class='fa fa-tags'></i>{$tags}</span>";
            }
            if(!empty($postMetaTop)){
                $htmlDetail .= "<div class='post-meta-tags'>{$postMetaTop}</div>";
            }
            if($tpg_title_position != 'above'){
                $htmlDetail .= $iTitle;
            }
            $postMetaMid = null;
            if(!empty($postMetaMid)){
                $htmlDetail .= "<div class='post-meta-tags'>{$postMetaMid}</div>";
            }
            if(in_array('excerpt', $items)){
                $htmlDetail .= "<div class='tpg-excerpt'>{$excerpt}</div>";
            }
            $postMetaBottom = null;
            
            if(in_array('author', $items)){
                $postMetaBottom .= "<span class='author'><i class='fa fa-user'></i>{$author}</span>";
            }
            if(in_array('post_date', $items) && $date){
              $postMetaBottom .= "<span class='date'><i class='far fa-calendar-alt'></i>{$date}</span>";
            }
            if(in_array('comment_count', $items) && $comment){
                $postMetaBottom .= "<span class='comment-link'><i class='fas fa-comments'></i>{$comment}</span>";
            }       
            if(!empty($htmlDetail)){
                $html .="<div class='rt-detail'>$htmlDetail</div>";
            }
            if(!empty($postMetaBottom2)){
                $html .= "<div class='post-meta {$btn_alignment_class}'>$postMetaBottom2</div>";
            }
            if(!empty($postMetaBottom)){
                $html .= "<div class='post-meta-user'>$postMetaBottom</div>";
            }
    $html .= '</div>';
$html .='</div>';

echo $html;