<?php

namespace Drupal\discount_code\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the discount entity.
 *
 * @ContentEntityType(
 *   id = "discount_code",
 *   label = @Translation("Discount code"),
 *   base_table = "discount_code",
 *   entity_keys = {
 *     "id" = "id",
 *     "uid" = "user_id",
 *     "discount" = "discount"
 *   },
 * )
 */
class DiscountCodeEntity extends ContentEntityBase {

  /**
   * Add fields to discount table.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Discount ID'))
      ->setDescription(t('ID'));

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User ID'))
      ->setDescription(t('User ID'))
      ->setSetting('target_type', 'user')
      ->setRevisionable(TRUE)
      ->setSetting('handler', 'default');

    $fields['discount'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Code'))
      ->setDescription(t('User discount code'))
      ->setSettings(['max_length' => 10]);

    return $fields;
  }

}
