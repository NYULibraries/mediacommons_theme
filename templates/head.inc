<?php if (isset($page['globalnav']) && !empty($page['globalnav'])) : ?>
  <nav class="global">
    <?php print render($page['globalnav']); ?>
  </nav>
<?php endif; ?>

<header  class="banner">
  <button type="button" class="skip-arrow" aria-label="menu"></button>
  <div class="top-hold">
    <h1><a href="<?php print $front_page; ?>" rel="home" class="logo"><span><?php print $site_name; ?></span></a></h1>
    <?php print render($page['search']); ?>
  </div>
  <nav id="main-nav" class="nav main">
    <?php if ($main_menu) : ?>
      <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('class' => array('main')))); ?>
    <?php endif; ?>
  </nav>
</header>
