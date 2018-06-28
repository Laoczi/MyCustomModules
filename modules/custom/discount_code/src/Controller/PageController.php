<?php

namespace Drupal\discount_code\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class PageController.
 *
 * @package Drupal\discount\Controller
 */
class PageController extends ControllerBase {

  /**
   * Generate page.
   */
  public function page() {
    $config = \Drupal::config('user_discount_code.settings');
    $token_service = \Drupal::token();
    $message = $token_service->replace($config->get('message'));

    return [
      '#theme' => 'discount_page',
      '#message' => $message,
    ];
  }

}
