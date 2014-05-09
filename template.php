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
/** See: http://api.drupal.org/api/drupal/includes%21theme.inc/function/template_process_page/7 */
function babyzen_preprocess_page( &$vars ) {
  /** Remove logo */
  $vars['logo'] = null;

  if (isset($vars['node'])) {
    // If the node type is "blog_madness" the template suggestion will be "page--blog-madness.tpl.php".
    $vars['theme_hook_suggestions'][] = 'page__'. $vars['node']->type;
  }
}