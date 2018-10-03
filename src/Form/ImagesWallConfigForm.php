<?php

namespace Drupal\d8_lille\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * A form for testing form labels and required marks.
 *
 * @internal
 */
class ImagesWallConfigForm extends FormBase {

  protected $config;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'images_wall_config_form';
  }

  public function __construct() {
    $config_factory = \Drupal::configFactory();
    $this->config = $config_factory->getEditable('pixabay.settings');
  }

  /**
   * {@inheritdoc}
   * @see https://api.drupal.org/api/drupal/elements
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['q'] = [
      '#type' => 'textfield',
      '#title' => t('Keyword filter'),
      '#required' => TRUE,
      '#default_value' => $this->config->get('q'),
    ];
    $form['per_page'] = [
      '#type' => 'number',
      '#title' => t('Number of images'),
      '#maxlength' => 2,
      '#required' => TRUE,
      '#default_value' => $this->config->get('per_page'),
    ];
    $form['order'] = [
      '#type' => 'radios',
      '#title' => 'Order',
      '#options' => [
        'first-radio' => 'Popular',
        'second-radio' => 'Latest',
      ],
      '#required' => TRUE,
      '#default_value' => $this->config->get('order'),
    ];
    $form['image_type'] = [
      '#type' => 'select',
      '#title' => 'Image Type',
      '#options' => [
        'photo' => 'Photo',
        'illustration' => 'Illustration',
        'vector' => 'Vector',
      ],
      '#default_value' => $this->config->get('image_type'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save',
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config->set('q', $form_state->getValue('q'));
    $this->config->set('per_page', $form_state->getValue('per_page'));
    $this->config->set('order', $form_state->getValue('order'));
    $this->config->set('image_type', $form_state->getValue('image_type'));
    $this->config->save();
  }

}
