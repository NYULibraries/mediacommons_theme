<?php 
// This  is to go inside a custom code field
?>

<script type='application/ld+json'>
{
  "@context": "http://schema.org/",
  "@type": "ScholarlyArticle",
  "headline": "[node:title]",
"creator": [
 <?php
  $contributorsA= field_get_items('node', $entity, 'field_contributors');
  foreach ($contributorsA as $i) {
    $name = user_load($i['uid'])->name;
    echo '{"@type": "Person",
    "name": "';
    echo $name;
    echo  '"}';
  }?>
],
 "datePublished": "[node:field-pubdate:custom:Y-m-d]",
"image": "[node:field_representative_image]",
"keywords": [
<?php
  $tagsA= field_get_items('node', $entity, 'field_taxonomy');
$tagsB = [];
  foreach ($tagsA as $i) {
$new =  '"' .  $i["taxonomy_term"]->name . '"';
       $tagsB[] = $new;
  }
echo implode(", ",$tagsB)
?>
  ]
}
</script>