<?php

namespace Drupal\d8_lille\EventSubscriber;


use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * A subscriber invalidating cache tags when color config objects are saved.
 */
class RedirectSubscriber implements EventSubscriberInterface {

  /**
   * Invalidate cache tags when a color theme config object changes.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   The Event to process.
   */
  public function redirect(GetResponseEvent $event) {
    if (\Drupal::service('path.matcher')->isFrontPage()) {
      $redirectUrl = Url::fromRoute('d8_lille.images_wall')->toString();
      $redirect = new RedirectResponse($redirectUrl);
      $event->setResponse($redirect);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {

    $events[KernelEvents::REQUEST][] = ['redirect'];
    return $events;
  }

}
