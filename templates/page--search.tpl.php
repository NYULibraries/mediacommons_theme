<a id="main-content"></a>
<?php  include ("head.inc");    ?>

  <?php if ($action_links): ?>
  <ul class="action-links">
    <?php print render($action_links); ?>
  </ul>
  <?php endif; ?>

<main role="main">

   <?php if ($tabs) : ?>
  <div class="tabs"><?php print render($tabs); ?></div>
  <?php endif; ?>

  <?php if (isset($page['highlighted'])) : ?>
            <div id="highlighted"><?php print render($page['highlighted']); ?></div>
  <?php endif; ?>


 <?php if ($messages) : ?>
          <?php print $messages; ?>
  <?php endif; ?>


 <?php if (isset($page['sidebar_basicpage1'])) : ?>
    <div  class="sidebar_searchresults">
      <?php print render($page['sidebar_basicpage1']); ?>
    </div>
  <?php endif; ?>


<section id="content">
  <?php 

    if ($title): print '<h1 class="page-title">' . $title . '</h1>'; endif;

    print render($page['content']); ?> 
</section>
 </main>
  
<?php if (isset($page['globalnav']) && !empty($page['globalnav'])) : ?>
  <nav class="global" role="navigation"><?php print render($page['globalnav']); ?></nav>
<?php endif; ?>

<?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
    <?php print render($page['footer']); ?> 
<?php endif; ?>