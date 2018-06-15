<?php

namespace Drupal\ajax_login\AjaxLogin;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 *
 * Change Login form to ajax.
 *
 * */

class AjaxLogin {

  /**
   * @param array $form
   *   For using data from form.
   * @param FormStateInterface $form_state
   *   For validation data from form.
   *
   * @return AjaxResponse
   *   Return AjaxResponse after submit the form.
   */
  public function ajaxSubmit(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $url = Url::fromUserInput('/');
    $link = Link::fromTextAndUrl(t('link'), $url)->toString();
    $user = $form_state->getValue('name');
    $pass = $form_state->getValue('pass');
    $opacity = 0;
    $messenger = \Drupal::messenger();

    if (\Drupal::service('user.auth')->authenticate($user, $pass) !== FALSE) {
      $messenger->deleteAll();
      $message =
        t("Hello, $user! To see the website as a registered user go to this $link ");
      $messenger->addMessage($message);
      $message = [
        '#theme' => 'status_messages',
        '#message_list' => \Drupal::messenger()->all(),
      ];
      $response->addCommand(new HtmlCommand('#box', $message));
      $response
        ->addCommand(new InvokeCommand
        ('#login_form_hidden', 'css', [
          'opacity',
          $opacity,
        ]));
    }
    else {
      $messenger->deleteAll();
      $message = t('Incorrect login and/or password');
      $messenger->addError($message);
      $message = [
        '#theme' => 'status_messages',
        '#message_list' => \Drupal::messenger()->all(),
      ];
      $response->addCommand(new HtmlCommand('#box', $message));
    }

    return $response;
  }

}
