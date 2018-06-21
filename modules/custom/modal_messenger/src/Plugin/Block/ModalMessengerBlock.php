<?php

namespace Drupal\modal_messenger\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\MessagesBlockPluginInterface;
use Drupal\Core\Cache\Cache;


/**
 * Provides a block to display the messages.
 *
 * @Block(
 *   id = "modal_messenger_block",
 *   admin_label = @Translation("Messenger")
 * )
 */
class ModalMessengerBlock extends BlockBase implements MessagesBlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'modal_messenger',
    ];
  }

}
