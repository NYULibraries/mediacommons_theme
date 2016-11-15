<?php 

function mediacommons_preprocess_block(&$variables) {
  //print_r($variables['block_html_id']);
 // if ($variables['block_html_id'] == 'block-mediacommons-blocks-mc-footer'){
   $specialBodyClass   = theme_get_setting( 'special_body_class' );
   $variables['theme_hook_suggestions'][] = 'block__' . $variables['block']->region . "__" . $specialBodyClass;
// }
}

?>