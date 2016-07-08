<a id="main-content"></a>
<header  role="banner"> <a href="#main-nav" class="skip-to-nav">Skip to Navigation</a>
    <button type="button" class="skip-arrow"></button>
    <h1><a href="<?php print $front_page; ?>" title="Home" rel="home" class="logo"><span><?php print $site_name; ?></span></a></h1>

  <?php print render($page['search']); ?>
  <nav id="main-nav" class="nav main" role="navigation">
    <?php if ($main_menu ) : ?>
    <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('class' => array('main')))); ?>
  <?php endif; ?>
  </nav>
</header>

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

 <article id="contentwide">
  <?php 
     print render($page['content']); ?> 
  </article>
</main>
  
<?php if (isset($page['globalnav']) && !empty($page['globalnav'])) : ?>
  <nav class="global" role="navigation"><?php print render($page['globalnav']); ?></nav>
<?php endif; ?>

<?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
    <?php print render($page['footer']); ?> 
<?php endif; ?>