<?php

/**
 * @file
 * Enables modules and site configuration for a Drutopia site installation.
 */

use Drupal\contact\Entity\ContactForm;
use Drupal\Core\Installer\InstallerKernel;
use Drupal\Core\Form\FormStateInterface;

include_once('drutopia.install.inc');

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function drutopia_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  $form['#submit'][] = 'drutopia_form_install_configure_submit';
}

/**
 * Submission handler to sync the contact.form.feedback recipient.
 */
function drutopia_form_install_configure_submit($form, FormStateInterface $form_state) {
  $site_mail = $form_state->getValue('site_mail');
  ContactForm::load('feedback')->setRecipients([$site_mail])->trustData()->save();
}

/**
 * Implements hook_modules_installed().
 */
function drutopia_modules_installed($module_names) {
  // Only look for YAML content if the module is available.
  if (\Drupal::moduleHandler()->moduleExists('yaml_content')) {
    drutopia_install_yaml_content($module_names);
  }

}

/**
 * Installs YAML content from a specified set of modules.
 *
 * @param array $module_names
 *   Modules to check for available YAML content.
 */
function drutopia_install_yaml_content($module_names) {
  $logger = \Drupal::logger('drutopia');

  // Prepare the import configuration and service.
  $path = drupal_get_path('profile', 'drutopia');
  /** @var \Drupal\yaml_content\ContentLoader\ContentLoaderInterface $loader */
  $loader = \Drupal::service('yaml_content.content_loader');
  $loader->setContentPath($path);

  // Prepare a list of content files to import.
  $content_files = [];
  foreach ($module_names as $module) {
    // Normally we install default content only at site install time. However,
    // drutopia_home_page is an exception since the module is not functional
    // without its default content.
    if (InstallerKernel::installationAttempted() || $module === 'drutopia_home_page') {
      // Support both 'default' and 'sample' content.
      // @todo: allow choice of whether default and sample content are
      // installed.
      // @see https://gitlab.com/drutopia/drutopia/-/issues/293
      foreach (['default', 'sample'] as $type) {
        $file_name = $module . '-' . $type . '.content.yml';
        if (file_exists($path . '/content/' . $file_name)) {
          $content_files[] = $file_name;
        }
      }
    }

  }

  // Generate the default and sample content.
  $loaded_entities = [];
  foreach ($content_files as $file_name) {
    $loaded = $loader->loadContent($file_name);
    $loaded_entities = array_merge($loaded_entities, $loaded);
  }

  // Create log entries for the loaded entities.
  foreach ($loaded_entities as $entity) {
    $logger->notice("Created default content item '%label' of type '%type_label'", [
      '%label' => $entity->label(),
      '%type_label' => $entity->getEntityType()->getLabel(),
    ]);
  }

}
