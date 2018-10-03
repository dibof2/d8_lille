<?php

namespace Drupal\d8_lille\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\d8_lille\Services\php;
use Drupal\d8_lille\Services\PixabayRequester;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;

class ImagesWallController extends ControllerBase implements ContainerInjectionInterface {

  private $pixabayRequester;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('d8_lille.pixabay_requester')
    );
  }

  public function __construct(PixabayRequester $pixabayRequester) {
    $this->pixabayRequester = $pixabayRequester;
  }

  /**
   * The images wall controller.
   */
  public function display($keyword) {
    return [
      '#theme' => 'pixabay_wall',
      '#images' => $this->pixabayRequester->getImages(['q' => $keyword]),
      '#attached' => [
        'library' => 'd8_lille/images_wall'
      ],
    ];
  }

  public function on404() {
    return [
      '#markup' => $this->t('@wip.'),
    ];
  }
}
