<?php

namespace Drupal\employee\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\core\Database\Database;
use Drupal\core\Database\Query\PagerSelectExtender;

class EmployeeController extends ControllerBase
{
    public function createEmployee()
    {
        $form = \Drupal::formBuilder()->getForm('Drupal\employee\Form\EmployeeForm');
        $renderform = \Drupal::service('renderer')->render($form);

        // return [
        //     '#type'=> 'markup',
        //     '#markup'=>$renderform
        // ];
        return [
            '#theme' => 'employee', //twig file ka naam without extension....
            '#items' => $form,
            '#title' => 'employee form'
        ];
    }

    public function getEmployeeList()
    {
        $limit =3;
        $query = \Drupal::database();
        $result = $query->select('employeesTable', 'e')
            ->fields('e', ['id', 'name', 'gender', 'about'])
            ->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit($limit)
            ->execute()
            // ->fetchAssoc();
            ->fetchAll(\PDO::FETCH_OBJ);

        // dd($result);
        $data = [];
        $header = ['id', 'name', 'gender', 'about', 'Edit', 'Delete'];
        foreach ($result as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->name,
                'gender' => $row->gender,
                'about' => $row->about,
                'edit' => t("<a href ='editEmployee/$row->id'> Edit</a>"),
                'delete' => t("<a href ='deleteEmployee/$row->id'> Delete</a>"),
            ];

            $build['table'] = [
                '#type' => 'table',
                '#header' => $header,
                '#rows' => $data
            ];
            $build['pager'] = [
                '#type' => 'pager',
            ];

        };
        return [
            $build,
            '#title' => 'Employee List'
        ];
    }
}
