<?php

namespace Drupal\dispatch_module\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;

/**
 * Generate the form for contact with administrator.
 */
class DispatchForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dispatch_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['message'] = [
      '#type' => 'textarea',
      '#title' => t('Write your message here'),
      '#required' => TRUE,
      '#description' => '[dispatch:username] to add user name <br>
                         [dispatch:site_email] to add site email.',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $token_service = \Drupal::token();

    $query = \Drupal::database()->select('users_field_data', 'ufd');
    $query->fields('ufd', ['uid', 'name', 'mail']);
    $query->condition('status', 1);
    $result = $query->execute();
    $message = $form_state->getValue('message');

    $queue = \Drupal::queue('email_dispatch');
    $queue->createQueue();

    foreach ($result as $value) {
      $queue->createItem([
        'uid' => $value->uid,
        'name' => $value->name,
        'mail' => $value->mail,
        'message' => $message,
      ]);

    }
  }

}

/**
 *
 * Hello, [dispatch:username] !
 * We have a new vacancy for developers if interesting sand
 * your resume to [dispatch:site_email].
 * Good luck!
 */
