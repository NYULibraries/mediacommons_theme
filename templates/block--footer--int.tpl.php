<?php
$theme_path = $GLOBALS['base_path']  . drupal_get_path('theme', variable_get('theme_default', NULL));
$main_menu = menu_navigation_links('main-menu');
?>
<nav class="footer-nav">
  <?php if ($main_menu) : ?>
  <?php print theme('links__system_main_menu', array('links' => $main_menu )); ?>
  <?php endif; ?>
</nav>
<div class="footer-nav">
  <ul><li>
    <strong>[in]Transition:</strong> A
    <a href="/">MediaCommons</a> Project with 
    <a href="https://www.cmstudies.org/page/jcms"  target="_blank">JCSM</a></li><li>
    <a href="https://www.cmstudies.org" target="_blank" title="Society For Cinema and Media Studies" style="line-height: 1;font-size: .1rem; display: inline-block; vertical-align: bottom;">
      <img alt="Society For Cinema and Media Studies" src="<?php echo $theme_path;?>/images/logos/scms_logo_sm.gif">
    </a></li><li>
    <a href="/intransition/copyright">Copyright/Fair Use Policy</a></li>
  </ul></div>
<div class="footer-nav credits" ><ul> <li class="first"><a class="external" href="https://www.nyu.edu/footer/accessibility.html" target="_blank">Accessibility</a></li><li class="powered">Powered by <a href="http://dlib.nyu.edu/dlts/" target="_blank" class="external">NYU DLTS</a></li></ul></div>
