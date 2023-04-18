<?php

namespace Drupal\switchable_css_classes\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\switchable_css_classes\CssClassInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the css class entity class.
 *
 * @ContentEntityType(
 *   id = "css_class",
 *   label = @Translation("CSS Class"),
 *   label_collection = @Translation("CSS Classes"),
 *   label_singular = @Translation("css class"),
 *   label_plural = @Translation("css classes"),
 *   label_count = @PluralTranslation(
 *     singular = "@count css classes",
 *     plural = "@count css classes",
 *   ),
 *   bundle_label = @Translation("CSS Class type"),
 *   handlers = {
 *     "list_builder" = "Drupal\switchable_css_classes\CssClassListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\switchable_css_classes\CssClassAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\switchable_css_classes\Form\CssClassForm",
 *       "edit" = "Drupal\switchable_css_classes\Form\CssClassForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\switchable_css_classes\Routing\CssClassHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "css_class",
 *   data_table = "css_class_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer css class types",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "bundle" = "bundle",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/css-class",
 *     "add-form" = "/css-class/add/{css_class_type}",
 *     "add-page" = "/css-class/add",
 *     "canonical" = "/css-class/{css_class}",
 *     "edit-form" = "/css-class/{css_class}",
 *     "delete-form" = "/css-class/{css_class}/delete",
 *   },
 *   bundle_entity_type = "css_class_type",
 *   field_ui_base_route = "entity.css_class_type.edit_form",
 * )
 */
class CssClass extends ContentEntityBase implements CssClassInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')
      ->setTranslatable(TRUE)
      ->setLabel(t('Label'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['class'] = BaseFieldDefinition::create('string')
      ->setTranslatable(TRUE)
      ->setLabel(t('Classe CSS'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['allowed_types'] = BaseFieldDefinition::create('entity_reference')
      ->setTranslatable(TRUE)
      ->setLabel(t('Types de paragraphe autorisés'))
      ->setSetting('target_type', 'paragraphs_type')
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 15,
      ])
      ->setCardinality(FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED)
      ->setDescription(t('Laissez vide pour tout autoriser.'))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setTranslatable(TRUE)
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(static::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the css class was created.'))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the css class was last edited.'));

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', t('Enabled'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 50,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    return $fields;
  }

}
