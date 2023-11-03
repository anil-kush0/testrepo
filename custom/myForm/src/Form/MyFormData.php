<?php

namespace Drupal\myForm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class myFormData extends FormBase
{
    /**
     * {@inheritdoc}
     */

    public function getFormId()
    {
        return 'new_form';
    }
    /**
     * {@inheritDoc}
     */

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['name'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('<b> enter name </b>'),
        '#attributes' => ['placeholder'=>'Enter your name']
        );
        $form['age'] = array(
        '#type' => 'number',
        '#title' => '<b>age</b>'
        
        );

        $form['about'] = array(
        '#type' => 'textarea',
        '#title' => '<strong>about you </strong>',
        '#attributes' => ['placeholder'=>'something intresting about you....']
        );
        $form['save'] = array(
        '#type' => 'submit',
        '#value' => 'save entry',
        '#button type' => 'primary'
        );
        return $form;
    }

    /**
     * {@inheritDoc}
     */


     public function submitForm(array &$form, FormStateInterface $form_state)
     {

         $name = $form_state->getValue('name');
         $age = $form_state->getValue('age');
         $about = $form_state->getValue('about');
         $node = \Drupal\node\Entity\Node::create([
             'type' => 'apicontent', 
             'title' => $name,
             'field_name' => $name, 
             'field_age' => $age,
             'field_about' => $about
            ]);
            $node->save();

         $this->messenger()->addMessage($this->t('node created Successfully!!!!!'), 'status',TRUE);
     }
}
