<?php
/**
 * @file
 * Returns the HTML for a block with bare minimum HTML.
 *
 */
?>
<?php 
$mclink = $GLOBALS['base_root'] . "/mediacommons" ;
$main_menu = menu_navigation_links('main-menu'); 
?>

  <nav class="footer-nav" role="navigation">
    <?php if ($main_menu) : ?>
      <?php print theme('links__system_main_menu', array('links' => $main_menu )); ?>
    <?php endif; ?>
  </nav>


<p class="extras"><strong>Field Guide:</strong> A <a href="<?php echo $mclink; ?>">MediaCommons</a> Project </p>
<p class="cc-info">All work at <span dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="title" rel="type">The Field Guide</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/" class="ext cc-license">Creative Commons Attribution 3.0 Unported License</a></p>
<?php  print $content; ?>