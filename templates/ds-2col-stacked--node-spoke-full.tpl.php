<?php

/**
 * @file
 * Display Suite 2 column stacked template.
 */
?>
<<?php print $layout_wrapper; print $layout_attributes; ?> class="<?php print $classes;?> clearfix">

<?php if (isset($title_suffix['contextual_links'])): ?>
  <?php print render($title_suffix['contextual_links']); ?>
<?php endif; ?>

<?php print '<header class="spoke-header">'; ?>
  <?php print $header; ?>
<?php print "</header>"; ?>

<<?php print $left_wrapper ?> class="spoke-body <?php print $left_classes; ?>">
  <?php print $left; ?>
</<?php print $left_wrapper ?>>

<?php print $right; ?>

<aside role="complementary">
	<div class="block-views block">
		<?php print views_embed_view('all_spokes_in_this_spokes_hub', 'block_1');?>
	</div>
</aside>

  <<?php print $footer_wrapper ?> class="<?php print $footer_classes; ?>">
    <?php print $footer; ?>
  </<?php print $footer_wrapper ?>>

</<?php print $layout_wrapper ?>>

<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>