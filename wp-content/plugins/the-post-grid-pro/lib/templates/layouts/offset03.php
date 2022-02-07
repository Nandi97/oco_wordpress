<?php

$html = $metaHtml =$titleHtml=$contentHtml =null;

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
$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
if(in_array('comment_count', $items) && $comment){
	$metaHtml .= '<span class="comment-count"><a href="' . get_comments_link() .'"><i class="fas fa-comments"></i> '. $num_comments.'</a></span>';
}
if(in_array('excerpt', $items)){
	$contentHtml .= "<div class='tpg-excerpt'>{$excerpt}</div>";
}
$postMetaBottom = null;
if(in_array('social_share', $items)){
	$postMetaBottom .= rtTPGP()->rtShare($pID);
}
if(in_array('read_more', $items)){
	$postMetaBottom .= "<span class='read-more'><a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$read_more_text}</a></span>";
}
if(!empty($postMetaBottom)){
	$contentHtml .= "<div class='post-meta'>$postMetaBottom</div>";
}

if(!empty($offset) && $offset == "big"){
    $class .= ($class ? " " : "") . "rt-col-xs-12 offset-big";
	$html .= "<div class='{$class}' data-id='{$pID}'>";
		$html .= '<div class="rt-holder">';
			$html .= '<div class="overlay">';
				$html .= "{$titleHtml}";
				$html .= "<span class='post-meta-user'>{$metaHtml}</span>";
				if(!empty($contentHtml)){
					$html .= "<div class='rt-detail'>{$contentHtml}</div>";
				}
			$html .= '</div> ';
	if($imgSrc) {
		$html .= "<a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>$imgSrc</a>";
	}
		$html .= '</div>';
	$html .='</div>';

}elseif(!empty($offset) && $offset == "small"){
	$dCol = $tCol = $mCol = 6;
	$class = $class ." offset-small";
	$grid = "rt-col-md-{$dCol} rt-col-sm-{$tCol} rt-col-xs-{$mCol}";
    $class .= ($class ? " " : "") . $grid . " offset-small";
	$imgSrc = rtTPG()->getFeatureImageSrc( $pID, 'medium');
	$html .= "<div class='{$class}' data-id='{$pID}'>";
		$html .= '<div class="rt-holder">';
			$html .= '<div class="overlay">';
				$html .= "{$titleHtml}";
				$html .= "<span class='post-meta-user'>{$metaHtml}</span>";
			$html .= '</div> ';
			$html .= "<a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>$imgSrc</a>";
		$html .= '</div>';
	$html .='</div>';
}
echo $html;