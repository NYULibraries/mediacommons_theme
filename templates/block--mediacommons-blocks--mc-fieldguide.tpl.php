<?php
/**
 * @file
 * Returns the HTML for a block.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728246
 *
 * MC Umbrella homepage widget -- list of items from Fieldguide
 */
?>
<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
	<?php if (!empty($block->subject)): ?>
    <div class="blockheader">
      <div>
        <?php print $block->subject; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php print $content; ?>
</div>
