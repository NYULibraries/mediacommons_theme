<?php

/**
 * Simple Field Posts from User.
 *
 * This file is not used and is here as a starting point for customization only.
 * @see theme_field()
 *
 *
 * @see template_preprocess_field()
 * @see theme_field()
 *
 * @ingroup themeable
 */
?>
<div class="peoplelist clearfix <?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="label">by</div> 
 	<?php foreach ($items as $delta => $item): ?>
      <?php print render($item); ?>
 	<?php endforeach; ?>
</div>
