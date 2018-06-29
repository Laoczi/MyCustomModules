<?php

/**
 * Batch process.
 */
function refresh_notes_status($nids, &$context) {

  \Drupal::messenger()->addMessage('Nichegose!');
  $config = \Drupal::config('notes.settings');
  $lim = 1;
  $counter = 0;

  if (empty($context['sandbox'])) {
    $context['sandbox']['progress'] = 0;
    $context['sandbox']['current_id'] = 0;
    $context['sandbox']['max'] = count($nids);
  }

  if (empty($context['sandbox']['items'])) {
    $context['sandbox']['items'] = $nids;
  }

  foreach ($context['sandbox']['items'] as $item) {
    if ($counter != $lim) {
      $query = \Drupal::database()->update('node__note_status');
      $query->fields(['status' => 1]);
      $query->condition('note_status_value');
      $query->execute();
    }

  }
}

/**
 * Generate message when batch was finished.
 */
function refresh_notes_status_finished_callback($success, $results, $operations) {
  if ($success) {
    $message = \Drupal::translation()
      ->formatPlural(count($results), 'One post processed.', '@count posts processed.');
  }
  else {
    $message = t('Finished with an error.');
  }

  \Drupal::messenger()->addMessage($message);

}
