<?php

namespace Drupal\dispatch_module\Plugin\QueueWorker;

use Drupal\Core\Mail\MailManager;
use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Processes Tasks for Dispatch module.
 *
 * @QueueWorker(
 *   id = "email_dispatch",
 *   title = @Translation("Email dispatch"),
 *   cron = {"time" = 30}
 * )
 */
class EmailDispatch extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $queue = \Drupal::queue('email_dispatch');

    $token_service = \Drupal::token();
    $mailManager = \Drupal::service('plugin.manager.mail');
    $module = 'dispatch_module';
    $key = 'email_dispatch';
    $to = $data['mail'];
    $params['message'] = $data['message'];

    $langcode = 'en';
    $mailManager->mail($module, $key, $to, $langcode, $params);
  }

}
