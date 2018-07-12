<?php

/**
  * MediaCommons --
  * Spoke page for [in]Transition
  *
  * Display Suite fluid 3 column 25/50/25 stacked template.
*/

  // Add sidebar classes so that we can apply the correct width to the center region in css.
  if (($left && !$right) || ($right && !$left)) $classes .= ' group-one-sidebar';
  if ($left && $right) $classes .= ' group-two-sidebars';
  if ($left) $classes .= ' group-sidebar-left';
  if ($right) $classes .= ' group-sidebar-right';
?>
<<?php print $layout_wrapper; print $layout_attributes; ?> class="intransition_full <?php print $classes;?> clearfix">

  <?php if (isset($title_suffix['contextual_links'])): ?>
  <?php print render($title_suffix['contextual_links']); ?>
  <?php endif; ?>


  <?php
  $hub_id = $field_part_of["und"][0]['nid']; 
  $hub_node = node_load($hub_id);
  $hub_title = $hub_node->title;
  $hub_url = url( 'node/' . $hub_id ); 
?>

  <nav class="backToIssue"><a href="<?php print  $hub_url ?>"><?php print  $hub_title ?></a></nav>

   <header class="group-header <?php print $header_classes; ?>">
    <?php print $header; ?>
  </header>


<div class="int-full-sections">
 
  <?php if ($left): ?>
    <section class="group-1 <?php print $left_classes; ?>">
      <?php print $left; ?>
    </section>
  <?php endif; ?>

  <?php if ($middle): ?>
    <section class="group-2 <?php print $middle_classes; ?>">
      <?php print $middle; ?>
    </section>
  <?php endif; ?>

  <?php if ($right): ?>
    <section  class="group-3 <?php print $right_classes; ?>">
      <?php print $right; ?>
    </section>
  <?php endif; ?>
</div>
  <<?php print $footer_wrapper ?> class="group-footer<?php print $footer_classes; ?>">
    <?php print $footer; ?>
  </<?php print $footer_wrapper ?>>

</<?php print $layout_wrapper ?>>

<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>
