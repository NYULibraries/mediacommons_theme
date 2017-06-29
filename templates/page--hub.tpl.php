<a id="main-content"></a>
<?php include ('head.inc'); ?>
<?php if ($action_links): ?>
  <ul class="action-links">
    <?php print render($action_links); ?>
  </ul>
<?php endif; ?>
<main role="main">
  <div id="content">
    <?php if (isset($tabs)): ?>
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
    <article  class="toc" role="directory">
      <?php print render($page['content']); ?> 
    </article>
  </div>
  <?php if (isset($page['sidebar_first'])) : ?>
    <aside role="complementary">
      <?php print render($page['sidebar_first']); ?>
    </aside>
  <?php endif; ?> 
</main>
<?php if (isset($page['globalnav']) && !empty($page['globalnav'])) : ?>
  <nav class="global" role="navigation">
    <?php print render($page['globalnav']); ?>
  </nav>
<?php endif; ?>
<?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
  <?php print render($page['footer']); ?> 
<?php endif; ?>
