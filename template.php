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

const MEDIACOMMONS_DOMAIN_PLACEHOLDER = 'http://[MEDIACOMMONS_DOMAIN]/';

/**
 * Implementation of hook_theme().
 * https://api.drupal.org/api/drupal/modules%21system%21system.api.php/function/hook_theme/7
 */
function mediacommons_theme( &$existing, $type, $theme, $path ) {

  $hooks = zen_theme( $existing, $type, $theme, $path );

  $hooks['user_login'] = array(
    'render element' => 'form',
    'template' => 'templates/user-login',
  );
  
  $hooks['html__pjax'] = array(
    'render element' => 'content',
    'base hook' => 'page',
    'template' => 'templates/html.pjax',
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
function mediacommons_comment_post_forbidden($variables) {
  $node = $variables['node'];
  global $user;

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
function mediacommons_is_pjax() {
  $is_pjax = &drupal_static('is_pjax');
  if (!isset($is_pjax) && function_exists('getallheaders')) {
    $headers = getallheaders();
    if (isset($headers['X-Pjax']) || isset($headers['X-PJAX'])) {
      drupal_add_http_header('uri', request_uri());
      $is_pjax = TRUE;
    }
    else {
      $params = drupal_get_query_parameters();
      if (isset($params['pjax'])) {
        drupal_add_http_header('uri', base_path() . request_uri());
        $is_pjax = TRUE;
      }
      else {
        $is_pjax = FALSE;
      }
    }
  }
  return $is_pjax;
}

function mediacommons_preprocess_html( &$vars ) {
  // An anonymous user has a user id of zero.
  $specialBodyClass   = theme_get_setting( 'special_body_class' );
  if (mediacommons_is_pjax()) {
    $vars['theme_hook_suggestions'][] = 'html__pjax';
  }
  if ( !empty( $specialBodyClass ) ) {
    $vars['classes_array'][] = $specialBodyClass;
  }
  if ( ( $key = array_search( 'no-sidebars', $vars['classes_array'] ) ) !== false ) {
    unset( $vars['classes_array'][$key] );
  }
  
}



function mediacommons_preprocess_image_style( &$variables ) {
  if ( $variables['style_name'] == 'profile_page_pic' ) {
    $variables['attributes']['class'][] = 'u-photo photo';
  } else if ( $variables['style_name'] == 'profile_pic_small' ) {
      $variables['attributes']['class'][] = 'u-photo photo u-photo-small';
    }
}

function mediacommons_user_menu() {
  $items['user/login'] = array(
    'title' => 'Join',
    'access callback' => 'user_is_anonymous',
    'type' => MENU_DEFAULT_LOCAL_TASK,
  );
}
function mediacommons_form_alter( &$form, &$form_state, $form_id ) {
  //dpm($form_id);
  if ( in_array( $form_id, array( 'user_login', 'user_login_block' ) ) ) {
    $form['name']['#attributes']['placeholder'] = t( 'Username or email address' );
    $form['name']['#description'] = t( "You may login with either your assigned username or your e-mail address." );
    $form['name']['#size'] = 28;

    $form['pass']['#attributes']['placeholder'] = t( 'Password' );
    $form['pass']['#description'] = t( "The password field is case sensitive." );
    $form['pass']['#size'] = 28;
    $form['actions']['submit']['#value'] = t( "Login" );
  } else if ( $form_id == 'search_block_form' ) {
      // HTML5 placeholder attribute
      $form['search_block_form']['#attributes']['placeholder'] = t( 'Search...' );
      //$form['search_block_form']['#type'] = 'search';

      //$form['search_block_form'] = str_replace('type="text"', 'type="search"', $form['search_block_form']);
      //dpm($form);
      $form['#prefix'] = '';
      $form['#suffix'] = '';
  } else if ( $form_id == 'comment_node_spoke_form' ) {
     // dpm($form);
      $form['subject']['#size'] = "auto";
  }

}

/** See: http://api.drupal.org/api/drupal/includes%21theme.inc/function/template_process_page/7 */
function mediacommons_preprocess_page( &$vars ) {
  $special_body_class = theme_get_setting( 'special_body_class' );
  if (mediacommons_is_pjax()) {
    $vars['theme_hook_suggestions'][] = 'page__pjax';
  }  
  if ( isset( $vars['node'] ) ) {
    // If the node type is "blog_madness" the template suggestion will be "page--blog-madness.tpl.php".
    $vars['theme_hook_suggestions'][] = 'page__'. $vars['node']->type;
    // https://www.drupal.org/node/410908
    if ( $vars['node']->type == 'spoke' ) {
      // unset($vars['sidebar']);
    }
  }

  if ( isset( $vars['page']['content']['system_main']['no_content'] ) ) {
    unset( $vars['page']['content']['system_main']['no_content'] );
  }


  if ( arg( 0 ) == 'taxonomy' && arg( 1 ) == 'term' && is_numeric( arg( 2 ) ) ) {
    $term = taxonomy_term_load( arg( 2 ) );
    $vars['theme_hook_suggestions'][] = 'page__vocabulary__' . $term->vocabulary_machine_name;
  }
  
  if ($special_body_class == 'mc' ) { 
    if (in_array("page__front", $vars['theme_hook_suggestions'])) {
        $vars['theme_hook_suggestions'][] = 'page__front__mc';
    }
  } 
  if ($special_body_class == 'imr' ) { 
    if (in_array("page__front", $vars['theme_hook_suggestions'])) {
        $vars['theme_hook_suggestions'][] = 'page__front__imr';
    }
  }
  if ($special_body_class == 'int' ) { 
    if (in_array("page__spoke", $vars['theme_hook_suggestions'])) {
        $vars['theme_hook_suggestions'][] = 'page__spoke__int';
    }
  }
}
function mediacommons_preprocess_node(&$vars) {
// give project names as classes to the items on the umbrella site front page
  if ($vars['type'] == 'front_page_post') {
    $vars['classes_array'][] =  'node-' . $vars['field_project'][0]['value'];
  }
  if (mediacommons_is_pjax()) {
    $vars['theme_hook_suggestions'][] = 'node__pjax';
  }  
}
function mediacommons_preprocess_username(&$variables) {

  $variables['name'] =  check_plain( $variables['name_raw'] );


  $account = $variables['account'];

  $variables['extra'] = '';
  if (empty($account->uid)) {
    $variables['uid'] = 0;
    if (theme_get_setting('toggle_comment_user_verification')) {
      $variables['extra'] = ' (' . t('not verified') . ')';
    }
  }
  else {
    $variables['uid'] = (int) $account->uid;
  }


  $variables['profile_access'] = user_access('access user profiles');
  $variables['link_attributes'] = array();
  // Populate link path and attributes if appropriate.
  if ($variables['uid'] && $variables['profile_access']) {
    // We are linking to a local user.
    $variables['link_attributes'] = array('title' => t('User profile: ' . $variables['name']));
    $variables['link_path'] = 'user/' . $variables['uid'];
  }
  elseif (!empty($account->homepage)) {
    // Like the 'class' attribute, the 'rel' attribute can hold a
    // space-separated set of values, so initialize it as an array to make it
    // easier for other preprocess functions to append to it.
    $variables['link_attributes'] = array('rel' => array('nofollow'));
    $variables['link_path'] = $account->homepage;
    $variables['homepage'] = $account->homepage;
  }
  // We do not want the l() function to check_plain() a second time.
  $variables['link_options']['html'] = TRUE;
  // Set a default class.
  $variables['attributes_array'] = array('class' => array('username'));
}
function mediacommons_preprocess_comment(&$variables) {
  $comment = $variables['elements']['#comment'];
  $node = $variables['elements']['#node'];
  $variables['comment'] = $comment;
  $variables['node'] = $node;
  $variables['author'] =  theme('username', array('account' => $comment));
  $user = user_load($comment->uid);
  // Get Organization of the commenter, and send that variable on to the template
  $orgA = field_get_items('user', $user, 'field_organization');
  if ($orgA) {$tid = $orgA[0]['tid']; 
    $term = taxonomy_term_load($tid); // load term object
    $term_uri = taxonomy_term_uri($term); // get array with path
    $term_title =  taxonomy_term_title($term);
    $term_path = $term_uri['path'];
    $string = "Organization: " . $term_title;
    //$term_attributes = array('title' => $string);

    $term_attributes = array('attributes'=>array('title'=>$string));


    $link = l($term_title,$term_path, $term_attributes );
    $variables['organization'] = $link;
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

/**
 * Begin User Profiles
 */
function mediacommons_preprocess_usernamex( &$vars ) {
  //putting back what drupal core messed with (truncated to 15 characters)
  $vars['name'] = "bob " . check_plain( $vars['name_raw'] );
}

function mediacommons_field__minimal__ds_user_picture( $vars ) {
  // Retrieve the user picture string and regex the link away
  if ( isset( $vars['items'][0]['#markup'] ) ) {
    $string = $vars['items'][0]['#markup'];
    $string2 = preg_replace( '#<a.*?>(.*?)</a>#i', '\1', $string ) ;
    return $string2;
  }
}
function mediacommons_field__field_profile_name( $vars ) {
  if ( isset( $vars['items'] ) ) {
    return '<h1 class="p-name fn">' . $vars['items'][0]['#markup'] . '</h1>';
  }
}
function mediacommons_field__field_body__spoke( $vars ) {
  $str = '<section class="body-text">';
  $specialBodyClass   = theme_get_setting( 'special_body_class' ) ? theme_get_setting( 'special_body_class' ) : "" ;
  if ( isset( $vars['items'] ) && ( $specialBodyClass == "imr" || $specialBodyClass == "int" ) ) {
  $str .= "<h2 class='curatorsnote'>Curator's Note</h2><div>" . $vars['items'][0]['#markup'] . '</div>';
  } else {
     $str .= $vars['items'][0]['#markup'];
  }
  $str .= '</section>';
  return $str;
}

function mediacommons_field__field_skype( $vars ) {
  return '<li><a class="u-url url skype" href="skype:'. $vars['items'][0]['#markup'] . '" rel="me"><span>' . $vars['items'][0]['#markup'] . '</span></a></li>';
}

function mediacommons_field__field_aim( $vars ) {
  return '<li><span class="p-aim">' . $vars['items'][0]['#markup'] . '</span></li>';
}
function mediacommons_field__field_twitter( $vars ) {
  return '<li><a class="u-url url twitter" href="https://twitter.com/'.  $vars['items'][0]['#markup']   . '" rel="me"><span>' . $vars['items'][0]['#markup'] . '</span></a></li>';
}
function mediacommons_field__field_email( $vars ) {
  //TODO - validate email address
  return '<li><a class="u-email email" rel="external me"  href="mailto:' . $vars['element']['#items'][0]['email'] . '"><span>' . $vars['element']['#items'][0]['email'] . '</span></a></li>';
}
function mediacommons_field__field_url( $vars ) {
  return '<li><a class="u-url url www"  href="'.  $vars['items'][0]['#element']['url'] . '" rel="external me"><span>' . $vars['items'][0]['#element']['title'] . '</span></a></li>';
}
function mediacommons_field__field_phone( $vars ) {
  $phone = preg_replace( '/\D+/', '', $vars['items'][0]['#title'] );
  return '<li><a class="p-tel tel"  href="tel:+1'.   $phone  . '" rel="me"><span>' . $vars['items'][0]['#title'] . '</span></a></li>';
}
function mediacommons_field__post_date( $vars ) {
  return '<time class="post-date">' . $vars['items'][0]['#markup'] . '</time>';
}
//function mediacommons_views_view_field__created($vars) {
//return '<time>' . $vars['items'][0]['#markup'] . '</time>';
//}
function mediacommons_field__field_title( $vars ) {
  return '<span class="p-job-title title">' . $vars['items'][0]['#markup'] . '</span>';
}


function mediacommons_field__field_taxonomy__spoke( $vars ) {
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


function mediacommons_field__field_taxonomy__user( $vars ) {
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

function mediacommons_field__name__user( $vars ) {
  $output = '<div class="p-name name fn">';
  $output .= $vars['items'][0]['#markup'];
  $output .= '</div>';
  return $output;
}


function mediacommons_field__field_bio__user( $vars ) {
  $output = '<aside role="complementary" class="bio"><header>';
  $output .= '<h1>' . $vars['label'] . '</h1></header><div>';
  $output .=  $vars['items'][0]['#markup'];
  $output .= '</div></aside>';
  return $output;
}
function mediacommons_field__field_plan__user( $vars ) {
  $output = '<aside role="complementary" class="plan"><header>';
  $output .= '<h1>' . $vars['label'] . '</h1></header><div>';
  $output .=  $vars['items'][0]['#markup'];
  $output .= '</div></aside>';
  return $output;
}


function mediacommons_field__field_tags( $vars ) {
  //dpm($vars);
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

function mediacommons_field__minimal__field_reviewer__review( $vars ) {
 // dpm($vars);
  if ($vars['element']['#view_mode'] == 'teaser'){
    $output ='';
    $output .= '<div class="peoplelist">' ;
    if ( isset( $vars['items'][0]['#title'] ) ) {
      $output .= $vars['label'] . ' ';
      foreach ( element_children( $vars['items'] ) as $key ) {
        $output .= '<span>' . drupal_render( $vars['items'][$key] ) . '</span> ';
      }
    }
    $output .= '</div>';
  } else {
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


function mediacommons_field__field_contributors__spoke( $vars ) {
  //ini_set('memory_limit', '1024M');
  //dpm($vars);
  //  Used for spoke teasers and spoke teaser simplest 
  $output ='';
  $output .= '<div class="peoplelist">' ;
  if ( isset( $vars['items'][0]['#title'] ) ) {
    $output .= $vars['label'] . ' ';
    foreach ( element_children( $vars['items'] ) as $key ) {
    $output .= '<span class="h-card">' . drupal_render( $vars['items'][$key] ) . '</span> ';
    }
  }
  $output .= '</div>';
  return $output;
}
function mediacommons_field__minimal__field_spokes__hub( $vars ) {
  //  Used for homepage for In Media Res
  $special_body_class = theme_get_setting( 'special_body_class' );
 
  if ($special_body_class == 'imr' && (drupal_is_front_page())) { 

    $ArrP = $vars['element']['#object']-> {'field_period'};
    $d1 = format_date( $ArrP['und']['0']['value'], 'custom','F j, Y');
    $d2 = format_date( $ArrP['und']['0']['value2'], 'custom','F j, Y');
    //dpm($vars['element']);
    //dpm( $ArrP);

    $output ='';
    $output .= '<time datetime="' . format_date( $ArrP['und']['0']['value'], 'custom','Y-m-d') . '" class="date-display-range">'. $d1 . ' to ' . $d2 . '</time>' ;
    if ( isset( $vars['items'][0] ) ) {
      $output .= '<div class="spokes">' ;
      foreach ( element_children( $vars['items'] ) as $key ) {
        $output .= drupal_render( $vars['items'][$key] ) ;
      }
      $output .= '</div>' ;
    }
    return $output;
  }
}

function mediacommons_field__field_curators_editors( $vars ) {
  //dpm($vars);
  $output = '<div class="peoplelist">' ;
  $output .= '<div class="field-label">' . $vars['label'] . '</div><ul >';
  foreach ( element_children( $vars['items'] ) as $key ) {
    $output .= '<li><a href="'  . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></li>';
  }
  $output .= '</ul></div>';
  return $output;
}
function mediacommons_field__field_co_editor( $vars ) {
  //dpm($vars);
  $output = '<div class="peoplelist">' ;
  $output .= '<div class="field-label">' . $vars['label'] . '</div><ul >';
  foreach ( element_children( $vars['items'] ) as $key ) {
    $output .= '<li><a href="'  . $GLOBALS['base_path'] . $vars['items'][$key]['#href'] . '">';
    $output .= $vars['items'][$key]['#title'];
    $output .= '</a></li>';
  }
  $output .= '</ul></div>';
  return $output;
}
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
  // here is where you can affect the <ul> elements
  if ( $variables['level'] =="2" ) {
    return '<ul aria-hidden="true">' . $variables['tree'] . '</ul>';
  } else {
    return '<ul role="menubar" >' . $variables['tree'] . '</ul>';
  }
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
  ////
  // Define special variables for use in hook_menu_tree
  //$element['#attributes']['data-menu-parent-name'] = $element['#original_link']['menu_name'];
  $element['#attributes']['data-level'] = $element['#original_link']['depth'];
  return '<li' . drupal_attributes( $element['#attributes'] ) . '>' . $output . $sub_menu . "</li>\n";
}

function get_url_for_mediacommons_site( $placeholder_url) {
  $relative_path = str_replace( MEDIACOMMONS_DOMAIN_PLACEHOLDER, '', $placeholder_url );

  // NOTE: gethostname() does not work for local /etc/hosts/ aliases.
  $hostname = $_SERVER['SERVER_NAME'];

  // Don't just do `$_SERVER['HTTPS'] ? 'https' : 'http';`.  This will throw an
  // error "Notice: Undefined index: HTTPS" which is not fatal but is printed on
  // on the page.
  if ( array_key_exists( 'HTTPS', $_SERVER ) ) {
    // It's unclear from http://php.net/manual/en/reserved.variables.server.php
    // whether the existence of the key is enough.  Test if it's "non-empty".
    $protocol = empty( $_SERVER['HTTPS'] ) ? 'https' : 'http';
  } else {
    $protocol = 'http';
  }

  $port = $_SERVER['SERVER_PORT'] === '80' ? '' : ':' . $_SERVER['SERVER_PORT'];

  return "${protocol}://${hostname}${port}/" . "${relative_path}";
}
