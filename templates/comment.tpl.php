<?php
/**
 * @file
 * Returns the HTML for comments.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728216
 */
?>
<?php 
//dpm($comment);
?>
<?php 
if (isset($comment->depth)) {
  if ($comment->depth == 0) {
    $depthclass = "top-level";
  }  else{
    $depthclass = "depth-reply depth-reply-" . $comment->depth;
  } 
} else if (isset($comment->pid)) {
  if ($comment->pid == 0) {
    $depthclass = "top-level";
  }  else{
   $depthclass = "depth-reply" ;
  }
} else {
   $depthclass = "no-depth-set";
}

?>
<article class="<?php print $classes; ?> clearfix <?php print $depthclass ;  ?>" <?php print $attributes ;  ?>>
<header>
    <?php print render($title_prefix); ?>
    <?php if (isset($title)): ?>
      <h3<?php print $title_attributes; ?>>
        <?php print $title; ?>
        <?php if ($new): ?>

          <mark class="new"><?php print $new; ?></mark>
        <?php endif; ?>
      </h3>
    <?php elseif ($new): ?>
      <mark class="new"><?php print $new; ?></mark>
    <?php endif; ?>
    <?php print render($title_suffix); ?>


    <div class="h-card vcard clearfix">
      <?php  print '<div class="field-user-avatar photo u-photo-small">' . $picture . '</div>'; ?>
   
        <div class="nameHolder">By <span class="p-name"><?php print $author; ?> </span></div>
        <?php if (isset($organization)): ?>
          <span class="p-org org"><?php print $organization; ?></span>
        <?php endif; ?>
        </div>
    <?php //print $permalink; ?>
    <?php print '<time datetime="'. $createdmachine . '">'. $created . '</time>'; ?>
    <?php if ($status == 'comment-unpublished'): ?>
      <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
    <?php endif; ?>
  </header>

  <?php
    // We hide the comments and links now so that we can render them later.
    hide($content['links']);
    $c = $comment->comment_body['und'][0]['safe_value'] ? $comment->comment_body['und'][0]['safe_value'] : $comment->comment_body['und'][0]['value'];
     print "<div class='field-name-comment-body'>" . $c . "</div>";
  ?>



  <?php print render($content['links']) ?>
</article>
