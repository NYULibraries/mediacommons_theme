<?php 

function mediacommons_preprocess_block(&$variables) {
	 $specialBodyClass   = theme_get_setting( 'special_body_class' );
   $variables['theme_hook_suggestions'][] = 'block__' . $variables['block']->region . "__" . $specialBodyClass;
   $variables['classes_array'][] = "mc-".$specialBodyClass;
}
function mediacommons_preprocess_field(&$variables) {
	$specialBodyClass   = theme_get_setting( 'special_body_class' );
	$variables['classes_array'][] = "mc-".$specialBodyClass;
}
?>