<?php
/**
 * @file
 * Returns the HTML for a block with bare minimum HTML.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728250
 */
?>


 <?php 
 //print  $content ;
 ?>

 <form role="search" action="<?php echo $_SERVER['PHP_SELF'];?>" accept-charset="UTF-8" method="post" id="search-block-form" class="form search header">
    <label for="edit-search-block-form-1"><span>Search this site:</span></label>
    <fieldset>
      <input type="search" maxlength="128" name="search_block_form" id="edit-search-block-form-1" size="15" value="" title="Enter the terms you wish to search for." placeholder="Search…" class="form-text">
      <input type="submit" name="op" id="edit-submit-2" value="" class="form-submit search">
      <input type="hidden" name="form_build_id" id="form-557ed34a66c4cb505955a9b7f85dd892" value="form-557ed34a66c4cb505955a9b7f85dd892">
      <input type="hidden" name="form_token" id="edit-search-block-form-form-token" value="78f5d7fa5d984995d90befe37926bf15">
      <input type="hidden" name="form_id" id="edit-search-block-form" value="search_block_form">
    </fieldset>
  </form>