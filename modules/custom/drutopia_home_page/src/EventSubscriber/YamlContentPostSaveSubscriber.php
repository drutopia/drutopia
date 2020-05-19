<?php

namespace Drupal\drutopia_home_page\EventSubscriber;

use Drupal\yaml_content\Event\EntityPostSaveEvent;
use Drupal\yaml_content\Event\YamlContentEvents;
use Drupal\exclude_node_title\ExcludeNodeTitleManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class DefaultContentImportSubscriber.
 *
 * Adds the node page default content to the exclude node title node list.
 */
class YamlContentPostSaveSubscriber implements EventSubscriberInterface {

  /**
   * The exclude node title manager.
   *
   * @var \Drupal\exclude_node_title\ExcludeNodeTitleManager
   */
  protected $excludeNodeTitleManager;

  /**
   * Constructs a new DefaultContentImportSubscriber object.
   *
   * @param \Drupal\exclude_node_title\ExcludeNodeTitleManager $exclude_node_title_manager
   *   The exclude node title manager.
   */
  public function __construct(ExcludeNodeTitleManager $exclude_node_title_manager) {
    $this->excludeNodeTitleManager = $exclude_node_title_manager;
  }

  /**
   * Sets the exclude node title status of the home page default content.
   *
   * @param \Drupal\yaml_content\Event\EntityPostSaveEvent $event
   *   The YAML Content post-save event.
   */
  public function defaultContentExcludeNodeTitle(EntityPostSaveEvent $event) {
    $entity = $event->getEntity();
    $home_page_uuid = 'fa7d176d-ae37-4625-baf4-43cc4fd10fd4';
    if ($entity->uuid() === $home_page_uuid) {
      $this->excludeNodeTitleManager->addNodeToList($entity);
    }
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events[YamlContentEvents::ENTITY_POST_SAVE][] = ['defaultContentExcludeNodeTitle'];
    return $events;
  }

}
