<?php

namespace Drupal\modal_messenger\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure messenger settings for this site.
 */
class ModalMessengerSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'modal_messenger_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'modal_messenger.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('modal_messenger.settings');

    $form['background'] = [
      '#type' => 'radios',
      '#options' => [
        'white' => $this->t('White'),
        'green' => $this->t('Green'),
        'red' => $this->t('Red'),
      ],
      '#title' => $this->t('Choose background color'),
      '#default_value' => $config->get('background'),
    ];

    $form['width'] = [
      '#type' => 'number',
      '#min' => '100',
      '#max' => '1000',
      '#title' => $this->t('Width'),
      '#default_value' => $config->get('width'),
    ];
    $form['height'] = [
      '#type' => 'number',
      '#min' => '100',
      '#max' => '1000',
      '#title' => $this->t('Height'),
      '#default_value' => $config->get('height'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('modal_messenger.settings')
      ->set('background', $form_state->getValue('background'))
      ->set('width', $form_state->getValue('width'))
      ->set('height', $form_state->getValue('height'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
