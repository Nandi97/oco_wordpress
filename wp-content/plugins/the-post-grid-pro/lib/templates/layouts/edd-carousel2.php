<?php
$price = null;
if(edd_has_variable_prices(get_the_ID())){
    $price = "<span class='price'>".edd_price_range(get_the_ID(), false)."</span>";
}else{
    $price = "<span class='price'>".edd_price(get_the_ID(), false)."</span>";
}
$html = $htmlTitle = $pType = null;

$html = $htmlTitle = $html_info =null;

$html .= sprintf('<div class="%s" data-id="%d">', esc_attr(implode(" ", [$grid, $class])), $pID);
	$html .= '<div class="rt-holder">';
	if($imgSrc) {
		$html .= '<div class="rt-img-holder">';
			$html .= '<div class="overlay">';
				$html .= "<a class='view-search' href='{$pLink}' class='{$anchorClass}' data-id='{$pID}'><i class='fa fa-search'></i></a>";
			$html .= '</div> ';
			$html .= "<a href='{$pLink}' class='{$anchorClass}' data-id='{$pID}'{$link_target}>$imgSrc</a>";
		$html .= '</div> ';
	}
	if(in_array('title', $items)){
        $htmlTitle = sprintf('<%1$s class="product-title"><a data-id="%2$s" class="%3$s" href="%4$s"%5$s>%6$s</a></%1$s>', $title_tag,$pID,$anchorClass,$pLink,$link_target,$title);
	}
    $html .= sprintf("<div class='rt-detail rt-woo-info'>%s<div class='product-meta'>%s</div></div>", $htmlTitle, edd_get_purchase_link());
	$html .= '</div>';
$html .='</div>';

echo $html;