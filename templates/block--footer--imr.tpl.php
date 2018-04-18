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

<div class="extras footer-nav"><ul><li class="first"><strong>In Media Res:</strong> A <a href="<?php echo $mclink; ?>">MediaCommons</a> Project&nbsp;</li><li><a href="/imr/copyright">Copyright/Fair Use Policy</a></li></ul></div>

<?php print $content; ?>