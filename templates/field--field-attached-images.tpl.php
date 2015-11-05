<?php

/**
 * @file field.tpl.php
 * Simplified template for featured image
 *  removes height and width so they can be more robustly calculated 
 *   by css
 * 
 */
?>
<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
  IMAG  <?php foreach ($items as $delta => $item):
      unset($item['#item']['width']);
      unset($item['#item']['height']);
      print render($item); ?>
    <?php endforeach; ?>
</div>
