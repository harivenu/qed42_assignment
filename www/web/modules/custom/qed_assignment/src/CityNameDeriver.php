<?php

namespace Drupal\qed_assignment;

use Drupal\Component\Plugin\Derivative\DeriverBase;

/**
 * Deriver for the cityname
 */
class CityNameDeriver extends DeriverBase {

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {

    // Get selected value.
    $config = \Drupal::config('qed_assignment.mappinginterface');
    $destination = $config->get('city_name_map');

    $this->derivatives['process'][$destination] = 'src_city';

    if ($destination != 'name') {
      $this->derivatives['process']['name'] = 'src_id';
    }

    return $this->derivatives;
  }

}
