<?php
/**
 * @file
 * Returns the HTML for a block.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728246
 */
?>
<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?> responsive-container"<?php print $attributes; ?>>
	<?php if (!empty($block->subject)): ?>
  <header class="blockheader"><span class="responsive-disclosure"></span><div><?php print $block->subject; ?></div></header>
<?php endif; ?>
<?php print $content; ?>
</div>
