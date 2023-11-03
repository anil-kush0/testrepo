<?php
namespace Drupal\mymodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class MyConfigNodeForm extends FormBase {

  public function getFormId() {
    return 'myForm.settings';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    // Add fields from your content types as needed.
    // You can conditionally include fields based on the configuration values.
    $config = \Drupal::config('myForm.settings');
    $include_node_type_c1 = $config->get('node_type_c1');
    $include_node_type_c2 = $config->get('node_type_c2');

    // Example fields:
    if ($include_node_type_c1) {
      $form['field_1_node_type_c1'] = [
        // Field definition for NodeType1
      ];
    }

    if ($include_node_type_c2) {
      $form['field_1_node_type_c2'] = [
        // Field definition for NodeType2
      ];
    }

    // Add more fields here.

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Check the configuration values to determine which content types to create.
    $config = \Drupal::config('myForm.settings');
    $include_node_type_c1 = $config->get('node_type_c1');
    $include_node_type_c2 = $config->get('node_type_c2');

    // Create nodes based on the selected content types.
    if ($include_node_type_c1) {
      // Create a NodeType1 node.
      $node = Node::create([
        'type' => 'node_type_c1', // Machine name of NodeType1
        // Set values for NodeType1 fields.
      ]);
      $node->save();
    }

    if ($include_node_type_c2) {
      // Create a NodeType2 node.
      $node = Node::create([
        'type' => 'node_type_c2', // Machine name of NodeType2
        // Set values for NodeType2 fields.
      ]);
      $node->save();
    }

    // Redirect to a confirmation page or display a success message.
  }
}
