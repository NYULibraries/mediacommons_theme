<?php

/**
 */
?>taxonomy-term-profile-block
<?php foreach ($fields as $id => $field): ?>
	<div>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>
  

  <?php print $field->wrapper_prefix; ?>
    <?php print $field->label_html; ?>
    <?php print $field->content; ?>
  <?php print $field->wrapper_suffix; ?>
</div>
<?php endforeach; ?>