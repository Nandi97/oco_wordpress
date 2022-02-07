<?php

$html = null;
if($imgSrc){
	$fullSrc = rtTPG()->getFeatureImageUrl( $pID, 'full' );
    $html .= sprintf('<div class="%s" data-id="%d">', esc_attr(implode(" ", [$grid, $class])), $pID);
	$html .= '<div class="rt-holder">';
	$html .= '<div class="overlay">';
	$html .= "<a class='tpg-zoom' title='{$title}' href='{$fullSrc}'><i class='fa fa-plus' aria-hidden='true'></i></a>";
	$html .= '</div>';
	$html .= $imgSrc;
	$html .= '</div>';
	$html .='</div>';
}


echo $html;
