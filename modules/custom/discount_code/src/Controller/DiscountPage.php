<?php

namespace Drupal\discount_code\Controller;

use Drupal\Core\Controller\ControllerBase;

class DiscountPage extends ControllerBase {

  function page() {
    $config = \Drupal::config('userDiscountCode.settings');

    $token_service = \Drupal::token();
    $message = $token_service->replace($config->get('message'));

    return [
      '#theme' => 'discount_page',
      '#message' => $message,
    ];

  }
}