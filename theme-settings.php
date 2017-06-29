<?php
/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function mediacommons_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL)  {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  unset($form['breadcrumb']);
  
  unset($form['support']);
  
  unset($form['theme_zen_settings']);

  unset($form['theme_settings']);
  
  $form['theme_settings'] = array();
  
  // Create the form using Forms API: http://api.drupal.org/api/7
  $form['theme_settings']['special_body_class'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Special Body Class Name'),
    '#default_value' => theme_get_setting('special_body_class'),
    '#size'          => 25,
    '#maxlength'     => 30,
  );

}
