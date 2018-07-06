<?php

/**
 * Batch process.
 */
function notes_module_refresh_status_process($data, &$context) {
  $config = \Drupal::config('notes.settings');
  $config_date = $config->get('date');
  $config_date = strtotime($config_date);
  $config_date =
    Drupal::service('date.formatter')->format($config_date, 'html_date');

  $context['sandbox']['items'] = $data;

  foreach ($context['sandbox']['items'] as $value) {
    $query = Drupal::database()->select('node_field_data', 'nfd');
    $query->addField('nfd', 'created');
    $query->condition('nid', $value);
    $note_date = $query->execute()->fetchField();
    $note_date =
      Drupal::service('date.formatter')->format($note_date, 'html_date');

    if ($note_date < $config_date) {
      $query = Drupal::database()->update('node__note_status');
      $query->fields(['note_status_value' => 0]);
      $query->condition('entity_id', $value);
      $query->execute();
    }
    else {
      $query = Drupal::database()->update('node__note_status');
      $query->fields(['note_status_value' => 1]);
      $query->condition('entity_id', $value);
      $query->execute();
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

  foreach ($context['sandbox']['items'] as $value) {

    $query = Drupal::entityQuery('node')->
    $query = Drupal::database()->update('node__note_status');
    $query->fields(['note_status_value' => NULL]);
    $query->condition('entity_id', $value);
    $query->execute();
  }
}

/**
 * Generate message when batch was finished.
 */
function notes_module_reset_status_finished_callback($success, $results, $operations) {

  \Drupal::messenger()->addMessage('Batch was finished');

}
