<?php

namespace Drupal\drutopia\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Powered by Drutopia' block.
 *
 * @Block(
 *   id = "drutopia_powered_by_block",
 *   admin_label = @Translation("Powered by Drutopia")
 * )
 */
class DrutopiaPoweredByBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return ['#markup' => '<span>' . $this->t('Powered by <a href=":poweredby">Drutopia</a>', [':poweredby' => 'https://www.drutopia.org']) . '</span>'];
  }

}
