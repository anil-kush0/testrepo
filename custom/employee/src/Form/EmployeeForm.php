<?php

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class EmployeeForm extends FormBase
{
    /**
     * {@inheritdoc}
     */

    public function getFormId()
    {
        return 'create_employee';
    }
    /**
     * {@inheritDoc}
     */

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $genderOption = [
        // '0' => 'select Gender',
        'male' => 'male',
        'female' => 'female',
        'other' => 'other'

        ];

        $form['name'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('<b>Employee Name</b>'),
        // '#required' => TRUE,
        '#attributes' => ['placeholder'=>'Enter your name']
        );
        $form['gender'] = array(
        '#type' => 'select',
        '#title' => '<b>gender</b>',
        '#options' => $genderOption,
        '#required' => true,
        );

        $form['about'] = array(
        '#type' => 'textarea',
        '#title' => '<strong>about employee </strong>',
        '#attributes' => ['placeholder'=>'something intresting about you....']
        );
        $form['save'] = array(
        '#type' => 'submit',
        '#value' => 'save employee',
        '#button type' => 'primary'
        );
        return $form;
    }
    /**
     * {@inheritDoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $name = $form_state->getValue('name');
        if(trim($name)=='') {
            $form_state->setErrorByName('name', $this->t('name field can not be empty...'));
        }
    }    
    /**
     * {@inheritDoc}
     */


    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $postData = $form_state->getValues();

        // echo "<pre>";
        // print_r($postData);
        // echo "</pre>";

        // exit;
        unset($postData['save'], $postData['form_build_id'], $postData['form_id'], $postData['form_token'], $postData['op']);

        $query= \Drupal::database();
        $query->insert('employeesTable')->fields($postData)->execute(); //insert k baad table ka naam And 
        // dd($query);
        $this->messenger()->addMessage($this->t('employee added Successfully'), 'status', true);
        // $this->messenger()->addMessage($this->t('employee added Successfully'), 'error',TRUE);
        // $this->messenger()->addMessage($this->t('employee added Successfully'), 'warning',TRUE);
        // $this->messenger()->addMessage($this->t('employee added Successfully'), 'information',TRUE); // status se status, error->error , info k -> info, warning se warning...
        
    }
}
