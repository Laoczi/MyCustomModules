<?php

/**
 * @file
 * Contains \Drupal\Internet_reception\Form\FormGen.
 */

namespace Drupal\Internet_reception\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Mail\MailManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Language\LanguageManagerInterface;

class FormGen extends FormBase {

    protected $mailManager;
    protected $languageManager;

    /**
     *Construct
     */
    public function __construct (MailManagerInterface $mail_manager, LanguageManagerInterface $language_manager) {
        $this->mailManager = $mail_manager;
        $this->languageManager = $language_manager;
    }

    /**
     * {@inheritdoc}
     */
    public static function create (ContainerInterface $container) {
        $form = new static(
            $container->get('plugin.manager.mail'),
            $container->get('language_manager')
        );
        $form->setMessenger($container->get('messenger'));
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId () {
        return 'internet_reception';
    }
    /**
     *
     * Build form
     */
    public function buildForm (array $form, FormStateInterface $form_state) {

        $form['name'] = [
            '#type' => 'textfield',
            '#title' => t('Your name:'),
            '#required' => TRUE,
        ];
        $form['email'] = [
            '#type' => 'email',
            '#title' => t('Your email:'),
            '#required' => TRUE,
        ];
        $form['age'] = [
            '#type' => 'textfield',
            '#title' => t('Your age:'),
            '#required' => TRUE,
        ];
        $form['subject'] = [
            '#type' => 'textfield',
            '#title' => t('Subject'),
            '#required' => TRUE,
        ];
        $form['message'] = [
            '#type' => 'textarea',
            '#title' => t('Your message'),
            '#required' => TRUE,
        ];
        $form['captcha'] = [
            '#type' => 'captcha',
            '#captcha_type' => 'captcha/Math',
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('Submit'),
            '#required' => TRUE,
        ];

        return $form;
    }

    /**
     *
     * Validation form
     *
     * {@inheritdoc}
     */
    public function validateForm (array &$form, FormStateInterface $form_state) {

        if (strlen($form_state->getValue('name')) < 2)  {
            $form_state->setErrorByName('name', $this->t('Name is too short.'));
        }

        if (strlen($form_state->getValue('email')) < 5) {
            $form_state->setErrorByName('email', $this->t('Email is too short.'));
        }

        if ($form_state->getValue('age') < 0) {
            $form_state->setErrorByName('age', $this->t('Type right age'));
        }

    }

    /**
     * Submit form
     *
     * {@inheritdoc}
     */
    public function submitForm (array &$form, FormStateInterface $form_state) {
        $form_values = $form_state->getValues();
        $module = 'Internet_reception';
        $key = 'contact_message';
        $to = $form_values['email'];
        $params = $form_values;
        $language_code = $this->languageManager->getDefaultLanguage()->getId();
        $send_now = TRUE;

        $result =
            $this->mailManager->mail($module, $key, $to, $language_code, $params, $send_now);
        if ($result['result'] == TRUE) {
            $this->messenger()->addMessage(t('Your message has been sent.'));
        } else {
            $this->messenger()
                ->addMessage(t('There was a problem sending your message and it was not sent.'), 'error');
        }
    }


}





