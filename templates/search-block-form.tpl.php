<?php
/**
 * @file
 * Returns the HTML for search  with bare minimum HTML.
 *
 */
//dpm($search['search_block_form']);
?>
<label for="edit-search-block-form--2"><span>Search this site:</span></label>

<fieldset>
<div class="search-contain">
<?php echo $search['search_block_form']; ?>
<?php echo $search['hidden']; ?>
<input type="submit" name="op" id="edit-submit" value="" class="form-submit search">

</div>
</fieldset>