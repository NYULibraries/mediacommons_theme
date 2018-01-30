<!-- ds 2 column stacked template -->
<<?php print $layout_wrapper; print $layout_attributes; ?> class="profile <?php print $classes;?> clearfix">
  <?php if (isset($title_suffix['contextual_links'])): ?>
    <?php print render($title_suffix['contextual_links']); ?>
  <?php endif; ?>
  <a id="main-content"></a>
  <header class="h-card vcard">
    <?php print $header; ?>
  </header>
  <div class="leftside">
    <?php print $left; ?>
  </div>
  <?php print $right; ?>
  <?php if (!empty($footer)): ?>
    <<?php print $footer_wrapper ?> class="<?php print $footer_classes; ?>">
      <?php  print $footer; ?>
    </<?php print $footer_wrapper ?>>
  <?php endif; ?>
</<?php print $layout_wrapper ?>>
<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>
