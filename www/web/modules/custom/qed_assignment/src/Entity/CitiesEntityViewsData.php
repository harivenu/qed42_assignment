<?php

namespace Drupal\qed_assignment\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Cities entity entities.
 */
class CitiesEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
