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
<p class="extras"><strong>In Media Res:</strong> A <a href="<?php echo $mclink; ?>">MediaCommons</a> Project &nbsp; | &nbsp; <a href="/imr/copyright">Copyright/Fair Use Policy</a></p>

<?php print $content; ?>