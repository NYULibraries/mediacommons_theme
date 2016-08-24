<?php
/**
 * @file
 * Returns the HTML for comments.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728216
 */
?>
<article class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>



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

    <?php 
$formatted_date = format_date($comment->created, 'custom', 'l, F j, Y  -- g:i a');
$machine_date = format_date($comment->created, 'custom', 'Y-m-j');
print '<time datetime="'. $machine_date . '">'. $formatted_date . '</time>';
 ?>
    <div class="h-card vcard clearfix">
      <?php  print '<div class="field-user-avatar photo u-photo-small">' . $picture . '</div>'; ?>
   
        <div class="nameHolder">By <span class="p-name"><?php print $author; ?> </span></div>
        <?php if (isset($organization)): ?>
          <span class="p-org org"><?php print $organization; ?></span>
        <?php endif; ?>
        </div>
      <?php //print $permalink; ?>
 
    <?php if ($status == 'comment-unpublished'): ?>
      <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
    <?php endif; ?>
  </header>

  <?php
    // We hide the comments and links now so that we can render them later.
    hide($content['links']);
    print render($content);
  ?>



  <?php print render($content['links']) ?>
</article>
