<!-- ds 2 column stacked template -->
<<?php print $layout_wrapper; print $layout_attributes; ?> class="<?php print $classes;?> clearfix">
<?php if (isset($title_suffix['contextual_links'])): ?>
  <?php print render($title_suffix['contextual_links']); ?>
<?php endif; ?>
<header>
  <?php print $header; ?>
</header>
<<?php print $left_wrapper ?> class="<?php print $left_classes; ?>">
  <?php print $left; ?>
</<?php print $left_wrapper ?>>
<?php print $right; ?>
  <<?php print $footer_wrapper ?> class="<?php print $footer_classes; ?>">
    <?php print $footer; ?>
  </<?php print $footer_wrapper ?>>
</<?php print $layout_wrapper ?>>
<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>
