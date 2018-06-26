<?php

namespace Drupal\discount_code\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the discount_code entity.
 *
 *
 * @ContentEntityType(
 *   id = "discount_code",
 *   label = @Translation("Discount code"),
 *   base_table = "discount_codes",
 *   entity_keys = {
 *     "id" = "id",
 *     "uid" = "user_id",
 *     "discount" = "discount_code"
 *   },
 * )
 */
class DiscountEntity extends ContentEntityBase {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Discount ID'));

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User ID'))
      ->setSetting('target_type', 'user')
      ->setRevisionable(TRUE)
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE);

    $fields['discount_code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Code'))
      ->setSettings(['max_length' => 10]);

    return $fields;
  }

}
