<?php

/**
 * @file
 * Display Suite 1 column template.
 */
?>
<<?php print "span"; print $layout_attributes; ?> class="ds-1col <?php print $classes;?>">


  <?php print $ds_content; ?>
</<?php print "span" ?>>

<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>