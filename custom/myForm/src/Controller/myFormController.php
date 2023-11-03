<?php

namespace Drupal\myForm\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;
use Drupal\myForm\AnilCustomServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

class myFormController extends ControllerBase
{
  protected $anilCustomServices;

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('myForm.api_anil_services')
    );
  }

  public function __construct(AnilCustomServices $anilCustomServices) {
    $this->anilCustomServices = $anilCustomServices;
  }

      
 public function showNodes()
{
    $nodes = Node::loadMultiple();
    $displayNodes = [];

    foreach ($nodes as $node) {
      $displayNodes[] = [
        'id' => $node->id(),
        'title' => $node->getTitle(),
        'name' => $node->get('field_name')->value,
        'age' => $node->get('field_age')->value,
        'about' => $node->get('field_about')->value,
      ];
    }
    return new JsonResponse($displayNodes);
  }


  public function nodeGenerate(Request $request){
    //   dd($request);
      $node =json_decode($request->getContent(), TRUE);
    //   dd($node);
    $ct = 0;
    // dd($this->anilCustomServices->validateName($node['name']));
    // if (!$this->anilCustomServices->validateName($node['name'])){
    //     $ct += 1;
    //     $this->messenger()->addError($this->t('Invalid Name hai!'));
    //     dd($ct);
    // }
    if (!$this->anilCustomServices->validateAge($node['age'])){
        $ct += 1;
        $this->messenger()->addError($this->t('Invalid Age'));
    }

    
if($ct == 0){

    $node = Node::create(
      [
        'type' => 'apicontent',
        'title' => $node['title'],
        'field_name' => $node['name'],
        'field_age' => $node['age'],
        'field_about' => $node['about'],
      ]
    );

    $node->enforceIsNew();
    $node->save();

  return new JsonResponse("Your Post is working , Node is created Anil Kumar ji.");
}
else{
    return new JsonResponse('Some problem with validation! Age is not proper it should be greater than 18');
}
}
  
    }
   
    

