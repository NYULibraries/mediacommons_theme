<?php
/**
 * @file
 * Returns the HTML for search  with bare minimum HTML.
 *
 */
?>
<label for="edit-search-block-form--2">
  <span>Search this site:</span>
</label>
<fieldset>
  <div class="search-contain">
    <?php print $search['search_block_form']; ?>
    <?php print $search['hidden']; ?>
    <input type="submit" name="op" value="" class="form-submit search"/>
  </div>
</fieldset>