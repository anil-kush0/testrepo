<?php
namespace Drupal\myForm\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class CustomConfigForm extends ConfigFormBase {

    /**
     * Settings Variable.
     */
    const CONFIGNAME = "myForm.settings";

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "myForm.settings";
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            static::CONFIGNAME,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $data = \Drupal::config('myForm.settings');
        $published = $data->get('checkbox');
        $config = $this->config(static::CONFIGNAME);
        $form['checkbox'] = [
            '#type' => 'checkbox',
            '#title' => 'Publish the node',
            // '#default_value' => $config->get("checkbox"),
        ];
        $form['checkbox']['#default_value'] = $published;
        return Parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $config->set("checkbox", $form_state->getValue('checkbox'));
        $config->save();
        
    }
}
