<?php
/**
 * @file
 * Returns the HTML for search  with bare minimum HTML.
 *
 */
//dpm($search['search_block_form']);
?>
<label for="edit-search-block-form-1"><span>Search this site:</span></label>

<fieldset>
<div class="search-contain">

  <input type="text" maxlength="128" name="search" id="edit-search-block-form-1" size="15" value="" title="Enter the terms you wish to search for." placeholder="Search…" class="form-text">

<input type="submit" name="op" id="edit-submit-2" value="" class="form-submit search">
<?php echo $search['hidden']; ?>
</div>
</fieldset>