<?php

namespace Drupal\dispatch_module\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

/**
 * Generate the form for contact with administrator.
 */
class DispatchForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dispatch_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'dispatch.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('dispatch.settings');

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => t('Write your message here'),
      '#required' => TRUE,
      '#description' => '[dispatch:username] to add user name <br>
                         [dispatch:site_email] to add site email.',
      '#default_value' => $config->get('message'),
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
    $this->configFactory->getEditable('dispatch.settings')
      ->set('message', $form_state->getValue('message'))
      ->save();

    $queue = \Drupal::queue('users');
    $queue->createQueue();
    $query = \Drupal::entityTypeManager()->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->execute();
    foreach ($query as $id) {
      $queue->createItem([
        'uid' => $id,
      ]);
    }

    $token_service = \Drupal::token();
    $message = $form_state->getValue('message');
    $query = \Drupal::entityTypeManager()->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->sort('uid')
      ->execute();

    $queue = \Drupal::queue('email_dispatch');
    $queue->createQueue();

    foreach ($query as $id) {
      $user = \Drupal::entityTypeManager()->getStorage('user')->load($id);
      $uid = $user->uid->value;
      $name = $user->name->value;
      $mail = $user->mail->value;
      $data['uid'] = $uid;
      $data['name'] = $name;
      $data['mail'] = $mail;
      $data['message'] = $token_service->replace($message);
      $queue->createItem($data);
    }
  }

}
