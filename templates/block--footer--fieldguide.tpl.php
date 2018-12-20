<?php 
$main_menu = menu_navigation_links('main-menu'); 
?>

  <nav class="footer-nav">
    <?php if ($main_menu) : ?>
      <?php print theme('links__system_main_menu', array('links' => $main_menu )); ?>
    <?php endif; ?>
  </nav>


<p class="extras"><strong>Field Guide:</strong> A <a href="/">MediaCommons</a> Project </p>
<p class="cc-info">All work at <span dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="title" rel="type">The Field Guide</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/" class="ext cc-license">Creative Commons Attribution 3.0 Unported License</a></p>

<div class="footer-nav credits" ><ul> <li class="first"><a class="external" href="https://www.nyu.edu/footer/accessibility.html" target="_blank">Accessibility</a></li><li class="powered">Powered by <a href="http://dlib.nyu.edu/dlts/" target="_blank" class="external">NYU DLTS</a></li></ul></div>