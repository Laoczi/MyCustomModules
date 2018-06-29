<?php

namespace Drupal\discount_code\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DiscountCodeSettingsForm.
 *
 * @package Drupal\discount\Form
 */
class DiscountCodeSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['user_discount_code.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_discount_code';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#description' => '[discount:username] to show user name <br>
                         [discount:discount-code] to show code.',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::configFactory()->getEditable('user_discount_code.settings')
      ->set('message', $form_state->getValue('message'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
