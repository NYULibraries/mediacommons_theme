<?php 
  $main_menu = menu_navigation_links('main-menu');
?>

<nav class="footer-nav">
  <?php if ($main_menu) : ?>
  <?php print theme('links__system_main_menu', array('links' => $main_menu )); ?>
  <?php endif; ?>
</nav>

<p class="extras"><a rel="license" href="https://creativecommons.org/licenses/by/3.0/"><img alt="Creative Commons License" src="https://i.creativecommons.org/l/by/3.0/80x15.png"></a> All work at <span dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="title" rel="type"><em>#Alt-Academy</em></span> is licensed under a <a rel="license" href="https://creativecommons.org/licenses/by/3.0/" class="ext">Creative Commons Attribution 3.0 Unported License</a>.<br> <em>#Alt-Academy</em> is a project of <a href="/">MediaCommons</a>, a digital scholarly network.</p>

<div class="footer-nav credits" ><ul> <li class="first"><a class="external" href="https://www.nyu.edu/footer/accessibility.html" target="_blank">Accessibility</a></li><li class="powered">Powered by <a href="http://dlib.nyu.edu/dlts/" target="_blank" class="external">NYU DLTS</a></li></ul></div>
