<?php

/**
 * @file
 * Contains \Drupal\ajax_login\MyAjaxLogin.
 */

namespace Drupal\ajax_login\MyAjaxLogin;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\AjaxResponse;

use Drupal\Core\Form\FormStateInterface;


class MyAjaxLogin {


    function MyAjaxSubmit (array &$form, FormStateInterface $form_state) {

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
                ('.js-form-item', 'css', [
                    'opacity',
                    $opacity,
                ]));

            $response
                ->addCommand(new InvokeCommand
                ('.js-form-item', 'css', [
                    'opacity',
                    $opacity,
                ]));


        } else {
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
/*  if (user_load_by_name($form_state->getValue('name')) &&
       $form_state->getValue('name') != false) {
       $text = 'User Found';
       $color = 'green';
   } else {
       $text = 'No User Found';
       $color = 'red';
   }

   $response
       ->addCommand(new HtmlCommand('#box', $text));
   $response
       ->addCommand(new InvokeCommand('#box', 'css', array
       ('color', $color)));

$response = new AjaxResponse();

, ({$form_state->getValue('name')})
*/




