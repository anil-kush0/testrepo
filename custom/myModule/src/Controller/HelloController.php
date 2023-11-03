<?php

    namespace Drupal\myModule\Controller;
    use Drupal\Core\Controller\ControllerBase;
    class HelloController extends ControllerBase{
            public function content(){
                return [
                    '#type' => 'markup',
                    '#markup' => '<h3>Welcome aapka swaagat hai hamare is custom module k page par</h3>'
                ];
                
            }
            public function info(){
                
                $data=[
                    'name' => 'anil kumar',
                    'email'=> '123@gmail.com'
                ];
                
                return [
                    '#type' => 'markup',
                    // '#markup' => '<h3>Information pages by anil...........</h3>', //jab items use so there will no any markup instead o this use..items
                    '#theme' => 'information_page', //twig ko add krwaya then remeber twig name me waha - idhar underscore kr diya
                    '#items' => $data
                   
                ];
                
            }
            public function offer($count)
            {
               return ['#type' => 'markup',
               '#markup' => $this->t('You will get %count% discount!!',
               array('%count' => $count)),];
            }
        }


?>