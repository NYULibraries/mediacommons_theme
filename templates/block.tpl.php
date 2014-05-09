<?php
/**
 * @file
 * Returns the HTML for a block.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728246
 */
?>
<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
	<?php if (!empty($block->subject)): ?>
  <header><?php print $block->subject; ?></header>
<?php endif; ?>
<?php print $content; ?>
</div>
