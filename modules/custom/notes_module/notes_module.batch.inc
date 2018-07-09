<?php

/**
 * Batch process.
 */
function notes_module_refresh_status_process($data, &$context) {
  $config = \Drupal::config('notes.settings');
  $storage = \Drupal::entityTypeManager()->getStorage('node');

  $config_date = $config->get('date');
  $config_date = strtotime($config_date);
  $config_date =
    Drupal::service('date.formatter')->format($config_date, 'html_date');

  $context['sandbox']['items'] = $data;

  foreach ($context['sandbox']['items'] as $value) {
    $note = $storage->load($value);
    $note_date = $note->created->value;
    $note_date =
      Drupal::service('date.formatter')->format($note_date, 'html_date');

    if ($note_date < $config_date) {
      $node = $storage->load($value);
      $node->note_status->value = 0;
      $node->save();
    }
    else {
      $node = $storage->load($value);
      $node->note_status->value = 1;
      $node->save();
    }
  }

}

/**
 * Generate message when batch was finished.
 */
function notes_module_refresh_status_finished_callback($success, $results, $operations) {

  \Drupal::messenger()->addMessage('Batch was finished');

}

/**
 * Batch process.
 */
function notes_module_reset_status_process($data, &$context) {
  $context['sandbox']['items'] = $data;
  $storage = \Drupal::entityTypeManager()->getStorage('node');

  foreach ($context['sandbox']['items'] as $value) {
    $node = $storage->load($value);
    $node->note_status->value = 0;
    $node->save();

  }
}

/**
 * Generate message when batch was finished.
 */
function notes_module_reset_status_finished_callback($success, $results, $operations) {

  \Drupal::messenger()->addMessage('Batch was finished');

}
