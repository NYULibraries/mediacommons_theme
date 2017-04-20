<?php 

function mediacommons_preprocess_block(&$variables) {
	 $specialBodyClass   = theme_get_setting( 'special_body_class' );
   $variables['theme_hook_suggestions'][] = 'block__' . $variables['block']->region . "__" . $specialBodyClass;
   $variables['classes_array'][] = "mc-".$specialBodyClass;
   /* this will show a block's parent view; otherwise not straightforward in Drupal */
   $pos = strrpos($variables['block']->delta,  "-");
   $variables['classes_array'][] =   substr($variables['block']->delta, 0, $pos)  ; 
}
function mediacommons_preprocess_field(&$variables) {
	$specialBodyClass   = theme_get_setting( 'special_body_class' );
	$variables['classes_array'][] = "mc-".$specialBodyClass;
	if($variables['element']['#field_name'] == 'field_representative_image') {
    if( !empty($variables['element']['#field_type'])
      && !empty($variables['items'][0]['#item']['is_default'])
      && $variables['element']['#field_type']=='image'
      && $variables['items'][0]['#item']['is_default'] == TRUE ){
        $variables['classes_array'][] = 'default-image';
    }
  }

}
?>