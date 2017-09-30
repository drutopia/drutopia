<?php

namespace Drupal\drutopia_home_page\EventSubscriber;

use Drupal\default_content\Event\DefaultContentEvents;
use Drupal\default_content\Event\ImportEvent;
use Drupal\exclude_node_title\ExcludeNodeTitleManager;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class DefaultContentImportSubscriber.
 *
 * Adds the node page default content to the exclude node title node list.
 */
class DefaultContentImportSubscriber implements EventSubscriberInterface {

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
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   The configuration event.
   * @param string $name
   *   The event name.
   */
  public function defaultContentExcludeNodeTitle(ImportEvent $event, $name) {
    $module = $event->getModule();
    if ($module === 'drutopia_home_page') {
      $entities = $event->getImportedEntities();
      $home_page_uuid = 'fa7d176d-ae37-4625-baf4-43cc4fd10fd4';
      if (isset($entities[$home_page_uuid])) {
        $this->excludeNodeTitleManager->addNodeToList($entities[$home_page_uuid]);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events[DefaultContentEvents::IMPORT][] = ['defaultContentExcludeNodeTitle'];
    return $events;
  }

}
