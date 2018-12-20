<?php 
$nid = $node->nid;
if ($nid) {
 $nid = $node->nid;
 $rendered_view = node_view(node_load($nid), 'full_intransition');
} 
?>

<?php  include ("head.inc");    ?>

  <?php if ($action_links): ?>
  <ul class="action-links">
    <?php print render($action_links); ?>
  </ul>
  <?php endif; ?>

<main>
  <?php if ($tabs) : ?>
      <div class="tabs"><?php print render($tabs); ?></div>
  <?php endif; ?>

  <?php if (isset($page['highlighted'])) : ?>
       <div id="highlighted"><?php print render($page['highlighted']); ?></div>
  <?php endif; ?>

  <?php if ($messages) : ?>
      <?php print $messages; ?>
  <?php endif; ?>

  <article class="spoke"><a id="main-content"></a>
   <?php 
  if ($nid) {
    print render($rendered_view);
  } else {
    print render($page['content']);
  }
  ?>
  </article>
 
</main>


<?php if (isset($page['footer']) && !empty($page['footer'])) : ?>
    <?php print render($page['footer']); ?>
<?php endif; ?>
