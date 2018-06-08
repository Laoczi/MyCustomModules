<?php

namespace Drupal\ajx\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Submit a form without a page reload.
 */
class AjxForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId () {
        return 'ajx-form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm (array $form, FormStateInterface $form_state) {
        // This container wil be replaced by AJAX.
        $form['container'] = [
            '#type' => 'container',
            '#attributes' => ['id' => 'box_container'],
        ];
        // The box contains some markup that we can change on a submit request.
        $form['container']['box'] = [
            '#type' => 'markup',
            '#markup' => '<h1>Initial markup for box</h1>',
        ];

        $form['name'] = [
            '#type' => 'textfield',
        ];

        $form['submit'] = [
            '#type' => 'submit',
            // The AJAX handler will call our callback, and will replace whatever page
            // element has id box-container.
            '#ajax' => [
                'callback' => '::promptCallback',
                'wrapper' => 'box_container',
            ],
            '#value' => $this->t('Submit'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm (array &$form, FormStateInterface $form_state) {
    }

    /**
     * Callback for submit_driven example.
     *
     * Select the 'box' element, change the markup in it, and return it as a
     * renderable array.
     *
     * @return array
     *   Renderable array (the box element)
     */
    public function promptCallback (array &$form, FormStateInterface $form_state) {

        $element = $form['container'];
        $element['box']['#markup'] =
            "Clicked submit ({$form_state->getValue('name')})";
        return $element;
    }

}
