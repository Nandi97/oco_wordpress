<?php
$html = $metaHtmltop= $metaHtmlbottom = $titleHtml= null;
if(in_array('title', $items)){
    $titleHtml = sprintf('<%1$s class="entry-title"><a data-id="%2$s" class="%3$s" href="%4$s"%5$s>%6$s</a></%1$s>', $title_tag,$pID,$anchorClass,$pLink,$link_target,$title);
}
if(in_array('post_date', $items) && $date){
    $metaHtmltop .= "<span class='date-meta'><i class='far fa-calendar-alt'></i> {$date}</span>";
}
if(in_array('author', $items)){
    $metaHtmltop .= "<span class='author'><i class='fa fa-user'></i>{$author}</span>";
 }
if(in_array('categories', $items) && $categories){
    $metaHtmltop .= "<span class='categories-links'><i class='fas fa-folder-open'></i>{$categories}</span>";
}
if(in_array('tags', $items) && $tags){
    $metaHtmltop .= "<span class='post-tags-links'><i class='fa fa-tags'></i>{$tags}</span>";
}
$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
if(in_array('comment_count', $items) && $comment){
    $metaHtmltop .= '<span class="comment-count"><a href="' . get_comments_link() .'"><i class="fas fa-comments"></i> '. $num_comments.'</a></span>';
}
$postMetaBottom = null;
if(in_array('social_share', $items)){
    $postMetaBottom .= rtTPGP()->rtShare($pID);
}
if(in_array('read_more', $items)){
    $postMetaBottom .= "<span class='read-more'><a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$read_more_text}</a></span>";
}


$html .= sprintf('<div class="%s" data-id="%d">', esc_attr(implode(" ", [$grid, $class])), $pID);
    $html .= sprintf('<div class="rt-holder%s">',$tpg_title_position ? " rt-with-title-".$tpg_title_position : null);
        if($tpg_title_position == 'above'){
            $html .= sprintf('<div class="rt-detail rt-with-title">%s</div>', $titleHtml);
        }
		if($imgSrc) {
			$html .= '<div class="rt-img-holder">';
			$html .= "<a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$imgSrc}</a>";
			$html .= '</div> ';
		}
        $html .="<div class='rt-detail'>";
            if($tpg_title_position == 'below'){
                $html .= $titleHtml;
            }
            $html .= sprintf('<div class="post-meta-user">%s</div>',$metaHtmltop);
            if(!$tpg_title_position){
                $html .=$titleHtml;
            }
            if(in_array('excerpt', $items)){
                $html .= "<div class='tpg-excerpt'>{$excerpt}</div>";
            }
           if(!empty($postMetaBottom)){
                $html .= "<div class='post-meta {$btn_alignment_class}'>$postMetaBottom</div>";
            }
        $html .= "</div>";
    $html .= '</div>';
$html .='</div>';

echo $html;

