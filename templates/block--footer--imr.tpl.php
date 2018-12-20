<?php
/**
 * @file
 * Returns the HTML for a block with bare minimum HTML.
 *
 */
?>
<?php 
$main_menu = menu_navigation_links('main-menu');

?>
  <nav class="footer-nav">
    <?php if ($main_menu) : ?>
      <?php print theme('links__system_main_menu', array('links' => $main_menu )); ?>
    <?php endif; ?>
  </nav>

<div class="extras footer-nav"><ul><li class="first"><strong>In Media Res:</strong> A <a href="/">MediaCommons</a> Project&nbsp;</li><li><a href="/imr/copyright">Copyright/Fair Use Policy</a></li></ul></div>

<div class="footer-nav credits" ><ul> <li class="first"><a class="external" href="https://www.nyu.edu/footer/accessibility.html" target="_blank">Accessibility</a></li><li class="powered">Powered by <a href="http://dlib.nyu.edu/dlts/" target="_blank" class="external">NYU DLTS</a></li></ul></div>