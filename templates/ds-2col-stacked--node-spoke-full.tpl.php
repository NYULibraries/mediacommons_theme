<?php

/**
 * @file
 * Display Suite 2 column stacked template.
 */
?>
<<?php print $layout_wrapper; print $layout_attributes; ?> class="<?php print $classes;?> clearfix">

<?php if (isset($title_suffix['contextual_links'])): ?>
  <?php print render($title_suffix['contextual_links']); ?>
<?php endif; ?>

<?php print '<header class="spoke-header">'; ?>
  <?php print $header; ?>
<?php print "</header>"; ?>

<<?php print $left_wrapper ?> class="spoke-body <?php print $left_classes; ?>">
  <?php print $left; ?>

 
  <?php
  // this corrects a display suite bug which does not show comment wrapper for anonymous users when there are no comments 
  // Bug corroborated here: http://drupal.stackexchange.com/questions/85124/how-to-show-log-in-or-register-to-post-comments-message-when-no-comments-on-co
  global $user;
  if (!$user->uid && $comment_count == 0) {
      print '<section id="comments" class="comments">';
      print '<header> <h2 class="comments__form-title title comment-form">Add new comment</h2></header>';
      $dest = drupal_get_destination();
      print l(t('Log in'),'user/login', array(
      'query' => $dest,
      ));
      // Print Register link only if allowed to do so.
      if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
        print ' or ';
        print l(t('register'),'user/register', array(
          'query' => $dest,
        ));
      }
      print " to add a comment.";
      print '</section>';
  } ?> 


</<?php print $left_wrapper ?>>

<?php print $right; ?>

<aside role="complementary">
	<div class="block-views block">
		<?php print views_embed_view('all_spokes_in_this_spokes_hub', 'block_1');?>
	</div>
</aside>

  <<?php print $footer_wrapper ?> class="<?php print $footer_classes; ?>">
    <?php print $footer; ?>
  </<?php print $footer_wrapper ?>>

</<?php print $layout_wrapper ?>>

<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>