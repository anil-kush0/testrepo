<?php
/**
* @file providing the service that say hello world and hello 'given name'.
*
*/

namespace  Drupal\myForm;

class AnilCustomServices {

 protected $do_something;

//  public function AnilCustomServices() {
//   return ' !!!!!  custom service......working anil .......!!!!!!';

//  }
// public function validateName($name) {
//   dd(preg_match('/^[a-zA-Z]+$/', $name));
//     if(preg_match('/^[a-zA-Z]+$/', $name) === 1){
//       return TRUE;
//     }
//     return FALSE;
//   }

  public function validateAge($age) {
    if (is_numeric($age) && $age >= 18) {
      return TRUE;
    }
    return FALSE;
  }
}