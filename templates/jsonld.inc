<script type='application/ld+json'> 
{
  "@context": "http://schema.org/",
  "@type": "ScholarlyArticle",
  "creator":  [
 <?php
  $contributorsA= field_get_items('node', $node, 'field_contributors');
  foreach ($contributorsA as $i) {
    $name = user_load($i['uid'])->name;
    echo '{"@type": "Person", "name": "' . $name. '"}';
  }?>],
  "datePublished": "<?php
    $pubdate= field_get_items('node', $node, 'field_pubdate');
    if (!empty($pubdate[0]["value"])){
      echo date('Y-m-d',$pubdate[0]["value"]);
    }
  ?>",
  "headline": "<?php print $node->title; ?>",
  "keywords": [<?php
  $tagsA= field_get_items('node', $node, 'field_taxonomy');
  $tagsB = [];
  foreach ($tagsA as $i) {
    $new =  '"' .  $i["taxonomy_term"]->name . '"';
    $tagsB[] = $new;
  }
  echo implode(", ",$tagsB)
?>],
"image": "<?php 
$image = token_replace('[node:field_representative_image]', array('node' => $node));
  echo $image; ?>"
}
</script>