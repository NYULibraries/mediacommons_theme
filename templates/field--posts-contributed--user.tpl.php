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

<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php foreach ($items as $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
