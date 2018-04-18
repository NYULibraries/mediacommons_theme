<?php $mclink = $GLOBALS['base_root'] . "/mediacommons"; 
 $main_menu = menu_navigation_links('main-menu'); ?>

  <nav class="footer-nav" role="navigation">
    <?php if ($main_menu) : ?>
      <?php print theme('links__system_main_menu', array('links' => $main_menu )); ?>
    <?php endif; ?>
  </nav>

  
<p class="extras"><strong>The New Everyday:</strong> A <a href="<?php echo $mclink; ?>">MediaCommons</a> Project<br>
  <a rel="license" href="http://creativecommons.org/licenses/by/3.0/"><img alt="Creative Commons License" src="http://i.creativecommons.org/l/by/3.0/80x15.png"></a> All work at <span dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="title" rel="type"><em>The New Everyday</em></span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/" class="ext">Creative Commons Attribution 3.0 Unported License</a>.
</p>
<?php print $content; ?>