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

<p class="extras"><strong>Field Guide:</strong> A <a href="<?php echo $mclink; ?>">MediaCommons</a> Project <br >
	<a rel="license" href="http://creativecommons.org/licenses/by/3.0/"><img alt="Creative Commons License" src="http://i.creativecommons.org/l/by/3.0/80x15.png"></a> All work at <span dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="title" rel="type"><b>The Field Guide</b></span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/" class="ext">Creative Commons Attribution 3.0 Unported License</a></p>
<?php  print $content; ?>