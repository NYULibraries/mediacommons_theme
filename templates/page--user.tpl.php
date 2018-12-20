<?php include 'head.inc'; ?>
<?php if ($action_links): ?>
  <ul class="action-links">
    <?php print render($action_links); ?>
  </ul>
<?php endif; ?>
<main>
   <?php if ($tabs) : ?>
    <div class="tabs">
      <?php print render($tabs); ?>
    </div>
  <?php endif; ?>
  <?php if (isset($page['highlighted'])) : ?>
    <div id="highlighted"><?php print render($page['highlighted']); ?></div>
  <?php endif; ?>
  <?php if ($messages) : ?>
    <?php print $messages; ?>
  <?php endif; ?>
  <a id="main-content"></a>
  <?php print render($page['content']); ?>
</main>
<?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
  <?php print render($page['footer']); ?> 
<?php endif; ?>