<?php

/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */

const MEDIACOMMONS_DOMAIN_PLACEHOLDER = 'http://[MEDIACOMMONS_DOMAIN]/';

/**
 * Implementation of hook_theme().
 * https://api.drupal.org/api/drupal/modules%21system%21system.api.php/function/hook_theme/7
 */
function mediacommons_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  $hooks['user_login'] = array(
    'render element' => 'form',
    'template' => 'templates/user-login',
  );
  $hooks['html__pjax'] = array(
    'render element' => 'content',
    'base hook' => 'page',
    'template' => 'templates/html.pjax',
  );
  $hooks['apachesolrsortlist'] = array(
    'variables' => array(),
    'template' => 'templates/components/apachesolrsortlist',
  );
  $hooks['page__pjax'] = array(
    'render element' => 'content',
    'base hook' => 'page',
    'template' => 'templates/page.pjax',
  );
  $hooks['node__pjax'] = array(
    'render element' => 'content',
    'base hook' => 'page',
    'template' => 'templates/node.pjax',
  );
  return $hooks;
}

/**
 * Implementation of template_preprocess_html().
 * See: https://api.drupal.org/api/drupal/includes%21theme.inc/function/template_preprocess_html/7.x
 */
function mediacommons_preprocess_html(&$variables) {
  $special_body_class = mediacommons_special_body_class();
  $no_sidebars = array_search('no-sidebars', $variables['classes_array']);
  $is_pjax = mediacommons_is_pjax();
  if ($is_pjax) {
    $variables['theme_hook_suggestions'][] = 'html__pjax';
  }
  if ($special_body_class) {
    $variables['classes_array'][] = $special_body_class;
   $variables['special_body_class'] = $special_body_class;
  }
  if ($no_sidebars !== false) { // should we test true instead of "!== false"
    unset($variables['classes_array'][$no_sidebars]);
  }
}

function mediacommons_preprocess_image_style(&$variables) {
  $class = '';
  $style_name = $variables['style_name'];
  switch ($style_name) {
    case 'profile_page_pic':
      $class = 'u-photo photo';
      break;
    case 'profile_pic_small':
      $class = 'u-photo photo u-photo-small';
      break;
  }
  $variables['attributes']['class'][] = $class;
}

function mediacommons_form($variables) {
  $element = $variables['element'];
  if (isset($element['#action'])) {
    $element['#attributes']['action'] = drupal_strip_dangerous_protocols($element['#action']);
  }
  element_set_attributes($element, array('method', 'id'));
  if (empty($element['#attributes']['accept-charset'])) {
    $element['#attributes']['accept-charset'] = 'UTF-8';
  }
  // remove extraneous div
  return '<form' . drupal_attributes($element['#attributes']) . '>' . $element['#children'] . '</form>';
}

function mediacommons_form_element($variables) {

  $output = '';

  $element = $variables['element'];

  $prefix = isset( $element['#field_prefix'] ) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';

  $suffix = isset( $element['#field_suffix'] ) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  $name = isset($element['#name']) ? $element['#name'] : NULL;

  if (($name != 'search_block_form') && ($name != 'search_block_form_mcsolr')) {

    // This function is invoked as theme wrapper, but the rendered form element
    // may not necessarily have been processed by form_builder().
    $element += array(
      '#title_display' => 'before',
    );

    // Add element #id for #type 'item'.
    if ( isset( $element['#markup'] ) && !empty( $element['#id'] ) ) {
      $attributes['id'] = $element['#id'];
    }
    // Add element's #type and #name as class to aid with JS/CSS selectors.
    $attributes['class'] = array( 'form-item' );
    if ( !empty( $element['#type'] ) ) {
      $attributes['class'][] = 'form-type-' . strtr( $element['#type'], '_', '-' );
    }
    if ( !empty( $element['#name'] ) ) {
      $attributes['class'][] = 'form-item-' . strtr( $element['#name'], array( ' ' => '-', '_' => '-', '[' => '-', ']' => '' ) );
    }
    // Add a class for disabled elements to facilitate cross-browser styling.
    if ( !empty( $element['#attributes']['disabled'] ) ) {
      $attributes['class'][] = 'form-disabled';
    }
    $output = '<div' . drupal_attributes( $attributes ) . '>' . "\n";

    // If #title is not set, we don't display any label or required marker.
    if ( !isset( $element['#title'] ) ) {
      $element['#title_display'] = 'none';
    }

    switch ( $element['#title_display'] ) {
      case 'before':
      case 'invisible':
        $output .= ' ' . theme( 'form_element_label', $variables );
        $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
        break;
      case 'after':
        $output .= ' ' . $prefix . $element['#children'] . $suffix;
        $output .= ' ' . theme( 'form_element_label', $variables ) . "\n";
        break;
      case 'none':
      case 'attribute':
        // Output no label and no required marker, only the children.
        $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
        break;
    }

    if (!empty( $element['#description'])) {
      $output .= '<div class="description">' . $element['#description'] . "</div>\n";
    }

    $output .= "</div>";

  }
  else {
    // Search Only; output no label and no required marker, only the children.
    $output = ' ' . $prefix . $element['#children'] . $suffix . "\n";
  }
  return $output;
}

function mediacommons_form_user_register_form_alter(&$form, &$form_state, $form_id) {
  drupal_set_title(t('Register new account'));
}

function mediacommons_form_search_block_form_alter(&$form, &$form_state, $form_id) {
  // HTML5 placeholder attribute
  // Do not change the name attribute, it will break search.
  $form['search_block_form']['#attributes']['placeholder'] = t('Search...');
  $form['search_block_form']['#attributes']['aria-label'] = t('Search');
  $form['#prefix'] = '';
  $form['#suffix'] = '';
}

function mediacommons_form_comment_node_spoke_form_alter(&$form, &$form_state, $form_id) {
  $form['subject']['#size'] = "auto";
  $form['comment_preview']['#weight'] = -5;
  $form['comment_output_below']['#weight'] = -10;
  $form['aa_comment'] = array(
    '#type' => 'fieldset',
    '#title' => NULL,
    '#collapsible' => FALSE,
    '#weight' => 10,
  );
  // Author
  $form['aa_comment']['author'] = $form['author'];
  unset($form['author']);
  $form['aa_comment']['author']['#weight'] = -10;
  // Subject
  $form['aa_comment']['subject'] = $form['subject'];
  unset($form['subject']);
  $form['aa_comment']['subject']['#weight'] = -1;
  // Comment
  $form['aa_comment']['comment_body'] = $form['comment_body'];
  unset($form['comment_body']);
  // Actions
  $form['aa_comment']['actions'] = $form['actions'];
  unset($form['actions']);
}

function mediacommons_form_user_login_alter(&$form, &$form_state, $form_id) {
  $form['name']['#attributes']['placeholder'] = t('Username or email address');
  $form['name']['#description'] = t('You may login with either your assigned username or your e-mail address.');
  $form['name']['#size'] = 28;
  $form['pass']['#attributes']['placeholder'] = t('Password');
  $form['pass']['#description'] = t('The password field is case sensitive.');
  $form['pass']['#size'] = 28;
  $form['actions']['submit']['#value'] = t('Login');
}

function mediacommons_form_user_login_block_alter(&$form, &$form_state, $form_id) {
  mediacommons_form_user_login_alter($form, $form_state, $form_id);
}

/**
 * Implementation of template_preprocess_html().
 * See: http://api.drupal.org/api/drupal/includes%21theme.inc/function/template_process_page/7
 */
function mediacommons_preprocess_page(&$vars) {
  $special_body_class = mediacommons_special_body_class();
  $is_pjax = mediacommons_is_pjax();
  if ($is_pjax) {
    $vars['theme_hook_suggestions'][] = 'page__pjax';
  }
  if (isset( $vars['node'])) {
    $vars['theme_hook_suggestions'][] = 'page__'. $vars['node']->type;
  }
  if ( isset( $vars['page']['content']['system_main']['no_content'] ) ) {
    unset( $vars['page']['content']['system_main']['no_content'] );
  }
  if ( arg( 0 ) == 'taxonomy' && arg( 1 ) == 'term' && is_numeric( arg( 2 ) ) ) {
    $term = taxonomy_term_load( arg( 2 ) );
    $vars['theme_hook_suggestions'][] = 'page__vocabulary__' . $term->vocabulary_machine_name;
  }
  if ( $special_body_class == 'mc' ) {
    if ( in_array( "page__front", $vars['theme_hook_suggestions'] ) ) {
      $vars['theme_hook_suggestions'][] = 'page__front__mc';
    }
  }
  if ( $special_body_class == 'int' ) {
    if ( in_array( "page__spoke", $vars['theme_hook_suggestions'] ) ) {
      $vars['theme_hook_suggestions'][] = 'page__spoke__int';
    }
  }
}

/**
 * Implementation of template_preprocess_node().
 * See: https://api.drupal.org/api/drupal/modules%21node%21node.module/function/template_preprocess_node/7.x
 */
function mediacommons_preprocess_node(&$variables) {
  // Node Object
  $node = $variables['node'];
  // Entity API
  $wrapper = entity_metadata_wrapper('node', $node);
  // Unified way of getting $node->type
  $bundle = $wrapper->getBundle();
  // Check for a PJAX request
  $is_pjax = mediacommons_is_pjax();
  // give project names as classes to the items on the umbrella site front page
  if ($bundle == 'front_page_post') {
    // name used for Fieldguide channel needs to be standardized 
    $projNameUsedSitewide = ($wrapper->field_project->value() == 'fg') ? 'fieldguide' : $wrapper->field_project->value();
    $variables['classes_array'][] = 'node-' . $projNameUsedSitewide;
  }
  if ($is_pjax) {
    $variables['theme_hook_suggestions'][] = 'node__pjax';
  }
}

function mediacommons_preprocess_username(&$variables) {
  $variables['name'] =  check_plain( $variables['name_raw'] );
  $account = $variables['account'];
  $variables['extra'] = '';
  if ( empty( $account->uid ) ) {
    $variables['uid'] = 0;
    if ( theme_get_setting( 'toggle_comment_user_verification' ) ) {
      $variables['extra'] = ' (' . t( 'not verified' ) . ')';
    }
  }
  else {
    $variables['uid'] = (int) $account->uid;
  }
  $variables['profile_access'] = user_access( 'access user profiles' );
  $variables['link_attributes'] = array();
  // Populate link path and attributes if appropriate.
  if ( $variables['uid'] && $variables['profile_access'] ) {
    // We are linking to a local user.
    $variables['link_attributes'] = array( 'title' => t( 'User profile: ' . $variables['name'] ) );
    $variables['link_path'] = 'user/' . $variables['uid'];
  }
  elseif ( !empty( $account->homepage ) ) {
    // Like the 'class' attribute, the 'rel' attribute can hold a
    // space-separated set of values, so initialize it as an array to make it
    // easier for other preprocess functions to append to it.
    $variables['link_attributes'] = array( 'rel' => array( 'nofollow' ) );
    $variables['link_path'] = $account->homepage;
    $variables['homepage'] = $account->homepage;
  }
  // We do not want the l() function to check_plain() a second time.
  $variables['link_options']['html'] = TRUE;
  // Set a default class.
  $variables['attributes_array'] = array( 'class' => array( 'username' ) );
}

/**
 * Begin User Profiles
 */

function mediacommons_field__field_profile_name($vars) {
  if (isset( $vars['items'])) {
    return '<h1 class="p-name fn">' . $vars['items'][0]['#markup'] . '</h1>';
  }
}

function mediacommons_field__field_organization($vars) {
  if ( isset( $vars['items'] ) ) {
   return '<span class="p-org org">' . render($vars['items'][0]) . '</span>';
  }
}

function mediacommons_field__field_body__spoke($vars) {
  $special_body_class = mediacommons_special_body_class();
  $str = '<section class="body-text">';
  if (isset($vars['items'])) {
    if ($special_body_class == 'imr') {
      $str .= "<h2 class='curatorsnote'>Curator's Note</h2><div>" . $vars['items'][0]['#markup'] . '</div>';
    }
    elseif ($special_body_class == "int") {
      $str .= "<h2 class='curatorsnote'>Creator's Statement</h2><div>" . $vars['items'][0]['#markup'] . '</div>';
    }
    else {
      $str .= $vars['items'][0]['#markup'];
    }
  }
  $str .= '</section>';
  return $str;
}

function mediacommons_field__field_skype($vars) {
  return '<li><a class="u-url url skype" href="skype:'. $vars['items'][0]['#markup'] . '" rel="me"><span>' . $vars['items'][0]['#markup'] . '</span></a></li>';
}

function mediacommons_field__field_aim($vars) {
  return '<li><span class="p-aim">' . $vars['items'][0]['#markup'] . '</span></li>';
}

function mediacommons_field__field_twitter($vars) {
  return '<li><a class="u-url url twitter" href="https://twitter.com/'.  $vars['items'][0]['#markup']   . '" rel="me"><span>' . $vars['items'][0]['#markup'] . '</span></a></li>';
}

function mediacommons_field__field_email($vars) {
  return '<li><a class="u-email email" rel="external me"  href="mailto:' . $vars['element']['#items'][0]['email'] . '"><span>' . $vars['element']['#items'][0]['email'] . '</span></a></li>';
}

function mediacommons_field__field_url($vars) {
  return '<li><a class="u-url url www"  href="'.  $vars['items'][0]['#element']['url'] . '" rel="external me"><span>' . $vars['items'][0]['#element']['title'] . '</span></a></li>';
}

function mediacommons_field__field_phone($vars) {
  $phone = preg_replace( '/\D+/', '', $vars['items'][0]['#title'] );
  return '<li><a class="p-tel tel"  href="tel:+1'.   $phone  . '" rel="me"><span>' . $vars['items'][0]['#title'] . '</span></a></li>';
}

function mediacommons_field__post_date($vars) {
  return '<time class="post-date">' . $vars['items'][0]['#markup'] . '</time>';
}

function mediacommons_field__field_pubdate($vars) {
  $pubdateA = $vars['element']['#object']->field_pubdate;
  return '<time class="pubdate">' . $vars['items'][0]['#markup'] . '</time>';
}
function mediacommons_field__field_title($vars) {
  return '<span class="p-job-title title">' . $vars['items'][0]['#markup'] . '</span>';
}

function mediacommons_field__field_taxonomy__spoke($vars) {
  $output = '<div class="tags">';
  $output .= '<div class="label-inline">' . $vars['label'] . '</div><ul class="tags">';
  foreach ( element_children( $vars['items'] ) as $key ) {
    $output .= '<li><a href="' . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></li>';
  }
  $output .= '</ul></div>';
  return $output;
}

function mediacommons_field__field_taxonomy__hub($vars) {
  $output = '<div class="tags">';
  $output .= '<div class="label-inline">' . $vars['label'] . '</div><ul class="tags">';
  foreach ( element_children( $vars['items'] ) as $key ) {
    $output .= '<li><a href="' . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></li>';
  }
  $output .= '</ul></div>';
  return $output;
}

function mediacommons_field__field_taxonomy__user($vars) {
  $output = '<aside role="complementary" class="research_interests">';
  $output .= '<header><h1>' . $vars['label'] . '</h1></header><ul class="tags block">';
  foreach ( element_children( $vars['items'] ) as $key ) {
    $output .= '<li><a href="' . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></li>';
  }
  $output .= '</ul></aside>';
  return $output;
}

function mediacommons_field__name__user($vars) {
  $output = '<div class="p-name name fn">';
  $output .= $vars['items'][0]['#markup'];
  $output .= '</div>';
  return $output;
}

function mediacommons_field__field_bio__user($vars) {
  $output = '<aside role="complementary" class="bio"><header>';
  $output .= '<h1>' . $vars['label'] . '</h1></header><div>';
  $output .=  $vars['items'][0]['#markup'];
  $output .= '</div></aside>';
  return $output;
}

function mediacommons_field__field_plan__user($vars) {
  $output = '<aside role="complementary" class="plan"><header>';
  $output .= '<h1>' . $vars['label'] . '</h1></header><div>';
  $output .=  $vars['items'][0]['#markup'];
  $output .= '</div></aside>';
  return $output;
}

function mediacommons_field__field_tags($vars) {
  $output = '<div class="tags-block-spoke">' ;
  $output .= '<h2>' . $vars['label'] . '</h2><ul class="tags">';
  foreach ( element_children( $vars['items'] ) as $key ) {
    $output .= '<li><a href="'  . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></li>';
  }
  $output .= '</ul></div>';
  return $output;
}

function mediacommons_field__minimal__field_reviewer__review($vars) {
  if ( $vars['element']['#view_mode'] == 'teaser' ) {
    $output ='';
    $output .= '<div class="peoplelist">' ;
    if (isset($vars['items'][0]['#title'])) {
      $output .= $vars['label'] . ' ';
      foreach ( element_children( $vars['items'] ) as $key ) {
        $output .= '<span>' . drupal_render( $vars['items'][$key] ) . '</span> ';
      }
    }
    $output .= '</div>';
  }
  else {
    $output ='';
    $output .= '<h3 class="review-byline peoplelist">' ;
    if ( isset( $vars['items'][0]['#title'] ) ) {
      $output .= $vars['label'] . ' ';
      foreach ( element_children( $vars['items'] ) as $key ) {
        $output .= '<span>' . drupal_render( $vars['items'][$key] ) . '</span> ';
      }
    }
    $output .= '</h3>';
  }
  return $output;
}

function mediacommons_field__field_contributors($vars) {
  //  Used for spoke teasers, spoke teaser simplest, hubs
  $output ='';
  $output .= '<div class="peoplelist contributors">' ;
  if ( isset( $vars['items'][0]['#title'] ) ) {
    $output .= $vars['label'] . ' ';
    foreach ( element_children( $vars['items'] ) as $key ) {

      $output .= '<span class="h-card">' . drupal_render( $vars['items'][$key] ) . '</span> ';
    }
  }
  $output .= '</div>';
  return $output;
}

function mediacommons_field__field_curators_editors($vars) {
  $special_body_class = mediacommons_special_body_class();
  $output = '<div class="peoplelist curator">' ;
  if ($special_body_class === 'imr') {
    $output .=  '<span class="l">Theme week organized by </span>';
  }
  else {
    $output .=  '<span class="l">' . $vars['label']. ' </span>';
  }

  foreach ( element_children( $vars['items'] ) as $key ) {
    $u = $vars['items'][$key]['#options']['entity'];
    if ( count( $u->field_organization ) > 0 ) {
      $tid = $u->field_organization['und'][0]['tid'];
      $term = taxonomy_term_load( $tid ); // load term object
      $term_uri = taxonomy_term_uri( $term ); // get array with path
      $term_title =  taxonomy_term_title( $term );
      $term_path = $term_uri['path'];
      $link = l( $term_title, $term_path );
    }
    $output .= '<div class="h-card">';
    $output .= '<span class= "p-name name fn"><a href="'  . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></span>';
    if ( !empty( $link ) ) {
      $output .=  '<span class="p-org">' . $link . '</span>';
    }
    $output .= '</div>';
  }
  $output .= '</div>';
  return $output;
}

function mediacommons_field__field_co_editor($vars) {
  $output = '<div class="peoplelist">' ;
  $output .= '<div class="field-label">' . $vars['label'] . '</div><ul>';
  foreach ( element_children( $vars['items'] ) as $key ) {
    $output .= '<li><a href="'  . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></li>';
  }
  $output .= '</ul></div>';
  return $output;
}

function mediacommons_preprocess_menu_tree(&$variables) {
  $tree = new DOMDocument();
  @$tree->loadHTML($variables['tree']);
  $links = $tree->getElementsByTagname('li');
  foreach ($links as $link) {
    $parentname = $link->getAttribute('data-menu-parent-name');
    $level = $link->getAttribute('data-level');
    break;
  }
  $variables['menu_parent_name'] = $parentname;
  $variables['level'] = $level;
}

/**
 * Implements hook_menu_tree().
 */
function mediacommons_menu_tree__menu_mcglobalnav($variables) {
  // here is where you can affect the <ul> elements
  if ( $variables['level'] == '2') {
    // For Channel navigation
    return '<ul aria-hidden="true">' . $variables['tree'] . '</ul>';
  } else {
    return '<ul aria-label="MediaCommons Global Navigation Menu" >' . $variables['tree'] . '</ul>';
  }
}

/**
 * Implements hook_menu_link().
 */
function mediacommons_menu_link__menu_mcglobalnav($variables) {
  $element = $variables['element'];
  // https://api.drupal.org/comment/11474#comment-11474
  $name_id = strtolower( strip_tags( $element['#title'] ) );
  // remove colons and anything past colons
  if ( strpos( $name_id, ':' ) ) $name_id = substr( $name_id, 0, strpos( $name_id, ':' ) );
  //Preserve alphanumerics, everything else goes away
  $pattern = '/[^a-z]+/ ';
  $name_id = preg_replace( $pattern, '', $name_id );
  $element['#attributes']['class'][] = $name_id;

  //  Links
  if ( $element['#original_link']['depth'] == '1' ) {
    // List Items
    if ( in_array( "first", $element['#attributes']['class'] ) ) {
      // SITES NAV  --  LOGIN, MY ACCOUNT
      // This sets the classes for the <li> tag
      $element['#attributes']['class'][] = 'sites_nav';
      // This sets the classes for the link itself
      $element['#localized_options']['attributes']['class'][] = "logolink";
      $element['#localized_options']['attributes']['class'][] = "mc-logo";
      $element['#title'] = '<span>' . $element['#title'] . '</span>';
    } else {
      // USER UTILITIES --  LOGIN, MY ACCOUNT
      $element['#attributes']['class'][] = 'utils' ;
      if ( $name_id == "myaccount" ) {
        global $user, $base_path;
        if ( user_is_anonymous() ) {
          return;
        }
        $element['#attributes']['class'][] = 'logged-in' ;
        $element['#localized_options']['attributes']['class'][] = "login-link";
        $element['#title'] = $user->name;
      }
      else if ( $name_id == "login" ) {
          $element['#attributes']['aria-haspopup'] = "true";
          $element['#attributes']['class'][] = 'logged-out' ;
          $element['#localized_options']['attributes']['class'][] = "login-link";
          $output = l( $element['#title'], $element['#href'], $element['#localized_options'] );
          $formLogin = drupal_get_form( 'user_login' );
          $pop = '<ul class="login-area" aria-hidden="true" style="">
        <li role="menuitem">' . render( $formLogin ) . '</li></ul>';
          return '<li' . drupal_attributes( $element['#attributes'] ) . '>' . $output . $pop . "</li>\n";
        }
    }
    $element['#localized_options']['html'] = true;
  }
  $sub_menu = '';
  if ( $element['#below'] ) {
    $sub_menu = drupal_render( $element['#below'] );
  }
  // Links to the various Media Commons sites use a domain placeholder that needs
  // to be filled in with the current host name.  We can't use relative paths
  // for various reasons, and don't want to hardcode the domain because this site
  // needs to run on other hosts like dev, stage, and various localhosts.
  // See https://jira.nyu.edu/browse/MC-188
  // "Link URLs in global navigation bar have hardcoded hostnames"
  if ( strpos( $element['#href'], MEDIACOMMONS_DOMAIN_PLACEHOLDER ) === 0 ) {
    $element['#href'] = get_url_for_mediacommons_site( $element[ '#href'] );
  }

  $output = l( $element['#title'], $element['#href'], $element['#localized_options'] );

  // Define special variables for use in hook_menu_tree
  //$element['#attributes']['data-menu-parent-name'] = $element['#original_link']['menu_name'];
  $element['#attributes']['data-level'] = $element['#original_link']['depth'];
  return '<li' . drupal_attributes( $element['#attributes'] ) . '>' . $output . $sub_menu . "</li>\n";
}

function mediacommons_preprocess_block(&$variables) {
   $special_body_class = mediacommons_special_body_class();
   $variables['theme_hook_suggestions'][] = 'block__' . $variables['block']->region . "__" . $special_body_class;
   $variables['classes_array'][] = "mc-" . $special_body_class;
   /* this will show a block's parent view; otherwise not straightforward in Drupal */
   $pos = strrpos($variables['block']->delta,  "-");
   $variables['classes_array'][] =   substr($variables['block']->delta, 0, $pos)  ;
}

function mediacommons_preprocess_field(&$variables) {
  $special_body_class = mediacommons_special_body_class();
  $variables['classes_array'][] = "mc-" . $special_body_class;
  if ($variables['element']['#field_name'] == 'field_representative_image') {
    if (!empty($variables['element']['#field_type']) && !empty($variables['items'][0]['#item']['is_default']) && $variables['element']['#field_type']=='image' && $variables['items'][0]['#item']['is_default'] == TRUE ) {
      $variables['classes_array'][] = 'default-image';
    }
  }
}

function mediacommons_comment_post_forbidden($variables) {
  global $user;
  // Node object
  $node = $variables['node'];
  // Since this is expensive to compute, we cache it so that a page with many
  // comments only has to query the database once for all the links.
  $authenticated_post_comments = &drupal_static(__FUNCTION__, NULL);
  if (!$user->uid) {
    if (!isset($authenticated_post_comments)) {
      // We only output a link if we are certain that users will get permission
      // to post comments by logging in.
      $comment_roles = user_roles(TRUE, 'post comments');
      $authenticated_post_comments = isset($comment_roles[DRUPAL_AUTHENTICATED_RID]);
    }
    if ($authenticated_post_comments) {
      $project = $hail = variable_get('mediacommons_project', 'mediacommons');
      if (isset($parameters['project'])) {
        $hail = $parameters['project'];
      }

      // http://localhost:8000/fieldguide/user/login
      // http://localhost:8000/mediacommons/user/login?destination=node/685%23comment-form&project=fieldguide

      // We cannot use drupal_get_destination() because these links
      // sometimes appear on /node and taxonomy listing pages.
      if (variable_get('comment_form_location_' . $node->type, COMMENT_FORM_BELOW) == COMMENT_FORM_SEPARATE_PAGE) {
        $destination = array('destination' => "comment/reply/$node->nid#comment-form");
      }
      else {
        $destination = array('destination' => "node/$node->nid#comment-form");
      }
      if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
        // Users can register themselves.
        return t('<a href="@login">Log in</a> or <a href="@register">register</a> to reply to this comment', array('@login' => url('user/login', array('query' => $destination)), '@register' => url('user/register', array('query' => $destination))));
      }
      else {
        // Only admins can add new users, no public registration.
        return t('<a href="@login">Log in</a> to reply to this comment', array('@login' => url('user/login', array('query' => $destination))));
      }
    }
  }
}

function mediacommons_preprocess_comment(&$variables) {

  $comment = $variables['elements']['#comment'];

  $node = $variables['elements']['#node'];

  $variables['comment'] = $comment;

  $variables['node'] = $node;

  $variables['author'] = theme('username', array('account' => $comment));

  $user = user_load($comment->uid);

  // Get Organization of the commenter, and send that variable on to the template
  if ($orgA = field_get_items('user', $user, 'field_organization')) {
    $term = taxonomy_term_load($orgA[0]['tid']); // load term object
    $term_uri = taxonomy_term_uri($term); // get array with path
    $term_attributes = array('attributes' => array('title' => t('@title', array('@title' =>  taxonomy_term_title($term)))));
    $variables['organization'] = l($term_attributes['attributes']['title'], $term_uri['path'], $term_attributes);
  }

  $variables['created'] = format_date($comment->created, 'custom', 'l, F j, Y —  g:i a');

  $variables['createdmachine'] = format_date($comment->created, 'custom', 'Y-m-j');

  // Avoid calling format_date() twice on the same timestamp.
  if ($comment->changed == $comment->created) {
    $variables['changed'] = $variables['created'];
  }
  else {
    $variables['changed'] = format_date($comment->changed);
  }

  $variables['new'] = !empty($comment->new) ? t('new') : '';

  $variables['picture'] = theme_get_setting('toggle_comment_user_picture') ? theme('user_picture', array('account' => $comment)) : '';

  $variables['signature'] = $comment->signature;

  $uri = entity_uri('comment', $comment);

  $uri['options'] += array('attributes' => array('class' => array('permalink'), 'rel' => 'bookmark'));

  $variables['title'] = l($comment->subject, $uri['path'], $uri['options']);

  $variables['permalink'] = l(t('Permalink'), $uri['path'], $uri['options']);

  $variables['submitted'] = t('Submitted by !username on !datetime', array('!username' => $variables['author'], '!datetime' => $variables['created']));

  // Preprocess fields.
  field_attach_preprocess('comment', $comment, $variables['elements'], $variables);

  // Helpful $content variable for templates.
  foreach (element_children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }

  // Set status to a string representation of comment->status.
  if (isset($comment->in_preview)) {
    $variables['status'] = 'comment-preview';
  }
  else {
    $variables['status'] = ($comment->status == COMMENT_NOT_PUBLISHED) ? 'comment-unpublished' : 'comment-published';
  }

  // Gather comment classes.
  // 'comment-published' class is not needed, it is either 'comment-preview' or
  // 'comment-unpublished'.
  if ($variables['status'] != 'comment-published') {
    $variables['classes_array'][] = $variables['status'];
  }
  if ($variables['new']) {
    $variables['classes_array'][] = 'comment-new';
  }
  if (!$comment->uid) {
    $variables['classes_array'][] = 'comment-by-anonymous';
  }
  else {
    if ($comment->uid == $variables['node']->uid) {
      $variables['classes_array'][] = 'comment-by-node-author';
    }
    if ($comment->uid == $variables['user']->uid) {
      $variables['classes_array'][] = 'comment-by-viewer';
    }
  }
}

function mediacommons_special_body_class() {
  $special_body_class = &drupal_static('special_body_class');
  if (!isset($special_body_class)) {
    $class = theme_get_setting('special_body_class');
    if (!empty($class)) {
      $special_body_class = $class;
    }
    else {
      $special_body_class = '';
    }
  }
  return $special_body_class;
}

function mediacommons_is_pjax() {
  return mediacommons_apis_is_pjax();
}

function get_url_for_mediacommons_site($placeholder_url) {
  $relative_path = str_replace( MEDIACOMMONS_DOMAIN_PLACEHOLDER, '', $placeholder_url );
  return mc_get_root_url() . "/${relative_path}";
}

/**
 * Facets
 */

function mediacommons_facetapi_count($variables) {
  return '<span class="facetapi-count">(' . (int) $variables['count'] . ')</span>';
}

function mediacommons_facetapi_deactivate_widget($variables) {
  $sanitize = empty($variables['options']['html']);
  $link_text = ($sanitize) ? check_plain($variables['text']) : $variables['text'];
  return $link_text . ' <div class="removeme icon-cross"></div>' ;
}

function mediacommons_facetapi_link_active($variables) {
  $sanitize = empty($variables['options']['html']);
  $link_text = ($sanitize) ? check_plain($variables['text']) : $variables['text'];
  // Theme function variables fro accessible markup.
  // @see http://drupal.org/node/1316580
  $accessible_vars = array(
    'text' => $variables['text'],
    'active' => TRUE,
  );
  // Builds link, passes through t() which gives us the ability to change the
  // position of the widget on a per-language basis.
  $replacements = array(
    '!facetapi_deactivate_widget' => theme('facetapi_deactivate_widget', $variables),
    '!facetapi_accessible_markup' => theme('facetapi_accessible_markup', $accessible_vars),
  );
  $variables['text'] = t('!facetapi_deactivate_widget !facetapi_accessible_markup', $replacements);
  $variables['options']['html'] = TRUE;
  return theme_link($variables) ;
}

/**
 * A replacement for l()
 *  - doesn't add the 'active' class
 *  - retains all $_GET parameters that ApacheSolr may not be aware of
 *  - if set, $options['query'] MUST be an array
 *
 * @see http://api.drupal.org/api/function/l/6
 *   for parameters and options.
 *
 * @return
 *   an HTML string containing a link to the given path.
 */
function mediacommons_apachesolr_l($text, $path, $options = array()) {
  // Merge in defaults.
  $options += array(
    'attributes' => array(),
    'html' => FALSE,
    'query' => array(),
  );

  // Don't need this, and just to be safe.
  unset($options['attributes']['title']);

  // Retain GET parameters that Apache Solr knows nothing about.
  $get = array_diff_key($_GET, array('q' => 1, 'page' => 1, 'solrsort' => 1), $options['query']);
  $options['query'] += $get;

  return check_url(url($path, $options));
}

function mediacommons_apachesolr_sort_list($vars) {
  // apachesolr_sort_list
  $vars['items'] = array_values($vars['items']);
  return theme('apachesolrsortlist', array('items' => $vars['items']));
}

function mediacommons_apachesolr_sort_link($vars) {
  $selected = ($vars['active']) ? ' selected' : '';
  // path
  $value = mediacommons_apachesolr_l($vars['text'], $vars['path'], $vars['options']);

  return '<option value="' . $value. '"'. $selected .'>' . $vars['text'] . '</option>';

}

 function mediacommons_form_required_marker($variables) {
   $attributes = array(
     'class' => 'form-required',
      'title' => t('This field is required.'),
      'aria-hidden' => 'true'
   );
  return '<span' . drupal_attributes($attributes) . '>*</span>';

 }
