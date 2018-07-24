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

  $path = 'node/' . $element['#object']->nid;
  $spokepath = url($path);

	unset($item['#item']['width']);
	unset($item['#item']['height']);
	$item['#item']['alt'] = "";
  
  print '<a tabindex="-1" role="presentation" href = "'. $spokepath . '">';
  print render($item); 
  print "</a>";
     
}
?>

</div>
