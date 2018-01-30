<header  role="banner">
  <button type="button" class="skip-arrow"></button>
  <div class="top-hold">
    <h1><a href="<?php print $front_page; ?>" title="Home" rel="home" class="logo"><span><?php print $site_name; ?></span></a></h1>
    <?php print render($page['search']); ?>
  </div>
  <nav id="main-nav" class="nav main" role="navigation">
    <?php if ($main_menu) : ?>
      <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('class' => array('main')))); ?>
    <?php endif; ?>
  </nav>
</header>
