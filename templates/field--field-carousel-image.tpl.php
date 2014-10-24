<?php

/**
 * @file field.tpl.php
 * Simplified template for carousel image
 *  removes height and width so they can be more robustly calculated 
 *   by css
 * 
 */
?>


<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php foreach ($items as $delta => $item):
      unset($item['#item']['width']);
      unset($item['#item']['height']);
     ?>
<?php print render($item); ?>
    <?php endforeach; ?>

</div>
