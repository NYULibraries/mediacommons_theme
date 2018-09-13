<?php
$theme_path = $GLOBALS['base_path']  . drupal_get_path('theme', variable_get('theme_default', NULL));
$main_menu = menu_navigation_links('main-menu');
?>
<nav class="footer-nav" role="navigation">
  <?php if ($main_menu) : ?>
  <?php print theme('links__system_main_menu', array('links' => $main_menu )); ?>
  <?php endif; ?>
</nav>
<div class="footer-nav">
  <ul><li>
    <strong>[in]Transition:</strong> A
    <a href="/">MediaCommons</a> /
    <a href="https://www.cmstudies.org/?page=cinema_journal"  target="_blank">Cinema Journal</a> Project</li><li>
    <a href="https://www.cmstudies.org" target="_blank" title="Society For Cinema and Media Studies" style="line-height: 1;font-size: .1rem; display: inline-block; vertical-align: bottom;">
      <img alt="Society For Cinema and Media Studies" src="<?php echo $theme_path;?>/images/logos/scms_logo_sm.gif">
    </a></li><li>
    <a href="/intransition/copyright">Copyright/Fair Use Policy</a></li>
  </ul></div>
  <?php print $content; ?>
