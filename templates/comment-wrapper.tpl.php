<?php
/**
 * @file
 * Returns the HTML for a wrapping container around comments.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728230
 */

  // Render the comments and form first to see if we need headings.
  $comments = render($content['comments']);
  $comment_form = render($content['comment_form']);
  $dest = drupal_get_destination();
  $log_in_link = NULL;
  $register_link = NULL;
  $comments_link = FALSE;  
  if (user_is_anonymous()) {
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
        $register_link = l(t('register'), 'user/register', $query);
      }
  }  
?>
<section id="comments" class="comments <?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if ($comments && $node->type != 'forum'): ?>
    <div class="comments-all">
      <?php print render($title_prefix); ?>
      <header>
        <h1 class="comments__title title"><?php print t('Comments'); ?></h1>
      </header>
      <?php print render($title_suffix); ?>
      <?php print $comments ; ?>
    </div>
  <?php endif; ?>
  <?php if ($comment_form): ?>
   <header class="comments-add">
     <h2 class="comments__form-title title"><?php print t('Add new comment'); ?></h2>
   </header>
   <div class="form-wrap">
    <?php print $comment_form; ?>
  </div>
  <?php else: ?>
    <header> 
      <h2 class="comments__form-title title"><?php print t('Add new comment'); ?></h2>
    </header>
    <div class="form-wrap">
      <?php print  $log_in_link ?>
      <?php if ($register_link) : ?>
        <span class="separator">or</span>
        <?php print $register_link ?>
      <?php endif; ?>      
      <span> to add a comment.</span>
    </div>
  <?php endif; ?>
</section>
