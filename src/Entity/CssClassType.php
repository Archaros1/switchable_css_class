<?php

namespace Drupal\switchable_css_classes\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the CSS Class type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "css_class_type",
 *   label = @Translation("CSS Class type"),
 *   label_collection = @Translation("CSS Class types"),
 *   label_singular = @Translation("css class type"),
 *   label_plural = @Translation("css classes types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count css classes type",
 *     plural = "@count css classes types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\switchable_css_classes\Form\CssClassTypeForm",
 *       "edit" = "Drupal\switchable_css_classes\Form\CssClassTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\switchable_css_classes\CssClassTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer css class types",
 *   bundle_of = "css_class",
 *   config_prefix = "css_class_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/css_class_types/add",
 *     "edit-form" = "/admin/structure/css_class_types/manage/{css_class_type}",
 *     "delete-form" = "/admin/structure/css_class_types/manage/{css_class_type}/delete",
 *     "collection" = "/admin/structure/css_class_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class CssClassType extends ConfigEntityBundleBase {

  /**
   * The machine name of this css class type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the css class type.
   *
   * @var string
   */
  protected $label;

}
