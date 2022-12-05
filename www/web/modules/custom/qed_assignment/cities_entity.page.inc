<?php

/**
 * @file
 * Contains cities_entity.page.inc.
 *
 * Page callback for Cities entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Cities entity templates.
 *
 * Default template: cities_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_cities_entity(array &$variables) {
  // Fetch CitiesEntity Entity Object.
  $cities_entity = $variables['elements']['#cities_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
