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
    <div id="highlighted">
      <?php print render($page['highlighted']); ?>
    </div>
  <?php endif; ?>
  <?php if ($messages) : ?>
    <?php print $messages; ?>
  <?php endif; ?>
  <div id="content" >
    <div id="main-content">
    <?php if ($title) : ?>
      <h1 class="page-title"><?php print $title ?></h1>
    <?php endif; ?>
    <?php print render($page['content']); ?>
  </div>
  </div>
 <?php if (isset($page['sidebar_basicpage1'])) : ?>
    <aside class="sidebar_basicpage1">
      <?php print render($page['sidebar_basicpage1']); ?>
    </aside>
  <?php endif; ?> 
</main>

<?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
  <?php print render($page['footer']); ?> 
<?php endif; ?>