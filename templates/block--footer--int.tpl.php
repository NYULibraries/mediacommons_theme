<?php $mclink = $GLOBALS['base_root'] . "/mediacommons"; 
$theme_path = $GLOBALS['base_path']  . drupal_get_path('theme', variable_get('theme_default', NULL));
?>
<div class= "<?php print $classes ?>">
  <p class="extras">
    <strong>[in]Transition:</strong> A <a href="<?php echo $mclink; ?>">MediaCommons</a>/<a href="http://www.cmstudies.org/?page=cinema_journal">Cinema Journal</a> Project | <a href="http://www.cmstudies.org/" target="_blank" title="Society For Cinema and Media Studies" style="line-height: 1;font-size: .1rem; display: inline-block; vertical-align: bottom;"><img alt="Society For Cinema and Media Studies" src="<?php echo $theme_path;?>/images/logos/scms_logo_sm.gif" ></a>&nbsp; |&nbsp;<a href="/intransition/copyright">Copyright/Fair Use Policy</a>
  </p>
  <?php print $content; ?>
</div>