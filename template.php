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


function babyzen_theme( &$existing, $type, $theme, $path ) {
  $hooks = zen_theme( $existing, $type, $theme, $path );

  $hooks['user_login'] = array(
    'render element' => 'form',
    'template' => 'templates/user-login',
    'preprocess functions' => array(
      'babyzen_preprocess_user_login'
    ),
  );
  $hooks['user_register_form'] = array(
    'render element' => 'form',
    'template' => 'user-register-form',
    'preprocess functions' => array(
      'babyzen_preprocess_user_register_form'
    ),
  );
  return $hooks;
}

function babyzen_preprocess_html( &$vars ) {
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
function babyzen_preprocess_block( &$variables, $hook ) {
  global $user;
  $block =& $variables['block'];

  if ( $block->module == 'system' && $block->delta == 'user-menu' ) {
    if ( user_is_logged_in() ) {
      //dpm( $variables['content'] );
      //$variables['content'] = check_plain($user->name) . $variables['content'];
    }
  }
}
function babyzen_preprocess_image_style(&$variables) {
    if ($variables['style_name'] == 'profile_page_pic') {
        $variables['attributes']['class'][] = 'u-photo photo';
    }
}

function babyzen_user_menu() {
  $items['user/login'] = array(
    'title' => 'Join',
    'access callback' => 'user_is_anonymous',
    'type' => MENU_DEFAULT_LOCAL_TASK,
  );

  return $items;
}
function babyzen_form_alter( &$form, &$form_state, $form_id ) {
  if ( in_array( $form_id, array( 'user_login', 'user_login_block' ) ) ) {
    $form['name']['#attributes']['placeholder'] = t( 'Username or email address' );
    $form['name']['#description'] = t("You may login with either your assigned username or your e-mail address.");
    $form['pass']['#attributes']['placeholder'] = t( 'Password' );
    $form['pass']['#description'] = t("The password field is case sensitive.");
    $form['actions']['submit']['#value'] = t("Login");
  } else if ( $form_id == 'search_block_form' ) {
      // HTML5 placeholder attribute
      $form['search_block_form']['#attributes']['placeholder'] = t( 'Search...' );
      //$form['search_block_form']['#type'] = 'search';
      //$form['search_block_form'] = str_replace('type="text"', 'type="search"', $form['search_block_form']);
    }

}
//function babyzen_preprocess_user_picture(&$vars) {
  //dpm($vars);
  //$vars['user_picture'] = 'z';
  //}
/**
 * Implement template_preprocess_comment().
 */
function babyzen_preprocess_comment(&$variables) {
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
function babyzen_form_comment_form_alter(&$form, &$form_state) {
  //dpm($form);
  $form['subject']['#size'] = "auto";
} 


/** See: http://api.drupal.org/api/drupal/includes%21theme.inc/function/template_process_page/7 */
function babyzen_preprocess_page( &$vars ) {
  /** Remove logo */
  $vars['logo'] = null;

  if (isset($vars['node'])) {
    // If the node type is "blog_madness" the template suggestion will be "page--blog-madness.tpl.php".
    $vars['theme_hook_suggestions'][] = 'page__'. $vars['node']->type;
    // https://www.drupal.org/node/410908
    if ($vars['node']->type == 'spoke') {
       // unset($vars['sidebar']);
      }
  }
}
function tne_field__minimal__field_full_name__mediacommonsprofile ($vars) {
  return '<h1 class="p-name fn">' . $vars[items][0]['#markup'] . '</h1>';
}
function tne_field__minimal__field_skype__mediacommonsprofile ($vars) {
  return '<li><a class="u-url url skype" href="skype:kfitz" rel="me"><span>' . $vars[items][0]['#markup'] . '</span></a></li>';
}
function tne_field__minimal__field_twitter__mediacommonsprofile ($vars) {
  return '<li><a class="u-url url twitter" href="https://twitter.com/'.  $vars[items][0]['#markup']   . '" rel="me"><span>' . $vars[items][0]['#markup'] . '</span></a></li>';
}
function tne_field__minimal__field_email__mediacommonsprofile ($vars) {
  return '<li><a class="u-email email"  href="mailto:" rel="external me"><span>' . $vars[element]['#object']->field_email[und][0][email] . '</span></a></li>';
}
function tne_field__minimal__field_url__mediacommonsprofile ($vars) {
  return '<li><a class="u-url url www"  href="'.  $vars[items][0]['#href'] . '" rel="external me"><span>' . $vars[items][0]['#title'] . '</span></a></li>';
}
function tne_field__minimal__field_telephone__mediacommonsprofile ($vars) {
  $phone = preg_replace('/\D+/', '', $vars[items][0]['#markup']);
  return '<li><a class="p-tel tel"  href="tel:+1'.   $phone  . '" rel="me"><span>' . $vars[items][0]['#markup'] . '</span></a></li>';
}
function tne_field__minimal__post_date ($vars) {
  return '<time>' . $vars[items][0]['#markup'] . '</time>';
}

