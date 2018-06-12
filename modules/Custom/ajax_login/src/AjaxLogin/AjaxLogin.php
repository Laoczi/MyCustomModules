<?php

namespace Drupal\ajax_login\AjaxLogin;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\FormStateInterface;

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
  function AjaxSubmit (array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $opacity = 0;
    $user = $form_state->getValue('name');

    if (user_load_by_name($form_state->getValue('name')) &&
      $form_state->getValue('name') != FALSE) {
      $response
        ->addCommand(new HtmlCommand('#box', 'Hello, ' . $user .
          '! To see the website as a registered user go to this 
                     <a href="http://phpmodule2.test/"> link</a>'));
      $response
        ->addCommand(new InvokeCommand
        ('#box', 'css', [
          'color',
          'black',
        ]));

      $response
        ->addCommand(new InvokeCommand
        ('.js-form-item', 'css', [
          'opacity',
          $opacity,
        ]));

      $response
        ->addCommand(new InvokeCommand
        ('#block-bartik-local-tasks', 'css', [
          'opacity',
          $opacity,
        ]));

      $response
        ->addCommand(new InvokeCommand
        ('#edit-submit', 'css', [
          'opacity',
          $opacity,
        ]));
    }
    else {
      $response
        ->addCommand(new HtmlCommand('#box', 'Incorrect login and/or password'));

      $response
        ->addCommand(new InvokeCommand
        ('#box', 'css', [
          'color',
          'red',
        ]));
    }

    return $response;
  }

}

