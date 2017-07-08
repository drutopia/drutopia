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

  return $tasks;
}
