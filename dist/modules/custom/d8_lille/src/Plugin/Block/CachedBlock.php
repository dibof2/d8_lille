<?php

namespace Drupal\d8_lille\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Cached' Block as a practice example.
 *
 * @Block(
 *   id = "d8_lille_cached_block",
 *   admin_label = @Translation("Cached block"),
 *   category = @Translation("D8 Lille Practice"),
 * )
 */
class CachedBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#markup' => $this->t('Hello, %user_name ! You are visiting the route %route_name. %nb_url_params parameters found in url.', [
          '%user_name' => $this->getCurrentUserName(),
          '%route_name' => $this->getCurrentRouteName(),
          '%nb_url_params' => $this->getNbUrlParams(),
      ]),
      '#cache' => [
        //   'max-age' => 0,
        'contexts' => [
            'user',
            'route.name',
            'url.query_args'
        ],
      ]
    );
  }

  private function getCurrentUserName() {
    $user = \Drupal::currentUser();
    // kint($user);
    return $user->getDisplayName();
  }

  private function getCurrentRouteName() {
    $route = \Drupal::routeMatch();
    // kint($route);
    return $route->getRouteName();
  }

  private function getNbUrlParams() {
    // $request = \Drupal::request();
    // kint($request);
    return \Drupal::request()->query->count();
  }
}