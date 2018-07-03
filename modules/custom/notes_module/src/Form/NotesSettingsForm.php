<?php

namespace Drupal\notes_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure notes settings.
 */
class NotesSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'notes_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'notes.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('notes.settings');

    $form['reset'] = [
      '#type' => 'submit',
      '#value' => 'Reset all notes status',
    ];
    $form['refresh'] = [
      '#type' => 'submit',
      '#value' => 'Refresh all notes status',
    ];

    $form['or'] = [
      '#type' => 'item',
      '#markup' => '<hr><h1> OR </h1>',
    ];

    $form['date'] = [
      '#type' => 'date',
      '#title' => $this->t('Choose actual date'),
      '#default_value' => $config->get('date'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('notes.settings')
      ->set('date', $form_state->getValue('date'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
