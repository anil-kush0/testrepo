<?php
namespace Drupal\mymodule\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class NodeTypeForm extends ConfigFormBase {

  public function getFormId() {
    return 'myForm.settings';
  }

  protected function getEditableConfigNames() {
    return ['myForm.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('myForm.settings');
    
    $form['node_type_c1'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable NodeType1'),
    //   '#default_value' => $config->get('node_type_c1'),
    ];

    $form['node_type_c2'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable NodeType2'),
    //   '#default_value' => $config->get('node_type_c2'),
    ];

    return Parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('myForm.settings');
    $config
      ->set('node_type_c1', $form_state->getValue('node_type_c1'))
      ->set('node_type_c2', $form_state->getValue('node_type_c2'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
