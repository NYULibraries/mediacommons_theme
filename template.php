<?php
/**
 *
 *
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */


function mediacommons_theme( &$existing, $type, $theme, $path ) {
  $hooks = zen_theme( $existing, $type, $theme, $path );

  $hooks['user_login'] = array(
    'render element' => 'form',
    'template' => 'templates/user-login',
    'preprocess functions' => array(
     // 'mediacommons_preprocess_user_login'
    ),
  );
  // $hooks['user_register_form'] = array(
  //   'render element' => 'form',
  //   'template' => 'user-register-form',
  //   'preprocess functions' => array(
  //     'mediacommons_preprocess_user_register_form'
  //   ),
  // );
  return $hooks;
}

function mediacommons_preprocess_html( &$vars ) {
  // An anonymous user has a user id of zero.

  /*drupal_add_css(path_to_theme() . '/css/specialcase.css', array('group' => CSS_THEME));*/
  $specialBodyClass   = theme_get_setting( 'special_body_class' );
  if ( !empty( $specialBodyClass ) ) {
    $vars['classes_array'][] = $specialBodyClass;
  }

 if (($key = array_search('no-sidebars', $vars['classes_array'])) !== false) {
    unset($vars['classes_array'][$key]);
}
}

function mediacommons_preprocess_image_style(&$variables) {
    if ($variables['style_name'] == 'profile_page_pic') {
        $variables['attributes']['class'][] = 'u-photo photo';
    }
}

function mediacommons_user_menu() {
  $items['user/login'] = array(
    'title' => 'Join',
    'access callback' => 'user_is_anonymous',
    'type' => MENU_DEFAULT_LOCAL_TASK,
  );

  // return $items;
}
function mediacommons_form_alter( &$form, &$form_state, $form_id ) {
  if ( in_array( $form_id, array( 'user_login', 'user_login_block' ) ) ) {
    $form['name']['#attributes']['placeholder'] = t( 'Username or email address' );
    $form['name']['#description'] = t("You may login with either your assigned username or your e-mail address.");
     $form['name']['#size'] = 28;
 
    $form['pass']['#attributes']['placeholder'] = t( 'Password' );
    $form['pass']['#description'] = t("The password field is case sensitive.");
    $form['pass']['#size'] = 28;
    $form['actions']['submit']['#value'] = t("Login");
  } else if ( $form_id == 'search_block_form' ) {
      // HTML5 placeholder attribute
      $form['search_block_form']['#attributes']['placeholder'] = t( 'Search...' );
      //$form['search_block_form']['#type'] = 'search';
   
      //$form['search_block_form'] = str_replace('type="text"', 'type="search"', $form['search_block_form']);
//dpm($form);
      $form['#prefix'] = '';
      $form['#suffix'] = '';

    }

}

/**
 * Implement template_preprocess_comment().
 */
function mediacommons_preprocess_comment(&$variables) {
  $comment = $variables['elements']['#comment'];
  $node = $variables['elements']['#node'];
  $variables['comment'] = $comment;
  $variables['node'] = $node;
  $variables['author'] = theme('username', array('account' => $comment));

  $variables['created'] = format_date($comment->created, 'long');

  // Avoid calling format_date() twice on the same timestamp.
  if ($comment->changed == $comment->created) {
    $variables['changed'] = $variables['created'];
  }
  else {
    $variables['changed'] = format_date($comment->changed);
  }

  $variables['new'] = !empty($comment->new) ? t('new') : '';
 // $variables['picture'] = theme_get_setting('toggle_comment_user_picture') ? theme('user_picture', array('account' => $comment)) : '';
  $variables['signature'] = $comment->signature;

  $uri = entity_uri('comment', $comment);
  $uri['options'] += array('attributes' => array(
    'class' => array('permalink'),
    'rel' => 'bookmark',
  ));

  $variables['title'] = l($comment->subject, $uri['path'], $uri['options']);
  $variables['permalink'] = l(t('Permalink'), $uri['path'], $uri['options']);
  $variables['submitted'] = t('Submitted by !username on !datetime', array('!username' => $variables['author'], '!datetime' => $variables['created']));
 
  $user_avatar='';
  //loading 'profile2' information
  $profile=profile2_load_by_user($comment->uid,'mediacommonsprofile');   
  if(is_object($profile)){
      //Showing 'profile2' image field picture instead of drupal default user image
      if(is_array($profile->field_user_avatar)&& count($profile->field_user_avatar)>0){
        $file_url=$profile->field_user_avatar['und'][0]['uri'];
               //Applying image style to that image 
         $user_avatar= theme('image_style', array('style_name' => 'user_avatar_comments', 'path' =>$file_url));
        }
        $organization = $profile->field_organization['und'][0]['value'];
    }
    $variables['user_avatar'] = $user_avatar;
    $variables['organization'] = $organization;
   
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
  // dpm($variables);
}


/**
 * Implement hook_form_comment_form_alter().
 */
function mediacommons_form_comment_form_alter(&$form, &$form_state) {
  //dpm($form);
  $form['subject']['#size'] = "auto";
} 


/** See: http://api.drupal.org/api/drupal/includes%21theme.inc/function/template_process_page/7 */
function mediacommons_preprocess_page( &$vars ) {
  /** Remove logo */
  // $vars['logo'] = null;

  if (isset($vars['node'])) {
    // If the node type is "blog_madness" the template suggestion will be "page--blog-madness.tpl.php".
    $vars['theme_hook_suggestions'][] = 'page__'. $vars['node']->type;
    // https://www.drupal.org/node/410908
    if ($vars['node']->type == 'spoke') {
       // unset($vars['sidebar']);
      }
  }
}
function mediacommons_field__minimal__field_full_name__mediacommonsprofile ($vars) {
   if (isset($vars['items'])) {
    return '<h1 class="p-name fn">' . $vars['items'][0]['#markup'] . '</h1>';
  }
}
function mediacommons_field__minimal__field_skype__mediacommonsprofile ($vars) {
  return '<li><a class="u-url url skype" href="skype:kfitz" rel="me"><span>' . $vars['items'][0]['#markup'] . '</span></a></li>';
}
function mediacommons_field__minimal__field_twitter__mediacommonsprofile ($vars) {
  return '<li><a class="u-url url twitter" href="https://twitter.com/'.  $vars['items'][0]['#markup']   . '" rel="me"><span>' . $vars['items'][0]['#markup'] . '</span></a></li>';
}
function mediacommons_field__minimal__field_email__mediacommonsprofile ($vars) {
  return '<li><a class="u-email email"  href="mailto:" rel="external me"><span>' . $vars['element']['#object']->field_email[und][0]['email'] . '</span></a></li>';
}
function mediacommons_field__minimal__field_url__mediacommonsprofile ($vars) {
  return '<li><a class="u-url url www"  href="'.  $vars['items'][0]['#href'] . '" rel="external me"><span>' . $vars['items'][0]['#title'] . '</span></a></li>';
}
function mediacommons_field__minimal__field_telephone__mediacommonsprofile ($vars) {
  $phone = preg_replace('/\D+/', '', $vars['items'][0]['#markup']);
  return '<li><a class="p-tel tel"  href="tel:+1'.   $phone  . '" rel="me"><span>' . $vars['items'][0]['#markup'] . '</span></a></li>';
}
function mediacommons_field__minimal__post_date ($vars) {
  return '<time>' . $vars['items'][0]['#markup'] . '</time>';
}

// function mediacommons_form_element($variables) {
//   $element = &$variables['element'];
//   //dpm($element);
//   // This function is invoked as theme wrapper, but the rendered form element
//   // may not necessarily have been processed by form_builder().

//   if ($element['#id'] == 'search-block-form'){
//     $output = '';
//     $element += array(
//       '#title_display' => 'before',
//     );

//     // Add element #id for #type 'item'.
//     if (isset($element['#markup']) && !empty($element['#id'])) {
//       $attributes['id'] = $element['#id'];
//     }
//     // If #title is not set, we don't display any label or required marker.
//     if (!isset($element['#title'])) {
//       $element['#title_display'] = 'none';
//     }
//     $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
//     $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

//     switch ($element['#title_display']) {
//       case 'before':
//       case 'invisible':
//         $output .= ' ' . theme('form_element_label', $variables);
//         $output .= ' <fieldset>' . $prefix . $element['#children'] . $suffix . '</fieldset>';
//         break;

//       case 'after':
//         $output .= ' ' . $prefix . $element['#children'] . $suffix;
//         $output .= ' ' . theme('form_element_label', $variables) . "\n";
//         break;

//       case 'none':
//       case 'attribute':
//         // Output no label and no required marker, only the children.
//         $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
//         break;
//     }
//     return $output;
//     }
// }

function mediacommons_field__minimal__field_research_interests__mediacommonsprofile($vars){
  $output = '<aside role="complementary" class="research_interests">';
  $output .= '<header><h1>' . $vars['label'] . '</h1></header><ul class="tags">';
  foreach (element_children($vars['items']) as $key) {
    $output .= '<li><a href="' . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></li>';
  }
  $output .= '</ul></aside>';
  return $output;
}
function mediacommons_field__minimal__field_bio__mediacommonsprofile($vars){
  $output = '<aside role="complementary" class="bio"><header>';
  $output .= '<h1>' . $vars['label'] . '</h1></header><div>';
  $output .=  $vars['items'][0]['#markup'];
  $output .= '</div></aside>';
  return $output;
}
function mediacommons_field__minimal__field_tags($vars){
  //dpm($vars);
  $output = '<div class="tags-block-spoke">' ;
  $output .= '<h2>' . $vars['label'] . '</h2><ul class="tags">';
  foreach (element_children($vars['items']) as $key) {
    $output .= '<li><a href="'  . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></li>';
  }
   $output .= '</ul></div>';
   return $output;
}
//field--field-tags.tpl.php
/* navigation */

function mediacommons_preprocess_menu_tree( &$variables ) {
  $tree = new DOMDocument();
  @$tree->loadHTML( $variables['tree'] );
  $links = $tree->getElementsByTagname( 'li' );
  foreach ( $links as $link ) {
    $parentname = $link->getAttribute( 'data-menu-parent-name' );
    $level = $link->getAttribute( 'data-level' );
    break;
  }
  $variables['menu_parent_name'] = $parentname;
  $variables['level'] = $level;
}

/**
 * Implements hook_menu_tree().
 */
function mediacommons_menu_tree__menu_mcglobalnav( $variables ) {
  $extra = '';
  if ( $variables['level'] == "2" ) {
    $extra = ' aria-hidden="true" style="display:none;"';
  }
  return '<ul role="menubar" class="' . $variables['menu_parent_name'] . ' level' . $variables['level'] . '"' . $extra . '>' . $variables['tree'] . '</ul>';
}

/**
 * Implements hook_menu_link().
 */
function mediacommons_menu_link__menu_mcglobalnav( array $variables ) {
  $element = $variables['element'];
  // https://api.drupal.org/comment/11474#comment-11474
  $name_id = strtolower( strip_tags( $element['#title'] ) );
  // remove colons and anything past colons
  if ( strpos( $name_id, ':' ) ) $name_id = substr( $name_id, 0, strpos( $name_id, ':' ) );
  //Preserve alphanumerics, everything else goes away
  $pattern = '/[^a-z]+/ ';
  $name_id = preg_replace( $pattern, '', $name_id );
  $element['#attributes']['class'][] = 'menu-' . $element['#original_link']['mlid'] . ' '.$name_id;//

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
      $element['#attributes']['aria-haspopup'] = "true";
      if ( $name_id == "myaccount" ) {
        global $user, $base_path;
        if ( user_is_anonymous() ) {
          return;
        }
        $element['#attributes']['class'][] = 'logged-in' ;
        $element['#localized_options']['attributes']['class'][] = "login-link";
        $element['#title'] = $user->name;
      } else {
        $element['#attributes']['class'][] = 'logged-out' ;
        $element['#localized_options']['attributes']['class'][] = "login-link";
        $output = l( $element['#title'], $element['#href'], $element['#localized_options'] );
        $pop = '<ul class="login-area" aria-hidden="true" style="">
        <li role="menuitem">' . render( drupal_get_form( 'user_login' ) ) . '</li></ul>';
        return '<li' . drupal_attributes( $element['#attributes'] ) . '>' . $output . $pop . "</li>\n";
      }
    }
    $element['#localized_options']['html'] = true;
  } else if ( $element['#original_link']['depth'] == '2' ) {
      $element['#localized_options']['attributes']['class'][] = "level2";
    }
  $sub_menu = '';
  if ( $element['#below'] ) {
    $sub_menu = drupal_render( $element['#below'] );
  }
  $output = l( $element['#title'], $element['#href'], $element['#localized_options'] );
  ////
  // Define special variables for use in hook_menu_tree
  $element['#attributes']['data-menu-parent-name'] = $element['#original_link']['menu_name'] ;
  $element['#attributes']['data-level'] = $element['#original_link']['depth'];
  return '<li' . drupal_attributes( $element['#attributes'] ) . '>' . $output . $sub_menu . "</li>\n";
}

