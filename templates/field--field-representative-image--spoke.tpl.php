<?php

/**
 * Thumbnail image: spoke 
 * WCAG 2.0 AA accessible markup
 *  
 *  
 * 
 */
?>
<div role="presentation" class="thumb"<?php print $attributes; ?>>

<?php 

foreach ($items as $delta => $item) {

  //print_r($item['classes_array'][0]);
  //print_r($item['#item']);
  $path = 'node/' . $element['#object']->nid;
  $spokepath = url($path);

	unset($item['#item']['width']);
	unset($item['#item']['height']);
	// class is set in mediacommons_editorialworkflow.module
	if (isset($item['classes_array'][0])){
		print render($item); 
	} else {
		print '<a tabindex="-1" aria-hidden="true" href = "'. $spokepath . '">';
		print render($item); 
	 	print "</a>";
	}
     
}
?>

</div>
