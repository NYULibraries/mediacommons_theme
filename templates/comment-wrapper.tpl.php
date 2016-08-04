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
?>
<section id="comments" class="comments <?php print $classes; ?>"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>
  <?php if ($comments && $node->type != 'forum'): ?>
    <header><h1 class="comments__title title"><?php print t('Comments'); ?></h1></header>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php print $comments; ?>

  <?php if ($comment_form): ?>

   <header> <h2 class="comments__form-title title comment-form"><?php print t('Add new comment'); ?></h2></header>
   <div class="form-wrap">
    <?php print $comment_form; ?>
  </div>
  <?php else: ?>
<header> <h2 class="comments__form-title title comment-form">
  <?php print t('Add new comment'); ?></h2></header>
   <div class="form-wrap">
 
  <?php 
  
 
  $dest = drupal_get_destination();
  print l(t('Log in'),'user/login', array(
      'query' => $dest,
    )
  );
  // Print Register link only if allowed to do so.
  if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
    print ' or ';
    print l(t('register'),'user/register', array(
        'query' => $dest,
      )
    );
  }
  print " to add a comment.";
  ?>
  </div>

   <?php endif; ?>
</section>
