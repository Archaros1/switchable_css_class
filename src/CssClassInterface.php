<?php

namespace Drupal\switchable_css_classes;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a css class entity type.
 */
interface CssClassInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
