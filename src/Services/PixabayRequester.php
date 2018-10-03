<?php

namespace Drupal\d8_lille\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PixabayRequester {

  private $httpClient;

  public function __construct(Client $httpClient) {
    $this->httpClient = $httpClient;
  }

  public function getImages($params) {

    $url = 'https://pixabay.com/api/';
    $options = [
      'query' => [
        'key' => '10270854-a866a6ef4ccbf9830aa0ab761',
      ],
    ];
    $options['query'] = array_merge($options['query'], $params);

    $config = \Drupal::config('pixabay.settings');

    if (!empty($config->get('q')) && empty($params)) {
      $options['query']['q'] = $config->get('q');
    }
    if (!empty($config->get('image_type'))) {
      $options['query']['image_type'] = $config->get('image_type');
    }
    if (!empty($config->get('order'))) {
      $options['query']['order'] = $config->get('order');
    }
    if (!empty($config->get('per_page'))) {
      $options['query']['per_page'] = $config->get('per_page');
    }

    try {
      $response = $this->httpClient->request('GET', $url, $options);
      $code = $response->getStatusCode();
      if ($code == 200) {
        $body = $response->getBody()->getContents();
        return json_decode($body)->hits;
      }
    }
    catch (RequestException $e) {
      \Drupal::logger('d8_lille')->error('Pixabay request failed with message %err', ['%err' => $e->getMessage()]);
    }
  }
}
