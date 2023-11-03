<?php

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class EditEmployee extends FormBase
{
    /**
     * {@inheritdoc}
     */

    public function getFormId()
    {
        return 'edit_employee';
    }
    /**
     * {@inheritDoc}
     */

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $id =\Drupal::routeMatch()->getParameter('id');
        $query =\Drupal::database();
        $data = $query->select('employees', 'e')
            ->fields('e', ['id','name','gender','about'])
            ->condition('e.id', $id, '=')
            ->execute()->fetchAll(\PDO::FETCH_OBJ);
        ;

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
        // '#default_value'=>$data[0]->name,
        '#attributes' => ['placeholder'=>'Enter your name']
        );
        $form['gender'] = array(
        '#type' => 'select',
        '#title' => '<b>gender</b>',
        '#options' => $genderOption,
        '#required' => true,
        // '#default_value'=>$data[0]->gender
        );

        $form['about'] = array(
        '#type' => 'textarea',
        '#title' => '<strong>about employee </strong>',
        '#attributes' => ['placeholder'=>'something intresting about you....'],
        // '#default_value'=>$data[0]['about']
        );
        $form['Update'] = array(
        '#type' => 'submit',
        '#value' => 'Update',
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
        $id =\Drupal::routeMatch()->getParameter('id');
        $postData = $form_state->getValues();

        // echo "<pre>";
        // print_r($postData);
        // echo "</pre>";

        // exit;
        unset($postData['Update'], $postData['form_build_id'], $postData['form_id'], $postData['form_token'], $postData['op']);

        $query= \Drupal::database();
        $query->update('employeesTable')->fields($postData)
            ->condition('id', $id)
            ->execute();

        $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../employeeList');
        // dd($query);
        $response->send();
        $this->messenger()->addMessage($this->t('employee updated Successfully'), 'status', true);
        // $this->messenger()->addMessage($this->t('employee added Successfully'), 'error',TRUE);
        // $this->messenger()->addMessage($this->t('employee added Successfully'), 'warning',TRUE);
        // $this->messenger()->addMessage($this->t('employee added Successfully'), 'information',TRUE); // status se status, error->error , info k -> info, warning se warning...
        
    }
}
