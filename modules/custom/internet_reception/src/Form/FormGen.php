<?php

namespace Drupal\internet_reception\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Mail\MailManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Language\LanguageManagerInterface;

/**
 * Generate the form for contact with administrator.
 */
class FormGen extends FormBase {

  /**
   * The mail manager service.
   *
   * We need this for send the mail.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * The language manager service.
   *
   * We need this for change language if necessary.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * FormGen constructor.
   *
   * @param \Drupal\Core\Mail\MailManagerInterface $mail_manager
   *   For using mailManager.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   For using languageManager.
   */
  public function __construct(MailManagerInterface $mail_manager,
    LanguageManagerInterface $language_manager) {
    $this->mailManager = $mail_manager;
    $this->languageManager = $language_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
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
  public function getFormId() {
    return 'internet_reception';
  }

  /**
   * Generate the form.
   *
   * @param array $form
   *   For add fields to form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   For validation form.
   *
   * @return array
   *   Return fields for build the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

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
      '#type' => 'number',
      '#title' => t('Your age:'),
      '#required' => TRUE,
      '#min' => 0,
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
   * Validation form.
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (strlen($form_state->getValue('name')) < 2) {
      $form_state->setErrorByName('name', $this->t('Name is too short.'));
    }
  }

  /**
   * Submit form.
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_values = $form_state->getValues();
    $module = 'internet_reception';
    $key = 'contact_message';
    $to = $form_values['email'];
    $params = $form_values;
    $language_code = $this->languageManager->getDefaultLanguage()->getId();

    $result =
      $this->mailManager->mail($module, $key, $to, $language_code, $params);
    if ($result['result'] == TRUE) {
      $this->messenger()->addMessage(t('Your message has been sent.'));
    }
    else {
      $this->messenger()
        ->addMessage(t('There was a problem sending your message and it was not sent.'), 'error');
    }
  }

}
