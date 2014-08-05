<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
  <?php if (!empty($header)): ?>
    <header>
      <?php print $header; ?>
    </header>
  <?php endif; ?>
  <?php foreach ($rows as $row): ?>
	<div class="h-card vcard">asdfdsaf
    <?php print $row; ?>
	</div>
<?php endforeach; 