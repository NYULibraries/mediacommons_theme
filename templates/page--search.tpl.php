<?php  include ("head.inc"); ?>
<?php if ($action_links): ?>
  <ul class="action-links">
    <?php print render($action_links); ?>
  </ul>
<?php endif; ?>
<main id="main-content">
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
  <div  class="searchresults_hold">
    <?php if (isset($page['searchresults_sidebar'])) : ?>
      <div  class="searchresults_sidebar">
        <?php print render($page['searchresults_sidebar']); ?>
      </div>
    <?php endif; ?>
    <div  class="searchresults_content">
      <?php print render($page['searchresults_main']); ?>
      <?php print render($page['content']); ?>
    </div>
  </div>
</main>
  
<?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
    <?php print render($page['footer']); ?> 
<?php endif; ?>