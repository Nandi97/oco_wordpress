<?php
$html = $titleHtml = $metaHtml = $contentHtml= null;
if(in_array('title', $items)){
    $titleHtml .= sprintf('<%1$s class="entry-title"><a data-id="%2$s" class="%3$s" href="%4$s"%5$s>%6$s</a></%1$s>', $title_tag,$pID,$anchorClass,$pLink,$link_target,$title);
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
if(in_array('comment_count', $items)){
    $metaHtml .= '<span class="comment-count"><i class="fas fa-comments"></i> '. $comment.'</span>';
}
if(in_array('excerpt', $items)){
    $contentHtml .= "<p class='tpg-excerpt'>{$excerpt}</p>";
}

$postMetaBottom = null;
if(in_array('social_share', $items)){
    $postMetaBottom .= rtTPGP()->rtShare($pID);
}
if(in_array('read_more', $items)){
    $postMetaBottom .= "<span class='read-more'><a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$read_more_text}</a></span>";
}
if(!empty($postMetaBottom)){
    $contentHtml .= "<div class='post-meta {$btn_alignment_class}'>$postMetaBottom</div>";
}

$html .= sprintf('<div class="%s" data-id="%d">', esc_attr(implode(" ", [$grid, $class])), $pID);
    $html .= '<div class="rt-holder">';
        $html .= "<div class='overlay'>";
		if($imgSrc) {
			$html .= "<a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$imgSrc}</a>";
		}
            $html .= "<div class='post-info'>{$titleHtml}<p class='post-meta-user'>{$metaHtml}</p>{$contentHtml}</div>";
            
        $html .="</div>";
    $html .= '</div>';
$html .='</div>';

echo $html;