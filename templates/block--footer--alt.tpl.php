<?php
/**
 * @file
 * Returns the HTML for a block with bare minimum HTML.
 *
 */
?>
<?php 
  $mclink = $GLOBALS['base_root'] . "/mediacommons" ; 
?>
<p class="extras"><a rel="license" href="http://creativecommons.org/licenses/by/3.0/"><img alt="Creative Commons License" src="http://i.creativecommons.org/l/by/3.0/80x15.png"></a> All work at <span dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="title" rel="type"><em>#Alt-Academy</em></span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/" class="ext">Creative Commons Attribution 3.0 Unported License</a>.<br> <em>#Alt-Academy</em> is a project of <a href="<?php echo $mclink; ?>">MediaCommons</a>, a digital scholarly network.</p>
<?php print $content; ?>
