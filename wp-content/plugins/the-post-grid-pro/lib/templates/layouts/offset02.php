<?php

$html = $htmlDetail =null;
if(!empty($offset) && $offset == "big"){
    $class .= ($class ? " " : "") . "rt-col-xs-12 offset-big";
	$html .= "<div class='{$class}' data-id='{$pID}'>";
	$html .= '<div class="rt-holder">';
	$html .= '<div class="rt-img-holder">';
	if($imgSrc) {
		$html .= "<a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>$imgSrc</a>";
	}
	$html .= '</div> ';

	if(in_array('title', $items)){
		$htmlDetail .= "<h3 class='entry-title'><a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$title}</a></h3>";
	}
	$postMetaTop = $postMetaMid =null;

	if(in_array('author', $items)){
		$postMetaTop .= "<span class='author'><i class='fa fa-user'></i>{$author}</span>";
	}
	if(in_array('post_date', $items) && $date){
		$postMetaTop .= "<span class='date'><i class='far fa-calendar-alt'></i>{$date}</span>";
	}
    if(in_array('categories', $items) && $categories){
        $postMetaTop .= "<span class='categories-links'><i class='fas fa-folder-open'></i>{$categories}</span>";
    }
    if(in_array('tags', $items) && $tags){
        $postMetaTop .= "<span class='post-tags-links'><i class='fa fa-tags'></i>{$tags}</span>";
    }
	if(in_array('comment_count', $items) && $comment){
		$postMetaTop .= "<span class='comment-link'><i class='fas fa-comments'></i>{$comment}</span>";
	}
	if(!empty($postMetaTop)){
		$htmlDetail .= "<div class='post-meta-user'>{$postMetaTop}</div>";
	}
	if(!empty($postMetaMid)){
		$htmlDetail .= "<div class='post-meta-tags'>{$postMetaMid}</div>";
	}
	if(in_array('excerpt', $items)){
		$htmlDetail .= "<div class='tpg-excerpt'>{$excerpt}</div>";
	}
	$postMetaBottom = null;
	if(in_array('social_share', $items)){
		$postMetaBottom .= rtTPGP()->rtShare($pID);
	}
	if(in_array('read_more', $items)){
		$postMetaBottom .= "<span class='read-more'><a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>{$read_more_text}</a></span>";
	}
	if(!empty($postMetaBottom)){
		$htmlDetail .= "<div class='post-meta'>$postMetaBottom</div>";
	}
	if(!empty($htmlDetail)){
		$html .="<div class='rt-detail'>$htmlDetail</div>";
	}
	$html .= '</div>';
	$html .='</div>';

}elseif(!empty($offset) && $offset == "small"){
	$dCol = $tCol = $mCol = 12;
	if(!empty($offsetCol[0]) && $offsetCol[0] ==4){
		$dCol = 6;
	}if(!empty($offsetCol[1]) && $offsetCol[1] ==4){
		$tCol = 6;
	}if(!empty($offsetCol[2]) && $offsetCol[2] ==4){
		$mCol = 6;
	}
	$grid = "rt-col-md-{$dCol} rt-col-sm-{$tCol} rt-col-xs-{$mCol}";
    $class .= ($class ? " " : "") . $grid . " offset-small";
	$html .= "<div class='{$class}' data-id='{$pID}'>";
	$html .= '<div class="rt-holder">';
	$html .= '<div class="rt-img-holder">';
	if($imgSrc) {
		$html .= "<a data-id='{$pID}' class='{$anchorClass}' href='{$pLink}'{$link_target}>$imgSrc</a>";
	}
	$html .= '</div> ';

	if(in_array('title', $items)){
        $htmlDetail .= sprintf('<%1$s class="entry-title"><a data-id="%2$s" class="%3$s" href="%4$s"%5$s>%6$s</a></%1$s>', $title_tag,$pID,$anchorClass,$pLink,$link_target,$title);
	}
	$postMetaTop =null;

	if(in_array('author', $items)){
		$postMetaTop .= "<span class='author'><i class='fa fa-user'></i>{$author}</span>";
	}
	if(in_array('post_date', $items) && $date){
		$postMetaTop .= "<span class='date'><i class='far fa-calendar-alt'></i>{$date}</span>";
	}
    if(in_array('categories', $items) && $categories){
        $postMetaTop .= "<span class='categories-links'><i class='fas fa-folder-open'></i>{$categories}</span>";
    }
    if(in_array('tags', $items) && $tags){
        $postMetaTop .= "<span class='post-tags-links'><i class='fa fa-tags'></i>{$tags}</span>";
    }
	if(in_array('comment_count', $items) && $comment){
		$postMetaTop .= "<span class='comment-link'><i class='fas fa-comments'></i>{$comment}</span>";
	}
	if(!empty($postMetaTop)){
		$htmlDetail .= "<div class='post-meta-user'>{$postMetaTop}</div>";
	}
	if(!empty($postMetaMid)){
		$htmlDetail .= "<div class='post-meta-tags'>{$postMetaMid}</div>";
	}
	if(in_array('excerpt', $items)){
		$htmlDetail .= "<div class='tpg-excerpt'>{$excerpt}</div>";
	}
	if(!empty($htmlDetail)){
		$html .="<div class='rt-detail'>$htmlDetail</div>";
	}
	$html .= '</div>';

	$html .='</div>';
}
echo $html;