<?php

/**
 * @file
 * Install-related functionality for Drutopia.
 */

/**
 * Implements hook_install_tasks().
 */
function drutopia_install_tasks($install_state) {
  $tasks = [];

  if (\Drupal::moduleHandler()->moduleExists('subprofiles')) {
    // Add Subprofiles tasks.
    $tasks = $tasks + subprofiles_get_install_tasks($install_state);
  }

  // Omit display_name so this task won't display.
  $tasks['drutopia_install_cleanup'] = [];

  return $tasks;
}

/**
 * Installation task; install optional configuration.
 *
 * @param $install_state
 *   An array of information about the current installation state.
 */
function drutopia_install_cleanup(&$install_state) {
  \Drupal::service('config.installer')->installOptionalConfig();
  // No return value so the installer will proceed to the final Drupal
  // installation tasks uninterrupted.
}
