<?php

namespace Drupal\qed_assignment\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MappingInterfaceForm.
 */
class MappingInterfaceForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'qed_assignment.mappinginterface',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mapping_interface_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('qed_assignment.mappinginterface');
    $form['city_name_map'] = array(
      '#title' => t('City Name Destination'),
      '#type' => 'select',
      '#description' => t('Choose destination field for city name..'),
      '#options' => [
        'name' => 'Title',
        'city_later' => 'City Later',
      ],
      '#default_value' => $config->get('city_name_map'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('qed_assignment.mappinginterface')
      ->set('city_name_map', $form_state->getValue('city_name_map'))
      ->save();
  }

}
