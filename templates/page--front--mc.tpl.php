<a id="main-content"></a>
<header  role="banner"> 
  <h1><a href="<?php print $front_page; ?>" title="Home" rel="home" class="logo"><span><?php print $site_name; ?></span></a></h1>
  <?php print render($page['search']); ?>
</header>
<?php if ($action_links): ?>
  <ul class="action-links">
    <?php print render($action_links); ?>
  </ul>
<?php endif; ?>
<main role="main">
  <?php if (isset($tabs)): ?>
    <div class="tabs"><?php print render($tabs); ?></div>
  <?php endif; ?>
  <?php if (isset($page['highlighted'])) : ?>
    <div id="highlighted"><?php print render($page['highlighted']); ?></div>
  <?php endif; ?>
  <?php if (isset($messages)) : ?>
    <?php print $messages; ?>
  <?php endif; ?>
  <div id="content"> 
    <div class="flexhold">
      <section class="featured-more">  
        <div class="hometophold">
          <div class="hometopleft"><?php  print render($page['umb_homepage_top']);  ?></div>
          <div class="hometopright">
            <p><span class="special">Placeholder!  Welcome</span> Fermentum posuere parturient egestas suscipit mi mi ad faucibus viverra habitasse dictumst vestibulum convallis condimentum parturient.Per ac euismod varius per elit eget at parturient nibh laoreet leo vulputate a mi vestibulum ullamcorper justo consectetur ad a nec.</p>
            <p><a href="#">Elit mi justo volutpat</a></p>
          </div>
        </div>
        <?php  print render($page['umb_homepage_bottom']); ?> 
      </section>
      <aside role="complementary">
        <?php print render($page['umb_homepage_sidebar']); ?>
      </aside>
     </div>
    </div>
  </main>
  <?php if (isset($page['globalnav']) && !empty($page['globalnav'])) : ?>
    <nav class="global" role="navigation"><?php print render($page['globalnav']); ?></nav>
  <?php endif; ?>
  <?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
    <?php print render($page['footer']); ?> 
  <?php endif; ?>
 