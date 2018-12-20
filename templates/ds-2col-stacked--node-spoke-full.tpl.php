<!-- ds 2 column stacked template -->
<<?php print $layout_wrapper; print $layout_attributes; ?> class="<?php print $classes;?> clearfix">
<?php if (isset($title_suffix['contextual_links'])): ?>
  <?php print render($title_suffix['contextual_links']); ?>
<?php endif; ?>
<?php //include 'jsonld.inc'; ?>
<header class="spoke-header">
  <?php print $header; ?>
</header>  
<<?php print $left_wrapper ?> class="spoke-body <?php print $left_classes; ?>">
  <?php print $left; ?>
  <?php 
    
    // @TODO: AOF1 - We need to move this code from here. difficult to debug.
    
    // this corrects a display suite bug which does not show comment wrapper for 
    // anonymous users when there are no comments 
    // Bug corroborated here: http://drupal.stackexchange.com/questions/85124/how-to-show-log-in-or-register-to-post-comments-message-when-no-comments-on-co
    $log_in_link = NULL;
    $register_link = NULL;
    $comments_link = FALSE;
    if (user_is_anonymous() && $comment_count == 0) {
      $comments_link = TRUE;
      $query = array('query' =>  
        array_merge(
          drupal_get_destination(), // get the destination
           array(
            'project' => variable_get('mediacommons_project', 'mediacommons') // add project
          )
        )
      );
      $log_in_link = l(t('Log in'), 'user/login', $query);
      if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
        $register_link = l(t('register'),'user/register', $query);
      }
    }
  ?>
  <?php if ($comments_link) : ?>
    <section id="comments" class="comments">
    <header>
      <h2 class="comments__form-title title comment-form">Add new comment</h2>
    </header>
    <?php print $log_in_link ?>
    <?php if ($register_link) : ?>
      <span class="separator">or</span>
      <?php print $register_link ?>
    <?php endif; ?>
    <span> to add a comment.</span>
    </section>  
  <?php endif; ?>
</<?php print $left_wrapper ?>>

<?php print $right; ?>
<aside>
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
