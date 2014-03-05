<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  STARTERKIT_preprocess_html($variables, $hook);
  STARTERKIT_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_html(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  //$variables['classes_array'] = array_diff($variables['classes_array'], array('class-to-remove'));
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_page(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_node(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // STARTERKIT_preprocess_node_page() or STARTERKIT_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  //if ($variables['block_html_id'] == 'block-system-main') {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('block__no_wrapper'));
  //}
}





// */


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



function babyzen_user_menu() {
  $items['user/login'] = array(
    'title' => 'Join',
    'access callback' => 'user_is_anonymous',
    'type' => MENU_DEFAULT_LOCAL_TASK,
  );

  return $items;
}

function babyzen_user_login_block( $vars ) {
}
function babyzen_preprocess_user_login( &$vars ) {
  // Extract the form buttons, and put them in independent variable.
  //$vars['buttons'] = $vars['form']['actions'];
  //hide($vars['form']['actions']);
}
function babyzen_preprocess_user_register_form( &$vars ) {
  //$vars['intro_text'] = t('This is my super awesome reg form');
}
function babyzen_form_alter( &$form, &$form_state, $form_id ) {
  if ( in_array( $form_id, array( 'user_login', 'user_login_block' ) ) ) {
    $form['name']['#attributes']['placeholder'] = t( 'Username or email address' );
    $form['name']['#description'] = "You may login with either your assigned username or your e-mail address.";
    $form['pass']['#attributes']['placeholder'] = t( 'Password' );
    $form['pass']['#description'] = "The password field is case sensitive.";
    $form['actions']['submit']['#value'] = "Login";
  }
}


/** See: http://api.drupal.org/api/drupal/includes%21theme.inc/function/template_process_page/7 */
function babyzen_preprocess_page( &$vars ) {
  /** Remove logo */
  $vars['logo'] = null;
}

function babyzen_menu_tree__features( $variables ) {

  //return print_r($variables);

  // if ($element['#original_link']['depth'] == '1') {
  //  $element['#attributes']['class'][] = 'rara';
  //}
  return '<ul class="global-sections" role="menubar"> ' . $variables['tree'] . '</ul>';
}
function babyzen_menu_link__features( array $variables ) {
  $element = $variables['element'];
  //return print_r($variables['element']);

  if ( $element['#original_link']['depth'] == '1' ) {
    // This sets the classes for the lists item
    $element['#title'] = '<span>' . $element['#title'] . '</span>';
    $element['#localized_options']['html'] = true;
    // This sets the classes for the link itself
    $element['#localized_options']['attributes']['class'][] = "logolink";
    $element['#localized_options']['attributes']['class'][] = "mc-logo";
  }

  //  l(t('Link text'), 'about-us', array('attributes' => array('class' => array('about-link', 'another-class'))));

  $sub_menu = '';
  if ( $element['#below'] ) {
    $sub_menu = drupal_render( $element['#below'] );
  }
  $output = l( $element['#title'], $element['#href'], $element['#localized_options'] );
  return '<li' . drupal_attributes( $element['#attributes'] ) . '>' . $output . $sub_menu . "</li>\n";
}
function babyzen_menu_tree__user_menu( &$variables ) {
  return '<ul class="utils" role="menubar">' . $variables['tree'] . '</ul>';
}
function babyzen_menu_link__user_menu( array $variables ) {
  global $user, $base_path;
  $element = $variables['element'];
  //return print_r($variables);
  if ( $element['#title'] == 'Login' ) {
    $element['#localized_options']['attributes']['class'][] = "login-link";
    $element['#attributes']['aria-haspopup'] = "true";
    $element['#attributes']['role'] = "menuitem";
    $output = l( $element['#title'], $element['#href'], $element['#localized_options'] );
    $pop = '<ul class="login-area" aria-hidden="true" style="">
        <li role="menuitem">' . render( drupal_get_form( 'user_login' ) ) . '</li></ul>';
    return '<li' . drupal_attributes( $element['#attributes'] ) . '>' . $output . $pop . "</li>\n";
  } else if ( $element['#title'] == 'My account' ) {
      $element['#localized_options']['attributes']['class'][] = "login-link";
      $element['#attributes']['aria-haspopup'] = "true";
      $element['#attributes']['role'] = "menuitem";
      $output =  l( $user->name, $element['#href'], $element['#localized_options'] );
      //$pop = '<ul class="user-pref-area" aria-hidden="true" style=""><li role="menuitem">' . render(drupal_get_form('user_login')) . '</li></ul>';
      $pop2 = '<ul role="menu" aria-hidden="true" class="user-pref-area" style="display: none;"> <li role="menuitem">'  .l(t('Edit my account'), "user/{$GLOBALS['user']->uid}/edit") . '</li>
        <li role="menuitem"> <a href="' . $base_path . 'user/'. $user->uid .'">View my contributions</a> </li>
        <li role="menuitem"> <a href="' . $base_path . 'user/'. $user->uid .'">View my bookmarks</a> </li>
        <li role="menuitem"> <a href="' . $base_path . 'user/logout">Logout</a></li></ul>';
      return '<li' . drupal_attributes( $element['#attributes'] ) . '>' . $output . $pop2 . "</li>\n";
    } else {
      $element['#attributes']['role'] = "menuitem";
      $output = l( $element['#title'], $element['#href'], $element['#localized_options'] );
      return '<li' . drupal_attributes( $element['#attributes'] ) . '>' . $output . "</li>\n";
  }
}