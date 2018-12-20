<?php if (isset($page['globalnav']) && !empty($page['globalnav'])) : ?>
<nav class="global">
  <?php print render($page['globalnav']); ?>
</nav>
<?php endif; ?>

<a id="main-content"></a>
<header class="banner">
  <h1>
    <a href="<?php print $front_page; ?>" title="Home" rel="home" class="logo">
      <span>
        <?php print $site_name; ?>
      </span>
    </a>
  </h1>
  <?php print render($page['search']); ?>
</header>
<?php if ($action_links): ?>
<ul class="action-links">
  <?php print render($action_links); ?>
</ul>
<?php endif; ?>
<main>
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
  <?php if (isset($messages)) : ?>
  <?php print $messages; ?>
  <?php endif; ?>
  <div id="content">
    <div class="flexhold">
      <section class="featured-more">
        <div class="hometophold">
          <div class="hometopleft">
            <?php  print render($page['umb_homepage_top']);  ?>
          </div>
          <div class="hometopright node-mc">
          
            <div class="special">Welcome<span> to MediaCommons</span>!</div>
            <div class="maintext">
              We are a community network for scholars, students, and practitioners in media studies, promoting exploration of new forms of publishing within the field.
            </div>
            <div class="readmoreabout">
               <a href="/about"> Read more...</a>
            </div>
          </div>
        </div>
        <?php  print render($page['umb_homepage_bottom']); ?>
      </section>
      <aside>
        <?php print render($page['umb_homepage_sidebar']); ?>
      </aside>
    </div>
  </div>
</main>

<?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
<?php print render($page['footer']); ?>
<?php endif; ?>