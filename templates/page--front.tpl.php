
<?php include ("head.inc"); ?>
  <?php if ($action_links): ?>
   <ul class="action-links">
    <?php print render($action_links); ?>
  </ul>
  <?php endif; ?>
  <main> 
    <?php if (isset($tabs)): ?>
      <div class="tabs"><?php print render($tabs); ?></div>
    <?php endif; ?>
    <?php if (isset($page['highlighted'])) : ?>
      <div id="highlighted"><?php print render($page['highlighted']); ?></div>
    <?php endif; ?>
    <?php if ($messages): ?>
      <?php print $messages; ?>
    <?php endif; ?>
    <div id="content"><a id="main-content"></a>
      <?php print render($page['homepage_top']); ?>
      <section class="featured-more">  
        <?php print render($page['homepage_bottom']); ?>
      </section>
    </div>
    <?php if (isset($page['homepage_sidebar'])) : ?>
      <aside><?php print render($page['homepage_sidebar']); ?></aside>
    <?php endif; ?> 
  </main>  
<?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
  <?php print render($page['footer']); ?> 
<?php endif; ?>
 